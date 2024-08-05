<?php

return [
    'DB_HOST' => $_ENV['DB_HOST'] ?? 'localhost',
    'DB_NAME' => $_ENV['DB_NAME'],
    'DB_USER' => $_ENV['DB_USER'],
    'DB_PASSWORD' => $_ENV['DB_PASSWORD'],
    'DB_PREFIX' => $_ENV['DB_PREFIX'] ?? '',
    'DB_PORT' => $_ENV['DB_PORT'] ?? 3306,
];
