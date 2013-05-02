<?php

namespace StickORM;

/**
 *  Abstract Factory returns new Stick Object.
 * Class StickFactory
 * @package StickORM
 * @author  Hamza Waqas
 * @version v1.0
 */
class StickFactory {

    /**
     *  Returns new Stick Object. If $id is supplied, then returns PK loaded object else fresh object.
     * @param null $table_name
     * @param null $id
     * @return Stick
     * @throws Exception
     */
    static function newStick($table_name = null, $id = null) {
        if ( is_null($table_name))
            throw new Exception("Cannot create null stick.");


        if ( !is_null($id)) {
            $stick = new Stick($table_name);
            return $stick->_auto_get($id);
        }

        return new Stick($table_name);
    }
}