<?php

namespace Isoros\Core;

use ORM\Connection;

class Database
{
    protected $connection;

    public function __construct(array $config)
    {
        $this->connection = Connection::make($config['mysql']);
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    }

    public function getConnection()
    {
        return $this->connection;
    }
    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $newMigrations = [];
        $files = scandir(__DIR__. '/migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }

            require_once __DIR__. '/../migrations/' . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            $this->log("Applying migration $migration");
            $instance->up();
            $this->log("Applied migration $migration");
            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("There are no migrations to apply");
        }
    }

    protected function createMigrationsTable()
    {
        $this->db->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE=INNODB;");
    }

    protected function getAppliedMigrations()
    {
        $statement = $this->db->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    protected function saveMigrations(array $newMigrations)
    {
        $str = implode(',', array_map(function ($m) {
            return "('$m')";
        }, $newMigrations));

        $statement = $this->db->prepare("INSERT INTO migrations (migration) VALUES $str");
        $statement->execute();
    }

    public function prepare($sql): \PDOStatement
    {
        return $this->db->prepare($sql);
    }

    private function log($message)
    {
        echo "[" . date("Y-m-d H:i:s") . "] - " . $message . PHP_EOL;
    }

    public function query($query)
    {
        return $this->connection->query($query);
    }

    public function fetch($query, $params = [])
    {
        return $this->connection->fetch($query, $params);
    }

    public function fetchAll($query, $params = [])
    {
        return $this->connection->fetchAll($query, $params);
    }

    public function insert($table, $data)
    {
        return $this->connection->table($table)->insert($data);
    }

    public function update($table, $data, $conditions)
    {
        return $this->connection->table($table)->update($data, $conditions);
    }

    public function delete($table, $conditions)
    {
        return $this->connection->table($table)->delete($conditions);
    }
}

