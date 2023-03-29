<?php
namespace Isoros\Core;
require_once __DIR__ . '/../vendor/autoload.php';
require_once 'Models/User.php';

use Isoros\Routers\router;

class App
{
    private $router;
    private $db;

    public function __construct()
    {
        $this->router = new Router();
        $this->dbConnection = new Database(require '../config/database.php');
    }

    public function run()
    {
        $this->router->dispatch();
    }

    public function getDbConnection(): Database
    {
        return $this->dbConnection;
    }

    public function getRouter(): Router
    {
        return $this->Router;
    }



}

