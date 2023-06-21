<?php

namespace Isoros\controllers\api;


use Isoros\models\Exam;
use Isoros\models\User;
use PDOException;


class ExamRepository implements Repository
{

    public function getAll(): array
    {
        return Exam::all();
    }

    public function findById($id)
    {
        return Exam::findById($id);
    }

    public function findExamByName($name): ?Exam
    {
        return Exam::findByName($name);
    }

    public function create($data)
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

    public function update($id, $data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
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

