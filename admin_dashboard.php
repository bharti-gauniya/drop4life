<?php
include "register_conn.php";
?>

<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Drop4Life - Admin Dashboard</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

/* BODY */
body {
    background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),
    url("https://images.unsplash.com/photo-1615461066841-6116e61058f4");
    background-size: cover;
    color: white;
}

/* HEADER */
.header {
    padding: 20px;
    text-align: center;
    background: rgba(255,0,0,0.8);
    font-size: 24px;
    font-weight: bold;
}

/* CONTAINER */
.container {
    padding: 20px;
}

/* BUTTONS */
.actions {
    margin-bottom: 20px;
}

.actions a {
    text-decoration: none;
    padding: 10px 15px;
    margin-right: 10px;
    background: #ff1a1a;
    color: white;
    border-radius: 8px;
    transition: 0.3s;
}

.actions a:hover {
    background: #cc0000;
    transform: scale(1.05);
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(8px);
}

th, td {
    padding: 12px;
    text-align: center;
}

th {
    background: #ff3333;
}

tr:hover {
    background: rgba(255,255,255,0.2);
}

/* DELETE BUTTON */
.delete-btn {
    background: #ff4d4d;
    padding: 5px 10px;
    border-radius: 5px;
    color: white;
    text-decoration: none;
}

.delete-btn:hover {
    background: darkred;
}
</style>

</head>

<body>

<div class="header">
    ❤️ Drop4Life Admin Dashboard
</div>

<div class="container">

```
<div class="actions">
    <a href="register.html">➕ Add Donor</a>
    <a href="admin_login.html">🚪 Logout</a>
</div>

<h2>Registered Donors</h2>

<table border="1">
    <tr>
        <th>Name</th>
        <th>Gender</th>
        <th>Age</th>
        <th>Blood</th>
        <th>Phone</th>
        <th>City</th>
        <th>Action</th>
    </tr>

    <?php
    $sql = "SELECT * FROM donors";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
            <td>".$row['donor_name']."</td>
            <td>".$row['donor_gender']."</td>
            <td>".$row['donor_age']."</td>
            <td>".$row['blood_group']."</td>
            <td>".$row['phone']."</td>
            <td>".$row['city']."</td>
            <td>
                <a class='delete-btn' href='delete.php?donor_id=".$row['donor_id']."'>Delete</a>
            </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No donors found</td></tr>";
    }
    ?>

</table>
</div>
</body>
</html>