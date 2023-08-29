<?php 
    
    include __DIR__ . "/config/db_connect.php";
    $courseId = (int)$_GET['id'];
    $result = $db->query("SELECT * FROM courses WHERE id = $courseId");
    // Fetch and process data here
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn it</title>
</head>
<body>
    this is courseid <?php echo $result->fetch_assoc()["name"]; ?>    

</body>
</html>