<?php require_once('../Connections/myconn.php'); ?>
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
$name = $_GET['name'];
$querya = mysql_query("SELECT * FROM clients WHERE name = '$name'");
$row = mysql_fetch_array($querya);
$id = $row['id'];
if ((isset($_GET['id'])) && ($_GET['id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM detail WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
  mysql_select_db($database_myconn, $myconn);
  $Result1 = mysql_query($deleteSQL, $myconn) or die(mysql_error());
  if(isset($_GET['pg']))
  {
	  $deleteGoTo = "../trans.php?msg=Record Successfully Deleted&&name=".$name."&&id=".$id;
  }
  elseif(isset($_GET['dg']))
  {
	  $deleteGoTo = "../client-detail.php?msg=Record Successfully Deleted&&name=".$name."&&id=".$id;
  }
  else
  {
  $deleteGoTo = "../date.php?msg=Record Successfully Deleted&&name=".$name."&&id=".$id;
  }
    $q = mysql_query("select sum(amount) as total_credit from detail where type = 'Credit' and name = '$name'");
  $ro = mysql_fetch_array($q);
  $total_credit = $ro["total_credit"];
  $q2 = mysql_query("select sum(amount) as total_debut from detail where type = 'Debut' and name = '$name'");
  $ro2 = mysql_fetch_array($q2);
  $total_debut = $ro2["total_debut"];
  $total = $total_credit-$total_debut;
  $result2 = mysql_query("update clients set Credit='$total_credit',Debut='$total_debut',result='$total' where name = '$name'");
  header("Location:".$deleteGoTo);
}
?>
