<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once 'Models/User.php';
use ORM\Connection;

$config = require '../config/database.php';

try {
    $pdo = Connection::make($config['mysql']);


    $user = new User($pdo,"Dorien3","","","","");

// roep de read() functie op het object aan en krijg een PDOStatement object terug
    $stmt = $user->read();


// gebruik fetchAll() om de rijen uit de resultaatset op te halen als een array
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    var_dump($data);

    //echo "Database connection successful!\n ";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

