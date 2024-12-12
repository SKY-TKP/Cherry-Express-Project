<?php
require_once("./connection.php");

$query = "SELECT * FROM store_table;";
$stmt = $pdo->query($query);
$stores = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($stores);

