<?php 

    include "../config/db_connect.php";
    include "../fileUpload/fileUpload.php";

    $instructorName = $edu_background = $about_instructor = "";
    
    if(!empty($_POST['instructorName'])) {
        $instructorName = $_POST['instructorName'];
    }

    if(!empty($_POST['instructorEmail'])) {
        $instructorEmail = $_POST['instructorEmail'];
    }

    if(!empty($_POST['edu_background'])) {
        $edu_background = $_POST['edu_background'];
    }

    if(!empty($_POST['about_instructor'])) {
        $about_instructor = $_POST['about_instructor'];
    }

    if(isset($_POST['submit'])) {
                
        $allowTypes = array("jpg", "jpeg", "png", "gif");
        if(in_array($fileType, $allowTypes)) {
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    $insert = $db->query("INSERT INTO instructor(name, edu_background, about_instructor, instructor_photo, email) 
                        VALUES('$instructorName', '$edu_background', '$about_instructor', '$fileName', '$instructorEmail')");
                        if ($insert) {
                            // Data inserted successfully, redirect back to the same page
                            header("Location: instructor.php");
                            exit; // Make sure to exit the script
                        }
                } else {
                        $statusMsg = "File upload failed";
                        $status = "danger";
                }
            } else {
                    $statusMsg = "Invalid file type";
                    $status = "danger";
            }

    }

            /// delete the file from the server
        if(isset($_POST['delete'])) {
            $deleteInstructorId = mysqli_real_escape_string($db, $_POST['delete']);
            $deleteCoursesStudentsInstructor = $db->query("DELETE FROM courses_students_instructors WHERE instructor_id = $deleteInstructorId");
            $deleteFromCourses = $db->query("DELETE FROM courses WHERE instructor_id = $deleteInstructorId");
            $deleteFromInstructor = $db->query("DELETE FROM instructor WHERE id = $deleteInstructorId");
            if($deleteCoursesStudentsInstructor && $deleteFromCourses && $deleteFromInstructor) {
                    // Query executed successfully, you can add a success message here
                header("Location: instructor.php");
                exit;
            } else {
                    // Query failed, you can add an error message here
                    $statusMsg = "Error deleting record";
                    $status = "danger";
            }

                
        } 



        ///
        if (isset($_POST['edit_instructor'])) {
            $id = mysqli_real_escape_string($db, $_POST['edit_instructor']);
            $instructorName = $_POST["instructorName"];
            $edu_background = $_POST["edu_background"];
            $about_instructor = $_POST["about_instructor"];
            
            // Check if a file was uploaded
            if (!empty($_FILES["file"]["name"])) {
                $allowTypes = array("jpg", "jpeg", "png", "gif");
                if (in_array($fileType, $allowTypes)) {
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                        // Update name and image in the database
                        $insert = $db->query("UPDATE instructor SET name = '$instructorName', edu_background = '$edu_background', instructor_photo = '$fileName', email ='$instructorEmail' WHERE id = $id");
                        if ($insert) {
                            header("Location: instructor.php");
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
                $updateName = $db->query("UPDATE instructor SET name = '$instructorName', edu_background = '$edu_background', email ='$instructorEmail' WHERE id = $id");
                if ($updateName) {
                    header("Location: instructor.php");
                    exit; // Make sure to exit the script
                } else {
                    $statusMsg = "Database query failed";
                    $status = "danger";
                }
            }
        }
        
        
        
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <?php include '../includes/cdn.php';?>
    <title>Document</title>
</head>
<body>
        <?php include('../templates/layout.php') ?>
        
        <div class="p-4 sm:ml-64 bg-cyan-50 min-h-[100vh]">
        
        <?php include "./components/instructor/addInstructor.php" ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
            <?php 
            // getting all instructor data
                $query = $db->query("SELECT * FROM instructor");

                if($query->num_rows > 0) {
                while($row = $query->fetch_assoc()) {
                $imageUrl = '../uploads/'.$row['instructor_photo'];
                
            ?>

            
            
                <div class="relative max-w-sm border border-gray-200 bg-white rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 group">
                    <div class=" hidden group-hover:block absolute top-2 right-0">
                        <div class="flex gap-2">

                        <?php include "./components/instructor/editInstructor.php";

                        include "./components/instructor/deleteInstructor.php";
                        ?>
                        

                        </div>

                    </div>
                    <div class="w-full pt-14 max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <div class="flex flex-col items-center pb-10">
                                <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src=<?php echo $imageUrl; ?> alt="Bonnie image"/>
                                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white"><?php echo $row['name']; ?></h5>
                                <span class="text-sm text-gray-500 dark:text-gray-400"><?php echo $edu_background ?></span>
                            </div>
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