<?php
require_once("connection.php");

$query = "SELECT COUNT(*) ParcelCount, DATE(Timestamp) Date
FROM parcel_status_history_table
WHERE Status = 'Delivered'
GROUP BY {$_GET['period']}(Timestamp);";
$stmt = $pdo->query($query);
$total_parcel = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT ReceiverPostCode PostCode, PlaceName, State, COUNT(*)  ParcelCount
FROM parcel_table
JOIN destination_table ON parcel_table.ReceiverPostCode = destination_table.Postcode
GROUP BY ReceiverPostCode
ORDER BY ParcelCount DESC
LIMIT 3;";
$stmt = $pdo->query($query);
$top3_receiver = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT customer_table.PostCode, PlaceName, State, COUNT(*)  ParcelCount
FROM parcel_table
JOIN order_table ON parcel_table.OrderID = order_table.OrderID
JOIN customer_table ON order_table.CustomerID = customer_table.CustomerID
JOIN destination_table ON customer_table.PostCode = destination_table.Postcode
GROUP BY PostCode
ORDER BY ParcelCount DESC
LIMIT 3;";
$stmt = $pdo->query($query);
$top3_sender = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT BoxSize, COUNT(*)  ParcelCount
FROM parcel_table
JOIN box_type_table ON parcel_table.BoxType = box_type_table.BoxType
GROUP BY BoxSize
ORDER BY ParcelCount DESC
LIMIT 3;";
$stmt = $pdo->query($query);
$top3_box = $stmt->fetchAll(PDO::FETCH_ASSOC);


echo json_encode([
    "total_parcel" => $total_parcel,
    "top3_receiver" => $top3_receiver,
    "top3_sender" => $top3_sender,
    "top3_box" => $top3_box
]);