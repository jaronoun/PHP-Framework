<?php

namespace Isoros\controllers\api;


use Cassandra\Date;
use Isoros\models\Exam;
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

    public function findExamByName($name)
    {

        return Exam::findByName($name);

    }

    public function create($data): ?Exam
    {
        $name = $data["name"];
        $desc = $data["desc"];
        $start = $data["start-time"];
        $end = $data["end-time"];

        $exam = new Exam(null, $name, $desc, $start, $end);

        if ($exam->save()) {
            return $exam;
        } else {
            return null;
        }
    }

    public function update($id, $data): false|string
    {
        $name = $data['name'];
        $desc = $data['desc'];
        $start_time = $data['start-time'];
        $end_time = $data['end-time'];

        try {
            $exam = Exam::findById($id);
            $exam->setName($name);
            $exam->setDescription($desc);
            $exam->setStartTime($start_time);
            $exam->setEndTime($end_time);
            $exam->setUpdatedAt();
            $exam->update();

            return json_encode($exam);
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function delete($id): false|string
    {
        try {
            Exam::deleteById($id);
            return json_encode(['success' => true]);
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

}

