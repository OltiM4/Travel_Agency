<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 1) { // Sigurohuni që vetëm adminët kanë qasje
    header("Location: login.php");
    exit();
}

include '../../../Data/auth/config/config.php';

// Për mesazhe pas veprimeve
$message = "";

// Shto një hotel të ri
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_hotel'])) {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $rating = (float)$_POST['rating'];
    $pricePerNight = (float)$_POST['pricePerNight'];
    $availability = (int)$_POST['availability'];
    $facilities = $_POST['facilities'];
    $contactDetails = $_POST['contactDetails'];

    $stmt = $conn->prepare("INSERT INTO hotels (name, location, rating, pricePerNight, availability, facilities, contactDetails) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssddiss", $name, $location, $rating, $pricePerNight, $availability, $facilities, $contactDetails);

    if ($stmt->execute()) {
        $message = "Hotel added successfully!";
    } else {
        $message = "Error adding hotel: " . $conn->error;
    }
}

// Fshi një hotel ekzistues
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_hotel'])) {
    $hotelID = (int)$_POST['hotelID'];

    $stmt = $conn->prepare("DELETE FROM hotels WHERE hotelID = ?");
    $stmt->bind_param("i", $hotelID);

    if ($stmt->execute()) {
        $message = "Hotel deleted successfully!";
    } else {
        $message = "Error deleting hotel: " . $conn->error;
    }
}

// Përditëso një hotel ekzistues
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_hotel'])) {
    $hotelID = (int)$_POST['hotelID'];
    $name = $_POST['name'];
    $location = $_POST['location'];
    $rating = (float)$_POST['rating'];
    $pricePerNight = (float)$_POST['pricePerNight'];
    $availability = (int)$_POST['availability'];
    $facilities = $_POST['facilities'];
    $contactDetails = $_POST['contactDetails'];

    $stmt = $conn->prepare("UPDATE hotels SET name = ?, location = ?, rating = ?, pricePerNight = ?, availability = ?, facilities = ?, contactDetails = ? WHERE hotelID = ?");
    $stmt->bind_param("ssddissi", $name, $location, $rating, $pricePerNight, $availability, $facilities, $contactDetails, $hotelID);

    if ($stmt->execute()) {
        $message = "Hotel updated successfully!";
    } else {
        $message = "Error updating hotel: " . $conn->error;
    }
}

// Përditëso disponueshmërinë e dhomave (updateHotelAvailability)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_availability'])) {
    $hotelID = (int)$_POST['hotelID'];
    $newAvailability = (int)$_POST['availability'];

    $stmt = $conn->prepare("UPDATE hotels SET availability = ? WHERE hotelID = ?");
    $stmt->bind_param("ii", $newAvailability, $hotelID);

    if ($stmt->execute()) {
        $message = "Hotel availability updated successfully!";
    } else {
        $message = "Error updating availability: " . $conn->error;
    }
}

// Shto një facilitet të ri (addFacility)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_facility'])) {
    $hotelID = (int)$_POST['hotelID'];
    $newFacility = $_POST['facility'];

    $stmt = $conn->prepare("UPDATE hotels SET facilities = CONCAT(facilities, ', ', ?) WHERE hotelID = ?");
    $stmt->bind_param("si", $newFacility, $hotelID);

    if ($stmt->execute()) {
        $message = "Facility added successfully!";
    } else {
        $message = "Error adding facility: " . $conn->error;
    }
}

// Merr të gjithë hotelet për t'i shfaqur në tabelë
$hotelsQuery = $conn->query("SELECT * FROM hotels");
if (!$hotelsQuery) {
    die("Error retrieving hotels: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Travel-Agency/Models/web-design/css/hotel.css">
    
    <title>Hotel Manasgement Dashboard</title>
</head>
<body>
<section id="header">
    <div class="header container">
        <div class="nav-bar">
            <div class="brand">
                <a href="index.php"><h1><span>J</span>O-<span>N</span>A</h1></a>
            </div>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="../../../Data/auth/config/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</section>

<section class="dashboard">
    <div class="container">
        <h1>Hotel Management Dashboard</h1>
        <?php if (!empty($message)): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form method="POST" class="hotel-form">
            <h2>Add Hotel</h2>
            <input type="text" name="name" placeholder="Hotel Name" required>
            <input type="text" name="location" placeholder="Location" required>
            <input type="number" step="0.1" name="rating" placeholder="Rating (1-5)" required>
            <input type="number" step="0.01" name="pricePerNight" placeholder="Price per Night" required>
            <input type="number" name="availability" placeholder="Available Rooms" required>
            <textarea name="facilities" placeholder="Facilities (comma-separated)" required></textarea>
            <input type="text" name="contactDetails" placeholder="Contact Details" required>
            <button type="submit" name="add_hotel">Add Hotel</button>
        </form>

        <h2>Manage Hotels</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Rating</th>
                    <th>Price/Night</th>
                    <th>Rooms</th>
                    <th>Facilities</th>
                    <th>Contact</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($hotel = $hotelsQuery->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($hotel['name']); ?></td>
                    <td><?php echo htmlspecialchars($hotel['location']); ?></td>
                    <td><?php echo htmlspecialchars($hotel['rating']); ?></td>
                    <td>$<?php echo htmlspecialchars($hotel['pricePerNight']); ?></td>
                    <td><?php echo htmlspecialchars($hotel['availability']); ?></td>
                    <td><?php echo htmlspecialchars($hotel['facilities']); ?></td>
                    <td><?php echo htmlspecialchars($hotel['contactDetails']); ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="hotelID" value="<?php echo $hotel['hotelID']; ?>">
                            <button type="submit" name="delete_hotel">Delete</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="hotelID" value="<?php echo $hotel['hotelID']; ?>">
                            <input type="number" name="availability" placeholder="New Availability" required>
                            <button type="submit" name="update_availability">Update Availability</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="hotelID" value="<?php echo $hotel['hotelID']; ?>">
                            <input type="text" name="facility" placeholder="New Facility" required>
                            <button type="submit" name="add_facility">Add Facility</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</section>
<section id="footer">
    <div class="footer container">
        <div class="brand">
            <h1><span>J</span>O <span>-N</span>A</h1>
        </div>
        <p>Copyright © 2023 JO-NA. All rights reserved</p>
    </div>
</section>
</body>
</html>
