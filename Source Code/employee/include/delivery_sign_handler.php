<?php

require_once("./connection.php");

$query = "INSERT INTO parcel_status_history_table (ParcelID, Status, EmployeeID) VALUE (?,?,?)";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['ParcelID'], "Delivered", $_SESSION['employee']['EmployeeID']]);

$signatureData = $_GET['signature_data'];
$signatureData = str_replace('data:image/png;base64,', '', $signatureData);
$signatureData = str_replace(' ', '+', $signatureData);
$decodedImage = base64_decode($signatureData);
$outputDir = '../image/signature';
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0777, true);
}
$filePath = $outputDir . "/signature_" . htmlspecialchars($_GET['ParcelID']) . ".png";
file_put_contents($filePath, $decodedImage);

header("Location: ../delivery.html");