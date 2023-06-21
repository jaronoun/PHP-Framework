<?php

namespace Isoros\controllers\api;

use Isoros\core\Model;
use Isoros\models\Grade;
use PDOException;

class GradeRepository extends Model implements Repository
{
    public function getAll(): array
    {
        return Grade::all();
    }

    public function findById($id): ?Grade
    {
        return Grade::findById($id);
    }

    public function findExamName($exam_id): string
    {
        return (new ExamRepository())->findById($exam_id)->getName();

    }

    public function findGradeByUserId($user_id): ?array
    {
        return Grade::findByUserId($user_id);
    }

    public function create($data): ?Grade
    {
        $name = $data[0];
        $desc = $data[1];
        $start_time = $data[2];
        $end_time = $data[3];

        $grade = new Grade($name, $desc, $start_time, $end_time);

        if($grade->save()){
            return $grade;
        } else {
            return null;
        }
    }

    public function update($id, $data): bool|string
    {
        $examId = $data[0];
        $user_id = $data[1];
        $desc = $data[2];
        $start_time = $data[3];
        $end_time = $data[4];

        try {
            $grade = Grade::findById($id);
            $grade->setExamId($examId);
            $grade->setUserId($user_id);
            $grade->setDescription($desc);
            $grade->setStartTime($start_time);
            $grade->setEndTime($end_time);
            $grade->save();

            return json_encode($grade);
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function delete($id): bool|string
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

