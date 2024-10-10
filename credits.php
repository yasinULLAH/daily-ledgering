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

$maxRows_deput = 99999999;
$pageNum_deput = 0;
if (isset($_GET['pageNum_deput'])) {
  $pageNum_deput = $_GET['pageNum_deput'];
}
$startRow_deput = $pageNum_deput * $maxRows_deput;

mysql_select_db($database_myconn, $myconn);
$query_deput = "select * from clients where result NOT like '%-%' AND result != 0 && result is not null order by id desc";
$qa = mysql_query("select SUM(result) AS rxz from clients where result NOT like '%-%' AND result != 0");
$ro = mysql_fetch_array($qa);
$r = $ro["rxz"];
$query_limit_deput = sprintf("%s LIMIT %d, %d", $query_deput, $startRow_deput, $maxRows_deput);
$deput = mysql_query($query_limit_deput, $myconn) or die(mysql_error());
if (isset($_GET['totalRows_deput'])) {
  $totalRows_deput = $_GET['totalRows_deput'];
} else {
  $all_deput = mysql_query($query_deput);
  $totalRows_deput = mysql_num_rows($all_deput);
}
$totalPages_deput = ceil($totalRows_deput/$maxRows_deput)-1;

$queryString_deput = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_deput") == false && 
        stristr($param, "totalRows_deput") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_deput = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_deput = sprintf("&totalRows_deput=%d%s", $totalRows_deput, $queryString_deput);
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
    <?php if(isset($_GET["msg"]))
	{?>
	<div id="msg"><?php echo $_GET["msg"] ?></div>
	<?php } ?>
	<font size="+2">Credit Accounts</font> <a href="credits_all.php">View All Credits</a><br />
	<table border="0">
	  <tr>
	    <td><?php if ($pageNum_deput > 0) { // Show if not first page ?>
	      <a href="<?php printf("%s?pageNum_deput=%d%s", $currentPage, 0, $queryString_deput); ?>">First</a>
	      <?php } // Show if not first page ?></td>
	    <td><?php if ($pageNum_deput > 0) { // Show if not first page ?>
	      <a href="<?php printf("%s?pageNum_deput=%d%s", $currentPage, max(0, $pageNum_deput - 1), $queryString_deput); ?>">Previous</a>
	      <?php } // Show if not first page ?></td>
	    <td><?php if ($pageNum_deput < $totalPages_deput) { // Show if not last page ?>
	      <a href="<?php printf("%s?pageNum_deput=%d%s", $currentPage, min($totalPages_deput, $pageNum_deput + 1), $queryString_deput); ?>">Next</a>
	      <?php } // Show if not last page ?></td>
	    <td><?php if ($pageNum_deput < $totalPages_deput) { // Show if not last page ?>
	      <a href="<?php printf("%s?pageNum_deput=%d%s", $currentPage, $totalPages_deput, $queryString_deput); ?>">Last</a>
	      <?php } // Show if not last page ?></td>
	    </tr>
	  </table>
	<br />
    <table width="769" style="margin-left:7%;" height="69" border="1">
      <tr bgcolor="#0099FF">
        <th>S:No</th>
        <th>Name</th>
        <th>Total Credit</th>
        <th>Total Debut</th>
        <th>Result</th>
        </tr>
    <?php 
	//$q = mysql_query("select * from clients where result NOT like '%-%' AND result != 0 order by conn_id desc");
	while($row_deput = mysql_fetch_assoc($deput))
	{
	?>
      <tr align="center" bgcolor="#999999">
        <td><a href="client-detail.php?id=<?php echo $row_deput["conn_id"] ?>"><?php echo $row_deput["conn_id"] ?></a></td>
        <td><a href="client-detail.php?name=<?php echo $row_deput["name"] ?>"><?php echo $row_deput["name"] ?></a></td>
        <td><?php echo $row_deput["Credit"] ?></td>
        <td><?php echo $row_deput["Debut"] ?></td>
        <td><?php echo $row_deput["result"] ?></td>
        </tr>
      <?php
	  $tt = 0;
	  $tt = $tt+$row_deput["result"];
	  } ?>
    </table>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div id="cr">This Total Credit Amount : <b><?php echo $tt; ?></b></div>
    <div id="cr2">Over All Credit Amount : <b><?php echo $r; ?></b></div>
    <table border="0">
      <tr>
    <td><?php if ($pageNum_deput > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_deput=%d%s", $currentPage, 0, $queryString_deput); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_deput > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_deput=%d%s", $currentPage, max(0, $pageNum_deput - 1), $queryString_deput); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_deput < $totalPages_deput) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_deput=%d%s", $currentPage, min($totalPages_deput, $pageNum_deput + 1), $queryString_deput); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_deput < $totalPages_deput) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_deput=%d%s", $currentPage, $totalPages_deput, $queryString_deput); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table></td>
</tr>
    <?php include("content/footer.php") ?>
</table>
</body>
</html>
<?php
mysql_free_result($deput);
?>
