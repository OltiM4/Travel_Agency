<?php

class Customer
{
    // Atributet
    private $customerID; // Primary Key
    private $name;
    private $email;
    private $phone;
    private $roleID; // Foreign Key (UserRole)

    // Konstruktori
    public function __construct($customerID, $name, $email, $phone, $roleID)
    {
        $this->customerID = $customerID;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->roleID = $roleID;
    }

    // Metoda per marrjen e te dhenave (getters)
    public function getCustomerID()
    {
        return $this->customerID;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getRoleID()
    {
        return $this->roleID;
    }

    // Metoda per vendosjen e te dhenave (setters)
    public function setName($name)
    {
        $this->name = $name;
    }

    public function setEmail($email)
    {
        if ($this->validateEmail($email)) {
            $this->email = $email;
        } else {
            throw new Exception("Invalid email format");
        }
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function setRoleID($roleID)
    {
        $this->roleID = $roleID;
    }

    // Metoda per te ruajtur nje klient ne databaze (Create)
    public function saveToDatabase($dbConnection)
    {
        $query = "INSERT INTO customers (customerID, name, email, phone, roleID) 
                  VALUES (:customerID, :name, :email, :phone, :roleID)";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindParam(':customerID', $this->customerID);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':roleID', $this->roleID);
        $stmt->execute();
    }

    // Metoda per perditesimin e klientit (Update)
    public function updateInDatabase($dbConnection)
    {
        $query = "UPDATE customers 
                  SET name = :name, email = :email, phone = :phone, roleID = :roleID 
                  WHERE customerID = :customerID";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':roleID', $this->roleID);
        $stmt->bindParam(':customerID', $this->customerID);
        $stmt->execute();
    }

    // Metoda per fshirjen e klientit (Delete)
    public function deleteFromDatabase($dbConnection)
    {
        $query = "DELETE FROM customers WHERE customerID = :customerID";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindParam(':customerID', $this->customerID);
        $stmt->execute();
    }

    // Metoda per validimin e email-it
    private function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    // Metoda per shfaqjen e te dhenave te klientit (Read)
    public function displayCustomerDetails()
    {
        return "Customer ID: {$this->customerID}, Name: {$this->name}, Email: {$this->email}, Phone: {$this->phone}, Role ID: {$this->roleID}";
    }
}

?>
