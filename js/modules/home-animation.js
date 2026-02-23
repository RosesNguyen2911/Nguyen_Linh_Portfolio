export function homeAnimation(){
// Register GSAP ScrollTrigger
gsap.registerPlugin(ScrollTrigger);

//
// HERO SECTION
//

// Typing cycle for role text
const roleText = document.querySelector("#type-role");
const roles = ["Branding", "Illustration", "Web Development", "Motion Graphics", "UX/UI", "2D/3D"];
let roleIndex = 0;

function typeRole(value) {
  return gsap.to(roleText, { text: value, duration: 1.2, ease: "power2.out" });
}

function clearRole() {
  return gsap.to(roleText, { text: "", duration: 0.6, ease: "power2.in" });
}

function startRoleCycle() {
  typeRole(roles[roleIndex]).then(() => {
    gsap.delayedCall(1, () => {
      clearRole().then(() => {
        roleIndex = (roleIndex + 1) % roles.length;
        startRoleCycle();
      });
    });
  });
}

// Hero load animation
function animateHero() {
  const tl = gsap.timeline({ defaults: { ease: "power3.out" } });

  tl.from("#hero", { opacity: 0, duration: 0.3 })
    .from(".hero-tagline", { y: 20, opacity: 0, duration: 0.8 })
    .from(".hero-second-line", { y: 20, opacity: 0, duration: 0.8 })
    .from(".banner-bg", { x: -200, rotation: -6, opacity: 0, duration: 1 })
    .from(".hero-avatar", {
      scale: 0.3,
      rotation: -20,
      opacity: 0,
      duration: 1,
      ease: "back.out(1.8)"
    }, "-=0.6")
    .fromTo(".status-btn",
      { opacity: 0, y: 20 },
      { opacity: 1, y: 0, duration: 0.8 },
      "-=0.3"
    );
}

animateHero();
startRoleCycle();


// ABOUT SECTION — reveal with wider movement

// Avatar: slide in from left
gsap.from(".about-avatar-wrapper", {
  x: -150, 
  opacity: 0,
  scrollTrigger: {
    trigger: "#about",
    start: "top 95%",
    end: "top 35%",
    scrub: true,
    toggleActions: "play reverse play reverse"
  }
});

// Intro: slide in from right
gsap.from(".about-intro", {
  x: 120,
  opacity: 0,
  scrollTrigger: {
    trigger: "#about",
    start: "top 92%",
    end: "top 35%",
    scrub: true,
    toggleActions: "play reverse play reverse"
  }
});

// Paragraphs: rise up with stagger
gsap.from(".about-text-wrapper p", {
  y: 70,
  opacity: 0,
  stagger: 0.15,
  scrollTrigger: {
    trigger: "#about",
    start: "top 88%",
    end: "top 35%",
    scrub: true,
    toggleActions: "play reverse play reverse"
  }
});

// Button: soft rise up
gsap.from(".about-btn", {
  y: 60,
  opacity: 0,
  scrollTrigger: {
    trigger: "#about",
    start: "top 85%",
    end: "top 35%",
    scrub: true,
    toggleActions: "play reverse play reverse"
  }
});


// VIDEO SECTION — smooth rise reveal
gsap.from(".video-wrapper", {
  y: 120,
  opacity: 0,
  scrollTrigger: {
    trigger: ".about-video",
    start: "top 80%",
    end: "top 40%",
    scrub: true,
    toggleActions: "play reverse play reverse"
  }
});


// SERVICES ANIMATION

  gsap.registerPlugin(ScrollTrigger);

  const tickerElements = document.querySelectorAll(".ticker");

  function cloneTickerContent(inner, content) {
    const duplicate = content.cloneNode(true);
    inner.append(duplicate);
  }

  function animateTickerElements(inner, duration) {
    const animations = [];

    const groups = inner.querySelectorAll(".ticker-text");
    groups.forEach(function (group) {
      const anim = gsap.to(group, {
        x: "-100%",
        repeat: -1,
        duration: duration,
        ease: "linear"
      });
      animations.push(anim);
    });

    return animations;
  }

  function handlePauseAnimations(animations) {
    animations.forEach(function (anim) {
      anim.pause();
    });
  }

  function handlePlayAnimations(animations) {
    animations.forEach(function (anim) {
      anim.play();
    });
  }

  function initializeTicker(ticker) {
    const inner = ticker.querySelector(".ticker-wrap");
    const content = inner.querySelector(".ticker-text");
    const duration = Number(ticker.getAttribute("data-duration"));

    cloneTickerContent(inner, content);

    const animations = animateTickerElements(inner, duration);

    function pauseTicker() {
      handlePauseAnimations(animations);
    }

    function resumeTicker() {
      handlePlayAnimations(animations);
    }

    ticker.addEventListener("mouseenter", pauseTicker);
    ticker.addEventListener("mouseleave", resumeTicker);
  }

  tickerElements.forEach(initializeTicker);



// TESTIMONIALS CAROUSEL

// select elements
const sliderWrapper = document.querySelector(".testimonials-wrapper");
const cards = document.querySelectorAll(".testimonial-card");
const btnPrev = document.querySelector(".btn-prev");
const btnNext = document.querySelector(".btn-next");

// keep track of the current slide
let currentIndex = 0;

// move wrapper based on the slide number
function updateCarousel() {
  sliderWrapper.style.transform = `translateX(${currentIndex * -100}%)`;
}

// go next and previous
function goNext() { currentIndex = (currentIndex + 1) % cards.length; updateCarousel(); }
function goPrev() { currentIndex = (currentIndex - 1 + cards.length) % cards.length; updateCarousel(); }

// button events
btnNext.addEventListener("click", goNext);
btnPrev.addEventListener("click", goPrev);

// set start
updateCarousel();

// GSAP animations for testimonials
gsap.registerPlugin(ScrollTrigger);

// animate whole section with play reverse
function animateTestimonialsSection() {
  gsap.fromTo(
    ".testimonials-section",
    { opacity: 0, y: 40 },
    {
      opacity: 1,
      y: 0,
      duration: 1,
      ease: "power2.out",
      scrollTrigger: {
        trigger: ".testimonials-section",
        start: "top 70%",
        toggleActions: "play reverse play reverse"
      }
    }
  );
}

// animate each card individually with reverse
function animateTestimonialCards() {
  const cards = document.querySelectorAll(".testimonial-card");

  cards.forEach(function(card) {
    gsap.fromTo(
      card,
      { opacity: 0, y: 50 },
      {
        opacity: 1,
        y: 0,
        duration: 1.1,
        ease: "power2.out",
        scrollTrigger: {
          trigger: card,
          start: "top 70%",
          toggleActions: "play reverse play reverse"
        }
      }
    );
  });
}

// call functions
animateTestimonialsSection();
animateTestimonialCards();
}

