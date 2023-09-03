
<?php 


$result = $db->query("SELECT * FROM courses");

//check query

if (!$result) {
   echo 'Error: '. mysqli_error($conn);
}

//fetch data
$courses = $result->fetch_all(MYSQLI_ASSOC);



?>


<section class="mt-10" id="courses_offer">
    <h1 class="text-4xl text-center">Courses Offer by LearnIt</h1>
    

    <!-- Slider main container -->
    <div class="swiper mt-6 mx-auto w-[90%] mb-4">
    <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <?php foreach($courses as $course) { ?>
                <div class="swiper-slide text-center w-full md:w-[33%] rounded-sm">

                    <div class="w-full h-[200px] overflow-hidden object-cover">
                        <img src="<?php echo "../uploads/" . $course["course_photo"]; ?>" alt="">
                    </div>
                    <div class="w-full h-[30px] mt-4 mb-6">
                        <h1 class="text-xl lg:text-2xl font-bold flex-wrap"><?php echo htmlspecialchars($course["name"]); ?></h1>
                    </div>
                    <div class="w-full h-[90px] course_description overflow-y-scroll ">
                        <p class="font-mono"><?php echo htmlspecialchars($course["description"]);?></p>
                    </div>
                    <div class="mb-3 mt-6">
                        <a href="course.php?id=<?php echo $course["id"];?>" class="mb-2"><button class="border border-red-500 p-2 hover:bg-red-500 hover:text-white">Learn More</button></a>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

        <!-- If we need scrollbar -->
        <!-- <div class="swiper-scrollbar"></div> -->
    </div>
</section>

