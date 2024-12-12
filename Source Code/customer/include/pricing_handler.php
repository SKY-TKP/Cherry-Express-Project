<?php
require_once("connection.php");
require_once("../../employee/include/calculation.php");

$calculatedData = calculatePrice($_POST["DeliveryType"], $_POST["Weight"], $_POST["Width"], $_POST["Length"], $_POST["Height"]);
echo json_encode($calculatedData);
