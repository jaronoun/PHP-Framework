<?php

namespace Isoros\Core;

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config/database.php');


use Isoros\Core\Database;

// Set up database connection
$config = Config::getInstance();
$db = new Database(require '../config/database.php');
$db->connect();

// Start the application by including index.php
include(__DIR__ . '/../config/index.php');