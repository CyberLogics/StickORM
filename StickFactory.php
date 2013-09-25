<?php
/**
 * Created as StickFactory.php.
 * Developer: Hamza Waqas
 * Date:      2/6/13
 * Time:      2:09 PM
 */

class StickFactory {

    static function newStick($table_name = null, $id = null) {
        if ( is_null($table_name))
            throw new Exception("Cannot create null stick.");


        if ( !is_null($id)) {
            $stick = new Stick($table_name);
            return $stick->_auto_get($id);
        }

        return new Stick($table_name);
    }

    static function newTransactor() {
        return Transactor::getTransactor();
    }
}