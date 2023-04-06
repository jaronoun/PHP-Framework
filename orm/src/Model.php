<?php

namespace ORM;

class Model extends QueryBuilder
{
    protected $table;

    public function __construct($pdo, $table)
    {
        parent::__construct($pdo);
        $this->table = $table;
    }

    public function all()
    {
        return $this->select($this->table)->fetchAll();
    }

    public function find($id)
    {
        return $this->select($this->table, ['*'], 'id = ?')->fetch([$id]);
    }

    public function create($data)
    {
        return $this->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->update($this->table, $data, $id);
    }

    public function delete($id)
    {
        return $this->delete($this->table, $id);
    }
}