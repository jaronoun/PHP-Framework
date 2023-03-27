<?php
class UserController
{
    public function index()
    {
        echo "Here's a list of users:";
        // Code to retrieve and display a list of users

        require_once 'app/Views/users/index.php';
    }

    public function show($params)
    {
        $userId = $params['id'];
        // Code to retrieve and display the user with the given ID
        require_once 'app/Views/users/show.php';
    }
}
