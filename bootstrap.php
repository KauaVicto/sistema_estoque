<?php

require_once "vendor/autoload.php";

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;

$dotenv = Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();


// Cria uma configuração padrão
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: array(__DIR__."/app"),
    isDevMode: true,
);

// configura a conexão
$connection = DriverManager::getConnection([
    'driver' => 'pdo_pgsql',
    'dbname' => $_ENV['DBNAME'],
    'user' => $_ENV['USER'],
    'password' => $_ENV['PASS'],
    'host' => $_ENV['HOST'],
    'port' => $_ENV['PORT'],
], $config);

// instancia o entity Manager
$entityManager = new EntityManager($connection, $config);