<?php

require __DIR__ . '/../vendor/autoload.php';
echo "\n";

// Backup .env file
$envFile = __DIR__ . '/../.env';
$envBackupFile = __DIR__ . '/../.env.backup';
if (file_exists($envFile) && !file_exists($envBackupFile)) {
    copy($envFile, $envBackupFile);
    copy(__DIR__ . '/../.env.testing', $envFile);
}

// Load environment variables
require __DIR__ . '/../config/dotenv.php';
$GLOBALS['logger'] = require __DIR__ . '/../config/monolog.php';

// Ensure the SQLite database file exists
$dbFile = '_test.sqlite';
if (!file_exists($dbFile)) {
    touch($dbFile);
}

// Set up dcotrine entity manager
$entityManager = require __DIR__ . '/../config/doctrine.php';
use App\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
$GLOBALS['userRepository'] = new DoctrineUserRepository($entityManager);

// Run migrations
echo "\033[33mRunning migrations...\033[0m\n";
$output = shell_exec(__DIR__ . '/../doctrine migrations:migrate --no-interaction --all-or-nothing');
if (strpos($output, '[ERROR]') !== false) {
    echo "\033[31mError running migrations:\033[0m\n" . $output;
    exit(1);
}
preg_match_all('/\[OK\].*$/m', $output, $matches);
foreach ($matches[0] as $match) {
    echo "\033[32m" . $match . "\033[0m\n";
}

echo "\n";

// Restore .env file after tests
register_shutdown_function(function() use ($envFile, $envBackupFile, $dbFile) {
    if (file_exists($envBackupFile)) {
        copy($envBackupFile, $envFile);
        unlink($envBackupFile);
        unlink($dbFile);
    }
});
