<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_database";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Lidhja me bazën e të dhënave dështoi: " . $conn->connect_error);
}
?>
