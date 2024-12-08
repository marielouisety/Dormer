<?php

SESSION_START();

$id = $_SESSION['userID'];
$landlordname = $_SESSION['name'];
$role = $_SESSION['role'];

include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tenantId = $_POST['tenant_id'];
    $electricityConsumption = (float)$_POST['electricitycons'];
    $waterConsumption = (float)$_POST['watercons'];
    $electricityBasePrice = (float)$_POST['electricityBasePrice'];
    $waterBasePrice = (float)$_POST['waterBasePrice'];
    $dateOfPayment = $_POST['date_of_payment'];
    $amount = (float)$_POST['amount'];
    $errorMessage = '';

    // Calculate total cost
    $totalElectricityCost = $electricityConsumption * $electricityBasePrice;
    $totalWaterCost = $waterConsumption * $waterBasePrice;
    $totalCost = $totalElectricityCost + $totalWaterCost;

    // Update services table
    $updateServicesSql = "UPDATE services 
                          SET electricity = $electricityConsumption, water = $waterConsumption 
                          WHERE id = (SELECT servicesID FROM rooms WHERE room_number = (SELECT room_number FROM tenants WHERE tenantID = $tenantId))";
    if ($conn->query($updateServicesSql) === TRUE) {
        // Insert into payments table
        $insertPaymentSql = "INSERT INTO payments (tenantID, electricitybill, waterbill, amount, date_of_payment, status) 
                             VALUES ($tenantId, $totalElectricityCost, $totalWaterCost, $totalCost, '$dateOfPayment', '')";
        if ($conn->query($insertPaymentSql) === TRUE) {
            echo "<script>document.getElementById('errorMessage').value = '';</script>";
            echo "<script>window.location.href = 'dashboard.php';</script>"; // Redirect to a success page
        } else {
            $errorMessage = "Error: " . $insertPaymentSql . "<br>" . $conn->error;
        }
    } else {
        $errorMessage = "Error: " . $updateServicesSql . "<br>" . $conn->error;
    }

    if ($errorMessage) {
        echo "<script>document.getElementById('errorMessage').value = '$errorMessage';</script>";
        echo "<script>window.history.back();</script>"; // Return to the form page
    }

    $conn->close();
}
?>
