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
<script>
/*$(function() {
var availableTags = [
<?php //$a = mysql_query("select DISTINCT name from clients");
//while($r = mysql_fetch_array($a))
//{
 //?>
"<?php //echo $r["name"] ?>",
<?php //} ?>
];
$( "#names" ).autocomplete({
source: availableTags
});
});*/
(function( $ ) {
$.widget( "custom.combobox", {
_create: function() {
this.wrapper = $( "<span>" )
.addClass( "custom-combobox" )
.insertAfter( this.element );
this.element.hide();
this._createAutocomplete();
this._createShowAllButton();
},
_createAutocomplete: function() {
var selected = this.element.children( ":selected" ),
value = selected.val() ? selected.text() : "";
this.input = $( "<input>" )
.appendTo( this.wrapper )
.val( value )
.attr( "title", "" )
.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
.autocomplete({
delay: 0,
minLength: 0,
source: $.proxy( this, "_source" )
})
.tooltip({
tooltipClass: "ui-state-highlight"
});
this._on( this.input, {
autocompleteselect: function( event, ui ) {
ui.item.option.selected = true;
this._trigger( "select", event, {
item: ui.item.option
});
},
autocompletechange: "_removeIfInvalid"
});
},
_createShowAllButton: function() {
var input = this.input,
wasOpen = false;
$( "<a>" )
.attr( "tabIndex", -1 )
.attr( "title", "Show All Items" )
.tooltip()
.appendTo( this.wrapper )
.button({
icons: {
primary: "ui-icon-triangle-1-s"
},
text: false
})
.removeClass( "ui-corner-all" )
.addClass( "custom-combobox-toggle ui-corner-right" )
.mousedown(function() {
wasOpen = input.autocomplete( "widget" ).is( ":visible" );
})
.click(function() {
input.focus();
// Close if already visible
if ( wasOpen ) {
return;
}
// Pass empty string as value to search for, displaying all results
input.autocomplete( "search", "" );
});
},
_source: function( request, response ) {
var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
response( this.element.children( "option" ).map(function() {
var text = $( this ).text();
if ( this.value && ( !request.term || matcher.test(text) ) )
return {
label: text,
value: text,
option: this
};
}) );
},
_removeIfInvalid: function( event, ui ) {
// Selected an item, nothing to do
if ( ui.item ) {
return;
}
// Search for a match (case-insensitive)
var value = this.input.val(),
valueLowerCase = value.toLowerCase(),
valid = false;
this.element.children( "option" ).each(function() {
if ( $( this ).text().toLowerCase() === valueLowerCase ) {
this.selected = valid = true;
return false;
}
});
// Found a match, nothing to do
if ( valid ) {
return;
}
// Remove invalid value
this.input
.val( "" )
.attr( "title", value + " didn't match any item" )
.tooltip( "open" );
this.element.val( "" );
this._delay(function() {
this.input.tooltip( "close" ).attr( "title", "" );
}, 2500 );
this.input.data( "ui-autocomplete" ).term = "";
},
_destroy: function() {
this.wrapper.remove();
this.element.show();
}
});
})( jQuery );
$(function() {
$( "#combobox" ).combobox();
$( "#toggle" ).click(function() {
$( "#combobox" ).toggle();
});
});
</script>
<?php 
$id = $_GET["id"];
@$q = mysql_query("select * from detail where id = '$id'");
@$r = mysql_fetch_array($q);
 ?>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="style/print.css" rel="stylesheet" type="text/css" media="print" />
<?php include("content/top.php"); ?>
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
    Update Account</font><br />
    <form action="actions/update.php" method="post" name="form1" id="form1">
      <table width="594" height="129" align="center" bgcolor="#009966">
        <tr valign="baseline">
          <td width="63" align="right" nowrap="nowrap"><strong>Name</strong> : </td>
          <td width="519"><span id="sprytextfield1">
          <select id="combobox" name="name">
         <option value="<?php echo $r["name"]; ?>"><?php echo $r["name"]; ?></option>
<?php $se = mysql_query("select DISTINCT name from clients");
while (@$row = mysql_fetch_array($se)){
?>
<option value="<?php echo $row["name"] ?>"><?php echo $row["name"] ?></option>
<?php } ?>
</select>
          <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMinCharsMsg">Must Not Be Empty.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"><strong>Type</strong> : </td>
          <td><select name="type" style="width:212px">
            <option value="<?php echo $r["type"] ?>"><?php echo $r["type"] ?></option>
            <option value="Credit">Credit</option>
            <option value="Debut">Debut</option>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"><strong>Amount</strong> : </td>
          <td><span id="sprytextfield2">
          <input type="text" name="amount" value="<?php echo $r["amount"] ?>" size="32" />
          <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMinCharsMsg">Must Not Be Empty.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
            <input type="hidden" name="idd" id="hiddenField" value="<?php echo $_GET['id'] ?>"/></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"><strong>Detail :</strong> &nbsp;</td>
          <td><label for="detail"></label>
            <input type="text" name="detail" id="detail" value="<?php echo $r["detail"] ?>"/></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td><input type="submit" value="Update record" /></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
    </form>
    <br />
    <br /></td>
  </tr>
    <?php include("content/footer.php") ?>
</table>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {minChars:2, validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {minChars:1, validateOn:["blur", "change"]});
</script>
</body>
</html>