<?php
namespace Isoros\Controllers\Web;

use Isoros\Controllers\api\GradeRepository;
use Isoros\controllers\api\UserRepository;
use Isoros\core\Controller;
use Isoros\core\View;
use Isoros\models\User;
use Isoros\routing\Session;
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

    public function show()
    {
        $container = $this->getContainer();

        $session = $container->get(Session::class);
        $loggedIn = $session->get('loggedIn');
        $user = $session->get('user');

        $this->gradeRepository = new UserRepository();
        $title = "Login";

        $view = $container->get(View::class);

        $view->renderParams('users/index',['user' => $user, 'loggedIn' => $loggedIn]);
    }
}
