<?php
require_once("connection.php");

$query = "SELECT *
    FROM parcel_status_history_table
    JOIN parcel_table
    ON parcel_status_history_table.ParcelID = parcel_table.ParcelID
    LEFT JOIN employee_table
    ON parcel_status_history_table.EmployeeID = employee_table.EmployeeID
    WHERE parcel_table.ParcelID = ?
    ORDER BY parcel_status_history_table.Timestamp;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET['TrackNumber']]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($result) {
        echo json_encode([$result[0]['ParcelID'] => $result]);
        exit();
}

$query = "SELECT *
    FROM parcel_status_history_table
    JOIN parcel_table
    ON parcel_status_history_table.ParcelID = parcel_table.ParcelID
    LEFT JOIN employee_table
    ON parcel_status_history_table.EmployeeID = employee_table.EmployeeID
    WHERE parcel_table.OrderID = ?
    ORDER BY parcel_status_history_table.Timestamp;";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['TrackNumber']]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($result) {
    $order = [];
    foreach ($result as $row) {
        $parcelID = $row['ParcelID'];
            if (!isset($order[$parcelID])) {
            $order[$parcelID] = [];
        }
        $order[$parcelID][] = $row;
    }
    echo json_encode($order);
    exit();
}

echo json_encode([]);
