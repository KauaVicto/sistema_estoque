<?php
session_start();

require_once "../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__.'/../');
$dotenv->load();

(require __DIR__ . '/../config/bootstrap.php')->run();