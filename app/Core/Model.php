<?php

use Isoros\Core\Database;
use Psr\Container\ContainerInterface;

abstract class Model
{
    protected $table;
    protected $primaryKey = 'id';
    protected $attributes = [];
    protected $db;
    protected $container;

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container, array $attributes = [])
    {
        $this->container = $container;
        $this->db = $container->get(Database::class);
        $this->attributes = $attributes;
    }

    public function __get($attribute)
    {
        return $this->attributes[$attribute] ?? null;
    }

    public function __set($attribute, $value)
    {
        $this->attributes[$attribute] = $value;
    }

    public static function all(Database $db)
    {
        return (new static($db))->newQuery()->get();
    }

    public static function find(Database $db, $id)
    {
        return (new static($db))->newQuery()->where('id', $id)->first();
    }

    public function save()
    {
        if ($this->exists()) {
            $this->newQuery()->where($this->primaryKey, $this->{$this->primaryKey})->update($this->attributes);
        } else {
            $this->newQuery()->insert($this->attributes);
            $this->{$this->primaryKey} = $this->newQuery()->getLastInsertId();
        }
    }

    public function delete()
    {
        if ($this->exists()) {
            $this->newQuery()->where($this->primaryKey, $this->{$this->primaryKey})->delete();
            $this->attributes = [];
        }
    }

    public function exists()
    {
        return !empty($this->attributes);
    }

    public function newQuery()
    {
        return new QueryBuilder($this->db, $this->table, $this->primaryKey);
    }

    public static function where(Database $db, $column, $operator, $value)
    {
        return (new static($db))->newQuery()->where($column, $operator, $value)->get();
    }

    public static function whereFirst(Database $db, $column, $operator, $value)
    {
        return (new static($db))->newQuery()->where($column, $operator, $value)->first();
    }

    public static function orderBy(Database $db, $column, $direction = 'asc')
    {
        return (new static($db))->newQuery()->orderBy($column, $direction)->get();
    }

    public static function limit(Database $db, $limit)
    {
        return (new static($db))->newQuery()->limit($limit)->get();
    }

    public static function count(Database $db)
    {
        return (new static($db))->newQuery()->count();
    }
}
