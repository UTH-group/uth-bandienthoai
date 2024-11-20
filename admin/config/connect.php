<?php
$host = 'localhost';
$db = 'webBanDt';
$user = 'root';
$pass = '';

$conn = mysqli_connect($host, $user, $pass, $db, 4422);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}