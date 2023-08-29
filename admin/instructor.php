<?php 

    include "../config/db_connect.php";
    include "../fileUpload/fileUpload.php";

    $instructorName = $edu_background = $about_instructor = "";
    
    if(!empty($_POST['instructorName'])) {
        $instructorName = $_POST['instructorName'];
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
                    $insert = $db->query("INSERT INTO instructor(name, edu_background, about_instructor, instructor_photo) 
                        VALUES('$instructorName', '$edu_background', '$about_instructor', '$fileName')");
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
            $deleteId = mysqli_real_escape_string($db, $_POST['delete']);
            $query = $db->query("DELETE FROM instructor WHERE id = $deleteId");
            if($query) {
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
                        $insert = $db->query("UPDATE instructor SET name = '$instructorName', edu_background = '$edu_background', instructor_photo = '$fileName' WHERE id = $id");
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
                $updateName = $db->query("UPDATE instructor SET name = '$instructorName', edu_background = '$edu_background' WHERE id = $id");
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
    <link rel="stylesheet" href="styles.css">
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
                    <div class="mt-14">
                        <img class="rounded-[50%] w-[100px] h-[100px] mx-auto object-cover" src=<?php echo $imageUrl; ?> alt="" />
                    </div>
                    <div class="p-2">
                        
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?php echo $row['name']; ?></h5>
                        
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><?php echo $edu_background ?></p>
                        
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