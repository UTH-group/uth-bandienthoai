<?php
$host = 'localhost';
$db = 'toydb';
$user = 'root';
$pass = '';

$conn = mysqli_connect($host, $user, $pass, $db, 3306);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}