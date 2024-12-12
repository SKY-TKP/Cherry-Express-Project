<?php
require_once("connection.php");

$query = "UPDATE order_table
SET PaymentType = ?, PaymentStatus =?
WHERE OrderID = ?;
";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['PaymentType'], 'Paid', $_GET['OrderID']]);

header("Location: ../pay_receipt.html");