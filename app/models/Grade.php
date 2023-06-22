<?php
// TODO: Alle waarden op NN zetten, doe ik nu ff niet want anders teveel werk met testen

namespace Isoros\models;

use Isoros\core\Model;
use PDO;

class Grade extends Model{

    public $id;
    public $exam_id;
    public $user_id;
    public $grade;
    public $created_at;
    public $updated_at;

    public function __construct($exam_id, $user_id, $grade) {

        $this->exam_id = $exam_id;
        $this->user_id = $user_id;
        $this->grade = $grade;
        $this->created_at = Date('Y-m-d H:i:s');
        $this->updated_at = Date('Y-m-d H:i:s');
        parent::__construct();
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getExamId() {
        return $this->exam_id;
    }

    public function setExamId($exam_id) {
        $this->exam_id = $exam_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getGrade() {
        return $this->grade;
    }

    public function setGrade($grade) {
        $this->grade = $grade;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }


    public static function all()
    {
        $data = self::query("SELECT * FROM grades");

        return $data;

    }

    public static function findById(int $id): ?Grade
    {
        $result = self::query("SELECT * FROM grade WHERE id = ?", [$id]);

        if($result){
            $grade = new Grade(
                $result['exam_id'],
                $result['user_id'],
                $result['grade'],

            );
            $grade->setId($result['id']);
            $grade->setCreatedAt($result['created_at']);
            $grade->setUpdatedAt($result['updated_at']);
        }
        return $result ? $grade : null;
    }

    public static function findByUserId(int $user_id): ? array
    {
        $result = self::query("SELECT * FROM grades WHERE user_id = ?", [$user_id]);

//        if($result){
//            $grades = new Grade($result['name'],
//                $result['desc'],
//                $result['start_time'],
//                $result['end_time'],
//            );
//            $grades->setId($result['id']);
//            $grades->setCreatedAt($result['created_at']);
//            $grades->setUpdatedAt($result['updated_at']);
//        }
        return $result ?? null;
    }

    public static function findByExamId(int $exam_id): ? array
    {
        $result = self::query("SELECT * FROM grades WHERE exam_id = ?", [$exam_id]);

//        if($result){
//            $grades = new Grade($result['name'],
//                $result['desc'],
//                $result['start_time'],
//                $result['end_time'],
//            );
//            $grades->setId($result['id']);
//            $grades->setCreatedAt($result['created_at']);
//            $grades->setUpdatedAt($result['updated_at']);
//        }
        return $result ?? null;
    }

    public function save(): bool
    {


        return $this->create();

    }

    private function create(): bool
    {
        self::query("INSERT INTO grades (exam_id, user_id, grade, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)", [
            $this->getExamId(),
            $this->getUserId(),
            $this->getGrade(),
            $this->getCreatedAt(),
            $this->getUpdatedAt()
        ]);

        return true;
    }

    private function update(): bool
    {
        self::query("UPDATE grades SET exam_id = ?, user_id = ?, grade = ?, created_at = ?, updated_at = ? WHERE id = ?", [
            $this->getExamId(),
            $this->getUserId(),
            $this->getGrade(),
            $this->getCreatedAt(),
            Date('Y-m-d H:i:s'),
            $this->getId()
        ]);

        return true;
    }

    public function delete(): bool
    {
        self::query("DELETE FROM grades WHERE id = ?", [$this->getId()]);
        return true;
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'grades_user', 'grades_id', 'user_id');
    }

    public function grades()
    {
        return $this->belongsTo(grades::class);
    }
}

