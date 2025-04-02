<?php
class Agent {
    private $agentID;
    private $agencyID;
    private $name;
    private $email;
    private $phone;
    private $specialization;

    public function __construct($agentID, $agencyID, $name, $email, $phone, $specialization) {
        $this->agentID = $agentID;
        $this->agencyID = $agencyID;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->specialization = $specialization;
    }

    public function getAgentID() {
        return $this->agentID;
    }

    public function getAgencyID() {
        return $this->agencyID;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getSpecialization() {
        return $this->specialization;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function setSpecialization($specialization) {
        $this->specialization = $specialization;
    }

    public function addBookingForCustomer($customerID, $bookingDetails) {

        echo "Booking added for customer $customerID.";
    }

    public function assistCustomer($customerID) {
        echo "Assisting customer $customerID.";
    }

    public function viewBookings() {
        echo "Displaying bookings for agent $this->agentID.";
    }
}
?>