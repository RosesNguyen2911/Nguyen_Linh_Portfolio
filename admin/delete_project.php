<?php
session_start();
require_once('../includes/connect.php');

/*
  DELETE PROJECT SCRIPT
  I get the project id from the URL and validate it first.
  If the id is invalid, I stop and return to the admin list.

  I permanently delete the project row from tbl_projects.
  If my database has FOREIGN KEY + ON DELETE CASCADE for tbl_projects_media,
  the related media rows will be removed automatically.

  I redirect back to the projects section so the page doesn’t jump to the top.
*/

$projectId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($projectId <= 0) {
  header('Location: project_list.php#featured-works');
  exit;
}

$query = 'DELETE FROM tbl_projects WHERE project_id = :projectId';
$stmt = $connect->prepare($query);
$stmt->bindParam(':projectId', $projectId, PDO::PARAM_INT);
$stmt->execute();
$stmt = null;

header('Location: project_list.php#featured-works');
exit;
?>