<?php

$includePath = $_SERVER['DOCUMENT_ROOT'] . '/Travel_Agency/Data/auth/config/config.php';
if (file_exists($includePath)) {
    include $includePath;
} else {
    die("Error: Could not include the database configuration file.");
}

if (!isset($conn)) {
    die("Database connection not established.");
}

// Handle Deleting a Booking
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $deleteQuery = $conn->query("DELETE FROM bookings WHERE id = $delete_id");
    if ($deleteQuery) {
        echo "<script>alert('Booking deleted successfully!'); window.location.href='bookings.php';</script>";
    } else {
        echo "<script>alert('Error deleting booking: " . $conn->error . "');</script>";
    }
}

// Handle Editing a Booking
if (isset($_POST['update'])) {
    $edit_id = intval($_POST['edit_id']);
    $name = $conn->real_escape_string($_POST['name']);
    $surname = $conn->real_escape_string($_POST['surname']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $guests = intval($_POST['guests']);
    $arrival_date = $conn->real_escape_string($_POST['arrival_date']);
    $leaving_date = $conn->real_escape_string($_POST['leaving_date']);
    
    $updateQuery = "UPDATE bookings SET name='$name', surname='$surname', email='$email', phone='$phone', guests=$guests, arrival_date='$arrival_date', leaving_date='$leaving_date' WHERE id=$edit_id";
    
    if ($conn->query($updateQuery) === TRUE) {
        echo "<script>alert('Booking updated successfully!'); window.location.href='bookings.php';</script>";
    } else {
        echo "<script>alert('Error updating booking: " . $conn->error . "');</script>";
    }
}

// Fetch all bookings
$bookingsQuery = $conn->query("SELECT * FROM bookings");
if (!$bookingsQuery) {
    die("Error fetching data: " . $conn->error);
}

$editData = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $editQuery = $conn->query("SELECT * FROM bookings WHERE id = $edit_id");
    if ($editQuery && $editQuery->num_rows > 0) {
        $editData = $editQuery->fetch_assoc();
    }
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
                    <a href="dashboard.php"><h1><span>JO</span>-NA</h1></a>
                </div>
                <div class="nav-list">
                    <ul>
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li><a href="users.php">Users</a></li>
                        <li><a href="bookings.php">Bookings</a></li>
                        <li><a href="add_flight.php">Flights</a></li>
                        <li><a href="traveler.php">Traveler</a></li>
                        <li><a href="/Travel-Agency/Data/auth/config/logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="bookings">
        <div class="bookings container">
            <h1>All Bookings</h1>
            
            <?php if ($editData) { ?>
            <h2>Edit Booking</h2>
            <form method="POST" action="">
                <input type="hidden" name="edit_id" value="<?php echo $editData['id']; ?>">
                <label for="name">Name:</label>
                <input type="text" name="name" value="<?php echo $editData['name']; ?>" required>
                <label for="surname">Surname:</label>
                <input type="text" name="surname" value="<?php echo $editData['surname']; ?>" required>
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo $editData['email']; ?>" required>
                <label for="phone">Phone:</label>
                <input type="text" name="phone" value="<?php echo $editData['phone']; ?>" required>
                <label for="guests">Guests:</label>
                <input type="number" name="guests" value="<?php echo $editData['guests']; ?>" required>
                <label for="arrival_date">Arrival Date:</label>
                <input type="date" name="arrival_date" value="<?php echo $editData['arrival_date']; ?>" required>
                <label for="leaving_date">Leaving Date:</label>
                <input type="date" name="leaving_date" value="<?php echo $editData['leaving_date']; ?>" required>
                <button type="submit" name="update">Update Booking</button>
            </form>
            <?php } ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Guests</th>
                        <th>Arrival Date</th>
                        <th>Leaving Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $bookingsQuery->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['surname']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['guests']; ?></td>
                            <td><?php echo $row['arrival_date']; ?></td>
                            <td><?php echo $row['leaving_date']; ?></td>
                            <td>
                                <a href="bookings.php?edit=<?php echo $row['id']; ?>">Edit</a> |
                                <a href="bookings.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>