<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CHANGE TO YOUR EMAIL
    $recipient = "nngklinh.2911@gmail.com";
    $subject = "New Portfolio Inquiry";

    // Raw input
    $name_raw = $_POST["name"] ?? "";
    $email_raw = $_POST["email"] ?? "";
    $msg_raw = $_POST["message"] ?? "";

    // Sanitize input
    $name = trim(strip_tags($name_raw));
    $message = trim(strip_tags($msg_raw));

    // Clean email to prevent header injection
    $email_clean = str_replace(
        ["\r", "\n", "%0a", "%0d"],
        "",
        trim($email_raw)
    );

    $email = filter_var($email_clean, FILTER_VALIDATE_EMAIL);

    // Validate
    $errors = [];

    if ($name === "") { 
        $errors[] = "name"; 
    }

    if (!$email) { 
        $errors[] = "email"; 
    }

    if ($message === "") { 
        $errors[] = "message"; 
    }

    // If errors → back to form
    if (!empty($errors)) {

        $query = http_build_query([
            "from" => "submit",           // FLAG FOR JS
            "errors" => implode(",", $errors),
            "name" => $name_raw,
            "email" => $email_raw,
            "message" => $msg_raw,
            "msg" => "Please fix the errors below."
        ]);

        header("Location: ../connect.php?$query#contact-form");
        exit;
    }

    // Build email
    $emailBody = "New Inquiry:\r\n\r\n";
    $emailBody .= "Name: {$name}\r\n";
    $emailBody .= "Email: {$email}\r\n";
    $emailBody .= "Message:\r\n{$message}\r\n";

    $headers = "From: Portfolio <no-reply@portfolio.com>\r\n";
    $headers .= "Reply-To: {$email}\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Attempt sending
    $sent = mail($recipient, $subject, $emailBody, $headers);

    if ($sent) {

        $successMsg = urlencode("Thank you! Your message has been sent successfully.");

        header("Location: ../connect.php?from=submit&msg=$successMsg#contact-form");
        exit;
    }

    // If email fails
    $failMsg = urlencode("Sorry, your message could not be sent.");
    header("Location: ../connect.php?from=submit&msg=$failMsg#contact-form");
    exit;
}

// Direct access to send.php
echo "These are not the droids you are looking for...";
exit;
?>
