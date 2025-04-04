<?php

class ReservationRepository implements IRepository
{
    private $context;

    public function __construct($context)
    {
        $this->context = $context;
    }

   
    public function getAllReservations()
    {
        return $this->context->query("SELECT * FROM reservations");
    }


    public function getReservationById($id)
    {
        return $this->context->query("SELECT * FROM reservations WHERE id = ?", [$id]);
    }

    
    public function addReservation($reservation)
    {
        return $this->context->execute("INSERT INTO reservations (user_id, hotel_id, package_id, start_date, end_date, total_price) VALUES (?, ?, ?, ?, ?, ?)",
            [
                $reservation->user_id,
                $reservation->hotel_id,
                $reservation->package_id,
                $reservation->start_date,
                $reservation->end_date,
                $reservation->total_price
            ]);
    }

    
    public function updateReservation($reservation)
    {
        return $this->context->execute("UPDATE reservations SET user_id = ?, hotel_id = ?, package_id = ?, start_date = ?, end_date = ?, total_price = ? WHERE id = ?",
            [
                $reservation->user_id,
                $reservation->hotel_id,
                $reservation->package_id,
                $reservation->start_date,
                $reservation->end_date,
                $reservation->total_price,
                $reservation->id
            ]);
    }

    
    public function deleteReservation($id)
    {
        return $this->context->execute("DELETE FROM reservations WHERE id = ?", [$id]);
    }
}
