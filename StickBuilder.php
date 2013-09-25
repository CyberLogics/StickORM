<?php

namespace StickORM;

/**
 * Class StickBuilder
 * @package StickORM
 * @author  Hamza Waqas
 * @version v1.0
 */
class StickBuilder {

    /**
     *  holds db instance.
     * @var null
     */
    private $_db = null;

    /**
     *  Holds data source
     * @var null
     */
    private static $_dataSource = null;

    /**
     * Implements __construct()
     *
     *  Fills $db class property.
     */
    public function __construct() {
        $this->_db = StickConfig::getInstance()->datasource;
        static::$_dataSource = $this->_db->getAbstract();
    }

    /**
     * @return StickBuilder Returns new Builder Factory.
     */
    static function newBuilder() {
        return new StickBuilder();
    }

    /**
     * @return DataSouce    Returns new Query Builder
     */
    public function newQuery() {
        return static::$_dataSource;
    }

    /**
     * @param Zend_Db_Select $select   Requires Select Query from Adapter
     * @return mixed    Executes the query and returns dataset.
     * @throws Exception
     */
    static function newExecutor(Zend_Db_Select $select) {
        if ( !$select instanceof Zend_Db_Select)
            throw new Exception("{$select} should be instance of Zend_Db_Select");
        return self::$_dataSource->query($select);
    }
}