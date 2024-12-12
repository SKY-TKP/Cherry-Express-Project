<?php

require_once("./connection.php");

$query = ("SELECT * FROM customer_table WHERE Email = ?;");
$stmt = $pdo->prepare($query);
$stmt->execute([$_POST['Email']]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result && password_verify($_POST['Password'], $result["Password"])) {
    $_SESSION["customer"] = $result;
    echo json_encode([
        "success" => true,
        "message" => ""
    ]);
}
else {
    echo json_encode([
        "success" => false,
        "message" => "Email or Password is invalid."
    ]);
}