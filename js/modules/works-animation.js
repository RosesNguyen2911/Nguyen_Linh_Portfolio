export function workAnimation(){
gsap.registerPlugin(ScrollTrigger);

/* FEATURED HEADING - SIMPLE FADE */
const featuredHeading = document.querySelector("#featured-heading");

function animateFeaturedHeading() {
  gsap.from(featuredHeading, {
    opacity: 0,
    duration: 1,
    ease: "power2.out",
  });
}

/* FLOATING SHAPES */
const floatShapes = document.querySelectorAll(".float");

function animateFloatingShapes() {
  floatShapes.forEach(function (shape) {
    const isBlue = shape.classList.contains("blue");
    const isYellow = shape.classList.contains("yellow");

    gsap.to(shape, {
      x: "+=" + gsap.utils.random(-40, 40),
      y: "+=" + gsap.utils.random(-40, 40),
      duration: gsap.utils.random(4, 7),
      repeat: -1,
      yoyo: true,
      ease: "sine.inOut",
    });

    gsap.to(shape, {
      scale: gsap.utils.random(0.9, 1.1),
      duration: gsap.utils.random(3, 5),
      repeat: -1,
      yoyo: true,
      ease: "power1.inOut",
    });

    if (isBlue) {
      gsap.to(shape, {
        x: "+=" + gsap.utils.random(-60, 60),
        y: "+=" + gsap.utils.random(-60, 60),
        duration: gsap.utils.random(3, 5),
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut",
      });
    }

    if (isYellow) {
      gsap.to(shape, {
        y: "+=" + gsap.utils.random(-55, 55),
        duration: gsap.utils.random(2.5, 3.8),
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut",
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
    ease: "power2.out",
  });

  gsap.from(heroText, {
    opacity: 0,
    y: 20,
    duration: 1,
    delay: 0.2,
    ease: "power2.out",
  });

  gsap.from(heroFilters, {
    opacity: 0,
    y: 20,
    duration: 1,
    delay: 0.4,
    ease: "power2.out",
  });
}

/* FILTER SYSTEM (FIXED FOR YOUR HTML) */
const filterButtons = document.querySelectorAll(".filter-btn");
const allCards = document.querySelectorAll(".work-card");

function normalizeTagText(text) {
  return text.trim().toLowerCase();
}

function getCardTags(card) {
  const tagSpans = card.querySelectorAll(".work-tags span");
  const tags = [];

  tagSpans.forEach(function (span) {
    tags.push(normalizeTagText(span.textContent));
  });

  return tags;
}

function filterToRequiredTag(selectedFilter) {
  if (selectedFilter === "branding") {
    return "branding";
  }

  if (selectedFilter === "motion") {
    return "motion design";
  }

  if (selectedFilter === "web") {
    return "web development";
  }

  if (selectedFilter === "3d") {
    return "3d modeling";
  }

  return "all";
}

function showCard(card) {
  card.style.display = "";
  gsap.fromTo(
    card,
    { opacity: 0 },
    { opacity: 1, duration: 0.3, ease: "power2.out" }
  );
}

function hideCard(card) {
  gsap.to(card, {
    opacity: 0,
    duration: 0.2,
    ease: "power2.out",
    onComplete: function () {
      card.style.display = "none";
      card.style.opacity = "";
    },
  });
}

function updateActiveButton(activeBtn) {
  filterButtons.forEach(function (btn) {
    btn.classList.remove("active");
  });

  activeBtn.classList.add("active");
}

function applyFilter(selectedFilter) {
  const requiredTag = filterToRequiredTag(selectedFilter);

  allCards.forEach(function (card) {
    if (requiredTag === "all") {
      showCard(card);
      return;
    }

    const tags = getCardTags(card);
    const isVisible = tags.includes(requiredTag);

    if (isVisible) {
      showCard(card);
    } else {
      hideCard(card);
    }
  });
}

function handleFilterClick(event) {
  const selected = event.currentTarget.getAttribute("data-filter");
  applyFilter(selected);
  updateActiveButton(event.currentTarget);
}

function setFilterListeners() {
  filterButtons.forEach(function (btn) {
    btn.addEventListener("click", handleFilterClick);
  });
}

/* CALL FUNCTIONS */
animateFeaturedHeading();
animateFloatingShapes();
animateHeroIntro();
setFilterListeners();
applyFilter("all");
}