<?php
require_once __DIR__ . '/../vendor/autoload.php';
use ORM\Connection;

$config = require '../config/database.php';

try {
    $pdo = Connection::make($config['mysql']);
    echo "Database connection successful!";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}