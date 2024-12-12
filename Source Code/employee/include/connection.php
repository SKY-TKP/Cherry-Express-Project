<?php

// $db = mysqli_connect("127.0.0.1","d67g9","d67g9");
// mysqli_select_db($db,"d67g9");
// mysqli_query($db,"SET NAMES 'utf8' COLLATE 'utf8_general_ci';");
session_start();

$host = "localhost";
$db_name = "d67g9";
$db_username = "d67g9";
$db_password = "d67g9";

try {
    $pdo = new PDO("mysql:host=$host; dbname=$db_name; charset=utf8", $db_username, $db_password);
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $error) {
    echo "Connection failed: " . $error -> getMessage();
}

?>