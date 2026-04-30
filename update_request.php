<?php
session_start();
include "register_conn.php";

if (isset($_GET['req_id'])) {
    $req_id = $_GET['req_id'];
    
    // Update the status to 'Accepted'
    $sql = "UPDATE requests SET status = 'Accepted' WHERE request_id = '$req_id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Request Accepted!'); window.location.href='profile.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>