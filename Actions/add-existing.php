<?php 
#ob_start();
require_once('../Connections/myconn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$name = $_POST['name'];
$querya = mysql_query("SELECT * FROM clients WHERE name = '$name'");
$row = mysql_fetch_array($querya);
$id = $row["conn_id"];
if($id<=0)
{
	$id = $row["id"];
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$date = date("d/m/Y");
	$d = $_POST["detail"];
  $insertSQL = sprintf("INSERT INTO detail (date, name, type, amount, conn_id, detail,info) VALUES ('$date', %s, %s, %s, '$id','$d','')",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['type'], "text"),
                       GetSQLValueString($_POST['amount'], "text"));
  mysql_select_db($database_myconn, $myconn);
  $Result1 = mysql_query($insertSQL, $myconn) or die(mysql_error());
  $q = mysql_query("select sum(amount) as total_credit from detail where type = 'Credit' and name = '$name'");
  $ro = mysql_fetch_array($q);
  $total_credit = $ro["total_credit"];
  $q2 = mysql_query("select sum(amount) as total_debut from detail where type = 'Debut' and name = '$name'");
  $ro2 = mysql_fetch_array($q2);
  $total_debut = $ro2["total_debut"];
  $total = $total_credit-$total_debut;
  $result2 = mysql_query("update clients set Credit='$total_credit',Debut='$total_debut',result='$total' where name = '$name'");
  if($result2){
				  if(isset($_POST['rapid'])>0)
				  {
				  header("location:../insert-record.php?s=s&&id=".$id."&&msg=SuccessFully Inserted Your Data And id is ".$id);
				  }
				  else
				  {
					   header("location:../insert-record.php?msg=SuccessFully Inserted Your Data And id is ".$id);
				  }
	  	
			}
}
#b_flush();
?>
