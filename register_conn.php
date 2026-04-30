<?php
$conn = new mysqli("localhost", "root", "", "drop4life");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>