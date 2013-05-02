<?php

namespace StickORM;

/**
 *  This makes the Object Transactional
 * Class Transactional
 * @package StickORM
 * @author  Hamza Waqas
 * @version v1.0
 */
interface Transactional
{
    /**
     *  Starts the Transaction process
     * @return mixed
     */
    public function beginTransaction();

    /**
     *  Lock it.
     * @return mixed
     */
    public function commit();

    /**
     *  Rollback to recover transaction.
     * @return mixed
     */
    public function rollback();
}
