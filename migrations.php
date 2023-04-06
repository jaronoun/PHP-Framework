<?php

require 'vendor/autoload.php';

use Isoros\core\App;
use Isoros\core\Database;

$pdo = new Database(require '../config/database.php');

$pdo->applyMigrations();


