<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$db = 'webBanDt';  // Changed from webBanDt to handvie
$user = 'root';
$pass = '';

try {
    $conn = mysqli_connect($host, $user, $pass, $db, 3306);
    
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
    
    if (!mysqli_set_charset($conn, 'utf8')) {
        throw new Exception("Error setting charset: " . mysqli_error($conn));
    }
    
} catch (Exception $e) {
    error_log("Database connection error: " . $e->getMessage());
    http_response_code(500);
    die("Database connection error. Please try again later.");
}
?>