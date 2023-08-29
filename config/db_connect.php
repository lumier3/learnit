<?php

require __DIR__ . "/../vendor/autoload.php";
// Include the Composer autoload file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


//db config
$dbHost = $_ENV['dbHost'];
$dbUsername = $_ENV['dbUsername'];
$dbPassword = $_ENV['dbPassword'];
$dbName = $_ENV['dbName'];

$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

//check connection
if ($db->connect_error) {
   die("Connection failed: " . $db->connect_error);
}
?>
