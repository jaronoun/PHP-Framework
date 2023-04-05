<?php
namespace Isoros\Core;
require_once __DIR__ . '/../..//vendor/autoload.php';
use Isoros\Models\User;

use Isoros\Routers\router;
use ORM\Connection;

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
        return $this->db->getConnection();
    }

    public function getRouter(): Router
    {
        return $this->Router;
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

