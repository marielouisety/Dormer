<?php
session_start();
session_unset();
session_destroy();

header("Location: /dormer/login/loginpage.php"); // Redirect to the login page after logout
exit();
?>
