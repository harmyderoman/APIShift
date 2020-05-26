<?php
/**
 * APIShift Engine v1.0.0
 * 
 * Copyright 2020-present Sapir Shemer, DevShift (devshift.biz)
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *  http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * 
 * @author Sapir Shemer
 */

 namespace APIShift\Core;

 /**
  * Manages cache data on your command, sir!
  */
 class CacheManager {
    /**
     * Indicates use of the APCU cache type
     */
    const APCU = 0;

    /**
     * Indicates use of the Memcached cache type
     */
    const MEMCACHED = 1;

    /**
     * Indicates use of the Redis cache type
     */
    const REDIS = 2;

    /**
     * Holds the connection object to call the cache system
     */
    private static $cache_connection = null;

    /**
     * Initializes the cache system and validates accessibility
     */
    private static function initialize() {
        switch(Configurations::CACHE_TYPE) {
            case self::APCU:
                if(!extension_loaded("apcu")) Status::message(Status::ERROR, "Please install/enable APCu or configure to use another system (Redis/Memcached)");
                break;
            case self::MEMCACHED:
                if(!extension_loaded("memcached")) Status::message(Status::ERROR, "Please install/enable Memcached or configure to use another system (APCu/Redis)");
                self::$cache_connection = new \Memcached('_');
                $result = self::$cache_connection->addServer(Configurations::CACHE_HOST, Configurations::CACHE_PORT);
                if(!$result) Status::message("Memcached: Couldn't start connection with cache host, please check host name/port");
            break;
            case self::REDIS:
                if(!extension_loaded("redis")) Status::message(Status::ERROR, "Please install/enable Redis or configure to use another system (APCu/Memcached)");
                self::$cache_connection = new \Redis();
                $result = self::$cache_connection->connect(Configurations::CACHE_HOST, Configurations::CACHE_PORT);
                if(!$result) Status::message("Redis: Couldn't start connection with cache host, please check host name/port");
                $result = self::$cache_connection->auth(Configurations::CACHE_PASS);
                if(!$result) Status::message("Redis: Couldn't authenticate credentials with cache system");
            break;
            default:
                Status::message(Status::ERROR, "Unrecognized cache system, please check your configurations");
        }
    }

     /**
      * Load default cache data

      * @param bool $refresh Set true to refresh the cache data
      */
    public static function loadDefaults(bool $refresh = false) {
        // Initialize cache system
        self::initialize();

        // Load frequently used data by the system to cache
        self::getTable('session_states', $refresh);
        self::getTable('statuses', $refresh);
        self::getTable('data_source_types', $refresh);
        self::getTable('data_entry_types', $refresh);
        self::getTable('connection_types', $refresh);
        self::getTable('connection_node_types', $refresh);
        self::getTable('request_authorization', $refresh);
    }

    /**
     * Check if a given key exists
     * @param string $key Key name to check
     * @return bool TRUE in case exists, FALSE otherwise
     */
    public static function exists($key) {
        switch(Configurations::CACHE_TYPE) {
            case self::APCU: return apcu_exists($key) !== false;
            case self::MEMCACHED:
                return self::$cache_connection->get($key) !== false;
                break;
            case self::REDIS:
                return self::$cache_connection->exists($key) != 0;
                break;
            default:
                Status::message(Status::ERROR, "Unrecognized cache system, please check your configurations");
        }
    }

    
    /**
     * Get value of a given key
     * 
     * @param string $key Key name to check
     * 
     * @return string|array|bool Value in case exists, FALSE otherwise
     */
    public static function get($key) {
        switch(Configurations::CACHE_TYPE) {
            case self::APCU: return apcu_fetch($key);
            case self::MEMCACHED:
                return self::$cache_connection->get($key);
                break;
            case self::REDIS:
                $value = self::$cache_connection->get($key);
                if(strpos($value, '{') !== false) $value = json_decode($value);
                return $value;
                break;
            default:
                Status::message(Status::ERROR, "Unrecognized cache system, please check your configurations");
        }
    }

    /**
     * Set variable in cache system
     * 
     * @param string $key Key name to assign to the data
     * @param mixed $value Value to store upon key
     * @param int $ttl Time to live in cache
     * 
     * @return void
     */
    public static function set($key, $value, $ttl = 0) {
        switch(Configurations::CACHE_TYPE) {
            case self::APCU:
                apcu_store($key, $value, $ttl);
                break;
            case self::MEMCACHED:
                self::$cache_connection->set($key, $value, $ttl);
                break;
            case self::REDIS:
                if(gettype($value) != 'array') self::$cache_connection->set($key, $value, ['EX' => $ttl]);
                else self::$cache_connection->set($key, json_encode($value), ['EX' => $ttl]);
                break;
            default:
                Status::message(Status::ERROR, "Unrecognized cache system, please check your configurations");
        }
    }

    /**
     * Loads row from table into cache of the table if not present and then return it
     * 
     * @param string $table_name Name of table
     * @param int $id ID of the item to retrieve
     * @param int $ttl Time to live in cache
     */
    public static function getFromTable($table_name, $id, $ttl = 0) {
        // Get from cache if exists
        $existing = self::get($table_name);
        if($existing && isset($existing[$id])) return $existing[$id];

        // If not than load from DB
        $result = [];
        if(DatabaseManager::fetchInto("main", $result, "SELECT * FROM " . $table_name . " WHERE id = :gid", [ 'gid' => $id ], 'id') === false)
            Status::message(Status::ERROR, "Couldn't retrieve element from " . $table_name);
        
        // And add to cache
        if($existing) {
            foreach($result as $key => $val) $existing[$key] = $val;
            self::set($table_name, $existing);
        }
        else self::set($table_name, $result);
        
        return $result[$id];
    }

    /**
     * Loads a table into cache
     * 
     * @param string $table_name Name of table
     * @param int $ttl Time to live in cache
     */
    public static function getTable($table_name, $refresh = false, $ttl = 0) {
        // Check if load needed or forcefully requested by refresh
        if(self::exists($table_name) && !$refresh) return;

        // Load to cache
        $data_to_load = [];
        if(DatabaseManager::fetchInto("main", $data_to_load, "SELECT * FROM {$table_name}", [], 'id') === false)
                Status::message(Status::ERROR, "Couldn't retrieve `{$table_name}` from DB");
        self::set($table_name, $data_to_load, $ttl);
    }
}
?>