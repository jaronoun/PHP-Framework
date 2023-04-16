<?php

namespace Isoros\controllers\api;

use Isoros\models\User;
use PDOException;

class UserRepository
{
    public function getUsers()
    {
        try {
            $users = User::all();
            return json_encode($users);
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function getUser($id)
    {
        try {
            $user = User::findById($id);
            return json_encode($user);
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function createUser($name, $email, $password, $role)
    {
        try {
            $user = new User($name, $email, $password, $role, null);

            var_dump($user->save());

            return json_encode($user);
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function updateUser($id, $name, $email, $password, $role)
    {
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

    public function deleteUser($id)
    {
        try {
            $user = User::findById($id);
            $user->delete();

            return json_encode(['success' => true]);
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function findUserByEmail($email){
        try {
            return User::findByEmail($email);

        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

}
