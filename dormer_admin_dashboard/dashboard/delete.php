<?php
include 'db_connect.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reference_number = $_POST['reference_number'];

    // Start transaction
    $conn->begin_transaction();

    try {
        // Delete from payments table
        $sql_payments = "DELETE FROM payments WHERE reference_number = ?";
        $stmt_payments = $conn->prepare($sql_payments);
        $stmt_payments->bind_param("i", $reference_number);
        $stmt_payments->execute();

        // Commit transaction
        $conn->commit();

        echo "Record deleted successfully";
    } catch (Exception $e) {
        // Rollback transaction
        $conn->rollback();
        echo "Error deleting record: " . $e->getMessage();
    }

    $stmt_payments->close();
    $conn->close();

    // Redirect back to the dashboard
    header('Location: dashboard.php');
    exit;
}
?>
