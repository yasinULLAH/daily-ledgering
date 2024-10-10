<?php require_once('Connections/myconn.php'); 
session_start();
if(!isset($_SESSION["name"]) || !isset($_SESSION["pass"]))
{
	header("location:index.php?msg=Please Login First");
	die();
}
?>
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

mysql_select_db($database_myconn, $myconn);
$query_all = "select * from clients where result NOT like '%-%' AND result != 0 && result is not null order by id desc";
$all = mysql_query($query_all, $myconn) or die(mysql_error());
$row_all = mysql_fetch_assoc($all);
$totalRows_all = mysql_num_rows($all);
$t = mysql_query("select SUM(result) AS total from clients where result NOT like '%-%' AND result != 0");
$a = mysql_fetch_array($t);
$total = $a["total"];
include("info.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>yasin's roznamcha software</title>
<style>
#info {
    background-color: yellow;
    border-left: 1px solid;
    border-right: 1px solid;
    border-top: 1px solid;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    font-size: 17px;
    height: 21px;
    line-height: 19px;
    margin-left: 3%;
    margin-top: -2px;
    padding-left: 10px;
    padding-right: 12px;
    position: absolute;
}
#tt {
    background-color: yellow;
    border-bottom: 1px solid;
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 6px;
    border-left: 1px solid;
    border-right: 1px solid;
    margin-left: 686px;
    position: absolute;
    text-align: center;
    width: 261px;
}
#apDiv1 {
    color: #0000FF;
    cursor: pointer;
    height: 17px;
    left: 878px;
    padding-left: 4px;
    position: absolute;
    text-decoration: underline;
    top: 5px;
    width: 86px;
    z-index: 1;
}</style>
<script language="javascript">
        function printd() {
             var divElements = document.getElementById('print').innerHTML;
            var oldPage = document.body.innerHTML;
            document.body.innerHTML ="<html><head><title>yasin softwares</title> </head><body>"+divElements+"<br />Copyright Yasin khan</body></html>" ;
            window.print();
			//PrintUtils.printPreview(Printd);  uses for print preview
			history.go(-0);
		}
</script>
</head>
<body>
<div id="apDiv1" onclick="printd()">Print This</div>
<div id="print">
<div id="info"><?php echo $infoMe ?> &nbsp;<font color="red">Credit</font> Accounts</div>
<br />
<table width="916" style="margin-left:3%" height="46" border="1" cellspacing="0" id="all">
  <tr>
    <th>S:No</th>
    <th>Date</th>
    <th>Name</th>
    <th>Total Credits</th>
    <th>Total Debuts</th>
    <th>Total Amount</th>
  </tr>
  <?php do { ?>
    <tr align="center">
      <td><?php echo $row_all['conn_id']; ?></td>
      <td><?php echo $row_all['date']; ?></td>
      <td><?php echo $row_all['name']; ?></td>
      <td><?php echo $row_all['Credit']; ?></td>
      <td><?php echo $row_all['Debut']; ?></td>
      <td><?php echo $row_all['result']; ?></td>
    </tr>
    <?php } while ($row_all = mysql_fetch_assoc($all)); ?>
</table>
<div id="tt"><strong>Total : <?php echo $total ?></strong></div>
</div>
</body>
</html>
<?php
mysql_free_result($all);
?>
