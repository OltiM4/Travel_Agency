<?php

class User {
    private $id;
    private $name;
    private $email;

    public function __construct($id, $name, $email) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public function create() {
        echo "User {$this->name} created.\n";
    }

    public function update($newName, $newEmail) {
        $this->name = $newName;
        $this->email = $newEmail;
        echo "User {$this->id} updated.\n";
    }

    public function delete() {
        echo "User {$this->id} deleted.\n";
    }

    public function viewProfile() {
        return "ID: {$this->id}, Name: {$this->name}, Email: {$this->email}";
    }
}

?>