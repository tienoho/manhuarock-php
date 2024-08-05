<?php 
include  realpath(__DIR__ . '/..') . '/controllers/cont.main.php';

print_r((new workerUploadBunnyCdn(1, $config))->handle());