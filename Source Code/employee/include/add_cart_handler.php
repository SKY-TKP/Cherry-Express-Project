<?php
require_once("connection.php");
require_once("calculation.php");

$calculatedData = calculatePrice($_POST["DeliveryType"], $_POST["Weight"], $_POST["Width"], $_POST["Length"], $_POST["Height"]);
$_POST["Price"] = $calculatedData["TotalPrice"];
$_POST["BoxType"] = $calculatedData["BoxType"];

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}
array_push($_SESSION["cart"],$_POST);

header("Location: ../cart.html");