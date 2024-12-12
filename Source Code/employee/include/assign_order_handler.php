<?php

require_once("./connection.php");
require_once("calculation.php");


$_GET['Price'] = calculatePriceByBox($_GET['DeliveryType'],$_GET['Weight'],$_GET['BoxType'])['TotalPrice'];

$headers = array_keys($_GET);
$clause = implode(", ", array_map(function($col) {
    return "$col = :$col";
}, $headers));
$query = "UPDATE parcel_table SET $clause WHERE ParcelID = :ParcelID";
$stmt = $pdo->prepare($query);
foreach ($headers as $header) {
    $stmt->bindParam(":$header", $_GET[$header]);
}
$stmt->execute();

$query = "INSERT INTO parcel_status_history_table (ParcelID, Status, EmployeeID) VALUE (?,?,?)";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['ParcelID'], "In Transit", $_SESSION['employee']['EmployeeID']]);

$query = "SELECT employee_table.EmployeeID, COUNT(parcel_table.ParcelID) AS ParcelCount
FROM employee_table
LEFT JOIN parcel_table
ON employee_table.EmployeeID = parcel_table.EmployeeID
WHERE employee_table.WarehouseID = (
    SELECT WarehouseID
    FROM warehouse_table
    WHERE OperationalStatus = 'Operational'
    ORDER BY ABS(Postcode - ?) ASC
    LIMIT 1)
    AND employee_table.Role = 'Driver'
GROUP BY employee_table.EmployeeID
ORDER BY ParcelCount ASC;";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['ReceiverPostCode']]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$query = "UPDATE parcel_table 
SET EmployeeID = ?
WHERE ParcelID = ?;";
$stmt = $pdo->prepare($query);
$stmt->execute([$result['EmployeeID'], $_GET['ParcelID']]);
