<?php
namespace APIShift\Models\Conditory;
use APIShift\Core;

/**
 * Model for conditory
 */
class Desserts {

    /**
    * Returns to the user all the available desserts
    */
    public static function getAllDesserts() {
      return Core\DataManager::getEntryValue(10);
      
    }
}
?>