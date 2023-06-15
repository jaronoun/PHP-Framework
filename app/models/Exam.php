<?php
// TODO: Alle waarden op NN zetten, doe ik nu ff niet want anders teveel werk met testen

namespace Isoros\models;

use Isoros\core\Model;
use DateTime;
use PDO;

class Exam extends Model{
    public ?int $id = null;
    public string $name;
    public ?string $desc;
    public ?string $start_time = null;
    public ?string $end_time = null;
    public ?string $created_at = null;
    public ?string $updated_at = null;

    public function __construct(
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

    public function getStartTime(): ?DateTime {
        return $this->start_time;
    }

    public function setStartTime(?DateTime $start_time): void {
        $this->start_time = $start_time;
    }

    public function getEndTime(): ?DateTime {
        return $this->end_time;
    }

    public function setEndTime(?DateTime $end_time): void {
        $this->end_time = $end_time;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(?DateTime $created_at): void {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?DateTime $updated_at): void {
        $this->updated_at = $updated_at;
    }

    public static function all(): array
    {
        $stmt = self::query("SELECT * FROM exam");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public static function findById(int $id): ?Exam
    {
        $stmt = self::query("SELECT * FROM exam WHERE id = ?", [$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result){
            $exam = new Exam($result['name'],
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
        $stmt = self::query("SELECT * FROM exam WHERE name = ?", [$name]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result){
            $exam = new Exam($result['name'],
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

    private function update(): bool
    {
        $stmt = self::query("UPDATE exam SET name = ?, desc = ?, start_time = ?, end_time = ?, updated_at = ? WHERE id = ?", [
            $this->getName()  ,
            $this->getDescription(),
            $this->getStartTime(),
            $this->getEndTime(),
            Date('Y-m-d H:i:s'),
            $this->getId()
        ]);

        return true;
    }

    public function delete(): bool
    {
        $stmt = self::query("DELETE FROM exam WHERE id = ?", [$this->id]);
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

