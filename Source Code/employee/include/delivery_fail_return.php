<?php

require_once("./connection.php");

if ($_GET["action"]=="fail") {
    $query = "INSERT INTO parcel_status_history_table (ParcelID, Status, EmployeeID) VALUE (?,?,?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET['ParcelID'], "Failed", $_SESSION['employee']['EmployeeID']]);
}
elseif ($_GET["action"]=="return") {
    $query = "INSERT INTO parcel_status_history_table (ParcelID, Status, EmployeeID) VALUE (?,?,?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET['ParcelID'], "Returned", $_SESSION['employee']['EmployeeID']]);
}
