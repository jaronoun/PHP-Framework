<?php
// TODO: Alle waarden op NN zetten, doe ik nu ff niet want anders teveel werk met testen

namespace Isoros\models;

use Isoros\core\Model;
use PDO;

class ExamUser extends Model
{
    public $id;
    public $exam_id;
    public $user_id;
    public $created_at;
    public $updated_at;
    private int $examId;
    private int $userId;

    public function create(int $examId, int $userId): void
    {
        $this->examId = $examId;
        $this->userId = $userId;
        $this->created_at = Date('Y-m-d H:i:s');
        $this->updated_at = Date('Y-m-d H:i:s');
        parent::__construct();
    }

    public function deleteByExamId(int $examId): bool|array
    {
        $stmt = self::query('DELETE FROM exam_user WHERE exam_id = :exam_id');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteByUserId(int $userId): bool|array
    {
        $stmt = self::query('DELETE FROM exam_user WHERE user_id = :user_id');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findExamIdsByUserId(int $userId): array
    {
        $stmt = self::query('SELECT exam_id FROM exam_user WHERE user_id = :user_id');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findUserIdsByExamId(int $examId): array
    {
        $stmt = self::query('SELECT user_id FROM exam_user WHERE exam_id = :exam_id');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
