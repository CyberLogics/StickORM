<?php

namespace StickORM;

/**
 * Class Modifiable
 * @package StickORM
 * @author  Hamza Waqas
 * @version v1.0
 */
interface Modifiable {

    /**
     * Add
     * @param $object
     * @param array $data
     * @return mixed
     */
    public function add($object, array &$data);

    /**
     *  Updates a record
     * @param $object
     * @param array $data
     * @return mixed
     */
    public function update($object, array &$data);

    /**
     *  Delete a record.
     * @param $object
     * @param array $data
     * @return mixed
     */
    public function remove($object, array $data);

}
