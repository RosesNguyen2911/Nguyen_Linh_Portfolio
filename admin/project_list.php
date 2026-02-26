<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require_once('../includes/connect.php');

/* PROJECTS QUERY
I fetch all projects + their first active poster image. */
$stmt_projects = $connect->prepare("
  SELECT
    p.project_id,
    p.project_title,
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

$projects = $stmt_projects->fetchAll(PDO::FETCH_ASSOC);
$stmt_projects = null;

/* Old add values */
$old_add = [];
if (isset($_SESSION['old_add_project']) && is_array($_SESSION['old_add_project'])) {
  $old_add = $_SESSION['old_add_project'];
  unset($_SESSION['old_add_project']);
}

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - Project List</title>

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


  <!-- HEADER -->
  <header id="header" class="grid-con">
    <h1 class="hidden"> Admin Login - Project List </h1>

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
      <h2 class="hidden"> Main Navigation</h2>
      <ul>
        <li><a href="../index.php">Home</a></li>
        <li><a href="login_form.php" class="active">Login</a></li>
        <li><a href="logout.php">Logout</a></li>
        <li class="mobile-connect"><a href="../contact.php">Contact</a></li>
      </ul>
    </nav>

    <div class="header-connect m-col-start-12 m-col-end-13 l-col-start-12 l-col-end-13">
      <a href="../contact.php" class="btn-connect">Contact</a>
    </div>
  </header>

  <main>

    <!-- HERO SECTION -->
    <section id="works-hero" class="grid-con">
      <div class="hero-content col-span-full">
        <h2><span class="accent">Admin Panel</span><br>Project List</h2>
        <p>Administrative dashboard for managing and maintaining portfolio projects.</p>
      </div>
    </section>

<!-- ADD NEW PROJECT BOX -->
<section id="admin-add-project" class="grid-con" aria-label="Admin add project">
<h3 class="admin-add-title col-span-full m-col-span-full l-col-span-full">Add a New Project</h3>

  <div class="admin-add-project-box col-span-full m-col-span-full l-col-span-full">

    <form action="add_project.php" method="post" enctype="multipart/form-data" class="admin-add-form">

      <div class="admin-form-group">
        <label for="project_poster">Project Poster</label>
        <input type="file" id="project_poster" name="project_poster" accept="image/*" required>
      </div>

      <div class="admin-form-group">
        <label for="project_title">Project Title</label>
        <input
          type="text"
          id="project_title"
          name="project_title"
          placeholder="Project Title"
          required
          value="<?php echo ($old_add['project_title'] ?? ''); ?>"
        >
      </div>

      <div class="admin-form-group">
        <label for="project_subtitle">Project Subtitle</label>
        <input
          type="text"
          id="project_subtitle"
          name="project_subtitle"
          placeholder="Branding | Motion | Web Development"
          required
          value="<?php echo ($old_add['project_subtitle'] ?? ''); ?>"
        >
      </div>

      <div class="admin-form-group">
        <label for="project_desc">Project Description</label>
        <textarea
          id="project_desc"
          name="project_desc"
          rows="5"
          placeholder="Write a short project description..."
          required
        ><?php echo ($old_add['project_desc'] ?? ''); ?></textarea>
      </div>

      <div class="admin-form-group">
        <label for="project_color">Project Color</label>
        <input
          type="text"
          id="project_color"
          name="project_color"
          placeholder="blue / pink / yellow / orange"
          required
          value="<?php echo htmlspecialchars($old_add['project_color'] ?? ''); ?>"
        >
      </div>

      <button type="submit" class="admin-add-btn">Add Project</button>

    </form>

  </div>
</section>

<!-- EDIT PROJECTS BOX -->
<section id="featured-works" class="grid-con" aria-label="Admin projects list">
  <h3 id="featured-heading" class="col-span-full m-col-span-full l-col-span-full">
    Edit an Existing Project
  </h3>

  <?php foreach ($projects as $project): ?>
  <div 
    id="project-<?php echo (int)$project['project_id']; ?>" 
    class="work-card col-span-full m-col-span-6 l-col-span-6 admin-project-card"
    data-color="<?php echo ($project['project_color']); ?>">

    <article class="admin-card-inner">

      <!-- Poster image from DB -->
      <?php if (!empty($project['poster_src'])): ?>
        <img
          class="admin-project-poster"
          src="../images/<?php echo ($project['poster_src']); ?>"
          alt="<?php echo ($project['poster_alt'] ?? $project['project_title']); ?>"
        >
      <?php else: ?>
        <div class="admin-project-poster admin-project-poster--empty">
          <span>No poster</span>
        </div>
      <?php endif; ?>

      <div class="work-info">
        <h4><?php echo ($project['project_title']); ?></h4>

        <div class="admin-actions">

          <a class="admin-btn admin-btn-edit"
             href="edit_project_form.php?id=<?php echo (int)$project['project_id']; ?>">
            <i class="fa-solid fa-pen-to-square"></i>
            <span>Edit</span>
          </a>

          <!-- DELETE OPENS MODAL -->
          <a class="admin-btn admin-btn-delete"
             href="#delete-project-<?php echo (int)$project['project_id']; ?>">
            <i class="fa-solid fa-trash-can"></i>
            <span>Delete</span>
          </a>

        </div>
      </div>

    </article>
  </div>

  <!-- DELETE MODAL -->
  <div id="delete-project-<?php echo (int)$project['project_id']; ?>" class="admin-modal">

    <div class="admin-modal-overlay"></div>

    <div class="admin-modal-box">
      <h4>Delete Project?</h4>
      <p>
        This action cannot be undone.<br>
        Confirm deletion for: 
        <strong><?php echo ($project['project_title']); ?></strong>
      </p>

      <div class="admin-modal-actions">

        <!-- CANCEL RETURNS TO EXACT CARD -->
        <a href="#project-<?php echo (int)$project['project_id']; ?>" 
           class="admin-btn admin-btn-cancel">
          Cancel
        </a>

        <!-- CONFIRM DELETE -->
        <a href="delete_project.php?id=<?php echo (int)$project['project_id']; ?>&back=featured-works"
        class="admin-btn admin-btn-delete">
        <i class="fa-solid fa-trash-can"></i>
        Delete
        </a>

      </div>
    </div>

  </div>

<?php endforeach; ?>
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