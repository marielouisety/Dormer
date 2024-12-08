<?php
session_start();
include 'db_connect.php';

// Fetch room number from query parameter
$room_number = $_GET['room_number'];

// Fetch room and tenant details
$sql = "SELECT rooms.room_number, rooms.availability, rooms.roomRentalFee, tenants.fName, tenants.lName, tenants.date_of_birth, tenants.gender, tenants.age, tenants.contact_number, tenants.email
        FROM rooms 
        LEFT JOIN tenants ON rooms.room_number = tenants.room_number
        WHERE rooms.room_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $room_number);
$stmt->execute();
$stmt->bind_result($room_number, $availability, $room_fee, $fName, $lName, $date_of_birth, $gender, $age, $contact_number, $email);
$stmt->fetch();
$stmt->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Room Details</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <img src="images/Dormer logo.png" alt="dormerlogo.png">
    </header>

    <div class="container">
        <h2><?php echo $fName . ' ' . $lName; ?></h2>
        <div class="detail-group">
            <p><span>Date of Birth:</span> <?php echo $date_of_birth; ?></p>
        </div>
        <div class="detail-group">
            <p><span>Gender:</span> <?php echo $gender; ?></p>
        </div>
        <div class="detail-group">
            <p><span>Age:</span> <?php echo $age; ?></p>
        </div>
        <div class="detail-group">
            <p><span>Phone Number:</span> <?php echo $contact_number; ?></p>
        </div>
        <div class="detail-group">
            <p><span>Email Address:</span> <?php echo $email; ?></p>
        </div>
        <div class="detail-group">
            <p><span>Room Number:</span> <?php echo $room_number; ?></p>
        </div>
        <div class="detail-group">
            <p><span>Room Rental Fee:</span> ₱<?php echo $room_fee; ?></p>
        </div>
        <div class="detail-group">
            <p><span>Status:</span> <?php echo $availability; ?></p>
        </div>
    </div>
</body>
</html>
