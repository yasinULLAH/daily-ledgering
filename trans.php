<?php 
session_start();
if(!isset($_SESSION["name"]) || !isset($_SESSION["pass"]))
{
	header("location:index.php?msg=Please Login First");
	die();
}
?>
<?php  
include('Connections/myconn.php'); ?>
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

$maxRows_trans = 95;
$pageNum_trans = 0;
if (isset($_GET['pageNum_trans'])) {
  $pageNum_trans = $_GET['pageNum_trans'];
}
$startRow_trans = $pageNum_trans * $maxRows_trans;

mysql_select_db("roznamcha");
$query_trans = "SELECT id, conn_id, `date`, name, type, amount, info FROM detail where info is not null && info != '' order by id desc";
$query_limit_trans = sprintf("%s LIMIT %d, %d", $query_trans, $startRow_trans, $maxRows_trans);
$trans = mysql_query($query_limit_trans);
$row_trans = mysql_fetch_assoc($trans);

if (isset($_GET['totalRows_trans'])) {
  $totalRows_trans = $_GET['totalRows_trans'];
} else {
  $all_trans = mysql_query($query_trans);
  $totalRows_trans = mysql_num_rows($all_trans);
}
$totalPages_trans = ceil($totalRows_trans/$maxRows_trans)-1;

$queryString_trans = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_trans") == false && 
        stristr($param, "totalRows_trans") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_trans = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_trans = sprintf("&totalRows_trans=%d%s", $totalRows_trans, $queryString_trans);
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>yasin's roznamcha software</title>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
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
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style>
#status {
    background-color: -moz-buttonhoverface;
    border-radius: 6px 6px 6px 6px;
    box-shadow: 0 0 8px 0;
    margin-left: 10%;
    margin-top: 1%;
    padding-left: 12px;
    padding-right: 12px;
    position: absolute;
}
#amount {
    border-radius: 6px 6px 6px 6px;
    height: 28px;
    width: 191px;
}
</style>
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
	<br />
    <font size="5px">Transfer Money</font> <br />
    <form action="actions/transfer.php" method="post">
      From :
        <span id="spryselect1">
        <select id="combobox" name="from">
          <option value=""></option>
          <?php $se = mysql_query("select DISTINCT name from clients order by id desc");
while ($row = mysql_fetch_array($se)){
?>
          <option value="<?php echo $row["name"] ?>"><?php echo $row["name"] ?></option>
          <?php } ?>
        </select>
        <span class="selectRequiredMsg">Please select an item.</span></span> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To :&nbsp;<span id="spryselect2">
        <select id="combobox2" name="to">
          <option value=""></option>
          <?php $se2 = mysql_query("select DISTINCT name from clients order by id desc");
while ($row2 = mysql_fetch_array($se2)){
?>
          <option value="<?php echo $row2["name"] ?>"><?php echo $row2["name"] ?></option>
          <?php } ?>
        </select>
        <span class="selectRequiredMsg">Please select an item.</span></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  <label for="amount"></label>
  <span id="sprytextfield1">
  <input type="text" name="amount" id="amount" placeholder="Amount To Be Transfered"  onchange="check()"/>
  <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMinCharsMsg">Minimum number of characters not met.</span></span>
  <input type="submit" value="make this tranfer" /><br />
    <span id="status"></span>
    </form>
    <br />
<font size="5px"><br />
Tranfer Detail</font><br />
<table width="935" height="46" border="1" cellspacing="0" style="margin-left:0.6%">
  <tr bgcolor="#9999CC">
    <th>S:No</th>
    <th>Date</th>
    <th>Name</th>
    <th>Type</th>
    <th>Amount</th>
    <th>Detail</th>
    <th>Manage</th>
  </tr>
  <?php do { ?>
    <tr align="center" bgcolor="#CC9966">
      <td><a href="client-detail.php?id=<?php echo $row_trans['conn_id']; ?>"><?php echo $row_trans['conn_id']; ?></a></td>
      <td><a href="date.php?date=<?php echo $row_trans['date']; ?>"><?php echo $row_trans['date']; ?></a></td>
      <td><a href="client-detail.php?name=<?php echo $row_trans['name']; ?>"><?php echo $row_trans['name']; ?></a></td>
      <td bgcolor="<?php $type = $row_trans["type"]; if($type=='Debut'){echo 'red';}else if($type=='Credit'){echo 'yellow';} ?>"><?php echo $row_trans['type']; ?></td>
      <td><?php echo $row_trans['amount']; ?></td>
      <td><?php echo $row_trans['info']; ?></td>
      <td><a href="actions/delete.php?id=<?php echo $row_trans['id'] ?>&&pg=t" onclick="return confirm('Are you sure')">Delete</a></td>
    </tr>
    <?php } while (@$row_trans = mysql_fetch_assoc($trans)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_trans > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_trans=%d%s", $currentPage, 0, $queryString_trans); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_trans > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_trans=%d%s", $currentPage, max(0, $pageNum_trans - 1), $queryString_trans); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_trans < $totalPages_trans) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_trans=%d%s", $currentPage, min($totalPages_trans, $pageNum_trans + 1), $queryString_trans); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_trans < $totalPages_trans) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_trans=%d%s", $currentPage, $totalPages_trans, $queryString_trans); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table></td>
  </tr>
    <?php include("content/footer.php") ?>
</table>
<script type="text/javascript">
	function check()
		{
			var hr = new XMLHttpRequest();
			var from = document.getElementById("combobox").value;
			var to = document.getElementById("combobox2").value;
			var amount = document.getElementById('amount').value;
			 var vars = "from="+from+"&to="+to+"&amount="+amount;
			 hr.open("POST", "check.php", true);
    		// Set content type header information for sending url encoded variables in the request
    		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    		// Access the onreadystatechange event for the XMLHttpRequest object
    		hr.onreadystatechange = function() {
   			if(hr.readyState == 4 && hr.status == 200) {
   			var return_data = hr.responseText;
			document.getElementById("status").innerHTML = return_data;
   			}
    }
    // Send the data to PHP now... and wait for response to update the status div
    hr.send(vars); // Actually execute the request
    document.getElementById("status").innerHTML = "processing...";
			
		}
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"], minChars:1});
</script>
</body>
</html>
<?php
@mysql_free_result($trans);
?>
