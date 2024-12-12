<?php
require_once("connection.php");
require_once("../../employee/include/calculation.php");

$query = (
    "SELECT *
    FROM information_schema.TABLES
    WHERE TABLE_SCHEMA = 'd67g9'
    AND TABLE_NAME = 'order_table';"
);
$stmt = $pdo->query($query);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$id = $result['AUTO_INCREMENT'];

$query = "INSERT INTO order_table (id, CustomerID, PaymentStatus) VALUES (?, ?, ?);";
$stmt = $pdo->prepare($query);
$stmt->execute([$id, $_SESSION['customer']['CustomerID'], "Pending"]);

$query = (
    "SELECT *
    FROM order_table
    WHERE id = ?;"
);
$stmt = $pdo->prepare($query);
$stmt->execute([$id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$order_id = $result['OrderID'];

foreach ($_SESSION["cart"] as $parcel) {

    $query = (
        "SELECT *
        FROM information_schema.TABLES
        WHERE TABLE_SCHEMA = 'd67g9'
        AND TABLE_NAME = 'parcel_table';"
    );
    $stmt = $pdo->query($query);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $parcel['id'] = $result['AUTO_INCREMENT'];

    if ($parcel['DeliveryType']=='Registered') {
        $due_date = (new DateTime())->modify('+7 days');
    }
    elseif ($parcel['DeliveryType']=='Standard') {
        $due_date = (new DateTime())->modify('+5 days');
    }
    elseif ($parcel['DeliveryType']=='Express') {
        $due_date = (new DateTime())->modify('+3 days');
    }
    $parcel['DueDate'] = $due_date->format('Y-m-d');

    $parcel['OrderID'] = $order_id;
    
    $data = calculatePrice($parcel["DeliveryType"], $parcel["Weight"], $parcel["Length"], $parcel["Width"], $parcel["Height"]);
    $parcel['BoxType'] = $data['BoxType'];
    $parcel['Price'] = $data['TotalPrice'];

    $headers = ['id', 'OrderID', 'BoxType', 'Weight', 'ReceiverFirstName', 'ReceiverLastName', 'ReceiverAddressLine1', 'ReceiverAddressLine2', 'ReceiverPostCode', 'ReceiverContactNumber', 'DueDate', 'DeliveryType', 'Price'];
    $columns = implode(", ", $headers); 
    $placeholders = ":" . implode(", :", $headers);

    $query = "INSERT INTO parcel_table ($columns) VALUES ($placeholders);";
    $stmt = $pdo->prepare($query);
    foreach ($headers as $header) {
        $stmt->bindParam(":$header", $parcel[$header]);
    }
    $stmt->execute();

    $query = ("SELECT *
        FROM parcel_table
        WHERE id = ?;"
    );
    $stmt = $pdo->prepare($query);
    $stmt->execute([$parcel['id']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $parcel_id = $result['ParcelID'];    
    $query = "INSERT INTO parcel_status_history_table (ParcelID, Status) VALUES (?,?);";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$parcel_id, "Submitted"]);
}

unset($_SESSION["cart"]);
header("Location:../order.html");