<?php

use Portfolio\Database;

header("Content-Type: application/json; charset=UTF-8");

spl_autoload_register(function ($class) {
    $class = str_replace('Portfolio\\', '', $class);
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    $filepath = __DIR__ . '/' . $class . '.php';

    if (file_exists($filepath)) {
        require_once $filepath;
    }
});


$db = new Database();


// I safely collect form data
$name_raw = $_POST["name"] ?? "";
$email_raw = $_POST["email"] ?? "";
$message_raw = $_POST["message"] ?? "";


// I sanitize user input
$name = trim(strip_tags($name_raw));
$message = trim(strip_tags($message_raw));

$email_clean = str_replace(["\r", "\n", "%0a", "%0d"], "", trim($email_raw));
$email = filter_var($email_clean, FILTER_VALIDATE_EMAIL);


// I validate required fields
$errors = [];

if ($name === "") $errors[] = "Please enter your full name.";
if (!$email)      $errors[] = "Please enter a valid email address.";
if ($message === "") $errors[] = "Please write your message.";


if (!empty($errors)) {
    echo json_encode(["errors" => $errors]);
    exit;
}


try {

    // I insert the message into the database using prepared statements
    $query = "INSERT INTO tbl_contacts 
              (contact_name, contact_email, contact_message)
              VALUES (:name, :email, :message)";

    $db->query($query, [
        'name'    => $name,
        'email'   => $email,
        'message' => $message
    ]);

    echo json_encode([
        "message" => "Thank you! Your message has been sent successfully."
    ]);
    exit;

} catch (Throwable $e) {

    // I log the real error internally
    error_log($e->getMessage());

    echo json_encode([
        "errors" => ["Sorry, something went wrong. Please try again later."]
    ]);
    exit;
}