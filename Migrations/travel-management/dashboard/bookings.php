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
        $message = "Rezervimi u shtua me sukses!";
    } else {
        $message = "Gabim: " . $conn->error;
    }
}


$bookingsQuery = $conn->query("SELECT * FROM bookings");
if (!$bookingsQuery) {
    die("Gabim në marrjen e të dhënave: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../Models/web-design/css/style.css">
    <link rel="stylesheet" href="../../../Models/web-design/css/bookings.css">
    <title>Bookings</title>
</head>

<body>
    <section id="header">
        <div class="header container">
            <div class="nav-bar">
                <div class="brand">
                    <a href="dashboard.php">
                        <h1><span>JO</span>-NA</h1>
                    </a>
                </div>
                <div class="nav-list">
                    <ul>
                    <li><a href="dashboard.php" data-after="Dashboard">Dashboard</a></li>
                        <li><a href="users.php" data-after="Users">Users</a></li>
                        <li><a href="bookings.php" data-after="Bookings">Bookings</a></li>
                        <li><a href="add_flight.php" data-after="Flights">Flights</a></li>
                        <li><a href="traveler.php" data-after="Traveler">Traveler</a></li>
                        <li><a href="/Travel-Agency/Data/auth/config/logout.php" data-after="Logout">Logout</a></li>
                        </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="bookings">
        <div class="bookings container">
            <h1>All Bookings</h1>
            
            <?php if (!empty($message)) { ?>
                <p style="color: green; font-weight: bold;"> <?php echo $message; ?> </p>
            <?php } ?>

            <form method="POST" action="">
                <label for="user_id">User ID:</label>
                <input type="text" name="user_id" required>
                <label for="name">Name:</label>
                <input type="text" name="name" required>
                <label for="surname">Surname:</label>
                <input type="text" name="surname" required>
                <label for="email">Email:</label>
                <input type="email" name="email" required>
                <label for="phone">Phone:</label>
                <input type="text" name="phone" required>
                <label for="address">Address:</label>
                <input type="text" name="address" required>
                <label for="location">Location:</label>
                <input type="text" name="location" required>
                <label for="guests">Guests:</label>
                <input type="number" name="guests" required>
                <label for="arrival_date">Arrival Date:</label>
                <input type="date" name="arrival_date" required>
                <label for="leaving_date">Leaving Date:</label>
                <input type="date" name="leaving_date" required>
                <button type="submit">Add Booking</button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Guests</th>
                        <th>Arrival Date</th>
                        <th>Leaving Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $bookingsQuery->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['surname']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['guests']); ?></td>
                            <td><?php echo htmlspecialchars($row['arrival_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['leaving_date']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

    <section id="footer">
        <div class="footer container">
            <div class="brand">
                <h1><span>JO</span>-NA</h1>
            </div>
            <p>&copy; 2023 JO-NA. All rights reserved</p>
        </div>
    </section>

    <script src="../../../../Models/web-design/js/main.js"></script>
</body>

</html>
