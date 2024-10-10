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
if(isset($_GET["name"]) || isset($_GET["id"]))
{
$name = $_GET["name"];
$id = $_GET["id"];
mysql_select_db($database_myconn, $myconn);
$query_all = "SELECT * FROM detail where name = '$name' OR conn_id = '$id'";
$all = mysql_query($query_all, $myconn) or die(mysql_error());
$row_all = mysql_fetch_assoc($all);
$totalRows_all = mysql_num_rows($all);
$t = mysql_query("select SUM(result) as total from clients");
$a = mysql_fetch_array($t);
$total = $a["total"];
}
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
    margin-left: 896px;
    position: absolute;
    text-align: center;
    width: 185px;
}
#db {
    background-color: yellow;
    border-bottom: 1px solid;
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 6px;
    border-left: 1px solid;
    border-right: 1px solid;
    margin-left: 713px;
    position: absolute;
    text-align: center;
    width: 185px;
}
#gg {
    background-color: yellow;
    border-bottom: 1px solid;
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 6px;
    border-left: 1px solid;
    border-right: 1px solid;
    margin-left: 530px;
    position: absolute;
    text-align: center;
    width: 185px;
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
}
</style>
<script language="javascript">
        function printd() {
             var divElements = document.getElementById('printd').innerHTML;
            var oldPage = document.body.innerHTML;
            document.body.innerHTML ="<html><head><title>yasin softwares</title> </head><body>"+divElements+"<br />Copyright Yasin khan</body></html>" ;
            window.print();
			//PrintUtils.printPreview(Printd);  uses for print preview
			history.go(-0);
		}
</script>
<link rel="stylesheet" href="js/jquery-ui.css">
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<script src="content/jquery.js" language="javascript">
</script>
<link href="style/print.css" rel="stylesheet" type="text/css" media="print" />
</head>
<body>
<br />
<form action="" method="get">
Name : 
<select id="combobox" name="name">
         <option value=""></option>
<?php $se = mysql_query("select DISTINCT name from clients order by id desc");
while ($row = mysql_fetch_array($se)){
?>
<option value="<?php echo $row["name"] ?>"><?php echo $row["name"] ?></option>
<?php } ?>
</select>
&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S:No :&nbsp;
<select id="combobox2" name="id">
  <option value=""></option>
  <?php $se2 = mysql_query("select DISTINCT id from clients order by id desc");
while ($row2 = mysql_fetch_array($se2)){
?>
  <option value="<?php echo $row2["id"] ?>"><?php echo $row2["id"] ?></option>
  <?php } ?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Find It" />
</form>
<br />
<div id="apDiv1" onclick="printd()">Print This</div>
<div id="printd">
<div id="info"><?php echo $infoMe ?> Detail of : &nbsp;<font color="#FF0000"><?php echo $name = $row_all["name"];$id = $row_all["conn_id"] ?></font> Account S:No <font color="#FF0000"><?php echo $id ?></font></div>
<br />
<table width="1049" style="margin-left:3%" height="46" border="1" cellspacing="0" id="all" class="f-big">
  <tr>
    <th width="173">Date</th>
    <th width="284">Detail</th>
    <th width="171">Credit</th>
    <th width="171">Debut</th>
    <th width="171">Total Amount</th>
  </tr>
  <?php do { ?>
    <tr align="center">
      <td><a href="date.php?date=<?php $type = $row_all["type"]; echo $row_all['date']; ?>"><?php echo $row_all['date']; ?></a></td>
      <td><?php echo $row_all['detail']; ?> <?php echo $row_all['info']; ?></td>
      <td bgcolor="#FFFF00"><?php if($type=='Credit'){echo $cr = $row_all["amount"];} ?></td>
      <td bgcolor="#FF0000" style="color:#FFF;"><?php if($type=='Debut'){echo $db = $row_all["amount"];} ?></td>
      <td><?php if(empty($t2)){$t2 = 0;}if($type=='Credit'){echo $t2 = $t2+$cr; }elseif($type=='Debut'){echo $t2=$t2-$db;}?></td>
    </tr>
    <?php } while (@$row_all = mysql_fetch_assoc($all)); ?>
</table>
<?php 
 $sel = @mysql_query("select SUM(amount) AS credit_total from detail where type = 'Credit' AND name = '$name'");
		 $row = @mysql_fetch_array($sel);
		 $cradit_total = $row["credit_total"];
		  $sel2 = @mysql_query("select SUM(amount) AS deput_total from detail where type = 'Debut'  AND name = '$name'");
		 $row2 = @mysql_fetch_array($sel2);
		 $debut_total = $row2["deput_total"];
		 $grand = $cradit_total-$debut_total;
?>
<div id="gg">
<strong>Total : <?php echo $cradit_total ?></strong></div>
<div id="db">
<strong>Total : <?php echo $debut_total ?></strong></div>
<div id="tt">
<strong>Total : <?php echo $grand ?></strong></div>
</div>
</body>
</html>
<?php
@mysql_free_result($all);
?>
