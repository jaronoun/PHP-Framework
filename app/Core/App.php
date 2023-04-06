<?php
namespace Isoros\Core;
require_once __DIR__ . '/../..//vendor/autoload.php';

use Isoros\Core\Database\Database;
use Isoros\Routers\router;

class App
{
    private $router;
    private $db;

    public function __construct()
    {
        $this->router = new Router();
        $this->db = new Database(require '../config/database.php');
    }

    public function run()
    {
        $this->router->dispatch();
    }

    public function getDbConnection(): \PDO
    {
        return $this->dbConnection->getConnection();
    }

    public function getRouter(): Router
    {
        return $this->router;
    }
    private static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new App();
        }

        return self::$instance;
    }

}

