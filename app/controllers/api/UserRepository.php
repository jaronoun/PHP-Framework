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

    public function findUserById($id)
    {
        try {
            $user = User::findById($id);
            return json_encode($user);
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function findUserByEmail($email){

        return User::findByEmail($email);

    }


    public function createUser($name, $email, $password, $role)
    {
        var_dump($name);
        $user = new User($name, $email, $password, $role, null);


        if($user->save()){
            return $user;
        } else {
            return null;
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



}
