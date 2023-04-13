<?php

require 'vendor/autoload.php';

use Isoros\core\Database;

$pdo = new Database();

$pdo->applyMigrations();


