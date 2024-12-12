<?php
require_once("./connection.php");

unset($_SESSION["cart"]);
header("Location:../cart.html");

?>