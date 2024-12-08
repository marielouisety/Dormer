<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newElectricityRate = $_POST['electricity_new'];
    $newWaterRate = $_POST['water_new'];

    // Update electricity rate
    $sql = "UPDATE services SET electricitybaseprice = ? WHERE electricitybaseprice = (SELECT MAX(electricitybaseprice) FROM services)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('d', $newElectricityRate);
    $stmt->execute();

    // Update water rate
    $sql = "UPDATE services SET waterbaseprice = ? WHERE waterbaseprice = (SELECT MAX(waterbaseprice) FROM services)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('d', $newWaterRate);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    header("Location: dashboard.php");
    exit();
}
?>
