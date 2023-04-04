<?php

namespace Isoros\Models;

use Isoros\Database;
use Isoros\DbModel;

class Exam extends DbModel
{
    protected $table = 'exam';

    public static function add(Database $db, $name, $desc, $start_time, $end_time)
    {
        $attributes = [
            'name' => $name,
            'desc' => $desc,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $exam = new Exam($db, $attributes);
        $exam->save();

        return $exam;
    }

    public function update(Database $db, $name, $desc, $start_time, $end_time)
    {
        $this->name = $name;
        $this->desc = $desc;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->updated_at = date('Y-m-d H:i:s');
        $this->save();

        return $this;
    }

    public static function getAll(Database $db)
    {
        return Exam::all($db);
    }

    public static function getById(Database $db, $id)
    {
        return Exam::find($db, $id);
    }

    public static function getByName(Database $db, $name)
    {
        return Exam::whereFirst($db, 'name', '=', $name);
    }

    public static function getByStartTime(Database $db, $start_time)
    {
        return Exam::whereFirst($db, 'start_time', '=', $start_time);
    }

    public static function getByEndTime(Database $db, $end_time)
    {
        return Exam::whereFirst($db, 'end_time', '=', $end_time);
    }

    public function delete(Database $db)
    {
        return parent::delete($db);
    }
}
