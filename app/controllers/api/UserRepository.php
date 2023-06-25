<?php

namespace Isoros\controllers\api;

use Isoros\models\ExamUser;
use Isoros\models\Grade;
use Isoros\models\User;
use PDOException;

class UserRepository implements Repository
{
    public function getAll()
    {
        return User::all();
    }

    public function findById($id): User
    {
        return User::findById($id);
    }

    public function findUserByEmail($email): ?User
    {
        return User::findByEmail($email);
    }


    public function create($data): ?User
    {
        $name = $data["name"];
        $email = $data["email"];
        $password = $data["password"];
        $role = $data["role"];

        $user = new User($name, $email, $password, $role, null);

        if($user->save()){
            return $user;
        } else {
            return null;
        }
    }

    public function update($id, $data): bool|string
    {
        $name = $data['name'];
        $email = $data['email'];
        $role = $data['role'];

        try {
            $user = User::findById($id);
            $user->name = $name;
            $user->email = $email;
            $user->role = $role;
            $user->updated_at = date('Y-m-d H:i:s');
            $user->update();

            return json_encode($user);
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function delete($id): bool|string
    {
        try {
            $user = User::findById($id);
            $examUsers = ExamUser::findByUser($id);
            foreach ($examUsers as $examUser) {
                ExamUser::deleteId($examUser['id']);
            }
            $grades = Grade::findByUserId($id);
            foreach ($grades as $grade) {
                Grade::deleteId($grade['id']);
            }
            $user->delete();

            return json_encode(['success' => true]);
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }



}
