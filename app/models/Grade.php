<?php
// TODO: Alle waarden op NN zetten, doe ik nu ff niet want anders teveel werk met testen

namespace Isoros\models;

use Isoros\core\Model;
use PDO;

class Grade extends Model{

    public $id;
    public $grade_id;
    public $user_id;
    public $grade;
    public $created_at;
    public $updated_at;

    public function getAll() {
        $stmt = $this->db->query('SELECT * FROM grade');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare('SELECT * FROM grade WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $desc, $start_time, $end_time) {
        $stmt = $this->db->prepare('INSERT INTO grade (name, desc, start_time, end_time, created_at) VALUES (:name, :desc, :start_time, :end_time, NOW())');
        $stmt->execute(['name' => $name, 'desc' => $desc, 'start_time' => $start_time, 'end_time' => $end_time]);
        return $this->getById($this->db->lastInsertId());
    }

    public function update($id, $name, $desc, $start_time, $end_time) {
        $stmt = $this->db->prepare('UPDATE grade SET name = :name, desc = :desc, start_time = :start_time, end_time = :end_time, updated_at = NOW() WHERE id = :id');
        $stmt->execute(['id' => $id, 'name' => $name, 'desc' => $desc, 'start_time' => $start_time, 'end_time' => $end_time]);
        return $this->getById($id);
    }

    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM grade WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}

