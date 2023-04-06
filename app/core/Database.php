<?php

namespace Isoros\core;

class Database
{
    protected \PDO $connection;

    public function __construct(array $config)
    {
        $this->connection = Connection::make($config['mysql']);
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $SQL = "CREATE TABLE IF NOT EXISTS exam (
          id int NOT NULL,
          name varchar(45) NOT NULL,
          description varchar(45) DEFAULT NULL,
          start_time datetime DEFAULT NULL,
          end_time datetime DEFAULT NULL,
          created_at datetime DEFAULT NULL,
          updated_at datetime DEFAULT NULL,
          PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

        CREATE TABLE IF NOT EXISTS users (
          id int NOT NULL,
          name varchar(45) DEFAULT NULL,
          email varchar(45) DEFAULT NULL,
          password varchar(45) DEFAULT NULL,
          role enum('student','teacher','admin') DEFAULT NULL,
          remember_token varchar(45) DEFAULT NULL,  
          created_at datetime DEFAULT NULL,
          updated_at datetime DEFAULT NULL,
          PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci; 

        CREATE TABLE IF NOT EXISTS exam_user (
          exam_id int DEFAULT NULL,
          user_id int DEFAULT NULL,
          created_at varchar(45) DEFAULT NULL,
          updated_at varchar(45) DEFAULT NULL,
          KEY user_id_idx (exam_id),
          KEY user_id_idx1 (user_id),
          CONSTRAINT exam_id FOREIGN KEY (exam_id) REFERENCES exam (id),
          CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci; 
        
        CREATE TABLE IF NOT EXISTS grades (
          id int NOT NULL,
          exam_id int DEFAULT NULL,
          user_id int DEFAULT NULL,
          grade int DEFAULT NULL,
          created_at varchar(45) DEFAULT NULL,
          updated_at varchar(45) DEFAULT NULL,
          PRIMARY KEY (id),
          KEY exam_id_idx (exam_id),
          KEY user_id_idx (user_id),
          CONSTRAINT exam_id_2 FOREIGN KEY (exam_id) REFERENCES exam (id),
          CONSTRAINT users_id_2 FOREIGN KEY (user_id) REFERENCES users (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;" ;

        $this->connection->exec($SQL);
    }

    public function getConnection(): \PDO
    {
        return $this->connection;
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $newMigrations = [];
        $files = scandir(__DIR__ . '/../migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }

            require_once __DIR__ . '/../migrations/' . $migration;
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
        $this->connection->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }

    protected function getAppliedMigrations()
    {
        $statement = $this->connection->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    protected function saveMigrations(array $newMigrations)
    {
        $str = implode(',', array_map(function ($m) {
            return "('$m')";
        }, $newMigrations));

        $statement = $this->connection->prepare("INSERT INTO migrations (migration) VALUES $str");
        $statement->execute();
    }

    public function prepare($sql): \PDOStatement
    {
        return $this->connection->prepare($sql);
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
