
<?php
include "register_conn.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
$name = $_POST['name'];
$gender = $_POST['gender'];
$age = $_POST['age'];
$blood = $_POST['blood'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$health = $_POST['health'];
$date = $_POST['lastDate'];
$state = $_POST['state'];
$city = $_POST['district'];
$password = trim($_POST['password']);
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$sql = "INSERT INTO donors 
(donor_name, donor_gender, donor_age, blood_group, phone, email, password, health_status, last_donation, state, city)
VALUES 
('$name','$gender','$age','$blood','$phone','$email','$hashed_password','$health','$date','$state','$city')";
if ($conn->query($sql) === TRUE) {
    echo '<script>
            alert("Registration Successful! Welcome to Drop4Life.");
            window.location.href = "index.php"; 
         </script>';
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>