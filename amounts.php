<?php require_once('Connections/myconn.php'); 
session_start();
if(!isset($_SESSION["name"]) || !isset($_SESSION["pass"]))
{
	header("location:index.php?msg=Please Login First");
	die();
}
?>
<?php
if(isset($_POST["from"]))
{
			$from = $_POST["from"];
			$to = $_POST["to"];
			mysql_select_db($database_myconn, $myconn);
			$all = mysql_query("SELECT * FROM clients WHERE result >= $from && result <= $to");
			$row_all = mysql_fetch_array($all);
			$t = mysql_query("SELECT SUM(result) as total FROM clients WHERE result >= $from AND result <= $to");
			$a = mysql_fetch_array($t);
			$total = $a["total"];

}
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
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body>
<br />
<form action="" method="post">
Show Between : <span id="sprytextfield1">
<input type="text" name="from" id="date"/>
<span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMinCharsMsg">Minimum number of characters not met.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span> And
<span id="sprytextfield2">
<input type="text" name="to" id="date2"/>
<span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMinCharsMsg">Minimum number of characters not met.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" value="Search it" />
</form><br />

<div id="apDiv1" onclick="printd()">Print This</div>
<div id="print">
<div id="info">Nayab Travel Agency Ph.No : [ 03049163858 ] Email : [ yasink51@yahoo.com ] &nbsp;Amount Between <font color="red">[ <?php echo $from ?> ]</font> To <font color="red">[ <?php echo $to ?> ]</font></div>
<br />
<table width="1049" style="margin-left:3%" height="46" border="1" cellspacing="0" id="all">
  <tr>
    <th width="80">S:No</th>
    <th width="188">Name</th>
    <th width="170">Date</th>
    <th width="188">Credit</th>
    <th width="188">Debut</th>
    <th width="227">Total Amount</th>
    </tr>
  <?php do { ?>
    <tr align="center">
      <td><a href="client-detail.php?id=<?php echo $row_all["conn_id"]; ?>"><?php echo $row_all['conn_id']; ?></a></td>
      <td><a href="client-detail.php?name=<?php echo $row_all["name"]; ?>"><?php echo $row_all['name']; ?></a></td>
      <td><a href="date.php?date=<?php echo $row_all["date"]; ?>"><?php echo $row_all['date']; ?></a></td>
      <td><?php echo $row_all['Credit']; ?></td>
      <td><?php echo $row_all['Debut']; ?></td>
      <td><?php echo $row_all['result']; ?></td>
    </tr>
    <?php } while (@$row_all = mysql_fetch_array($all)); ?>
</table>
<div id="tt"><strong>
Total : <?php echo $total ?></strong></div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {minChars:1, validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {minChars:1, validateOn:["change"]});
</script>
</body>
</html>

