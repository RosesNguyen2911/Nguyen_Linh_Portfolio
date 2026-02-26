<!DOCTYPE html>
<html lang="en">

<?php
require_once('includes/connect.php');

/* SKILLS QUERY
I fetch all active skills first. */
$stmt_skills = $connect->prepare("
  SELECT skill_id, skill_number, skill_title, skill_desc
  FROM tbl_skills
  WHERE is_active = 1
  ORDER BY skill_id ASC
");
$stmt_skills->execute();
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About - Nguyen Linh Portfolio</title>

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

<body data-page="about">

  <!-- HEADER -->
  <header id="header" class="grid-con">
    <h1 class="hidden"> Nguyen Linh Portfolio - About Page </h1>
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
        <li><a href="about.php" class="active">About</a></li>
        <li class="mobile-connect"><a href="contact.php">Contact</a></li>
      </ul>
    </nav>

    <div class="header-connect m-col-start-12 m-col-end-13 l-col-start-12 l-col-end-13">
      <a href="contact.php" class="btn-connect">Contact</a>
    </div>
  </header>

  <main>
    <!-- HERO -->
    <section id="about-hero" class="grid-con">

      <!-- TITLE -->
      <div class="about-hero-content col-span-full">
    
        <h2 id="hero-title-1" class="hero-title">
          Hi, I’m <span class="accent">Linh Nguyen</span>
        </h2>

        <h3 id="hero-title-2" class="hero-title">
          An <span class="accent">Interactive</span> <br>
           Designer & Developer
        </h3>

        <p class="flip-hint">
          Let’s flip each card to know more facts about me <i class="far fa-smile-wink"></i>
        </p>
        
    
      </div>
    
      <!-- 3 FLIP PHOTOS -->
<div class="card-container col-span-full m-col-span-full l-col-span-full">

  <div class="card" id="card-1">
    <div class="card-front">
      <img src="images/card_1.png" alt="Work Style">
    </div>
    <div class="card-back">
      <span>Thoughtful & Precise</span>
      <p>I refine every detail until a design feels balanced, intentional, and meaningful.</p>
    </div>
  </div>

  <div class="card" id="card-2">
    <div class="card-front">
      <img src="images/card_2.png" alt="Creative Personality">
    </div>
    <div class="card-back">
      <span>Curiosity First</span>
      <p>I experiment, explore, and follow curiosity - that’s where my best ideas happen.</p>
    </div>
  </div>

  <div class="card" id="card-3">
    <div class="card-front">
      <img src="images/card_3.png" alt="Personal Vibe">
    </div>
    <div class="card-back">
      <span>Warm & Collaborative</span>
      <p>I listen, communicate clearly, and bring calm positive energy to every team.</p>
    </div>
  </div>

</div>

    </section>
    
<!-- SKILLS & TOOLS -->
     <section id="skills">
  <h2 class="skills-heading">Skills & Tools</h2>

  <?php
  while ($skill = $stmt_skills->fetch(PDO::FETCH_ASSOC)) {

    echo '
      <div class="skill-row">
        <span class="skill-number">'.$skill['skill_number'].'</span>

        <div class="skill-info">
          <h3>'.$skill['skill_title'].'</h3>

          <p>
            '.$skill['skill_desc'].'
          </p>

          <div class="skill-icons">
    ';

    /* TOOLS QUERY (PER SKILL)
       I fetch tools related to the current skill using the junction table. */
    $stmt_tools = $connect->prepare("
      SELECT t.tool_src, t.tool_alt
      FROM tbl_skills_tools st
      INNER JOIN tbl_tools t ON t.tool_id = st.tool_id
      WHERE st.skill_id = :skill_id
        AND t.is_active = 1
      ORDER BY t.tool_id ASC
    ");

    $stmt_tools->bindParam(':skill_id', $skill['skill_id'], PDO::PARAM_INT);
    $stmt_tools->execute();

    while ($tool = $stmt_tools->fetch(PDO::FETCH_ASSOC)) {
      echo '
        <img src="images/'.$tool['tool_src'].'" alt="'.$tool['tool_alt'].'">
      ';
    }

    $stmt_tools = null;

    echo '
          </div>
        </div>
      </div>
    ';
  }

  $stmt_skills = null;
  ?>
</section>


<div class="resume-wrapper">
  <a 
    class="resume-btn"
    href="images/Linh_Nguyen_Resume.pdf"
    target="_blank"
    rel="noopener"
  >
    My Resume
  </a>
</div>
  </main>


  <!-- FOOTER -->
  <footer id="footer" class="grid-con">
    <div class="footer-top col-span-full">
      <nav class="footer-nav">
        <h2 class="hidden">Footer Navigation</h2>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="works.php">Works</a></li>
          <li><a href="about.php" class="active">About</a></li>
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
      <a href="contact.php" class="btn-connect">Contact</a>
    </section>

    <div class="footer-bottom col-span-full">
      <p class="credit-left">Design and Developed by Linh Nguyen</p>
      <p class="credit-right">© 2026 All Rights Reserved</p>
    </div>
  </footer>

</body>
</html>