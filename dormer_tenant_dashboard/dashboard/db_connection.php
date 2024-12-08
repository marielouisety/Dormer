<?php
$servername = "localhost";
$username = "root"; // Assuming 'root' is the username
$password = ""; // Assuming no password
$dbname = "dormerdb"; // Database name from your SQL file

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
