<?php 
include  realpath(__DIR__ . '/..') . '/controllers/cont.main.php';

print_r((new workerUploadWasabiCdn(1, $config))->handle());