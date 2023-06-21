<?php
// TODO: Alle waarden op NN zetten, doe ik nu ff niet want anders teveel werk met testen
// TODO: ww niet als plain text
// TODO: De manier waarop de query's worden opgesteld kan veiliger worden gemaakt. Momenteel worden variabelen direct in de query geplaatst, wat kan leiden tot SQL injection. Het is beter om prepared statements te gebruiken met placeholders voor de variabelen. Dit voorkomt SQL injection en maakt de applicatie veiliger.
// TODO: De User-klasse zou kunnen worden uitgebreid met meer functionaliteit, zoals bijvoorbeeld een methode om een gebruiker op te zoeken op basis van de naam of emailadres.
// TODO: Het is een goed idee om de timestamps van created_at en updated_at automatisch te genereren, in plaats van ze mee te geven als parameters in de constructor. Dit voorkomt fouten en vereenvoudigt het gebruik van de klasse.

namespace Isoros\models;

use DateTime;
use Isoros\core\Model;
use PDO;
use PDOException;

class User extends Model
{
    protected string $table = 'users';

    public ?int $id = null;
    public string $name;
    public string $email;
    public ?string $password;
    public ?string $role;
    public ?string $remember_token = null;
    public ?string $created_at = null;
    public ?string $updated_at = null;

    public function __construct(
        string $name,
        string $email,
        ?string $password,
        ?string $role,
        ?string $remember_token,
    ) {
        $this->name = $name ;
        $this->email = $email ;
        $this->password = $password ?? null;
        $this->role = $role ?? null;
        $this->remember_token = $remember_token ?? null;
        $this->created_at = Date('Y-m-d H:i:s');
        $this->updated_at = Date('Y-m-d H:i:s');
        parent::__construct();
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function getRememberToken(): ?string
    {
        return $this->remember_token;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }

    // Setters
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function setRole(?string $role): void
    {
        $this->role = $role;
    }

    public function setRememberToken(?string $remember_token): void
    {
        $this->remember_token = $remember_token;
    }

    public function setCreatedAt(?string $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt(?string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    public static function all(): array
    {
        $stmt = self::query("SELECT * FROM users");
        return $stmt;

//        $users = [];
//        foreach ($results as $result) {
//            $users[] = new User(
//                $result['id'],
//                $result['name'],
//                $result['email'],
//                $result['password'],
//                $result['role'],
//                $result['remember_token'] ?? null,
//                $result['created_at']?? null,
//                $result['updated_at']?? null
//            );
//        }
//
//        return $users;
    }

    public static function findById(int $id): ?User
    {
        $result = self::query("SELECT * FROM users WHERE id = ?", [$id]);
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
        $user = null;

        $stmt = self::query("SELECT * FROM users WHERE email = ?", [$email]);

        foreach($stmt as $item){
            $user = new User(
                $item['name'],
                $item['email'],
                $item['password'],
                $item['role'],
                $item['remember_token'],

            );

            $user->setId($item['id']);
            $user->setCreatedAt($item['created_at']);
            $user->setUpdatedAt($item['updated_at']);

        }



        return $stmt ? $user : null;
    }

    public function save(): bool
    {

        if (! self::findByEmail($this->email)) {

            return $this->create();
        }

        return false;
    }

    private function create(): bool
    {
        $result = self::query("INSERT INTO users (name, email, password, role, remember_token, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)", [
            $this->name,
            $this->email,
            $this->password,
            $this->role,
            $this->remember_token,
            $this->created_at,
            $this->updated_at
        ]);

        return true;
    }

    private function update(): bool
    {
        self::query("UPDATE users SET name = ?, email = ?, password = ?, role = ?, remember_token = ?, created_at = ?, updated_at = ? WHERE id = ?", [
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

