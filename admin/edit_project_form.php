<!DOCTYPE html>
<html lang="en">
<?php
session_start();

/* Protect admin access */
if (!isset($_SESSION['user_id'])) {
  header('Location: login_form.php');
  exit;
}

require_once('../includes/connect.php');

/* Get project id from URL */
$project_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($project_id <= 0) {
  header('Location: project_list.php');
  exit;
}

/* Project query */
$stmt_project = $connect->prepare("
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
    project_results,
    project_order,
    is_active
  FROM tbl_projects
  WHERE project_id = :id
  LIMIT 1
");
$stmt_project->execute([':id' => $project_id]);
$project = $stmt_project->fetch(PDO::FETCH_ASSOC);
$stmt_project = null;

if (!$project) {
  header('Location: project_list.php');
  exit;
}

/* Media query */
$stmt_media = $connect->prepare("
  SELECT project_media_type, project_media_src, project_media_alt, project_media_order
  FROM tbl_projects_media
  WHERE project_id = :id
    AND is_active = 1
  ORDER BY project_media_order ASC, project_media_id ASC
");
$stmt_media->execute([':id' => $project_id]);
$media_rows = $stmt_media->fetchAll(PDO::FETCH_ASSOC);
$stmt_media = null;

/* Sort media */
$poster_src = '';
$poster_alt = '';

$hero_src = '';
$hero_alt = '';

$details = [];

$video_thumb_src = '';
$video_thumb_alt = '';

$video_webm_src = '';
$video_webm_alt = '';

$video_mp4_src = '';
$video_mp4_alt = '';

foreach ($media_rows as $m) {
  if ($m['project_media_type'] === 'poster' && $poster_src === '') {
    $poster_src = $m['project_media_src'];
    $poster_alt = $m['project_media_alt'];
  }

  if ($m['project_media_type'] === 'hero' && $hero_src === '') {
    $hero_src = $m['project_media_src'];
    $hero_alt = $m['project_media_alt'];
  }

  if ($m['project_media_type'] === 'detail') {
    $details[] = $m;
  }

  if ($m['project_media_type'] === 'video_thumbnail' && $video_thumb_src === '') {
    $video_thumb_src = $m['project_media_src'];
    $video_thumb_alt = $m['project_media_alt'];
  }

  if ($m['project_media_type'] === 'video_webm' && $video_webm_src === '') {
    $video_webm_src = $m['project_media_src'];
    $video_webm_alt = $m['project_media_alt'];
  }

  if ($m['project_media_type'] === 'video_mp4' && $video_mp4_src === '') {
    $video_mp4_src = $m['project_media_src'];
    $video_mp4_alt = $m['project_media_alt'];
  }
}
?>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Project - Admin Login</title>

  <link rel="stylesheet" href="../css/grid.css">
  <link rel="stylesheet" href="../css/main.css">

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

  <link rel="icon" type="image/png" href="../L_Favicon/favicon-96x96.png" sizes="96x96">
  <link rel="icon" type="image/svg+xml" href="../L_Favicon/favicon.svg">
  <link rel="shortcut icon" href="../L_Favicon/favicon.ico">
  <link rel="apple-touch-icon" sizes="180x180" href="../L_Favicon/apple-touch-icon.png">
  <link rel="manifest" href="../L_Favicon/site.webmanifest">
</head>

<body data-page="admin-edit-project">

  <!-- HEADER (same style as your admin pages) -->
  <header id="header" class="grid-con">
    <h1 class="hidden">Edit Project - Admin Login</h1>

    <div class="header-logo col-span-2 m-col-span-3 l-col-span-2">
      <a href="../index.php" class="logo-wrapper">
        <img src="../images/L_Logo.svg" alt="Linh Nguyen Logo">
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
      <h2 class="hidden">Main Navigation</h2>
      <ul>
        <li><a href="../index.php">Home</a></li>
        <li><a href="project_list.php" class="active">Projects</a></li>
        <li>
          <a href="logout.php" class="admin-logout-link">
            <i class="fa-solid fa-arrow-right-to-bracket" aria-hidden="true"></i>
            <span>Logout</span>
          </a>
        </li>
        <li class="mobile-connect"><a href="../contact.php">Contact</a></li>
      </ul>
    </nav>

    <div class="header-connect m-col-start-12 m-col-end-13 l-col-start-12 l-col-end-13">
      <a href="../contact.php" class="btn-connect">Contact</a>
    </div>
  </header>

  <main>

    <!-- HERO -->
    <section id="works-hero" class="grid-con">
      <div class="hero-content col-span-full">
        <h2><span class="accent">Admin Panel</span><br>Edit Project</h2>
        <p>Update project content, media, and case study details.</p>
      </div>
    </section>

    <!-- EDIT FORM -->
    <section id="admin-add-project" class="grid-con" aria-label="Admin edit project form">
      <h3 class="admin-add-title col-span-full m-col-span-full l-col-span-full">Edit Project</h3>

      <div class="admin-add-project-box col-span-full m-col-span-full l-col-span-full">

        <?php if ($poster_src !== ''): ?>
          <img
            class="admin-project-poster"
            src="../images/<?php echo ($poster_src); ?>"
            alt="<?php echo ($poster_alt !== '' ? $poster_alt : $project['project_title']); ?>"
            style="max-width:260px;border-radius:12px;display:block;margin:0 auto 18px;"
          >
        <?php endif; ?>

        <form action="edit_project.php" method="post" enctype="multipart/form-data" class="admin-add-form">
          <input type="hidden" name="project_id" value="<?php echo (int)$project['project_id']; ?>">

          <!-- BASIC INFO -->
          <div class="admin-form-group">
            <label for="project_title">Project Title</label>
            <input
              type="text"
              id="project_title"
              name="project_title"
              required
              value="<?php echo ($project['project_title']); ?>"
            >
          </div>

          <div class="admin-form-group">
            <label for="project_subtitle">Project Subtitle</label>
            <input
              type="text"
              id="project_subtitle"
              name="project_subtitle"
              required
              value="<?php echo ($project['project_subtitle']); ?>"
            >
          </div>

          <div class="admin-form-group">
            <label for="project_color">Project Color</label>
            <input
              type="text"
              id="project_color"
              name="project_color"
              required
              value="<?php echo ($project['project_color']); ?>"
            >
          </div>

          <div class="admin-form-group">
            <label for="project_brief">Project Brief</label>
            <textarea id="project_brief" name="project_brief" rows="3"><?php echo ($project['project_brief']); ?></textarea>
          </div>

          <div class="admin-form-group">
            <label for="project_desc">Project Description</label>
            <textarea id="project_desc" name="project_desc" rows="6"><?php echo ($project['project_desc']); ?></textarea>
          </div>

          <div class="admin-form-group">
            <label for="project_link">Project Link</label>
            <input
              type="text"
              id="project_link"
              name="project_link"
              value="<?php echo ($project['project_link']); ?>"
            >
          </div>

          <!-- CASE STUDY -->
          <div class="admin-form-group">
            <label for="project_role">Role</label>
            <textarea id="project_role" name="project_role" rows="2"><?php echo ($project['project_role']); ?></textarea>
          </div>

          <div class="admin-form-group">
            <label for="project_deliverables">Deliverables</label>
            <textarea id="project_deliverables" name="project_deliverables" rows="3"><?php echo ($project['project_deliverables']); ?></textarea>
          </div>

          <div class="admin-form-group">
            <label for="project_goals">Goals</label>
            <textarea id="project_goals" name="project_goals" rows="3"><?php echo ($project['project_goals']); ?></textarea>
          </div>

          <div class="admin-form-group">
            <label for="project_challenges">Challenges</label>
            <textarea id="project_challenges" name="project_challenges" rows="3"><?php echo ($project['project_challenges']); ?></textarea>
          </div>

          <div class="admin-form-group">
            <label for="project_learnings">Learnings</label>
            <textarea id="project_learnings" name="project_learnings" rows="3"><?php echo ($project['project_learnings']); ?></textarea>
          </div>

          <div class="admin-form-group">
            <label for="project_results">Results</label>
            <textarea id="project_results" name="project_results" rows="3"><?php echo ($project['project_results']); ?></textarea>
          </div>

          <!-- MEDIA UPLOADS -->
          <div class="admin-form-group">
            <label for="poster_file">Replace Poster (optional)</label>
            <input type="file" id="poster_file" name="poster_file" accept="image/*">
          </div>

          <div class="admin-form-group">
            <label for="hero_file">Hero Image (optional)</label>
            <input type="file" id="hero_file" name="hero_file" accept="image/*">
          </div>

          <div class="admin-form-group">
            <label for="detail_images">Detail Images (optional, multiple)</label>
            <input type="file" id="detail_images" name="detail_images[]" accept="image/*" multiple>
          </div>

          <div class="admin-form-group">
            <label for="video_thumbnail_file">Video Thumbnail (optional)</label>
            <input type="file" id="video_thumbnail_file" name="video_thumbnail_file" accept="image/*">
          </div>

          <div class="admin-form-group">
            <label for="video_webm_file">Video WebM (optional)</label>
            <input type="file" id="video_webm_file" name="video_webm_file" accept="video/webm">
          </div>

          <div class="admin-form-group">
            <label for="video_mp4_file">Video MP4 (optional)</label>
            <input type="file" id="video_mp4_file" name="video_mp4_file" accept="video/mp4">
          </div>

          <!-- ORDER / ACTIVE -->
          <div class="admin-form-group">
            <label for="project_order">Project Order</label>
            <input
              type="number"
              id="project_order"
              name="project_order"
              value="<?php echo (int)$project['project_order']; ?>"
            >
          </div>

          <div class="admin-form-group">
            <label for="is_active">Visibility (1 = show, 0 = hide)</label>
            <input
              type="number"
              id="is_active"
              name="is_active"
              min="0"
              max="1"
              value="<?php echo (int)$project['is_active']; ?>"
            >
          </div>

          <button type="submit" class="admin-add-btn">Save Changes</button>
        </form>

      </div>
    </section>

  </main>

  <!-- FOOTER -->
  <footer id="footer-admin" class="grid-con">
    <div class="footer-bottom-admin col-span-full">
      <p class="credit-left">Design and Developed by Linh Nguyen</p>
      <p class="credit-right">© 2026 All Rights Reserved</p>
    </div>
  </footer>

</body>
</html>