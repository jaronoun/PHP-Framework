<?php

namespace Isoros\seeders;

class SetupSeeder extends Seeder
{
    public function run()
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
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";

        $this->connection->exec($SQL);
    }
}