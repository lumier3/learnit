<!---

1. course name
2. description
3. learn more

---->

<?php 

//connect sql database
$conn = mysqli_connect('localhost', 'lumiere' , '136300', 'learnitdb');

//check connection
if (!$conn) {
   echo 'Error connecting to'. mysqli_connect_error();
}

// query database
$sql = "SELECT * FROM courses";

//execute query
$result = mysqli_query($conn , $sql);

//check query

if (!$result) {
   echo 'Error: '. mysqli_error($conn);
}

//fetch data
$courses = mysqli_fetch_all($result, MYSQLI_ASSOC);

//close connection  
mysqli_free_result($result);
mysqli_close($conn);

?>


<section class="mt-10">
    <h1 class="text-4xl text-center">Courses Offer by LearnIt</h1>
    

    <!-- Slider main container -->
    <div class="swiper mt-6 mx-auto w-[90%] h-[300px]">
    <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <?php foreach($courses as $course) { ?>
                <div class="swiper-slide text-center w-full md:w-[33%]">
                    <h2><?php echo htmlspecialchars($course["name"]); ?></h2>
                    <p><?php echo htmlspecialchars($course["description"]);?></p>
                    <button class="border border-red-500 p-2   "><a href="course.php?id=<?php echo $course["id"];?>">Learn More</a></button>
                </div>
            <?php } ?>
        </div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

        <!-- If we need scrollbar -->
        <div class="swiper-scrollbar"></div>
    </div>
</section>