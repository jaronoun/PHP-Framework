<?php

namespace Isoros\Core;

use PDO;
use PDOException;
use Psr\Container\ContainerInterface;

class Database
{
    protected $db;
    protected static $instance;
    protected $container;

    private function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->db = $container->get(PDO::class);
    }

    public static function getInstance(ContainerInterface $container)
    {
        if (self::$instance === null) {
            self::$instance = new self($container);
        }

        return self::$instance;
    }

    public function getRepository($entityClass)
    {
        $tableName = $this->getTableName($entityClass);

        $repositoryClass = str_replace('Models', 'Database\Repositories', $entityClass) . 'Repository';

        return $this->container->get($repositoryClass);
    }

    protected function getTableName($entityClass)
    {
        $reflect = new \ReflectionClass($entityClass);

        return strtolower($reflect->getShortName()) . 's';
    }

    public function execute($query, $bindings = [])
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute($bindings);

        $this->lastInsertId = $this->db->lastInsertId();

        return $stmt;
    }

    public function getLastInsertId()
    {
        return $this->lastInsertId;
    }
}
