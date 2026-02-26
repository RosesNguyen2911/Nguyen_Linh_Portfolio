<!DOCTYPE html>
<html lang="en">

<?php

require_once('includes/connect.php');

/* PROJECTS QUERRY
I get title, brief, subtitle and color from tbl_projects.
I also get the first poster (src and alt) from tbl_projects_media. */
$stmt_projects = $connect->prepare("
  SELECT
    p.project_id,
    p.project_title,
    p.project_brief,
    p.project_subtitle,
    p.project_color,

    (
      SELECT pm.project_media_src
      FROM tbl_projects_media pm
      WHERE pm.project_id = p.project_id
        AND pm.project_media_type = 'poster'
        AND pm.is_active = 1
      ORDER BY pm.project_media_order ASC
      LIMIT 1
    ) AS poster_src,

    (
      SELECT pm.project_media_alt
      FROM tbl_projects_media pm
      WHERE pm.project_id = p.project_id
        AND pm.project_media_type = 'poster'
        AND pm.is_active = 1
      ORDER BY pm.project_media_order ASC
      LIMIT 1
    ) AS poster_alt

  FROM tbl_projects p
  WHERE p.is_active = 1
  ORDER BY p.project_order ASC, p.project_id ASC
");

$stmt_projects->execute();

/* I store all projects into an array so I can loop them in the HTML section */
$projects = $stmt_projects->fetchAll(PDO::FETCH_ASSOC);
$stmt_projects = null;

/* This function turns "A | B | C" into separate span tags */
function buildTags($subtitle) {
  $tags = explode('|', $subtitle);
  $output = '';

  foreach ($tags as $tag) {
    $clean = trim($tag);
    if ($clean != '') {
      $output .= '<span>'.$clean.'</span>';
    }
  }

  return $output;
}
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Works - Nguyen Linh Portfolio</title>

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

<body data-page="works">
  <!-- HEADER -->
  <header id="header" class="grid-con">
    <h1 class="hidden"> Nguyen Linh Portfolio - Works Page </h1>
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
        <li><a href="works.php" class="active">Works</a></li>
        <li><a href="about.php">About</a></li>
        <li class="mobile-connect"><a href="contact.php">Contact</a></li>
      </ul>
    </nav>

    <div class="header-connect m-col-start-12 m-col-end-13 l-col-start-12 l-col-end-13">
      <a href="contact.php" class="btn-connect">Contact</a>
    </div>
  </header>

  <main>
    <!-- HERO -->
    <section id="works-hero" class="grid-con">

      <!-- FLOATING SHAPES (NEW) -->
      <div class="float blue"></div>
      <div class="float pink"></div>
      <div class="float orange"></div>
      <div class="float yellow"></div>
      
      <div class="hero-content col-span-full m-col-span-full l-col-span-full">
        <h2><span class="accent">Creative Playground</span><br>Where Ideas Come Alive</h2>

        <p>A curated collection of Branding, Motion, 3D, and Web projects - blending imagination and craft to bring ideas vividly to life.</p>

        <div class="filter-bar">
          <button class="filter-btn active" data-filter="all">All</button>
          <button class="filter-btn" data-filter="branding">Branding</button>
          <button class="filter-btn" data-filter="motion">Motion</button>
          <button class="filter-btn" data-filter="web">Web Development</button>
          <button class="filter-btn" data-filter="3d">3D</button>
      </div>
      </div>
    </section>


<!-- FEATURED WORKS -->
<section id="featured-works" class="grid-con" aria-labelledby="featured-heading">

  <?php foreach ($projects as $project): ?>

    <a href="case_study.php?id=<?php echo $project['project_id']; ?>"
       class="work-card col-span-full m-col-span-6 l-col-span-6"
       data-color="<?php echo $project['project_color']; ?>">

      <span class="work-arrow" aria-hidden="true">
        <i class="fa-solid fa-arrow-right-long"></i>
      </span>

      <article>
        <h3 class="hidden"><?php echo $project['project_title']; ?> Project</h3>

        <img src="images/<?php echo $project['poster_src']; ?>"
             alt="<?php echo $project['poster_alt']; ?>">

        <div class="work-info">
          <h4><?php echo $project['project_title']; ?></h4>
          <p><?php echo $project['project_brief']; ?></p>

          <div class="work-tags">
            <?php echo buildTags($project['project_subtitle']); ?>
          </div>
        </div>
      </article>

    </a>

  <?php endforeach; ?>

</section>
    
  </main>


  <!-- FOOTER -->
  <footer id="footer" class="grid-con">
    <div class="footer-top col-span-full">
      <nav class="footer-nav">
        <h2 class="hidden">Footer Navigation</h2>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="works.php" class="active">Works</a></li>
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
      <a href="contact.php" class="btn-connect">Contact</a>
    </section>

    <div class="footer-bottom col-span-full">
      <p class="credit-left">Design and Developed by Linh Nguyen</p>
      <p class="credit-right">© 2026 All Rights Reserved</p>
    </div>
  </footer>
  
</body>
</html>