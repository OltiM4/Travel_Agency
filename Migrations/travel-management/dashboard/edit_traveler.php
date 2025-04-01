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

$message = "";


if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM travelers WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $traveler = $result->fetch_assoc();
    $stmt->close();

    
    if (!$traveler) {
        die("Error: No traveler found with the provided ID.");
    }
} else {
    die("Error: No traveler ID provided.");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = trim($_POST['customer_id']);
    $passport_number = trim($_POST['passport_number']);
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if (!empty($customer_id) && !empty($passport_number) && !empty($name) && !empty($surname) && !empty($email) && !empty($phone)) {
        $stmt = $conn->prepare("UPDATE travelers SET customer_id = ?, passport_number = ?, name = ?, surname = ?, email = ?, phone = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $customer_id, $passport_number, $name, $surname, $email, $phone, $id);
        if ($stmt->execute()) {
            $message = "Traveler updated successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "All fields are required.";
    }
}
?>
