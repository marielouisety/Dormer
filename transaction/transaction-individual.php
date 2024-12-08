<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<form method="POST">
<h2>Select the tenantID to filter Transaction History</h2>

                <?PHP
                $username = "root"; 
                $password = ""; 
                $database = "dormerdb"; 
                $mysqli = new mysqli("localhost", $username, $password, $database); 
                $query = "SELECT tenantID, fName, lName FROM tenants";

                echo"<div><select name = \"tenantID\" id = \"tenantID\" class=\"w-input\" >";
                if ($result = $mysqli->query($query)) {
                    while ($row = $result->fetch_assoc()) {
                    $_SESSION["tenantID"]=$row["tenantID"];

                      echo"<option>";
                      echo $row["tenantID"];
                      echo " - ";
                      echo $row["fName"];
                      echo $row["lName"];					  
                      echo "</option>";
                    }}
                      echo"</select></div>";

                    ?>

<button type="submit" name="submit">Filter</button>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dormerdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$tenantID=mysqli_real_escape_string($conn, $_POST["tenantID"]);

// SQL query to get transaction history
$sql = "SELECT payments.reference_number, payments.amount, payments.date_of_payment, tenants.fName, tenants.lName, payments.status 
        FROM payments 
        LEFT JOIN tenants ON payments.tenantID = tenants.tenantID WHERE payments.tenantID ='$tenantID' AND tenants.tenantID ='$tenantID'
        ORDER BY payments.date_of_payment DESC";

$result = $conn->query($sql);

?>



<h2>Transaction History</h2>

<table>
    <thead>
        <tr>
            <th>Reference Number</th>
            <th>Amount</th>
            <th>Date of Payment</th>
            <th>Tenant Name</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["reference_number"] . "</td>";
                echo "<td>" . $row["amount"] . "</td>";
                echo "<td>" . $row["date_of_payment"] . "</td>";
                echo "<td>" . $row["fName"] . " " . $row["lName"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No transactions found</td></tr>";
        }
		}
	
        ?>
    </tbody>
</table>
</form>
</body>
</html>
