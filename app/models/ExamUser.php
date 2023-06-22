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

    public function __construct(
        int $id = null,
        int $exam_id,
        int $user_id,
        $created_at = null,
        $updated_at = null)
    {
        $this->id = $id ?? null;
        $this->exam_id = $exam_id;
        $this->user_id = $user_id;
        $this->created_at = $created_at ?? date('Y-m-d H:i:s');
        $this->updated_at = $updated_at ?? date('Y-m-d H:i:s');
        parent::__construct();
    }

    public static function all()
    {
        $data = self::query("SELECT * FROM exam_user");
        return $data;
    }

    public static function findByUser($userId)
    {
        $data = self::query("SELECT * FROM exam_user WHERE user_id = ?", [$userId]);
        return $data;
    }

    public static function findByExam($examId)
    {
        $data = self::query("SELECT * FROM exam_user WHERE exam_id = ?", [$examId]);
        return $data;
    }

    public static function findByExamAndUser($examId, $userId)
    {
        $data = self::query("SELECT * FROM exam_user WHERE exam_id = ? AND user_id = ?", [$examId, $userId]);
        return $data;
    }

    public function save()
    {
        if (! self::findByExamAndUser($this->exam_id, $this->user_id)) {
            return $this->create();
        }
        return false;
    }

    public function create() : bool
    {
        $stmt = self::query("INSERT INTO exam_user (exam_id, user_id, created_at, updated_at) VALUES (?, ?, ?, ?)",
        [
           $this->exam_id,
           $this->user_id,
           $this->created_at,
           $this->updated_at
        ]);
        return true;
    }

    public function delete() : bool
    {
        if (self::findByExam($this->exam_id)) {
            return $this->remove();
        }
        return false;
    }

    public function remove() : bool
    {
        $stmt = self::query("DELETE FROM exam_user WHERE exam_id = ? AND user_id = ?", [$this->exam_id, $this->user_id]);
        return true;
    }


}
