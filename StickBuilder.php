<?php
/**
 * Created as StickBuilder.php.
 * Developer: Hamza Waqas
 * Date:      2/6/13
 * Time:      4:03 PM
 */


/**
 *  Helps to create a new Query.
 */
class StickBuilder {

    private $_db = null;

    private static $_dataSource = null;


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