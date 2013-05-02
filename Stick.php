<?php

namespace StickORM;

/**
 *  Main Stick Object Class.
 * Class StickConfig
 * @package StickORM
 * @author  Hamza Waqas
 * @version v1.0
 * @since   1st Feb, 2013
 */
class Stick {

    /**
     *  Holds Object Table name
     * @var string
     */
    private $_table = "table_name";

    /**
     *  Holds Key/Value of Data
     * @var array
     */
    private $_data = array();

    /**
     *  Indicates whether new
     * @var bool
     */
    private $_isNew;

    /**
     *  Holds data source
     * @var Object
     */
    private $_dataSource;

    /**
     *  Holds Fetch method.
     * @var Integer
     */
    private $_fetchAs = PDO::FETCH_ASSOC;

    /**
     *  holds class Data source.
     * @var null
     */
    protected static $_classDataSource = null;

    /**
     * Holds name
     * @var String
     */
    protected static $_name;

    /**
     *  Holds config object.
     * @var null
     */
    private $_config = null;

    private static $static_config = null;

    /**
     *  Is Object loaded?
     * @var bool
     */
    private $_isLoaded = false;

    /**
     *  is Successful to save?
     * @var bool
     */
    private $_isSaved = false;

    /**
     *  Implements __construct();
     *  Initializes al the basic object.
     * @param $table_name
     * @param array $data
     */
    public function __construct($table_name,$data = array()) {
        $this->_table = $table_name;
        $this->_data = $data;
        $this->_isNew = true;
        $this->_config = StickConfig::getInstance();
        static::$static_config = $this->_config;
        $this->_dataSource = $this->_config->datasource;
    }

    /**
     * If new, then insert else update
     */
    public function save() {
        $this->_validateModifiable();
        if ($this->_isNew) {
            $this->_dataSource->add($this->_getName(), $this->_data);
            $this->_isSaved = true;
        } else {
            $this->_dataSource->update($this->_getName(), $this->_data);
            $this->_isSaved = true;
        }
    }

    /**
     *  Get data by Primary Key
     * @param $id
     * @param null $table_name
     * @return $this
     */
    function _auto_get($id, $table_name = null) {
        if (!is_null($table_name) && !isset($this->_table))
            $this->_table = $table_name;

        $record = static::getDataSource()->scanAndGet($this->_getName(), $id);
        if (!empty ($record)) {
            foreach ($record as $column => $value) {
                $this->_data[$column] = $value;
            }
            $this->_isLoaded = true;
            $this->_isNew = false;
        }

        return $this;
    }

    /**
     *  Is the Object loaded of Given Primary Key value?
     * @return bool
     */
    public function isLoaded() {
        return $this->_isLoaded;
    }

    /**
     *  is Successful to save?
     * @return bool
     */
    public function isSaved() {
        return $this->_isSaved;
    }

    /**
     *  Deletes the record.
     */
    public function delete() {
        $this->_dataSource->remove($this->_getName(), $this->_data);
    }

    /**
     *  Mark Object as new!
     * @param $bool
     */
    public function _setNew($bool) {
        $this->_isNew = $bool;
    }

    private function _makeStick($data) {
        if ( !empty ($data)) {
            $stick = Stick::newStick($this->_getName());
            foreach ($data as $column => $value) {
                $stick->$column = $value;
            }

            return $stick;
        }
        return Stick::newStick($this->_getName());
    }

    /**
     * @param array $criteria
     * @param null $order
     * @param null $limit
     * @param int $offset
     * @deprecated true
     * @return stdClass
     */
    public function get($criteria = array(), $order = null, $limit = null, $offset = 0) {
        try {
            $result = static::getDataSource()->get($this->_getName(), $criteria, $order, $limit, $offset);
            $object = new stdClass();
            if ( !empty($result)) {
                $object = Stick::newStick($this->_getName());
                $object->_setNew(false);
                foreach ($result as $column => $value) {
                    $object->$column = $value;
                }
            }

        } catch (Exception $ex) {
            echo "<pre>"; print_r($ex); exit;
        }
        return $object;
    }

    /**
     *  Private method to make object readable.
     * @throws Exception
     */
    private function _validateModifiable()
    {
        if (!($this->getDataSource() instanceof Modifiable)) {
            throw new Exception("Object is read-only.");
        }
    }

    /**
     *  Implements __unset()
     *
     * @param $column
     */
    public function __unset($column)
    {
        $this->_validateModifiable();
        $this->_data[$column] = null;
    }

    /**
     * @param $object
     * @param array $criteria
     * @param null $order
     * @param null $limit
     * @param int $offset
     * @deprecated true
     * @return array
     */
    public function get_all($object, array $criteria = array(), $order = null, $limit = null, $offset = 0) {
        try {
            $result = static::getDataSource()->get_all($this->_getName(), $criteria, $order, $limit, $offset);
            $objects = array();
            if ( !empty($result) && count($result) > 0) {
                foreach ($result as $data) {
                    $object = Stick::newStick($this->_getName());
                    $object->_setNew(false);
                    foreach ($data as $column => $value) {
                        $object->$column = $value;
                    }
                    $objects[] = $object;
                }
            }

        } catch (Exception $ex) {
            echo "<pre>"; print_r($ex); exit;
        }

        return $objects;
    }

    /**
     *  Returns the count of records.
     * @param array $criteria
     * @return mixed
     */
    public function count($criteria = array()) {
        return static::getDataSource()->count($this->_getName(),$criteria);
    }

    /**
     *  Implements __set()
     * Sets the value of column
     * @param $column
     * @param $value
     */
    public function __set($column, $value) {
        $this->_data[$column] = $value;
    }

    /**
     *  Implements __get()
     *  Returns the value of Column.
     * @param $column
     * @return mixed
     */
    public function __get($column) {
        return $this->_data[$column];
    }

    /**
     *  Change Object from ORM to Collection
     * @param null $type
     * @return array|object
     */
    public function getScope($type = null) {
        if ( $type == 'object')
            return (object) $this->_data;

        return $this->_data;
    }

    /**
     *  Mode of Data
     * @param $type
     * @return $this
     */
    public function fetchAs($type = PDO::FETCH_OBJ) {
        $this->_fetchAs = $type;
        static::getDataSource()->setFetchMode($this->_fetchAs);
        return $this;
    }

    /**
     *  Returns data source.
     * @return mixed
     */
    public static function getDataSource() {
        return static::$static_config->datasource;
    }

    /**
     *  Sets Data source.
     * @param DataSource $datasource
     */
    public static function setDataSource(DataSource $datasource) {
        static::$_classDataSource = $datasource;
    }

    public function _getName() {
        if ( !isset ($this->_table)) {
            throw new Exception("Table name not found in ".get_called_class());
        }

        return $this->_table;
    }

    /**
     *  Check if Key/Value pair exist.
     * @param $key
     * @return bool
     */
    public function hasProperty($key) {
        if ( array_key_exists($key, $this->_data))
            return true;

        return false;
    }




}