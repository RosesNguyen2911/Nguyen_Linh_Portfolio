<!DOCTYPE html>
<html lang="en">

<?php

/*FAQ QUERY 
I load my PDO connection first, then prepare and execute the FAQ query
so the FAQ section can be generated dynamically from the database. */

require_once('includes/connect.php');

$stmt_faq = $connect->prepare("
    SELECT faq_id, faq_icon, faq_question, faq_answer 
    FROM tbl_faqs 
    WHERE is_active = 1
    ORDER BY faq_id ASC
");

$stmt_faq->execute();
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact - Nguyen Linh Portfolio</title>

  <link rel="stylesheet" href="css/grid.css">
  <link rel="stylesheet" href="css/main.css">

   <!-- FONTS & ICON -->
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&display=swap" rel="stylesheet">

 <!-- FAVICON -->
  <link rel="icon" type="image/png" href="L_Favicon/favicon-96x96.png" sizes="96x96">
  <link rel="icon" type="image/svg+xml" href="L_Favicon/favicon.svg">
  <link rel="shortcut icon" href="L_Favicon/favicon.ico">
  <link rel="apple-touch-icon" sizes="180x180" href="L_Favicon/apple-touch-icon.png">
  <link rel="manifest" href="L_Favicon/site.webmanifest">

  <!-- SCRIPT -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/TextPlugin.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
  <script type="module" src="js/main.js"></script>

</head>

<body data-page="contact">

  <!-- HEADER -->
  <header id="header" class="grid-con">
    <h1 class="hidden"> Nguyen Linh Portfolio - Contact Page </h1>
    <div class="header-logo col-span-2 m-col-span-3 l-col-span-2">
      <a href="index.php" class="logo-wrapper">
        <img src="images/L_Logo.svg" alt="Linh Nguyen Logo">

        <div class="logo-text">
          <span>Linh</span>
          <span>Nguyen</span>
        </div>
      </a>
    </div>

    <input type="checkbox" id="menu-toggle" hidden>

    <label for="menu-toggle" class="header-hamburger col-start-4 col-end-5">
      <span></span><span></span><span></span>
    </label>

    <nav class="header-nav m-col-start-6 m-col-end-8 l-col-start-6 l-col-end-8">
      <h2 class="hidden"> Main Navigation</h2>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="works.php">Works</a></li>
        <li><a href="about.php">About</a></li>
        <li class="mobile-connect"><a href="contact.php" class="active">Contact</a></li>
      </ul>
    </nav>

    <div class="header-connect m-col-start-12 m-col-end-13 l-col-start-12 l-col-end-13">
      <a href="contact.php" class="btn-connect active">Contact</a>
    </div>
  </header>

   
  <main>
    <!-- HERO -->
    <section id="contact-hero" class="grid-con">
      <div class="contact-intro col-span-full m-col-span-full l-col-span-full">
        <h2 class="col-span-full m-col-span-full l-col-span-full">Let’s <span class="accent">Connect</span> and <span class="accent">Collaborate</span></h2>
        <p>
          Have a creative idea or project in mind?
          Fill out the form below or explore the FAQs to learn more about how we can work together.
        </p>
      </div>
    </section>

    <!-- CONTACT FORM -->
    <section id="contact-form" class="grid-con">
      <h2 class="col-span-full m-col-span-full l-col-span-full">Contact Me</h2>

      <div id="form-box" class="contact-form-box col-span-full m-col-start-2 m-col-end-12 l-col-start-2 l-col-end-12">

      <form id="contactForm" action="includes/send.php" method="post" novalidate>

          <div class="form-group">
            <label for="name">Name</label>
            <input
              type="text"
              id="name"
              name="name"
              placeholder="Your Full Name"
            >
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input
              type="text"
              id="email"
              name="email"
              placeholder="Your Email"
            >
          </div>

          <div class="form-group">
            <label for="message">Message</label>
            <textarea
              id="message"
              name="message"
              rows="5"
              placeholder="Tell Me About Your Project..."
            ></textarea>
            <small>
              *Please fill out all required sections.
            </small>
          </div>

          <div id="successBox" class="custom-success-box form-success-under-btn" hidden>
            <p>
              <i class="fa-solid fa-circle-check"></i>
              <span id="successText"></span>
            </p>
          </div>

          <div id="errorBox" class="custom-errors-box form-errors-under-btn" hidden>
            <ul id="errorList"></ul>
          </div>

          <button type="submit" class="btn-submit">Send Message</button>

        </form>

      </div>
    </section>

<!-- FAQ -->
<section id="faqs" class="grid-con">
  <h2 class="col-span-full">Frequently Asked Questions</h2>

  <?php 
  while($row = $stmt_faq->fetch(PDO::FETCH_ASSOC)) {

    echo '
      <article class="faq-item col-span-full m-col-span-3 l-col-span-3">
        <div class="faq-inner">
          <h3>
            <i class="'.($row['faq_icon']).'"></i> 
            '.($row['faq_question']).'
          </h3>
          <p>'.($row['faq_answer']).'</p>
        </div>
      </article>
    ';
  }

  $stmt_faq = null;
  ?>
</section>

  </main>

  <!-- FOOTER -->
  <footer id="footer" class="grid-con">
    <div class="footer-top col-span-full">
      <nav class="footer-nav">
        <h2 class="hidden">Footer Navigation</h2>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="works.php">Works</a></li>
          <li><a href="about.php">About</a></li>
        </ul>
      </nav>

      <div class="footer-social">
        <a href="https://github.com/RosesNguyen2911" aria-label="GitHub"><i class="fab fa-github"></i></a>
        <a href="https://www.instagram.com/k._.ninhh/" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="https://www.linkedin.com/in/linh-nguyen-893b79325/" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
      </div>
    </div>

    <section class="footer-cta col-span-full">
      <h2 class="hidden">Footer Call To Action</h2>
      <h3>Ready to Bring Your Vision to Life?</h3>
      <p>
        Let’s make something incredible together! Reach out to discuss your project,
        and let’s create designs that resonate and inspire.
      </p>
      <a href="contact.php" class="btn-connect active">Contact</a>
    </section>

    <div class="footer-bottom col-span-full">
      <p class="credit-left">Design and Developed by Linh Nguyen</p>
      <p class="credit-right">© 2026 All Rights Reserved</p>
    </div>
  </footer>

</body>
</html>