<?php
require_once '../vendor/autoload.php';

use Isoros\Core\App;
use Isoros\Core\Container;

$container = new Container();

// Controllers
$container->set('HomeController', function () {
return new \App\Controllers\web\HomeController();
});

$container->set('UserController', function () {
return new \App\Controllers\web\UserController();
});

$container->set('ExamController', function () {
return new \App\Controllers\api\ExamController();
});

$container->set('GradeController', function () {
return new \App\Controllers\api\GradeController();
});

// Models
$container->set('UserModel', function () {
return new \App\Models\User();
});

$container->set('GradeModel', function () {
return new \App\Models\Grade();
});

$container->set('ExamModel', function () {
return new \App\Models\Exam();
});

$container->set('ExamUserModel', function () {
return new \App\Models\ExamUser();
});

// Views
$container->set('View', function () {
return new \App\Core\View();
});

$app = new App($container);

// Web routes
$app->get('/', 'HomeController@index');
$app->get('/users', 'UserController@index');
$app->get('/users/edit/{id}', 'UserController@edit');

// API routes
$app->get('/api/exams', 'ExamController@index');
$app->get('/api/exams/{id}', 'ExamController@show');
$app->post('/api/exams', 'ExamController@store');
$app->put('/api/exams/{id}', 'ExamController@update');
$app->delete('/api/exams/{id}', 'ExamController@delete');

$app->get('/api/grades', 'GradeController@index');
$app->get('/api/grades/{id}', 'GradeController@show');
$app->post('/api/grades', 'GradeController@store');
$app->put('/api/grades/{id}', 'GradeController@update');
$app->delete('/api/grades/{id}', 'GradeController@delete');

$app->run();