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
$password = $_POST['password'];
$confirmPassword = $_POST['confirm-password'];


if ($password !== $confirmPassword) {
    header('Location: tenants.php?error=Passwords do not match.');
    exit();
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO tenants (fName, lName, date_of_birth, contact_number, age, gender, email, password, room_number, landlordID) VALUES ('$fName', '$lName', '$dateOfBirth', '$contactNumber', '$age', '$gender', '$email', '$hashedPassword', '$roomNumber', $id)";

if ($conn->query($sql) === TRUE) {
    $updateRoomSql = "UPDATE rooms SET availability='Occupied' WHERE room_number='$roomNumber'";
    $conn->query($updateRoomSql);
    header('Location: tenants.php?success=Tenant added successfully');
} else {
    header('Location: tenants.php?error=Error adding tenant: ' . $conn->error);
}

$conn->close();
?>
