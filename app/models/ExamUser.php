<?php
// TODO: Alle waarden op NN zetten, doe ik nu ff niet want anders teveel werk met testen

namespace Isoros\models;

use Isoros\core\Model;
use PDO;

class ExamUser extends Model
{
    public $exam_id;
    public $user_id;
    public $created_at;
    public $updated_at;

    public function __construct(
        int $exam_id,
        int $user_id)
    {
        $this->exam_id = $exam_id;
        $this->user_id = $user_id;
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
        parent::__construct();
    }

    public static function all()
    {
        $stmt = self::query("SELECT * FROM exam_user");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public static function findByUser($userId)
    {
        $stmt = self::query("SELECT * FROM exam_user WHERE user_id = ?", [$userId]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $exams = [];
        foreach ($data as $exam) {
            $examId = $exam['exam_id'];
            $stmt = self::query("SELECT * FROM exam WHERE id = ?", [$examId]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            array_push($exams, $result);
        }
        return $exams;
    }

    public static function findByExam($examId)
    {
        $stmt = self::query("SELECT * FROM exam_user WHERE exam_id = ?", [$examId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function save()
    {
        if (! self::findByExam($this->exam_id)) {
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

}
