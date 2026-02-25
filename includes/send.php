<?php
header("Content-Type: application/json; charset=UTF-8");

require_once(__DIR__ . "/connect.php"); // I use __DIR__ to prevent incorrect relative path loading

// I only accept POST requests so this script cannot be accessed directly
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit;
}

$name_raw = $_POST["name"] ?? "";
$email_raw = $_POST["email"] ?? "";
$message_raw = $_POST["message"] ?? "";

// I trim and strip tags to prevent unwanted HTML input
$name = trim(strip_tags($name_raw));
$message = trim(strip_tags($message_raw));

// I remove line breaks to prevent header injection
$email_clean = str_replace(["\r", "\n", "%0a", "%0d"], "", trim($email_raw));

// I validate the email format before inserting it into the database
$email = filter_var($email_clean, FILTER_VALIDATE_EMAIL);

$errors = [];

if ($name === "") {
    $errors[] = "Please enter your full name.";
}

if (!$email) {
    $errors[] = "Please enter a valid email address.";
}

if ($message === "") {
    $errors[] = "Please write your message.";
}

if (!empty($errors)) {
    echo json_encode(["errors" => $errors]);
    exit;
}

try {
    $query = "INSERT INTO tbl_contacts 
              (contact_name, contact_email, contact_message)
              VALUES (?, ?, ?)";

    $stmt = $connect->prepare($query);

    $stmt->bindParam(1, $name, PDO::PARAM_STR);
    $stmt->bindParam(2, $email, PDO::PARAM_STR);
    $stmt->bindParam(3, $message, PDO::PARAM_STR);

    $stmt->execute();

    echo json_encode([
        "message" => "Thank you! Your message has been sent successfully."
    ]);
    exit;

} catch (PDOException $e) {
    // I log the real database error internally but return a generic message to the user
    error_log($e->getMessage());
    echo json_encode([
        "errors" => ["Sorry, something went wrong. Please try again later."]
    ]);
    exit;
}