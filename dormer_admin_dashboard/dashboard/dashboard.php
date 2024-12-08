<?php
SESSION_START();

$id = $_SESSION['userID'];
$landlordname = $_SESSION['name'];
$role = $_SESSION['role'];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dormer</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link rel="stylesheet" href="dashboardstyles.css">
    <script src="index.js"></script>
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

    <div class="main">
        <div class="sidebar">
            <a href="../../dormer_admin_dashboard/dashboard/dashboard.php" class="dashboard">Dashboard</a>
            <a href="../../dormer_admin_dashboard/tenants/tenants.php" class="tenants">Tenants</a>
            <a href="../../dormer_admin_dashboard/changepassword/password.php" class="changepassword">Change Password</a>
            <a href="#" class="signout" onclick="confirmLogout()">Sign Out</a>
        </div>
        <div class="content">
            <div class="statsheader">
                <div class="vacantrooms">
                    <div class="text">
                        <p>Vacant Rooms</p>
                        <?php
                                include 'db_connect.php';

                                // Query to get the total number of rooms
                                $sqlTotalRooms = "SELECT COUNT(room_number) as totalRooms FROM rooms;";
                                $resultTotalRooms = $conn->query($sqlTotalRooms);
                                $rowTotalRooms = $resultTotalRooms->fetch_assoc();
                                
                                // Query to get the number of occupied rooms
                                $sqlOccupiedRooms = "SELECT COUNT(room_number) as occupiedRooms FROM rooms WHERE availability != 'Occupied';";
                                $resultOccupiedRooms = $conn->query($sqlOccupiedRooms);
                                $rowOccupiedRooms = $resultOccupiedRooms->fetch_assoc();
                                
                                echo "<div class='room-stats' stlye='font-weight='normal>
                                    <h4>" . $rowOccupiedRooms['occupiedRooms'] . "/" . $rowTotalRooms['totalRooms'] . "</h4>
                                    </div>";
    
                                $conn->close();
                            ?>
    
                    </div>
                    <img src="../localimages/vacantrooms.png" alt="vacantrooms.png">
                </div>
                <div class="totaltenants">
                    <div class="text">
                        <p>Total Tenants</p>
                        <p name="tenantsstats" id="tenantsstats"> 
                            <?php
                                include 'db_connect.php';
                                $sql = "SELECT COUNT(tenantID) as tenantcount FROM tenants;";
        
                                $result = $conn->query($sql);
                                
                                $row = $result->fetch_assoc();
                                
                                echo " <h4 style='font-weight: normal;'>" . $row["tenantcount"] . "</h4> ";
    
                                $conn->close();
                            ?>
                        </p>
                    </div>
                    <img src="../localimages/totaltenants.png" alt="totaltenants.png">
                </div>
                    <div class="servicerates">
                    <p>Service Rates</p>
                    <div class="electricitytext">
                        
                        <p name="electricity" id="electricity"> 
                            <?php
                                include 'db_connect.php';
                                $sql = "SELECT MAX(electricitybaseprice) as elecprice FROM services;";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                echo " <h4 style='font-weight: normal;'>Electricity:" . $row["elecprice"] . "/kWh</h4> ";
                            ?>
                        </p>
                    </div>
                    <div class="watertext">
                        
                        <p name="water" id="water"> 
                            <?php
                                $sql = "SELECT MAX(waterbaseprice) as waterprice FROM services;";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                echo " <h4 style='font-weight: normal;'>Water:" . $row["waterprice"] . "/m3</h4> ";
                            ?>
                        </p>
                    </div>
                    <button class="openServiceOverlaybutton" onclick="openServiceOverlay()">Edit Rates</button>
                    <?php $conn->close(); ?>
                </div>
            </div>
            <div class="transactions">
                <h3>Records</h3>
                <button id="createbutton" onclick="opencreate(this)">Create a new record</button>
                <!-- Dropdown filter -->
                    <form method="GET" action="">
                        <label for="statusFilter">Filter by Status:</label>
                        <select name="status" id="statusFilter" onchange="this.form.submit()">
                            <option value="">All</option>
                            <option value="Paid" <?php if (isset($_GET['status']) && $_GET['status'] == 'Paid') echo 'selected'; ?>>Paid</option>
                            <option value="Unpaid" <?php if (isset($_GET['status']) && $_GET['status'] == 'Unpaid') echo 'selected'; ?>>Unpaid</option>
                        </select>
                    </form>
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
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Paid</th>
                                        <th>Delete</th>
                                        </tr>
                                    </thead>";

                                    
                                include 'db_connect.php';
                                
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
                                        services ON rooms.servicesID = services.id";


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
                                        if ($status !== 'Paid') {
                                        echo    "<td>
                                                <form method='POST' action='update_status.php' style='display:inline;'>
                                                    <input type='hidden' name='reference_number' value='{$row['reference_number']}'>
                                                    <input type='hidden' name='status' value='Paid'>
                                                    <button type='submit' id='edit' class='edit-btn'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-check-circle-fill' viewBox='0 0 16 16'>
                                                    <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
                                                  </svg></button>
                                                </form>
                                            </td>";
                                    }else if (($status == 'Paid')){
                                        echo   "
                                            <td>
                                            </td>";
                                        }
                                    echo"<td>
                                            <form method='POST' action='delete.php' style='display:inline;'>
                                                <input type='hidden' name='reference_number' value='{$row['reference_number']}'>
                                                <button type='submit' id='delete'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                                                <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z'/>
                                                <path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z'/>
                                                </svg></button>
                                            </form>
                                        </td>
                                    </tr>";
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
            <div id="createrecord" class="create-record">
                    <div class="recordcontent">
                        <span class="close" onclick="closecreate()">&times;</span>
                        <h3>Create New Record</h3>
                        <form method="POST" action="create.php">
                            <label for="createTenantId">Tenant:</label>
                            <select name="tenant_id" id="createTenantId" required onchange="updateTenantDetails()">
                                <option value="">Select Tenant</option>
                                <?php
                                include 'db_connect.php';
                                $sql = "SELECT tenants.tenantID, tenants.fName, tenants.lName, rooms.room_number, rooms.roomRentalFee, 
                                        services.electricity, services.electricitybaseprice, services.water, services.waterbaseprice 
                                        FROM tenants 
                                        JOIN rooms ON tenants.room_number = rooms.room_number 
                                        JOIN services ON rooms.servicesID = services.id";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {

                                        $roomRentalFee = number_format((float)$row['roomRentalFee'], 2, '.', '');
                                        $electricity = number_format((float)$row['electricity'], 2, '.', '');
                                        $electricityBasePrice = number_format((float)$row['electricitybaseprice'], 2, '.', '');
                                        $water = number_format((float)$row['water'], 2, '.', '');
                                        $waterBasePrice = number_format((float)$row['waterbaseprice'], 2, '.', '');
                                    

                                        echo "<option value='{$row['tenantID']}' 
                                                data-room-number='{$row['room_number']}' 
                                                data-room-rental-fee='{$row['roomRentalFee']}' 
                                                data-electricity='{$row['electricity']}' 
                                                data-electricity-base-price='{$row['electricitybaseprice']}' 
                                                data-water='{$row['water']}' 
                                                data-water-base-price='{$row['waterbaseprice']}'>
                                                {$row['tenantID']} - {$row['fName']} {$row['lName']}
                                            </option>";
                                    }
                                }
                                $conn->close();
                                ?>
                            </select><br>


                            <input type="hidden" name="electricityBasePrice" id="electricityBasePriceHidden">
                            <input type="hidden" name="waterBasePrice" id="waterBasePriceHidden">
                            <div id="tenantDetails" style="display: none;">
                                <p><strong>Room Number:</strong> <span id="roomNumber"></span></p>
                                <p><strong>Room Rental Fee: ₱</strong> <span id="roomRentalFee"></span></p>
                                <p><strong>Electricity Consumption:</strong> <input type="text" id="electricitycons" name="electricitycons" value="" required oninput="updateTotalCost()">kWh</p>
                                <p><strong>Electricity Base Price: ₱</strong> <span id="electricityBasePrice"></span>/kWh</p>
                                <p><strong>Electricity Cost: ₱</strong> <span id="electricity_cost"></span></p>
                                <p><strong>Water Consumption:</strong> <input type="text" id="watercons" name="watercons" value="" required oninput="updateTotalCost()">m3</p>
                                <p><strong>Water Base Price: ₱</strong> <span id="waterBasePrice"></span>/m3</p>
                                <p><strong>Water Cost: ₱</strong> <span id="water_cost"></span></p>
                                <p><strong>Total Cost: ₱</strong> <span id="totalcosts"></span></p>
                                <p id="errorMessageDisplay" style="color: red;"></p>
                            </div>

                            <label for="date_of_payment">Date of Payment:</label>
                            <input type="date" name="date_of_payment" id="date_of_payment" required><br>
                            <label for="createAmount">Amount:</label>
                            <input type="text" name="amount" id="createAmount" value="" required readonly><br>
                            <button type="submit" class="save-btn">Save</button>
                        </form>
                    </div>
                </div>
            
                <?php
                    include 'db_connect.php';

                    // Fetch electricity price
                    $sql = "SELECT MAX(electricitybaseprice) as elecprice FROM services;";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $elecPrice = $row["elecprice"];

                    // Fetch water price
                    $sql = "SELECT MAX(waterbaseprice) as waterprice FROM services;";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $waterPrice = $row["waterprice"];

                    $conn->close();
                ?>
                
                <!--SERVICERATE OVERLAY-->
                <div id="serviceoverlay" class="serviceoverlay">
                    <div class="serviceoverlay-content">
                        <span class="closebtn" onclick="closeServiceOverlay()">&times;</span>
                        <form method="POST" action="update_rates.php">
                        <h4>Edit Rates</h4>
                            <label for="electricity_new">Electricity Rate</label>
                            <input type="text" name="electricity_new" id="electricity_new" value="<?php echo $elecPrice; ?>" required>
                            <label for="water_new">Water Rate</label>
                            <input type="text" name="water_new" id="water_new" value="<?php echo $waterPrice; ?>" required>
                            <button type="submit">Update Rates</button>
                        </form>
                    </div>
                </div>
        
    </div>

    


</body>
</html>