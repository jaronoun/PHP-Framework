<?php
// TODO: Alle waarden op NN zetten, doe ik nu ff niet want anders teveel werk met testen

namespace Isoros\models;

use Isoros\core\Model;
use DateTime;
use PDO;

class Exam extends Model{
    protected int $id;
    protected string $name;
    protected ?string $desc;
    protected ?DateTime $start_time;
    protected ?DateTime $end_time;
    protected ?DateTime $created_at;
    protected ?DateTime $updated_at;

    public function getAll() {
        $stmt = self::query('SELECT * FROM exam');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = self::query('SELECT * FROM exam WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByName($name): ?Exam
    {
        $stmt = self::query('SELECT * FROM exam WHERE name = ?',['name' => $name]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? new Exam(
            $result['id'],
            $result['name'],
            $result['desc'],
            $result['start_time'],
            $result['end_time'],
            $result['created_at'],
            $result['updated_at']
        ) : null;
    }

    public function create($name, $desc, $start_time, $end_time) {
        $stmt = self::query('INSERT INTO exam (name, desc, start_time, end_time, created_at) VALUES (:name, :desc, :start_time, :end_time, NOW())');
        $stmt->execute(['name' => $name, 'desc' => $desc, 'start_time' => $start_time, 'end_time' => $end_time]);
        return $this->getById(self::lastInsertId());
    }

    public function update($id, $name, $desc, $start_time, $end_time) {
        $stmt = self::query('UPDATE exam SET name = :name, desc = :desc, start_time = :start_time, end_time = :end_time, updated_at = NOW() WHERE id = :id');
        $stmt->execute(['id' => $id, 'name' => $name, 'desc' => $desc, 'start_time' => $start_time, 'end_time' => $end_time]);
        return $this->getById($id);
    }

    public function delete($id) {
        $stmt = self::query('DELETE FROM exam WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'exam_user');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'exam_id');
    }
}

