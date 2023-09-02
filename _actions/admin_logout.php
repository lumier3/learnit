<?php
// Start the session
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();
setcookie("adminId", "", time() - 3600, "/"); // Replace "login_token" with the name of your cookie


// Redirect to the login page or any other page you prefer
header("Location:../admin/"); // Change "login.php" to the page you want to redirect to
exit();
?>