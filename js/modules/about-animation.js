export function aboutAnimation(){
gsap.registerPlugin(ScrollTrigger);

// ELEMENTS
const titleIntro = document.querySelector("#hero-title-1");
const titleMulti = document.querySelector("#hero-title-2");
const flipHint = document.querySelector(".flip-hint");
const cards = document.querySelectorAll(".card");


// TEXT ANIMATIONS
function animateHeroText() {

  gsap.from(titleIntro, {
    opacity: 0,
    y: 60,
    duration: 1.1,
    ease: "power3.out",
    scrollTrigger: {
      trigger: "#about-hero",
      start: "top 85%",
    }
  });

  gsap.from(titleMulti, {
    opacity: 0,
    x: -60,
    duration: 1.1,
    delay: 0.2,
    ease: "power3.out",
    scrollTrigger: {
      trigger: "#about-hero",
      start: "top 80%",
    }
  });

  gsap.from(flipHint, {
    opacity: 0,
    x: 50,
    duration: 0.9,
    delay: 0.35,
    ease: "power2.out",
    scrollTrigger: {
      trigger: "#about-hero",
      start: "top 78%",
    }
  });
}

// CARD SCROLL-IN ANIMATE
function animateCards() {
  gsap.from(cards, {
    opacity: 0,
    y: 50,
    rotate: 3,
    duration: 1.1,
    stagger: 0.18,
    ease: "power3.out",
    scrollTrigger: {
      trigger: ".card-container",
      start: "top 95%",
    }
  });
}


// FLIP CARD 
function handleCardClick(event) {
  const card = event.currentTarget;
  const flipped = card.classList.contains("is-flipped");

  gsap.to(card, {
    rotateY: flipped ? 0 : 180,
    duration: 0.8,
    ease: "power2.inOut"
  });

  card.classList.toggle("is-flipped");
}

cards.forEach(card => card.addEventListener("click", handleCardClick));

// CALL FUNCTION
  animateHeroText();
  animateCards();



  // SKILLS TOOLS ANIMATE
  gsap.registerPlugin(ScrollTrigger);

// I animate each skill row when it enters the viewport
function animateSkillRows() {
  const rows = document.querySelectorAll(".skill-row");

  rows.forEach(function(row) {

    const line = row.querySelector("::after"); // pseudo effect handled in GSAP via cssRule

    // animate heading + paragraph
    const title = row.querySelector("h3");
    const text = row.querySelector("p");

    const tl = gsap.timeline({
      scrollTrigger: {
        trigger: row,
        start: "top 85%",
        toggleActions: "play none none reverse"
      }
    });

    // animate row fade + upward
    tl.from(row, {
      opacity: 0,
      y: 40,
      duration: 0.6,
      ease: "power2.out"
    });

    // animate title
    tl.from(title, {
      opacity: 0,
      x: -20,
      duration: 0.4
    }, "-=0.3");

    // animate text
    tl.from(text, {
      opacity: 0,
      x: 20,
      duration: 0.4
    }, "-=0.3");

    // animate line underline (::after)
    tl.to(row, {
      "--lineWidth": "100%",  
      duration: 0.9,
      ease: "power2.out"
    }, "-=0.3");
  });
}

animateSkillRows();

}
