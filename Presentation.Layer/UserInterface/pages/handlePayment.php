<?php

class Payment {
    private $paymentID; 
    private $bookingID; 
    private $amount; 
    private $paymentDate; 
    private $paymentMethod; 
    private $paymentStatus; 

    
    public function __construct($paymentID, $bookingID, $amount, $paymentDate, $paymentMethod, $paymentStatus) {
        $this->paymentID = $paymentID;
        $this->bookingID = $bookingID;
        $this->amount = $amount;
        $this->paymentDate = $paymentDate;
        $this->paymentMethod = $paymentMethod;
        $this->paymentStatus = $paymentStatus;
    }

    // Kjo eshte metoda per procesimin e pageses 
    public function processPayment() {
        if ($this->paymentStatus === "Pending") {
            $this->paymentStatus = "Completed";
            echo "Payment processed successfully.\n";
        } else {
            echo "Payment already processed or invalid status.\n";
        }
    }

    // Metoda per rimburesimin e pageses 
    public function refundPayment() {
        if ($this->paymentStatus === "Completed") {
            $this->paymentStatus = "Refunded";
            echo "Payment refunded successfully.\n";
        } else {
            echo "Refund cannot be processed. Payment status: $this->paymentStatus\n";
        }
    }

    // Metoda per me i pa detajet e pageses 
    public function viewPaymentDetails() {
        return [
            "Payment ID" => $this->paymentID,
            "Booking ID" => $this->bookingID,
            "Amount" => $this->amount,
            "Payment Date" => $this->paymentDate,
            "Payment Method" => $this->paymentMethod,
            "Payment Status" => $this->paymentStatus
        ];
    }

    // Getat dhe Setat 
    public function getPaymentID() {
        return $this->paymentID;
    }

    public function setPaymentID($paymentID) {
        $this->paymentID = $paymentID;
    }

    public function getBookingID() {
        return $this->bookingID;
    }

    public function setBookingID($bookingID) {
        $this->bookingID = $bookingID;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function getPaymentDate() {
        return $this->paymentDate;
    }

    public function setPaymentDate($paymentDate) {
        $this->paymentDate = $paymentDate;
    }

    public function getPaymentMethod() {
        return $this->paymentMethod;
    }

    public function setPaymentMethod($paymentMethod) {
        $this->paymentMethod = $paymentMethod;
    }

    public function getPaymentStatus() {
        return $this->paymentStatus;
    }

    public function setPaymentStatus($paymentStatus) {
        $this->paymentStatus = $paymentStatus;
    }
}

?>