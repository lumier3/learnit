<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    // Include PHPMailer
    require_once 'vendor/autoload.php';

    $updatedButtonText = "Successfully Submitted";
    if (isset($_POST['submitAssignment'])) {
        $selectedCourse = $_POST['selectedCourse']; //course
        list($selectedCourseId, $selectedCourseName) = explode(':', $selectedCourse);
        
        $allowTypes = array("docx", "pdf", "png", "gif" , "jpg");
            if(in_array($fileType, $allowTypes)) {

            $originalFileName = $_FILES["file"]["name"];

    // Remove spaces and replace special characters with underscores
            $cleanedFileName = preg_replace('/[^\w.-]/', '_', $originalFileName);

    // Create the target file path with the cleaned file name
            $target_file = $target_dir . $cleanedFileName;


// Create a PHPMailer instance
            $mail = new PHPMailer(true);

            try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Use the appropriate SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'l1stent0her888@gmail.com';  // Your Gmail email address
            $mail->Password = 'gkkqkokswarteztm';   // Your Gmail password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Fetch the sender's email address from the database based on the user who submitted the assignment
            $receiverEmail = $db->query("SELECT instructor.email , instructor.name FROM instructor
            INNER JOIN courses On instructor.id = courses.instructor_id
            WHERE courses.id = $selectedCourseId")->fetch_assoc() ;  // Replace with your database query

            $signedInUser = $db->query("SELECT * FROM students where id = '{$_COOKIE['userId']}'")->fetch_assoc();

           // Recipients
            $mail->setFrom($signedInUser['email'], $signedInUser['name']);
            $mail->addAddress($receiverEmail["email"], $receiverEmail["name"]);
            $mail->addStringAttachment($target_file, $cleanedFileName);
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Assignment Submission';
            $mail->Body = $signedInUser["name"] . ' has submitted an assignment for the course '. $selectedCourseName;

            // Send the email
            $mail->send();
            $statusMsg = "File upload successful!";
            $status = "success";
        
            header("Location: ../index.php");
            exit();
} catch (Exception $e) {
    echo "Email could not be sent. Error: {$mail->ErrorInfo}";
    
}
    } else {
        $statusMsg = "File upload failed";
        $status = "danger";
        echo $statusMsg;
    }


    } 
?>




<div id="submitHwModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="submitHwModal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="px-6 py-6 lg:px-8">
                <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Submit your homework</h3>
                <form class="space-y-6" action="../index.php" method="post" enctype="multipart/form-data">
                    <div>
                        <label for="selectedCourse" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Select an Course</label>
                            <select name="selectedCourse" id="selectedCourse" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>Choose Course to submit</option>
                                    <?php 
                                        $result = $db->query("SELECT courses.name , courses.id
                                        FROM courses
                                        INNER JOIN courses_students_instructors
                                        ON courses.id = courses_students_instructors.course_id
                                        INNER JOIN students 
                                        ON students.id = courses_students_instructors.student_id
                                        WHERE student_id = '{$_COOKIE['userId']}'");
                                        if($result->num_rows > 0) {
                                            
                                            while($row = $result->fetch_assoc()) {
                                            ?>
                                                <option value="<?php echo $row["id"]; ?>:<?php echo $row["name"]; ?>"><?php echo $row["name"];?></option>
                                                <?php
                                            }
                                        } else {
                                            echo "0 results";
                                        }
                                    ?>
                            </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file" name="file">
                    </div>
                   
                    
                    <button type="submit" name="submitAssignment" id="submitAssignmentButton" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <?php
                       echo "Submit Assignment";
                    ?>
                    </button>
                   
                </form>
            </div>
        </div>
    </div>
</div> 
