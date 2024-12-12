<?php
require_once("connection.php");
require_once("../../employee/include/calculation.php");

$calculatedData = calculatePrice($_POST["DeliveryType"], $_POST["Weight"], $_POST["Width"], $_POST["Length"], $_POST["Height"]);
$_POST["Price"] = $calculatedData["TotalPrice"];
$_POST["BoxType"] = $calculatedData["BoxSize"];

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}
array_push($_SESSION["cart"],$_POST);
if ($_POST["action"]=="Add to cart") {
    header("Location:../cart.html");
}
else {
    header("Location:./submit_cart_handler.php");
}
