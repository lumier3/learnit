<?php 
    

    include __DIR__ . "/config/db_connect.php";
    $courseId = (int)$_GET['id'];
    $result = $db->query("SELECT * FROM courses WHERE id = $courseId");
    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
    }

    
    $enrolled = false;
    if(isset($_COOKIE['userId'])){
        $studentId = mysqli_real_escape_string($db, $_COOKIE['userId']);

        //check if the student is enrolled in the course
        $enrollmentCheckQuery = "SELECT * FROM courses_students WHERE student_id = '$studentId' AND course_id = '$courseId'";
        $enrollmentCheckResult = $db->query($enrollmentCheckQuery);

        if(mysqli_num_rows($enrollmentCheckResult) > 0){
            $enrolled = true;
        }
    }

    if(isset($_POST['courseId'])){
        $enrolledCourseId = mysqli_real_escape_string($db, $_POST['courseId']);
        $studentId = mysqli_real_escape_string($db, $_COOKIE['userId']);
        if(!empty($enrolledCourseId) &&!empty($studentId)){
            $query = "INSERT INTO courses_students (course_id, student_id) VALUES ('$enrolledCourseId',$studentId)";
            $result = $db->query($query);
            if($result){
                header("Location:index.php");
                exit();
            } else {
                echo $db->error;
            }
        } 
    }


    // Fetch and process data here
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn it</title>
    <?php include "./includes/cdn.php";?>
    <link rel="stylesheet" href="./styles.css">
</head>
<body class="bg-gray-400">

    <?php include "./templates/navbar.php" ?>

    <form class="max-w-[80%] mx-auto mt-20 text-center" method="POST" action="">
    <input type="hidden" name="courseId" value="<?php echo $courseId; ?>">
            <!-- this is header -->
            <h1 class="text-white font-semibold text-4xl"><?php echo $row['name'];?></h1>
            <p >
                <?php echo $row['description'];?>
            </p>
            <?php 
        if (isset($_COOKIE['userId'])) {
            //userlogged in 

            //check if the student is enrolled in the course
            if(!$enrolled) {
                echo '<button type="submit" name="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Enroll</button>';
            } else {
                echo '<a href="' . $row["course_link"] . '" target="_blank"><button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="w-3.5 h-3.5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 21">
                  <path d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z"/>
                </svg>
                Download
              </button></a>';
            }

        
        } else {
            echo '<a href="./_actions/login.php"><button type="button" name="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Log in to enroll the course</button></a>';
        }
        
        
        ?>
    </form>

    <?php include "./includes/scripts.php";?>


</body>
</html>