<?php
namespace Isoros\Controllers\Web;

use Isoros\core\Controller;
use Isoros\core\View;
use Isoros\models\User;

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

        require_once 'app/views/users/show.php';
    }
}
