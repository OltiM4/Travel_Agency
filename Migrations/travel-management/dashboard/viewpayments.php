<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 1) {
    header("Location: login.php");
    exit();
}

$file = '../../../Data/auth/config/config.php';
if (file_exists($file)) {
    include $file;
} else {
    die("Error: config.php file not found at $file");
}

class PaymentManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updatePaymentStatus($paymentID, $newStatus) {
        $stmt = $this->conn->prepare("UPDATE payments SET payment_status = ? WHERE payment_id = ?");
        $stmt->bind_param("si", $newStatus, $paymentID);
        if ($stmt->execute()) {
            return "Payment status updated to $newStatus successfully!";
        } else {
            return "Error updating payment status: " . $this->conn->error;
        }
    }

    public function verifyPayment($paymentID) {
        $stmt = $this->conn->prepare("SELECT * FROM payments WHERE payment_id = ?");
        $stmt->bind_param("i", $paymentID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getTransactionHistory($userID = null) {
        if ($userID) {
            $stmt = $this->conn->prepare("SELECT * FROM payments WHERE user_id = ? ORDER BY payment_date DESC");
            $stmt->bind_param("i", $userID);
        } else {
            $stmt = $this->conn->prepare("SELECT * FROM payments ORDER BY payment_date DESC");
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function requestRefund($paymentID, $reason) {
        $stmt = $this->conn->prepare("INSERT INTO refund_requests (payment_id, reason, status) VALUES (?, ?, 'Pending')");
        $stmt->bind_param("is", $paymentID, $reason);
        if ($stmt->execute()) {
            return "Refund request submitted successfully!";
        } else {
            return "Error submitting refund request: " . $this->conn->error;
        }
    }
}

$verifyMessage = "";
$transactionHistory = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['payment_id'])) {
    $paymentID = (int)$_POST['payment_id'];
    $action = $_POST['action'];

    $paymentManager = new PaymentManager($conn);

    if ($action === 'update') {
        $newStatus = $_POST['new_status'];
        $message = $paymentManager->updatePaymentStatus($paymentID, $newStatus);
        header("Location: viewpayments.php?message=" . urlencode($message));
        exit();
    } elseif ($action === 'verify') {
        $paymentDetails = $paymentManager->verifyPayment($paymentID);
        if ($paymentDetails) {
            $verifyMessage = "Payment Verified: Amount: " . $paymentDetails['amount'] . " €, Method: " . $paymentDetails['payment_method'] . ", Status: " . $paymentDetails['payment_status'] . ".";
        } else {
            $verifyMessage = "Payment not found or invalid.";
        }
    } elseif ($action === 'getHistory') {
        $userID = isset($_POST['user_id']) ? (int)$_POST['user_id'] : null;
        $transactionHistory = $paymentManager->getTransactionHistory($userID);
    } elseif ($action === 'requestRefund') {
        $reason = $_POST['refund_reason'];
        $message = $paymentManager->requestRefund($paymentID, $reason);
        header("Location: viewpayments.php?message=" . urlencode($message));
        exit();
    }
}

$query = "SELECT p.payment_id, p.user_id, u.name, u.surname, p.amount, p.payment_method, p.payment_status, p.card_number, p.card_expiry, p.bank_account, p.paypal_email, p.payment_date
          FROM payments p
          LEFT JOIN users u ON p.user_id = u.id
          ORDER BY p.payment_date DESC";
$result = $conn->query($query);

if (!$result) {
    die("Error retrieving payments: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Travel-Agency/Models/web-design/css/dashboard.css">
    <link rel="stylesheet" href="../web-design/css/style.css">
    <title>View Payments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            margin: 20px auto;
            max-width: 1200px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #f4f4f4;
            color: #333;
        }
        form {
            margin-top: 10px;
        }
        form input, form select, form button {
            margin-right: 5px;
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        form button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<section id="header">
    <div class="header container">
        <div class="nav-bar">
            <div class="brand">
                <a href="dashboard.php"><h1><span>JO</span>-NA</h1></a>
            </div>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="bookings.php">Bookings</a></li>
                <li><a href="add_flight.php">Flights</a></li>
                <li><a href="traveler.php">Traveler</a></li>
                <li><a href="../../../Data/auth/config/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</section>

<div class="container">
    <h1>All Payments</h1>
    <?php if (!empty($verifyMessage)): ?>
        <p class="verify-message"><?php echo htmlspecialchars($verifyMessage); ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['message'])): ?>
        <p class="<?php echo htmlspecialchars($_GET['message']); ?>">
            <?php
            if ($_GET['message'] === 'processed') echo "Payment processed successfully!";
            elseif ($_GET['message'] === 'rejected') echo "Payment rejected successfully!";
            elseif ($_GET['message'] === 'refunded') echo "Payment refunded successfully!";
            elseif ($_GET['message'] === 'error') echo "An error occurred. Please try again.";
            ?>
        </p>
    <?php endif; ?>
    <table>
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>User</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['payment_id']); ?></td>
                <td><?php echo htmlspecialchars($row['name'] . ' ' . $row['surname']); ?></td>
                <td><?php echo htmlspecialchars($row['amount']); ?> €</td>
                <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                <td><?php echo htmlspecialchars($row['payment_status']); ?></td>
                <td>
                    <form method="POST" action="viewpayments.php" style="display: inline;">
                        <input type="hidden" name="payment_id" value="<?php echo $row['payment_id']; ?>">
                        <select name="new_status">
                            <option value="Processed">Processed</option>
                            <option value="Rejected">Rejected</option>
                            <option value="Refunded">Refunded</option>
                        </select>
                        <button type="submit" name="action" value="update" style="background-color: blue; color: white;">Update</button>
                    </form>
                    <form method="POST" action="viewpayments.php" style="display: inline;">
                        <input type="hidden" name="payment_id" value="<?php echo $row['payment_id']; ?>">
                        <button type="submit" name="action" value="verify" style="background-color: purple; color: white;">Verify</button>
                    </form>
                    <form method="POST" action="viewpayments.php" style="display: inline;">
                        <input type="hidden" name="payment_id" value="<?php echo $row['payment_id']; ?>">
                        <input type="text" name="refund_reason" placeholder="Reason for refund" required>
                        <button type="submit" name="action" value="requestRefund" style="background-color: orange; color: white;">Request Refund</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <h2>Transaction History</h2>
    <form method="POST" action="viewpayments.php">
        <label for="user_id">User ID (leave blank for all users):</label>
        <input type="number" name="user_id" id="user_id" placeholder="Enter User ID">
        <button type="submit" name="action" value="getHistory">View History</button>
    </form>
    <?php if (!empty($transactionHistory)): ?>
    <table>
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>User ID</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactionHistory as $transaction): ?>
                <tr>
                    <td><?php echo htmlspecialchars($transaction['payment_id']); ?></td>
                    <td><?php echo htmlspecialchars($transaction['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($transaction['amount']); ?> €</td>
                    <td><?php echo htmlspecialchars($transaction['payment_method']); ?></td>
                    <td><?php echo htmlspecialchars($transaction['payment_status']); ?></td>
                    <td><?php echo htmlspecialchars($transaction['payment_date']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
</body>
</html>