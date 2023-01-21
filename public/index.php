<?php
session_start();

require_once "../vendor/autoload.php";

date_default_timezone_set ("America/Sao_Paulo");

/* Doctrine */
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__.'/../');
$dotenv->load();

/* Slim */
(require __DIR__ . '/../config/bootstrap.php')->run();