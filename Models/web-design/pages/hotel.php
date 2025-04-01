<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/Travel-Agency/Models/web-design/css/hotel.css">
  <title>JO-NA Hotels</title>
</head>
<body>
<?php
session_start(); 
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 0) {
    header("Location: login.php");
    exit();
}

include '../../../Data/auth/config/config.php';


$hotelsQuery = $conn->query("SELECT * FROM hotels");
if (!$hotelsQuery) {
    die("Error retrieving hotels: " . $conn->error);
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_hotel'])) {
    $hotelID = (int)$_POST['hotelID'];
    $userID = (int)$_SESSION['user_id'];
    $rooms = (int)$_POST['rooms'];

    $availabilityQuery = $conn->prepare("SELECT availability FROM hotels WHERE hotelID = ?");
    $availabilityQuery->bind_param("i", $hotelID);
    $availabilityQuery->execute();
    $result = $availabilityQuery->get_result();
    $availability = $result->fetch_assoc()['availability'];

    if ($availability >= $rooms) {
        $updateQuery = $conn->prepare("UPDATE hotels SET availability = availability - ? WHERE hotelID = ?");
        $updateQuery->bind_param("ii", $rooms, $hotelID);
        $updateQuery->execute();

        $bookingQuery = $conn->prepare("INSERT INTO bookings (user_id, hotel_id, rooms) VALUES (?, ?, ?)");
        $bookingQuery->bind_param("iii", $userID, $hotelID, $rooms);
        $bookingQuery->execute();

        $message = "Hotel booked successfully!";
    } else {
        $message = "Not enough rooms available!";
    }
}
?>
<section id="header">
   <div class="header container">
     <div class="nav-bar">
       <div class="brand">
         <a href="index.php">
           <h1><span>J</span>O- <span>N</span>A <span>T</span>RAVEL</h1>
         </a>
       </div>
       <div class="nav-list">
         <ul>
          <li><a href="afterlogin.php#hero" data-after="Home">Home</a></li>
          <li><a href="../../../Data/auth/config/logout.php" data-after="LogOut">LogOut</a></li>
         </ul>
       </div>
     </div>
   </div>
 </section>
<div class="heading" style="background:url(../img/header-bg-2.png) no-repeat">
   <h1>Hotels</h1>
</div>

<section class="hotels">
   <div class="container">
      <?php if (!empty($message)): ?>
          <p class="message"><?php echo htmlspecialchars($message); ?></p>
      <?php endif; ?>

      <?php while ($hotel = $hotelsQuery->fetch_assoc()): ?>
          <div class="hotel-card">
              <img src="<?php echo !empty($hotel['imagePath']) ? htmlspecialchars($hotel['imagePath']) : '../img/default-hotel.jpg'; ?>" 
                   alt="Hotel Image">
              <div class="hotel-info">
                  <h2><?php echo htmlspecialchars($hotel['name']); ?></h2>
                  <p><strong>Location:</strong> <?php echo htmlspecialchars($hotel['location']); ?></p>
                  <p><strong>Rating:</strong> <?php echo htmlspecialchars($hotel['rating']); ?>/5</p>
                  <p><strong>Price per Night:</strong> $<?php echo htmlspecialchars($hotel['pricePerNight']); ?></p>
                  <p><strong>Available Rooms:</strong> <?php echo htmlspecialchars($hotel['availability']); ?></p>
                  <p><strong>Facilities:</strong> <?php echo htmlspecialchars($hotel['facilities']); ?></p>
                  <p><strong>Contact:</strong> <?php echo htmlspecialchars($hotel['contactDetails']); ?></p>

                  <?php if ($hotel['availability'] > 0): ?>
                      <form method="POST" action="">
                          <input type="hidden" name="hotelID" value="<?php echo $hotel['hotelID']; ?>">
                          <label for="rooms">Rooms:</label>
                          <input type="number" name="rooms" min="1" max="<?php echo $hotel['availability']; ?>" required>
                          <button type="submit" name="book_hotel">Book Now</button>
                      </form>
                  <?php else: ?>
                      <p style="color: red; font-weight: bold;">No rooms available</p>
                  <?php endif; ?>
              </div>
          </div>
      <?php endwhile; ?>
   </div>
</section>

<section id="footer">
   <div class="footer container">
     <div class="brand">
       <h1><span>J</span>O <span>-N</span>A</h1>
     </div>
     <div class="social-icon">
       <div class="social-item">
         <a href="#"><img src="https://img.icons8.com/bubbles/100/000000/facebook-new.png" /></a>
       </div>
       <div class="social-item">
         <a href="#"><img src="https://img.icons8.com/bubbles/100/000000/instagram-new.png" /></a>
       </div>
     </div>
     <p>Copyright © 2023 JO-NA. All rights reserved</p>
   </div>
 </section>
</body>
</html>
