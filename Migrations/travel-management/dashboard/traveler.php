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
$edit_traveler = null;
$search_results = null;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == "add") {
        
        $customer_id = trim($_POST['customer_id']);
        $passport_number = trim($_POST['passport_number']);
        $name = trim($_POST['name']);
        $surname = trim($_POST['surname']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);

        if (!empty($customer_id) && !empty($passport_number) && !empty($name) && !empty($surname) && !empty($email) && !empty($phone)) {
            $stmt = $conn->prepare("INSERT INTO travelers (customer_id, passport_number, name, surname, email, phone) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $customer_id, $passport_number, $name, $surname, $email, $phone);
            if ($stmt->execute()) {
                $message = "Traveler added successfully!";
            } else {
                $message = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "All fields are required.";
        }
    } elseif ($action == "delete") {
        
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM travelers WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $message = "Traveler deleted successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    } elseif ($action == "edit") {
        
        $id = intval($_POST['id']);
        $customer_id = trim($_POST['customer_id']);
        $passport_number = trim($_POST['passport_number']);
        $name = trim($_POST['name']);
        $surname = trim($_POST['surname']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);

        if (!empty($customer_id) && !empty($passport_number) && !empty($name) && !empty($surname) && !empty($email) && !empty($phone)) {
            $stmt = $conn->prepare("UPDATE travelers SET customer_id = ?, passport_number = ?, name = ?, surname = ?, email = ?, phone = ? WHERE id = ?");
            $stmt->bind_param("ssssssi", $customer_id, $passport_number, $name, $surname, $email, $phone, $id);
            if ($stmt->execute()) {
                $message = "Traveler updated successfully!";
            } else {
                $message = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "All fields are required for editing.";
        }
    } elseif ($action == "show_edit") {
        
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("SELECT * FROM travelers WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $edit_traveler = $result->fetch_assoc();
        $stmt->close();
    }
}


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $search_query = trim($_GET['search']);
    if (!empty($search_query)) {
        $stmt = $conn->prepare("SELECT * FROM travelers WHERE name LIKE ? OR surname LIKE ?");
        $like_query = "%$search_query%";
        $stmt->bind_param("ss", $like_query, $like_query);
        $stmt->execute();
        $search_results = $stmt->get_result();
        $stmt->close();
    }
}


if (!$search_results) {
    $travelersQuery = $conn->query("SELECT * FROM travelers");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travelers</title>
    <link rel="stylesheet" href="../../../Models/web-design/css/style.css">
    <link rel="stylesheet" href="../../../Models/web-design/css/travelers.css">
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

    <section id="travelers">
        <div class="container">
            <h1>Travelers</h1>
            
            <?php if (!empty($message)) { ?>
                <p class="message"><?php echo htmlspecialchars($message); ?></p>
            <?php } ?>

            
            <form method="POST" action="">
                <?php if ($edit_traveler) { ?>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($edit_traveler['id']); ?>">
                <?php } ?>
                <input type="text" name="customer_id" placeholder="Customer ID" value="<?php echo $edit_traveler ? htmlspecialchars($edit_traveler['customer_id']) : ''; ?>" required>
                <input type="text" name="passport_number" placeholder="Passport Number" value="<?php echo $edit_traveler ? htmlspecialchars($edit_traveler['passport_number']) : ''; ?>" required>
                <input type="text" name="name" placeholder="Name" value="<?php echo $edit_traveler ? htmlspecialchars($edit_traveler['name']) : ''; ?>" required>
                <input type="text" name="surname" placeholder="Surname" value="<?php echo $edit_traveler ? htmlspecialchars($edit_traveler['surname']) : ''; ?>" required>
                <input type="email" name="email" placeholder="Email" value="<?php echo $edit_traveler ? htmlspecialchars($edit_traveler['email']) : ''; ?>" required>
                <input type="text" name="phone" placeholder="Phone" value="<?php echo $edit_traveler ? htmlspecialchars($edit_traveler['phone']) : ''; ?>" required>
                <button type="submit" name="action" value="<?php echo $edit_traveler ? 'edit' : 'add'; ?>">
                    <?php echo $edit_traveler ? 'Update Traveler' : 'Add Traveler'; ?>
                </button>
            </form>

            
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search by name or surname">
                <button type="submit">Search</button>
            </form>

            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer ID</th>
                        <th>Passport Number</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $data = $search_results ?: $travelersQuery;
                    while ($row = $data->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['customer_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['passport_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['surname']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="action" value="show_edit">Edit</button>
                                </form>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="action" value="delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>
