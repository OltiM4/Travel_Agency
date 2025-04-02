<?php

class Invoice {
    private $id;
    private $amount;

    public function __construct($id, $amount) {
        $this->id = $id;
        $this->amount = $amount;
    }

    public function generate() {
        echo "Invoice {$this->id} generated for amount: {$this->amount}€.\n";
    }

    public function send() {
        echo "Invoice {$this->id} sent.\n";
    }

    public function delete() {
        echo "Invoice {$this->id} deleted.\n";
    }

    public function viewProfile() {
        return "Invoice ID: {$this->id}, Amount: {$this->amount}€";
    }
}

?>
