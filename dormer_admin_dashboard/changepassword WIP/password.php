<?php
SESSION_START();

$id = $_SESSION['userID'];
$landlordname = $_SESSION['name'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dormer</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <img src="../../images/Dormer logo.png" alt="dormerlogo.png">
        <div class="user-info">
            <?php
            if (isset($_SESSION['userID']) && isset($_SESSION['name']) && isset($_SESSION['role'])) {
                echo "<div class='userdetails'>". $_SESSION['userID'] . " " . $_SESSION['name'] . " - " . ucfirst($_SESSION['role']) ."</div>";
            } else {
                echo "<div class='userdetails'>Guest</div>";
            }
            ?>
        </div>
    </header>
        <div class="container">
            <div class="back-arrow">
                <span>&larr;</span>
            </div>
            <div class="form-container">
            <h1>Change Password</h1>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                include 'db_connect.php';

                session_start();
                $userId = $_SESSION['user_id']; // Assuming user_id is stored in session
                $oldPassword = $_POST['old-password'];
                $newPassword = $_POST['new-password'];
                $confirmPassword = $_POST['confirm-password'];
                $error = '';

                // Fetch current password from database
                $sql = "SELECT password FROM users WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $stmt->bind_result($currentPasswordHash);
                $stmt->fetch();
                $stmt->close();

                // Verify old password
                if (!password_verify($oldPassword, $currentPasswordHash)) {
                    $error = 'Old password is incorrect.';
                } elseif ($newPassword !== $confirmPassword) {
                    $error = 'New password and confirm password do not match.';
                } else {
                    // Hash the new password and update it in the database
                    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                    $updateSql = "UPDATE users SET password = ? WHERE id = ?";
                    $updateStmt = $conn->prepare($updateSql);
                    $updateStmt->bind_param("si", $newPasswordHash, $userId);

                    if ($updateStmt->execute()) {
                        echo '<p class="success">Password changed successfully.</p>';
                    } else {
                        $error = 'Failed to change password. Please try again.';
                    }

                    $updateStmt->close();
                }

                $conn->close();

                if ($error) {
                    echo '<p class="error">' . $error . '</p>';
                }
            }
            ?>
            <form method="POST">
                <label for="old-password">Old Password</label>
                <input type="password" id="old-password" name="old-password" placeholder="Enter Old Password" required>

                <label for="new-password">New Password</label>
                <input type="password" id="new-password" name="new-password" placeholder="Enter New Password" required>

                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Re-enter Password" required>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>
