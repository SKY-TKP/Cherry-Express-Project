<?php
require_once("./connection.php");

$query = "SELECT * FROM customer_table WHERE Email = ?;";
$stmt = $pdo->prepare($query);
$stmt->execute([$_POST['Email']]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if ($result) {
    echo json_encode([
        "success" => false,
        "message" => "This email already exists."
    ]);
    exit();
}
if ($_POST["Password"] != $_POST["ConfirmPassword"]) {
    echo json_encode([
        "success" => false,
        "message" => "Passwords mismatch."
    ]);
    exit();
}

$query = (
    "SELECT *
    FROM information_schema.TABLES
    WHERE TABLE_SCHEMA = 'd67g9'
    AND TABLE_NAME = 'customer_table';"
);
$stmt = $pdo->query($query);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$_POST['id'] = $result['AUTO_INCREMENT'];
$_POST['Password'] = password_hash($_POST["Password"], PASSWORD_DEFAULT); 

$stmt = $pdo->query("SHOW COLUMNS FROM customer_table");
$headers = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $headers[] = $row['Field'];
}
$excluding_headers = ['CustomerID', 'JoinDateTime', 'PreferedPreferredContactMethod'];
foreach ($excluding_headers as $header) {
    unset($headers[$header]);
}
$columns = implode(", ", $headers); 
$placeholders = ":" . implode(", :", $headers);

$query = "INSERT INTO customer_table ($columns) VALUES ($placeholders);";
$stmt = $pdo->prepare($query);
foreach ($headers as $header) {
    $stmt->bindParam(":$header", $_POST[$header]);
}
$stmt->execute();

echo json_encode([
    "success" => true,
    "message" => ""
]);