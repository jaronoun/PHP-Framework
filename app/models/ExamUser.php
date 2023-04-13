<?php
// TODO: Alle waarden op NN zetten, doe ik nu ff niet want anders teveel werk met testen

namespace Isoros\models;

use Isoros\core\Model;
use PDO;

class ExamUser extends Model
{
    public function create(int $examId, int $userId)
    {
        $stmt = $this->pdo->prepare('INSERT INTO exam_user (exam_id, user_id, created_at, updated_at) VALUES (:exam_id, :user_id, NOW(), NOW())');
        $stmt->bindValue(':exam_id', $examId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteByExamId(int $examId)
    {
        $stmt = $this->pdo->prepare('DELETE FROM exam_user WHERE exam_id = :exam_id');
        $stmt->bindValue(':exam_id', $examId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteByUserId(int $userId)
    {
        $stmt = $this->pdo->prepare('DELETE FROM exam_user WHERE user_id = :user_id');
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function findExamIdsByUserId(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT exam_id FROM exam_user WHERE user_id = :user_id');
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function findUserIdsByExamId(int $examId): array
    {
        $stmt = $this->pdo->prepare('SELECT user_id FROM exam_user WHERE exam_id = :exam_id');
        $stmt->bindValue(':exam_id', $examId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
