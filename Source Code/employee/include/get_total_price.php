<?php
require_once("connection.php");

$query = "SELECT SUM(Price) TotalPrice
FROM parcel_table
WHERE OrderID=?
GROUP BY OrderID;";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['OrderID']]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($result);
