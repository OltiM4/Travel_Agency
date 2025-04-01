<?php

$includePath = $_SERVER['DOCUMENT_ROOT'] . '/Travel-Agency/Data/auth/config/config.php';
if (file_exists($includePath)) {
    include $includePath;
} else {
    die("Error: Could not include the database configuration file.");
}


if (!isset($conn)) {
    die("Database connection not established.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user_id = $conn->real_escape_string($_POST['user_id']); 
    $name = $conn->real_escape_string($_POST['name']); 
    $surname = $conn->real_escape_string($_POST['surname']); 
    $email = $conn->real_escape_string($_POST['email']); 
    $phone = $conn->real_escape_string($_POST['phone']); 
    $address = $conn->real_escape_string($_POST['address']); 
    $location = $conn->real_escape_string($_POST['location']); 
    $guests = intval($_POST['guests']); 
    $arrival_date = $conn->real_escape_string($_POST['arrival_date']); 
    $leaving_date = $conn->real_escape_string($_POST['leaving_date']); 

    $sql = "INSERT INTO bookings (user_id, name, surname, email, phone, address, location, guests, arrival_date, leaving_date) VALUES ('$user_id', '$name', '$surname', '$email', '$phone', '$address', '$location', $guests, '$arrival_date', '$leaving_date')";

    if ($conn->query($sql) === TRUE) {
        echo "Rezervimi është shtuar me sukses!";
    } else {
        echo "Gabim: " . $conn->error;
    }

    $conn->close();
}
?>