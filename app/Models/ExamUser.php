<?php
// TODO: Alle waarden op NN zetten, doe ik nu ff niet want anders teveel werk met testen

namespace Isoros\Models;

use Isoros\Core\Database;
use Isoros\Core\Model;

class ExamUser extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['name', 'email', 'password'];

    public static function addExamGrade(Database $db, $examId, $studentId, $grade)
    {
        $examGrade = new ExamUser($db, [
            'exam_id' => $examId,
            'student_id' => $studentId,
            'grade' => $grade
        ]);
        $examGrade->save();
    }

    public static function getExamGrades(Database $db, $examId)
    {
        return ExamUser::where($db, 'exam_id', '=', $examId);
    }
}
