<?php

namespace StickORM;

/**
 *  Holds Key/Value pair of Configuration that can be access as Singleton in all over application.
 * Class StickConfig
 * @package StickORM
 * @author  Hamza Waqas
 * @version v1.0
 */
class StickConfig {

    /**
     *  Holds configuration Key/value
     * @var array
     */
    private static $_data = array();

    /**
     *  Singleton property variable
     * @var null
     */
    private static $_instance = null;

    /**
     *
     * Singleton, creates a new StickConfig else returns existing.
     * @return null|StickConfig
     */
    static function getInstance() {
        if ( !static::$_instance instanceof StickConfig)
            static::$_instance = new StickConfig();

        return static::$_instance;
    }

    /**
     *  Implements __get()
     *  Finds the property in $_data and returns the value
     * @param $key
     * @return mixed
     */
    public  function __get($key) {
        return static::$_data[$key];
    }

    /**
     *  Implements __set()
     *  Adds a Key/Value to Configuration
     * @param $key
     * @param $value
     */
    public function __set($key, $value) {
        static::$_data[$key] = $value;
    }

}