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

    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $user_type = intval($_POST['user_type']); 

    
    if (empty($name) || empty($surname) || empty($email) || empty($password)) {
        die("Të gjitha fushat janë të detyrueshme!");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email-i nuk është i vlefshëm!");
    }

    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    
    $sql = "INSERT INTO users (name, surname, email, password, user_type) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Gabim në përgatitjen e pyetjes: " . $conn->error);
    }

    
    $stmt->bind_param("ssssi", $name, $surname, $email, $hashed_password, $user_type);

    if ($stmt->execute()) {
        echo "Përdoruesi është shtuar me sukses!";
    } else {
        echo "Gabim gjatë shtimit të përdoruesit: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>