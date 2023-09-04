<?php 
include __DIR__ . "/../config/db_connect.php";
session_start();
if(!isset($_COOKIE['adminId'])) {
  header("Location:../../_actions/admin_login.php");
  exit();
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles.css">
    <?php include '../includes/cdn.php';?>
</head>
<body>
    <?php include('../templates/layout.php');?>
    
</div>
</body>
</html>