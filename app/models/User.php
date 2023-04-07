<?php
// TODO: Alle waarden op NN zetten, doe ik nu ff niet want anders teveel werk met testen
// TODO: ww niet als plain text
// TODO: De manier waarop de query's worden opgesteld kan veiliger worden gemaakt. Momenteel worden variabelen direct in de query geplaatst, wat kan leiden tot SQL injection. Het is beter om prepared statements te gebruiken met placeholders voor de variabelen. Dit voorkomt SQL injection en maakt de applicatie veiliger.
// TODO: De User-klasse zou kunnen worden uitgebreid met meer functionaliteit, zoals bijvoorbeeld een methode om een gebruiker op te zoeken op basis van de naam of emailadres.
// TODO: Het is een goed idee om de timestamps van created_at en updated_at automatisch te genereren, in plaats van ze mee te geven als parameters in de constructor. Dit voorkomt fouten en vereenvoudigt het gebruik van de klasse.

namespace Isoros\models;

use DateTime;

class User {
    private $conn;

    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public string $role;
    public ?string $remember_token;
    public ?DateTime $created_at;
    public ?DateTime $updated_at;

    public function __construct($db, $name, $email, $password, $role, $remember_token) {
        $this->conn = $db;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->remember_token = $remember_token;

    }


}

