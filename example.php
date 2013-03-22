<?php

// Register Auto-loader and set configuration


\StickORM\Autoloader::registerLoader();
$stick_config = StickConfig::getInstance();

try {
    $stick_config->datasource = new Database(Zend_Db::factory('Pdo_Mysql', array(
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'root',
        'dbname'   => 'faredodgers_v1'
    )));
} catch (Exception $ex) {
    echo "<pre>"; print_r($ex); exit;
}


/**
 *  If want to load existing.
 */
$jobStick = StickFactory::newStick('jobs', $values['job_id']);
$jobStick->status = 4; // Job Completed
$jobStick->completed_on = time();
$jobStick->save();
if ( $jobStick->isSaved() ) {
    // Saved. Do something.
}

/**
 *  Create new stick
 */

$jobStick = StickFactory::newStick('jobs');
$jobStick->status = 1;
$jobStick->completed_on = time();
$jobStick->save();
if ( $jobStick->isSaved()) {
    // Saved. do something
}