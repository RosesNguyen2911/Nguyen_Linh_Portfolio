<!DOCTYPE html>
<html lang="en">
<?php
require_once('includes/connect.php');

/* (WORKS) PROJECTS QUERRY
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
  LIMIT 4
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

/* SERVICES QUERY
I get service title + color from tbl_services */
$stmt_services = $connect->prepare("
  SELECT service_title, service_color
  FROM tbl_services
  WHERE is_active = 1
  ORDER BY service_order ASC, service_id ASC
");
$stmt_services->execute();
$services = $stmt_services->fetchAll(PDO::FETCH_ASSOC);
$stmt_services = null;


/* TESTIMONIALS QUERY
I get name, role, message and color from tbl_testimonials */
$stmt_testimonials = $connect->prepare("
  SELECT testimonial_author_name, testimonial_author_role, testimonial_message, testimonial_color
  FROM tbl_testimonials
  WHERE is_active = 1
  ORDER BY testimonial_id ASC
");
$stmt_testimonials->execute();
$testimonials = $stmt_testimonials->fetchAll(PDO::FETCH_ASSOC);
$stmt_testimonials = null;
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - Nguyen Linh Portfolio</title>

  <link rel="stylesheet" href="css/grid.css">
  <link rel="stylesheet" href="css/main.css">
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

<link rel="icon" type="image/png" href="L_Favicon/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/svg+xml" href="L_Favicon/favicon.svg">
<link rel="shortcut icon" href="L_Favicon/favicon.ico">
<link rel="apple-touch-icon" sizes="180x180" href="L_Favicon/apple-touch-icon.png">
<link rel="manifest" href="L_Favicon/site.webmanifest">

 <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/TextPlugin.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
 <script type="module" src="js/main.js"></script>

</head>

<body data-page="home">


   <!-- HEADER -->
   <header id="header" class="grid-con">
    <h1 class="hidden"> Nguyen Linh Portfolio - Home Page </h1>
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
        <li><a href="index.php" class="active">Home</a></li>
        <li><a href="works.php">Works</a></li>
        <li><a href="about.php">About</a></li>
        <li class="mobile-connect"><a href="contact.php">Contact</a></li>
      </ul>
    </nav>

    <div class="header-connect m-col-start-12 m-col-end-13 l-col-start-12 l-col-end-13">
      <a href="contact.php" class="btn-connect">Contact</a>
    </div>
  </header>

  <!-- MAIN -->
  <main>
 <!-- HERO SECTION -->
 <section id="hero" class="grid-con">

  <h2 class="hero-tagline col-span-full">I'm Linh Nguyen</h2>
  <h3 class="hero-second-line col-span-full">An Interactive Designer & Developer</h3>

  <div class="hero-banner col-span-full">
    <div class="banner-bg">
      <p class="banner-title">PORTFOLIO</p>
      <img src="images/avatar.svg" alt="Linh Nguyen Avatar" class="hero-avatar">
      <div class="banner-label">
        <p id="type-role">Graphic Designer</p>
      </div>
    </div>
  </div>

  <div class="hero-status col-span-full">
    <a href="contact.php" class="status-btn" aria-label="Availability Status">
      <span class="dot"></span> Available For Work
    </a>
  </div>  
</section>


 <!-- ABOUT SECTION -->
 <section id="about" class="grid-con" aria-labelledby="about-heading">
  <div class="gradient-wave"></div>
  <h2 id="about-heading" class="hidden">About Linh Nguyen</h2>

  <figure class="about-avatar-wrapper col-span-full m-col-span-6 l-col-span-5">
    <img src="images/second_avatar.svg"
      alt="Linh Nguyen working on her laptop"
      class="about-avatar">
  </figure>

  <article class="about-text-wrapper col-span-full m-col-span-7 l-col-span-7">
    <h3 class="about-intro">Hi, I'm <span class="main-name">Linh Nguyen!</span></h3>
    <p>
      I’m an Interactive Designer & Developer creating thoughtful digital experiences through <strong> branding, motion,</strong> and <strong>web design & development.</strong>
      Originally from Vietnam and currently based in London, Ontario, I’m open to freelance opportunities and creative collaborations worldwide.
    </p>
    
    <a href="about.php" class="about-btn">More About Me!</a>
  </article>
</section>

  <!-- VIDEO SECTION -->
  <section id="video" class="about-video" aria-labelledby="video-heading">
    <h2 id="video-heading" class="hidden">Linh Nguyen's Demo Reel</h2>

    <figure class="video-wrapper">
      <video class="portfolio-video" poster="images/portfolio_banner.png"
        aria-label="Nguyen Linh 2025 Demo Reel Thumbnail">
        <source src="video/Nguyen_Linh_Demo_Reel.webm" type="video/webm">
        <source src="video/Nguyen_Linh_Demo_Reel.mp4" type="video/mp4">
        Your browser does not support the video tag.
      </video>

      <button class="btn-center-play" aria-label="Play or Pause Video">
        <i class="fa-solid fa-play"></i>
      </button>

        <div class="video-controls">
          <div class="left-controls">
            <button class="btn-playpause" aria-label="Play or Pause">
              <i class="fa-solid fa-play"></i>
            </button>
            <span class="time-display">0:00 / 0:00</span>
          </div>

          <div class="center-controls">
            <div class="progress-container">
              <div class="progress-bar"></div>
              <div class="progress-thumb"></div>
            </div>
          </div>

          <div class="right-controls">
            <div class="volume-container">
              <button class="volume-icon" aria-label="Mute or Unmute">
                <i class="fa-solid fa-volume-high"></i>
              </button>
              <div class="volume-track">
                <div class="volume-bar"></div>
                <div class="volume-thumb"></div>
              </div>
            </div>

            <div class="setting-wrapper">
              <button class="btn-setting" aria-label="Playback Speed">
                <i class="fa-solid fa-gear"></i>
              </button>
              <ul class="setting-menu hidden">
                <li data-speed="0.5">0.5×</li>
                <li data-speed="1">1×</li>
                <li data-speed="2">2×</li>
                <li data-speed="2.5">2.5×</li>
              </ul>
            </div>

            <button class="btn-airplay" aria-label="AirPlay">
              <i class="fa-solid fa-tv"></i>
            </button>

            <button class="btn-replay" aria-label="Replay Video">
              <i class="fa-solid fa-rotate-right"></i>
            </button>

            <button class="btn-fullscreen" aria-label="Fullscreen">
              <i class="fa-solid fa-expand"></i>
            </button>
          </div>
        </div>
      </figure>
      <div class="gradient-wave"></div>
    </section>
    

<!-- FEATURED WORKS -->
<section id="featured-works" class="grid-con" aria-labelledby="featured-heading">
  <h2 id="featured-heading" class="col-span-full m-col-span-full l-col-span-full">Featured Works</h2>

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

  <!-- Learn More Button -->
  <div class="work-button col-span-full">
    <a href="works.php" class="btn-learn">See All</a>
  </div>
</section>
    
      
       <!-- MY SERVICES SECTION -->
    <section id="services" class="grid-con" aria-labelledby="services-heading">
      <h2 id="services-heading" class="hidden">My Services</h2>

      <div class="ticker" data-duration="18">
        <div class="ticker-wrap">
          <div class="ticker-text">

            <?php
            /* I loop services and print spans like the old HTML */
            foreach ($services as $service) {
              echo '<span class="'.$service['service_color'].'">'.$service['service_title'].'</span>';
            }
            ?>

          </div>
        </div>
      </div>
    </section>


    <!-- TESTIMONIALS -->
    <section id="testimonials" class="testimonials-section col-span-full" aria-labelledby="testimonials-heading">
      <h2 id="testimonials-heading" class="hidden">Testimonials</h2>

      <div class="testimonials-wrapper">

        <?php
        foreach ($testimonials as $t) {
          echo '
            <article class="testimonial-card '.$t['testimonial_color'].'">
              <h3 class="hidden">Testimonial from '.$t['testimonial_author_name'].'</h3>
              <h4>'.$t['testimonial_author_name'].'</h4>
              <div class="line"></div>
              <p>'.$t['testimonial_message'].'</p>
              <span>'.$t['testimonial_author_role'].'</span>
            </article>
          ';
        }
        ?>

      </div>

      <div class="carousel-controls">
        <button class="btn-prev" aria-label="Previous slide">
          <i class="fas fa-chevron-left"></i>
        </button>

        <button class="btn-next" aria-label="Next slide">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>
    </section>


  </main>

  <!-- FOOTER -->
  <footer id="footer" class="grid-con">
    <div class="footer-top col-span-full">
      <nav class="footer-nav">
        <h2 class="hidden">Footer Navigation</h2>
        <ul>
          <li><a href="index.php" class="active">Home</a></li>
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
      <a href="contact.php" class="btn-connect">Contact</a>
    </section>

    <div class="footer-bottom col-span-full">
      <p class="credit-left">Design and Developed by Linh Nguyen </p>
      <p class="credit-right">© 2026 All Rights Reserved</p>
    </div>
  </footer>

  </body>
  </html>
  