<?php

require_once("./connection.php");

$query = ("SELECT * FROM employee_table WHERE EmployeeID = ?;");
$stmt = $pdo->prepare($query);
$stmt->execute([$_POST['EmployeeID']]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result && $_POST['Password'] == $result["Password"]) {
    $_SESSION["employee"] = $result;
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