<?php 

include "submitHwForm.php"; 
$studentInfo = $db->query("SELECT * FROM students where id = '{$_COOKIE['userId']}'")->fetch_assoc();   


?>

<div class="flex items-center md:order-2">
      <button type="button" class="flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
        <span class="sr-only">Open user menu</span>
        <img class="w-8 h-8 md:w-10 md:h-10  rounded-full" src="../imgs/2980634_avatar_girl_people_person_profile_icon.png" alt="user photo">
        
      </button>
      <!-- Dropdown menu -->
      <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
        <div class="px-4 py-3">
          <span class="block text-sm text-gray-900 dark:text-white"><?php echo $studentInfo['name']; ?></span>
          <span class="block text-sm  text-gray-500 truncate dark:text-gray-400"><?php echo $studentInfo['email']; ?></span>
        </div>
        

        <div>
            <a data-modal-target="submitHwModal" data-modal-toggle="submitHwModal" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white cursor-pointer" >
                    Submit
            </a> 
        </div>
          

        <div class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
            <?php 
            if (isset($_COOKIE['userId'])) {
            // User is logged in
            // Display "Sign Out" and other user-specific content
            echo '<a href="../_actions/logout.php" class=" cursor-pointer">Sign Out</a>';
            } 
        
            ?>
        </div>
    </div>
</div>