<?php
namespace Isoros\Controllers\Web;

use Isoros\Models\User;

class UserController
{
    public function index()
    {
        echo "Here's a list of users:";
        // Code to retrieve and display a list of users
        // Create an instance of the User Model class
        $userModel = new User("","","","");

        // Call a method of the User Model object to retrieve a list of users
        $users = $userModel->read();


        require_once 'app/Views/users/index.php';
    }

    public function show($params)
    {
        $userId = $params['id'];
        // Code to retrieve and display the user with the given ID
        require_once 'app/Views/users/show.php';
    }
}
