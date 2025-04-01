<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 0) {
    header("Location: login.php");
    exit();
}

$includePath = $_SERVER['DOCUMENT_ROOT'] . '/Travel-Agency/Data/auth/config/config.php';
if (file_exists($includePath)) {
    include $includePath;
} else {
    die("Error: Could not include the database configuration file.");
}

if (!isset($conn)) {
    die("Database connection not established.");
}

function addTravelDetails($conn, $itineraryID, $departureLocation, $arrivalLocation, $transportMode, $totalCost, $departureDate) {
    $stmt = $conn->prepare("INSERT INTO travel_details (itineraryID, departureLocation, arrivalLocation, transportMode, totalCost, departureDate) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssds", $itineraryID, $departureLocation, $arrivalLocation, $transportMode, $totalCost, $departureDate);
    return $stmt->execute();
}

function updateTravelDetails($conn, $travelDetailID, $itineraryID, $departureLocation, $arrivalLocation, $transportMode, $totalCost, $departureDate) {
    $stmt = $conn->prepare("UPDATE travel_details SET itineraryID = ?, departureLocation = ?, arrivalLocation = ?, transportMode = ?, totalCost = ?, departureDate = ? WHERE travelDetailID = ?");
    $stmt->bind_param("isssdsi", $itineraryID, $departureLocation, $arrivalLocation, $transportMode, $totalCost, $departureDate, $travelDetailID);
    return $stmt->execute();
}

function deleteTravelDetails($conn, $travelDetailID) {
    $stmt = $conn->prepare("DELETE FROM travel_details WHERE travelDetailID = ?");
    $stmt->bind_param("i", $travelDetailID);
    return $stmt->execute();
}

function getAllTravelDetails($conn) {
    $query = "SELECT travelDetailID, itineraryID, departureLocation, arrivalLocation, transportMode, totalCost, departureDate FROM travel_details";
    return $conn->query($query);
}

function calculateTotalCost($costs) {
    return array_sum($costs);
}

$travelDetails = getAllTravelDetails($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../web-design/css/style.css">
    <title>Travel Details</title>
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
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li><a href="travel_details.php">Travel Details</a></li>
                        <li><a href="/Travel-Agency/Data/auth/config/logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="traveldetails">
        <div class="container">
            <h1>Travel Details</h1>
            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>Travel Detail ID</th>
                        <th>Itinerary ID</th>
                        <th>Departure Location</th>
                        <th>Arrival Location</th>
                        <th>Transport Mode</th>
                        <th>Total Cost (€)</th>
                        <th>Departure Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $travelDetails->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['travelDetailID']); ?></td>
                            <td><?php echo htmlspecialchars($row['itineraryID']); ?></td>
                            <td><?php echo htmlspecialchars($row['departureLocation']); ?></td>
                            <td><?php echo htmlspecialchars($row['arrivalLocation']); ?></td>
                            <td><?php echo htmlspecialchars($row['transportMode']); ?></td>
                            <td><?php echo htmlspecialchars($row['totalCost']); ?></td>
                            <td><?php echo htmlspecialchars($row['departureDate']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>