<?php

namespace Isoros\controllers\api;

use Isoros\core\Model;
use Isoros\models\Grade;
use PDOException;

class GradeRepository extends Model implements Repository
{
    public function getAll()
    {
        return Grade::all();
    }

    public function findById($id)
    {
        return Grade::findById($id);
    }

    public function findExamName($exam_id)
    {
        return (new ExamRepository())->findExamById($exam_id)->getName();

    }

    public function findGradeByUserId($user_id)
    {
        return Grade::findByUserId($user_id);
    }

    public function create($name, $desc, $start_time, $end_time)
    {
        $grade = new Grade($name, $desc, $start_time, $end_time);

        if($grade->save()){
            return $grade;
        } else {
            return null;
        }
    }

    public function update($id, $name, $desc, $start_time, $end_time)
    {
        try {
            $grade = Grade::findById($id);
            $grade->setDescription($desc);
            $grade->setStartTime($start_time);
            $grade->setEndTime($end_time);
            $grade->save();

            return json_encode($grade);
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            $grade = Grade::findById($id);
            $grade->delete();

            return json_encode(['success' => true]);
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }
}

