<?php 
    

    include __DIR__ . "/config/db_connect.php";
    $courseId = (int)$_GET['id'];
    $courseName = '';
    $courseDescription = '';
    $courseLink = '';
    $coursePhoto = '';
    $instructorId = '';
    $instructorName = '';
    $courseResult = $db->query("SELECT * FROM courses WHERE id = '$courseId'");

    if(mysqli_num_rows($courseResult) == 1){
        $row = mysqli_fetch_assoc($courseResult);
        $courseName = $row['name'];
        $courseDescription = $row['description'];
        $courseLink = $row['course_link'];
        $coursePhoto = $row['course_photo'];
        $instructorId = $row['instructor_id'];
    }

    $instructorResult = $db->query("SELECT * FROM instructor WHERE id = '$instructorId'");
    if(mysqli_num_rows($instructorResult) == 1){
        $row = mysqli_fetch_assoc($instructorResult);
        $instructorName = $row['name'];
    }

    
    $enrolled = false;
    if(isset($_COOKIE['userId'])){
        $studentId = mysqli_real_escape_string($db, $_COOKIE['userId']);

        //check if the student is enrolled in the course
        $enrollmentCheckQuery = "SELECT * FROM courses_students_instructors WHERE student_id = '$studentId' AND course_id = '$courseId'";
        $enrollmentCheckResult = $db->query($enrollmentCheckQuery);

        if(mysqli_num_rows($enrollmentCheckResult) > 0){
            $enrolled = true;
        }
    }

    if(isset($_POST['courseId'])){
        $enrolledCourseId = mysqli_real_escape_string($db, $_POST['courseId']);
        $studentId = mysqli_real_escape_string($db, $_COOKIE['userId']);
        if(!empty($enrolledCourseId) &&!empty($studentId)){
            $query = "INSERT INTO courses_students_instructors (course_id, student_id, instructor_id) VALUES ('$enrolledCourseId',$studentId, $instructorId)";
            $result = $db->query($query);
            if($result){
                header("Location:course.php?id=$courseId");
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
<body >

    <div class="course_enroll pb-5">
    <?php include "./templates/navbar.php" ?>
    </div>
    <div class="w-[90%] flex-row md:flex mx-auto justify-between mt-18 mb-10">

        <form class="max-w-[90%] lg:max-w-[60%] mx-auto mt-10 text-left" method="POST" action="">
        <input type="hidden" name="courseId" value="<?php echo $courseId; ?>">
                <!-- this is header -->
                <h1 class="font-bold text-5xl text-left tracking-wide"><?php echo $courseName;?></h1>
                <p class="w-[80%] mt-10 font-mono text-left">
                    <?php echo $courseDescription;?>
                </p>

                <p class="mt-4">This couses is teached by
                    <span class="font-bold text-cyan-700"><?php echo $instructorName;?></span>
                </p>
                <?php 
            if (isset($_COOKIE['userId'])) {
                //userlogged in 

                //check if the student is enrolled in the course
                if(!$enrolled) {
                    echo '<button type="submit" name="submit" class="mt-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Enroll</button>';
                } else {
                    echo '<a href="' . $courseLink . '" target="_blank"><button type="button" class="mt-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Download course file
                </button></a>';
                }

            
            } else {
                echo '<a href="./_actions/login.php"><button type="button" name="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Log in to enroll the course</button></a>';
            }
            
            
            ?>
        </form>
        <div class="max-w-[90%] lg:max-w-[40%] mt-10 lg:mt-40 mx-auto">
            <img src="<?php echo './uploads/' . $coursePhoto ?>" alt="" class="rounded-md w-full h-[300px] object-cover">
        </div>
    </div>

    <?php include "./includes/scripts.php";?>


</body>
</html>