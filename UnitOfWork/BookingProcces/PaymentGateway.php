<?php

class PaymentGateway {
    private $connected;

    public function connect() {
        $this->connected = true;
        echo "Connected to payment gateway.\n";
    }

    public function disconnect() {
        $this->connected = false;
        echo "Disconnected from payment gateway.\n";
    }

    public function authorize($amount) {
        if ($this->connected) {
            echo "Payment of {$amount}€ authorized.\n";
            return true;
        }
        echo "Payment gateway not connected. Authorization failed.\n";
        return false;
    }

    public function capturePayment($amount) {
        if ($this->connected) {
            echo "Payment of {$amount}€ captured.\n";
            return true;
        }
        echo "Payment gateway not connected. Payment capture failed.\n";
        return false;
    }
}

?>