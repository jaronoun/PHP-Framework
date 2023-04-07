<?php

namespace Isoros\controllers\api;

use Isoros\core\Controller;
use Isoros\models\User;

class UserController extends Controller
{
    public function getUsers()
    {
        $users = User::all();
        return json_encode($users);
    }

    public function getUser($id)
    {
        $user = User::find($id);
        return json_encode($user);
    }

    public function createUser($name, $email, $password, $role)
    {
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->role = $role;
        $user->save();

        return json_encode($user);
    }

    public function updateUser($id, $name, $email, $password, $role)
    {
        $user = User::find($id);
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->role = $role;
        $user->save();

        return json_encode($user);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();

        return json_encode(['success' => true]);
    }


}
