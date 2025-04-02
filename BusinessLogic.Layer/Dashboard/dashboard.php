<?php
session_start(); 


if (!isset($_SESSION['user_id'])) {
    header("Location: /Travel_Agency/Presentation.Layer/UserInterface/pages/login.php");
    exit();
}


$includePath = $_SERVER['DOCUMENT_ROOT'] . '/Travel_Agency/DataAccess.Layer/Config/config.php';
if (file_exists($includePath)) {
    include $includePath;
} else {
    die("Error: Could not include the database configuration file.");
}


if (!isset($conn)) {
    die("Database connection not established.");
}

$usersQuery = $conn->query("SELECT COUNT(*) AS total FROM users");
$numUsers = ($usersQuery) ? $usersQuery->fetch_assoc()['total'] : 0;

$bookingsQuery = $conn->query("SELECT COUNT(*) AS total FROM bookings");
$numBookings = ($bookingsQuery) ? $bookingsQuery->fetch_assoc()['total'] : 0;

$flightsQuery = $conn->query("SELECT COUNT(*) AS total FROM flights");
$numFlights = ($flightsQuery) ? $flightsQuery->fetch_assoc()['total'] : 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../UserInterface/css/style.css">
    <link rel="stylesheet" href="../UserInterface/css/dashboard.css">
    <title>Dashboard</title>
</head>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: auto;
    overflow: hidden;
}

#header {
    background: #333;
    color: #fff;
    padding-top: 30px;
    min-height: 70px;
    border-bottom: #bbb 1px solid;
}

#header a {
    color: #fff;
    text-decoration: none;
}

.nav-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.nav-list ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-list ul li {
    display: inline;
    margin-left: 20px;
}

#dashboard {
    text-align: center;
}

.dashboard .dashboard-info {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    flex-wrap: wrap;
    margin-top: 20px;
}

.dashboard .info-item {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin: 10px;
    width: calc(50% - 40px); 
    text-align: center;
}

.dashboard .info-item h2 {
    font-size: 1.5em;
    color: #333;
    margin-bottom: 15px;
}

.dashboard .info-item p {
    font-size: 1.2em;
    margin-bottom: 20px;
    color: #666;
}

.info-item button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    text-decoration: none;
    font-size: 1em;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.info-item button:hover {
    background-color: #0056b3;
}

@media (max-width: 768px) {
    .dashboard .info-item {
        width: 100%; 
    }
}
#footer {
    background: #333;
    color: #fff;
    text-align: center;
    padding: 30px 0;
}

#footer p {
    margin: 0;
}
</style>

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
                    <div class="hamburger">
                        <div class="bar"></div>
                    </div>
                    <ul>
                        <li><a href="dashboard.php" data-after="Dashboard">Dashboard</a></li>
                        <li><a href="users.php" data-after="Users">Users</a></li>
                        <li><a href="bookings.php" data-after="Bookings">Bookings</a></li>
                        <li><a href="add_flight.php" data-after="Flights">Flights</a></li>
                        <li><a href="traveler.php" data-after="Travelers">Travelers</a></li>
                        <li><a href="hotelManagement.php" data-after="Hotels">Hotels</a></li>
                        <li><a href="viewpayments.php" data-after="View Payments">View Payments</a></li>
                        <li><a href="/Travel_Agency/DataAccess.Layer/Config/logout.php" data-after="Logout">Logout</a></li>
                        
                        </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="dashboard">
        <div class="dashboard container">
            <div class="dashboard-info">
                <div class="info-item">
                    <h2>Total Users</h2>
                    <p><?php echo $numUsers; ?></p>
                    <button onclick="location.href='users.php'">Read More</button>
                </div>
                <div class="info-item">
                    <h2>Total Bookings</h2>
                    <p><?php echo $numBookings; ?></p>
                    <button onclick="location.href='bookings.php'">Read More</button>
                </div>
                <div class="info-item">
                    <h2>Total Flights</h2>
                    <p><?php echo $numFlights; ?></p>
                    <button onclick="location.href='add_flight.php'">More</button>
                </div>
            </div>
        </div>
    </section>

    <section id="footer">
        <div class="footer container">
            <div class="brand">
                <h1><span>JO</span>-NA</h1>
            </div>
            <div class="social-icon">
            </div>
            <p>&copy; 2023 JO-NA. All rights reserved</p>
        </div>
    </section>

    <script src="../UserInterface/js/main.js"></script>
</body>

</html>