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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_accounts = 99999999999;
$pageNum_accounts = 0;
if (isset($_GET['pageNum_accounts'])) {
  $pageNum_accounts = $_GET['pageNum_accounts'];
}
$startRow_accounts = $pageNum_accounts * $maxRows_accounts;

mysql_select_db($database_myconn, $myconn);
if($_GET['srt']=='s')
{
	$query_accounts = "SELECT * FROM clients order by id asc";
}elseif($_GET['srt']=='n')
{
	$query_accounts = "SELECT * FROM clients order by name asc";
}
elseif($_GET['srt']=='d')
{
	$query_accounts = "SELECT * FROM clients order by date asc";
}elseif($_GET['srt']=='t')
{
	$query_accounts = "SELECT * FROM clients order by CAST(result AS UNSIGNED ) desc";
}elseif($_GET['srt']=='tc')
{
	$query_accounts = "SELECT * FROM clients order by CAST(Credit AS UNSIGNED ) desc";
}elseif($_GET['srt']=='tb')
{
	$query_accounts = "SELECT * FROM clients order by CAST(Debut AS UNSIGNED ) desc";
}
else
{
	$query_accounts = "SELECT * FROM clients order by id desc";
}
$query_limit_accounts = sprintf("%s LIMIT %d, %d", $query_accounts, $startRow_accounts, $maxRows_accounts);
$accounts = mysql_query($query_limit_accounts, $myconn) or die(mysql_error());
$a = mysql_num_rows($accounts);
$row_accounts = mysql_fetch_assoc($accounts);

if (isset($_GET['totalRows_accounts'])) {
  $totalRows_accounts = $_GET['totalRows_accounts'];
} else {
  $all_accounts = mysql_query($query_accounts);
  $totalRows_accounts = mysql_num_rows($all_accounts);
}
$totalPages_accounts = ceil($totalRows_accounts/$maxRows_accounts)-1;

$queryString_accounts = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_accounts") == false && 
        stristr($param, "totalRows_accounts") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_accounts = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_accounts = sprintf("&totalRows_accounts=%d%s", $totalRows_accounts, $queryString_accounts);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Yasin Roznamcha's Softwate</title>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<link href="style/print.css" rel="stylesheet" type="text/css" media="print" />
<?php include("content/top.php"); ?>
<style type="text/css">
#ja tr:nth-child(odd){
	background-color:#9ACD90;
}
#ja tr:nth-child(even){
	background-color:#9ACD52;
}
#apDiv1 {    color: #0000FF;
    cursor: pointer;
    height: 17px;
    left: 878px;
    padding-left: 4px;
    position: absolute;
    text-decoration: underline;
    top: 227px;
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
    <?php if(isset($_GET["msg"]))
	{?>
	<div id="msg"><?php echo $_GET["msg"] ?></div>
	<?php } ?>
	<font size="+2">All Accounts</font>
    <a href="all.php">View all Account</a><br />
    Total <font color="#FF0000"> <?php echo $a ?> </font> records found  &nbsp;&nbsp;&nbsp;&nbsp;
    <div id="apDiv1" onclick="printd()">Print This</div>
    <br />
    <div id="printd">
      <table width="933" id="ja" height="46" cellspacing="0" cellpadding="0" border="1" style="margin-left:0.4%;">
        <tr bgcolor="#0066FF">
          <th width="2" bgcolor="#0066FF"><a id="c" href="all_account.php?srt=s">S:No</a></th>
          <th width="2" bgcolor="#0066FF"><a id="c" href="all_account.php?srt=d">Date</a></th>
          <th width="210" bgcolor="#0066FF"><a id="c" href="all_account.php?srt=n">Name</a></th>
          <th width="2" bgcolor="#0066FF"><a id="c" href="all_account.php?srt=tc">Total Credit</a></th>
          <th width="2" bgcolor="#0066FF"><a id="c" href="all_account.php?srt=tb">Total Debut</a></th>
          <th width="2" bgcolor="#0066FF"><a id="c" href="all_account.php?srt=t">Total</a></th>
          <th width="2" bgcolor="#0066FF">Delete</th>
          </tr>
        <?php do { ?>
        <tr align="center">
          <td><a href="client-detail.php?id=<?php echo $row_accounts['id']; ?>"><?php echo $row_accounts['id']; ?></a></td>
          <td><a href="date.php?date=<?php echo $row_accounts['date']; ?>"><?php echo $row_accounts['date']; ?></a></td>
          <td><a href="client-detail.php?name=<?php echo $row_accounts['name']; ?>"><?php echo $row_accounts['name']; ?></a></td>
          <td class="white"><?php echo $row_accounts['Credit']; ?></td>
          <td><?php echo $row_accounts['Debut']; ?></td>
          <td><?php echo $row_accounts['result']; ?></td>
          <td><a title="Delete Record" onclick="return confirm('Are You Sure Want To Delete &rArr; <?php echo strtoupper($row_accounts['name']) ?> &lArr; Record')" href="actions/delete_client.php?id=<?php echo $row_accounts['id']; ?>&&pg=a" style="color:#F00">X</a></td>
          </tr>
        <?php } while ($row_accounts = mysql_fetch_assoc($accounts)); ?>
      </table>
    </div>
    <br />
    <table border="0">
      <tr>
        <td><?php if ($pageNum_accounts > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_accounts=%d%s", $currentPage, 0, $queryString_accounts); ?>">First</a>
            <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_accounts > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_accounts=%d%s", $currentPage, max(0, $pageNum_accounts - 1), $queryString_accounts); ?>">Previous</a>
            <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_accounts < $totalPages_accounts) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_accounts=%d%s", $currentPage, min($totalPages_accounts, $pageNum_accounts + 1), $queryString_accounts); ?>">Next</a>
            <?php } // Show if not last page ?></td>
        <td><?php if ($pageNum_accounts < $totalPages_accounts) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_accounts=%d%s", $currentPage, $totalPages_accounts, $queryString_accounts); ?>">Last</a>
            <?php } // Show if not last page ?></td>
      </tr>
    </table>
    <div class="total"><strong>Total Credit</strong> =
<font style="background-color:#F00; color:#FFF;padding-left:4px;padding-right:4px;">
<?php 
		 $sel = @mysql_query("select SUM(amount) AS credit_total from detail where type = 'Credit'");
		 $row = @mysql_fetch_array($sel);
		   $cradit_total = $row["credit_total"];
		   echo $row["credit_total"] ?></font>
     <strong>Total Debut</strong> =
<font style="background-color:#FFFF00; color:#000;padding-left:4px;padding-right:4px;"><?php 
		 $sel2 = @mysql_query("select SUM(amount) AS debut_total from detail where type = 'Debut'");
		 $row2 = @mysql_fetch_array($sel2);
		   $debut_total = $row2["debut_total"];
		   echo $row2["debut_total"] ?></font>
      <strong>Total Amount</strong> =
<font style="background-color:#F00; color:#FFF;padding-left:4px;padding-right:4px;"><?php $grand = $cradit_total-$debut_total;
		   echo $grand;
		   ?></font>
    </div></td>
  </tr>
    <?php include("content/footer.php") ?>
</table>
</body>
</html>
<?php
mysql_free_result($accounts);
?>
