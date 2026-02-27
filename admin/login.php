<?php
session_start();

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
   match a record in tbl_users. */
$query = 'SELECT user_id, username FROM tbl_users WHERE username = :username AND password = :password LIMIT 1';

$rows = $db->query($query, [
  'username' => $username,
  'password' => $password
]);

if (count($rows) === 1) {
  $row = $rows[0];

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