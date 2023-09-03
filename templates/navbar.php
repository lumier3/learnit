<nav class="flex justify-between items-center px-10 pt-8">
    <div>
        <a href="index.php">
            <h1 class="text-2xl md:text-4xl text-white">Learn<span class="text-red-500 text-3xl md:text-5xl">It</span></h1>
        </a>
    </div>
    <div class="hidden lg:flex w-[45rem] justify-evenly items-center">
        <a class="text-white cursor-pointer hover:text-red-500" href="#header">Home</a>
        <a class="text-white cursor-pointer hover:text-red-500" href="#courses_offer">Courses</a>
        <a class="text-white cursor-pointer hover:text-red-500" href="#about-us">About Us</a>
        <a class="text-white cursor-pointer hover:text-red-500"  href="#contact-us">Contact</a>
        
    </div>
    
    <div class="flex items-center">
        <div class="lg:flex">
            <?php 
                if (isset($_COOKIE['userId'])) {
                // User is logged in
                // Display "Sign Out" and other user-specific content
                include "userProfile.php";
                } else {
                    // User is not logged in
                    // Display "Sign In" and other content for non-logged-in users
                    echo '<a href="../_actions/login.php" class="text-white cursor-pointer hover:text-red-500">Sign In</a>';
                }
            ?>
        </div>


        <!--- mobile menu --->
        
    </div>
 </nav>