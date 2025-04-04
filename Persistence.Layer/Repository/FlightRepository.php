<?php

class FlightRepository {
    private $context;

    public function __construct($context) {
        $this->context = $context;
    }

    public function createFlight($flightDto) {
        $sql = "INSERT INTO flights (flight_number, departure_location, arrival_location, departure_time, arrival_time, price) VALUES (:flight_number, :departure_location, :arrival_location, :departure_time, :arrival_time, :price)";
        $stmt = $this->context->prepare($sql);
        $stmt->bindParam(':flight_number', $flightDto['flight_number']);
        $stmt->bindParam(':departure_location', $flightDto['departure_location']);
        $stmt->bindParam(':arrival_location', $flightDto['arrival_location']);
        $stmt->bindParam(':departure_time', $flightDto['departure_time']);
        $stmt->bindParam(':arrival_time', $flightDto['arrival_time']);
        $stmt->bindParam(':price', $flightDto['price']);
        return $stmt->execute();
    }


}

?>