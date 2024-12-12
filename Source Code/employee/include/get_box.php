<?php
require_once("connection.php");

$query = "SELECT * FROM box_type_table";
$stmt = $pdo->query($query);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);
