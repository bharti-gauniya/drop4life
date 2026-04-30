<?php
include "register_conn.php";

// Fetch total number of donors
$total_sql = "SELECT COUNT(*) as total FROM donors";
$total_res = mysqli_query($conn, $total_sql);
$total_data = mysqli_fetch_assoc($total_res);
$total_donors = $total_data['total'];

// Fetch breakdown by blood group
$group_sql = "SELECT blood_group, COUNT(*) as count FROM donors GROUP BY blood_group";
$group_result = mysqli_query($conn, $group_sql);
$broadcast_sql = "SELECT * FROM broadcasts WHERE status = 'Active' ORDER BY created_at DESC LIMIT 5";
$broadcast_res = mysqli_query($conn, $broadcast_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Drop4Life</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family: 'Poppins', sans-serif;
}

/* NAVBAR */
nav{
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:15px 50px;
  box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

nav h2{
  color:white;
}

body {
    margin: 0;
    padding: 0;
    min-height: 100vh;
    /* This ensures the background image never moves or turns white */
    background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),
    url("https://images.unsplash.com/photo-1615461066841-6116e61058f4");
    background-size: cover;
    background-attachment: fixed;
    background-position: center;
    overflow-x: hidden;
}

/* The horizontal container for your text and inventory */
.main-container {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 100px 50px; /* Adjust top padding so it sits below navbar */
    gap: 40px;
}

.hero-text {
    flex: 1;
    max-width: 50%;
}

.inventory-sidebar {
    flex: 1;
    max-width: 400px;
    background: rgba(255, 255, 255, 0.1); /* Glass effect */
    backdrop-filter: blur(10px);
    padding: 25px;
    border-radius: 15px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
}
.hero {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 50px;
    height: calc(100vh - 80px); /* Adjust based on navbar height */
}
/* New style for the right-side inventory */
.hero-inventory {
    max-width: 45%;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    padding: 30px;
    border-radius: 15px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
}
nav ul{
  display:flex;
  list-style:none;
  gap:30px;
}

nav ul li{
  cursor:pointer;
}

.login-btn {
  text-decoration: none;
  padding: 8px 15px;
  border-radius: 20px;
  color: #8B0000;
  font-weight: 500;
}

.signup-btn {
  background: #ff4d4d;
  color: white;
  padding: 8px 15px;
  border-radius: 20px;
  text-decoration: none;
}

.login-btn:hover {
  color: #ff1a1a;
}

.signup-btn:hover {
  background: #ff1a1a;
}
/* HERO SECTION */

.hero-text h1{
  font-size:80px;
  color:white;
}

.hero-text p{
  margin:20px 0;
  color:white;
  font-size: 25px;
}

.donate-btn{
  padding:12px 25px;
  background:#ff1a1a;
  color:white;
  border:none;
  border-radius:30px;
  font-size:22px;
  cursor:pointer;
  transition:0.3s;
}

.donate-btn:hover{
  transform:scale(1.05);
  box-shadow:0 5px 15px rgba(255,0,0,0.4);
}

/* IMAGE */
.hero img{
  width:500px;
}

nav ul li a {
  color:white;   /* dark red */
  text-decoration: none;
  font-weight: 600;
  transition: 0.3s;
  font-size:22px;
}
.close{
  float:right;
  cursor:pointer;
}
nav ul li a {
  position: relative;
}
nav ul li a:hover {
  color: #ff1a1a;   /* brighter red on hover */
  border-bottom: 2px solid #ff1a1a;
  padding-bottom: 3px;
}
nav ul li a::after {
  content: "";
  position: absolute;
  width: 0%;
  height: 2px;
  bottom: -3px;
  left: 0;
  background-color: #ff1a1a;
  transition: 0.3s;
}

nav ul li a:hover::after {
  width: 100%;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav>
  <h2 font-size:22px; style="color:#e60023;">🩸 Drop4Life</h2>
  <ul>
  <li><a href="index.php">Home</a></li>
  <li><a href="find_donorr.php">Find Donors</a></li>
  <li><a href="need_blood.html">Need Blood</a></li>
  <li><a href="why_donate.html">Why Donate Blood</a></li>
  <li><a href="about_us.html">About Us</a></li>
</ul>
 <div class="auth-buttons">
    
    <a href="login.html" style="text-decoration: none;">
        <button class="login-btn">login</button>
    </a>
</div>
</nav>

<!-- HERO SECTION -->
<section class="hero">
  <div class="hero-text">
    <h1>Donate Blood<br>and get real blessings.</h1>
    <p>Blood is the most precious gift that anyone can give to another person.
       Donating blood not only saves lives but also benefits the donor.</p>
    <a href="register.html">
      <button class="donate-btn">Donate Now</button>
    </a>
  </div>

  <div class="hero-inventory">
    <h2 style="color: #ff4d4d; margin-bottom: 15px; font-size: 28px;">Live Inventory</h2>
    
    <div style="background: #cc0000; padding: 15px; border-radius: 10px; margin-bottom: 20px; text-align: center;">
        <span style="font-size: 14px; text-transform: uppercase;">Total Registered Donors</span>
        <h2 style="font-size: 40px; margin: 0;"><?php echo $total_donors; ?></h2>
    </div>

    <table style="width: 100%; border-collapse: collapse; font-size: 16px;">
      <tr style="border-bottom: 2px solid #ff4d4d;">
        <th style="padding: 8px 0;">Blood Group</th>
        <th style="padding: 8px 0; text-align: right;">Available</th>
      </tr>
      <?php 
      mysqli_data_seek($group_result, 0); // Reset pointer to start of results
      while($row = mysqli_fetch_assoc($group_result)) {
          echo "<tr style='border-bottom: 1px solid rgba(255,255,255,0.1);'>";
          echo "<td style='padding: 8px 0; font-weight: bold;'>".$row['blood_group']."</td>";
          echo "<td style='padding: 8px 0; text-align: right;'>".$row['count']."</td>";
          echo "</tr>";
      }
      ?>
    </table>
    <div style="margin-top: 25px; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 15px;">
    <h3 style="color: #ff4d4d; font-size: 18px; margin-bottom: 10px; display: flex; align-items: center;">
        <span style="margin-right: 8px;">📢</span> Emergency Broadcasts
    </h3>
    
    <div class="broadcast-container" style="max-height: 200px; overflow-y: auto; padding-right: 5px;">
        <?php if (mysqli_num_rows($broadcast_res) > 0): ?>
            <?php while($b_row = mysqli_fetch_assoc($broadcast_res)): ?>
                <div style="background: rgba(255, 0, 0, 0.15); border-left: 4px solid #ff4d4d; padding: 10px; margin-bottom: 10px; border-radius: 4px;">
                    <p style="margin: 0; font-size: 14px; font-weight: bold; color: #ffbcbc;">
                        Needs <?php echo $b_row['blood_group']; ?> in <?php echo $b_row['city']; ?>
                    </p>
                    <p style="margin: 5px 0 0; font-size: 12px; opacity: 0.9;">
                        Posted: <?php echo date('M d, h:i A', strtotime($b_row['created_at'])); ?>
                    </p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="font-size: 13px; opacity: 0.6; font-style: italic;">No active emergency requests.</p>
        <?php endif; ?>
    </div>
</div>
  </div>
</section>
</body>
</html>
