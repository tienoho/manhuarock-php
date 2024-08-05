<?php

$data = $_POST['data'];
$path = $_POST['path'];

chdir(__DIR__);

$directory = realpath(dirname($path));

if(!is_dir($directory)){
    //Create our directory.
    mkdir($directory, 755, true);
}

if(file_put_contents($path, $data) !== false){
    echo json_encode(['status' => true]);
    exit;
}

echo json_encode(['status' => false]);