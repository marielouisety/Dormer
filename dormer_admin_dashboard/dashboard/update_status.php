<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reference_number = $_POST['reference_number'];
    $status = $_POST['status'];

    $update_sql = "UPDATE payments SET status = ? WHERE reference_number = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('si', $status, $reference_number);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard.php");
    exit();
}
?>
