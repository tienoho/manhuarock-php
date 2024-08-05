<?php

set_time_limit(0);
error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('Asia/Ho_Chi_Minh');
define('ROOT_DIR', realpath(__DIR__ . '/..'));

include ROOT_DIR . '/includes/config.php';

include ROOT_DIR . '/liberies/class.fsSessionManager.php';
include ROOT_DIR . '/liberies/class.helper.php';
include ROOT_DIR . '/liberies/class.listSite.php';
include ROOT_DIR . '/liberies/class.workerDownload.php';
include ROOT_DIR . '/liberies/class.workerScraper.php';
include ROOT_DIR . '/liberies/class.workerUploadWasabiStorage.php';
include ROOT_DIR . '/liberies/class.workerUploadBunnyStorage.php';
include ROOT_DIR . '/liberies/class.workerUploadMinioStorage.php';
include ROOT_DIR . '/vendor/autoload.php';


/*
Calling Object
 */
$helper = new Helper();
$fsSessionManager = new fsSessionManager();
$db  = new MysqliDb($config['db']['db_host'], $config['db']['db_user'], $config['db']['db_password'], $config['db']['db_name']);
