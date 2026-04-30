<?php
session_start();
include "register_conn.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Find Donor</title>

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
    height: 100vh;
    overflow: hidden;
    background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),
    url("https://images.unsplash.com/photo-1615461066841-6116e61058f4");
    background-size: cover;
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

h2 {
    margin-bottom: 20px;
}

form {
    background: white;
    color: black;
    padding: 20px;
    border-radius: 10px;
    width: 300px;
    margin: auto;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
}

select, button {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    border: none;
}

button {
    background: #cc0000;
    color: white;
    cursor: pointer;
    font-weight: bold;
}

button:hover {
    background: #990000;
}

#results {
    margin-top: 30px;
}

.card {
    background: white;
    color: black;
    padding: 15px;
    margin: 10px auto;
    width: 300px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
}

.available {
    color: green;
    font-weight: bold;
}

.not-available {
    color: red;
    font-weight: bold;
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
.card button{
    background: #cc0000;
    color: white;
    border: none;
    padding: 10px;
    width: 100%;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
}

.card button:hover{
    background: #990000;
}
</style>

</head>

<body>
<nav>
  <h2 font-size:22px;>🩸 Drop4Life</h2>
  <ul>
  <li><a href="index.php">Home</a></li>
  <li><a href="find_donorr.php">Find Donors</a></li>
  <li><a href="need_blood.html">Need Blood</a></li>
  <li><a href="why_donate.html">Why Donate Blood</a></li>
  <li><a href="about_us.html">About Us</a></li>
</ul>
</nav>

<form method="GET" action="" >

<select id="blood_group" name="blood_group" required>
<option value="">Select Blood Group</option>
<option>A+</option>
<option>A-</option>
<option>B+</option>
<option>B-</option>
<option>O+</option>
<option>O-</option>
<option>AB+</option>
<option>AB-</option>
</select>

<select id="state" name="state" required>
<option value="">Select State</option>
</select>

<select id="city" name="city" required>
<option value="">Select City</option>
</select>
<button type="submit">Search</button>

</form>
<script>

// Load States (FIXED)
fetch("https://countriesnow.space/api/v0.1/countries/states", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify({
        country: "India"
    })
})
.then(response => response.json())
.then(data => {
    console.log(data); // 👈 IMPORTANT (debug)
    let stateSelect = document.getElementById("state");
    if(data.data && data.data.states) {
        data.data.states.forEach(state => {
            let option = document.createElement("option");
            option.value = state.name;
            option.textContent = state.name;
            stateSelect.appendChild(option);
        });
    } else {
        alert("State data not loaded!");
    }
})
.catch(error => {
    console.error("Error:", error);
    alert("Failed to load states");
});
// Load Cities
document.getElementById("state").addEventListener("change", function() {
    let state = this.value;

    fetch("https://countriesnow.space/api/v0.1/countries/state/cities", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ country: "India", state: state })
    })
    .then(res => res.json())
    .then(data => {
        let citySelect = document.getElementById("city");
        citySelect.innerHTML = "<option>Select City</option>";

        data.data.forEach(city => {
            let option = document.createElement("option");
            option.value = city;
            option.text = city;
            citySelect.appendChild(option);
        });
    });
});
</script>
<script>
function sendRequest(donorId, bloodGroup){

    fetch(`send_request2.php?donor_id=${donorId}&blood_group=${bloodGroup}`)
    .then(res => res.text())
    .then(data => {
        alert(data);
    });
}
// Update the function to accept city
function broadcastRequest(bloodGroup, city) {
    if(confirm(`No donors found. Would you like to broadcast an emergency for ${bloodGroup} in ${city}?`)) {
        // Pass both blood_group and city in the URL
        fetch(`broadcast_action.php?blood_group=${bloodGroup}&city=${city}`)
        .then(response => response.text())
        .then(message => {
            alert(message);
            window.location.href = 'index.php'; 
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Failed to send broadcast.");
        });
    }
}
</script>
<?php 
if(isset($_GET['blood_group']) && isset($_GET['state']) && isset($_GET['city'])){
    
    $blood = $_GET['blood_group'];
    $state = $_GET['state'];
    $city  = $_GET['city'];
    $sql = "SELECT * FROM donors 
            WHERE blood_group='$blood' 
            AND state='$state' 
            AND city='$city'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
            echo "<h2 style='color:white;text-align:center;'>Matching Donors</h2>";
        while($row = $result->fetch_assoc()){
            $status = "Available ✅";
            $class = "available";
            $isDisabled = "";

            if($row['last_donation'] != ""){
            $lastDate = new DateTime($row['last_donation']);
            $today = new DateTime();
            $diff = $today->diff($lastDate)->days;
            if($diff < 90){
                $status = "Not Available ❌ (Wait ".(90-$diff)." days)";
                $class = "not-available";
                $isDisabled = "disabled";
            }
        }
     echo "
    <div class='card'>
        <h3>".$row['donor_name']."</h3>
        <p><b>Blood Group:</b> ".$row['blood_group']."</p>
        <p><b>Location:</b> ".$row['city'].", ".$row['state']."</p>
        <p class='$class'>$status</p>
        
        <button onclick='sendRequest(".$row['donor_id'].", \"".$row['blood_group']."\")' 
                class='request-btn' 
                $isDisabled 
                style='".($isDisabled ? "background: #ccc; cursor: not-allowed;" : "")."'>
            ".($isDisabled ? "Unavailable" : "Request Blood")."
        </button>
    </div>";
}
}
else {
    echo "<div style='background: rgba(255,255,255,0.1); padding: 20px; border-radius: 10px; color: white; text-align: center; margin-top: 20px;'>";
    echo "<h3>No $blood donors found in your area.</h3>";
    // ADD $city TO THE ONCLICK FUNCTION BELOW
    // Check if user is logged in
    if (isset($_SESSION['user_id'])) {
        // Logged in users can broadcast
        echo "<p>Would you like to broadcast an emergency alert?</p>";
        echo "<button onclick='sendBroadcast(\"$blood\", \"$city\")' class='broadcast-btn' style='background: #ff4d4d; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;'>Broadcast Emergency</button>";
    } else {
        // Guests see the registration requirement msg
        echo "<p style='color: #ffbcbc; font-weight: bold;'>To broadcast an emergency alert to all donors, please register as a recipient first.</p>";
        echo "<a href='register.html' class='broadcast-btn' style='display: inline-block; background: #888; color: white; padding: 10px; border: none; border-radius: 5px; text-decoration: none; margin-top: 10px;'>Register to Broadcast</a>";
    }
    echo "</div>";
}
}
?>
</body>
</html>

