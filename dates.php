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
if(strlen($_POST["name"])>1)
{
			$name = $_POST["name"];
			$from = $_POST["from"];
			$to = $_POST["to"];
			mysql_select_db($database_myconn, $myconn);
			$query_all = "SELECT * FROM detail WHERE date BETWEEN '".$from."' AND '".$to."' && name = '$name'";
			$all = mysql_query($query_all, $myconn) or die(mysql_error());
			$row_all = mysql_fetch_assoc($all);
			$totalRows_all = mysql_num_rows($all);
			//$t = mysql_query("SELECT SUM(amount) as total_d FROM detail WHERE date >= '$from' AND date <= '$to' AND name = '$name' && type = 'Debut'");
			//$a = mysql_fetch_array($t);
			//$total_d = $a["total_d"];
			//$t2 = mysql_query("SELECT SUM(amount) as total_c FROM detail WHERE date >= '$from' AND date <= '$to' AND name = '$name' && type = 'Credit'");
			//$a = mysql_fetch_array($t2);
			//$total_c = $a["total_c"];
			//$total = $total_c-$total_d;
}
elseif(strlen($_POST["name"])<1 && isset($_POST["from"]))
{
			$from = $_POST["from"];
			$to = $_POST["to"];
			mysql_select_db($database_myconn, $myconn);
			$query_all = "SELECT * FROM detail WHERE date >= '$from' AND date <= '$to'";
			$all = mysql_query($query_all, $myconn) or die(mysql_error());
			$row_all = mysql_fetch_assoc($all);
			$totalRows_all = mysql_num_rows($all);
			//$t = mysql_query("SELECT SUM(amount) as total_d FROM detail WHERE date >= '$from' AND date <= '$to' AND type = 'Debut'");
			//$a = mysql_fetch_array($t);
			//$total_d = $a["total_d"];
			//$t2 = mysql_query("SELECT SUM(amount) as total_c FROM detail WHERE date >= '$from' AND date <= '$to' AND type = 'Credit'");
			//$a = mysql_fetch_array($t2);
			//$total_c = $a["total_c"];
			//$total = $total_c-$total_d;
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
    margin-left: 820px;
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
}
</style>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
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
<link rel="stylesheet" href="js/jquery-ui.css">
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<script src="content/combo.js"></script>
<script language="javascript">
$(function() {
$( "#date" ).datepicker();
});
$(function() {
$( "#date2" ).datepicker();
});
</script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body>
<br />
<form action="" method="post">
Show Between : <span id="sprytextfield1">
<input type="text" name="from" id="date"/>
<span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMinCharsMsg">Minimum number of characters not met.</span></span> And
<span id="sprytextfield2">
<input type="text" name="to" id="date2"/>
<span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMinCharsMsg">Minimum number of characters not met.</span></span> &nbsp;Name : 
<label for="name"></label>
<select id="combobox" name="name">
          <?php 
if(isset($_GET["id"]))
{
	$id = $_GET["id"];
	$q = mysql_query("select name from clients where id = '$id'");
	@$r = mysql_fetch_array($q);
	$name = $r["name"];	
}
if(isset($name))
{
?>
<option value="<?php echo $name ?>"><?php echo $name ?></option>
<?php } ?>
         <option value=""></option>
<?php $se = mysql_query("select DISTINCT name from clients order by id desc");
while ($row = mysql_fetch_array($se)){
?>
<option value="<?php echo $row["name"] ?>"><?php echo $row["name"] ?></option>
<?php } ?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" value="Find It" />
</form><br />

<div id="apDiv1" onclick="printd()">Print This</div>
<div id="print">
<div id="info"><?php echo $infoMe ?> &nbsp;Accounts Detail From <font color="red">[ <?php echo $from ?> ]</font> To <font color="red">[ <?php echo $to ?> ]</font></div>
<br />
<table width="1049" style="margin-left:3%" height="46" border="1" cellspacing="0" id="all">
  <tr>
    <th width="80">S:No</th>
    <th width="145">Date</th>
    <th width="230">Name</th>
    <th width="120">Type</th>
    <th width="355">Detail</th>
    <th width="227">Amount</th>
    </tr>
  <?php 
  $total = 0;
  do { 
$sa = $row_all['date'];
list($d1,$m1,$y1)=explode('/',$sa);
//echo  strtotime($sa);
//echo "<br /><font color='#FF0000'>";
list($d2,$m2,$y2)=explode('/',$from);
//echo "</font><br /><font color='#00FF33'>";
list($d3,$m3,$y3)=explode('/',$to);
//echo "</font><br />";
//echo $d3."<br />";
//echo $m3."<br />";
//echo $y3."<br />";
  if($d1>=$d2 and $m1>=$m2 and $y1>=$y2 and $d1<=$d3 and $m1<=$m3 and $y1<=$y3)
  {
  ?>
    <tr align="center">
      <td><?php echo $row_all['conn_id']; ?></td>
      <td><?php echo $row_all['date']; ?></td>
      <td><?php echo $row_all['name']; ?></td>
      <td><?php echo $row_all['type']; ?></td>
      <td><?php echo $row_all['detail']; ?> <?php echo $row_all['info']; ?></td>
      <td><?php echo $row_all['amount']; ?></td>
    </tr>
    <?php 
				if($row_all['type']=='Debut')
				{
				$total = $total - $row_all['amount'];
				}
				else
				{
					$total = $total + $row_all['amount'];
				}
  }
  else
  {  
  }
	} while (@$row_all = mysql_fetch_assoc($all)); ?>
</table>
<div id="tt"><strong>
Total : <?php echo $total ?></strong></div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {minChars:1});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {minChars:1});
</script>
</body>
</html>
<?php
@mysql_free_result($all);
?>
