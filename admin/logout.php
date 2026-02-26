<?php
session_start();

/*
  LOGOUT PROCESS

  I completely clear the current session.
  First, I reset the $_SESSION array.
  Then, I destroy the session to remove all stored login data.
  Finally, I redirect the user back to the homepage.
*/

$_SESSION = array();
session_destroy();

header('Location: ../index.php');
exit;