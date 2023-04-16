<?php

namespace Isoros\seeders;

class ExamSeeder extends Seeder
{
    public function __construct()
    {
        parent::__construct();
    }

    public function run()
    {
        $SQL = "
        INSERT INTO exam (name, desc, start_time, end_time, created_at, updated_at) VALUES
            ('Engels', 'First exam', '2023-05-01 09:00:00', '2023-05-01 12:00:00', '2023-04-13 15:30:00', '2023-04-13 15:30:00'),
            ('Nederlands', 'Second exam', '2023-05-02 14:00:00', '2023-05-02 17:00:00', '2023-04-14 10:45:00', '2023-04-14 10:45:00'),
            ('Databases', 'Third exam', '2023-05-03 10:00:00', '2023-05-03 13:00:00', '2023-04-15 13:15:00', '2023-04-15 13:15:00');
        ";

        $this->connection->exec($SQL);;

    }
}