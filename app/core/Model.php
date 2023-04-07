<?php

namespace Isoros\core;

use PDO;
use Psr\Container\ContainerInterface;

class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = (Container::getInstance())->get(Database::class);
    }
    protected static function connect()
    {
        // Database credentials
        $config = require_once '../config/database.php';
        $config = $config['mysql'];

        // Create connection
        $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
        $pdo = new PDO($dsn, $config['username'], $config['password']);

        // Set PDO attributes
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        return $pdo;
    }

    protected static function query($sql, $params = [])
    {
        $pdo = self::connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    public function hasOne($relatedModel, $foreignKey = null) {
        $relatedTable = (new $relatedModel)->table;
        $foreign_key = $foreignKey ?? $this->table . '_id';
        return $this->query("SELECT * FROM $relatedTable WHERE id = $this->$foreign_key")->fetch();
    }

    // één-op-veel relatie
    public function hasMany($relatedModel, $foreignKey = null) {
        $relatedTable = (new $relatedModel)->table;
        $foreign_key = $foreignKey ?? $this->table . '_id';
        return $this->query("SELECT * FROM $relatedTable WHERE $foreign_key = $this->id")->fetchAll();
    }

    // veel-op-veel relatie
    public function belongsToMany($relatedModel, $joinTable, $foreignKey = null, $relatedKey = null) {
        $relatedTable = (new $relatedModel)->table;
        $foreign_key = $foreignKey ?? $this->table . '_id';
        $related_key = $relatedKey ?? $relatedTable . '_id';
        $join_table = $joinTable ?? $this->table . '_' . $relatedTable;
        return $this->query("SELECT $relatedTable.* FROM $relatedTable JOIN $join_table ON $relatedTable.id = $join_table.$related_key WHERE $join_table.$foreign_key = $this->id")->fetchAll();
    }

    public function setUp()
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

        $this->db->exec($SQL);
    }

}
