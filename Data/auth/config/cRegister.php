<?php
include 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $conn->real_escape_string($_POST['name']);
    $surname = $conn->real_escape_string($_POST['surname']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $user_type = 0; 

    if (empty($name) || empty($surname) || empty($email) || empty($password)) {
        echo "<script>alert('Ju lutem plotësoni të gjitha fushat!'); window.location.href='register.php';</script>";
        exit();
    }

   
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $sql = "INSERT INTO users (name, surname, email, password, user_type) VALUES ('$name', '$surname', '$email', '$hashed_password', '$user_type')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Regjistrimi u krye me sukses!');</script>";
        header("Location: ../../../Models/web-design/pages/login.php");
        exit();
    } else {
        echo "Gabim: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
