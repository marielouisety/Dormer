<?php
include 'db_connect.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reference_number = $_POST['reference_number'];
    $tenant_id = $_POST['tenant_id'];
    $tenant_fname = $_POST['tenant_fname'];
    $tenant_lname = $_POST['tenant_lname'];
    $date_of_payment = $_POST['date_of_payment'];
    $amount = $_POST['amount'];
    $status = $_POST['status'];

    // Update payments table
    $sql_payments = "UPDATE payments 
                     SET date_of_payment = ?, amount = ?, status = ? 
                     WHERE reference_number = ?";
    $stmt_payments = $conn->prepare($sql_payments);
    $stmt_payments->bind_param("sdsi", $date_of_payment, $amount, $status, $reference_number);
    $stmt_payments->execute();

    // Update tenants table
    $sql_tenants = "UPDATE tenants 
                    SET fName = ?, lName = ? 
                    WHERE tenantID = ?";
    $stmt_tenants = $conn->prepare($sql_tenants);
    $stmt_tenants->bind_param("ssi", $tenant_fname, $tenant_lname, $tenant_id);
    $stmt_tenants->execute();

    // Close statements and connection
    $stmt_payments->close();
    $stmt_tenants->close();
    $conn->close();

    // Redirect back to the dashboard
    header('Location: dashboard.php');
    exit;
}
?>
