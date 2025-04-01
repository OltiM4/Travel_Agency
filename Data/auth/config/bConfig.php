<?php


include __DIR__ . '/../auth/config/config.php'; 


session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../web-design/pages/login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $user_id = $_SESSION['user_id'];

    $user_query = "SELECT name, surname, email FROM users WHERE id = ?";
    $stmt = $conn->prepare($user_query);
    if (!$stmt) {
        die("Gabim në përgatitjen e pyetjes: " . $conn->error);
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();

    if ($user_data) {
     
        $name = $user_data['name'];
        $surname = $user_data['surname'];
        $email = $user_data['email'];

        
        $phone = $conn->real_escape_string($_POST['phone']);
        $guests = intval($_POST['guests']);
        $arrival_date = $conn->real_escape_string($_POST['arrivals']);
        $leaving_date = $conn->real_escape_string($_POST['leaving']);
        $location = $conn->real_escape_string($_POST['location']);
        $address = $conn->real_escape_string($_POST['address']);

     
        $stmt = $conn->prepare(
            "INSERT INTO bookings (user_id, name, surname, email, phone, guests, arrival_date, leaving_date, location, address) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        if (!$stmt) {
            die("Gabim në përgatitjen e pyetjes: " . $conn->error);
        }
        $stmt->bind_param("issssiisss", $user_id, $name, $surname, $email, $phone, $guests, $arrival_date, $leaving_date, $location, $address);

        if ($stmt->execute()) {
            echo "Rezervimi u bë me sukses!";
        } else {
            echo "Gabim: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Gabim: Nuk u gjetën të dhënat e përdoruesit!";
    }

    
    $conn->close();
}

?>
