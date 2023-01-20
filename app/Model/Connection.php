<?php

namespace App\Model;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;


abstract class Connection
{

    protected static function connect()
    {

        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: array(__DIR__ . "/app"),
            isDevMode: true,
        );

        $connection = DriverManager::getConnection([
            'driver' => 'pdo_pgsql',
            'dbname' => $_ENV['DBNAME'],
            'user' => $_ENV['USER'],
            'password' => $_ENV['PASS'],
            'host' => $_ENV['HOST'],
            'port' => $_ENV['PORT'],
        ], $config);

        // obtaining the entity manager
        $entityManager = new EntityManager($connection, $config);

        return $entityManager;
    }
}
