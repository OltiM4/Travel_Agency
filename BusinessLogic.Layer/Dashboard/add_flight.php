<?php

$includePath = $_SERVER['DOCUMENT_ROOT'] . '/Travel_Agency/DataAccess.Layer/Config/config.php';
if (file_exists($includePath)) {
    include $includePath;
} else {
    die("Error: Could not include the database configuration file.");
}

if (!isset($conn)) {
    die("Database connection not established.");
}

class FlightManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Metoda per me shtu nje fluturim te ri 
    public function schedule($flight_number, $departure_location, $arrival_location, $departure_time, $arrival_time, $price) {
        $stmt = $this->conn->prepare("INSERT INTO flights (flight_number, departure_location, arrival_location, departure_time, arrival_time, price) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssd", $flight_number, $departure_location, $arrival_location, $departure_time, $arrival_time, $price);

        if ($stmt->execute()) {
            return "Flight added successfully!";
        } else {
            return "Error: " . $this->conn->error;
        }
    }

    // Metoda me i marr te gjithe fluturimet ekzistuse 
    public function getFlights() {
        $query = "SELECT * FROM flights";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $flights = [];
            while ($row = $result->fetch_assoc()) {
                $flights[] = $row;
            }
            return $flights;
        } else {
            return [];
        }
    }

    // Metoda per me fshi nje fluturim 
    public function deleteFlight($flight_id) {
        $stmt = $this->conn->prepare("DELETE FROM flights WHERE id = ?");
        $stmt->bind_param("i", $flight_id);

        if ($stmt->execute()) {
            return "Flight deleted successfully!";
        } else {
            return "Error: " . $this->conn->error;
        }
    }

    // Perditsimi i nje fluturimi 
    public function updateFlight($flight_id, $flight_number, $departure_location, $arrival_location, $departure_time, $arrival_time, $price) {
        $stmt = $this->conn->prepare("UPDATE flights SET flight_number = ?, departure_location = ?, arrival_location = ?, departure_time = ?, arrival_time = ?, price = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $flight_number, $departure_location, $arrival_location, $departure_time, $arrival_time, $price, $flight_id);

        if ($stmt->execute()) {
            return "Flight updated successfully!";
        } else {
            return "Error: " . $this->conn->error;
        }
    }
}

$flightManager = new FlightManager($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add') {
            $flight_number = $_POST['flight_number'];
            $departure_location = $_POST['departure_location'];
            $arrival_location = $_POST['arrival_location'];
            $departure_time = $_POST['departure_time'];
            $arrival_time = $_POST['arrival_time'];
            $price = $_POST['price'];

            $message = $flightManager->schedule($flight_number, $departure_location, $arrival_location, $departure_time, $arrival_time, $price);
        } elseif ($action === 'delete') {
            $flight_id = $_POST['flight_id'];
            $message = $flightManager->deleteFlight($flight_id);
        } elseif ($action === 'update') {
            $flight_id = $_POST['flight_id'];
            $flight_number = $_POST['flight_number'];
            $departure_location = $_POST['departure_location'];
            $arrival_location = $_POST['arrival_location'];
            $departure_time = $_POST['departure_time'];
            $arrival_time = $_POST['arrival_time'];
            $price = $_POST['price'];

            $message = $flightManager->updateFlight($flight_id, $flight_number, $departure_location, $arrival_location, $departure_time, $arrival_time, $price);
        }
    }
}

// Lista e fluturimeve 
$flights = $flightManager->getFlights();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Flights</title>
    <link rel="stylesheet" href="/Travel_Agency/Presentation.Layer/UserInterface/css/flights.css">
    <script>
        function editFlight(flight) {
            document.querySelector('input[name="flight_id"]').value = flight.id;
            document.querySelector('input[name="flight_number"]').value = flight.flight_number;
            document.querySelector('input[name="departure_location"]').value = flight.departure_location;
            document.querySelector('input[name="arrival_location"]').value = flight.arrival_location;
            document.querySelector('input[name="departure_time"]').value = flight.departure_time;
            document.querySelector('input[name="arrival_time"]').value = flight.arrival_time;
            document.querySelector('input[name="price"]').value = flight.price;
            document.querySelector('button[type="submit"]').innerText = "Update Flight";
            document.querySelector('input[name="action"]').value = "update";
        }
    </script>
</head>
<body>
<section id="header">
    <div class="header container">
        <div class="nav-bar">
            <div class="brand">
                <a href="dashboard.php"><h1><span>JO</span>-NA</h1></a>
            </div>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="bookings.php">Bookings</a></li>
                <li><a href="add_flight.php">Flights</a></li>
                <li><a href="traveler.php">Traveler</a></li>
                <li><a href="hotelManagement.php">Hotels</a></li>
                <li><a href="viewpayments.php">View Payments</a></li>
                <li><a href="/Travel_Agency/DataAccess.Layer/Config/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</section>

<section id="add-flight">
    <div class="container">
        <h1>Manage Flights</h1>
        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
        <form method="POST" class="flights-form">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="flight_id">
            <input type="text" name="flight_number" placeholder="Flight Number" required>
            <input type="text" name="departure_location" placeholder="Departure Location" required>
            <input type="text" name="arrival_location" placeholder="Arrival Location" required>
            <input type="datetime-local" name="departure_time" required>
            <input type="datetime-local" name="arrival_time" required>
            <input type="number" name="price" placeholder="Price" required>
            <button type="submit">Add Flight</button>
        </form>
    </div>
</section>

<section id="schedule">
    <div class="container">
        <h1>Flight Schedule</h1>
        <table>
            <thead>
                <tr>
                    <th>Flight Number</th>
                    <th>Departure</th>
                    <th>Arrival</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($flights)): ?>
                    <?php foreach ($flights as $flight): ?>
                    <tr>
                        <td><?= htmlspecialchars($flight['flight_number']); ?></td>
                        <td><?= htmlspecialchars($flight['departure_location']); ?></td>
                        <td><?= htmlspecialchars($flight['arrival_location']); ?></td>
                        <td><?= htmlspecialchars($flight['departure_time']); ?></td>
                        <td><?= htmlspecialchars($flight['arrival_time']); ?></td>
                        <td><?= htmlspecialchars($flight['price']); ?> €</td>
                        <td>
                            <button type="button" onclick='editFlight(<?= json_encode($flight); ?>)'>Edit</button>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="flight_id" value="<?= $flight['id']; ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7">No flights available.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<section id="footer">
    <div class="footer container">
        <div class="brand">
            <h1><span>JO</span>- NA</h1>
        </div>
        <p>&copy; 2023 JO-NA. All rights reserved.</p>
    </div>
</section>
</body>
</html>

