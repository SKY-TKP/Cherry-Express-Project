<?php

session_start();
require("connection.php");


$user_id=$_POST['email'];
$user_password=$_POST['password'];

$query="SELECT * FROM login_table  WHERE CustomerEmail='$user_id' AND CustomerPassword='$user_password'";
//SQL is string need "" and ''
//echo $query;

$result=mysqli_query($db,$query);

if($list=mysqli_fetch_array($result))
{
//    $_SESSION['staff_id']=$list['staff_id'];
//    $_SESSION['staff_name']=$list['staff_name'];
	
	//if(user_type=="customer")
   //header("refresh: 0; url=customer_mainpage.php");
    //if(user_type=="staff")
   
    echo("success");
	//if(user_type=="admin")
   //header("refresh: 0; url=admin_mainpage.php");
}

else
{
	echo("fail");;
}


?>
