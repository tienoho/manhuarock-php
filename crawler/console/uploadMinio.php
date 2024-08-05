<?php 
include  realpath(__DIR__ . '/..') . '/controllers/cont.main.php';

print_r((new workerUploadMinioCdn(5, $config))->handle());