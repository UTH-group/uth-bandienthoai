<?php
$host = 'localhost';
$db = 'webBanDt';
$user = 'root';
$pass = '';

$conn = mysqli_connect($host, $user, $pass, $db, 3306);
mysqli_set_charset($conn, 'utf8');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}