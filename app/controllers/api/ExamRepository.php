<?php

namespace Isoros\controllers\api;


use Isoros\models\Exam;
use PDOException;


class ExamRepository implements Repository
{

    public function getAll(): array
    {
        return Exam::all();
    }

    public function findById($id): ?Exam
    {
        return Exam::findById($id);
    }

    public function findExamByName($name): ?Exam
    {
        return Exam::findByName($name);
    }

    public function create($data): ?Exam
    {
        $name = $data["name"];
        $desc = $data["desc"];
        $start = $data["start-time"];
        $end = $data["end-time"];

        $exam = new Exam($name, $desc, $start, $end);

        if ($exam->save()) {
            return $exam;
        } else {
            return null;
        }
    }

    public function update($id, $data): false|string
    {
        $name = $data[0];
        $desc = $data[1];
        $start_time = $data[2];
        $end_time = $data[3];
        $updated_at = $data[4];


        try {
            $exam = Exam::findById($id);
            $exam->setExamId($name);
            $exam->setUserId($desc);
            $exam->setDescription($desc);
            $exam->setStartTime($start_time);
            $exam->setEndTime($end_time);
            $exam->setUpdatedAt($updated_at);
            $exam->save();

            return json_encode($exam);
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function delete($id): false|string
    {
        try {
            $exam = Exam::findById($id);
            $exam->delete();
            return json_encode(['success' => true]);
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

}

