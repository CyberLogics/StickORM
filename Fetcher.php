<?php
namespace StickORM;

/**
 * Class Fetcher
 * @package StickORM
 * @author  Hamza Waqas
 * @version v1.0
 */
interface Fetcher
{
    public function setFetchMode($fetch_mode);
    public function getFetchMode();
}
