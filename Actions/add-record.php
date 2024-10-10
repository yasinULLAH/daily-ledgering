<?php
ob_start();
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
$name = $_POST["names"];
$c = mysql_query("select * from clients where name = '$name'");
$count = mysql_num_rows($c);
if($count>0){header("location:../insert-record.php?msg=This Account Already Exist");die();}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $date = date("d/m/Y");
  $insertSQL = sprintf("INSERT INTO clients (date, name) VALUES ('$date', %s)",
                       GetSQLValueString($_POST['names'], "text"));
 $dbs = mysql_select_db($database_myconn, $myconn);
  $Result1 = mysql_query($insertSQL, $myconn) or die(mysql_error());
	   $id = mysql_insert_id();
	  if($id<=0)
	  {
		  @$q = mysql_query("select max(id) as id from clients");
		  @$a = mysql_fetch_array($q);
		  $id = $a["id"];
	  }
  $Result = mysql_query("UPDATE clients set conn_id = '$id' where id = '$id'");
  if($Result){header("location:../insert-record.php?id=".$id."msg=SuccessFully Inserted Your Data And Id Is ".$id."");}
 }
 ob_flush();
?>
 
