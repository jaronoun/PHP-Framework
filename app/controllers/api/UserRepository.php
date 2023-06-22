<?php

namespace Isoros\controllers\api;

use Isoros\models\User;
use PDOException;

class UserRepository implements Repository
{
    public function getAll(): bool|string
    {
        try {
            $users = User::all();
            return json_encode($users);
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
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
        $name = $data[0];
        $email = $data[1];
        $password = $data[2];
        $role = $data[3];

        try {
            $user = User::findById($id);
            $user->name = $name;
            $user->email = $email;
            $user->password = $password;
            $user->role = $role;
            $user->save();

            return json_encode($user);
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function delete($id): bool|string
    {
        try {
            $user = User::findById($id);
            $user->delete();

            return json_encode(['success' => true]);
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }



}
