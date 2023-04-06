<?php

require 'vendor/autoload.php';

use Isoros\Core\Database\Database;

$pdo = new Database(require '../config/database.php');

$pdo->applyMigrations();


