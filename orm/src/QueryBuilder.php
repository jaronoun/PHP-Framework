<?php

namespace ORM;

class QueryBuilder
{
    protected $connection;
    protected $table;

    public function __construct(Connection $connection, $table)
    {
        $this->connection = $connection;
        $this->table = $table;
    }

    public function select($columns = ['*'])
    {
        $query = sprintf("SELECT %s FROM %s", implode(', ', $columns), $this->table);
        return $this->execute($query);
    }

    public function insert($values)
    {
        $columns = implode(', ', array_keys($values));
        $placeholders = implode(', ', array_fill(0, count($values), '?'));

        $query = sprintf("INSERT INTO %s (%s) VALUES (%s)", $this->table, $columns, $placeholders);
        return $this->execute($query, array_values($values));
    }

    public function update($values)
    {
        $set = [];
        foreach ($values as $column => $value) {
            $set[] = sprintf("%s = ?", $column);
        }

        $query = sprintf("UPDATE %s SET %s", $this->table, implode(', ', $set));
        return $this->execute($query, array_values($values));
    }

    public function delete()
    {
        $query = sprintf("DELETE FROM %s", $this->table);
        return $this->execute($query);
    }

    public function where($column, $operator, $value)
    {
        $query = sprintf("SELECT * FROM %s WHERE %s %s ?", $this->table, $column, $operator);
        return $this->execute($query, [$value]);
    }

    protected function execute($query, $parameters = [])
    {
        return $this->connection->execute($query, $parameters);
    }
}