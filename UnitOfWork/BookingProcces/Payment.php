<?php

class Payment {
    private $amount;
    private $isPaid;

    public function __construct($amount) {
        $this->amount = $amount;
        $this->isPaid = false;
    }

    public function process() {
        $this->isPaid = true;
        echo "Payment processed for amount: " . $this->amount . "€\n";
    }

    public function refund() {
        if ($this->isPaid) {
            $this->isPaid = false;
            echo "Payment refunded for amount: " . $this->amount . "€\n";
        } else {
            echo "Payment not processed yet, refund not possible.\n";
        }
    }

    public function isPaid() {
        return $this->isPaid;
    }
}

?>
