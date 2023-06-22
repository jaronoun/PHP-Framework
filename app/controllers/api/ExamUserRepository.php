<?php
namespace Isoros\controllers\api;

use DateTime;
use Isoros\core\Model;
use Isoros\models\ExamUser;
use Psr\Container\ContainerInterface;

class ExamUserRepository extends Model implements Repository
{

    public function getAll()
    {
        return ExamUser::all();
    }

    public function findByUser($userId)
    {
        return ExamUser::findByUser($userId);
    }

    public function findByExam($examId)
    {
        return ExamUser::findByExam($examId);
    }

    public function create($data): ?ExamUser
    {
        $exam_id = $data["exam_id"];
        $user_id = $data["user_id"];

        $examUser = new ExamUser(null, $exam_id, $user_id);

        if ($examUser->save()) {
            return $examUser;
        } else {
            return null;
        }
    }

    public function delete($id)
    {
        $deleted = true;
        $examUsers = ExamUser::findByExam($id);
        foreach ($examUsers as $data) {
            $examUser = new ExamUser(
                $data['id'],
                $data['exam_id'],
                $data['user_id'],
                $data['created_at'],
                $data['updated_at']
            );
            if (!$examUser->delete()) {
                $deleted = false;
            }
        }
        return $deleted;
    }

    public function deleteById($examId, $userId)
    {
        return ExamUser::deleteById($examId, $userId);
    }

    public function update($id, $data)
    {
        // TODO: Implement update() method.
    }

    public function findById($id)
    {
        // TODO: Implement findById() method.
    }
}
