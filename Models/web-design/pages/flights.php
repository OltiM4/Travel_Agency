<?php
session_start();
include '../../../Data/auth/config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../Data/auth/login.php");
    exit();
}

$flightsQuery = $conn->query("SELECT * FROM flights");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'reserve') {
        $flight_id = $_POST['flight_id'];
        $user_id = $_SESSION['user_id'];

        $stmt = $conn->prepare("INSERT INTO bookings (user_id, flight_id, booking_status) VALUES (?, ?, 'reserved')");
        $stmt->bind_param("ii", $user_id, $flight_id);
        $stmt->execute();
        $message = "Flight reserved successfully!";
    }

    if (isset($_POST['action']) && $_POST['action'] == 'cancel') {
        $booking_id = $_POST['booking_id'];
        $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $booking_id, $_SESSION['user_id']);
        $stmt->execute();
        $message = "Reservation canceled successfully!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/flights.css">
    <title>Flights</title>
</head>
<body>
<section id="header">
    <div class="header container">
        <div class="nav-bar">
            <div class="brand">
                <a href="index.php"><h1>JO-NA</h1></a>
            </div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#flights">Flights</a></li>
                <li><a href="../../../Data/auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</section>

<section id="flights">
    <div class="container">
        <h1>Available Flights</h1>
        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
        <div class="flights">
            <table>
                <thead>
                    <tr>
                        <th>Flight Number</th>
                        <th>Departure</th>
                        <th>Arrival</th>
                        <th>Departure Time</th>
                        <th>Arrival Time</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $flightsQuery->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['flight_number']; ?></td>
                            <td><?= $row['departure_location']; ?></td>
                            <td><?= $row['arrival_location']; ?></td>
                            <td><?= $row['departure_time']; ?></td>
                            <td><?= $row['arrival_time']; ?></td>
                            <td><?= $row['price']; ?> €</td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="flight_id" value="<?= $row['id']; ?>">
                                    <button type="submit" name="action" value="reserve">Reserve</button>
                                </form>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="booking_id" value="<?= $row['id']; ?>">
                                    <button type="submit" name="action" value="cancel">Cancel</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<section id="footer">
    <div class="footer container">
        <div class="brand">
            <h1>JO-NA</h1>
        </div>
        <p>&copy; 2023 JO-NA Travel. All rights reserved.</p>
    </div>
</section>
</body>
</html>
