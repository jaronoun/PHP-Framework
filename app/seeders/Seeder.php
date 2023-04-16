<?php

namespace Isoros\seeders;

use Isoros\core\Database;
use PDO;

class Seeder
{
    public PDO $connection;

    public function __construct()
    {
        $this->connection = Database::connect();
    }
}