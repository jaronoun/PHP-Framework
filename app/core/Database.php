<?php

// Over het algemeen zijn de functies die betrekking hebben op het communiceren met de database,
// zoals het uitvoeren van SQL-query's, het maken van verbinding met de database en het ophalen
// van resultaten, opgenomen in de Database-klasse. Dit omvat ook de transacties en eventuele
// andere geavanceerde databasebewerkingen.

namespace Isoros\core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    /**
     * Verbinding maken met de database.
     *
     * @return PDO|null
     */
    public static function connect(): ?PDO
    {
        if (self::$connection !== null) {
            return self::$connection;
        }
        // Database credentials
        $config = require_once '../../config/database.php';
        $config = $config['mysql'];

        // Create connection
        $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";

        try {
            self::$connection =new PDO($dsn, $config['username'], $config['password']);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }

        return self::$connection;
    }

    /**
     * Begin een database transactie.
     *
     * @return void
     */
    public static function beginTransaction(): void
    {
        self::connect()->beginTransaction();
    }

    /**
     * Maak de veranderingen die gemaakt zijn binnen een transactie permanent.
     *
     * @return void
     */
    public static function commit(): void
    {
        self::connect()->commit();
    }

    /**
     * Maak de veranderingen die gemaakt zijn binnen een transactie ongedaan.
     *
     * @return void
     */
    public static function rollBack(): void
    {
        self::connect()->rollBack();
    }
}

