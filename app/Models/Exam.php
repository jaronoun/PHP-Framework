<?php
// TODO: Alle waarden op NN zetten, doe ik nu ff niet want anders teveel werk met testen
class Exam {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $stmt = $this->db->query('SELECT * FROM exam');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare('SELECT * FROM exam WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $desc, $start_time, $end_time) {
        $stmt = $this->db->prepare('INSERT INTO exam (name, desc, start_time, end_time, created_at) VALUES (:name, :desc, :start_time, :end_time, NOW())');
        $stmt->execute(['name' => $name, 'desc' => $desc, 'start_time' => $start_time, 'end_time' => $end_time]);
        return $this->getById($this->db->lastInsertId());
    }

    public function update($id, $name, $desc, $start_time, $end_time) {
        $stmt = $this->db->prepare('UPDATE exam SET name = :name, desc = :desc, start_time = :start_time, end_time = :end_time, updated_at = NOW() WHERE id = :id');
        $stmt->execute(['id' => $id, 'name' => $name, 'desc' => $desc, 'start_time' => $start_time, 'end_time' => $end_time]);
        return $this->getById($id);
    }

    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM exam WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}

