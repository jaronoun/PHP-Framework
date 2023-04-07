<?php

namespace Isoros\Controllers\api;

use Grade;
use Isoros\core\Model;

class GradeController extends Model
{


    public function createGrade($exam_id, $user_id, $grade)
    {
        $grade = new Grade($this->db);

        $grade->exam_id = $exam_id;
        $grade->user_id = $user_id;
        $grade->grade = $grade;
        $grade->created_at = date('Y-m-d H:i:s');
        $grade->updated_at = date('Y-m-d H:i:s');

        if ($grade->create()) {
            return true;
        }

        return false;
    }

    public function getGrades()
    {
        $grades = new Grade($this->db);

        return $grades->read();
    }

    public function getGradeById($id)
    {
        $grade = new Grade($this->db);

        $grade->id = $id;

        $grade->read_single();

        return $grade;
    }

    public function updateGrade($id, $exam_id, $user_id, $grade)
    {
        $grade = new Grade($this->db);

        $grade->id = $id;
        $grade->exam_id = $exam_id;
        $grade->user_id = $user_id;
        $grade->grade = $grade;
        $grade->updated_at = date('Y-m-d H:i:s');

        if ($grade->update()) {
            return true;
        }

        return false;
    }

    public function deleteGrade($id)
    {
        $grade = new Grade($this->db);

        $grade->id = $id;

        if ($grade->delete()) {
            return true;
        }

        return false;
    }
}

