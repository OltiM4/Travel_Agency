<?php

class BookingRepository {
    private $context;

    public function __construct($context) {
        $this->context = $context;
    }

    public function createBooking($bookingDto) {
        $sql = "INSERT INTO bookings (customer_id, flight_id, booking_date, number_of_passengers, price) VALUES (:customer_id, :flight_id, :booking_date, :number_of_passengers, :price)";
        $stmt = $this->context->prepare($sql);
        $stmt->bindParam(':customer_id', $bookingDto['customer_id']);
        $stmt->bindParam(':flight_id', $bookingDto['flight_id']);
        $stmt->bindParam(':booking_date', $bookingDto['booking_date']);
        $stmt->bindParam(':number_of_passengers', $bookingDto['number_of_passengers']);
        $stmt->bindParam(':price', $bookingDto['price']);
        return $stmt->execute();
    }


} 

?>