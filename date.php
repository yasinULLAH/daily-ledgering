<?php 
session_start();
if(!isset($_SESSION["name"]) || !isset($_SESSION["pass"]))
{
	header("location:index.php?msg=Please Login First");
	die();
}
?>
<?php require_once('Connections/myconn.php'); ?>
<?php
	if(isset($_GET['date']))
	{
		$date = $_GET["date"];
	}
	else
	{
	$date = date("d/m/Y");
	}
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

$colname_today = "-1";
if (isset($_GET['date'])) {
  $colname_today = $_GET['date'];
}
mysql_select_db($database_myconn, $myconn);
$query_today = sprintf("SELECT * FROM detail WHERE `date` = '$date' ORDER BY type,id desc", GetSQLValueString($colname_today, "text"));
$today = mysql_query($query_today, $myconn) or die(mysql_error());
$row_today = mysql_fetch_assoc($today);
$totalRows_today = mysql_num_rows($today);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$date = date("d/m/Y");
  $insertSQL = sprintf("INSERT INTO detail (date, name, type, amount) VALUES ('$date', %s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['type'], "text"),
                       GetSQLValueString($_POST['amount'], "text"));

  mysql_select_db($database_myconn, $myconn);
  $Result1 = mysql_query($insertSQL, $myconn) or die(mysql_error());
  if($Result1){header("location:index.php?msg=SuccessFully Inserted Your Data");}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Yasin Roznamcha's Softwate</title>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="js/jquery-ui.css">
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<script language="javascript">
$(function() {
$( "#date" ).datepicker();
});
</script>
<link href="style/print.css" rel="stylesheet" type="text/css" media="print" />
<?php include("content/top.php"); ?>
</head>
<body>
<table width="1054" height="579" cellspacing="0">
  <?php include("content/header.php") ?>
  <tr>
    <?php include("content/side.php") ?>
    <td width="854" height="434" valign="top" id="content">
    <?php 
	include("content/nav.php"); ?>
<?php if(isset($_GET["msg"]))
	{?>
	<div id="msg"><?php echo $_GET["msg"] ?></div>
	<?php } ?><br />
    <a href="date.php?date=<?php 
	echo date("d/m/Y") ?>">Totday's Detial</a> &nbsp;<a href="dates.php">Advance Dates</a><br />
    &nbsp;&nbsp;<form action="date.php" method="get" name="frm"><input name="date" type="text" id="date"/> &nbsp;&nbsp;<input type="submit" value="Find It" /></form>
    <br />
     <table width="939" cellspacing="0" border="1" bgcolor="#003399" style="margin-left:0.4%;">
       <tr bgcolor="#006699">
        <th>S:No</th>
        <th>Date</th>
        <th>Name</th>
        <th>Detail</th>
        <th>Type</th>
        <th>Amount</th>
        <th id="none">Manage</th>
       </tr>
      <?php 
	  do {
		  $type = $row_today["type"]; 
	  if($type=="Debut")
	  {
		  $bg = "red";
	  }
	  else
	  {
		  $bg = "yellow";
	  }
	  ?>
        <tr align="center" bgcolor="#999966">
          <td bgcolor="#999966"><a href="client-detail.php?id=<?php echo $row_today['conn_id']; ?>" style="color:#00F;"><?php echo $row_today['conn_id']; ?></a></td>
          <td><?php echo $row_today['date']; ?></td>
          <td><a href="client-detail.php?name=<?php echo $row_today['name']; ?>" style="color:#00F;"><?php echo $row_today['name']; ?></a></td>
          <td bgcolor="#999966"><?php echo $row_today['detail']; ?> <?php echo $row_today['info']; ?></td>
          <td bgcolor="<?php echo $bg ?>"><?php echo $row_today['type']; ?></td>
          <td><?php echo $row_today['amount']; ?></td>
          <td id="none"><?php if(!empty($row_today["name"])) { ?><a href="update.php?id=<?php echo $row_today['id'] ?>">Edit</a> / <a href="actions/delete.php?id=<?php echo $row_today['id'] ?>&&name=<?php echo $row_today['name'] ?>" onclick="return confirm('Are You Sure')">Delete</a><?php } ?></td>
        </tr>
        <?php } while ($row_today = mysql_fetch_assoc($today)); ?>
</table>
     <br />
     <div id="total-tb">
       <table width="529" height="124" border="1" bgcolor="#006699">
         <tr>
           <td height="52" colspan="3" align="center"><strong>Total For <font color="#FFFF00"><?php echo $_GET["date"] ?></font></strong></td>
          </tr>
         <tr bgcolor="#999966">
           <th>Total Credit</th>
           <th>Total Debut</th>
           <th>Total</th>
          </tr>
         <tr bgcolor="#999966">
         <?php 
		 $sel = @mysql_query("select SUM(amount) AS credit_total from detail where type = 'Credit' AND date = '$date'");
		 $row = @mysql_fetch_array($sel);
		 ?>
           <td>&nbsp;<?php
		   $cradit_total = $row["credit_total"];
		   echo $row["credit_total"] ?></td>
            <?php 
		 $sel2 = @mysql_query("select SUM(amount) AS deput_total from detail where type = 'Debut'  AND date = '$date'");
		 $row2 = @mysql_fetch_array($sel2);
		 ?>
           <td>&nbsp;
           <?php
		   $debut_total = $row2["deput_total"];
		   echo $row2["deput_total"] ?>
           </td>
           <td>&nbsp;
           <?php 
		   $grand = $cradit_total-$debut_total;
		   echo $grand;
		   ?>
           </td>
          </tr>
                  </table>
           <div id="ttw"><strong>Grand Total : </strong><?php 
		   $es = mysql_query("select SUM(result) as tt from clients");
		   $q = mysql_fetch_array($es);
		   echo $q["tt"];
		    ?>&nbsp;
          </div>
     </div>
<p>&nbsp;</p>
<br />
    <br /></td>
  </tr>
    <?php include("content/footer.php") ?>
</table>
</body>
</html>
<?php
@mysql_free_result($today);
?>
