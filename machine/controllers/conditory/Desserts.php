<?php
namespace APIShift\Controllers\Conditory;
use APIShift\Core;
use APIShift\Models;

/**
 * Controller for managing desserts in conditory
 */
class Desserts {
    /**
    * Returns to the user all the available desserts
    */
    public static function getAllDesserts() {
      Core\Status::message(Core\Status::SUCCESS, Models\Conditory\Desserts::getAllDesserts());
    }
}
?>