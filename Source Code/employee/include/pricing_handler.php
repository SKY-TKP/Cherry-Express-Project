<?php
require_once("connection.php");
require_once("calculation.php");

if (isset($_POST["DeliveryType"])) {
    $calculatedData = calculatePrice($_POST["DeliveryType"], $_POST["Weight"], $_POST["Width"], $_POST["Length"], $_POST["Height"]);
    echo json_encode($calculatedData);
}
