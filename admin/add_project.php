<?php
session_start();

/* Protect admin access */
if (!isset($_SESSION['user_id'])) {
  header('Location: login_form.php');
  exit;
}

   spl_autoload_register(function ($class) {
    $class = str_replace('Portfolio\\', '', $class);
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
  
    $filepath = __DIR__ . '/../includes/' . $class . '.php';
    $filepath = str_replace("/", DIRECTORY_SEPARATOR, $filepath);
  
    if (file_exists($filepath)) {
      require_once $filepath;
    }
  });
  
  use Portfolio\Database;
  
  $db = new Database();
  $pdo = $db->connect();


/*
  ADD PROJECT SCRIPT
  I create a new project entry.
  First, I validate all required inputs and the uploaded poster.
  Then I safely upload the image and insert the project into the database.
  At this stage, I only create a basic project card.
  The full case study content will be completed later in the Edit page.
*/

$title    = trim($_POST['project_title'] ?? '');
$subtitle = trim($_POST['project_subtitle'] ?? '');
$desc     = trim($_POST['project_desc'] ?? '');
$color    = trim($_POST['project_color'] ?? '');

/* I store old input values in session 
  so the user does not lose data if a redirect happens. */
$_SESSION['old_add_project'] = [
  'project_title'    => $title,
  'project_subtitle' => $subtitle,
  'project_desc'     => $desc,
  'project_color'    => $color
];

/* VALIDATION (SERVER SIDE CHECK)
   Even though the form uses HTML "required",
   I validate again on the server to prevent empty or unsafe submissions.
*/
if ($title === '' || $subtitle === '' || $desc === '' || $color === '') {
  header('Location: project_list.php#admin-add-project');
  exit;
}

/* I make sure a poster image is uploaded successfully 
  before continuing.*/
if (!isset($_FILES['project_poster']) || $_FILES['project_poster']['error'] !== UPLOAD_ERR_OK) {
  header('Location: project_list.php#admin-add-project');
  exit;
}

/* IMAGE UPLOAD
  I generate a unique filename to avoid naming conflicts.
  I also restrict allowed extensions to common image formats
  for consistency and basic security.*/

$random  = rand(10000, 99999);
$newname = 'poster_' . $random;

$filetype = strtolower(pathinfo($_FILES['project_poster']['name'], PATHINFO_EXTENSION));

/* I normalize jpeg to jpg so my extension list stays simple. */
if ($filetype === 'jpeg') {
  $filetype = 'jpg';
}

$allowed = ['jpg', 'png', 'gif', 'webp'];

if (!in_array($filetype, $allowed)) {
  header('Location: project_list.php#admin-add-project');
  exit;
}

$newname .= '.' . $filetype;
$target_file = '../images/' . $newname;

/* I move the uploaded file from temporary storage 
  into the images folder.*/
if (!move_uploaded_file($_FILES['project_poster']['tmp_name'], $target_file)) {
  header('Location: project_list.php#admin-add-project');
  exit;
}

/* DATABASE INSERT
  bl_projects contains many NOT NULL fields.
  For the Add Project step, I insert safe placeholder values
  for the case study sections.
  These fields will be properly updated later in edit_project.php.*/

/* I automatically calculate the next project_order
  so the new project appears at the end of the list. */
$stmtOrder = $pdo->prepare("SELECT COALESCE(MAX(project_order), 0) + 1 AS next_order FROM tbl_projects");
$stmtOrder->execute();
$nextOrder = (int)($stmtOrder->fetch(PDO::FETCH_ASSOC)['next_order'] ?? 1);
$stmtOrder = null;

/* Minimal placeholders for required fields */
$project_brief      = $desc; 
$project_desc       = $desc; 
$project_link       = null;  

$project_role         = '';
$project_deliverables = '';
$project_goals        = '';
$project_challenges   = '';
$project_learnings    = '';
$project_results      = '';

$queryProject = "
  INSERT INTO tbl_projects
  (
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
  )
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)
";

$stmt = $pdo->prepare($queryProject);
$stmt->execute([
  $title,
  $color,
  $project_brief,
  $subtitle,
  $project_desc,
  $project_link,
  $project_role,
  $project_deliverables,
  $project_goals,
  $project_challenges,
  $project_learnings,
  $project_results,
  $nextOrder
]);

$project_id = (int)$pdo->lastInsertId();
$stmt = null;

/*
  After inserting the project,
  I insert its poster into tbl_projects_media
  and link it using the generated project_id.
*/
$queryMedia = "
  INSERT INTO tbl_projects_media
  (project_id, project_media_type, project_media_src, project_media_alt, project_media_order, is_active)
  VALUES (?, 'poster', ?, ?, 1, 1)
";

$altText = $title . ' Poster';

$stmt2 = $pdo->prepare($queryMedia);
$stmt2->execute([$project_id, $newname, $altText]);
$stmt2 = null;

/* 
  On success, I clear old session data
  and redirect back to the project list,
  jumping directly to the newly created project card.
*/
unset($_SESSION['old_add_project']);

$_SESSION['project_flash'] = 'Project added successfully.';
header('Location: project_list.php#project-' . $project_id);
exit;