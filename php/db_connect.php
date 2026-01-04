<?php
// Database connection for Support Apps BKPSDM
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db = 'sapps';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>