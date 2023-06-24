<?php

namespace Isoros\controllers\api;

use Isoros\core\Model;
use Isoros\models\Grade;
use PDOException;

class GradeRepository extends Model implements Repository
{
    public function getAll(): array
    {
        $results = Grade::all();
        $data = [];

        foreach($results as $result) {
            $data[] = array(
                'id' => $result['id'],
                'exam_name' => $this->findExamName($result['exam_id']),
                'user_name' => $this->findUserName($result['user_id']),
                'grade' => $result['grade'],
                'created_at' => $result['created_at'],
                'updated_at' => $result['updated_at']
            );

        }
        return $data;
    }

    public function findById($id): ?Grade
    {
        return Grade::findById($id);
    }

    public function findByUserId($user_id): ?array
    {
        $results = Grade::findByUserId($user_id);
        $data = [];

        foreach($results as $result) {
            $data[] = array(
                'id' => $result['id'],
                'exam_name' => $this->findExamName($result['exam_id']),
                'user_name' => $this->findUserName($result['user_id']),
                'grade' => $result['grade'],
                'created_at' => $result['created_at'],
                'updated_at' => $result['updated_at']
            );
        }
        return $data;
    }

    public function findRecentGrade($user_id)
    {
        $results = Grade::findRecentGrade($user_id);
        return $results;
    }

    public function findExamName($exam_id): string
    {

        $name = (new ExamRepository)->findById($exam_id)->getName();
        return $name;

    }

    public function findUserName($user_id)
    {
        $data = (new UserRepository)->findById($user_id)->getName();
        return $data;

    }

    public function findGradeByUserId($user_id): ?array
    {
        return Grade::findByUserId($user_id);
    }

    public function findGradeByExamIdAndUserId($exam_id, $user_id): ?array
    {
        return Grade::findByExamIdAndUserId($exam_id, $user_id);
    }

    public function findGradeByExamId($exam_id): ?array
    {
        return Grade::findByExamId($exam_id);
    }


    public function create($data): ?Grade
    {
        $examId = $data['exam_id'];
        $userId = $data['user_id'];
        $teacherId = $data['teacher_id'];
        $grade = $data['grade'];

        $grade = new Grade($examId, $userId, $grade, $teacherId);

        if($grade->save()){
            return $grade;
        } else {
            return null;
        }
    }

    public function update($id, $data): ?Grade
    {
        $grade = Grade::findById($id);

        $grade->setExamId($data['exam_id']);
        $grade->setUserId($data['user_id']);
        $grade->setGrade($data['grade']);
        $grade->setTeacherId($data['teacher_id']);
        $grade->setUpdatedAt(Date('Y-m-d H:i:s'));

        if($grade->update()){
            return $grade;
        } else {
            return null;
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

