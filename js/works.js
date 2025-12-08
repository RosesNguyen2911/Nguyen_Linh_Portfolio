gsap.registerPlugin(ScrollTrigger);

/* FEATURED HEADING - SIMPLE FADE */
const featuredHeading = document.querySelector("#featured-heading");

function animateFeaturedHeading() {
  gsap.from(featuredHeading, {
    opacity: 0,
    duration: 1,
    ease: "power2.out"
  });
}

/* FLOATING SHAPES */
const floatShapes = document.querySelectorAll(".float");

function animateFloatingShapes() {
  floatShapes.forEach(function(shape) {
    const isBlue = shape.classList.contains("blue");
    const isYellow = shape.classList.contains("yellow");

    gsap.to(shape, {
      x: "+=" + gsap.utils.random(-40, 40),
      y: "+=" + gsap.utils.random(-40, 40),
      duration: gsap.utils.random(4, 7),
      repeat: -1,
      yoyo: true,
      ease: "sine.inOut"
    });

    gsap.to(shape, {
      scale: gsap.utils.random(0.9, 1.1),
      duration: gsap.utils.random(3, 5),
      repeat: -1,
      yoyo: true,
      ease: "power1.inOut"
    });

    if (isBlue) {
      gsap.to(shape, {
        x: "+=" + gsap.utils.random(-60, 60),
        y: "+=" + gsap.utils.random(-60, 60),
        duration: gsap.utils.random(3, 5),
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut"
      });
    }

    if (isYellow) {
      gsap.to(shape, {
        y: "+=" + gsap.utils.random(-55, 55),
        duration: gsap.utils.random(2.5, 3.8),
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut"
      });
    }
  });
}

/* HERO INTRO */
const heroTitle = document.querySelector("#works-hero h2");
const heroText = document.querySelector("#works-hero p");
const heroFilters = document.querySelector(".filter-bar");

function animateHeroIntro() {
  gsap.from(heroTitle, {
    opacity: 0,
    y: 20,
    duration: 1,
    ease: "power2.out"
  });

  gsap.from(heroText, {
    opacity: 0,
    y: 20,
    duration: 1,
    delay: 0.2,
    ease: "power2.out"
  });

  gsap.from(heroFilters, {
    opacity: 0,
    y: 20,
    duration: 1,
    delay: 0.4,
    ease: "power2.out"
  });
}

/* FILTER SYSTEM */
const filterButtons = document.querySelectorAll(".filter-btn");
const allCards = document.querySelectorAll(".work-card");

function handleFilterClick(event) {
  const selected = event.currentTarget.getAttribute("data-filter");

  const shuffled = Array.from(allCards).sort(function() {
    return Math.random() - 0.5;
  });

  shuffled.forEach(function(card) {
    const categories = card.getAttribute("data-category");
    const isVisible = selected === "all" || categories.includes(selected);

    if (isVisible) {
      card.style.display = "block";

      gsap.fromTo(
        card,
        { opacity: 0 },
        {
          opacity: 1,
          duration: 0.3,
          ease: "power2.out"
        }
      );
    }

    else {
      gsap.to(card, {
        opacity: 0,
        duration: 0.2,
        ease: "power2.out",
        onComplete: function() {
          card.style.display = "none";
        }
      });
    }
  });

  updateActiveButton(event.currentTarget);
}

function updateActiveButton(activeBtn) {
  filterButtons.forEach(function(btn) {
    btn.classList.remove("active");
  });

  activeBtn.classList.add("active");
}

function setFilterListeners() {
  filterButtons.forEach(function(btn) {
    btn.addEventListener("click", handleFilterClick);
  });
}

/* CALL FUNCTIONS */
animateFeaturedHeading();
animateFloatingShapes();
animateHeroIntro();
setFilterListeners();
