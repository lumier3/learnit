<?php 

  include __DIR__ . "/config/db_connect.php";
  // session_start();
  // if(!isset($_COOKIE['userId'])) {
  //   header("Location:./_actions/login.php");
  //   exit();
  // }
?>

<!DOCTYPE html>
<html lang="en">
   <?php include("templates/header.php");
   include("templates/courses.php");
   include("templates/footer.php");
   
   ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script> 
<script>
    // Function to simulate typing effect
    const exploreButton = document.getElementById('explore-button');
    function typeText(element, text, speed) {
        let i = 0;
        element.innerHTML = ''; // Clear the existing text
        const interval = setInterval(function () {
            element.innerHTML += text.charAt(i);
            i++;
            if (i >= text.length) {
                clearInterval(interval);
                // Typing animation complete, show the button
           exploreButton.classList.remove('hidden');
            }
        }, speed);
    }

    // Get the element where you want to apply the typing effect
    const typedTextElement = document.getElementById("typed-text");

    // Call the function with your desired text and typing speed (adjust the speed as needed)
    typeText(typedTextElement, typedTextElement.textContent, 12);

    // swiper sections

    const swiper = new Swiper('.swiper', {
  // Optional parameters
      loop: true,
      slidesPerView: 1, // Show 1 slide at a time
      spaceBetween: 20,
      effect: 'slide', // Slide transition effect
      speed: 1000,

      // Responsive breakpoints
        breakpoints: {
        // When screen width is more than or equal to 768 pixels
        640: {
            slidesPerView: 3, // Show 1 slide at a time
        },
    },
      
      // Adjust as needed
      autoplay: {
         delay: 2500,
        disableOnInteraction: false,
      },

  // Navigation arrows
      navigation: {
         nextEl: '.swiper-button-next',
         prevEl: '.swiper-button-prev',
      },

  // And if we need scrollbar
      scrollbar: {
         el: '.swiper-scrollbar',
      },
      on: {
      reachEnd: function () {
      swiper.slideTo(0); // When you reach the end, go back to the first slide
    },
  },
});

   
</script>


</body>
</html>