<?php
include __DIR__ . '/config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "<script>alert('Ju lutem plotësoni të gjitha fushat!'); window.location.href='../../web-design/pages/login.php';</script>";
        exit();
    }

    $stmt = $conn->prepare("SELECT id, name, surname, email, password, user_type FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_surname'] = $row['surname'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_type'] = $row['user_type'];

            $stmt->close();
            $conn->close();

            if ($row['user_type'] == 1) {
                header("Location: ../../../Migrations/travel-management/dashboard/dashboard.php");
                exit();
            } else {
                header("Location: ../../../Models/web-design/pages/afterlogin.php");
                exit();
            }
        } else {
            echo "<script>alert('Fjalëkalimi është i pasaktë!'); window.location.href='../../web-design/pages/login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Ky email nuk është i regjistruar!'); window.location.href='../../web-design/pages/login.php';</script>";
        exit();
    }
}
?>
