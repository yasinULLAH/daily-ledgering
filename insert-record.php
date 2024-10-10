<?php 
session_start();
if(!isset($_SESSION["name"]) || !isset($_SESSION["pass"]))
{
	header("location:index.php?msg=Please Login First");
	die();
}
?>
<?php include("Connections/myconn.php") ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Yasin Roznamcha's Softwate</title>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="js/jquery-ui.css">
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<script src="content/combo.js">
</script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="style/print.css" rel="stylesheet" type="text/css" media="print" />
<?php include("content/top.php"); ?>
<script>
 $("#login").click(function(){
         $.ajax({
            type: "POST",
		 });
 });
 $("#sort").sort();
</script>
</head>
<body>
<table width="1054" height="579" cellspacing="0">
 <?php include("content/header.php") ?>
  <tr>
    <?php include("content/side.php") ?>
    <td width="854" height="434" valign="top" id="content">
    <?php include("content/nav.php"); ?>
    <br />
    <?php if(isset($_GET["msg"]))
	{?>
	<div id="msg"><?php echo $_GET["msg"] ?></div>
	<?php } ?>
    <font size="+2"><br />
    Add To an Existing Account</font><br />
    <form action="actions/add-existing.php" method="post" name="form1" id="form1">
      <table width="594" height="129" align="center" bgcolor="#009966">
        <tr valign="baseline">
          <td width="63" align="right" nowrap="nowrap"><strong>Name</strong> : </td>
          <td width="519"><span id="sprytextfield1">
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
<option value="<?php echo $name ?>" id="sort"><?php echo $name ?></option>
<?php } ?>
         <option value=""></option>
<?php $se = mysql_query("select DISTINCT name from clients order by name");
while ($row = mysql_fetch_array($se)){
?>
<option value="<?php echo $row["name"] ?>"><?php echo $row["name"] ?></option>
<?php } ?>
</select>
          <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMinCharsMsg">Must Not Be Empty.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"><strong>Type</strong> : </td>
          <td><select name="type" style="width:212px">
            <option value="Credit" <?php if (!(strcmp("Credit", ""))) {echo "SELECTED";} ?>>Credit</option>
            <option value="Debut" <?php if (!(strcmp("Debut", ""))) {echo "SELECTED";} ?>>Debut</option>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"><strong>Amount</strong> : </td>
          <td><span id="sprytextfield2">
          <input type="text" name="amount" value="" size="32" />
          <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMinCharsMsg">Must Not Be Empty.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
</td>
        </tr>
<tr>
<td>&nbsp;<b>Detail :</b> </td><td><input type="text" name="detail" value="" size="32" /> 
  &nbsp;Rapid : 
  <input type="checkbox" name="rapid" id="rapid" <?php if(isset($_GET['s'])){?>checked="checked"<?php } ?>/>
  <label for="rapid"></label></td></tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td><input type="submit" value="Insert record" /></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
    </form>
    <font size="+2">Start A New Acoount</font><br />
<form action="actions/add-record.php" method="POST" name="form2" id="form2">
      <table width="594" height="80" align="center" bgcolor="#009966">
        <tr valign="baseline">
          <td width="63" height="34" align="right" nowrap="nowrap"><strong>Name</strong> : </td>
          <td width="519"><span id="sprytextfield1"><span id="sprytextfield3">
          <input type="text" name="names" value="" size="32" id="names2"/>
          <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMinCharsMsg">Minimum number of characters not met.</span></span><span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMinCharsMsg">Must Not Be Empty.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td height="38" align="right" nowrap="nowrap">&nbsp;</td>
          <td><input type="submit" value="Start Account" /></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
      <input type="hidden" name="MM_insert" value="form2" />
</form>
<br />
    <br /></td>
  </tr>
    <?php include("content/footer.php") ?>
</table>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {minChars:2, validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {minChars:1, validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur", "change"], minChars:2});
</script>
</body>
</html>