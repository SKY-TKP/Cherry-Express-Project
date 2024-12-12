<?php
require_once("./connection.php");

$query = "SELECT * FROM customer_table WHERE Email = ? AND id != ?;";
$stmt = $pdo->prepare($query);
$stmt->execute([$_POST['Email'], $_SESSION['customer']['id']]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if ($customer) {
    echo json_encode(["success" => false,
    "message" => "This email already exists."]);
    exit();
}
// if ($_POST["Password"] != $_POST["ConfirmPassword"]) {
//     echo json_encode(["success" => false,
//     "message" => "Passwords mismatch."]);
//     exit();
// }

$statement = $pdo->query("SHOW COLUMNS FROM customer_table");
$headers = [];
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $headers[] = $row['Field'];
}

$excluding_headers = ['id', 'CustomerID', 'JoinDateTime', 'PreferredContactMethod', 'Password'];
$headers = array_diff($headers, $excluding_headers);

$clause = implode(", ", array_map(function($col) {
    return "$col = :$col";
}, $headers));
$query = "UPDATE customer_table SET $clause WHERE id = :id";
$statement = $pdo->prepare($query);

foreach ($headers as $header) {
    $statement->bindParam(":$header", $_POST[$header]);
}
// $statement->bindParam(":Password", password_hash($_POST["Password"], PASSWORD_DEFAULT));
$statement->bindParam(":id", $_SESSION['customer']['id']);
$statement->execute();

$query = ("SELECT * FROM customer_table WHERE id = ?;");
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['customer']['id']]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION["customer"] = $result;

echo json_encode(["success" => true,
"message" => ""]);
