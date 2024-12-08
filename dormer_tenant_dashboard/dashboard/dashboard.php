<?php
SESSION_START();

$id = $_SESSION['userID'];
$landlordname = $_SESSION['name'];
$role = $_SESSION['role'];

$servername = "localhost";
$username = "root";  
$password = "";  
$dbname = "dormerdb";  

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you get tenantID from a GET parameter or session
$tenantID = isset($_GET['tenantID']) ? intval($_GET['tenantID']) : 1;  // Example tenantID

$sql = "SELECT tenants.*, rooms.room_number, rooms.roomRentalFee
FROM tenants
JOIN rooms ON tenants.room_number = rooms.room_number
WHERE tenants.tenantID = $id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch tenant data
    $tenant = $result->fetch_assoc();
} else {
    echo "No tenant found";
    $tenant = null;
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Dashboard</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
    <script>
        function showChangePasswordForm() {
            document.getElementById('changePasswordModal').style.display = 'block';
        }

        function hideChangePasswordForm() {
            document.getElementById('changePasswordModal').style.display = 'none';
        }

        function submitChangePasswordForm() {
            var currentPassword = document.getElementById('currentPassword').value;
            var newPassword = document.getElementById('newPassword').value;
            var confirmPassword = document.getElementById('confirmPassword').value;

            if (currentPassword === '') {
                alert('Please enter your current password.');
                return;
            }
            if (newPassword === '') {
                alert('Please enter a new password.');
                return;
            }
            if (confirmPassword === '') {
                alert('Please confirm your new password.');
                return;
            }
            if (newPassword !== confirmPassword) {
                alert('New password and confirm password do not match.');
                return;
            }

            document.getElementById('changePasswordForm').submit();
        }

        function confirmLogout() {
            var confirmation = confirm("Are you sure you want to logout?");
            if (confirmation) {
                window.location.href = 'logout.php'; // Redirect to the logout script
            }
        }
    </script>
</head>
<body>
    <div class="header">
        <img src="dormer.png" alt="Dormer">
    </div>
    <div class="container">
        <div class="flex-container">
            <div class="details">
            <div class="info">
                <?php if ($tenant): ?>
                    <h1 style="color: black"><?php echo htmlspecialchars($tenant['fName'] .' '. $tenant['lName']); ?></h1>
                    <p>Tenant ID: <?php echo htmlspecialchars($tenant['tenantID']); ?></p>
                    <p>Room Number: <?php echo htmlspecialchars($tenant['room_number']); ?></p>
                    <p>Room Rental Fee: <?php echo htmlspecialchars($tenant['roomRentalFee']); ?></p>
                    <p>Age: <?php echo htmlspecialchars($tenant['age']); ?></p>
                    <p>Date of Birth: <?php echo htmlspecialchars($tenant['date_of_birth']); ?></p>
                    <p>Email: <?php echo htmlspecialchars($tenant['email']); ?></p>
                    <p>Contact Number: <?php echo htmlspecialchars($tenant['contact_number']); ?></p>
                <?php else: ?>
                    <p>No tenant information available.</p>
                <?php endif; ?>
            </div>
                <div class="transactions">
                    <h3 class="subtitle">Recent Transactions</h3>
                    <div class="table-container">
                        <table>
                            <tbody>
                                <?php
                                    echo"<thead>
                                        <tr>
                                        <th>Reference Number</th>
                                        <th>Room Number</th>
                                        <th>Tenant ID</th>
                                        <th>Tenant Name</th>
                                        <th>Date of Payment</th>
                                        <th>Electricity Cost</th>
                                        <th>Water Cost</th>
                                        <th>Room Rent Fee</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        </tr>
                                    </thead>";

                                    
                                include 'db_connection.php';
                                
                                function getStatus($date_of_payment, $current_status) {
                                    if ($current_status == "Paid") {
                                        return "Paid";
                                    }
                                
                                    // Create DateTime objects for the payment date and current date
                                    $payment_date = new DateTime($date_of_payment);
                                    $current_date = new DateTime();
                                    
                                    // Calculate the interval
                                    $interval = $current_date->diff($payment_date);
                                
                                    if ($interval->days == 0) {
                                        return "Payment Date";
                                    } elseif ($interval->invert == 0 && $interval->days <= 30) {
                                        return "Payment Due";
                                    } else {
                                        return "Payment Overdue";
                                    }
                                }
                                
                                

                                $statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
                                
                                $sql = "SELECT
                                        payments.reference_number,
                                        tenants.room_number,
                                        tenants.tenantID,
                                        payments.date_of_payment,
                                        payments.amount,
                                        payments.status,
                                        tenants.fName,
                                        tenants.lName,
                                        rooms.room_number,
                                        rooms.roomRentalFee,
                                        payments.electricitybill,
                                        payments.waterbill
                                    FROM
                                        payments
                                    JOIN
                                        tenants ON payments.tenantID = tenants.tenantID
                                    JOIN
                                        rooms ON tenants.room_number = rooms.room_number
                                    JOIN
                                        services ON rooms.servicesID = services.id 
                                    WHERE
                                        tenants.tenantID = $id";


                                    if ($statusFilter) {
                                        if ($statusFilter != 'Paid') {
                                            $sql .= " WHERE payments.status IN ('Payment Due', 'Payment Today', 'Payment Overdue')";
                                        } elseif ($statusFilter == 'Paid') {
                                            $sql .= " WHERE payments.status = 'Paid'";
                                        }
                                    }

                                    $sql .= " ORDER BY payments.reference_number DESC";

                                    $stmt = $conn->prepare($sql);
        

                                    $stmt->execute();
                                    $result = $stmt->get_result();    
                                
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        $status = getStatus($row['date_of_payment'], $row['status']);
                                        
                                        // Update the status in the database if it has changed
                                        if ($row['status'] !== $status && $row['status'] !== "Paid") {
                                            $update_sql = "UPDATE payments SET status = ? WHERE reference_number = ?";
                                            $stmt_update = $conn->prepare($update_sql);
                                            $stmt_update->bind_param('si', $status, $row['reference_number']);
                                            $stmt_update->execute();
                                            $stmt_update->close();
                                        }
                                
                                        echo "<tr data-id='{$row['reference_number']}'>
                                            <td class='ref-num'>{$row['reference_number']}</td>
                                            <td class='room-num'>{$row['room_number']}</td>
                                            <td class='tenant-id'>{$row['tenantID']}</td>
                                            <td class='tenant-name'>" . $row["fName"] . " " . $row["lName"] . "</td>
                                            <td class='date'>{$row['date_of_payment']}</td>
                                            <td class='eleccost'>{$row['electricitybill']}</td>
                                            <td class='watercost'>{$row['waterbill']}</td>
                                            <td class='roomrentalfee'>{$row['roomRentalFee']}</td>
                                            <td class='amount'>{$row['amount']}</td>
                                            <td class='status'><span class='" . ($status == 'Payment Overdue' ? 'overdue' : '') . "'>{$status}</span></td>";
                                        }
                                } else {
                                    echo "<tr><td colspan='8'>No transactions found</td></tr>";
                                }
                                $conn->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
        <div class="actions">
            <a href="#" onclick="showChangePasswordForm()">Change Password</a>
            <a href="#" onclick="confirmLogout()">Sign Out</a>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div id="changePasswordModal">
        <div id="changePasswordModalContent">
            <span onclick="hideChangePasswordForm()" style="float: right; cursor: pointer;">&times;</span>
            <h2>Change Password</h2>
            <form id="changePasswordForm" action="change_password.php" method="POST">
                <label for="currentPassword">Current Password:</label>
                <input type="password" id="currentPassword" name="currentPassword" required>
                <br>
                <label for="newPassword">New Password:</label>
                <input type="password" id="newPassword" name="newPassword" required>
                <br>
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
                <br>
                <button type="button" onclick="submitChangePasswordForm()">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>
