<?php

declare(strict_types=1);

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;
use Dotenv\Dotenv;

// Change the working directory to the root of the project
chdir(dirname(__DIR__));

// Load the autoloader
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
} else {
    throw new RuntimeException('vendor/autoload.php not found. Please run composer install.');
}

// Configure Whoops
$whoops = (new Run())->pushHandler(new PrettyPageHandler());
$whoops->register();

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
