<?php
namespace Isoros\controllers\api;

use DateTime;
use Isoros\core\Model;
use Isoros\models\ExamUser;
use Psr\Container\ContainerInterface;

class ExamUserRepository extends Model implements Repository
{
    // Deze methode haalt een examuser op basis van het id uit de database en geeft null terug als er geen rij met dat id bestaat.
    public function getById(int $id): ?ExamUser {
        $stmt = $this->db->prepare("SELECT * FROM exam_user WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if ($row === false) {
            return null;
        }

        return $this->mapRowToExamUser($row);
    }


    private function mapRowToExamUser(array $row): ExamUser
    {
        $examUser = new ExamUser();
        $examUser->setExamId($row['exam_id']);
        $examUser->setUserId($row['user_id']);
        $examUser->setCreatedAt(new DateTime($row['created_at']));
        $examUser->setUpdatedAt(new DateTime($row['updated_at']));
        return $examUser;
    }

    public function find($exam_id, $user_id)
    {
        $query = "SELECT * FROM exam_user WHERE exam_id = :exam_id AND user_id = :user_id";
        $params = array(':exam_id' => $exam_id, ':user_id' => $user_id);
        $result = $this->db->query($query, $params);
        if (count($result) == 0) {
            return null;
        }
        return new ExamUser($result[0]);
    }

    public function findAll()
    {
        $query = "SELECT * FROM exam_user";
        $result = $this->db->query($query);
        $exam_users = array();
        foreach ($result as $row) {
            $exam_users[] = new ExamUser($row);
        }
        return $exam_users;
    }

    public function findByExam($exam_id)
    {
        $query = "SELECT * FROM exam_user WHERE exam_id = :exam_id";
        $params = array(':exam_id' => $exam_id);
        $result = $this->db->query($query, $params);
        $exam_users = array();
        foreach ($result as $row) {
            $exam_users[] = new ExamUser($row);
        }
        return $exam_users;
    }


    public function save(ExamUser $exam_user)
    {
        $query = "INSERT INTO exam_user (exam_id, user_id, created_at, updated_at) VALUES (:exam_id, :user_id, :created_at, :updated_at)";
        $params = array(
            ':exam_id' => $exam_user->getExamId(),
            ':user_id' => $exam_user->getUserId(),
            ':created_at' => $exam_user->getCreatedAt(),
            ':updated_at' => $exam_user->getUpdatedAt()
        );
        $this->db->execute($query, $params);
    }
    
    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public function findById($id)
    {
        // TODO: Implement findById() method.
    }

    public function create($data)
    {
        // TODO: Implement create() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function update($id, $data)
    {
        // TODO: Implement update() method.
    }
}
