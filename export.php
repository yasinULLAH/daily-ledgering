<?php 
session_start();
if(!isset($_SESSION["name"]) || !isset($_SESSION["pass"]))
{
	header("location:index.php?msg=Please Login First");
	die();
}
?>
<?php
include("Connections/myconn.php")
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
	top: 250px;
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
      <br /><?php if(isset($_GET["msg"]))
	{?>
	<div id="msg"><?php echo $_GET["msg"] ?></div>
	<?php }else
	{?>
    <div id="msg">Enter The Account Name Or ID To Export Or Leave Blank To Export All</div>
	 <?php } ?>
    </p>
    <fieldset>
    <legend>Account Export Wizard</legend>
      <form id="delete" name="delete" method="get" action="exporter/generate-pdf.php">
      Account Name : <select id="combobox" name="name">
      <option value=""></option>
<?php $se = mysql_query("select DISTINCT name from clients");
while ($row = mysql_fetch_array($se)){
?>
<option value="<?php echo $row["name"] ?>" id="sort"><?php echo $row["name"] ?></option>
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
      &nbsp;&nbsp;&nbsp;&nbsp;<br />
      &nbsp;&nbsp;Detail :&nbsp;&nbsp;&nbsp;
      <input type="checkbox" name="dt" id="dt" />
      <label for="dt"></label>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="submit" value="Export Now !" onclick="return confirm('Are You Sure Want To Export')"/>
      </form>
      </p>
      <br />
     <?php include("content/footer.php") ?>
</fieldset>
</table>
</body>
</html>