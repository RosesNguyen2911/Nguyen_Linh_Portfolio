<!DOCTYPE html>
<html lang="en">

<?php
spl_autoload_register(function ($class) {
  $class = str_replace('Portfolio\\', '', $class);
  $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);

  $filepath = __DIR__ . '/includes/' . $class . '.php';
  $filepath = str_replace("/", DIRECTORY_SEPARATOR, $filepath);

  if (file_exists($filepath)) {
    require_once $filepath;
  }
});

use Portfolio\Database;

$db = new Database();

/* I get project id from URL */
$project_id = 0;
if (isset($_GET['id'])) {
  $project_id = (int)$_GET['id'];
}

/* If the project's id <=0 , go back to works */
if ($project_id <= 0) {
  header("Location: works.php");
  exit;
}

/* PROJECTS QUERY
I get all case study text from tbl_projects by id */
$project_rows = $db->query("
  SELECT
    project_id,
    project_title,
    project_color,
    project_brief,
    project_subtitle,
    project_desc,
    project_link,
    project_role,
    project_deliverables,
    project_goals,
    project_challenges,
    project_learnings,
    project_order,
    project_results
  FROM tbl_projects
  WHERE project_id = :id
    AND is_active = 1
  LIMIT 1
", [
  'id' => $project_id
]);

$project = $project_rows[0] ?? null;

/* If project not found, then just stay (or go back) to "Works" page  */
if (!$project) {
  header("Location: works.php");
  exit;
}

/* MEDIA QUERY
I get all media for this project from tbl_projects_media */
$media_rows = $db->query("
  SELECT project_media_type, project_media_src, project_media_alt, project_media_order
  FROM tbl_projects_media
  WHERE project_id = :id
    AND is_active = 1
  ORDER BY project_media_order ASC, project_media_id ASC
", [
  'id' => $project_id
]);

/* I sort media into simple variables */
$hero_src = '';
$hero_alt = '';

$details = array();

$video_thumb_src = '';
$video_thumb_alt = '';

$video_webm_src = '';
$video_webm_alt = '';

$video_mp4_src = '';
$video_mp4_alt = '';

foreach ($media_rows as $m) {
  if ($m['project_media_type'] == 'hero' && $hero_src == '') {
    $hero_src = $m['project_media_src'];
    $hero_alt = $m['project_media_alt'];
  }

  if ($m['project_media_type'] == 'detail') {
    $details[] = $m;
  }

  if ($m['project_media_type'] == 'video_thumbnail' && $video_thumb_src == '') {
    $video_thumb_src = $m['project_media_src'];
    $video_thumb_alt = $m['project_media_alt'];
  }

  if ($m['project_media_type'] == 'video_webm' && $video_webm_src == '') {
    $video_webm_src = $m['project_media_src'];
    $video_webm_alt = $m['project_media_alt'];
  }

  if ($m['project_media_type'] == 'video_mp4' && $video_mp4_src == '') {
    $video_mp4_src = $m['project_media_src'];
    $video_mp4_alt = $m['project_media_alt'];
  }
}

/* MORE PROJECTS QUERRY
I always show the next 3 projects after the current one (by project_order).
If I'm near the end and not enough projects, I "wrap" and take from the start. */

$currentOrder = (int)($project['project_order'] ?? 0);

/* 1) Get next projects (order -> current) */
$more_projects = $db->query("
  SELECT
    p.project_id,
    p.project_title,

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
    AND p.project_id != :id
    AND p.project_order > :curOrder
  ORDER BY p.project_order ASC, p.project_id ASC
  LIMIT 3
", [
  'id' => $project_id,
  'curOrder' => $currentOrder
]);

/* 2) If not enough, take remaining from the beginning (wrap) */
$need = 3 - count($more_projects);

if ($need > 0) {
  // NOTE: LIMIT cannot be bound in PDO reliably, so we keep {$need} in the SQL like before.
  $more_projects_2 = $db->query("
    SELECT
      p.project_id,
      p.project_title,

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
      AND p.project_id != :id
      AND p.project_order <= :curOrder
    ORDER BY p.project_order ASC, p.project_id ASC
    LIMIT {$need}
  ", [
    'id' => $project_id,
    'curOrder' => $currentOrder
  ]);

  $more_projects = array_merge($more_projects, $more_projects_2);
}

/* I turn "A | B | C" into spans like old HTML */
function buildSubtitleSpans($subtitle) {
  $tags = explode('|', $subtitle);
  $out = '';

  foreach ($tags as $t) {
    $clean = trim($t);
    if ($clean != '') {
      $out .= '<span>'.$clean.'</span>';
    }
  }

  return $out;
}

/* PAGE TITLE TEXT */
$page_title = $project['project_title'].' — Case Study';
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $page_title; ?></title>

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

  <!-- SCRIPT -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/TextPlugin.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
  <script type="module" src="js/main.js"></script>
</head>

<body data-page="casestudy">
  <!-- HEADER -->
  <header id="header" class="grid-con">
    <h1 class="hidden"> Nguyen Linh Portfolio - Case Study Page </h1>

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
    <section id="project-hero" class="grid-con">
      <div class="hero-wrapper col-span-full m-col-start-2 m-col-end-12 l-col-start-2 l-col-end-12">

        <h2 class="project-title">
          <span class="accent"><?php echo $project['project_title']; ?></span>
        </h2>

        <div class="project-subtitle">
          <?php echo buildSubtitleSpans($project['project_subtitle']); ?>
        </div>

      </div>
    </section>

    <!-- DESCRIPTION -->
    <section id="project-desc" class="grid-con">
      <h3 class="col-span-full m-col-start-2 m-col-end-5 l-col-start-2 l-col-end-5">DESCRIPTION</h3>

      <div class="desc-wrapper col-span-full m-col-start-5 m-col-end-12 l-col-start-5 l-col-end-12">
        <p>
          <?php
            echo nl2br($project['project_desc']);
          ?>
        </p>

        <?php if (!empty($project['project_link'])): ?>
          <a href="<?php echo $project['project_link']; ?>" target="_blank" class="visit-btn">
            <i class="fa-solid fa-globe"></i>
            Visit Website
          </a>
        <?php endif; ?>
      </div>
    </section>

    <!-- INFO GRID -->
    <section id="project-info" class="grid-con">
      <div class="info-box col-span-full m-col-start-2 m-col-end-12 l-col-start-2 l-col-end-12">

        <div class="info-item">
          <h3>ROLE</h3>
          <p><?php echo $project['project_role']; ?></p>
        </div>

        <div class="info-item">
          <h3>DELIVERABLES</h3>
          <p><?php echo nl2br($project['project_deliverables']); ?></p>
        </div>

      </div>

      <div class="info-image col-span-full m-col-start-2 m-col-end-12 l-col-start-2 l-col-end-12">
        <?php if ($hero_src != ''): ?>
          <img src="images/<?php echo $hero_src; ?>" alt="<?php echo $hero_alt; ?>">
        <?php endif; ?>
      </div>
    </section>

    <!-- GOALS -->
    <section id="project-goals" class="grid-con">
      <h3 class="section-title col-span-full m-col-start-2 m-col-end-5 l-col-start-2 l-col-end-5">GOALS</h3>

      <div class="list col-span-full m-col-start-5 m-col-end-12 l-col-start-5 l-col-end-12">
        <p><?php echo nl2br($project['project_goals']); ?></p>
      </div>
    </section>

    <!-- CHALLENGES -->
    <section id="project-challenges" class="grid-con">
      <h3 class="section-title col-span-full m-col-start-2 m-col-end-5 l-col-start-2 l-col-end-5">CHALLENGES</h3>

      <div class="list col-span-full m-col-start-5 m-col-end-12 l-col-start-5 l-col-end-12">
        <p><?php echo nl2br($project['project_challenges']); ?></p>
      </div>
    </section>

    <!-- DETAIL SHOTS -->
    <section id="details" class="grid-con">
      <h3 class="hidden">Detail Shots</h3>

      <div class="details-grid col-span-full m-col-start-2 m-col-end-12 l-col-start-2 l-col-end-12">
        <?php foreach ($details as $d): ?>
          <img src="images/<?php echo $d['project_media_src']; ?>" alt="<?php echo $d['project_media_alt']; ?>">
        <?php endforeach; ?>
      </div>
    </section>

    <!-- LEARNINGS -->
    <section id="project-learnings" class="grid-con">
      <h3 class="section-title col-span-full m-col-start-2 m-col-end-5 l-col-start-2 l-col-end-5">LEARNINGS</h3>

      <div class="list col-span-full m-col-start-5 m-col-end-12 l-col-start-5 l-col-end-12">
        <p><?php echo nl2br($project['project_learnings']); ?></p>
      </div>
    </section>

    <!-- FINAL RESULTS -->
    <section id="project-final" class="grid-con">
      <h3 class="section-title col-span-full m-col-start-2 m-col-end-5 l-col-start-2 l-col-end-5">RESULTS</h3>

      <div class="list col-span-full m-col-start-5 m-col-end-12 l-col-start-5 l-col-end-12">
        <p><?php echo nl2br($project['project_results']); ?></p>
      </div>
    </section>

    <!-- VIDEO SECTION -->
    <section id="video" class="project-video" aria-labelledby="video-heading">
      <h3 id="video-heading" class="hidden"><?php echo $project['project_title']; ?> Video Promo</h3>

      <figure class="video-wrapper">
        <video class="portfolio-video"
          <?php if ($video_thumb_src != ''): ?>
            poster="images/<?php echo $video_thumb_src; ?>"
          <?php endif; ?>
          aria-label="<?php echo ($video_thumb_alt != '' ? $video_thumb_alt : 'Project Video Thumbnail'); ?>">

          <?php if ($video_webm_src != ''): ?>
            <source src="video/<?php echo $video_webm_src; ?>" type="video/webm">
          <?php endif; ?>

          <?php if ($video_mp4_src != ''): ?>
            <source src="video/<?php echo $video_mp4_src; ?>" type="video/mp4">
          <?php endif; ?>

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
    </section>

    <!-- MORE PROJECTS SLIDER -->
    <section id="more-projects" class="grid-con">
      <h3 class="section-title col-span-full m-col-start-2 m-col-end-12 l-col-start-2 l-col-end-12">MORE PROJECTS</h3>
      <div class="divider col-span-full m-col-start-2 m-col-end-12 l-col-start-2 l-col-end-12"></div>

      <div class="slider-wrapper col-span-full m-col-span-full  l-col-start-3 l-col-end-11">
        <?php foreach ($more_projects as $mp): ?>
          <a href="case_study.php?id=<?php echo $mp['project_id']; ?>" class="slider-card">
            <?php if (!empty($mp['poster_src'])): ?>
              <img src="images/<?php echo $mp['poster_src']; ?>" alt="<?php echo $mp['poster_alt']; ?>">
            <?php endif; ?>
            <h4><?php echo $mp['project_title']; ?></h4>
          </a>
        <?php endforeach; ?>
      </div>
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