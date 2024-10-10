<?php 
session_start();
if(!isset($_SESSION["name"]) || !isset($_SESSION["pass"]))
{
	header("location:index.php?msg=Please Login First");
	die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Yasin Roznamcha's Softwate</title>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<link href="style/print.css" rel="stylesheet" type="text/css" media="print" />
<?php include("content/top.php"); ?>
</head>
<body>
<table width="1054" height="579" cellspacing="0">
 <?php include("content/header.php") ?>
  <tr>
    <?php include("content/side.php") ?>
    <td width="854" height="434" valign="top" id="content"><?php include("content/nav.php");
	include("Connections/myconn.php");
	 ?>
    <br />
    <br />
    <br />
    <br />
    <table width="668" height="129" border="1" bgcolor="#006633" style="margin-left:7%;position:absolute;">
      <tr bgcolor="#999966">
        <th height="55" colspan="3" align="center" bgcolor="#999966">Grand Total Detail</th>
        </tr>
      <tr bgcolor="#999966">
        <th height="33">Total Credit</th>
        <th>Total Debut</th>
        <th>Grand Total</th>
      </tr>
      <tr bgcolor="#999999">
        <td height="31">&nbsp;
          <?php 
		 $sel = mysql_query("select SUM(result) AS credit_total from clients where result NOT like '%-%' AND result != 0");
		 //$sel = @mysql_query("select SUM(amount) AS credit_total from detail where type = 'Credit'");
		 $row = @mysql_fetch_array($sel);
		   $cradit_total = $row["credit_total"];
		   echo $row["credit_total"] ?>
        </td>
        <td>&nbsp; <?php 
		$sel2 = mysql_query("select SUM(result) AS debut_total from clients where result like '%-%' AND result != 0");
		 //$sel2 = @mysql_query("select SUM(amount) AS debut_total from detail where type = 'Debut'");
		 $row2 = @mysql_fetch_array($sel2);
		   $debut_total = $row2["debut_total"];
		   echo $row2["debut_total"] ?>
          </td>
        <td>&nbsp;
        <?php $grand = $debut_total+$cradit_total;
		   echo $grand;
		   ?>
        </td>
      </tr>
    </table>
<br />
    </td>
  </tr>
    <?php include("content/footer.php") ?>
</table>
</body>
</html>