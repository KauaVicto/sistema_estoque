<?php
session_start();

require_once "../vendor/autoload.php";

/* Doctrine */
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__.'/../');
$dotenv->load();

/* Slim */
(require __DIR__ . '/../config/bootstrap.php')->run();