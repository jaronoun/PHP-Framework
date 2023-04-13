<?php
namespace Isoros\Controllers\Web;

use Isoros\controllers\api\UserRepository;
use Isoros\core\Controller;
use Isoros\core\View;
use Isoros\models\User;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class UserController extends Controller
{

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index()
    {
        $this->gradeRepository = new UserRepository();
        $title = "Login";

        $container = $this->getContainer();

        $view = $container->get(View::class);


        $view->render('users/index');

    }

    public function show($params)
    {
        $userId = $params['id'];

        require_once 'app/views/users/show.php';
    }
}
