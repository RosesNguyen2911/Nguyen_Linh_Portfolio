export function featuredWorks(){
gsap.registerPlugin(ScrollTrigger);

// I selected all cards so I can animate each one independently
const featuredCards = document.querySelectorAll(".work-card");
const featuredHeading = document.querySelector("#featured-heading");

// I animated the heading so it reacts when scrolling down and up
function animateFeaturedHeading() {
  gsap.fromTo(
    featuredHeading,
    { opacity: 0, scale: 0.9 },
    {
      opacity: 1,
      scale: 1,
      duration: 1,
      ease: "power2.out",
      scrollTrigger: {
        trigger: featuredHeading,
        start: "top 90%",
        toggleActions: "play reverse play reverse"
      }
    }
  );
}

// I animated each card with its own scroll trigger so they appear when scrolling both ways
function animateFeaturedCards() {
  featuredCards.forEach(function(card) {
    gsap.fromTo(
      card,
      { opacity: 0, y: 40 },
      {
        opacity: 1,
        y: 0,
        duration: 1.1,
        ease: "power2.out",
        scrollTrigger: {
          trigger: card,
          start: "top 85%",
          toggleActions: "play reverse play reverse"
        }
      }
    );
  });
}

// I call these functions because the script loads after the HTML
animateFeaturedHeading();
animateFeaturedCards();
}