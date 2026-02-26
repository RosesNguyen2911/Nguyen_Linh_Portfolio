<?php
session_start();
require_once('../includes/connect.php');

/* LOGIN PROCESS
  I validate the login form on the server side.
  First, I check for empty fields.
  Then, I verify the username and password against tbl_users.
  If authentication fails, I store an error message in session
  and redirect back to login_form.php.*/

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

/* I store the entered username in session 
  so the user does not need to retype it after a redirect.*/
$_SESSION['old_username'] = $username;

// 1) Empty checks
if ($username === '' && $password === '') {
  $_SESSION['login_error'] = 'Please enter both username and password.';
  header('Location: login_form.php');
  exit;
}

if ($username === '') {
  $_SESSION['login_error'] = 'Please enter your Username.';
  header('Location: login_form.php');
  exit;
}

if ($password === '') {
  $_SESSION['login_error'] = 'Please enter your Password.';
  header('Location: login_form.php');
  exit;
}

/* 2) Database check
  I use a prepared statement to safely check
  whether the provided username and password
  match a record in tbl_users.
*/
$query = 'SELECT user_id, username FROM tbl_users WHERE username = ? AND password = ? LIMIT 1';
$stmt = $connect->prepare($query);
$stmt->bindParam(1, $username, PDO::PARAM_STR);
$stmt->bindParam(2, $password, PDO::PARAM_STR);
$stmt->execute();

if ($stmt->rowCount() === 1) {
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

/* If credentials are valid,
  I create session variables to keep the user logged in. */
  $_SESSION['username'] = $row['username'];
  $_SESSION['user_id'] = $row['user_id'];

  // Clear old username on success
  unset($_SESSION['old_username']);

  header('Location: project_list.php');
  exit;
}

/* 3) Invalid credentials
   If no matching record is found,
   I set an error message and redirect back to the login form. */
$_SESSION['login_error'] = 'Invalid credentials. Are you sure you have access to this page?';
header('Location: login_form.php');
exit;