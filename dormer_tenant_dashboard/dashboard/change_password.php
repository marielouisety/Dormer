<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $tenantId = $_SESSION['userID']; // Assuming you have the tenant ID stored in session

    // Retrieve the current password hash from the database
    $sql = "SELECT password FROM tenants WHERE tenantID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $tenantId);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($currentPasswordHash);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        // Verify the current password
        if (password_verify($currentPassword, $currentPasswordHash)) {
            // Hash the new password for security
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the password in the database
            $sql = "UPDATE tenants SET password = ? WHERE tenantID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $hashedPassword, $tenantId);

            if ($stmt->execute()) {
                echo "Password successfully updated.";
            } else {
                echo "Error updating password: " . $conn->error;
            }
        } else {
            echo "Current password is incorrect.";
        }
    } else {
        echo "User not found.";
    }

    $stmt->close();
    $conn->close();
    header("Location: dashboard.php"); // Redirect back to the dashboard
    exit();
} else {
    echo "Invalid request method.";
}
?>
