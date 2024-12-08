<?php
SESSION_START();

$id = $_SESSION['userID'];
$landlordname = $_SESSION['name'];
$role = $_SESSION['role'];
?>
<?php

// Include the database connection file
include 'db_connect.php';

// Fetch room data along with tenant information
$sql = "SELECT rooms.room_number, rooms.availability, tenants.fName, tenants.lName 
        FROM rooms 
        LEFT JOIN tenants ON rooms.room_number = tenants.room_number";
$result = $conn->query($sql);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dormer</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link rel="stylesheet" href="tenatsstyles.css">
    <script src="index.js"></script>
</head>
<body>
    <header>
        <img src="images/Dormer logo.png" alt="dormerlogo.png">
        <div class="user-info">
            <?php
            if (isset($_SESSION['userID']) && isset($_SESSION['name']) && isset($_SESSION['role'])) {
                echo "<div class='userdetails'>". $_SESSION['userID'] . " " . $_SESSION['name'] . " - " . ucfirst($_SESSION['role']) ."</div>";
            } else {
                echo "<div class='userdetails'>Guest</div>";
            }
            ?>
        </div>
    </header>

    <div class="main">
        <div class="sidebar">
        <a href="../../dormer_admin_dashboard/dashboard/dashboard.php" class="dashboard">Dashboard</a>
            <a href="../../dormer_admin_dashboard/tenants/tenants.php" class="tenants">Tenants</a>
            <a href="../../dormer_admin_dashboard/changepassword/password.php" class="changepassword">Change Password</a>
            <a href="#" class="signout" onclick="confirmLogout()">Sign Out</a>
        </div>
            <div class="content">
            <h2 style="width: 100%;">Rooms</h2>
            <div class="rooms-list-container">
                <div class="rooms-list">
                    <?php
                    include 'db_connect.php';

                    // Query to get room and tenant details
                    $sqlRooms = "SELECT rooms.room_number, rooms.availability, tenants.fName, tenants.lName, tenants.date_of_birth, tenants.contact_number, tenants.age, tenants.gender, tenants.email 
                                FROM rooms 
                                LEFT JOIN tenants ON rooms.room_number = tenants.room_number 
                                ORDER BY rooms.room_number";
                    $resultRooms = $conn->query($sqlRooms);

                    if ($resultRooms->num_rows > 0) {
                        while ($row = $resultRooms->fetch_assoc()) {
                            $tenantName = !empty($row['fName']) && !empty($row['lName']) ? $row['fName'] . ' ' . $row['lName'] : 'No tenant';
                            $availability = $row['availability'] == 'Occupied' ? 'Occupied' : 'Vacant';
                            echo "<div class='room-box' onclick='showOverlay(\"{$row['room_number']}\", \"{$row['fName']}\", \"{$row['lName']}\", \"{$availability}\", \"{$row['date_of_birth']}\", \"{$row['contact_number']}\", \"{$row['age']}\", \"{$row['gender']}\", \"{$row['email']}\")'>";
                            echo "<h3>Room Number: " . $row['room_number'] . "</h3>";
                            echo "<p><strong>Tenant:</strong> " . $tenantName . "</p>";
                            echo "<p><strong>Status:</strong> " . $availability . "</p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No rooms available.</p>";
                    }

                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div id="overlay" class="overlay">
        <div class="overlay-content">
            <button class="close-btn" onclick="closeOverlay()"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
            </svg></button>
            <div id="tenantDetails">
                <!-- Tenant details will be populated here by JavaScript -->
            </div>
        </div>
    </div>



    <div class="addtenantcontainer" id="add-tenant-container">
        <div class="header">
            <span class="close" onclick="closecontainer()">&times;</span>
            <h1 class="roomnumber">Register a Tenant</h1>
            <h2 id="roomnumber-display"></h2>
        </div>
        <form method="POST" action="addtenants.php">
            <fieldset>
                <legend>Personal Information</legend>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter Email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter Password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Re-enter Password" required>
                </div>
                <div class="form-group">
                    <label for="surname">Surname</label>
                    <input type="text" id="surname" name="surname" placeholder="Enter Surname" required>
                </div>
                <div class="form-group">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" name="first-name" placeholder="Enter First Name" required>
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" placeholder="Enter Date of Birth">
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <input type="text" id="gender" name="gender" placeholder="Enter Gender" required>
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" placeholder="Enter Age" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter Phone Number" required>
                </div>
                <div class="form-group">
                    <label for="room-fee">Room Fee</label>
                    <input type="number" id="room-fee" name="room-fee" placeholder="Enter Room Fee" required>
                </div>
                <input type="hidden" id="roomnumber" name="roomnumber">
                <input type="hidden" id="landlordID" name="landlordID" value="<?php echo $_SESSION['userID']; ?>">
                <button type="submit">Register Tenant</button>
            </fieldset>
        </form>
    </div>
    </div>



    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>
