<?php
require_once("connection.php");
require_once("calculation.php");

$query = ("SELECT CustomerID FROM customer_table WHERE Email = ?");
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['Email']]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['customer']['CustomerID'] = $result['CustomerID'];

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

    sleep(1);
    //assign
    $query = "INSERT INTO parcel_status_history_table (ParcelID, Status, EmployeeID) VALUE (?,?,?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$parcel_id, "In Transit", $_SESSION['employee']['EmployeeID']]);

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
    $stmt->execute([$parcel['ReceiverPostCode']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $query = "UPDATE parcel_table 
    SET EmployeeID = ?
    WHERE ParcelID = ?;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$result['EmployeeID'], $parcel_id]);
}

unset($_SESSION["cart"]);
header("Location:../assign.html");