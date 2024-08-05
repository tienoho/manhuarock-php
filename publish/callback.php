<?php


require_once __DIR__ . './../backend/app.php';

$app = new App();

$service =  new \Services\Muabanthe();  
$service->charge_callback();