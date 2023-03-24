<?php
// TODO: Alle waarden op NN zetten, doe ik nu ff niet want anders teveel werk met testen


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

    public function create() {
        $query = "INSERT INTO grades SET exam_id=:exam_id, user_id=:user_id, grade=:grade, created_at=:created_at, updated_at=:updated_at";

        $stmt = $this->conn->prepare($query);

        $this->exam_id = htmlspecialchars(strip_tags($this->exam_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->grade = htmlspecialchars(strip_tags($this->grade));
        $this->created_at = htmlspecialchars(strip_tags($this->created_at));
        $this->updated_at = htmlspecialchars(strip_tags($this->updated_at));

        $stmt->bindParam(":exam_id", $this->exam_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":grade", $this->grade);
        $stmt->bindParam(":created_at", $this->created_at);
        $stmt->bindParam(":updated_at", $this->updated_at);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function read() {
        $query = "SELECT * FROM grades";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function read_single() {
        $query = "SELECT * FROM grades WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->exam_id = $row['exam_id'];
        $this->user_id = $row['user_id'];
        $this->grade = $row['grade'];
        $this->created_at = $row['created_at'];
        $this->updated_at = $row['updated_at'];
    }

    public function update() {
        $query = "UPDATE grades SET exam_id=:exam_id, user_id=:user_id, grade=:grade, updated_at=:updated_at WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $this->exam_id = htmlspecialchars(strip_tags($this->exam_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->grade = htmlspecialchars(strip_tags($this->grade));
        $this->updated_at = htmlspecialchars(strip_tags($this->updated_at));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":exam_id", $this->exam_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":grade", $this->grade);
        $stmt->bindParam(":updated_at", $this->updated_at);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete() {
        $query = "DELETE FROM grades WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}

