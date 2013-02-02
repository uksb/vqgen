<?php
/**
 * vQmod XML Generator v3.0.0
 * 
 * Generate XML files for use with vQmod.
 * Built-in File Manager and Log Viewer.
 *
 * For further information please visit {@link http://www.vqmod.com/}
 * 
 * @author Simon Powers - UK Site Buidler Ltd <info@uksitebuilder.net> {@link http://www.opencart-extensions.co.uk/}
 * @copyright Copyright (c) 2011, UK Site Builder Ltd
 * @version $Id: index.php,v 2.2.0 2011-12-07 23:00:00 sp Exp $
 * @license http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-ShareAlike 3.0 Unported License
 */

// Set the default file paths relative to this file
define('LOG', '../vqmod/vqmod.log'); // relative location of vqmod log file
define('LOGMAX', 10); // max viewale size in MB of log file
define('PATH', '../vqmod/xml/'); // relative path to the vqmod xml folder
define('CACHE', '../vqmod/vqcache/'); // relative path to the vqmod cache folder

if (!ini_get('date.timezone')) {
	date_default_timezone_set('UTC');
}

include('inc/functions.php');
include('inc/actions.php');
include('inc/files.php');
include('inc/log.php');
?>
<!DOCTYPE HTML>
<head>
<meta charset="utf-8">
<title>vQmod XML File Generator</title>
<meta name="author" content="Simon Powers, UK Site Builder Ltd, http://www.opencart-extensions.co.uk/">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<?php
if(isset($_GET['generated'])){
?>
<p class="generate">File Generated Successfully at <?php echo date("G:i"); ?></p>
<p><span class="add">Create a New file</span></p>
<p><a href="./?enable=<?php echo $_GET['file']; ?>"><img src="images/enable.png" width="16" height="16" alt="enable" title="Enable"> Enable this vQmod</a></p>
<?php	
}
?>
<h1>vQmod XML File Generator</h1>
<p>First of all you need to install vQmod if you haven't got it already.</p>
<p>For more info on vQmod and what it does visit <a href="http://www.vqmod.com/">vQmod.com</a></p>
<?php 
if(isset($_GET['file'])){
?>
<form name="generator" action="./" method="post">
<fieldset class="ma">
<legend>General file info</legend>
	<label for="filename">Filename:</label>
    <input id="filename" name="filename" type="text" onblur="$(this).val($(this).val().replace('.xml', ''))" style="width:400px;" value="<?php echo str_replace(".xml_", "", $_GET['file']); ?>">
    .xml <span class="help">This will be the final Generated XML filename</span><br><br>
    
    <label for="fileid">Title:</label>
    <input id="fileid" name="fileid" type="text" style="width:400px;" value="<?php echo preg_replace("/\r?\n/", "\\n", htmlentities($id['value'], ENT_QUOTES, 'UTF-8')); ?>"> <span class="help">Give it a name</span><br><br>
    
    <label for="version">File Version:</label>
    <input id="version" name="version" type="text" style="width:50px;" value="<?php echo preg_replace("/\r?\n/", "\\n", htmlentities($version['value'], ENT_QUOTES, 'UTF-8')); ?>"> <span class="help">This can be your version number for this file or the version number of the site</span><br><br>
    
    <label for="vqmodver">vQmod Version:</label>
    <input id="vqmodver" name="vqmodver" type="text" style="width:50px;" value="<?php echo preg_replace("/\r?\n/", "\\n", htmlentities($vqmver['value'], ENT_QUOTES, 'UTF-8')); ?>"> <span class="help">Just for your reference</span><br><br>
    
    <label for="author">Author:</label>
    <input id="author" name="author" type="text" style="width:400px;" value="<?php echo preg_replace("/\r?\n/", "\\n", htmlentities($author['value'], ENT_QUOTES, 'UTF-8')); ?>"> <span class="help">Your name and/or website address</span>
    
</fieldset>

<div id="container"></div>
<div>
    <div id="actions">
        <p><span class="add2">Add a new operation</span></p>
        <p><span class="add1">Add a new file to edit</span></p>
        <p><span class="add">Start Over</span></p>
    </div>
    <div id="generate">
    	<p><input type="submit" name="submit" value="Generate XML File" id="dogen"><input type="hidden" name="generatexml" value="1"></p>
    </div>
</div>
</form>
<?php
}
if(!isset($_POST['generatexml'])&&!isset($_GET['file'])){
?>
<h2>Fill out the form below with your file edits</h2>
<form name="generator" action="./" method="post">
<fieldset class="ma">
<legend>General file info</legend>
	<label for="filename">Filename:</label>
    <input id="filename" name="filename" type="text" onblur="$(this).val($(this).val().replace('.xml', ''))" style="width:400px;">
    .xml <span class="help">This will be the final Generated XML filename</span><br><br>
    
    <label for="fileid">Title:</label>
    <input id="fileid" name="fileid" type="text" style="width:400px;"> <span class="help">Give it a name</span><br><br>
    
    <label for="version">File Version:</label>
    <input id="version" name="version" type="text" style="width:50px;" value=""> <span class="help">This can be your version number for this file or the version number of the site</span><br><br>
    
    <label for="vqmodver">vQmod Version:</label>
    <input id="vqmodver" name="vqmodver" type="text" style="width:50px;" value=""> <span class="help">Just for your reference</span><br><br>
    
    <label for="author">Author:</label>
    <input id="author" name="author" type="text" style="width:400px;"> <span class="help">Your name and/or website address</span>
    
</fieldset>

<div id="container"></div>
<div>
    <div id="actions">
        <p><span class="add2">Add a new operation</span></p>
        <p><span class="add1">Add a new file to edit</span></p>
        <p><span class="add">Start Over</span></p>
    </div>
    <div id="generate">
        <p><input type="submit" name="submit" value="Generate XML File" id="dogen"><input type="hidden" name="generatexml" value="1"></p>
    </div>
</div>
</form>
<?php
}
?>
<div class="slide-out-div">
<a class="handle" href="#">Content</a>
<?php
if(isset($inactivevqmods)&&count($inactivevqmods)>0){ ?>
    <h3>Newly Created, Edited and Inactive vQmod Files</h3>
    <p><span class="help">vQmod Cache will be cleared on enable/delete</span></p>
    <table>
    <tr><td class="row2" colspan="2" style="text-align:right;"><a href="./?enableall=1"><img src="images/enable.png" width="16" height="16" alt="enable" title="Enable ALL"></a> Enable ALL</td></tr>
    <tr><th scope="col">Filename</th><th scope="col">Action</th></tr>
<?php
	$row = '';
	foreach($inactivevqmods as $av){
		$row = ($row == 'row2'?'row1':'row2'); ?>
        <tr>
            <td class="<?php echo $row; ?>">
                <p style="margin:0;"><span class="help"><?php echo $av['file']; ?></span>
                <br><?php if($av['id']!='') { echo $av['id']; ?>
                <br><?php } if($av['version']!='') { ?><span class="help">Ver:</span> <?php echo $av['version']; } if($av['vqmver']!=''){ ?> <span class="help">vQmod:</span> <?php echo $av['vqmver']; } if($av['size']!=''){ ?> <span class="help">Size:</span> <?php echo $av['size']; } ?> <span class="help">Date:</span> <?php echo $av['date']; ?>
                <?php if($av['author']!=''){ ?><br><span class="help">Author:</span> <?php echo $av['author']; } ?></p>
            </td>
            <td class="<?php echo $row; ?> actions">
            	<a href="./?file=<?php echo $av['file'].'_'; ?>"><img src="images/edit.png" width="16" height="16" alt="edit" title="Edit"></a> <a href="./?enable=<?php echo $av['file'].'_'; ?>"><img src="images/enable.png" width="16" height="16" alt="enable" title="Enable"></a> <a href="./?get=<?php echo $av['file'].'_'; ?>"><img src="images/get.png" width="16" height="16" title="Get" alt="get"></a> <a href="./?delete=<?php echo $av['file'].'_'; ?>" onclick="return confirm('Are you sure you want to delete: <?php echo $av['file']; ?>');"><img src="images/delete.png" width="16" height="16" alt="delete" title="Delete"></a>
			</td>
        </tr>
<?php
}
?>
    </table>
<?php
}

if(isset($activevqmods)&&count($activevqmods)>0){
?>
    <h3>Active vQmod Files</h3>
    <p><span class="help">vQmod Cache will be cleared on disable/delete<br>File will be disabled on edit and vQmod Cache cleared</span></p>
    <table>
    <tr><td class="row2" colspan="2" style="text-align:right;"><a href="./?disableall=1"><img src="images/disable.png" width="16" height="16" alt="disable" title="Disable ALL"></a> Disable ALL</td></tr>
    <tr><th scope="col">Filename</th><th scope="col">Action</th></tr>
<?php
	$row = '';
	foreach($activevqmods as $av){
		$row = ($row == 'row2'?'row1':'row2'); ?>
        <tr>
            <td class="<?php echo $row; ?>">
                <p style="margin:0;"><span class="help"><?php echo $av['file']; ?></span>
                <br><?php if($av['id']!='') { echo $av['id']; ?>
                <br><?php } if($av['version']!='') { ?><span class="help">Ver:</span> <?php echo $av['version']; } if($av['vqmver']!=''){ ?> <span class="help">vQmod:</span> <?php echo $av['vqmver']; } if($av['size']!=''){ ?> <span class="help">Size:</span> <?php echo $av['size']; } ?> <span class="help">Date:</span> <?php echo $av['date']; ?>
                <?php if($av['author']!=''){ ?><br><span class="help">Author:</span> <?php echo $av['author']; } ?></p>
            </td>
            <td class="<?php echo $row; ?> actions">
                <a href="./?file=<?php echo $av['file']; ?>"><img src="images/edit.png" width="16" height="16" alt="edit" title="Edit"></a> <a href="./?disable=<?php echo $av['file']; ?>"><img src="images/disable.png" width="16" height="16" alt="disable" title="Disable"></a> <a href="./?get=<?php echo $av['file']; ?>"><img src="images/get.png" width="16" height="16" title="Get" alt="get"></a> <a href="./?delete=<?php echo $av['file']; ?>" onclick="return confirm('Are you sure you want to delete: <?php echo $av['file']; ?>');"><img src="images/delete.png" width="16" height="16" alt="delete" title="Delete"></a>
            </td>
        </tr>
<?php
}
?>
</table>
<?php
}
?>
</div>
<div class="slide-out-div2">
<a class="handle2" href="#">Content</a>
<h3>vQmod Log File</h3> <a href="./?clearlog=1">Clear Log</a><br><br>
<textarea id="log" readonly="readonly"><?php echo $log; ?></textarea>
</div>
<div id="footer">&copy; Copyright <?php echo (date("Y")>2011?'2011 - ':'') . date("Y"); ?> <a href="http://www.uksitebuilder.net/">UK Site Builder Ltd</a> - Get More Great vQmod Extensions at <a href="http://www.opencart-extensons.co.uk/">OpenCart-Extensons.co.uk</a><br>vQmod Generator by <a href="http://www.uksitebuilder.net" >UK Site Builder Ltd</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/">Creative Commons Attribution-ShareAlike 3.0 Unported License</a></div>
<script src="js/jquery.min.js"></script>
<?php 
if(isset($_GET['file'])){
?>
<script>
$(function() {
var x = '';
<?php 
$idx = 0;
$idx2 = 0;
foreach($data as $f){ ?>
	x = x + "<div class=\"file\">";
	x = x + "\n\t<fieldset id=\"filefieldset_" + <?php echo $idx; ?> + "\" class=\"fi\">";
	x = x + "\n\t<legend>File to edit</legend>";
	x = x + "\n\t\t<label for=\"file_" + <?php echo $idx; ?> + "\">Path to Filename:</label>";
	x = x + "\n\t\t<input id=\"file_" + <?php echo $idx; ?> + "\" name=\"file[" + <?php echo $idx; ?> + "]\" type=\"text\" style=\"width:750px;\" value=\"<?php echo preg_replace("/\r?\n/", "\\n", htmlentities(addslashes($f['attributes']['name']), ENT_QUOTES, 'UTF-8')); ?>\"><br><br>"; 
	x = x + "\n\t\t<div class=\"delete\">Remove on Generate <input id=\"remove_" + <?php echo $idx; ?> + "\" name=\"remove_" + <?php echo $idx; ?> + "\" type=\"checkbox\" value=\"1\" onclick=\"if($('#remove_" + <?php echo $idx; ?> + "').is(':checked')){ $('input[id^=remove_" + <?php echo $idx; ?> + "_]').attr('checked','checked').attr('disabled','disabled'); } else { $('input[id^=remove_" + <?php echo $idx; ?> + "_]').removeAttr('checked').removeAttr('disabled'); }\"></div>";
	x = x + "\n\t</fieldset>";
	
	<?php 
	foreach($f['value'] as $op){
	?>
		x = x + "\n\t<div class=\"operation\">";    
		x = x + "\n\t\t<fieldset id=\"operationfieldset_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" class=\"op\">";
		x = x + "\n\t\t<legend>Operation to perform</legend>";
		x = x + "\n\t\t\t<label for=\"search_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\">Search:</label>";
		x = x + "\n\t\t\t<input id=\"search_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" name=\"search[" + <?php echo $idx; ?> + "][" + <?php echo $idx2; ?> + "]\" type=\"text\" style=\"width:750px;\" value=\"<?php echo preg_replace("/\r?\n/", "\\n", htmlentities(addslashes($op['value'][0]['value']), ENT_QUOTES, 'UTF-8')); ?>\"><br><br>";
		x = x + "\n\t\t\t<label for=\"position_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\">Position:</label>";
		x = x + "\n\t\t\t<select id=\"position_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" name=\"position[" + <?php echo $idx; ?> + "][" + <?php echo $idx2; ?> + "]\">";
		x = x + "\n\t\t\t\t<option value=\"replace\"<?php if($op['value'][0]['attributes']['position']=='replace'){ ?> selected=\"selected\"<?php } ?>>replace</option>";
		x = x + "\n\t\t\t\t<option value=\"before\"<?php if($op['value'][0]['attributes']['position']=='before'){ ?> selected=\"selected\"<?php } ?>>before</option>";
		x = x + "\n\t\t\t\t<option value=\"after\"<?php if($op['value'][0]['attributes']['position']=='after'){ ?> selected=\"selected\"<?php } ?>>after</option>";
		x = x + "\n\t\t\t\t<option value=\"top\"<?php if($op['value'][0]['attributes']['position']=='top'){ ?> selected=\"selected\"<?php } ?>>top</option>";
		x = x + "\n\t\t\t\t<option value=\"bottom\"<?php if($op['value'][0]['attributes']['position']=='bottom'){ ?> selected=\"selected\"<?php } ?>>bottom</option>";
		x = x + "\n\t\t\t\t<option value=\"all\"<?php if($op['value'][0]['attributes']['position']=='all'){ ?> selected=\"selected\"<?php } ?>>all</option>";
		x = x + "\n\t\t\t</select>";
		x = x + "\n\t\t\t<span class=\"help\">What to do with or where to place, the 'add' data in relation to the 'search' data</span><br><br>";
		x = x + "\n\t\t\t<label for=\"offset_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\">Offset:</label>";
		x = x + "\n\t\t\t<input id=\"offset_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" name=\"offset[" + <?php echo $idx; ?> + "][" + <?php echo $idx2; ?> + "]\" type=\"text\" style=\"width:40px;\" value=\"<?php echo $op['value'][0]['attributes']['offset']; ?>\"> <span class=\"help\">Single Integer ONLY (leave blank for none)</span><br><br>";
		x = x + "\n\t\t\t<label for=\"index_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\">Index:</label>";
		x = x + "\n\t\t\t<input id=\"index_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" name=\"index[" + <?php echo $idx; ?> + "][" + <?php echo $idx2; ?> + "]\" type=\"text\" style=\"width:40px;\" value=\"<?php echo $op['value'][0]['attributes']['index']; ?>\"> <span class=\"help\">Single Integer or Comma Separated Integers Only (leave blank for none)</span><br><br>";
		x = x + "\n\t\t\t<label for=\"error_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\">Error:</label>";
		x = x + "\n\t\t\t<select id=\"error_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" name=\"error[" + <?php echo $idx; ?> + "][" + <?php echo $idx2; ?> + "]\">";
		x = x + "\n\t\t\t\t<option value=\"abort\"<?php if(!isset($op['value'][0]['attributes']['error'])){ ?> selected=\"selected\"<?php } ?>>abort &amp; log</option>";
		x = x + "\n\t\t\t\t<option value=\"log\"<?php if($op['value'][0]['attributes']['error']=='log'){ ?> selected=\"selected\"<?php } ?>>skip &amp; log</option>";
		x = x + "\n\t\t\t\t<option value=\"skip\"<?php if($op['value'][0]['attributes']['error']=='skip'){ ?> selected=\"selected\"<?php } ?>>skip don't log</option>";
		x = x + "\n\t\t\t</select> <span class=\"help\">Abort and Log is default</span><br><br>";
		x = x + "\n\t\t\t<label for=\"regex_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\">Regex:</label>";
		x = x + "\n\t\t\t<select id=\"regex_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" name=\"regex[" + <?php echo $idx; ?> + "][" + <?php echo $idx2; ?> + "]\">";
		x = x + "\n\t\t\t\t<option value=\"false\"<?php if(!isset($op['value'][0]['attributes']['regex'])){ ?> selected=\"selected\"<?php } ?>>false</option>";
		x = x + "\n\t\t\t\t<option value=\"true\"<?php if($op['value'][0]['attributes']['regex']=='true'){ ?> selected=\"selected\"<?php } ?>>true</option>";
		x = x + "\n\t\t\t</select>";
		x = x + "\n\t\t\t<span class=\"help\">False is default - Switch to True to use regular expressions</span><br><br>";
		x = x + "\n\t\t\t<textarea id=\"add_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" name=\"add[" + <?php echo $idx; ?> + "][" + <?php echo $idx2; ?> + "]\" style=\"width:940px;height:240px;\"><?php echo preg_replace("/\r?\n/", "\\n", htmlentities(addslashes($op['value'][1]['value']), ENT_QUOTES, 'UTF-8')); ?></textarea><br><br>";
		x = x + "\n\t\t\t<div class=\"delete\">Remove on Generate <input id=\"remove_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" name=\"remove_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" type=\"checkbox\" value=\"1\" onclick=\"if($('input[id^=remove_" + <?php echo $idx; ?> + "_]').not(':checked').length===0){ $('#remove_" + <?php echo $idx; ?> + "').attr('checked','checked'); $('input[id^=remove_" + <?php echo $idx; ?> + "_]').attr('disabled','disabled'); }\"></div>";
		x = x + "\n\t\t\t<div class=\"delete\">Add <select id=\"newop_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" name=\"newop[" + <?php echo $idx; ?> + "][" + <?php echo $idx2; ?> + "]\">";
		x = x + "\n\t\t\t\t<option value=\"0\" selected=\"selected\">0</option>";
		x = x + "\n\t\t\t\t<option value=\"1\">1</option>";
		x = x + "\n\t\t\t\t<option value=\"2\">2</option>";
		x = x + "\n\t\t\t\t<option value=\"3\">3</option>";
		x = x + "\n\t\t\t</select> new operation(s) after this one <span class=\"gen\">[Go]</span></div>";
		x = x + "\n\t\t</fieldset>";
		x = x + "\n\t</div>";
<?php
		$idx2++;
	}
	$idx++;
?>
		x = x + "\n</div>";
<?php
}
?>
	$("#container").append(x);

	var idx = <?php echo $idx-1; ?>;
	var idx2 = <?php echo $idx2-1; ?>;
	
	$(".add1").click(function() {
		idx = idx + 1;
		idx2 = idx2 + 1;
		
		var x = "\n<div class=\"file\">";
		x = x + "\n\t<fieldset id=\"filefieldset_" + idx + "\" class=\"fi\">";
		x = x + "\n\t<legend>File to edit</legend>";
		x = x + "\n\t\t<label for=\"file_" + idx + "\">Path to Filename:</label>";
		x = x + "\n\t\t<input id=\"file_" + idx + "\" name=\"file[" + idx + "]\" type=\"text\" style=\"width:750px;\"><br><br>"; 
		x = x + "\n\t\t<!-- <a onclick=\"idx = idx - 1; $(this).parent().parent().slideUp(function(){ $(this).remove() }); return false\"><span class=\"remove\">Remove</span></a> //-->";
		x = x + "\n\t\t<div class=\"delete\">Remove on Generate <input id=\"remove_" + idx + "\" name=\"remove_" + idx + "\" type=\"checkbox\" value=\"1\" onclick=\"if($('#remove_" + idx + "').is(':checked')){ $('input[id^=remove_" + idx + "_]').attr('checked','checked').attr('disabled','disabled'); } else { $('input[id^=remove_" + idx + "_]').removeAttr('checked').removeAttr('disabled'); }\"></div>";
		x = x + "\n\t</fieldset>";
		x = x + "\n\t<div class=\"operation\">";    
		x = x + "\n\t\t<fieldset id=\"operationfieldset_" + idx + "_" + idx2 + "\" class=\"op\">";
		x = x + "\n\t\t<legend>Operation to perform</legend>";
		x = x + "\n\t\t\t<label for=\"search_" + idx + "_" + idx2 + "\">Search:</label>";
		x = x + "\n\t\t\t<input id=\"search_" + idx + "_" + idx2 + "\" name=\"search[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:750px;\"><br><br>";
		x = x + "\n\t\t\t<label for=\"position_" + idx + "_" + idx2 + "\">Position:</label>";
		x = x + "\n\t\t\t<select id=\"position_" + idx + "_" + idx2 + "\" name=\"position[" + idx + "][" + idx2 + "]\">";
		x = x + "\n\t\t\t\t<option value=\"replace\" selected=\"selected\">replace</option>";
		x = x + "\n\t\t\t\t<option value=\"before\">before</option>";
		x = x + "\n\t\t\t\t<option value=\"after\">after</option>";
		x = x + "\n\t\t\t\t<option value=\"top\">top</option>";
		x = x + "\n\t\t\t\t<option value=\"bottom\">bottom</option>";
		x = x + "\n\t\t\t\t<option value=\"all\">all</option>";
		x = x + "\n\t\t\t</select>";
		x = x + "\n\t\t\t<span class=\"help\">What to do with or where to place, the 'add' data in relation to the 'search' data</span><br><br>";
		x = x + "\n\t\t\t<label for=\"offset_" + idx + "_" + idx2 + "\">Offset:</label>";
		x = x + "\n\t\t\t<input id=\"offset_" + idx + "_" + idx2 + "\" name=\"offset[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:40px;\"> <span class=\"help\">Single Integer ONLY (leave blank for none)</span><br><br>";
		x = x + "\n\t\t\t<label for=\"index_" + idx + "_" + idx2 + "\">Index:</label>";
		x = x + "\n\t\t\t<input id=\"index_" + idx + "_" + idx2 + "\" name=\"index[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:40px;\"> <span class=\"help\">Single Integer or Comma Separated Integers Only (leave blank for none)</span><br><br>";
		x = x + "\n\t\t\t<label for=\"error_" + idx + "_" + idx2 + "\">Error:</label>";
		x = x + "\n\t\t\t<select id=\"error_" + idx + "_" + idx2 + "\" name=\"error[" + idx + "][" + idx2 + "]\">";
		x = x + "\n\t\t\t\t<option value=\"abort\" selected=\"selected\">abort &amp; log</option>";
		x = x + "\n\t\t\t\t<option value=\"log\">skip &amp; log</option>";
		x = x + "\n\t\t\t\t<option value=\"skip\">skip don't log</option>";
		x = x + "\n\t\t\t</select> <span class=\"help\">Abort and Log is default</span><br><br>";
		x = x + "\n\t\t\t<label for=\"regex_" + idx + "_" + idx2 + "\">Regex:</label>";
		x = x + "\n\t\t\t<select id=\"regex_" + idx + "_" + idx2 + "\" name=\"regex[" + idx + "][" + idx2 + "]\">";
		x = x + "\n\t\t\t\t<option value=\"false\" selected=\"selected\">false</option>";
		x = x + "\n\t\t\t\t<option value=\"true\">true</option>";
		x = x + "\n\t\t\t</select>";
		x = x + "\n\t\t\t<span class=\"help\">False is default - Switch to True to use regular expressions</span><br><br>";
		x = x + "\n\t\t\t<textarea id=\"add_" + idx + "_" + idx2 + "\" name=\"add[" + idx + "][" + idx2 + "]\" style=\"width:940px;height:240px;\"></textarea><br><br>";
		x = x + "\n\t\t\t<div class=\"delete\">Remove on Generate <input id=\"remove_" + idx + "_" + idx2 + "\" name=\"remove_" + idx + "_" + idx2 + "\" type=\"checkbox\" value=\"1\" onclick=\"if($('input[id^=remove_" + idx + "_]').not(':checked').length===0){ $('#remove_" + idx + "').attr('checked','checked'); $('input[id^=remove_" + idx + "_]').attr('disabled','disabled'); }\"></div>";
		x = x + "\n\t\t\t<div class=\"delete\">Add <select id=\"newop_" + idx + "_" + idx2 + "\" name=\"newop[" + idx + "][" + idx2 + "]\">";
		x = x + "\n\t\t\t\t<option value=\"0\" selected=\"selected\">0</option>";
		x = x + "\n\t\t\t\t<option value=\"1\">1</option>";
		x = x + "\n\t\t\t\t<option value=\"2\">2</option>";
		x = x + "\n\t\t\t\t<option value=\"3\">3</option>";
		x = x + "\n\t\t\t</select> new operation(s) after this one <span class=\"gen\">[Go]</span></div>";
		x = x + "\n\t\t</fieldset>";
		x = x + "\n\t</div>";
		x = x + "\n</div>";
		
		$("#container").append(x);
		var $elem = $('body');
		$('html, body').animate({scrollTop: $elem.height()}, 800);
	});
	
	$(".add2").click(function() {
		if($('#remove_' + idx ).is(':checked')){
			alert('Please clear the \'Remove on Generate\' checkbox for this file, if you wish to add a new operation to it.\n\nAlternatively, you can add a new file to edit.');
		}else{
			idx = idx;
			idx2 = idx2 + 1;
			
			var x = "\n\t<div class=\"operation\">";    
			x = x + "\n\t\t<fieldset id=\"operationfieldset_" + idx + "_" + idx2 + "\" class=\"op\">";
			x = x + "\n\t\t<legend>Operation to perform</legend>";
			x = x + "\n\t\t\t<label for=\"search_" + idx + "_" + idx2 + "\">Search:</label>";
			x = x + "\n\t\t\t<input id=\"search_" + idx + "_" + idx2 + "\" name=\"search[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:750px;\"><br><br>";
			x = x + "\n\t\t\t<label for=\"position_" + idx + "_" + idx2 + "\">Position:</label>";
			x = x + "\n\t\t\t<select id=\"position_" + idx + "_" + idx2 + "\" name=\"position[" + idx + "][" + idx2 + "]\">";
			x = x + "\n\t\t\t\t<option value=\"replace\" selected=\"selected\">replace</option>";
			x = x + "\n\t\t\t\t<option value=\"before\">before</option>";
			x = x + "\n\t\t\t\t<option value=\"after\">after</option>";
			x = x + "\n\t\t\t\t<option value=\"top\">top</option>";
			x = x + "\n\t\t\t\t<option value=\"bottom\">bottom</option>";
			x = x + "\n\t\t\t\t<option value=\"all\">all</option>";
			x = x + "\n\t\t\t</select>";
			x = x + "\n\t\t\t<span class=\"help\">What to do with or where to place, the 'add' data in relation to the 'search' data</span><br><br>";
			x = x + "\n\t\t\t<label for=\"offset_" + idx + "_" + idx2 + "\">Offset:</label>";
			x = x + "\n\t\t\t<input id=\"offset_" + idx + "_" + idx2 + "\" name=\"offset[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:40px;\"> <span class=\"help\">Single Integer ONLY (leave blank for none)</span><br><br>";
			x = x + "\n\t\t\t<label for=\"index_" + idx + "_" + idx2 + "\">Index:</label>";
			x = x + "\n\t\t\t<input id=\"index_" + idx + "_" + idx2 + "\" name=\"index[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:40px;\"> <span class=\"help\">Single Integer or Comma Separated Integers Only (leave blank for none)</span><br><br>";
			x = x + "\n\t\t\t<label for=\"error_" + idx + "_" + idx2 + "\">Error:</label>";
			x = x + "\n\t\t\t<select id=\"error_" + idx + "_" + idx2 + "\" name=\"error[" + idx + "][" + idx2 + "]\">";
			x = x + "\n\t\t\t\t<option value=\"abort\" selected=\"selected\">abort &amp; log</option>";
			x = x + "\n\t\t\t\t<option value=\"log\">skip &amp; log</option>";
			x = x + "\n\t\t\t\t<option value=\"skip\">skip don't log</option>";
			x = x + "\n\t\t\t</select> <span class=\"help\">Abort and Log is default</span><br><br>";
			x = x + "\n\t\t\t<label for=\"regex_" + idx + "_" + idx2 + "\">Regex:</label>";
			x = x + "\n\t\t\t<select id=\"regex_" + idx + "_" + idx2 + "\" name=\"regex[" + idx + "][" + idx2 + "]\">";
			x = x + "\n\t\t\t\t<option value=\"false\" selected=\"selected\">false</option>";
			x = x + "\n\t\t\t\t<option value=\"true\">true</option>";
			x = x + "\n\t\t\t</select>";
			x = x + "\n\t\t\t<span class=\"help\">False is default - Switch to True to use regular expressions</span><br><br>";
			x = x + "\n\t\t\t<textarea id=\"add_" + idx + "_" + idx2 + "\" name=\"add[" + idx + "][" + idx2 + "]\" style=\"width:940px;height:240px;\"></textarea><br><br>";
			x = x + "\n\t\t\t<div class=\"delete\">Remove on Generate <input id=\"remove_" + idx + "_" + idx2 + "\" name=\"remove_" + idx + "_" + idx2 + "\" type=\"checkbox\" value=\"1\" onclick=\"if($('input[id^=remove_" + idx + "_]').not(':checked').length===0){ $('#remove_" + idx + "').attr('checked','checked'); $('input[id^=remove_" + idx + "_]').attr('disabled','disabled'); }\"></div>";
			x = x + "\n\t\t\t<div class=\"delete\">Add <select id=\"newop_" + idx + "_" + idx2 + "\" name=\"newop[" + idx + "][" + idx2 + "]\">";
			x = x + "\n\t\t\t\t<option value=\"0\" selected=\"selected\">0</option>";
			x = x + "\n\t\t\t\t<option value=\"1\">1</option>";
			x = x + "\n\t\t\t\t<option value=\"2\">2</option>";
			x = x + "\n\t\t\t\t<option value=\"3\">3</option>";
			x = x + "\n\t\t\t</select> new operation(s) after this one <span class=\"gen\">[Go]</span></div>";
			x = x + "\n\t\t</fieldset>";
			x = x + "\n\t</div>";
			
			$(".file:last").append(x);
			
			var $elem = $('body');
			$('html, body').animate({scrollTop: $elem.height()}, 800);
		}
	});

	$(".add").click(function() {
		location.href='./';
	});
	$(".gen").bind('click', function() {
		$('#dogen').trigger('click');
	});
});
</script>
<?php
}

if(!isset($_POST['generatexml'])&&!isset($_GET['file'])){
?>
<script>
var idx = 0;
var idx2 = 0;
$(function() {
	var x = "<div class=\"file\">";
	x = x + "\n\t<fieldset id=\"filefieldset_" + idx + "\" class=\"fi\">";
	x = x + "\n\t<legend>File to edit</legend>";
	x = x + "\n\t\t<label for=\"file_" + idx + "\">Path to Filename:</label>";
	x = x + "\n\t\t<input id=\"file_" + idx + "\" name=\"file[" + idx + "]\" type=\"text\" style=\"width:750px;\"><br><br>"; 
	x = x + "\n\t\t<div class=\"delete\">Remove on Generate <input id=\"remove_" + idx + "\" name=\"remove_" + idx + "\" type=\"checkbox\" value=\"1\" onclick=\"if($('#remove_" + idx + "').is(':checked')){ $('input[id^=remove_" + idx + "_]').attr('checked','checked').attr('disabled','disabled'); } else { $('input[id^=remove_" + idx + "_]').removeAttr('checked').removeAttr('disabled'); }\"></div>";
	x = x + "\n\t</fieldset>";
	x = x + "\n\t<div class=\"operation\">";    
	x = x + "\n\t\t<fieldset id=\"operationfieldset_" + idx + "_" + idx2 + "\" class=\"op\">";
	x = x + "\n\t\t<legend>Operation to perform</legend>";
	x = x + "\n\t\t\t<label for=\"search_" + idx + "_" + idx2 + "\">Search:</label>";
	x = x + "\n\t\t\t<input id=\"search_" + idx + "_" + idx2 + "\" name=\"search[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:750px;\"><br><br>";
	x = x + "\n\t\t\t<label for=\"position_" + idx + "_" + idx2 + "\">Position:</label>";
	x = x + "\n\t\t\t<select id=\"position_" + idx + "_" + idx2 + "\" name=\"position[" + idx + "][" + idx2 + "]\">";
	x = x + "\n\t\t\t\t<option value=\"replace\" selected=\"selected\">replace</option>";
	x = x + "\n\t\t\t\t<option value=\"before\">before</option>";
	x = x + "\n\t\t\t\t<option value=\"after\">after</option>";
	x = x + "\n\t\t\t\t<option value=\"top\">top</option>";
	x = x + "\n\t\t\t\t<option value=\"bottom\">bottom</option>";
	x = x + "\n\t\t\t\t<option value=\"all\">all</option>";
	x = x + "\n\t\t\t</select>";
	x = x + "\n\t\t\t<span class=\"help\">What to do with or where to place, the 'add' data in relation to the 'search' data</span><br><br>";
	x = x + "\n\t\t\t<label for=\"offset_" + idx + "_" + idx2 + "\">Offset:</label>";
	x = x + "\n\t\t\t<input id=\"offset_" + idx + "_" + idx2 + "\" name=\"offset[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:40px;\"> <span class=\"help\">Single Integer ONLY (leave blank for none)</span><br><br>";
	x = x + "\n\t\t\t<label for=\"index_" + idx + "_" + idx2 + "\">Index:</label>";
	x = x + "\n\t\t\t<input id=\"index_" + idx + "_" + idx2 + "\" name=\"index[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:40px;\"> <span class=\"help\">Single Integer or Comma Separated Integers Only (leave blank for none)</span><br><br>";
	x = x + "\n\t\t\t<label for=\"error_" + idx + "_" + idx2 + "\">Error:</label>";
	x = x + "\n\t\t\t<select id=\"error_" + idx + "_" + idx2 + "\" name=\"error[" + idx + "][" + idx2 + "]\">";
	x = x + "\n\t\t\t\t<option value=\"abort\" selected=\"selected\">abort &amp; log</option>";
	x = x + "\n\t\t\t\t<option value=\"log\">skip &amp; log</option>";
	x = x + "\n\t\t\t\t<option value=\"skip\">skip don't log</option>";
	x = x + "\n\t\t\t</select> <span class=\"help\">Abort and Log is default</span><br><br>";
	x = x + "\n\t\t\t<label for=\"regex_" + idx + "_" + idx2 + "\">Regex:</label>";
	x = x + "\n\t\t\t<select id=\"regex_" + idx + "_" + idx2 + "\" name=\"regex[" + idx + "][" + idx2 + "]\">";
	x = x + "\n\t\t\t\t<option value=\"false\" selected=\"selected\">false</option>";
	x = x + "\n\t\t\t\t<option value=\"true\">true</option>";
	x = x + "\n\t\t\t</select>";
	x = x + "\n\t\t\t<span class=\"help\">False is default - Switch to True to use regular expressions</span><br><br>";
	x = x + "\n\t\t\t<textarea id=\"add_" + idx + "_" + idx2 + "\" name=\"add[" + idx + "][" + idx2 + "]\" style=\"width:940px;height:240px;\"></textarea><br><br>";
	x = x + "\n\t\t\t<div class=\"delete\">Remove on Generate <input id=\"remove_" + idx + "_" + idx2 + "\" name=\"remove_" + idx + "_" + idx2 + "\" type=\"checkbox\" value=\"1\" onclick=\"if($('input[id^=remove_" + idx + "_]').not(':checked').length===0){ $('#remove_" + idx + "').attr('checked','checked'); $('input[id^=remove_" + idx + "_]').attr('disabled','disabled'); }\"></div>";
	x = x + "\n\t\t\t<div class=\"delete\">Add <select id=\"newop_" + idx + "_" + idx2 + "\" name=\"newop[" + idx + "][" + idx2 + "]\">";
	x = x + "\n\t\t\t\t<option value=\"0\" selected=\"selected\">0</option>";
	x = x + "\n\t\t\t\t<option value=\"1\">1</option>";
	x = x + "\n\t\t\t\t<option value=\"2\">2</option>";
	x = x + "\n\t\t\t\t<option value=\"3\">3</option>";
	x = x + "\n\t\t\t</select> new operation(s) after this one <span class=\"gen\">[Go]</span></div>";
	x = x + "\n\t\t</fieldset>";
	x = x + "\n\t</div>";
	x = x + "\n</div>";
	
	$("#container").append(x);

	$(".add1").click(function() {
		idx = idx + 1;
		idx2 = idx2 + 1;
		
		var x = "\n<div class=\"file\">";
		x = x + "\n\t<fieldset id=\"filefieldset_" + idx + "\" class=\"fi\">";
		x = x + "\n\t<legend>File to edit</legend>";
		x = x + "\n\t\t<label for=\"file_" + idx + "\">Path to Filename:</label>";
		x = x + "\n\t\t<input id=\"file_" + idx + "\" name=\"file[" + idx + "]\" type=\"text\" style=\"width:750px;\"><br><br>"; 
		x = x + "\n\t\t<!-- <a onclick=\"idx = idx - 1; $(this).parent().parent().slideUp(function(){ $(this).remove() }); return false\"><span class=\"remove\">Remove</span></a> //-->";
		x = x + "\n\t\t<div class=\"delete\">Remove on Generate <input id=\"remove_" + idx + "\" name=\"remove_" + idx + "\" type=\"checkbox\" value=\"1\" onclick=\"if($('#remove_" + idx + "').is(':checked')){ $('input[id^=remove_" + idx + "_]').attr('checked','checked').attr('disabled','disabled'); } else { $('input[id^=remove_" + idx + "_]').removeAttr('checked').removeAttr('disabled'); }\"></div>";
		x = x + "\n\t</fieldset>";
		x = x + "\n\t<div class=\"operation\">";    
		x = x + "\n\t\t<fieldset id=\"operationfieldset_" + idx + "_" + idx2 + "\" class=\"op\">";
		x = x + "\n\t\t<legend>Operation to perform</legend>";
		x = x + "\n\t\t\t<label for=\"search_" + idx + "_" + idx2 + "\">Search:</label>";
		x = x + "\n\t\t\t<input id=\"search_" + idx + "_" + idx2 + "\" name=\"search[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:750px;\"><br><br>";
		x = x + "\n\t\t\t<label for=\"position_" + idx + "_" + idx2 + "\">Position:</label>";
		x = x + "\n\t\t\t<select id=\"position_" + idx + "_" + idx2 + "\" name=\"position[" + idx + "][" + idx2 + "]\">";
		x = x + "\n\t\t\t\t<option value=\"replace\" selected=\"selected\">replace</option>";
		x = x + "\n\t\t\t\t<option value=\"before\">before</option>";
		x = x + "\n\t\t\t\t<option value=\"after\">after</option>";
		x = x + "\n\t\t\t\t<option value=\"top\">top</option>";
		x = x + "\n\t\t\t\t<option value=\"bottom\">bottom</option>";
		x = x + "\n\t\t\t\t<option value=\"all\">all</option>";
		x = x + "\n\t\t\t</select>";
		x = x + "\n\t\t\t<span class=\"help\">What to do with or where to place, the 'add' data in relation to the 'search' data</span><br><br>";
		x = x + "\n\t\t\t<label for=\"offset_" + idx + "_" + idx2 + "\">Offset:</label>";
		x = x + "\n\t\t\t<input id=\"offset_" + idx + "_" + idx2 + "\" name=\"offset[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:40px;\"> <span class=\"help\">Single Integer ONLY (leave blank for none)</span><br><br>";
		x = x + "\n\t\t\t<label for=\"index_" + idx + "_" + idx2 + "\">Index:</label>";
		x = x + "\n\t\t\t<input id=\"index_" + idx + "_" + idx2 + "\" name=\"index[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:40px;\"> <span class=\"help\">Single Integer or Comma Separated Integers Only (leave blank for none)</span><br><br>";
		x = x + "\n\t\t\t<label for=\"error_" + idx + "_" + idx2 + "\">Error:</label>";
		x = x + "\n\t\t\t<select id=\"error_" + idx + "_" + idx2 + "\" name=\"error[" + idx + "][" + idx2 + "]\">";
		x = x + "\n\t\t\t\t<option value=\"abort\" selected=\"selected\">abort &amp; log</option>";
		x = x + "\n\t\t\t\t<option value=\"log\">skip &amp; log</option>";
		x = x + "\n\t\t\t\t<option value=\"skip\">skip don't log</option>";
		x = x + "\n\t\t\t</select> <span class=\"help\">Abort and Log is default</span><br><br>";
		x = x + "\n\t\t\t<label for=\"regex_" + idx + "_" + idx2 + "\">Regex:</label>";
		x = x + "\n\t\t\t<select id=\"regex_" + idx + "_" + idx2 + "\" name=\"regex[" + idx + "][" + idx2 + "]\">";
		x = x + "\n\t\t\t\t<option value=\"false\" selected=\"selected\">false</option>";
		x = x + "\n\t\t\t\t<option value=\"true\">true</option>";
		x = x + "\n\t\t\t</select>";
		x = x + "\n\t\t\t<span class=\"help\">False is default - Switch to True to use regular expressions</span><br><br>";
		x = x + "\n\t\t\t<textarea id=\"add_" + idx + "_" + idx2 + "\" name=\"add[" + idx + "][" + idx2 + "]\" style=\"width:940px;height:240px;\"></textarea><br><br>";
		x = x + "\n\t\t\t<div class=\"delete\">Remove on Generate <input id=\"remove_" + idx + "_" + idx2 + "\" name=\"remove_" + idx + "_" + idx2 + "\" type=\"checkbox\" value=\"1\" onclick=\"if($('input[id^=remove_" + idx + "_]').not(':checked').length===0){ $('#remove_" + idx + "').attr('checked','checked'); $('input[id^=remove_" + idx + "_]').attr('disabled','disabled'); }\"></div>";
		x = x + "\n\t\t\t<div class=\"delete\">Add <select id=\"newop_" + idx + "_" + idx2 + "\" name=\"newop[" + idx + "][" + idx2 + "]\">";
		x = x + "\n\t\t\t\t<option value=\"0\" selected=\"selected\">0</option>";
		x = x + "\n\t\t\t\t<option value=\"1\">1</option>";
		x = x + "\n\t\t\t\t<option value=\"2\">2</option>";
		x = x + "\n\t\t\t\t<option value=\"3\">3</option>";
		x = x + "\n\t\t\t</select> new operation(s) after this one <span class=\"gen\">[Go]</span></div>";
		x = x + "\n\t\t</fieldset>";
		x = x + "\n\t</div>";
		x = x + "\n</div>";
		
		$("#container").append(x);
		var $elem = $('body');
		$('html, body').animate({scrollTop: $elem.height()}, 800);
	});
	
	$(".add2").click(function() {
		if($('#remove_' + idx ).is(':checked')){
			alert('Please clear the \'Remove on Generate\' checkbox for this file, if you wish to add a new operation to it.\n\nAlternatively, you can add a new file to edit.');
		}else{
			idx = idx;
			idx2 = idx2 + 1;
			
			var x = "\n\t<div class=\"operation\">";    
			x = x + "\n\t\t<fieldset id=\"operationfieldset_" + idx + "_" + idx2 + "\" class=\"op\">";
			x = x + "\n\t\t<legend>Operation to perform</legend>";
			x = x + "\n\t\t\t<label for=\"search_" + idx + "_" + idx2 + "\">Search:</label>";
			x = x + "\n\t\t\t<input id=\"search_" + idx + "_" + idx2 + "\" name=\"search[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:750px;\"><br><br>";
			x = x + "\n\t\t\t<label for=\"position_" + idx + "_" + idx2 + "\">Position:</label>";
			x = x + "\n\t\t\t<select id=\"position_" + idx + "_" + idx2 + "\" name=\"position[" + idx + "][" + idx2 + "]\">";
			x = x + "\n\t\t\t\t<option value=\"replace\" selected=\"selected\">replace</option>";
			x = x + "\n\t\t\t\t<option value=\"before\">before</option>";
			x = x + "\n\t\t\t\t<option value=\"after\">after</option>";
			x = x + "\n\t\t\t\t<option value=\"top\">top</option>";
			x = x + "\n\t\t\t\t<option value=\"bottom\">bottom</option>";
			x = x + "\n\t\t\t\t<option value=\"all\">all</option>";
			x = x + "\n\t\t\t</select>";
			x = x + "\n\t\t\t<span class=\"help\">What to do with or where to place, the 'add' data in relation to the 'search' data</span><br><br>";
			x = x + "\n\t\t\t<label for=\"offset_" + idx + "_" + idx2 + "\">Offset:</label>";
			x = x + "\n\t\t\t<input id=\"offset_" + idx + "_" + idx2 + "\" name=\"offset[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:40px;\"> <span class=\"help\">Single Integer ONLY (leave blank for none)</span><br><br>";
			x = x + "\n\t\t\t<label for=\"index_" + idx + "_" + idx2 + "\">Index:</label>";
			x = x + "\n\t\t\t<input id=\"index_" + idx + "_" + idx2 + "\" name=\"index[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:40px;\"> <span class=\"help\">Single Integer or Comma Separated Integers Only (leave blank for none)</span><br><br>";
			x = x + "\n\t\t\t<label for=\"error_" + idx + "_" + idx2 + "\">Error:</label>";
			x = x + "\n\t\t\t<select id=\"error_" + idx + "_" + idx2 + "\" name=\"error[" + idx + "][" + idx2 + "]\">";
			x = x + "\n\t\t\t\t<option value=\"abort\" selected=\"selected\">abort &amp; log</option>";
			x = x + "\n\t\t\t\t<option value=\"log\">skip &amp; log</option>";
			x = x + "\n\t\t\t\t<option value=\"skip\">skip don't log</option>";
			x = x + "\n\t\t\t</select> <span class=\"help\">Abort and Log is default</span><br><br>";
			x = x + "\n\t\t\t<label for=\"regex_" + idx + "_" + idx2 + "\">Regex:</label>";
			x = x + "\n\t\t\t<select id=\"regex_" + idx + "_" + idx2 + "\" name=\"regex[" + idx + "][" + idx2 + "]\">";
			x = x + "\n\t\t\t\t<option value=\"false\" selected=\"selected\">false</option>";
			x = x + "\n\t\t\t\t<option value=\"true\">true</option>";
			x = x + "\n\t\t\t</select>";
			x = x + "\n\t\t\t<span class=\"help\">False is default - Switch to True to use regular expressions</span><br><br>";
			x = x + "\n\t\t\t<textarea id=\"add_" + idx + "_" + idx2 + "\" name=\"add[" + idx + "][" + idx2 + "]\" style=\"width:940px;height:240px;\"></textarea><br><br>";
			x = x + "\n\t\t\t<div class=\"delete\">Remove on Generate <input id=\"remove_" + idx + "_" + idx2 + "\" name=\"remove_" + idx + "_" + idx2 + "\" type=\"checkbox\" value=\"1\" onclick=\"if($('input[id^=remove_" + idx + "_]').not(':checked').length===0){ $('#remove_" + idx + "').attr('checked','checked'); $('input[id^=remove_" + idx + "_]').attr('disabled','disabled'); }\"></div>";
			x = x + "\n\t\t\t<div class=\"delete\">Add <select id=\"newop_" + idx + "_" + idx2 + "\" name=\"newop[" + idx + "][" + idx2 + "]\">";
			x = x + "\n\t\t\t\t<option value=\"0\" selected=\"selected\">0</option>";
			x = x + "\n\t\t\t\t<option value=\"1\">1</option>";
			x = x + "\n\t\t\t\t<option value=\"2\">2</option>";
			x = x + "\n\t\t\t\t<option value=\"3\">3</option>";
			x = x + "\n\t\t\t</select> new operation(s) after this one <span class=\"gen\">[Go]</span></div>";
			x = x + "\n\t\t</fieldset>";
			x = x + "\n\t</div>";
			
			$(".file:last").append(x);
			
			var $elem = $('body');
			$('html, body').animate({scrollTop: $elem.height()}, 800);
		}
	});

	$(".add").click(function() {
		location.href='./';
	});
	$(".gen").bind('click', function() {
		$('#dogen').trigger('click');
	});
});
</script>
<?php
}
?>
<script src="js/jquery.textarea.js"></script>
<script src="js/jquery.tabSlideOut.v1.3.js"></script>
<script>
$(function(){
	$('.slide-out-div').tabSlideOut({
		tabHandle: '.handle',                              //class of the element that will be your tab
		pathToTabImage: './images/files_top_tab.png',          //path to the image for the tab (optionaly can be set using css)
		imageHeight: '34px',                               //height of tab image
		imageWidth: '133px',                               //width of tab image    
		tabLocation: 'top',                               //side of screen where tab lives, top, right, bottom, or left
		speed: 300,                                        //speed of animation
		action: 'click',                                   //options: 'click' or 'hover', action to trigger animation
		topPos: '0px',                                   //position from the top
		leftPos: '337px',                                   //position from the left
		fixedPosition: false                               //options: true makes it stick(fixed position) on scroll
	});

	$('.slide-out-div2').tabSlideOut({
		tabHandle: '.handle2',                              //class of the element that will be your tab
		pathToTabImage: './images/log_top_tab.png',          //path to the image for the tab (optionaly can be set using css)
		imageHeight: '34px',                               //height of tab image
		imageWidth: '125px',                               //width of tab image    
		tabLocation: 'top',                               //side of screen where tab lives, top, right, bottom, or left
		speed: 300,                                        //speed of animation
		action: 'click',                                   //options: 'click' or 'hover', action to trigger animation
		topPos: '0px',                                   //position from the top
		leftPos: '0px',                                   //position from the left
		fixedPosition: false                               //options: true makes it stick(fixed position) on scroll
	});
	
	$("textarea").tabby();
	
<?php if(file_exists(LOG)&&filesize(LOG)>1&&filesize(LOG)<((LOGMAX*1048576)+1)){ ?>
	$('.handle2').click(function() {
		$.ajax({
			url : "logfile.php?log=<?php echo LOG; ?>",
			dataType: "json",
			success: function(data){
				$("#log").val(data);
			}
		});
	});
<?php } ?>
});
</script>
</body>
</html>