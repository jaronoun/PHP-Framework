<?php

namespace Isoros\core;

use InvalidArgumentException;
use Isoros\controllers\api\ExamRepository;
use Isoros\controllers\api\Repository;
use Isoros\controllers\api\UserRepository;
use PDO;
use PDOStatement;
use Psr\Container\ContainerInterface;

class Model
{
    private PDO $connection;


    public function __construct()
    {
        $this->connection = Database::connect();

    }

    protected static function query(string $sql, array $params = []): array
    {
        $stmt = Database::connect()->prepare($sql);

        foreach ($params as $index => $value) {
            $paramIndex = is_int($index) ? $index + 1 : $index;
            if ($paramIndex < 1) {
                throw new InvalidArgumentException("Parameter index must be greater than or equal to 1.");
            }
            $stmt->bindValue($paramIndex, $value);

        }

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
//        $results = [];
//
//        foreach($data as $item){
//            array_push($results, $item);
//        }

        return $data;
    }

    public function hasOne(string $relatedModel, ?string $foreignKey = null): ?array
    {
        $relatedTable = (new $relatedModel)->table;
        $foreignKey = $foreignKey ?? $this->table . '_id';
        $stmt = $this->query("SELECT * FROM $relatedTable WHERE id = ?", [$this->$foreignKey]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? array_map('htmlspecialchars', $result) : null;
    }

    public function hasMany(string $relatedModel, ?string $foreignKey = null): ?array
    {
        $relatedTable = (new $relatedModel)->table;
        $foreignKey = $foreignKey ?? $this->table . '_id';
        return $this->query("SELECT * FROM $relatedTable WHERE $foreignKey = ?", [$this->id])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function belongsTo(string $relatedModel, ?string $foreignKey = null): ?array
    {
        $relatedTable = (new $relatedModel)->table;
        $foreignKey = $foreignKey ?? $relatedTable . '_id';
        return $this->query("SELECT * FROM $relatedTable WHERE id = ?", [$this->$foreignKey])->fetch(PDO::FETCH_ASSOC);
    }

    public function belongsToMany(string $relatedModel, string $joinTable, ?string $foreignKey = null, ?string $relatedKey = null): ?array
    {
        $relatedTable = (new $relatedModel)->table;
        $foreignKey = $foreignKey ?? $this->table . '_id';
        $relatedKey = $relatedKey ?? $relatedTable . '_id';
        $joinTable = $joinTable ?? $this->table . '_' . $relatedTable;
        return $this->query("SELECT $relatedTable.* FROM $relatedTable JOIN $joinTable ON $relatedTable.id = $joinTable.$relatedKey WHERE $joinTable.$foreignKey = ?", [$this->id])->fetchAll(PDO::FETCH_ASSOC);
    }
}
