<?php
session_start();

// Database credentials
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
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember_me = isset($_POST['rememberme']);

    // Check if the user is a landlord
    $stmt = $conn->prepare("SELECT id, password, landlordname FROM landlord WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $landlordname);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['userID'] = $id;
            $_SESSION['name'] = $landlordname;
            $_SESSION['role'] = 'landlord';

            if ($remember_me) {
                setcookie("email", $email, time() + (86400 * 30), "/"); // 30 days
                setcookie("password", $hashed_password, time() + (86400 * 30), "/"); // 30 days
            }

            header("location: ../dormer_admin_dashboard/dashboard/dashboard.php");
            exit;
        } else {
            $password_err = "The password you entered was not valid.";
        }
    } else {
        // Check if the user is a tenant
        $stmt = $conn->prepare("SELECT tenantID, password, fName, lName FROM tenants WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed_password, $fName, $lName);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['userID'] = $id;
                $_SESSION['name'] = $fName . ' ' . $lName;
                $_SESSION['role'] = 'tenant';

                if ($remember_me) {
                    setcookie("email", $email, time() + (86400 * 30), "/"); // 30 days
                    setcookie("password", $hashed_password, time() + (86400 * 30), "/"); // 30 days
                }

                header("location: ../dormer_tenant_dashboard/dashboard/dashboard.php");
                exit;
            } else {
                $password_err = "The password you entered was not valid.";
            }
        } else {
            $email_err = "The field is empty or the account can't be found.";
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link rel="stylesheet" href="loginstyles.css">
    <title>Dormer</title>
</head>
<body>
    
    <header>
        <img src="../images/Dormer logo.png" alt="dormerlogo.jpg">
    </header>
    <div class="logindiv">
        <h2>Log In</h2>
        <form id="loginForm" action="loginpage.php" method="POST">
            <div class="inputarea">
                <input type="text" id="email" name="email" placeholder="Email address" >
                <div id="emailError" class="error-message" style="color: white; font-size: 12px;"></div>
                <br>
                <input type="password" id="password" name="password" placeholder="Password" >
                <div id="passwordError" class="error-message" style="color: white; font-size: 12px;"></div>
                <!--<a class="forgotpassword" href="forgotpassword.php" style="color: white; font-size: 12px;">Forgot password?</a>-->
                <br>
                <input type="checkbox" id="rememberme" name="rememberme"><label class="rememberme">Remember me</label>
                <br>
            </div>
            <br>
            <div class="loginbuttondiv">
                <input type="submit" id="loginbutton" value="Login">
            </div>
        </form>
        <div class="donthave">
            <p>Don't have an account? <a href="../regis/registrationpage.php">Sign Up.</a></p>
        </div>
    </div>
    <script>
         <?php if (!empty($email_err)): ?>
            document.getElementById('emailError').innerText = "<?php echo $email_err; ?>";
        <?php endif; ?>
        <?php if (!empty($password_err)): ?>
            document.getElementById('passwordError').innerText = "<?php echo $password_err; ?>";
        <?php endif; ?>
    </script>
</body>
</html>
