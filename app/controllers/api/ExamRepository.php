<?php

namespace Isoros\controllers\api;


use Isoros\models\Exam;
use Isoros\models\User;
use PDOException;


class ExamRepository
{

    public function getExams(): array
    {
        return Exam::all();
    }

    public function findExamById($id)
    {
        return Exam::findById($id);
    }

    public function findExamByName($name)
    {
        return Exam::findByName($name);
    }

    public function createExam($name, $desc, $start_time, $end_time)
    {
        $exam = new Exam($name, $desc, $start_time, $end_time);

        if($exam->save()){
            return $exam;
        } else {
            return null;
        }
    }

    public function updateExam($id, $name, $desc, $start_time, $end_time)
    {
        try {
            $exam = Exam::findById($id);
            $exam->setDescription($desc);
            $exam->setStartTime($start_time);
            $exam->setEndTime($end_time);
            $exam->save();

            return json_encode($exam);
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function deleteExam($id)
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

