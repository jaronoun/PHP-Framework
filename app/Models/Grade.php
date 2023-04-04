<?php
// TODO: Alle waarden op NN zetten, doe ik nu ff niet want anders teveel werk met testen

namespace Isoros\Models;


class Grade {
    private $conn;

    public $id;
    public $exam_id;
    public $user_id;
    public $grade;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

}

