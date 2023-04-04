<?php
namespace Isoros\Controllers\Web;

use Isoros\Core\Controller;
use Isoros\Core\View;
use Isoros\Models\User;

class UserController extends Controller
{

    public function index()
    {
        $user = new User($this->db,"Dorien3","","","","");

        // roep de read() functie op het object aan en krijg een PDOStatement object terug
        $result = $user->read();
        // gebruik fetchAll() om de rijen uit de resultaatset op te halen als een array
        $users = $result->fetchAll(\PDO::FETCH_ASSOC);

        $view = new View('users/index', compact('users'));
        $view->render();
    }

    public function show($params)
    {
        $userId = $params['id'];
        $user = new User($this->db,"Dorien3","","","","");

        // roep de read() functie op het object aan en krijg een PDOStatement object terug
        $result = $user->read();
        // gebruik fetchAll() om de rijen uit de resultaatset op te halen als een array
        $users = $result->fetchAll(\PDO::FETCH_ASSOC);

        $view = new View('users/show', compact('users'));
        $view->render();

    }
}
