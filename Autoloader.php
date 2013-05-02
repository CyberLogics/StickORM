<?php

namespace StickORM;


/**
 * Class Autoloader
 * @package StickORM
 * @author  Hamza Waqas
 * @version v1.0
 */
class Autoloader {

    /**
     *  Registers autoload method
     */
    static function registerLoader() {
        spl_autoload_register(__NAMESPACE__."\\Autoloader::_autoload");
    }

    /**
     *  Finds for the class name based over pattern.
     * @param $class
     */
    static function _autoload($class) {
        if (strpos($class,'_') === FALSE) {
            $class_path = dirname(__FILE__).DS.$class.'.php';
            if (file_exists($class_path))
                require_once $class_path;
        }

    }
}