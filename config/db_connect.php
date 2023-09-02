<?php

//require __DIR__ . "/../vendor/autoload.php";
// Include the Composer autoload file
//$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
//$dotenv->load();


//db config
$dbHost = "localhost";
$dbUsername = "lumiere";
$dbPassword = "136300";
$dbName = "learnitdb";

$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

//check connection
if ($db->connect_error) {
   die("Connection failed: " . $db->connect_error);
}
?>
