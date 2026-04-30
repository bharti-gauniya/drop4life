<?php
session_start();
include "register_conn.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$id = $_SESSION['user_id'];
$type = $_SESSION['user_type'];

// --- DATA FETCHING LOGIC ---
if ($type == 'donor') {
    $query = "SELECT * FROM donors WHERE donor_id = '$id'";
    $res = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($res);
    
    $name = $data['donor_name'];
    $blood = $data['blood_group'];
    $city = $data['city'];
    $age = $data['donor_age'];
    $gender = $data['donor_gender'];
    $phone = $data['phone'];
} else {
    $query = "SELECT * FROM recipient WHERE recipient_id = '$id'";
    $res = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($res);
    
    $name = $data['recipient_Name'];
    $blood = $data['bloodGroup'];
    $phone = $data['contactNo'];
    
    // Set these to null for recipients to avoid "Undefined Variable" errors
    $age = null;
    $gender = null;
    $city = null;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Drop4Life Profile</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .profile-box { border: 2px solid #d32f2f; padding: 20px; width: 400px; margin: 20px auto; border-radius: 10px; background: white; box-shadow: 0px 4px 8px rgba(0,0,0,0.1); }
        .label { font-weight: bold; color: #555; }
        .blood { color: red; font-size: 1.2em; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #d32f2f; color: white; }
        .btn-logout { background-color: #cc0000; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px; }
    </style>
</head>
<body>

    <div class="profile-box">
        <h2>Welcome, <?php echo $name; ?></h2>
        <p><span class="label">User Type:</span> <?php echo ucfirst($type); ?></p>
        <hr>
        <p><span class="label">Blood Group:</span> <span class="blood"><?php echo $blood; ?></span></p>
        
        <?php if ($type == 'donor'): ?>
            <p><span class="label">City:</span> <?php echo $city; ?></p>
            <p><span class="label">Age:</span> <?php echo $age; ?></p>
            <p><span class="label">Gender:</span> <?php echo $gender; ?></p>
        <?php endif; ?>
        
        <p><span class="label">Phone:</span> <?php echo $phone; ?></p>
        
        <div style="text-align: center;">
            <a href="logout.php" class="btn-logout">Logout from Drop4Life</a>
        </div>
    </div>

    <div class="container" style="max-width: 800px; margin: 0 auto;">
        
        <?php if ($type == 'donor'): ?>
            <h3>Incoming Blood Requests</h3>
            <table>
                <tr>
                    <th>Recipient Name</th>
                    <th>Blood Needed</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php
                $req_sql = "SELECT r.*, rec.recipient_Name, rec.contactNo 
                            FROM requests r 
                            JOIN recipient rec ON r.recipient_id = rec.recipient_id 
                            WHERE r.donor_id = '$id' 
                            ORDER BY r.request_id DESC";
                $req_result = mysqli_query($conn, $req_sql);

                if (mysqli_num_rows($req_result) > 0) {
                    while ($row = mysqli_fetch_assoc($req_result)) {
                        echo "<tr>
                                <td>{$row['recipient_Name']}</td>
                                <td>{$row['blood_group']}</td>
                                <td>{$row['contactNo']}</td>
                                <td>{$row['status']}</td>
                                <td>";
                        if ($row['status'] == 'Pending') {
                            echo "<a href='update_request.php?req_id={$row['request_id']}' style='color:green; font-weight:bold;'>Accept</a>";
                        } else {
                            echo "Accepted ✅";
                        }
                        echo "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align:center;'>No requests yet.</td></tr>";
                }
                ?>
            </table>

        <?php else: ?>
            <h3 style="color: #cc0000;">My Sent Requests</h3>
            <table>
                <tr>
                    <th>Donor Name</th>
                    <th>Blood Group</th>
                    <th>Status</th>
                    <th>Contact Details</th>
                </tr>
                <?php
                $my_req_sql = "SELECT r.*, d.donor_name, d.phone, d.email 
                               FROM requests r 
                               JOIN donors d ON r.donor_id = d.donor_id 
                               WHERE r.recipient_id = '$id'
                               ORDER BY r.request_id DESC";
                $my_req_res = mysqli_query($conn, $my_req_sql);

                if (mysqli_num_rows($my_req_res) > 0) {
                    while ($my_row = mysqli_fetch_assoc($my_req_res)) {
                        $isAccepted = ($my_row['status'] == 'Accepted');
                        $status_color = $isAccepted ? 'green' : 'orange';
                        
                        echo "<tr>
                                <td>{$my_row['donor_name']}</td>
                                <td>{$my_row['blood_group']}</td>
                                <td style='color:$status_color; font-weight:bold;'>{$my_row['status']}</td>
                                <td>";
                        if ($isAccepted) {
                            echo "📞 {$my_row['phone']}<br>📧 {$my_row['email']}";
                        } else {
                            echo "<i style='color:#888;'>Locked until Accepted</i>";
                        }
                        echo "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' style='text-align:center;'>You haven't sent any requests yet.</td></tr>";
                }
                ?>
            </table>
        <?php endif; ?>
    </div>

</body>
</html>