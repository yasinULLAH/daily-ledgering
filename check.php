<?php
include("Connections/myconn.php");
$from = $_POST["from"];
$amount = $_POST["amount"];
$q = mysql_query("select result from clients where name = '$from'");
$r = mysql_fetch_array($q);
$total_f = $r["result"];
if($total_f=='-')
{
	$rem = $total_f+$amount;
}
else
{
	$rem = $total_f-$amount;
}
$to = $_POST["to"];
$q2 = mysql_query("select result from clients where name = '$to'");
$r2 = mysql_fetch_array($q2);
$total_t = $r2["result"];
$rem2 = $total_t+$amount;

echo "After Tranfer <font color='#FF0000'>".$from."</font> Account Balance Will Be <font color='#FF0000'>".$rem."</font> And <font color='#FF0000'>".$to."</font> Balance Will Be <font color='#FF0000'>".$rem2." </font>";
?>