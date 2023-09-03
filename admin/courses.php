<?php 

        //connect to server

        include "../config/db_connect.php";
        include "../fileUpload/fileUpload.php";

        $courseName = $description = $instructor = $courseLink = $selectedInstructorId =  "";
       
        //check name
        if(isset($_POST["submit"])) {
            $courseName = mysqli_real_escape_string($db, $_POST["courseName"]);
            $description = mysqli_real_escape_string($db, $_POST["description"]);
            $courseLink = mysqli_real_escape_string($db, $_POST["courseLink"]);
            $selectedInstructorId = mysqli_real_escape_string($db, $_POST["selectedInstructor"]);

            $allowTypes = array("jpg", "jpeg", "png", "gif");
            if(in_array($fileType, $allowTypes)) {
                if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    $insert = $db->query("INSERT INTO courses (name, description, course_link, instructor_id, course_photo) VALUES('$courseName', '$description', '$courseLink', '$selectedInstructorId', '$fileName')");
                    if($insert) {
                        header("Location: ./courses.php");
                        exit;   
                    }
                    } else {
                            $statusMsg = "File upload failed";
                            $status = "danger";
                            echo "<script>alert('$statusMsg');</script>";
                    }
                } else {
                        $statusMsg = "Invalid file type";
                        $status = "danger";
                        echo "<script>alert('$statusMsg');</script>";
                }
        }




        //edit course

        if (isset($_POST['edit_course'])) {
            $id = mysqli_real_escape_string($db, $_POST['edit_course']);
            $courseName = mysqli_real_escape_string($db, $_POST["courseName"]);
            $description = mysqli_real_escape_string($db, $_POST["description"]);
            $courseLink = mysqli_real_escape_string($db, $_POST["courseLink"]);
            $selectedInstructorId = mysqli_real_escape_string($db, $_POST["selectedInstructor"]);

            
            // Check if a file was uploaded
            if (!empty($_FILES["file"]["name"])) {
                $allowTypes = array("jpg", "jpeg", "png", "gif");
                if (in_array($fileType, $allowTypes)) {
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                        // Update name and image in the database
                        $insert = $db->query("UPDATE courses SET name = '$courseName', description = '$description', course_link = '$courseLink', instructor_id = '$selectedInstructorId' ,course_photo = '$fileName' WHERE id = $id");
                        if ($insert) {
                            header("Location: courses.php");
                            exit; // Make sure to exit the script
                        } else {
                            $statusMsg = "Database query failed";
                            $status = "danger";
                        }
                    } else {
                        $statusMsg = "File upload failed";
                        $status = "danger";
                    }
                } else {
                    $statusMsg = "Invalid file type";
                    $status = "danger";
                }
            } else {
                // Update name only, without changing the image
                $updateName = $db->query("UPDATE courses SET name = '$courseName', description = '$description', course_link = '$courseLink', instructor_id = '$selectedInstructorId'  WHERE id = $id");
                if ($updateName) {
                    header("Location: courses.php");
                    exit; // Make sure to exit the script
                } else {
                    $statusMsg = "Database query failed";
                    $status = "danger";
                }
            }
        }


        // delete course 
        if(isset($_POST['delete'])) {
            $deleteId = mysqli_real_escape_string($db, $_POST['delete']);
            $deleteCoursesStudent = $db->query("DELETE FROM courses_students_instructors WHERE course_id = $deleteId");
            $deleteCourse = $db->query("DELETE FROM courses WHERE id = $deleteId");

            if($deleteCoursesStudent && $deleteCourse) {
                    // Query executed successfully, you can add a success message here
                header("Location: courses.php");
                exit;
            } else {
                    // Query failed, you can add an error message here
                    $statusMsg = "Error deleting record";
                    $status = "danger";
            }

                
        } 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <?php include '../includes/cdn.php';?>
</head>
<body>
    <?php include "../templates/layout.php"; ?>
    <div class="p-4 sm:ml-64  bg-cyan-50 min-h-[100vh]">
        
    <!-- Modal toggle -->
        <?php include "./components/courses/addCourse.php";?>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                <?php 
                // getting all instructor data
                    $query = $db->query("SELECT * FROM courses");

                    if($query->num_rows > 0) {
                    while($courseRow = $query->fetch_assoc()) {
                    $imageUrl = '../uploads/'.$courseRow['course_photo'];
                    
                ?>

            
                
                
                <div class="relative max-w-sm border border-gray-200 bg-white rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 group">
                    <div class=" hidden group-hover:block absolute top-2 right-0">
                        
                        <div class="flex gap-2">

                                <?php include "./components/courses/editCourse.php";

                                include "./components/courses/deleteCourse.php";
                                ?>


                        </div>
                    

                      <!-- add edit and delete -->

                    </div>
                    <div class="mt-14">
                        <img class="rounded-[50%] w-[100px] h-[100px] mx-auto object-cover" src=<?php echo $imageUrl; ?> alt="" />
                    </div>
                    <div class="p-2">
                        
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"> <?php echo isset($courseRow['name']) ? $courseRow['name'] : 'No Name'; ?></h5>
                        
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"> <?php echo isset($courseRow['description']) ? $courseRow['description'] : 'No Description'; ?></p>
                        
                    </div>
                </div>
           
            


                <?php
                            
                        }
                    }  else {
                        echo "0 results";
                    }
                ?>
            </div>  
    </div>
    <?php include '../includes/scripts.php';?>
</body>
</html>