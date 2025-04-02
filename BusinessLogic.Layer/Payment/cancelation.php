<?php

class Cancellation
{

    private $cancellationID;  
    private $bookingID;       
    private $reason;          
    private $cancellationDate; 

    
    public function __construct($cancellationID, $bookingID, $reason, $cancellationDate)
    {
        $this->cancellationID = $cancellationID;
        $this->bookingID = $bookingID;
        $this->reason = $reason;
        $this->cancellationDate = $cancellationDate;
    }

    public function getCancellationID()
    {
        return $this->cancellationID;
    }

    public function setCancellationID($cancellationID)
    {
        $this->cancellationID = $cancellationID;
    }

    public function getBookingID()
    {
        return $this->bookingID;
    }

    public function setBookingID($bookingID)
    {
        $this->bookingID = $bookingID;
    }

    public function getReason()
    {
        return $this->reason;
    }

    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    public function getCancellationDate()
    {
        return $this->cancellationDate;
    }

    public function setCancellationDate($cancellationDate)
    {
        $this->cancellationDate = $cancellationDate;
    }

    public function saveToDatabase($dbConnection)
    {
        $query = "INSERT INTO cancellations (cancellationID, bookingID, reason, cancellationDate) 
                  VALUES (:cancellationID, :bookingID, :reason, :cancellationDate)";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindParam(':cancellationID', $this->cancellationID);
        $stmt->bindParam(':bookingID', $this->bookingID);
        $stmt->bindParam(':reason', $this->reason);
        $stmt->bindParam(':cancellationDate', $this->cancellationDate);
        return $stmt->execute();
    }


    public function updateInDatabase($dbConnection)
    {
        $query = "UPDATE cancellations 
                  SET bookingID = :bookingID, reason = :reason, cancellationDate = :cancellationDate 
                  WHERE cancellationID = :cancellationID";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindParam(':cancellationID', $this->cancellationID);
        $stmt->bindParam(':bookingID', $this->bookingID);
        $stmt->bindParam(':reason', $this->reason);
        $stmt->bindParam(':cancellationDate', $this->cancellationDate);
        return $stmt->execute();
    }

  
    public function deleteFromDatabase($dbConnection)
    {
        $query = "DELETE FROM cancellations WHERE cancellationID = :cancellationID";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindParam(':cancellationID', $this->cancellationID);
        return $stmt->execute();
    }

    public function searchByID($dbConnection, $id)
    {
        $query = "SELECT * FROM cancellations WHERE cancellationID = :cancellationID";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindParam(':cancellationID', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}