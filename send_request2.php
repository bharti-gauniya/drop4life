<?php
session_start();
include "register_conn.php";
// Find this block in send_request2.php
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'recipient') {
    echo "Access Denied: Please login or register as a recipient to request blood.";
    // Optional: Add a button in the response that JS can pick up to show a modal
    exit();
}

if (isset($_GET['donor_id']) && isset($_GET['blood_group'])) {
    $donor_id = $_GET['donor_id'];
    $recipient_id = $_SESSION['user_id'];
    $blood_group = $_GET['blood_group'];

    // Prevent duplicate requests
    $check_availability = "SELECT last_donation FROM donors WHERE donor_id = '$donor_id'";
$avail_res = $conn->query($check_availability);
$donor_data = $avail_res->fetch_assoc();

if($donor_data['last_donation'] != ""){
    $lastDate = new DateTime($donor_data['last_donation']);
    $diff = (new DateTime())->diff($lastDate)->days;
    if($diff < 90){
        echo "Error: This donor is not eligible to donate yet.";
        exit();
    }
}
    $check = "SELECT * FROM requests WHERE donor_id = '$donor_id' AND recipient_id = '$recipient_id' AND status = 'Pending'";
    $check_res = $conn->query($check);

    if ($check_res->num_rows > 0) {
        echo "You have already sent a pending request to this donor.";
    } else {
        $sql = "INSERT INTO requests (donor_id, recipient_id, blood_group) VALUES ('$donor_id', '$recipient_id', '$blood_group')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Request sent successfully! The donor will see it in their profile.";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>