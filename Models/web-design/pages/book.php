<?php
session_start();
$includePath = $_SERVER['DOCUMENT_ROOT'] . '/Travel_Agency/Data/auth/config/config.php';

if (file_exists($includePath)) {
    include $includePath;
} else {
    die("Error: Could not include the database configuration file.");
}

if (!isset($conn)) {
    die("Database connection not established.");
}

// Verifikoni autentikimin dhe llojin e përdoruesit
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 0) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Merr ID e përdoruesit nga sesioni
    $user_id = intval($_SESSION['user_id']);
    
    // Merr të dhënat e përdoruesit nga tabela users
    $user_query = $conn->query("SELECT name, surname, email FROM users WHERE id = $user_id");
    if (!$user_query || $user_query->num_rows == 0) {
        die("Error: User data not found.");
    }
    $user_data = $user_query->fetch_assoc();
    
    // Pastro dhe verifiko të dhënat nga forma
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $location = $conn->real_escape_string($_POST['location']);
    $guests = intval($_POST['guests']);
    $arrival_date = $conn->real_escape_string($_POST['arrivals']);
    $leaving_date = $conn->real_escape_string($_POST['leaving']);
    
    // Krijo query për insert
    $sql = "INSERT INTO bookings (user_id, name, surname, email, phone, address, location, guests, arrival_date, leaving_date) 
            VALUES (
                '$user_id', 
                '{$user_data['name']}', 
                '{$user_data['surname']}', 
                '{$user_data['email']}', 
                '$phone', 
                '$address', 
                '$location', 
                '$guests', 
                '$arrival_date', 
                '$leaving_date'
            )";

    if ($conn->query($sql) === TRUE) {
        // Ridrejto në faqen e pagesës me ID e rezervimit
        $booking_id = $conn->insert_id;
        header("Location: /Travel_Agency/Controllers/payment/process_payment.php?booking_id=$booking_id");
        exit();
    } else {
        die("Error: " . $conn->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/book.css"> 
    <title>JO-NA Book</title>
</head>
<body>

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
          <li><a href="afterlogin.php#services" data-after="Service">Transporti</a></li>
          <li><a href="afterlogin.php#projects" data-after="Service">Package</a></li>
          <li><a href="afterlogin.php#about" data-after="About">About</a></li>
          <li><a href="afterlogin.php#contact" data-after="Contact">Contact</a></li>
          <li><a href="../../../Data/auth/config/logout.php" data-after="LogOut">LogOut</a></li>
         </ul>
       </div>
     </div>
   </div>
 </section>

<div class="heading" style="background:url(../img/header-bg-1.png) no-repeat">
   <h1>Book Now</h1>
</div>

<section class="booking">
   <h1 class="heading-title">Book Your Trip!</h1>
   <form action="book.php" method="post" class="book-form" onsubmit="return validateBookingForm()">
      <div class="flex">
         <div class="inputBox">
            <span>Phone :</span>
            <input type="tel" placeholder="Enter your number" name="phone" pattern="[0-9]{9,15}" required>
         </div>
         <div class="inputBox">
            <span>Address :</span>
            <input type="text" placeholder="Enter your address" name="address" required>
         </div>
         <div class="inputBox">
            <span>Where to :</span>
            <input type="text" placeholder="Place you want to visit" name="location" required>
         </div>
         <div class="inputBox">
            <span>How many :</span>
            <input type="number" placeholder="Number of guests" name="guests" min="1" max="20" required>
         </div>
         <div class="inputBox">
            <span>Arrival :</span>
            <input type="date" name="arrivals" id="arrivalDate" required>
         </div>
         <div class="inputBox">
            <span>Leaving :</span>
            <input type="date" name="leaving" id="leavingDate" required>
         </div>
      </div>
      <input type="submit" value="Submit" class="btn" name="send">
   </form>
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

<script src="../js/main.js"></script>
<script>
function validateBookingForm() {
    const arrivalDate = new Date(document.getElementById('arrivalDate').value);
    const leavingDate = new Date(document.getElementById('leavingDate').value);
    
    if (arrivalDate >= leavingDate) {
        alert('Leaving date must be after arrival date!');
        return false;
    }
    
    return true;
}
</script>

</body>
</html>