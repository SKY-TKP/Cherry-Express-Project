<?php
require_once("connection.php");

$query = "SELECT *
FROM parcel_status_history_table JOIN 
	(SELECT ParcelID ,MAX(Timestamp) latest_timestamp
    FROM parcel_status_history_table
    GROUP BY ParcelID) latest_timestamp_table
ON parcel_status_history_table.ParcelID = latest_timestamp_table.ParcelID
AND parcel_status_history_table.Timestamp = latest_timestamp_table.latest_timestamp
JOIN parcel_table
ON parcel_table.ParcelID = parcel_status_history_table.ParcelID
JOIN order_table ON order_table.OrderID = parcel_table.OrderID JOIN customer_table ON customer_table.CustomerID = order_table.CustomerID
WHERE parcel_table.OrderID = ?
GROUP BY parcel_table.ParcelID;";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['TrackNumber']]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($result) {
    echo json_encode($result);
    exit();
}

echo json_encode([]);
