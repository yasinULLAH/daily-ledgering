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

$maxRows_usr = 9999;
$pageNum_usr = 0;
if (isset($_GET['pageNum_usr'])) {
  $pageNum_usr = $_GET['pageNum_usr'];
}
$startRow_usr = $pageNum_usr * $maxRows_usr;

$colname_usr = "-1";
if (isset($_GET['name'])) {
  $colname_usr = $_GET['name'];
  $id = $_GET["id"];
}else
{  
	  $id = $_GET["id"];
}
mysql_select_db($database_myconn, $myconn);
$query_usr = sprintf("SELECT * FROM detail WHERE name = '$colname_usr' OR conn_id = '$id'", GetSQLValueString($colname_usr, "text"));
$query_limit_usr = sprintf("%s LIMIT %d, %d", $query_usr, $startRow_usr, $maxRows_usr);
$usr = mysql_query($query_limit_usr, $myconn) or die(mysql_error());
$row_usr = mysql_fetch_assoc($usr);

if (isset($_GET['totalRows_usr'])) {
  $totalRows_usr = $_GET['totalRows_usr'];
} else {
  $all_usr = mysql_query($query_usr);
  $totalRows_usr = mysql_num_rows($all_usr);
}
$totalPages_usr = ceil($totalRows_usr/$maxRows_usr)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Yasin Roznamcha's Softwate</title>
<link rel="stylesheet" href="js/jquery-ui.css">
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<script src="content/jquery.js" language="javascript">
</script>
<link href="style/print.css" rel="stylesheet" type="text/css" media="print" />
<?php include("content/top.php"); ?>
<style>
#prints {
    margin-left: 47% !important;
    margin-top: -2% !important;
    position: absolute !important;
}
</style>
</head>
<body>
<table width="1054" height="579" cellspacing="0">
  <?php include("content/header.php") ?>
  <tr>
    <?php include("content/side.php") ?>
    <td width="854" height="434" valign="top" id="content">
      <?php include("content/nav.php");
	 ?>
      <br />
    </p>
      <form id="form1" name="form1" method="get" action="client-detail.php">
      Account Name : <select id="combobox" name="name">
      <option value=""></option>
<?php $se = mysql_query("select DISTINCT name from clients");
while ($row = mysql_fetch_array($se)){
?>
<option value="<?php echo $row["name"] ?>"><?php echo $row["name"] ?></option>
<?php } ?>
&nbsp;&nbsp;</select>
      &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Account id : 
      <select id="combobox2" name="id">
        <option value=""></option>
        <?php $se = mysql_query("select DISTINCT conn_id from clients");
while ($row = mysql_fetch_array($se)){
?>
        <option value="<?php echo $row["conn_id"] ?>"><?php echo $row["conn_id"] ?></option>
        <?php } ?>
      </select> 
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="submit" value="Get Information" />
      </form>
      <p>Showing Detail For <strong><font color="#FF0000" size="+2"><?php echo $row_usr['name']; $name = $row_usr["name"]; ?></font></strong> Account And Id Is <font color="#FF0000" size="+2"><?php echo $row_usr['conn_id']; $id = $row_usr["conn_id"];?></font>
        <div id="prints"><span onclick="printd();return false" style="color:#00F;text-decoration:underline;cursor:pointer;">Print</span>
         : <a href="account_all.php?id=<?php echo $id ?>&&name=<?php echo $name ?>">Preview Detail</a>
        </div>
      </p>
      <div id="print">
      <table width="941" height="62" border="1" cellspacing="0" style="position:relative;margin-left:0.2%;">
        <tr bgcolor="#999933">
        <th width="121" height="23">Date</th>
        <th width="119">Type</th>
        <th width="143">Amount</th>
        <th width="129">Detail</th>
        <th width="142">Manage</th>
        </tr>
      <?php do {
	 $type = $row_usr["type"]; 
	  if($type=="Debut")
	  {
		  $bg = "red";
	  }
	  else
	  {
		  $bg = "yellow";
	  }
		   ?>
        <tr align="center">
          <td bgcolor="#9999CC"><a href="date.php?date=<?php echo $row_usr['date']; ?>"><?php echo $row_usr['date']; ?></a></td>
          <td bgcolor="<?php echo $bg ?>"><?php echo $row_usr['type']; ?></td>
          <td bgcolor="#9999CC"><?php echo $row_usr['amount']; ?></td>
          <td bgcolor="#9999CC"><?php echo $row_usr['detail']; ?> <?php echo $row_usr['info']; ?></td>
          <td bgcolor="#9999CC"><?php if(!empty($row_usr["name"])){ ?><a href="actions/delete.php?id=<?php echo $row_usr['id']; ?>&&name=<?php echo $row_usr["name"]; ?>&&pg=c" onclick="return confirm('Are You Sure')">Delete</a> / <a href="update.php?id=<?php echo $row_usr['id']; ?>">Edit</a><?php } ?></td>
        </tr>
        <?php } while ($row_usr = mysql_fetch_assoc($usr)); ?>
  </table>
      <br />
<table width="529" style="margin-left:11%" height="124" border="1" bgcolor="#006699">
          <tr>
            <td height="52" colspan="3" align="center"><strong>Total Of <font color="#FF0000" size="+2"><?php echo $name;
			 ?> </font> Account</strong></td>
          </tr>
          <tr bgcolor="#999966">
            <th>Total Credit</th>
            <th>Total Debut</th>
            <th>Client Results</th>
          </tr>
          <tr bgcolor="#999966">
<?php
		 $sel = @mysql_query("select SUM(amount) AS credit_total from detail where type = 'Credit' AND name = '$name'");
		 $row = @mysql_fetch_array($sel);
		 ?>
            <td>&nbsp;
              <?php
		   $cradit_total = $row["credit_total"];
		   echo $row["credit_total"] ?></td>
            <?php 
		 $sel2 = @mysql_query("select SUM(amount) AS deput_total from detail where type = 'Debut'  AND name = '$name'");
		 $row2 = @mysql_fetch_array($sel2);
		 ?>
            <td>&nbsp;
              <?php
		   $debut_total = $row2["deput_total"];
		   echo $row2["deput_total"] ?></td>
            <td>&nbsp;
              <?php 
		   $grand = $cradit_total-$debut_total;
		   if($grand==0){
			   echo "<font color=\"#FF0000\">Account Is Clear</font>";
		   }else
		   {
		   echo $grand;
		   }
		   ?></td>
          </tr>
        </table>
        </div>
<br />
    </td>
  </tr>
    <?php include("content/footer.php") ?>
</table>
</body>
</html>
<?php
mysql_free_result($usr);
?>
