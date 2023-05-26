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

    public function show()
    {
        $container = $this->getContainer();

        $session = $container->get(Session::class);
        $loggedIn = $session->get('loggedIn');
        $email = $session->get('user');

        $this->userRepository = new UserRepository();
        $title = "Login";

        $user = $this->userRepository->findUserByEmail($email);

        $data = ['name' => $title, 'loggedIn' => $loggedIn, 'page' => 'users', 'user' => $user];

//        $view = new View(__DIR__ . '/../../../resources/views');
//        $result = $view->render('users/index.php', $data);


//        $view = $container->get(View::class);

//        $view->renderParams('users/index',['user' => $user, 'loggedIn' => $loggedIn, 'page' => 'users']);
    }
}
