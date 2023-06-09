<?php
// TODO: Alle waarden op NN zetten, doe ik nu ff niet want anders teveel werk met testen

namespace Isoros\models;

use Isoros\core\Model;
use DateTime;
use PDO;

class Exam extends Model
{
    public ?int $id = null;
    public string $name;
    public ?string $desc;
    public ?string $start_time = null;
    public ?string $end_time = null;
    public ?string $created_at = null;
    public ?string $updated_at = null;

    public function __construct(
        ?int $id,
        string $name,
        ?string $desc,
        ?string $start_time,
        ?string $end_time)
    {
        $this->name = $name;
        $this->desc = $desc === "" ? null : $desc;

        $currentDateTime = date('Y-m-d H:i:s');
        $this->start_time = ($start_time !== null) ? date('Y-m-d H:i:s', strtotime($start_time)) : $currentDateTime;
        $this->end_time = ($end_time !== null) ? date('Y-m-d H:i:s', strtotime($end_time)) : $currentDateTime;

        $this->created_at = $currentDateTime;
        $this->updated_at = $currentDateTime;
        parent::__construct();
    }

    public static function deleteById($id)
    {
        $stmt = self::query("DELETE FROM exam WHERE id = ?", [$id]);
        return true;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getDescription(): ?string {
        return $this->desc;
    }

    public function setDescription(?string $desc): void {
        $this->desc = $desc;
    }

    public function getStartTime(): ?string {
        return $this->start_time;
    }

    public function setStartTime(?string $start_time): void {
        $currentDateTime = date('Y-m-d H:i:s');
        $this->start_time = ($start_time !== null) ? date('Y-m-d H:i:s', strtotime($start_time)) : $currentDateTime;
    }

    public function getEndTime(): ?string {
        return $this->end_time;
    }

    public function setEndTime(?string $end_time): void {
        $currentDateTime = date('Y-m-d H:i:s');
        $this->end_time = ($end_time !== null) ? date('Y-m-d H:i:s', strtotime($end_time)) : $currentDateTime;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function setCreatedAt(?string $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt(): void
    {
        $this->updated_at = date("Y-m-d H:i:s");
    }

    public static function all(): array
    {
        $results = self::query("SELECT * FROM exam");

        return $results;
    }

    public static function findById(int $id)
    {
        $result = self::query("SELECT * FROM exam WHERE id = ?", [$id]);
        $result = $result[0] ?? null;
        if($result){
            $exam = new Exam(
                $result['id'],
                $result['name'],
                $result['desc'],
                $result['start_time'],
                $result['end_time'],
            );
            $exam->setId($result['id']);
            $exam->setCreatedAt($result['created_at']);
            $exam->setUpdatedAt($result['updated_at']);
        }

        return $result ? $exam : null;
    }

    public static function findByName(string $name): ?Exam
    {
        $result = self::query("SELECT * FROM exam WHERE name = ?", [$name]);
        $result = $result[0] ?? null;
        if($result){
            $exam = new Exam(
                $result['id'],
                $result['name'],
                $result['desc'],
                $result['start_time'],
                $result['end_time'],
            );
            $exam->setId($result['id']);
            $exam->setCreatedAt($result['created_at']);
            $exam->setUpdatedAt($result['updated_at']);
        }

        return $result ? $exam : null;
    }

    public function save(): bool
    {
        if (! self::findByName($this->name)) {
            return $this->create();
        }
        return false;
    }

    private function create(): bool
    {
        $stmt = self::query("INSERT INTO exam (name, `desc`, start_time, end_time, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)", [
            $this->name,
            $this->desc,
            $this->start_time,
            $this->end_time,
            $this->created_at,
            $this->updated_at
        ]);
        return true;
    }

    public function update(): bool
    {
        $stmt = self::query("UPDATE exam SET name = ?, `desc` = ?, start_time = ?, end_time = ?, updated_at = ? WHERE id = ?", [
            $this->getName(),
            $this->getDescription(),
            $this->getStartTime(),
            $this->getEndTime(),
            Date('Y-m-d H:i:s'),
            $this->getId()
        ]);

        return true;
    }

    public function exam()
    {
        return $this->belongsToMany(User::class, 'exam_user');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'exam_id');
    }
}

