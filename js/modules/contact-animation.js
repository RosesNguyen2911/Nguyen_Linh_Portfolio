export function contactAnimation() {
  gsap.registerPlugin(ScrollTrigger);

  const heroTitle = document.querySelector('#contact-hero h2');
  const heroText = document.querySelector('#contact-hero p');
  const accentWords = document.querySelectorAll('#contact-hero .accent');

  /* HERO TEXT SPLIT */
  function splitAccentLetters() {
    accentWords.forEach((group) => {
      const letters = group.textContent.trim();
      let html = '';

      for (let i = 0; i < letters.length; i++) {
        html += `<span class="letter">${letters[i]}</span>`;
      }

      group.innerHTML = html;
    });
  }

  /* HERO ACCENT BOUNCE */
  function addAccentBounce() {
    accentWords.forEach((word) => {
      word.addEventListener('mouseenter', () => {
        gsap.fromTo(
          word,
          { y: 0, scale: 1 },
          {
            y: -12,
            scale: 1.1,
            duration: 0.25,
            ease: 'power2.out',
            onComplete: () => {
              gsap.to(word, {
                y: 0,
                scale: 1,
                duration: 0.25,
                ease: 'power2.in',
              });
            },
          }
        );
      });
    });
  }

  /* HERO LOAD */
  function animateHeroLoad() {
    gsap.from(heroTitle, {
      opacity: 0,
      y: 45,
      duration: 1.1,
      ease: 'power3.out',
    });

    gsap.from(heroText, {
      opacity: 0,
      y: 30,
      delay: 0.25,
      duration: 1,
      ease: 'power3.out',
    });

    gsap.from('#contact-hero .letter', {
      opacity: 0,
      y: 20,
      delay: 0.4,
      duration: 0.7,
      stagger: 0.05,
      ease: 'power2.out',
    });
  }

  /* HERO SCROLL */
  function animateHeroScroll() {
    gsap.fromTo(
      heroTitle,
      { opacity: 0, y: 40 },
      {
        opacity: 1,
        y: 0,
        duration: 1,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: heroTitle,
          start: 'top 90%',
          toggleActions: 'play reverse play reverse',
        },
      }
    );

    gsap.fromTo(
      heroText,
      { opacity: 0, y: 30 },
      {
        opacity: 1,
        y: 0,
        duration: 1,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: heroText,
          start: 'top 92%',
          toggleActions: 'play reverse play reverse',
        },
      }
    );
  }

  function initHeroAnimations() {
    if (!heroTitle || !heroText || accentWords.length === 0) return;

    splitAccentLetters();
    addAccentBounce();
    animateHeroLoad();
    animateHeroScroll();
  }

  initHeroAnimations();
}