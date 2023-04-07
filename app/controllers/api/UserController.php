<?php

namespace Isoros\controllers\api;

use Isoros\core\Controller;
use Isoros\models\User;

class UserController extends Controller
{
    public function getById(int $id): ?User {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if ($row === false) {
            return null;
        }

        return $this->mapRowToUser($row);
    }

    private function mapRowToUser(array $row): User {
        $user = new User();
        $user->id = $row['id'];
        $user->name = $row['name'];
        $user->email = $row['email'];
        $user->password = $row['password'];
        $user->role = $row['role'];
        $user->remember_token = $row['remember_token'];
        $user->created_at = new DateTime($row['created_at']);
        $user->updated_at = new DateTime($row['updated_at']);
        return $user;
    }


}
