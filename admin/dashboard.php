<?php 
    include "../config/db_connect.php";

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
    <?php include "../templates/layout.php";?>
    <div class="p-4 sm:ml-64  bg-cyan-50 min-h-[100vh]">
        <div class="relative dashboard_scroll max-w-[80%] max-h-full mx-auto overflow-x-auto overflow-y-scroll mt-32">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="sticky top-0 text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Courses
                        </th>
                        <th scope="col" class="px-6 py-3">
                           Total Enrolled Students
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <?php 
                            $coursesResult = $db->query("SELECT * FROM courses");
                            if ($coursesResult) {
                                while ($courseRow = $coursesResult->fetch_assoc()) {
                                    echo "<tr class='bg-white border-b dark:bg-gray-800 dark:border-gray-700'>";
                                    echo "<td class='px-6 text-black py-4 border-b dark:border-gray-600 text-sm'>" . $courseRow['name'] . "</td>";
                                    
                                    // Count the total enrolled students for this course
                                    $courseId = $courseRow['id'];
                                    $enrolledStudentsResult = $db->query("SELECT COUNT(*) as total FROM courses_students_instructors WHERE course_id = '$courseId'");
                                    
                                    if ($enrolledStudentsResult) {
                                        $enrolledStudentsRow = $enrolledStudentsResult->fetch_assoc();
                                        echo "<td class='px-6 py-4 text-black border-b dark:border-gray-600 text-sm'>" . $enrolledStudentsRow['total'] . "</td>";
                                    } else {
                                        echo "<td class='px-6 py-4 text-black border-b dark:border-gray-600 text-sm'>0</td>"; // Default to 0 if no students found
                                    }
                                    
                                    echo "</tr>";
                                };
                                
                            }
                            
                        ?>
                        <!-- <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Apple MacBook Pro 17"
                        </th>
                        <td class="px-6 py-4">
                            Silver
                        </td> -->
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <?php include "../includes/scripts.php";?>
</body>
</html>