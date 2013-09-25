<?php
/**
 * Created as Transactor.php.
 * Developer: Hamza Waqas
 * Date:      8/6/13
 * Time:      11:20 AM
 */

class Transactor {

    private static $_instance = null;

    private $_datasource = null;

    public function __construct() {
        $this->_datasource = StickConfig::getInstance()->datasource;
    }

    static function getTransactor() {
        if ( self::$_instance instanceof Transactor )
            return self::$_instance;

        self::$_instance = new Transactor();
        return self::$_instance;
    }

    public function beginTransaction() {
         $this->_datasource->beginTransaction();
    }

    public function commitTransaction() {
        $this->_datasource->commit();
    }

    public function rollitBack() {
        $this->_datasource->rollback();
    }
}