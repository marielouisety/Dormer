<?php
include 'db_connect.php';

SESSION_START();

$id = $_SESSION['userID'];
$landlordname = $_SESSION['name'];
$role = $_SESSION['role'];

$roomNumber = $_POST['room_number'];
$fName = $_POST['fName'];
$lName = $_POST['lName'];
$dateOfBirth = $_POST['dateOfBirth'];
$contactNumber = $_POST['contactNumber'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$email = $_POST['email'];

$sql = "UPDATE tenants SET fName='$fName', lName='$lName', date_of_birth='$dateOfBirth', contact_number='$contactNumber', age='$age', gender='$gender', email='$email', landlordID='$id' WHERE room_number='$roomNumber'";

if ($conn->query($sql) === TRUE) {
    echo "Tenant updated successfully";
} else {
    echo "Error updating tenant: " . $conn->error;
}

$conn->close();
?>
