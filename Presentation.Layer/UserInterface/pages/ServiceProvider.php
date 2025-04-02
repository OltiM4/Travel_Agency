<?php
session_start();

// Kontrollo nëse përdoruesi ka qasje
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 1) { // Lejo qasje vetëm për adminët
    header("Location: login.php");
    exit();
}

// Përfshi konfigurimin e bazës së të dhënave
$includePath = $_SERVER['DOCUMENT_ROOT'] . '/Travel-Agency/Data/auth/config/config.php';
if (file_exists($includePath)) {
    include $includePath;
} else {
    die("Error: Could not include the database configuration file.");
}

if (!isset($conn)) {
    die("Database connection not established.");
}

// Funksion për të marrë të gjithë ofruesit e shërbimeve
function getAllServiceProviders($conn) {
    $query = "SELECT providerID, name, type, contactDetails FROM service_providers";
    return $conn->query($query);
}

// Funksion për të marrë një ofrues të vetëm bazuar në ID
function getServiceProvider($conn, $providerID) {
    $stmt = $conn->prepare("SELECT * FROM service_providers WHERE providerID = ?");
    $stmt->bind_param("i", $providerID);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Funksion për të shtuar një ofrues të ri
function createServiceProvider($conn, $name, $type, $contactDetails) {
    $stmt = $conn->prepare("INSERT INTO service_providers (name, type, contactDetails) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $type, $contactDetails);
    return $stmt->execute();
}

// Funksion për të përditësuar një ofrues ekzistues
function updateServiceProvider($conn, $providerID, $name, $type, $contactDetails) {
    $stmt = $conn->prepare("UPDATE service_providers SET name = ?, type = ?, contactDetails = ? WHERE providerID = ?");
    $stmt->bind_param("sssi", $name, $type, $contactDetails, $providerID);
    return $stmt->execute();
}

// Funksion për të fshirë një ofrues
function deleteServiceProvider($conn, $providerID) {
    $stmt = $conn->prepare("DELETE FROM service_providers WHERE providerID = ?");
    $stmt->bind_param("i", $providerID);
    return $stmt->execute();
}

// Merr të gjithë ofruesit e shërbimeve për t'i shfaqur
$serviceProviders = getAllServiceProviders($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../web-design/css/style.css">
    <title>Service Providers</title>
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
                        <li><a href="service_provider.php">Service Providers</a></li>
                        <li><a href="/Travel-Agency/Data/auth/config/logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="serviceproviders">
        <div class="container">
            <h1>Service Providers</h1>
            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>Provider ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Contact Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $serviceProviders->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['providerID']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['type']); ?></td>
                            <td><?php echo htmlspecialchars($row['contactDetails']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>