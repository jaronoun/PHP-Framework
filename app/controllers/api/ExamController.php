<?php

namespace Isoros\controllers\api;

use Isoros\core\Model;
use Isoros\models\Exam;


class ExamController extends Model
{
    private string $exam;

    public function getAllExams()
    {
        return $this->exam->getAll();
    }

    public function getExamById($id)
    {
        return $this->exam->getById($id);
    }

    public function createExam($name, $desc, $start_time, $end_time)
    {
        return $this->exam->create($name, $desc, $start_time, $end_time);
    }

    public function updateExam($id, $name, $desc, $start_time, $end_time)
    {
        return $this->exam->update($id, $name, $desc, $start_time, $end_time);
    }

    public function deleteExam($id)
    {
        $this->exam->delete($id);
    }
}

