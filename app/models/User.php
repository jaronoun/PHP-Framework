<?php
// TODO: Alle waarden op NN zetten, doe ik nu ff niet want anders teveel werk met testen
// TODO: ww niet als plain text
// TODO: De manier waarop de query's worden opgesteld kan veiliger worden gemaakt. Momenteel worden variabelen direct in de query geplaatst, wat kan leiden tot SQL injection. Het is beter om prepared statements te gebruiken met placeholders voor de variabelen. Dit voorkomt SQL injection en maakt de applicatie veiliger.
// TODO: De User-klasse zou kunnen worden uitgebreid met meer functionaliteit, zoals bijvoorbeeld een methode om een gebruiker op te zoeken op basis van de naam of emailadres.
// TODO: Het is een goed idee om de timestamps van created_at en updated_at automatisch te genereren, in plaats van ze mee te geven als parameters in de constructor. Dit voorkomt fouten en vereenvoudigt het gebruik van de klasse.

namespace Isoros\models;

use Isoros\core\Model;
use PDO;

class User extends Model
{
    protected string $table = 'users';

    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public string $role;
    public ?string $remember_token;
    public string $created_at;
    public string $updated_at;

    public function __construct(
        int $id,
        string $name,
        string $email,
        string $password,
        string $role,
        ?string $remember_token,
        string $created_at,
        string $updated_at
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->remember_token = $remember_token;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        parent::__construct();
    }

    public static function all(): array
    {
        $stmt = self::query("SELECT * FROM users");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($results as $result) {
            $users[] = new User(
                $result['id'],
                $result['name'],
                $result['email'],
                $result['password'],
                $result['role'],
                $result['remember_token'],
                $result['created_at'],
                $result['updated_at']
            );
        }

        return $users;
    }

    public static function findById(int $id): ?User
    {
        $stmt = self::query("SELECT * FROM users WHERE id = ?", [$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? new User(
            $result['id'],
            $result['name'],
            $result['email'],
            $result['password'],
            $result['role'],
            $result['remember_token'],
            $result['created_at'],
            $result['updated_at']
        ) : null;
    }

    public static function findByEmail(string $email): ?User
    {
        $stmt = self::query("SELECT * FROM users WHERE email = ?", [$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? new User(
            $result['id'],
            $result['name'],
            $result['email'],
            $result['password'],
            $result['role'],
            $result['remember_token'],
            $result['created_at'],
            $result['updated_at']
        ) : null;
    }

    public function save(): bool
    {
        if (!$this->id) {
            return $this->create();
        }
        return $this->update();
    }

    private function create(): bool
    {
        $stmt = self::query("INSERT INTO users (name, email, password, role, remember_token, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)", [
            $this->name,
            $this->email,
            $this->password,
            $this->role,
            $this->remember_token,
            $this->created_at,
            $this->updated_at
        ]);
        $this->id = self::lastInsertId();
        return true;
    }

    private function update(): bool
    {
        $stmt = self::query("UPDATE users SET name = ?, email = ?, password = ?, role = ?, remember_token = ?, created_at = ?, updated_at = ? WHERE id = ?", [
            $this->name,
            $this->email,
            $this->password,
            $this->role,
            $this->remember_token,
            $this->created_at,
            $this->updated_at,
            $this->id
        ]);
        return true;
    }

    public function delete(): bool
    {
        $stmt = self::query("DELETE FROM users WHERE id = ?", [$this->id]);
        return true;
    }
}

