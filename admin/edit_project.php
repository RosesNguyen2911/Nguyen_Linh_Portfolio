<?php
session_start();

/* Protect admin access */
if (!isset($_SESSION['user_id'])) {
  header('Location: login_form.php');
  exit;
}

require_once('../includes/connect.php');

/*
  EDIT PROJECT SCRIPT
  I update all text fields in tbl_projects first (this is the “main” data).
  Then I process uploaded media (if any) and store them in tbl_projects_media.

  I treat some media types as “single slot”:
  - poster, hero, video_thumbnail, video_webm, video_mp4
  For these, I deactivate old rows (is_active = 0) and insert the new file as the active one.

  I treat detail images as “multiple”:
  - detail
  For these, I do not replace old ones. I append new rows and increase project_media_order so the gallery keeps the correct sequence.
*/

$project_id = isset($_POST['project_id']) ? (int)$_POST['project_id'] : 0;
/* I stop early if the id is invalid, because updating without a valid project_id would be unsafe. */
if ($project_id <= 0) {
  header('Location: project_list.php');
  exit;
}

/* Basic fields
I trim inputs to avoid saving accidental spaces and to keep the database clean. */
$title = trim($_POST['project_title'] ?? '');
$subtitle = trim($_POST['project_subtitle'] ?? '');
$color = trim($_POST['project_color'] ?? '');

$brief = trim($_POST['project_brief'] ?? '');
$desc = trim($_POST['project_desc'] ?? '');
$link = trim($_POST['project_link'] ?? '');

$role = trim($_POST['project_role'] ?? '');
$deliverables = trim($_POST['project_deliverables'] ?? '');
$goals = trim($_POST['project_goals'] ?? '');
$challenges = trim($_POST['project_challenges'] ?? '');
$learnings = trim($_POST['project_learnings'] ?? '');
$results = trim($_POST['project_results'] ?? '');

$order = isset($_POST['project_order']) ? (int)$_POST['project_order'] : 1;
$is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;
/* I force is_active to be either 0 or 1 so it stays consistent in the database. */
$is_active = ($is_active === 0) ? 0 : 1;

/* Update project text
I update tbl_projects first so the content changes are saved even if no files are uploaded. */
$queryUpdate = "
  UPDATE tbl_projects
  SET
    project_title = ?,
    project_color = ?,
    project_brief = ?,
    project_subtitle = ?,
    project_desc = ?,
    project_link = ?,
    project_role = ?,
    project_deliverables = ?,
    project_goals = ?,
    project_challenges = ?,
    project_learnings = ?,
    project_results = ?,
    project_order = ?,
    is_active = ?
  WHERE project_id = ?
  LIMIT 1
";

$stmt = $connect->prepare($queryUpdate);
$stmt->execute([
  $title,
  $color,
  $brief,
  $subtitle,
  $desc,
  /* I store NULL when link is empty, because NULL is cleaner than an empty string for optional fields. */
  ($link === '' ? null : $link),
  $role,
  $deliverables,
  $goals,
  $challenges,
  $learnings,
  $results,
  $order,
  $is_active,
  $project_id
]);
$stmt = null;

/* HELPERS
I use small helper functions so the upload logic stays consistent and I do not repeat the same code many times. */
function ext_normalize($ext) {
  /* I normalize extensions (jpeg -> jpg) so my allowed list stays simple and predictable. */
  $ext = strtolower($ext);
  if ($ext === 'jpeg') return 'jpg';
  return $ext;
}

function save_upload($fileArr, $targetDir, $prefix, $allowedExts) {
  /* I only continue when the upload is valid and finished without PHP upload errors. */
  if (!isset($fileArr) || !isset($fileArr['error']) || $fileArr['error'] !== UPLOAD_ERR_OK) {
    return '';
  }

  /* I validate the extension to reduce risk and keep file types consistent. */
  $ext = ext_normalize(pathinfo($fileArr['name'], PATHINFO_EXTENSION));
  if (!in_array($ext, $allowedExts)) {
    return '';
  }

  /* I generate a new safe filename to avoid unsafe characters and name collisions. */
  $random = rand(10000, 99999);
  $filename = $prefix . '_' . $random . '.' . $ext;
  $targetPath = rtrim($targetDir, '/') . '/' . $filename;

  /* I move the temp file into the real folder; if this fails, I return empty so the caller can skip DB insert. */
  if (move_uploaded_file($fileArr['tmp_name'], $targetPath)) {
    return $filename;
  }

  return '';
}

function deactivate_media_type($connect, $project_id, $type) {
  /* I “soft replace” old media by turning off is_active, so I keep history and avoid breaking references. */
  $stmt = $connect->prepare("
    UPDATE tbl_projects_media
    SET is_active = 0
    WHERE project_id = ?
      AND project_media_type = ?
  ");
  $stmt->execute([$project_id, $type]);
  $stmt = null;
}

function insert_media($connect, $project_id, $type, $src, $alt, $order) {
  /* I insert one media row with is_active = 1 so the front-end can fetch the current media easily. */
  $stmt = $connect->prepare("
    INSERT INTO tbl_projects_media
      (project_id, project_media_type, project_media_src, project_media_alt, project_media_order, is_active)
    VALUES
      (?, ?, ?, ?, ?, 1)
  ");
  $stmt->execute([$project_id, $type, $src, $alt, $order]);
  $stmt = null;
}

/* File rules
I separate image and video extensions so each upload input is validated correctly. */
$imageExts = ['jpg', 'png', 'gif', 'webp'];
$videoExts = ['webm', 'mp4'];

/* Poster (replace)
I replace poster by deactivating old poster rows, then inserting the new one as order 1. */
$poster_name = save_upload($_FILES['poster_file'] ?? null, '../images', 'poster', $imageExts);
if ($poster_name !== '') {
  deactivate_media_type($connect, $project_id, 'poster');
  insert_media($connect, $project_id, 'poster', $poster_name, $title . ' Poster', 1);
}

/* Hero (replace)
Same logic as poster: single active hero image per project. */
$hero_name = save_upload($_FILES['hero_file'] ?? null, '../images', 'hero', $imageExts);
if ($hero_name !== '') {
  deactivate_media_type($connect, $project_id, 'hero');
  insert_media($connect, $project_id, 'hero', $hero_name, $title . ' Hero Image', 1);
}

/* Detail images (append multiple)
This part is slightly tricky:
- detail_images is a “multiple files” input, so PHP gives arrays for name/tmp_name/error.
- I find the current max order, then add new images after it so the order stays correct. */
if (isset($_FILES['detail_images']) && isset($_FILES['detail_images']['name']) && is_array($_FILES['detail_images']['name'])) {

  $stmtMax = $connect->prepare("
    SELECT COALESCE(MAX(project_media_order), 0) AS max_order
    FROM tbl_projects_media
    WHERE project_id = ?
      AND project_media_type = 'detail'
      AND is_active = 1
  ");
  $stmtMax->execute([$project_id]);
  $maxOrder = (int)($stmtMax->fetch(PDO::FETCH_ASSOC)['max_order'] ?? 0);
  $stmtMax = null;

  $count = count($_FILES['detail_images']['name']);
  for ($i = 0; $i < $count; $i++) {
    if ($_FILES['detail_images']['error'][$i] !== UPLOAD_ERR_OK) continue;

    /* I rebuild one file array so I can reuse save_upload() for each image. */
    $oneFile = [
      'name' => $_FILES['detail_images']['name'][$i],
      'type' => $_FILES['detail_images']['type'][$i],
      'tmp_name' => $_FILES['detail_images']['tmp_name'][$i],
      'error' => $_FILES['detail_images']['error'][$i],
      'size' => $_FILES['detail_images']['size'][$i]
    ];

    $detail_name = save_upload($oneFile, '../images', 'detail', $imageExts);
    if ($detail_name !== '') {
      $maxOrder++;
      insert_media($connect, $project_id, 'detail', $detail_name, $title . ' Detail Image', $maxOrder);
    }
  }
}

/* Video thumbnail (replace)
Thumbnail is stored in images folder and behaves like a single slot. */
$thumb_name = save_upload($_FILES['video_thumbnail_file'] ?? null, '../images', 'video_thumb', $imageExts);
if ($thumb_name !== '') {
  deactivate_media_type($connect, $project_id, 'video_thumbnail');
  insert_media($connect, $project_id, 'video_thumbnail', $thumb_name, $title . ' Video Thumbnail', 1);
}

/* Video webm (replace)
Video files go into ../video and also behave like single slots. */
$webm_name = save_upload($_FILES['video_webm_file'] ?? null, '../video', 'video_webm', $videoExts);
if ($webm_name !== '') {
  deactivate_media_type($connect, $project_id, 'video_webm');
  insert_media($connect, $project_id, 'video_webm', $webm_name, $title . ' Video WebM', 1);
}

/* Video mp4 (replace) */
$mp4_name = save_upload($_FILES['video_mp4_file'] ?? null, '../video', 'video_mp4', $videoExts);
if ($mp4_name !== '') {
  deactivate_media_type($connect, $project_id, 'video_mp4');
  insert_media($connect, $project_id, 'video_mp4', $mp4_name, $title . ' Video MP4', 1);
}

/* Done
I redirect back to the exact edited card anchor so the admin stays at the same position after saving. */
$_SESSION['project_flash'] = 'Project updated successfully.';
header('Location: project_list.php#project-' . $project_id);
exit;
?>