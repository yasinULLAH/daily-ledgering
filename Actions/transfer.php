<?php 
ob_start();
require_once('../Connections/myconn.php'); ?>
<?php
	if(isset($_POST["from"]))
	{
		$name = $_POST['from'];
		$querya = mysql_query("SELECT * FROM clients WHERE name = '$name'");
		$row = mysql_fetch_array($querya);
		$id = $row["conn_id"];
		if($id<=0)
		{
			$id = $row["id"];
		}
			  $date = date("d/m/Y");
			  $type = 'Debut';
			  $amount = $_POST['amount'];
			  $from = $_POST["from"];
			  $info = "Tranfer To ".$_POST["to"];		
			  $insertSQL = mysql_query("INSERT INTO detail (date, name, type, amount, conn_id, info) VALUES ('$date', '$from', '$type', '$amount', '$id', '$info')")
			  or die(mysql_error());
			  $q = mysql_query("select sum(amount) as total_credit from detail where type = 'Credit' and name = '$name'");
			  $ro = mysql_fetch_array($q);
			  $total_credit = $ro["total_credit"];
			  $q2 = mysql_query("select sum(amount) as total_debut from detail where type = 'Debut' and name = '$name'");
			  $ro2 = mysql_fetch_array($q2);
			  $total_debut = $ro2["total_debut"];
			   if($total_debut=='-')
				  {
					$total = $total_credit+$total_debut;  
				  }
				  else
				  {
					$total = $total_credit-$total_debut;  
				  }
			  $result2 = mysql_query("update clients set Credit='$total_credit',Debut='$total_debut',result='$total' where name = '$name'") or die(mysql_error());
	}
	if(isset($_POST["to"]))
	{
		$name = $_POST['to'];
		$querya = mysql_query("SELECT * FROM clients WHERE name = '$name'");
		$row = mysql_fetch_array($querya);
		$id = $row["conn_id"];
		if($id<=0)
		{
			$id = $row["id"];
		}
		$type = 'Credit';
		$amount = $_POST['amount'];
		$from = $_POST["to"];
		$info2 = "Tranfer From ".$_POST["from"];		
  $insertSQL = mysql_query("INSERT INTO detail (date, name, type, amount, conn_id, info) VALUES ('$date', '$from', '$type', '$amount', '$id', '$info2')");
  $q = mysql_query("select sum(amount) as total_credit from detail where type = 'Credit' and name = '$name'");
  $ro = mysql_fetch_array($q);
  $total_credit = $ro["total_credit"];
  $q2 = mysql_query("select sum(amount) as total_debut from detail where type = 'Debut' and name = '$name'");
  $ro2 = mysql_fetch_array($q2);
  $total_debut = $ro2["total_debut"];
  if($total_debut=='-')
  {
	$total = $total_credit+$total_debut;  
  }
  else
  {
	$total = $total_credit-$total_debut;  
  }
  $result22 = mysql_query("update clients set Credit='$total_credit',Debut='$total_debut',result='$total' where name = '$name'") or die(mysql_error());
	}
  if($result22){
				  if(isset($_POST['rapid'])>0)
				  {
				  header("location:../trans.php?id=".$id."&&msg=SuccessFully Inserted Your Data And id is ".$id);
				  }
				  else
				  {
					   header("location:../trans.php?msg=SuccessFully Inserted Your Data");
				  }
	  	
			}
ob_flush();
?>
