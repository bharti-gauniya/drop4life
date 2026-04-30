<?php
$username = $_POST['username'];
$password = $_POST['password'];

// simple login (for project)
if($username == "admin" && $password == "1234") {
    header("Location: admin_dashboard.php");
} else {
    echo '<script>
            alert("Invalid Login!");  
         </script>';
    exit();
}
?>