<?php
session_start(); 
include '../../../DataAccess.Layer/Config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../Presentation.Layer/UserInterface/pages/login.php");
    exit();
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reserve'])) {
    $itinerary_id = $_POST['itinerary_id'];
    $traveler_id = $_SESSION['traveler_id'];
    $details = $_POST['details'];

    $stmt = $conn->prepare("INSERT INTO reservations (itinerary_id, traveler_id, details) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $itinerary_id, $traveler_id, $details);

    if ($stmt->execute()) {
        $message = "Rezervimi u bë me sukses!";
        header("Location: itineraries.php?success=1");
        exit;
    } else {
        $message = "Gabim gjatë rezervimit: " . $stmt->error;
    }
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $message = "Rezervimi u bë me sukses!";
}

$query = "SELECT * FROM itineraries";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/itineraries.css">
    <title>Itineraret</title>
</head>
<body>
    <section id="header">
        <div class="header container">
            <div class="nav-bar">
                <div class="brand">
                    <a href="afterlogin.php"><h1>JO-NA Travel</h1></a>
                </div>
                <ul>
                    <li><a href="afterlogin.php">Home</a></li>
                    <li><a href="#itineraries">Itineraries</a></li>
                    <li><a href="../../../DataAccess.Layer/Config/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </section>

    <section id="itineraries">
        <div class="container">
            <h1 class="section-title">Eksploroni <span>Itineraret</span></h1>
            <p>Zbuloni eksperiencat dhe udhëtimet më të mira që kemi për ju!</p>

            <?php if ($message): ?>
                <p class="message"><?= htmlspecialchars($message); ?></p>
            <?php endif; ?>

            <div class="itineraries-list">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="itinerary-item">
                        <img src="../img/itinerary.png" alt="Itinerary Image">
                        <div class="itinerary-content">
                            <h2>Travel Itinerary</h2>
                            <form action="itineraries.php" method="POST">
                                <input type="hidden" name="itinerary_id" value="<?= htmlspecialchars($row['id']); ?>">
                                <label for="details">Details:</label>
                                <textarea name="details" placeholder="Shkruaj detajet për udhëtimin" required></textarea>
                                <button type="submit" name="reserve" class="btn">Rezervo</button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <section id="footer">
        <div class="footer container">
            <div class="brand">
                <h1>JO-NA Travel</h1>
            </div>
            <p>&copy; 2023 JO-NA Travel. All rights reserved.</p>
        </div>
    </section>


    </style>
</body>
</html>
