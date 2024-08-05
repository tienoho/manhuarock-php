<?php
include __DIR__ . '/controllers/cont.main.php';

$params = getopt('s:');
$site = $params['s'] ?? '';

if (!$site) {
    exit('Can not receive parameters from terminal');
}

include __DIR__ . '/sites/' . $site . '.php';
