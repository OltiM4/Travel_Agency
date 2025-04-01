<?php

class Transaction {
    private $status;

    public function initiate() {
        $this->status = "Initiated";
        echo "Transaction initiated.\n";
    }

    public function complete() {
        $this->status = "Completed";
        echo "Transaction completed.\n";
    }

    public function rollback() {
        $this->status = "Rolled Back";
        echo "Transaction rolled back.\n";
    }

    public function getStatus() {
        return $this->status;
    }
}

?>
