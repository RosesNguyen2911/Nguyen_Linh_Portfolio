<?php
session_start();

/* LOGOUT PROCESS
   I clear the current session so the user is fully logged out.
   First, I reset the $_SESSION array.
   Then, I destroy the session to remove all stored login data.
   Finally, I redirect back to the homepage. */

$_SESSION = array();
session_destroy();

header('Location: ../index.php');
exit;