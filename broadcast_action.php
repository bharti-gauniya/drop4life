<?php
session_start();
include "register_conn.php";

if (isset($_GET['blood_group']) && isset($_GET['city'])) {
    $bg = $_GET['blood_group'];
    $city = $_GET['city']; // Get city directly from the search result
    
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
    $msg = "URGENT: $bg blood needed in $city!";

    $sql = "INSERT INTO broadcasts (recipient_id, blood_group, city, message, status) 
            VALUES ('$user_id', '$bg', '$city', '$msg', 'Active')";

    if (mysqli_query($conn, $sql)) {
        echo "Emergency Broadcast sent successfully!";
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
}
?>