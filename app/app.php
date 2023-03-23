<?php

use ORM\Connection;

$config = require 'config/database.php';

Connection::make($config['mysql']);