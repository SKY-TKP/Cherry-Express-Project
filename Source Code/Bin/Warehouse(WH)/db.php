<?php
$host = 'localhost'; // Change to your database host
$user = 'd67g9'; // Change to your database username
$password = 'd67g9'; // Change to your database password
$database = 'd67g9'; // Change to your database name

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
