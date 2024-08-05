<?php

$site = getConf('site');


// Config for redis server
$redis = new \Predis\Client([
    'host' => 'localhost',
    'port' => 6379,
    'password' => '',
    'database' => 0,
]);


// Local storage driver
$storage_driver = new \Services\StorageDriver\Local(
    [
        'root_path' => ROOT_PATH . '/public/uploads',
        'base_url' => $site['site_url'] . '/uploads',
    ]
);



return [
    'storage_driver' => $storage_driver,
    'redis' => $redis,
    'max_thread' => 1,
];
