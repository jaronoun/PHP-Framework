<?php

namespace Isoros\Core;

use ORM\Connection;

class Database
{
    protected $connection;

    public function __construct(array $config)
    {
        $this->connection = Connection::make($config['mysql']);
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function query($query)
    {
        return $this->connection->query($query);
    }

    public function fetch($query, $params = [])
    {
        return $this->connection->fetch($query, $params);
    }

    public function fetchAll($query, $params = [])
    {
        return $this->connection->fetchAll($query, $params);
    }

    public function insert($table, $data)
    {
        return $this->connection->table($table)->insert($data);
    }

    public function update($table, $data, $conditions)
    {
        return $this->connection->table($table)->update($data, $conditions);
    }

    public function delete($table, $conditions)
    {
        return $this->connection->table($table)->delete($conditions);
    }
}

