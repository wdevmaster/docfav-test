<?php

declare(strict_types=1);

// Change the working directory to the root of the project
chdir(dirname(__DIR__));

// Load the autoloader
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
} else {
    fwrite(STDERR, 'vendor/autoload.php could not be found. Did you run `composer install`?' . PHP_EOL);
    exit(1);
}

// Configure Whoops
require __DIR__ . '/../config/whoops.php';

// Load environment variables
require __DIR__ . '/../config/dotenv.php';

// Set up Monolog
require __DIR__ . '/../config/monolog.php';

// Set up dependencies
require __DIR__ . '/../config/dependencies.php';

// Handle request
require __DIR__ . '/../routes.php';
