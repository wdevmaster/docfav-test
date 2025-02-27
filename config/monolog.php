<?php

use Monolog\Logger;
use Monolog\ErrorHandler;
use Monolog\Handler\StreamHandler;

$logger = new Logger('app');
$logger->pushHandler(new StreamHandler(__DIR__ . '/../app.log', Logger::DEBUG));

ErrorHandler::register($logger);