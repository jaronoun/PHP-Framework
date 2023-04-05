<?php

require 'vendor/autoload.php';

use Isoros\Core\App;
use Isoros\Core\Database;

$pdo = new Database(require '../config/database.php');

$pdo->applyMigrations();


