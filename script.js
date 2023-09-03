// Function to simulate typing effect
const exploreButton = document.getElementById("explore-button");
function typeText(element, text, speed) {
  let i = 0;
  element.innerHTML = ""; // Clear the existing text
  const interval = setInterval(function () {
    element.innerHTML += text.charAt(i);
    i++;
    if (i >= text.length) {
      clearInterval(interval);
      // Typing animation complete, show the button
      exploreButton.classList.remove("hidden");
    }
  }, speed);
}

// Find all elements with the class name "swiper"
const swiper = new Swiper(".swiper", {
  // Optional parameters
  loop: true,
  slidesPerView: 1, // Show 1 slide at a time
  spaceBetween: 20,
  effect: "slide", // Slide transition effect
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
    delay: 1500,
    disableOnInteraction: false,
  },

  // Navigation arrows
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },

  // And if we need scrollbar
  scrollbar: {
    el: ".swiper-scrollbar",
  },
  on: {
    reachEnd: function () {
      swiper.slideTo(0); // When you reach the end, go back to the first slide
    },
  },
});
