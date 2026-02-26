<?php

$dsn = "mysql:host=localhost;dbname=linh_nguyen_portfolio;charset=utf8mb4";

/* PDO CONFIGURATION
 I’m configuring PDO to:
 - throw exceptions when errors occur,
 - return associative arrays by default,
 - and use real prepared statements for better security.
*/
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $connect = new PDO($dsn, 'root', 'root', $options);
} catch (PDOException $e) {
    error_log($e->getMessage());
    exit('Database connection failed.');
}