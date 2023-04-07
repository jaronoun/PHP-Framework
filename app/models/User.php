<?php
// TODO: Alle waarden op NN zetten, doe ik nu ff niet want anders teveel werk met testen
// TODO: ww niet als plain text
// TODO: De manier waarop de query's worden opgesteld kan veiliger worden gemaakt. Momenteel worden variabelen direct in de query geplaatst, wat kan leiden tot SQL injection. Het is beter om prepared statements te gebruiken met placeholders voor de variabelen. Dit voorkomt SQL injection en maakt de applicatie veiliger.
// TODO: De User-klasse zou kunnen worden uitgebreid met meer functionaliteit, zoals bijvoorbeeld een methode om een gebruiker op te zoeken op basis van de naam of emailadres.
// TODO: Het is een goed idee om de timestamps van created_at en updated_at automatisch te genereren, in plaats van ze mee te geven als parameters in de constructor. Dit voorkomt fouten en vereenvoudigt het gebruik van de klasse.

namespace Isoros\models;

use Isoros\core\Model;
use PDO;

class User extends Model {

    protected $id;
    protected $name;
    protected $email;
    protected $password;
    protected $role;

    public function getAll() {
        $stmt = $this->db->query('SELECT * FROM user');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare('SELECT * FROM user WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $desc, $start_time, $end_time) {
        $stmt = $this->db->prepare('INSERT INTO user (name, desc, start_time, end_time, created_at) VALUES (:name, :desc, :start_time, :end_time, NOW())');
        $stmt->execute(['name' => $name, 'desc' => $desc, 'start_time' => $start_time, 'end_time' => $end_time]);
        return $this->getById($this->db->lastInsertId());
    }

    public function update($id, $name, $desc, $start_time, $end_time) {
        $stmt = $this->db->prepare('UPDATE user SET name = :name, desc = :desc, start_time = :start_time, end_time = :end_time, updated_at = NOW() WHERE id = :id');
        $stmt->execute(['id' => $id, 'name' => $name, 'desc' => $desc, 'start_time' => $start_time, 'end_time' => $end_time]);
        return $this->getById($id);
    }

    public static function all()
    {
        return self::query("SELECT * FROM `users`")->fetchAll();
    }

    public static function find($id)
    {
        return self::query("SELECT * FROM `users` WHERE `id` = :id", [':id' => $id])->fetch();
    }

    public function save()
    {
        $now = date('Y-m-d H:i:s');

        if (isset($this->id)) {
            $sql = "UPDATE `users` SET `name` = :name, `email` = :email, `password` = :password, `role` = :role, `updated_at` = :updated_at WHERE `id` = :id";
            $params = [
                ':id' => $this->id,
                ':name' => $this->name,
                ':email' => $this->email,
                ':password' => $this->password,
                ':role' => $this->role,
                ':updated_at' => $now
            ];
        } else {
            $sql = "INSERT INTO `users` (`name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES (:name, :email, :password, :role, :created_at, :updated_at)";
            $params = [
                ':name' => $this->name,
                ':email' => $this->email,
                ':password' => $this->password,
                ':role' => $this->role,
                ':created_at' => $now,
                ':updated_at' => $now
            ];
        }

        return self::query($sql, $params);
    }

    public function delete()
    {
        if (isset($this->id)) {
            return self::query("DELETE FROM `users` WHERE `id` = :id", [':id' => $this->id]);
        }

        return false;
    }


}

