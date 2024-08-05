<?php 
include  realpath(__DIR__ . '/..') . '/controllers/cont.main.php';

print_r((new workerDownload(5, $config['site_url']))->handle());