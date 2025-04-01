<?php
session_start();
include '../../Data/auth/config/config.php'; 

$paymentSuccessful = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['payment_submit'])) {
    $amount = (double) $_POST['amount']; 
    $method = $_POST['method'];
    $user_id = (int) $_SESSION['user_id'];

   
    $card_number = $method === 'Credit Card' ? $_POST['card_number'] : null;
    $card_expiry = $method === 'Credit Card' ? $_POST['card_expiry'] : null;
    $bank_account = $method === 'Bank Transfer' ? $_POST['bank_account'] : null;
    $paypal_email = $method === 'PayPal' ? $_POST['paypal_email'] : null;

    
    $card_number = $card_number ?: '';
    $card_expiry = $card_expiry ?: '';
    $bank_account = $bank_account ?: '';
    $paypal_email = $paypal_email ?: '';

    
    if ($amount > 0 && !empty($method) && $user_id > 0) {
        $stmt = $conn->prepare("
            INSERT INTO payments (user_id, amount, payment_method, payment_status, card_number, card_expiry, bank_account, paypal_email) 
            VALUES (?, ?, ?, 'Pending', ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "idsssss",  
            $user_id,      
            $amount,       
            $method,       
            $card_number,  
            $card_expiry,  
            $bank_account, 
            $paypal_email  
        );

        if ($stmt->execute()) {
            $paymentSuccessful = true; 
        } else {
            echo "<p>Error submitting payment: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p>Please fill in all required fields correctly.</p>";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Payment</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .payment-form {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 300px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333333;
        }
        input, select {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #cccccc;
        }
        button {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #45a049;
        }
        .success-message {
            margin-top: 15px;
            color: green;
            font-weight: bold;
            text-align: center;
        }
        .hidden {
            display: none;
        }
    </style>
    <script>
        function togglePaymentFields() {
            const method = document.getElementById('method').value;
            document.getElementById('credit-card-fields').classList.toggle('hidden', method !== 'Credit Card');
            document.getElementById('bank-transfer-fields').classList.toggle('hidden', method !== 'Bank Transfer');
            document.getElementById('paypal-fields').classList.toggle('hidden', method !== 'PayPal');
        }
    </script>
    <?php if ($paymentSuccessful): ?>
    <script>
        setTimeout(function() {
            window.location.href = '../../Models/web-design/pages/afterlogin.php'; 
        }, 3000);
    </script>
    <?php endif; ?>
</head>
<body>
    <div class="payment-form">
        <h1>Payment Form</h1>
        <form method="post">
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" step="0.01" placeholder="Enter amount" required>
            </div>
            <div class="form-group">
                <label for="method">Payment Method:</label>
                <select id="method" name="method" onchange="togglePaymentFields()" required>
                    <option value="" disabled selected>Select payment method</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="PayPal">PayPal</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                </select>
            </div>

            
            <div id="credit-card-fields" class="hidden">
                <div class="form-group">
                    <label for="card_number">Card Number:</label>
                    <input type="text" id="card_number" name="card_number" placeholder="Enter card number">
                </div>
                <div class="form-group">
                    <label for="card_expiry">Card Expiry:</label>
                    <input type="text" id="card_expiry" name="card_expiry" placeholder="MM/YY">
                </div>
            </div>

            
            <div id="bank-transfer-fields" class="hidden">
                <div class="form-group">
                    <label for="bank_account">Bank Account:</label>
                    <input type="text" id="bank_account" name="bank_account" placeholder="Enter bank account">
                </div>
            </div>

           
            <div id="paypal-fields" class="hidden">
                <div class="form-group">
                    <label for="paypal_email">PayPal Email:</label>
                    <input type="email" id="paypal_email" name="paypal_email" placeholder="Enter PayPal email">
                </div>
            </div>

            <button type="submit" name="payment_submit">Submit Payment</button>
            <?php if ($paymentSuccessful): ?>
            <p class="success-message">Payment submitted successfully! Redirecting...</p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
