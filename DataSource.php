<?php


namespace StickORM;

/**
 * Class DataSource
 * @package StickORM
 * @author  Hamza Waqas
 * @deprecated  Class is Deprecated and will removed in next release.
 * @version v1.0
 */
interface DataSource {
    public function get($object, array $criteria = array(), $order = null, $limit = null, $offset = 0);
    public function get_all($object, array $criteria = array(), $order = null, $limit = null, $offset = 0);
    public function count($object, array $criteria = array());
}