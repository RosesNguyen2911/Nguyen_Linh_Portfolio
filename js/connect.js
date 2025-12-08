gsap.registerPlugin(ScrollTrigger);

const heroTitle = document.querySelector("#contact-hero h2");
const heroText = document.querySelector("#contact-hero p");
const accentWords = document.querySelectorAll("#contact-hero .accent");
const contactFormBox = document.querySelector("#contact-form form");
const contactHeading = document.querySelector("#contact-form h2");


// HERO SETUP
function splitAccentLetters() {
  accentWords.forEach(function(group) {
    const letters = group.textContent.trim();
    let html = "";
    for (let i = 0; i < letters.length; i++) {
      html += `<span class="letter">${letters[i]}</span>`;
    }
    group.innerHTML = html;
  });
}

function addAccentBounce() {
  accentWords.forEach(function(word) {
    word.addEventListener("mouseenter", handleAccentBounce);
  });
}

function handleAccentBounce(event) {
  const word = event.currentTarget;
  gsap.fromTo(
    word,
    { y: 0, scale: 1 },
    {
      y: -12,
      scale: 1.1,
      duration: 0.25,
      ease: "power2.out",
      onComplete: resetAccentBounce.bind(null, word)
    }
  );
}

function resetAccentBounce(word) {
  gsap.to(word, {
    y: 0,
    scale: 1,
    duration: 0.25,
    ease: "power2.in"
  });
}


// HERO ANIMATIONS ON LOAD
function animateHeroLoad() {
  gsap.from(heroTitle, {
    opacity: 0,
    y: 45,
    duration: 1.1,
    ease: "power3.out"
  });

  gsap.from(heroText, {
    opacity: 0,
    y: 30,
    delay: 0.25,
    duration: 1,
    ease: "power3.out"
  });

  gsap.from("#contact-hero .letter", {
    opacity: 0,
    y: 20,
    delay: 0.4,
    duration: 0.7,
    stagger: 0.05,
    ease: "power2.out"
  });
}


// HERO ANIMATIONS ON SCROLL
function animateHeroScroll() {
  gsap.fromTo(
    heroTitle,
    { opacity: 0, y: 40 },
    {
      opacity: 1,
      y: 0,
      duration: 1,
      ease: "power2.out",
      scrollTrigger: {
        trigger: heroTitle,
        start: "top 90%",
        toggleActions: "play reverse play reverse"
      }
    }
  );

  gsap.fromTo(
    heroText,
    { opacity: 0, y: 30 },
    {
      opacity: 1,
      y: 0,
      duration: 1,
      ease: "power2.out",
      scrollTrigger: {
        trigger: heroText,
        start: "top 92%",
        toggleActions: "play reverse play reverse"
      }
    }
  );
}


// CONTACT FORM ANIMATIONS
function animateContactForm() {
  gsap.fromTo(
    contactHeading,
    { opacity: 0, y: 40, scale: 0.95 },
    {
      opacity: 1,
      y: 0,
      scale: 1,
      duration: 1,
      ease: "power2.out",
      scrollTrigger: {
        trigger: contactHeading,
        start: "top 90%",
        toggleActions: "play none play none"
      }
    }
  );

  gsap.fromTo(
    contactFormBox,
    { opacity: 0, y: 50, scale: 0.97 },
    {
      opacity: 1,
      y: 0,
      scale: 1,
      duration: 1.1,
      ease: "power2.out",
      scrollTrigger: {
        trigger: contactFormBox,
        start: "top 85%",
        toggleActions: "play none play none"
      }
    }
  );
}


// INITIALIZE ALL ANIMATIONS
function initPageAnimations() {
  splitAccentLetters();
  addAccentBounce();
  animateHeroLoad();
  animateHeroScroll();
  animateContactForm();
}

initPageAnimations();


// FAQS ANIMATION


gsap.registerPlugin(ScrollTrigger);

const faqHeading = document.querySelector("#faqs h2");
const faqItems = document.querySelectorAll(".faq-item");


// I animate the FAQ heading like the Featured section
function animateFaqHeading() {
  gsap.fromTo(
    faqHeading,
    { opacity: 0, scale: 0.9 },
    {
      opacity: 1,
      scale: 1,
      duration: 1,
      ease: "power2.out",
      scrollTrigger: {
        trigger: faqHeading,
        start: "top 90%",
        toggleActions: "play reverse play reverse"
      }
    }
  );
}


// I animate each FAQ item with its own scroll trigger
function animateFaqItems() {
  faqItems.forEach(function(item) {
    gsap.fromTo(
      item,
      { opacity: 0, y: 40 },
      {
        opacity: 1,
        y: 0,
        duration: 1.1,
        ease: "power2.out",
        scrollTrigger: {
          trigger: item,
          start: "top 85%",
          toggleActions: "play reverse play reverse"
        }
      }
    );
  });
}


// I run all FAQ animations
function runFaqAnimations() {
  animateFaqHeading();
  animateFaqItems();
}

runFaqAnimations();

// FORM STATUS ANIMATION
gsap.registerPlugin(ScrollTrigger);

// I animate the message box when it appears
function animateFormStatus() {
    const box = document.querySelector(".form-status");

    if (!box) return;

    if (box.classList.contains("error")) {
        gsap.from(box, {
            opacity: 0,
            y: 20,
            duration: 0.5,
            ease: "power2.out"
        });
    } else if (box.classList.contains("success")) {
        gsap.from(box, {
            opacity: 0,
            scale: 0.85,
            duration: 0.6,
            ease: "back.out(1.7)"
        });
    }
}

// I shake invalid fields using GSAP
function animateErrorFields() {
    const badFields = document.querySelectorAll(".error-field");

    badFields.forEach(function(field) {
        gsap.from(field, {
            x: -8,
            duration: 0.1,
            ease: "power1.inOut",
            yoyo: true,
            repeat: 3
        });
    });
}

// I run animations because script loads AFTER HTML
animateFormStatus();
animateErrorFields();



// FORM STATUS ANIMATION
// I select the form section so I can move the view after the user submits the form
const formSection = document.querySelector("#contact-form");

// I select the form box so I can animate it when there are errors
const formBox = document.querySelector("#form-box");


// I scroll to the form only right after the form has been submitted
function scrollAfterSubmit() {
  const params = new URLSearchParams(window.location.search);
  const fromSubmit = params.get("from");

  if (fromSubmit === "submit") {
    formSection.scrollIntoView({
      behavior: "smooth",
      block: "start"
    });
  }
}


// I shake the form a little when there are validation errors so the user notices them
function shakeForm() {
  const hasErrors = window.location.search.includes("errors=");

  if (hasErrors) {
    gsap.fromTo(
      formBox,
      { x: 0 },
      {
        x: -20,
        duration: 0.1,
        repeat: 5,
        yoyo: true,
        ease: "power1.inOut",
        onComplete: () => {
          gsap.set(formBox, { x: 0 });
        }
      }
    );
  }
}



// I clear the URL parameters so refreshing the page doesn’t keep the old messages
function clearURLParams() {
  const params = new URLSearchParams(window.location.search);
  const fromSubmit = params.get("from");

  // I only clear the URL if the form was just submitted
  if (fromSubmit === "submit") {
    window.history.replaceState({}, "", "connect.php");
  }
}


// I run everything after the page loads
window.addEventListener("load", () => {
  scrollAfterSubmit();
  shakeForm();

  // I add a small delay so animations still run before the URL gets cleaned
  setTimeout(clearURLParams, 800);
});
