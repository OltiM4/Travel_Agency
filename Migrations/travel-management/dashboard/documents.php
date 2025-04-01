<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../../../Data/auth/config/config.php';

// Mesazhe per sukses ose gabime
$message = "";

// 1. uploadDocument() - Ngarko nje dokument te ri
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload_document'])) {
    $userID = $_SESSION['user_id'];
    $documentType = $_POST['documentType'];
    $documentStatus = "Pending";
    $issueDate = $_POST['issueDate'];
    $expirationDate = $_POST['expirationDate'];

    if (!empty($_FILES['documentFile']['name'])) {
        $filePath = '../../../uploads/' . basename($_FILES['documentFile']['name']);
        if (move_uploaded_file($_FILES['documentFile']['tmp_name'], $filePath)) {
            $stmt = $conn->prepare("INSERT INTO documents (userID, documentType, documentStatus, issueDate, expirationDate, documentFilePath) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssss", $userID, $documentType, $documentStatus, $issueDate, $expirationDate, $filePath);

            if ($stmt->execute()) {
                $message = "Document uploaded successfully!";
            } else {
                $message = "Error uploading document: " . $conn->error;
            }
        } else {
            $message = "Error uploading file.";
        }
    } else {
        $message = "Please select a file to upload.";
    }
}

// 2. validateDocument() - Kontrollo vlefshmerine e dokumentit
function validateDocument($expirationDate) {
    $currentDate = date('Y-m-d');
    return strtotime($expirationDate) >= strtotime($currentDate);
}

// 3. getDocumentsByType() - Merr dokumentet sipas tipit
function getDocumentsByType($conn, $userID, $type) {
    $stmt = $conn->prepare("SELECT * FROM documents WHERE userID = ? AND documentType = ?");
    $stmt->bind_param("is", $userID, $type);
    $stmt->execute();
    return $stmt->get_result();
}

// 4. deleteDocument() - Fshi nje dokument ekzistues
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_document'])) {
    $documentID = (int)$_POST['documentID'];

    $stmt = $conn->prepare("DELETE FROM documents WHERE documentID = ?");
    $stmt->bind_param("i", $documentID);

    if ($stmt->execute()) {
        $message = "Document deleted successfully!";
    } else {
        $message = "Error deleting document: " . $conn->error;
    }
}

// 5. getDocumentDetails() - Merr detajet e nje dokumenti
function getDocumentDetails($conn, $documentID) {
    $stmt = $conn->prepare("SELECT * FROM documents WHERE documentID = ?");
    $stmt->bind_param("i", $documentID);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// 6. updateDocumentStatus() - Perditeso statusin e dokumentit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $documentID = (int)$_POST['documentID'];
    $newStatus = $_POST['newStatus'];

    $stmt = $conn->prepare("UPDATE documents SET documentStatus = ? WHERE documentID = ?");
    $stmt->bind_param("si", $newStatus, $documentID);

    if ($stmt->execute()) {
        $message = "Document status updated successfully!";
    } else {
        $message = "Error updating document status: " . $conn->error;
    }
}

// 7. getExpiredDocuments() - Merr dokumentet e skaduara
function getExpiredDocuments($conn, $userID) {
    $stmt = $conn->prepare("SELECT * FROM documents WHERE userID = ? AND expirationDate < CURDATE()");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    return $stmt->get_result();
}

// 8. uploadVisa() - Ngarko nje dokument te tipit "Visa"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload_visa'])) {
    $_POST['documentType'] = 'Visa';
    include __FILE__; // Riperdorimi i kodit per uploadDocument
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Travel-Agency/Models/web-design/css/document.css">
    <title>Document Management</title>
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

<section class="documents">
    <div class="container">
        <h1>Document Management</h1>
        <?php if (!empty($message)): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <!-- Forma per ngarkimin e dokumenteve -->
        <form method="POST" enctype="multipart/form-data" class="document-form">
            <h2>Upload Document</h2>
            <label for="documentType">Document Type:</label>
            <input type="text" name="documentType" placeholder="e.g., Passport, Visa" required>
            <label for="issueDate">Issue Date:</label>
            <input type="date" name="issueDate" required>
            <label for="expirationDate">Expiration Date:</label>
            <input type="date" name="expirationDate" required>
            <label for="documentFile">Upload File:</label>
            <input type="file" name="documentFile" required>
            <button type="submit" name="upload_document">Upload Document</button>
        </form>

        <!-- Tabela per menaxhimin e dokumenteve -->
        <h2>Your Documents</h2>
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Issue Date</th>
                    <th>Expiration Date</th>
                    <th>Valid</th>
                    <th>File</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($document = $documentsQuery->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($document['documentType']); ?></td>
                    <td><?php echo htmlspecialchars($document['documentStatus']); ?></td>
                    <td><?php echo htmlspecialchars($document['issueDate']); ?></td>
                    <td><?php echo htmlspecialchars($document['expirationDate']); ?></td>
                    <td><?php echo validateDocument($document['expirationDate']) ? "Yes" : "No"; ?></td>
                    <td><a href="<?php echo htmlspecialchars($document['documentFilePath']); ?>" target="_blank">View</a></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="documentID" value="<?php echo $document['documentID']; ?>">
                            <button type="submit" name="delete_document">Delete</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="documentID" value="<?php echo $document['documentID']; ?>">
                            <select name="newStatus">
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                            <button type="submit" name="update_status">Update Status</button>
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
