<?php

require_once '../../../vendor/autoload.php';

\Dotenv\Dotenv::createImmutable('../../../')->load();

echo getenv('DB_SOCKET') . PHP_EOL;
echo getenv('DB_USER') . PHP_EOL;
echo getenv('DB_PASS') . PHP_EOL;
echo getenv('DB_DATABASE') . PHP_EOL;