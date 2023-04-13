<?php

namespace Isoros\core;

use PDO;
use PDOStatement;

class Model
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = Database::connect();

    }

    protected static function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = Database::connect()->prepare($sql);
        foreach ($params as $index => $value) {
            $paramIndex = is_int($index) ? $index + 1 : $index;
            if ($paramIndex < 1) {
                throw new InvalidArgumentException("Parameter index must be greater than or equal to 1.");
            }
            $stmt->bindValue($paramIndex, $value);
        }
        $stmt->execute();

        return $stmt;
    }

    public function hasOne(string $relatedModel, ?string $foreignKey = null): ?array
    {
        $relatedTable = (new $relatedModel)->table;
        $foreignKey = $foreignKey ?? $this->table . '_id';
        $stmt = $this->query("SELECT * FROM $relatedTable WHERE id = ?", [$this->$foreignKey]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? array_map('htmlspecialchars', $result) : null;
    }

    public function hasMany(string $relatedModel, ?string $foreignKey = null): ?array
    {
        $relatedTable = (new $relatedModel)->table;
        $foreignKey = $foreignKey ?? $this->table . '_id';
        return $this->query("SELECT * FROM $relatedTable WHERE $foreignKey = ?", [$this->id])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function belongsTo(string $relatedModel, ?string $foreignKey = null): ?array
    {
        $relatedTable = (new $relatedModel)->table;
        $foreignKey = $foreignKey ?? $relatedTable . '_id';
        return $this->query("SELECT * FROM $relatedTable WHERE id = ?", [$this->$foreignKey])->fetch(PDO::FETCH_ASSOC);
    }

    public function belongsToMany(string $relatedModel, string $joinTable, ?string $foreignKey = null, ?string $relatedKey = null): ?array
    {
        $relatedTable = (new $relatedModel)->table;
        $foreignKey = $foreignKey ?? $this->table . '_id';
        $relatedKey = $relatedKey ?? $relatedTable . '_id';
        $joinTable = $joinTable ?? $this->table . '_' . $relatedTable;
        return $this->query("SELECT $relatedTable.* FROM $relatedTable JOIN $joinTable ON $relatedTable.id = $joinTable.$relatedKey WHERE $joinTable.$foreignKey = ?", [$this->id])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setUp(): void
    {
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

}
