<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

// Configuración de Doctrine
$paths = [__DIR__ . '/src/Infrastructure/Persistence/Entity'];
$isDevMode = true;

// Configuración de la conexión a la base de datos
$dbParams = [
    'driver' => 'pdo_mysql',
    'user' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'dbname' => $_ENV['DB_DATABASE'],
    'host' => $_ENV['DB_HOST'],
    'port' => $_ENV['DB_PORT'],
];

$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
$connection = DriverManager::getConnection($dbParams, $config);

$entityManager = new EntityManager($connection, $config);

return $entityManager;