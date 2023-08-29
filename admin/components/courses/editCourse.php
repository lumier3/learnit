<?php 

include __DIR__ . "/../../../fileUpload/fileUpload.php";

$editId = $courseRow["id"];
$courseName = $courseRow["name"];
$description = $courseRow["description"];
$courseLink = $courseRow["course_link"];
$selectedInstructorId = $courseRow["instructor_id"];

?>




<button data-modal-target="edit-course-form-<?php echo $courseRow['id']; ?>" data-modal-toggle="edit-course-form-<?php echo $courseRow['id']; ?>" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
    Edit
</button>


    
            <!-- Main modal -->
            <div id="edit-course-form-<?php echo $courseRow['id']; ?>" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <button type="button" class="absolute 
                        top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 
                        rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600
                        dark:hover:text-white" data-modal-hide="edit-course-form-<?php echo $courseRow['id']; ?>">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="px-6 py-6 lg:px-8">
                            <!-- form start here -->
                            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Edittt</h3>
                            <form class="space-y-6" action="courses.php" method="POST" enctype="multipart/form-data" id="edit-instructor-form-<?php echo $courseRow['id']; ?>">
                                <div>
                                    <label for="courseName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course Name</label>
                                    <input type="text" value="<?php echo $courseName; ?>" name="courseName" id="courseName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="enter course name" required>
                                </div>
    
                                <div>
                                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                    <textarea type="text" name="description" id="description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="enter description" required><?php echo $description; ?></textarea>
                                </div>
    
                                <div>
                                    <label for="courseLink" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course Link</label>
                                    <input type="text" value="<?php echo $courseLink; ?>" name="courseLink" id="courseLink" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="enter description" required>
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="edit_file_input">Upload file</label>
                                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="edit_file_input" type="file" name="file">
                                    
                                </div>

                                <div>
                                    <label for="instructor" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Choose an instructor</label>
                                    <select name="selectedInstructor" id="instructor" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">Choose an instructor</option> <!-- Add an empty option for the default selection -->
                                        <?php 
                                            $result = $db->query("SELECT * FROM instructor");
                                            if($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $instructorId = $row["id"];
                                                    $instructorName = $row["name"];
                                                    
                                                    // Check if this instructor matches the selected instructor ID
                                                    $isSelected = ($instructorId == $selectedInstructorId) ? 'selected' : '';
                                                ?>
                                                    <option value="<?php echo $instructorId; ?>" <?php echo $isSelected; ?>><?php echo $instructorName; ?></option>
                                                <?php
                                                    }
                                                } else {
                                                    echo "0 results";
                                                }
                                            ?>
                                        </select>
                                    </div>


                                
                                
                                <div>
                                <button type="hidden" value=<?php echo $editId ?> name="edit_course" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">edit</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <script>
    // JavaScript to show the modal when the "Edit" button is clicked
    const editButtons = document.querySelectorAll('.block.text-white.bg-blue-700.hover:bg-blue-800');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const modalId = button.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            modal.style.display = 'block';
        });
    });

    // JavaScript to hide the modal when the close button is clicked
    const closeButtons = document.querySelectorAll('.absolute.top-3.right-2.5.text-gray-400.bg-transparent.hover:bg-gray-200.hover:text-gray-900.rounded-lg.text-sm.w-8.h-8.ml-auto.inline-flex.justify-center.items-center.dark:hover:bg-gray-600.dark:hover:text-white');
    
    closeButtons.forEach(closeButton => {
        closeButton.addEventListener('click', function () {
            const modalId = closeButton.getAttribute('data-modal-hide');
            const modal = document.getElementById(modalId);
            modal.style.display = 'none';
        });
    });
</script>

