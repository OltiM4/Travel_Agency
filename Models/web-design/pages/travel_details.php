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

// Funksion për të marrë të gjitha detajet e udhëtimit
function getAllTravelDetails($conn) {
    $query = "SELECT travelDetailID, type, description, price, date FROM travel_details";
    return $conn->query($query);
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
                        <th>Type</th>
                        <th>Description</th>
                        <th>Price (€)</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $travelDetails->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['travelDetailID']); ?></td>
                            <td><?php echo htmlspecialchars($row['type']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['price']); ?></td>
                            <td><?php echo htmlspecialchars($row['date']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>
