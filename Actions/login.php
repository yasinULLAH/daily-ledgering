<?php 
include("../Connections/myconn.php");
$name = $_POST["name"];
$pass = $_POST["pass"];
$pass = md5($pass);
//echo $name."<br />".$pass;die();
$qa = mysql_query("select * from admin where name = '$name' AND pass = '$pass'")or die(mysql_error());
$num = mysql_num_rows($qa);
if($num<=0)
{
	header("location:../index.php?msg=Incorrect Login Information");
	die();
}
else
{
	session_start();
	$row = mysql_fetch_array($qa);
	$_SESSION["name"] = $row["name"];
	$_SESSION["pass"] = $row["pass"];
	header("location:../insert-record.php?msg=Succesfully loged In");
}
?>