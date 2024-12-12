<?php
session_start();
require("../Connection.php");

$customer_email = $_POST['email'];
$customer_password = $_POST['password'];

$query = "SELECT * FROM customers_table  WHERE Email='$customer_email' AND CustomerPassword='$customer_password'";

$result = mysqli_query($db,$query);

if($list = mysqli_fetch_array($result)){
    //    $_SESSION['staff_id']=$list['staff_id'];
    //    $_SESSION['staff_name']=$list['staff_name'];
    echo("success");
}
else{
	echo("fail");
}

?>
