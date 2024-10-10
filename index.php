<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Yasin Roznamcha's Softwate</title>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<link href="style/print.css" rel="stylesheet" type="text/css" media="print" />
<?php include("content/top.php"); ?>
<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>
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
   <?php if(!isset($_SESSION["name"])){ ?>
    <font size="+3">Welcome Please Login</font><br />
    <?php // echo $d = md5("khankhan2") ?>
    <br />
    <form action="actions/login.php" method="post">
    <table width="505" style="margin-left:14%;" height="132" border="1">
      <tr>
        <td width="86">Name :
		 </td>
        <td width="403"><label for="name"></label>
          <input type="text" style="width:300px" name="name" id="name" /></td>
      </tr>
      <tr>
        <td>Password</td>
        <td><label for="pass"></label>
          <input type="password" style="width:300px" name="pass" id="pass" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Log me In" />
          <input type="submit" name="clear" id="clear" value="Clear" /></td>
        </tr>
    </table>
    </form>
    <?php }else{ ?>
    <font size="+3">Wellcome <font color="#FF0000"><?php echo $_SESSION["name"] ?></font> You are Now Logged In</font>
    <div class="slide">
	<img src="images/king 2.gif" style="width: 100%;height: 100%;">
    </div>
    <?php } ?>
    <font size="+3">    <br />
    <div style="margin-left:21%"> </div>
    </font></td>
  </tr>
    <?php include("content/footer.php") ?>
</table>
<script type="text/javascript">
swfobject.registerObject("FlashID");
</script>
</body>
</html>