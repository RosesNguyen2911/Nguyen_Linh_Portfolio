gsap.registerPlugin(ScrollTrigger);

// Reusable fade + slide animation
function fadeUpOnScroll(targets) {
  gsap.utils.toArray(targets).forEach(el => {
    gsap.from(el, {
      opacity: 0,
      y: 40,
      duration: 1,
      ease: "power2.out",
      scrollTrigger: {
        trigger: el,
        start: "top 90%",
        toggleActions: "play reverse play reverse"
      }
    });
  });
}

// Apply animations
fadeUpOnScroll("#project-hero .hero-wrapper");   // Hero title/subtitle
fadeUpOnScroll("#project-desc p");               // Description text
fadeUpOnScroll(".info-item, .info-image");       // Info grid
fadeUpOnScroll(".section-title, .list");         // Section titles + text blocks
fadeUpOnScroll("#details img");                  // Detail shots images
fadeUpOnScroll("#more-projects .slider-card");   // More project cards