<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $landlordname= $_POST['landlordname']; 
    $email= $_POST['email']; 
    $password= $_POST['password']; 
    $contact_number= $_POST['contact_number']; 


    // Hash the password before saving to the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO landlord (landlordname, email, password, contact_number)
    VALUES ('$landlordname', '$email', '$hashed_password', '$contact_number')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link rel="stylesheet" href="regisstyles.css">
    <title>Dormer</title>
</head>
<body>
    <header>
        <img src="../images/Dormer logo.png" alt="dormerlogo.jpg">
    </header>
    <div class="regisdiv">
        <h2>Landlord Sign Up</h2>
        
        <form action="registrationpage.php" method="POST">
            <div class="inputarea">
                Landlord Name
                <input type="text" id="landlordname" name="landlordname" placeholder=" Enter name" required>
                <br>
                Email
                <input type="text" id="email" name="email" placeholder=" Enter Email" required>
                <br>
                Password
                <input type="password" id="password" name="password" placeholder="Enter Password" required>
                <br>
                Confirm Password
                <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Re-enter Password" required>
                <br>
                Contact Number
                <input type="text" id="contact_number" name="contact_number" placeholder="Enter phone number" required>
                <br>
            </div>
                <p class="terms">By creating an account, you agree to our <a href="">Terms</a> and have read and acknowledged the <a href="">Global Privacy Statement</a>.</p>
            <br>
            <div class="signupbutton">
                <input type="submit" id="signup" value="Sign Up">
            </div>
        </form>

    </div>
</body>
</html>
