<?php
include "register_conn.php";

$name = $_POST['name'];
$blood = $_POST['blood'];
$units = $_POST['units'];
$phone = $_POST['phone'];
$email = $_POST['email'];

$date = $_POST['date'];
$reason = $_POST['reason'];
$otherReason = $_POST['otherReason'];
$hospital = $_POST['hospital'];
$city = $_POST['city'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
// If "Other" selected, use custom reason
if($reason == "Other"){
    $reason = $otherReason;
}
$status = "Pending";

$sql = "INSERT INTO recipient 
(recipient_Name, bloodGroup, requiredUnits, contactNo, email, requestDate, requestStatus, password)
VALUES 
('$name', '$blood', '$units', '$phone','$email' ,'$date', '$status','$password')";

if($conn->query($sql) === TRUE){
    $new_user_id = $conn->insert_id; 

    // NEW: Log them in automatically
    session_start();
    $_SESSION['user_id'] = $new_user_id;
    $_SESSION['user_type'] = 'recipient';
    echo "<script>alert(' Request Submitted Successfully!');
     window.location.href='find_donorr.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>