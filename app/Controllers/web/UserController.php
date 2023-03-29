<?php
namespace Isoros\Controllers\Web;

use Isoros\Models\User;

class UserController
{
    public function index()
    {

        $user = new User();
        $users = $user->read();
        $view = new View('users.index', compact('users'));
        $view->render();
    }

    public function show($params)
    {
        $userId = $params['id'];
        // Code to retrieve and display the user with the given ID
        require_once 'app/Views/users/show.php';
    }
}
