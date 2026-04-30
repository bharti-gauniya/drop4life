<?php
session_start();
include "register_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. Check Donors Table
    $stmt = $conn->prepare("SELECT * FROM donors WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['donor_id']; // Ensure this matches your DB column
            $_SESSION['user_type'] = 'donor';
            header("Location: profile.php");
            exit();
        }
    }

    // 2. Check Recipients Table if not found in Donors
    $stmt = $conn->prepare("SELECT * FROM recipient WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['recipient_id']; // Ensure this matches your DB column
            $_SESSION['user_type'] = 'recipient';
            header("Location: profile.php");
            exit();
        }
    }

    echo "<script>alert('Invalid Email or Password'); window.location.href='login.html';</script>";
}
?>