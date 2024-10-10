<td width="110" valign="top" id="side" bgcolor="#0066CC" style="padding-left:3px;line-height:33px;font-size:21px;">
<br>
<a href="index.php" style="color:#F93;">Home Page</a><br>
<a href="actions/logout.php" style="color:#F93">Logout</a><br>
<a href="index.php" style="color:#F93">Login</a><br>
<?php if(isset($_SESSION["name"]) AND isset($_SESSION["pass"])){ ?>
<a href="backup/backup.php" style="color:#F93">Backup Every Thing</a><br>
<a href="trans.php" style="color:#F93">Transfor Money</a><br>
<a href="amounts.php" style="color:#F93">Amount</a><br>
<a href="delete_record.php" style="color:#F93">Delete a Record</a><br>
<a href="export.php" style="color:#F93;display:none;">Export to PDF</a><br>
<?php } ?>
</td>