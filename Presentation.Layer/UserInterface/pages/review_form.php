<?php
include '../../../DataAccess.Layer/Config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating = (int)$_POST['rating'];
    $comment = $_POST['comment'];

    $stmt = $conn->prepare("INSERT INTO Reviews (rating, comment) VALUES (?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("is", $rating, $comment);
    if (!$stmt->execute()) {
        echo '<div class="message error" id="flash-message">Error submitting review: ' . $stmt->error . '</div>';
    } else if ($stmt->affected_rows > 0) {
        echo '<div class="message success" id="flash-message">Review submitted successfully!</div>';
        echo '<script>
                setTimeout(function() {
                    document.getElementById("flash-message").style.display = "none";
                }, 3000);
              </script>';
    } else {
        echo '<div class="message error" id="flash-message">No data was inserted.</div>';
    }
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Review</title>

    <style>
      :root {
            --primary: #3a86ff;
            --secondary: #8338ec;
            --accent: #ff006e;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #28a745;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f4f4f9;
            color: var(--dark);
            line-height: 1.6;
        }

        /* Header Styles */
        #header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header.container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .nav-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand h1 {
            color: white;
            font-size: 1.8rem;
            margin: 0;
        }

        .brand span {
            color: #ffcc00;
        }

        .nav-bar ul {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-bar a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }

        .nav-bar a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        /* Review Form Container */
        .review-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 0 20px;
        }

        /* Review Form Styles */
        .review-form {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .review-form:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .form-title {
            text-align: center;
            margin-bottom: 30px;
            color: var(--primary);
            font-size: 2rem;
            position: relative;
        }

        .form-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: var(--accent);
            margin: 10px auto;
            border-radius: 2px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }

        input[type="number"],
        textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        input[type="number"]:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(58, 134, 255, 0.2);
        }

        textarea {
            min-height: 150px;
            resize: vertical;
        }

        .rating-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }

        .rating-container input[type="radio"] {
            display: none;
        }

        .rating-container label {
            font-size: 2rem;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s;
        }

        .rating-container input[type="radio"]:checked ~ label {
            color: #ffcc00;
        }

        .rating-container label:hover,
        .rating-container label:hover ~ label {
            color: #ffcc00;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(58, 134, 255, 0.3);
        }

        /* Message Styles */
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
        }

        .success {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success);
            border: 1px solid var(--success);
        }

        .error {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid #dc3545;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-bar {
                flex-direction: column;
            }
            
            .nav-bar ul {
                margin-top: 1rem;
                gap: 1rem;
            }
            
            .review-form {
                padding: 30px 20px;
            }
        }

        /* Star Rating Animation */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        .rating-container label:hover {
            animation: pulse 0.5s ease;
        }

        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
            transition: opacity 0.5s ease;
        }
        
        .success {
            background-color: rgba(40, 167, 69, 0.2);
            color: #28a745;
            border: 1px solid #28a745;
        }
        
        .error {
            background-color: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border: 1px solid #dc3545;
        }
    </style>
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
                    <li><a href="../../../DataAccess.Layer/Config/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </section>
    <div class="review-container">
    <?php if (isset($message)): ?>
            <div class="message <?= strpos($message, 'successfully') !== false ? 'success' : 'error' ?>">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        <form class="review-form" method="post">
            <h2 class="form-title">Share Your Experience</h2>

            <div class="form-group">
                <label for="rating">Your Rating:</label>
                <div class="rating-container">
                    <input type="radio" id="star5" name="rating" value="5">
                    <label for="star5">★</label>
                    <input type="radio" id="star4" name="rating" value="4">
                    <label for="star4">★</label>
                    <input type="radio" id="star3" name="rating" value="3">
                    <label for="star3">★</label>
                    <input type="radio" id="star2" name="rating" value="2">
                    <label for="star2">★</label>
                    <input type="radio" id="star1" name="rating" value="1" required>
                    <label for="star1">★</label>
                </div>
            </div>

        <div class="form-group">
                <label for="comment">Your Review:</label>
                <textarea id="comment" name="comment" placeholder="Tell us about your experience with JO-NA Travel..." required></textarea>
            </div>
        <input type="submit" value="Submit Review">
    </form>
</body>
</html>
