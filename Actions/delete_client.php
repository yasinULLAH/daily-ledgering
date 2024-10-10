<?php 
include("../Connections/myconn.php");
$name = $_GET['name'];
//echo $name;
$id = $_GET['id'];
//echo $id;
if(!isset($name) || !isset($id))
{
	header("location:../delete_record.php?msg=select a record first");
}
if(!empty($name))
{
	$q =	mysql_query("select * from clients where name = '$name'") or die(mysql_error());
	$qa =	mysql_fetch_array($q);
	$idt = $qa['id'];
}
elseif(!empty($id))
{
	$q =	mysql_query("select * from clients where id = '$id'")or die(mysql_error());
	$qa =	mysql_fetch_array($q);
	$idt = $qa['id'];
}
if($idt<=0)
{
	header("location:../delete_record.php?msg=Record not found");
		
}
else
{
	$d = mysql_query("delete from detail where conn_id = '$idt'");
	$d1 = 	mysql_query("delete from clients where id = '$idt'");
}
if(!empty($_GET['pg']))
{
		header("location:../all_account.php?msg=Record Deleted Successfully");	
}
elseif($d or $d1)
{
	header("location:../delete_record.php?msg=Record Deleted Successfully");
}else{
	header("location:../delete_record.php?msg=A problem accured while deleting the record");	
}
?>