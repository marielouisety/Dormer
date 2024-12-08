<?php
include 'db_connect.php';

$roomNumber = $_POST['room_number'];

$sql = "DELETE FROM tenants WHERE room_number='$roomNumber'";

if ($conn->query($sql) === TRUE) {
    $updateRoomSql = "UPDATE rooms SET availability='Vacant' WHERE room_number='$roomNumber'";
    $conn->query($updateRoomSql);
    echo "Tenant deleted and room made vacant";
} else {
    echo "Error deleting tenant: " . $conn->error;
}

$conn->close();
?>
