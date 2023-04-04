<?php
// TODO: Alle waarden op NN zetten, doe ik nu ff niet want anders teveel werk met testen
// TODO: ww niet als plain text
// TODO: De manier waarop de query's worden opgesteld kan veiliger worden gemaakt. Momenteel worden variabelen direct in de query geplaatst, wat kan leiden tot SQL injection. Het is beter om prepared statements te gebruiken met placeholders voor de variabelen. Dit voorkomt SQL injection en maakt de applicatie veiliger.
// TODO: De User-klasse zou kunnen worden uitgebreid met meer functionaliteit, zoals bijvoorbeeld een methode om een gebruiker op te zoeken op basis van de naam of emailadres.
// TODO: Het is een goed idee om de timestamps van created_at en updated_at automatisch te genereren, in plaats van ze mee te geven als parameters in de constructor. Dit voorkomt fouten en vereenvoudigt het gebruik van de klasse.

namespace Isoros\Models;

class User {
    private $db;

    public $id;
    public $name;
    public $email;
    public $password;
    public $role;
    public $remember_token;
    public $created_at;
    public $updated_at;

    public function __construct($db, $name, $email, $password, $role, $remember_token) {
        $this->db = $db;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->remember_token = $remember_token;

    }

    public function registerStudent($name, $email, $password) {
        $student = new Student();
        $student->name = $name;
        $student->email = $email;
        $student->password = password_hash($password, PASSWORD_DEFAULT);
        $student->save();
        return $student;
    }

    public function enrollInExam($studentId, $examId) {
        $student = $this->find($studentId);
        if ($student) {
            $student->exams()->attach($examId);
            return $student;
        }
        return null;
    }

    public function getGrades($studentId) {
        $student = $this->find($studentId);
        if ($student) {
            return $student->grades;
        }
        return null;
    }
}

