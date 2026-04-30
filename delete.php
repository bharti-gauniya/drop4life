<?php
include "register_conn.php";
$id = $_GET['donor_id'];
$sql = "DELETE FROM donors WHERE donor_id=$id";
if($conn->query($sql) === TRUE){
    header("Location: admin_dashboard.php");
} else {
    echo "Error deleting record";
}
?>