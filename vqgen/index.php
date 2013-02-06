<?php
/**
 * vQmod XML Generator v3.2.1
 * 
 * Generate XML files for use with vQmod.
 * Built-in File Manager and Log Viewer.
 *
 * For further information please visit {@link http://www.vqmod.com/}
 * 
 * @author Simon Powers - UK Site Buidler Ltd <info@uksitebuilder.net> {@link http://uksb.github.com/vqgen/}
 * @copyright Copyright (c) 2013, UK Site Builder Ltd
 * @version $Id: index.php, v3.2.1 2013-02-05 22:30:00 sp Exp $
 * @license http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-ShareAlike 3.0 Unported License
 */

// Set the default file paths relative to this file
define('PASSWORD', ''); // secure this tool with a password - leave blank to skip the login screen (see install notes)
define('LOG', '../vqmod/logs/'); // relative location of vqmod log files folder
define('LOGMAX', 10); // max viewale size in MB of log file
define('PATH', '../vqmod/xml/'); // relative path to the vqmod xml folder
define('CACHE', '../vqmod/vqcache/'); // relative path to the vqmod cache folder
define('MODSCACHE', '../vqmod/mods.cache'); // relative path to the vqmod mods.cache file
define('NEWS', 'http://www.opencart.com/index.php?route=feature/blog/rss'); // Leave blank for UKSB News - Or add a URL to an RSS feed to use in the News tab in place of the default UKSB News - ie. http://www.opencart.com/index.php?route=feature/blog/rss

if(isset($_POST['login'])){
	if($_POST['password']==PASSWORD){
		setcookie('vqgenlogged','1');
		header("Location:./");
	}else{
		$error = 1;	
	}
}


include('language.php');

if(isset($_COOKIE['vqgenlogged'])||PASSWORD==''){
	if (!ini_get('date.timezone')) {
		date_default_timezone_set('UTC');
	}
	include('inc/functions.php');
	include('inc/actions.php');
	include('inc/files.php');
	include('inc/log.php');
	include('inc/cache.php');
}
?>
<!DOCTYPE HTML>
<head>
<meta charset="utf-8">
<title><?php echo PACKAGE_NAME; ?></title>
<meta name="author" content="Simon Powers, UK Site Builder Ltd, http://uksb.github.com/vqgen/">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<?php
if(!isset($_COOKIE['vqgenlogged'])&&PASSWORD!=''){
?>
<div style="width:400px; margin:200px auto 0 auto;">
<?php if(isset($error)){ ?><p class="remove"><?php echo LOGINFAIL; ?></p><?php } ?>
<form name="login" id="login" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<fieldset class="ma" style="width:400px;">
<legend><?php echo LOGIN; ?></legend>
	<label for="password"><?php echo LOGINPASSWORD; ?></label>
    <input id="password" name="password" type="password" style="width:200px;" value=""><br><br>
	<input type="submit" name="login" value="<?php echo LOGIN; ?>" style="margin:0 auto; font-size:2em; font-weight:bold;cursor:pointer;">
</fieldset>
</form>
</div>
<?php } else { ?>
<div class="ui-layout-center">
<?php
if(isset($_GET['generated'])){
?>
<p class="generate"><?php echo FILE_GENERATED . date("G:i"); ?></p>
<p><input id="add" class="button" type="button" value="<?php echo CREATE_NEW_FILE; ?>"></p>
<p><img src="images/enable.png" alt="" width="16" height="16" title="<?php echo ENABLE_THIS_VQMOD; ?>"> <input id="add3" class="button" type="button" value="<?php echo ENABLE_THIS_VQMOD; ?>"></p>
<?php	
}
?>
<h1><?php echo PACKAGE_NAME; ?></h1>
<?php echo OPENING_STATEMENT; ?>
<?php 
if(isset($_GET['file'])){
?>
<form name="generator" action="./" method="post">
<fieldset class="ma">
<legend><?php echo GENERAL_FILE_INFO; ?></legend>
	<label for="filename"><?php echo FILENAME; ?></label>
    <input id="filename" name="filename" type="text" onblur="$(this).val($(this).val().replace('.xml', ''))" style="width:400px;" value="<?php echo str_replace(".xml_", "", $_GET['file']); ?>">
    .xml <span class="help"><?php echo FILENAME_HELP; ?></span><br><br>
    
    <label for="fileid"><?php echo TITLE; ?></label>
    <input id="fileid" name="fileid" type="text" style="width:400px;" value="<?php echo preg_replace("/\r?\n/", "\\n", htmlentities($id['value'], ENT_QUOTES, 'UTF-8')); ?>"> <span class="help"><?php echo TITLE_HELP; ?></span><br><br>
    
    <label for="version"><?php echo FILE_VERSION; ?></label>
    <input id="version" name="version" type="text" style="width:50px;" value="<?php echo preg_replace("/\r?\n/", "\\n", htmlentities($version['value'], ENT_QUOTES, 'UTF-8')); ?>"> <span class="help"><?php echo FILE_VERSION_HELP; ?></span><br><br>
    
    <label for="vqmodver"><?php echo VQMOD_VERSION; ?></label>
    <input id="vqmodver" name="vqmodver" type="text" style="width:50px;" value="<?php echo preg_replace("/\r?\n/", "\\n", htmlentities($vqmver['value'], ENT_QUOTES, 'UTF-8')); ?>"> <span class="help"><?php echo VQMOD_VERSION_HELP; ?></span><br><br>
    
    <label for="author"><?php echo AUTHOR; ?></label>
    <input id="author" name="author" type="text" style="width:400px;" value="<?php echo preg_replace("/\r?\n/", "\\n", htmlentities($author['value'], ENT_QUOTES, 'UTF-8')); ?>"> <span class="help"><?php echo AUTHOR_HELP; ?></span>
    
</fieldset>

<div id="container"></div>
<div>
    <div id="actions">
        <p><input id="add2" class="button" type="button" value="<?php echo ADD_OPERATION; ?>"></p>
        <p><input id="add1" class="button" type="button" value="<?php echo ADD_FILE; ?>"></p>
        <p><input id="add" class="button" type="button" value="<?php echo START_OVER; ?>"></p>
    </div>
    <div id="generate">
    	<p><input type="submit" name="submit" value="<?php echo GENERATE_XML_FILE; ?>" id="dogen"><input type="hidden" name="generatexml" value="1"></p>
    </div>
    <div id="donate">
    	<p><a href="http://www.uksitebuilder.net/donation/"><img src="images/donate.png" alt="" width="64" height="64" title="<?php echo DONATE; ?>"></a></p>
    </div>
</div>
</form>
<?php
}
if(!isset($_POST['generatexml'])&&!isset($_GET['file'])){
?>
<h2><?php echo FILL_OUT_FORM; ?></h2>
<form name="generator" action="./" method="post">
<fieldset class="ma">
<legend><?php echo GENERAL_FILE_INFO; ?></legend>
	<label for="filename"><?php echo FILENAME; ?></label>
    <input id="filename" name="filename" type="text" onblur="$(this).val($(this).val().replace('.xml', ''))" style="width:400px;">
    .xml <span class="help"><?php echo FILENAME_HELP; ?></span><br><br>
    
    <label for="fileid"><?php echo TITLE; ?></label>
    <input id="fileid" name="fileid" type="text" style="width:400px;"> <span class="help"><?php echo TITLE_HELP; ?></span><br><br>
    
    <label for="version"><?php echo FILE_VERSION; ?></label>
    <input id="version" name="version" type="text" style="width:50px;" value=""> <span class="help"><?php echo FILE_VERSION_HELP; ?></span><br><br>
    
    <label for="vqmodver"><?php echo VQMOD_VERSION; ?></label>
    <input id="vqmodver" name="vqmodver" type="text" style="width:50px;" value=""> <span class="help"><?php echo VQMOD_VERSION_HELP; ?></span><br><br>
    
    <label for="author"><?php echo AUTHOR; ?></label>
    <input id="author" name="author" type="text" style="width:400px;"> <span class="help"><?php echo AUTHOR_HELP; ?></span>
    
</fieldset>

<div id="container"></div>
<div>
    <div id="actions">
        <p><input id="add2" class="button" type="button" value="<?php echo ADD_OPERATION; ?>"></p>
        <p><input id="add1" class="button" type="button" value="<?php echo ADD_FILE; ?>"></p>
        <p><input id="add" class="button" type="button" value="<?php echo START_OVER; ?>"></p>
    </div>
    <div id="generate">
        <p><input type="submit" name="submit" value="<?php echo GENERATE_XML_FILE; ?>" id="dogen"><input type="hidden" name="generatexml" value="1"></p>
    </div>
    <div id="donate">
    	<p><a href="http://www.uksitebuilder.net/donation/"><img src="images/donate.png" alt="" width="64" height="64" title="<?php echo DONATE; ?>"></a></p>
    </div>
</div>
</form>
<?php
}
?>

<div class="slide-out-div3">
<a class="handle3" href="#"><?php echo CONTENT; ?></a>
<h3><?php echo VQMOD_CACHE_FILES; ?></h3> <a href="./?clearvqcache=1"><?php echo CLEAR_VQMOD_CACHE; ?></a> <a href="./?clearmodscache=1"><?php echo CLEAR_MODS_CACHE; ?></a><br><br>
<?php if(isset($_GET['cleared'])&&$_GET['cleared']=='modscache'){ ?><span class="message"><?php echo CLEARED_MODSCACHE; ?></span><br><br><?php } ?>
<?php if(isset($_GET['cleared'])&&$_GET['cleared']=='vqcache'){ ?><span class="message"><?php echo CLEARED_VQCACHE; ?></span><br><br><?php } ?>
<?php if(isset($_GET['cleared'])&&substr($_GET['cleared'], 0, 11)=='vqcachefile'){ ?><span class="message"><?php echo sprintf(CLEARED_VQCACHEFILE, substr($_GET['cleared'], 12, (strlen($_GET['cleared'])-12))); ?></span><br><br><?php } ?>
<b><?php echo CACHE_FILES; ?></b> <select name="file_list" id="file_list">
<option value=""><?php echo CHOOSE_ONE; ?></option>
<?php if(count(cache_list(CACHE))){ ?>
<optgroup label="vqmod/vqcache/">
 <?php foreach(cache_list(CACHE) as $val){ ?>
 <option value="<?php echo $val; ?>"<?php if($val == $_GET['vqcachefile']){ ?> selected="selected"<?php } ?>><?php echo $val; ?></option>
<?php } ?>
</optgroup>
<?php } ?>
<optgroup label="vqmod/">
 <option value="mods.cache"<?php if('mods.cache' == $_GET['vqcachefile']){ ?> selected="selected"<?php } ?>>mods.cache</option>
</optgroup>
</select><?php if(isset($_GET['vqcachefile'])&&$_GET['vqcachefile']!=''&&$_GET['vqcachefile']!='mods.cache'){ ?> <a href="./?deletevqcachefile=<?php echo $_GET['vqcachefile']; ?>"><img src="images/delete.png" width="16" height="16" alt="" title="<?php echo DELETE; ?>"></a><?php } ?><br><br>

<textarea id="cache" readonly><?php echo $cache; ?></textarea>
</div>

<div class="slide-out-div2">
<a class="handle2" href="#"><?php echo CONTENT; ?></a>
<h3><?php echo VQMOD_LOG_FILES; ?></h3> <a href="./?clearlogs=1"><?php echo CLEAR_VQMOD_LOGS; ?></a> <a href="./?clearlog=1"><?php echo CLEAR_THIS_LOG; ?></a><br><br>
<?php if(isset($_GET['handle2'])&&$_GET['handle2']=='alllogs'){ ?><span class="message"><?php echo CLEARED_ALL_LOGS; ?></span><br><br><?php } ?>
<?php if(isset($_GET['handle2'])&&$_GET['handle2']!='alllogs'){ ?><span class="message"><?php echo sprintf(CLEARED_LOG_FILE, $_GET['handle2']); ?></span><br><br><?php } ?>
<textarea id="log" readonly><?php echo $log; ?></textarea>
</div>

<div class="slide-out-div">
<a class="handle" href="#"><?php echo CONTENT; ?></a>
<?php if(isset($_GET['handle1'])&&substr($_GET['handle1'], 0, 7)=='deleted'){ ?><span class="message"><?php echo sprintf(VQMOD_FILE_DELETED, substr($_GET['handle1'], 8, (strlen($_GET['handle1'])-8))); ?></span><br><br><?php } 
elseif(isset($_GET['handle1'])&&$_GET['handle1']=='enabledall'){ ?><span class="message"><?php echo VQMOD_FILES_ENABLED; ?></span><br><br><?php }
elseif(isset($_GET['handle1'])&&substr($_GET['handle1'], 0, 7)=='enabled'){ ?><span class="message"><?php echo sprintf(VQMOD_FILE_ENABLED, rtrim(substr($_GET['handle1'], 8, (strlen($_GET['handle1'])-8)),'_')); ?></span><br><br><?php } 
elseif(isset($_GET['handle1'])&&$_GET['handle1']=='disabledall'){ ?><span class="message"><?php echo VQMOD_FILES_DISABLED; ?></span><br><br><?php }
elseif(isset($_GET['handle1'])&&substr($_GET['handle1'], 0, 8)=='disabled'){ ?><span class="message"><?php echo sprintf(VQMOD_FILE_DISABLED, substr($_GET['handle1'], 9, (strlen($_GET['handle1'])-9))); ?></span><br><br><?php } ?>
<?php
if(isset($inactivevqmods)&&count($inactivevqmods)>0){ ?>
    <h3><?php echo VQMOD_FILES_INACTIVE; ?></h3>
    <p><span class="help"><?php echo DELETE_VQMOD_CACHE; ?></span></p>
    <table>
    <tr><td class="row2" colspan="2" style="text-align:right;"><a href="./?enableall=1"><img src="images/enable.png" width="16" height="16" alt="" title="<?php echo ENABLE_ALL; ?>"></a> <?php echo ENABLE_ALL; ?></td></tr>
    <tr><th scope="col"><?php echo TH_FILENAME; ?></th><th scope="col"><?php echo TH_ACTION; ?></th></tr>
<?php
	$row = '';
	foreach($inactivevqmods as $av){
		$row = ($row == 'row2'?'row1':'row2'); ?>
        <tr>
            <td class="<?php echo $row; ?>">
                <p style="margin:0;"><span class="help"><?php echo $av['file']; ?></span>
                <br><?php if($av['id']!='') { echo $av['id']; ?>
                <br><?php } if($av['version']!='') { ?><span class="help"><?php echo VER; ?></span> <?php echo $av['version']; } if($av['vqmver']!=''){ ?> <span class="help"><?php echo VQMOD; ?></span> <?php echo $av['vqmver']; } if($av['size']!=''){ ?> <span class="help"><?php echo SIZE; ?></span> <?php echo $av['size']; } ?> <span class="help"><?php echo DATE; ?></span> <?php echo $av['date']; ?>
                <?php if($av['author']!=''){ ?><br><span class="help"><?php echo VQMOD_AUTHOR; ?></span> <?php echo $av['author']; } ?></p>
            </td>
            <td class="<?php echo $row; ?> actions">
            	<a href="./?file=<?php echo $av['file'].'_'; ?>"><img src="images/edit.png" width="16" height="16" alt="" title="<?php echo EDIT; ?>"></a> <a href="./?enable=<?php echo $av['file'].'_'; ?>"><img src="images/enable.png" width="16" height="16" alt="" title="<?php echo ENABLE; ?>"></a> <a href="./?get=<?php echo $av['file'].'_'; ?>"><img src="images/get.png" width="16" height="16" title="<?php echo GET; ?>" alt=""></a> <a href="./?delete=<?php echo $av['file'].'_'; ?>" onclick="return confirm('<?php echo DELETE_CONFIRM . $av['file']; ?>');"><img src="images/delete.png" width="16" height="16" alt="" title="<?php echo DELETE; ?>"></a>
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
    <h3><?php echo VQMOD_FILES_ACTIVE; ?></h3>
    <p><span class="help"><?php echo DISABLE_VQMOD_CACHE; ?></span></p>
    <table>
    <tr><td class="row2" colspan="2" style="text-align:right;"><a href="./?disableall=1"><img src="images/disable.png" width="16" height="16" alt="" title="<?php echo DISABLE_ALL; ?>"></a> <?php echo DISABLE_ALL; ?></td></tr>
    <tr><th scope="col"><?php echo TH_FILENAME; ?></th><th scope="col"><?php echo TH_ACTION; ?></th></tr>
<?php
	$row = '';
	foreach($activevqmods as $av){
		$row = ($row == 'row2'?'row1':'row2'); ?>
        <tr>
            <td class="<?php echo $row; ?>">
                <p style="margin:0;"><span class="help"><?php echo $av['file']; ?></span>
                <br><?php if($av['id']!='') { echo $av['id']; ?>
                <br><?php } if($av['version']!='') { ?><span class="help"><?php echo VER; ?></span> <?php echo $av['version']; } if($av['vqmver']!=''){ ?> <span class="help"><?php echo VQMOD; ?></span> <?php echo $av['vqmver']; } if($av['size']!=''){ ?> <span class="help"><?php echo SIZE; ?></span> <?php echo $av['size']; } ?> <span class="help"><?php echo DATE; ?></span> <?php echo $av['date']; ?>
                <?php if($av['author']!=''){ ?><br><span class="help"><?php echo VQMOD_AUTHOR; ?></span> <?php echo $av['author']; } ?></p>
            </td>
            <td class="<?php echo $row; ?> actions">
                <a href="./?file=<?php echo $av['file']; ?>"><img src="images/edit.png" width="16" height="16" alt="" title="<?php echo EDIT; ?>"></a> <a href="./?disable=<?php echo $av['file']; ?>"><img src="images/disable.png" width="16" height="16" alt="" title="<?php echo DISABLE; ?>"></a> <a href="./?get=<?php echo $av['file']; ?>"><img src="images/get.png" width="16" height="16" title="<?php echo GET; ?>" alt=""></a> <a href="./?delete=<?php echo $av['file']; ?>" onclick="return confirm('<?php echo DELETE_CONFIRM . $av['file']; ?>');"><img src="images/delete.png" width="16" height="16" alt="" title="<?php echo DELETE; ?>"></a>
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

<div class="news">
<a class="handlenews" href="#"><?php echo CONTENT; ?></a>
<div id="news"><?php echo LOADING; ?></div>
</div>

<div id="footer">&copy; Copyright <?php echo (date("Y")>2011?'2011 - ':'') . date("Y"); ?> <a href="http://www.uksitebuilder.net/">UK Site Builder Ltd</a> - Get More Great vQmod Extensions at <a href="http://www.opencart-extensions.co.uk/">OpenCart-Extensions.co.uk</a><br><a href="http://uksb.github.com/vqgen/" >vQmod Generator by UK Site Builder Ltd</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/">Creative Commons Attribution-ShareAlike 3.0 Unported License</a></div>
<script src="js/jquery-1.9.0.min.js"></script>
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
	x += "<div class=\"file\">";
	x += "\n\t<fieldset id=\"filefieldset_" + <?php echo $idx; ?> + "\" class=\"fi\">";
	x += "\n\t<legend><?php echo FILE_TO_EDIT; ?></legend>";
	x += "\n\t\t<label for=\"path_" + <?php echo $idx; ?> + "\"><?php echo PATH_TO_FILENAMES; ?></label>";
	x += "\n\t\t<input id=\"path_" + <?php echo $idx; ?> + "\" name=\"path[" + <?php echo $idx; ?> + "]\" type=\"text\" style=\"width:750px;\" value=\"<?php echo preg_replace("/\r?\n/", "\\n", htmlentities(addslashes($f['attributes']['path']), ENT_QUOTES, 'UTF-8')); ?>\"><br><br>"; 
	x += "\n\t\t<label for=\"file_" + <?php echo $idx; ?> + "\"><?php echo FILENAMES; ?></label>";
	x += "\n\t\t<input id=\"file_" + <?php echo $idx; ?> + "\" name=\"file[" + <?php echo $idx; ?> + "]\" type=\"text\" style=\"width:750px;\" value=\"<?php echo preg_replace("/\r?\n/", "\\n", htmlentities(addslashes($f['attributes']['name']), ENT_QUOTES, 'UTF-8')); ?>\"><br><br>"; 
	x += "\n\t\t<div class=\"delete\"><?php echo REMOVE_ON_GENERATE; ?> <input id=\"remove_" + <?php echo $idx; ?> + "\" name=\"remove_" + <?php echo $idx; ?> + "\" type=\"checkbox\" value=\"1\" onclick=\"if($('#remove_" + <?php echo $idx; ?> + "').is(':checked')){ $('input[id^=remove_" + <?php echo $idx; ?> + "_]').attr('checked','checked').attr('disabled','disabled'); } else { $('input[id^=remove_" + <?php echo $idx; ?> + "_]').removeAttr('checked').removeAttr('disabled'); }\"></div>";
	x += "\n\t</fieldset>";
	
	<?php 
	foreach($f['value'] as $op){
	$arkey=0;
	// Check to see if IGNOREIF exists /Backwards comaptibility
	$add = ($op['value'][1]['tag']=='add'?1:2);
	$igif = ($op['value'][1]['tag']=='ignoreif'?1:2);
	?>
		x += "\n\t<div class=\"operation\">";    
		x += "\n\t\t<fieldset id=\"operationfieldset_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" class=\"op\">";
		x += "\n\t\t<legend><?php echo OPERATION_TO_PERFORM; ?></legend>";
		x += "\n\t\t\t<label for=\"info_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\"><?php echo INFO; ?><br><span class=\"help\"><?php echo INFO_ASSIST; ?></span></label>";
		x += "\n\t\t\t<input id=\"info_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" name=\"info[" + <?php echo $idx; ?> + "][" + <?php echo $idx2; ?> + "]\" type=\"text\" style=\"width:750px;margin-bottom:10px;\" value=\"<?php echo preg_replace("/\r?\n/", "\\n", htmlentities(addslashes($op['attributes']['info']), ENT_QUOTES, 'UTF-8')); ?>\"><br><br>";
		x += "\n\t\t\t<label for=\"search_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\"><?php echo SEARCH; ?><br><span class=\"help\"><?php echo SEARCH_ASSIST; ?></span></label>";
		x += "\n\t\t\t<input id=\"search_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" name=\"search[" + <?php echo $idx; ?> + "][" + <?php echo $idx2; ?> + "]\" type=\"text\" style=\"width:750px;margin-bottom:10px;\" value=\"<?php echo preg_replace("/\r?\n/", "\\n", htmlentities(addslashes($op['value'][$arkey]['value']), ENT_QUOTES, 'UTF-8')); ?>\"><br><br>";
		x += "\n\t\t\t<label for=\"position_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\"><?php echo POSITION; ?></label>";
		x += "\n\t\t\t<select id=\"position_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" name=\"position[" + <?php echo $idx; ?> + "][" + <?php echo $idx2; ?> + "]\">";
		x += "\n\t\t\t\t<option value=\"replace\"<?php if($op['value'][$arkey]['attributes']['position']=='replace'){ ?> selected=\"selected\"<?php } ?>><?php echo REPLACE; ?></option>";
		x += "\n\t\t\t\t<option value=\"before\"<?php if($op['value'][$arkey]['attributes']['position']=='before'){ ?> selected=\"selected\"<?php } ?>><?php echo BEFORE; ?></option>";
		x += "\n\t\t\t\t<option value=\"after\"<?php if($op['value'][$arkey]['attributes']['position']=='after'){ ?> selected=\"selected\"<?php } ?>><?php echo AFTER; ?></option>";
		x += "\n\t\t\t\t<option value=\"top\"<?php if($op['value'][$arkey]['attributes']['position']=='top'){ ?> selected=\"selected\"<?php } ?>><?php echo TOP; ?></option>";
		x += "\n\t\t\t\t<option value=\"bottom\"<?php if($op['value'][$arkey]['attributes']['position']=='bottom'){ ?> selected=\"selected\"<?php } ?>><?php echo BOTTOM; ?></option>";
		x += "\n\t\t\t\t<option value=\"all\"<?php if($op['value'][$arkey]['attributes']['position']=='all'){ ?> selected=\"selected\"<?php } ?>><?php echo ALL; ?></option>";
		x += "\n\t\t\t</select>";
		x += "\n\t\t\t<span class=\"help\"><?php echo POSITION_HELP; ?></span><br><br>";
		x += "\n\t\t\t<label for=\"offset_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\"><?php echo OFFSET; ?><br><span class=\"help\"><?php echo OFFSET_ASSIST; ?></span></label>";
		x += "\n\t\t\t<input id=\"offset_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" name=\"offset[" + <?php echo $idx; ?> + "][" + <?php echo $idx2; ?> + "]\" type=\"text\" style=\"width:40px;margin-bottom:10px;\" value=\"<?php echo $op['value'][$arkey]['attributes']['offset']; ?>\"> <span class=\"help\"><?php echo OFFSET_HELP; ?></span><br><br>";
		x += "\n\t\t\t<label for=\"index_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\"><?php echo INDEX; ?><br><span class=\"help\"><?php echo INDEX_ASSIST; ?></span></label>";
		x += "\n\t\t\t<input id=\"index_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" name=\"index[" + <?php echo $idx; ?> + "][" + <?php echo $idx2; ?> + "]\" type=\"text\" style=\"width:60px;margin-bottom:10px;\" value=\"<?php echo $op['value'][$arkey]['attributes']['index']; ?>\"> <span class=\"help\"><?php echo INDEX_HELP; ?></span><br><br>";
		x += "\n\t\t\t<label for=\"error_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\"><?php echo ERROR; ?><br><span class=\"help\"><?php echo ERROR_ASSIST; ?></span></label>";
		x += "\n\t\t\t<select id=\"error_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" name=\"error[" + <?php echo $idx; ?> + "][" + <?php echo $idx2; ?> + "]\">";
		x += "\n\t\t\t\t<option value=\"abort\"<?php if(!isset($op['value'][$arkey]['attributes']['error'])){ ?> selected=\"selected\"<?php } ?>><?php echo ABORT_LOG; ?></option>";
		x += "\n\t\t\t\t<option value=\"log\"<?php if($op['value'][$arkey]['attributes']['error']=='log'){ ?> selected=\"selected\"<?php } ?>><?php echo SKIP_LOG; ?></option>";
		x += "\n\t\t\t\t<option value=\"skip\"<?php if($op['value'][$arkey]['attributes']['error']=='skip'){ ?> selected=\"selected\"<?php } ?>><?php echo SKIP_NO_LOG; ?></option>";
		x += "\n\t\t\t</select> <span class=\"help\"><?php echo ERROR_HELP; ?></span><br><br>";
		x += "\n\t\t\t<label for=\"regex_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\"><?php echo REGEX; ?><br><span class=\"help\"><?php echo REGEX_ASSIST; ?></span></label>";
		x += "\n\t\t\t<select id=\"regex_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" name=\"regex[" + <?php echo $idx; ?> + "][" + <?php echo $idx2; ?> + "]\">";
		x += "\n\t\t\t\t<option value=\"false\"<?php if(!isset($op['value'][$arkey]['attributes']['regex'])){ ?> selected=\"selected\"<?php } ?>><?php echo ISFALSE; ?></option>";
		x += "\n\t\t\t\t<option value=\"true\"<?php if($op['value'][$arkey]['attributes']['regex']=='true'){ ?> selected=\"selected\"<?php } ?>><?php echo ISTRUE; ?></option>";
		x += "\n\t\t\t</select>";
		x += "\n\t\t\t<span class=\"help\"><?php echo REGEX_HELP; ?></span><br><br>";
		x += "\n\t\t\t<textarea id=\"add_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" name=\"add[" + <?php echo $idx; ?> + "][" + <?php echo $idx2; ?> + "]\" style=\"width:940px;height:240px;\"><?php echo preg_replace("/\r?\n/", "\\n", htmlentities(addslashes($op['value'][$arkey+$add]['value']), ENT_QUOTES, 'UTF-8')); ?></textarea><br><br>";
		x += "\n\t\t\t<label for=\"ignoreif_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\"><?php echo IGNOREIF; ?><br><span class=\"help\"><?php echo IGNOREIF_ASSIST; ?></span></label>";
		x += "\n\t\t\t<input id=\"ignoreif_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" name=\"ignoreif[" + <?php echo $idx; ?> + "][" + <?php echo $idx2; ?> + "]\" type=\"text\" style=\"width:750px;margin-bottom:10px;\" value=\"<?php echo preg_replace("/\r?\n/", "\\n", htmlentities(addslashes($op['value'][$arkey+$igif]['value']), ENT_QUOTES, 'UTF-8')); ?>\"><br><br>";
		x += "\n\t\t\t<label for=\"regex_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\"><?php echo REGEX; ?><br><span class=\"help\"><?php echo REGEX_ASSIST; ?></span></label>";
		x += "\n\t\t\t<select id=\"igregex_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" name=\"igregex[" + <?php echo $idx; ?> + "][" + <?php echo $idx2; ?> + "]\">";
		x += "\n\t\t\t\t<option value=\"false\"<?php if(!isset($op['value'][$arkey+$igif]['attributes']['regex'])){ ?> selected=\"selected\"<?php } ?>><?php echo ISFALSE; ?></option>";
		x += "\n\t\t\t\t<option value=\"true\"<?php if($op['value'][$arkey+$igif]['attributes']['regex']=='true'){ ?> selected=\"selected\"<?php } ?>><?php echo ISTRUE; ?></option>";
		x += "\n\t\t\t</select>";
		x += "\n\t\t\t<span class=\"help\"><?php echo IGREGEX_HELP; ?></span><br><br>";
		x += "\n\t\t\t<div class=\"delete\">Remove on Generate <input id=\"remove_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" name=\"remove_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" type=\"checkbox\" value=\"1\" onclick=\"if($('input[id^=remove_" + <?php echo $idx; ?> + "_]').not(':checked').length===0){ $('#remove_" + <?php echo $idx; ?> + "').attr('checked','checked'); $('input[id^=remove_" + <?php echo $idx; ?> + "_]').attr('disabled','disabled'); }\"></div>";
		x += "\n\t\t\t<div class=\"delete\"><?php echo ADD; ?> <select id=\"newop_" + <?php echo $idx; ?> + "_" + <?php echo $idx2; ?> + "\" name=\"newop[" + <?php echo $idx; ?> + "][" + <?php echo $idx2; ?> + "]\">";
		x += "\n\t\t\t\t<option value=\"0\" selected=\"selected\">0</option>";
		x += "\n\t\t\t\t<option value=\"1\">1</option>";
		x += "\n\t\t\t\t<option value=\"2\">2</option>";
		x += "\n\t\t\t\t<option value=\"3\">3</option>";
		x += "\n\t\t\t</select> <?php echo NEW_OPERATIONS; ?> <span class=\"gen\">[<?php echo NOW; ?>]</span></div>";
		x += "\n\t\t</fieldset>";
		x += "\n\t</div>";
<?php
		$idx2++;
	}
	$idx++;
?>
		x += "\n</div>";
<?php
}
?>
	$("#container").append(x);
	var idx = <?php echo $idx-1; ?>;
	var idx2 = <?php echo $idx2-1; ?>;
	
	$("#add1").click(function() {
		idx ++;
		idx2 ++;
		
		var x = "\n<div class=\"file\">";
		x += "\n\t<fieldset id=\"filefieldset_" + idx + "\" class=\"fi\">";
		x += "\n\t<legend>File to edit</legend>";
		x += "\n\t\t<label for=\"path_" + idx + "\"><?php echo PATH_TO_FILENAMES; ?></label>";
		x += "\n\t\t<input id=\"path_" + idx + "\" name=\"path[" + idx + "]\" type=\"text\" style=\"width:750px;\"><br><br>"; 
		x += "\n\t\t<label for=\"file_" + idx + "\"><?php echo FILENAMES; ?></label>";
		x += "\n\t\t<input id=\"file_" + idx + "\" name=\"file[" + idx + "]\" type=\"text\" style=\"width:750px;\"><br><br>"; 
		x += "\n\t\t<!-- <a onclick=\"idx = idx - 1; $(this).parent().parent().slideUp(function(){ $(this).remove() }); return false\"><span class=\"remove\">Remove</span></a> //-->";
		x += "\n\t\t<div class=\"delete\"><?php echo REMOVE_ON_GENERATE; ?> <input id=\"remove_" + idx + "\" name=\"remove_" + idx + "\" type=\"checkbox\" value=\"1\" onclick=\"if($('#remove_" + idx + "').is(':checked')){ $('input[id^=remove_" + idx + "_]').attr('checked','checked').attr('disabled','disabled'); } else { $('input[id^=remove_" + idx + "_]').removeAttr('checked').removeAttr('disabled'); }\"></div>";
		x += "\n\t</fieldset>";
		x += "\n\t<div class=\"operation\">";    
		x += "\n\t\t<fieldset id=\"operationfieldset_" + idx + "_" + idx2 + "\" class=\"op\">";
		x += "\n\t\t<legend><?php echo OPERATION_TO_PERFORM; ?></legend>";
		x += "\n\t\t\t<label for=\"info_" + idx + "_" + idx2 + "\"><?php echo INFO; ?><br><span class=\"help\"><?php echo INFO_ASSIST; ?></span></label>";
		x += "\n\t\t\t<input id=\"info_" + idx + "_" + idx2 + "\" name=\"info[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:750px;margin-bottom:10px;\"><br><br>";
		x += "\n\t\t\t<label for=\"search_" + idx + "_" + idx2 + "\"><?php echo SEARCH; ?><br><span class=\"help\"><?php echo SEARCH_ASSIST; ?></span></label>";
		x += "\n\t\t\t<input id=\"search_" + idx + "_" + idx2 + "\" name=\"search[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:750px;margin-bottom:10px;\"><br><br>";
		x += "\n\t\t\t<label for=\"position_" + idx + "_" + idx2 + "\"><?php echo POSITION; ?></label>";
		x += "\n\t\t\t<select id=\"position_" + idx + "_" + idx2 + "\" name=\"position[" + idx + "][" + idx2 + "]\">";
		x += "\n\t\t\t\t<option value=\"replace\" selected=\"selected\"><?php echo REPLACE; ?></option>";
		x += "\n\t\t\t\t<option value=\"before\"><?php echo BEFORE; ?></option>";
		x += "\n\t\t\t\t<option value=\"after\"><?php echo AFTER; ?></option>";
		x += "\n\t\t\t\t<option value=\"top\"><?php echo TOP; ?></option>";
		x += "\n\t\t\t\t<option value=\"bottom\"><?php echo BOTTOM; ?></option>";
		x += "\n\t\t\t\t<option value=\"all\"><?php echo ALL; ?></option>";
		x += "\n\t\t\t</select>";
		x += "\n\t\t\t<span class=\"help\"><?php echo POSITION_HELP; ?></span><br><br>";
		x += "\n\t\t\t<label for=\"offset_" + idx + "_" + idx2 + "\"><?php echo OFFSET; ?><br><span class=\"help\"><?php echo OFFSET_ASSIST; ?></span></label>";
		x += "\n\t\t\t<input id=\"offset_" + idx + "_" + idx2 + "\" name=\"offset[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:40px;margin-bottom:10px;\"> <span class=\"help\"><?php echo OFFSET_HELP; ?></span><br><br>";
		x += "\n\t\t\t<label for=\"index_" + idx + "_" + idx2 + "\"><?php echo INDEX; ?><br><span class=\"help\"><?php echo INDEX_ASSIST; ?></span></label>";
		x += "\n\t\t\t<input id=\"index_" + idx + "_" + idx2 + "\" name=\"index[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:60px;margin-bottom:10px;\"> <span class=\"help\"><?php echo INDEX_HELP; ?></span><br><br>";
		x += "\n\t\t\t<label for=\"error_" + idx + "_" + idx2 + "\"><?php echo ERROR; ?><br><span class=\"help\"><?php echo ERROR_ASSIST; ?></span></label>";
		x += "\n\t\t\t<select id=\"error_" + idx + "_" + idx2 + "\" name=\"error[" + idx + "][" + idx2 + "]\">";
		x += "\n\t\t\t\t<option value=\"abort\" selected=\"selected\"><?php echo ABORT_LOG; ?></option>";
		x += "\n\t\t\t\t<option value=\"log\"><?php echo SKIP_LOG; ?></option>";
		x += "\n\t\t\t\t<option value=\"skip\"><?php echo SKIP_NO_LOG; ?></option>";
		x += "\n\t\t\t</select> <span class=\"help\"><?php echo ERROR_HELP; ?></span><br><br>";
		x += "\n\t\t\t<label for=\"regex_" + idx + "_" + idx2 + "\"><?php echo REGEX; ?><br><span class=\"help\"><?php echo REGEX_ASSIST; ?></span></label>";
		x += "\n\t\t\t<select id=\"regex_" + idx + "_" + idx2 + "\" name=\"regex[" + idx + "][" + idx2 + "]\">";
		x += "\n\t\t\t\t<option value=\"false\" selected=\"selected\"><?php echo ISFALSE; ?></option>";
		x += "\n\t\t\t\t<option value=\"true\"><?php echo ISTRUE; ?></option>";
		x += "\n\t\t\t</select>";
		x += "\n\t\t\t<span class=\"help\"><?php echo REGEX_HELP; ?></span><br><br>";
		x += "\n\t\t\t<textarea id=\"add_" + idx + "_" + idx2 + "\" name=\"add[" + idx + "][" + idx2 + "]\" style=\"width:940px;height:240px;\"></textarea><br><br>";
		x += "\n\t\t\t<label for=\"ignoreif_" + idx + "_" + idx2 + "\"><?php echo IGNOREIF; ?><br><span class=\"help\"><?php echo IGNOREIF_ASSIST; ?></span></label>";
		x += "\n\t\t\t<input id=\"ignoreif_" + idx + "_" + idx2 + "\" name=\"ignoreif[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:750px;margin-bottom:10px;\"><br><br>";
		x += "\n\t\t\t<label for=\"igregex_" + idx + "_" + idx2 + "\"><?php echo REGEX; ?><br><span class=\"help\"><?php echo REGEX_ASSIST; ?></span></label>";
		x += "\n\t\t\t<select id=\"igregex_" + idx + "_" + idx2 + "\" name=\"igregex[" + idx + "][" + idx2 + "]\">";
		x += "\n\t\t\t\t<option value=\"false\" selected=\"selected\"><?php echo ISFALSE; ?></option>";
		x += "\n\t\t\t\t<option value=\"true\"><?php echo ISTRUE; ?></option>";
		x += "\n\t\t\t</select>";
		x += "\n\t\t\t<span class=\"help\"><?php echo IGREGEX_HELP; ?></span><br><br>";
		x += "\n\t\t\t<div class=\"delete\"><?php echo REMOVE_ON_GENERATE; ?> <input id=\"remove_" + idx + "_" + idx2 + "\" name=\"remove_" + idx + "_" + idx2 + "\" type=\"checkbox\" value=\"1\" onclick=\"if($('input[id^=remove_" + idx + "_]').not(':checked').length===0){ $('#remove_" + idx + "').attr('checked','checked'); $('input[id^=remove_" + idx + "_]').attr('disabled','disabled'); }\"></div>";
		x += "\n\t\t\t<div class=\"delete\"><?php echo ADD; ?> <select id=\"newop_" + idx + "_" + idx2 + "\" name=\"newop[" + idx + "][" + idx2 + "]\">";
		x += "\n\t\t\t\t<option value=\"0\" selected=\"selected\">0</option>";
		x += "\n\t\t\t\t<option value=\"1\">1</option>";
		x += "\n\t\t\t\t<option value=\"2\">2</option>";
		x += "\n\t\t\t\t<option value=\"3\">3</option>";
		x += "\n\t\t\t</select> <?php echo NEW_OPERATIONS; ?> <span class=\"gen\">[<?php echo NOW; ?>]</span></div>";
		x += "\n\t\t</fieldset>";
		x += "\n\t</div>";
		x += "\n</div>";
		
		$("#container").append(x);
		var $elem = $('body');
		$('html, body').animate({scrollTop: $elem.height()}, 800);
	});
	
	$("#add2").click(function() {
		if($('#remove_' + idx ).is(':checked')){
			alert('<?php echo CLEAR_REMOVE_ON_GENERATE; ?>');
		}else{
			idx2 ++;
			
			var x = "\n\t<div class=\"operation\">";    
			x += "\n\t\t<fieldset id=\"operationfieldset_" + idx + "_" + idx2 + "\" class=\"op\">";
			x += "\n\t\t<legend><?php echo OPERATION_TO_PERFORM; ?></legend>";
			x += "\n\t\t\t<label for=\"info_" + idx + "_" + idx2 + "\"><?php echo INFO; ?><br><span class=\"help\"><?php echo INFO_ASSIST; ?></span></label>";
			x += "\n\t\t\t<input id=\"info_" + idx + "_" + idx2 + "\" name=\"info[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:750px;margin-bottom:10px;\"><br><br>";
			x += "\n\t\t\t<label for=\"search_" + idx + "_" + idx2 + "\"><?php echo SEARCH; ?><br><span class=\"help\"><?php echo SEARCH_ASSIST; ?></span></label>";
			x += "\n\t\t\t<input id=\"search_" + idx + "_" + idx2 + "\" name=\"search[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:750px;margin-bottom:10px;\"><br><br>";
			x += "\n\t\t\t<label for=\"position_" + idx + "_" + idx2 + "\"><?php echo POSITION; ?></label>";
			x += "\n\t\t\t<select id=\"position_" + idx + "_" + idx2 + "\" name=\"position[" + idx + "][" + idx2 + "]\">";
			x += "\n\t\t\t\t<option value=\"replace\" selected=\"selected\"><?php echo REPLACE; ?></option>";
			x += "\n\t\t\t\t<option value=\"before\"><?php echo BEFORE; ?></option>";
			x += "\n\t\t\t\t<option value=\"after\"><?php echo AFTER; ?></option>";
			x += "\n\t\t\t\t<option value=\"top\"><?php echo TOP; ?></option>";
			x += "\n\t\t\t\t<option value=\"bottom\"><?php echo BOTTOM; ?></option>";
			x += "\n\t\t\t\t<option value=\"all\"><?php echo ALL; ?></option>";
			x += "\n\t\t\t</select>";
			x += "\n\t\t\t<span class=\"help\"><?php echo POSITION_HELP; ?></span><br><br>";
			x += "\n\t\t\t<label for=\"offset_" + idx + "_" + idx2 + "\"><?php echo OFFSET; ?><br><span class=\"help\"><?php echo OFFSET_ASSIST; ?></span></label>";
			x += "\n\t\t\t<input id=\"offset_" + idx + "_" + idx2 + "\" name=\"offset[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:40px;margin-bottom:10px;\"> <span class=\"help\"><?php echo OFFSET_HELP; ?></span><br><br>";
			x += "\n\t\t\t<label for=\"index_" + idx + "_" + idx2 + "\"><?php echo INDEX; ?><br><span class=\"help\"><?php echo INDEX_ASSIST; ?></span></label>";
			x += "\n\t\t\t<input id=\"index_" + idx + "_" + idx2 + "\" name=\"index[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:60px;margin-bottom:10px;\"> <span class=\"help\"><?php echo INDEX_HELP; ?></span><br><br>";
			x += "\n\t\t\t<label for=\"error_" + idx + "_" + idx2 + "\"><?php echo ERROR; ?><br><span class=\"help\"><?php echo ERROR_ASSIST; ?></span></label>";
			x += "\n\t\t\t<select id=\"error_" + idx + "_" + idx2 + "\" name=\"error[" + idx + "][" + idx2 + "]\">";
			x += "\n\t\t\t\t<option value=\"abort\" selected=\"selected\"><?php echo ABORT_LOG; ?></option>";
			x += "\n\t\t\t\t<option value=\"log\"><?php echo SKIP_LOG; ?></option>";
			x += "\n\t\t\t\t<option value=\"skip\"><?php echo SKIP_NO_LOG; ?></option>";
			x += "\n\t\t\t</select> <span class=\"help\"><?php echo ERROR_HELP; ?></span><br><br>";
			x += "\n\t\t\t<label for=\"regex_" + idx + "_" + idx2 + "\"><?php echo REGEX; ?><br><span class=\"help\"><?php echo REGEX_ASSIST; ?></span></label>";
			x += "\n\t\t\t<select id=\"regex_" + idx + "_" + idx2 + "\" name=\"regex[" + idx + "][" + idx2 + "]\">";
			x += "\n\t\t\t\t<option value=\"false\" selected=\"selected\"><?php echo ISFALSE; ?></option>";
			x += "\n\t\t\t\t<option value=\"true\"><?php echo ISTRUE; ?></option>";
			x += "\n\t\t\t</select>";
			x += "\n\t\t\t<span class=\"help\"><?php echo REGEX_HELP; ?></span><br><br>";
			x += "\n\t\t\t<textarea id=\"add_" + idx + "_" + idx2 + "\" name=\"add[" + idx + "][" + idx2 + "]\" style=\"width:940px;height:240px;\"></textarea><br><br>";
			x += "\n\t\t\t<label for=\"ignoreif_" + idx + "_" + idx2 + "\"><?php echo IGNOREIF; ?><br><span class=\"help\"><?php echo IGNOREIF_ASSIST; ?></span></label>";
			x += "\n\t\t\t<input id=\"ignoreif_" + idx + "_" + idx2 + "\" name=\"ignoreif[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:750px;margin-bottom:10px;\"><br><br>";
			x += "\n\t\t\t<label for=\"igregex_" + idx + "_" + idx2 + "\"><?php echo REGEX; ?><br><span class=\"help\"><?php echo REGEX_ASSIST; ?></span></label>";
			x += "\n\t\t\t<select id=\"igregex_" + idx + "_" + idx2 + "\" name=\"igregex[" + idx + "][" + idx2 + "]\">";
			x += "\n\t\t\t\t<option value=\"false\" selected=\"selected\"><?php echo ISFALSE; ?></option>";
			x += "\n\t\t\t\t<option value=\"true\"><?php echo ISTRUE; ?></option>";
			x += "\n\t\t\t</select>";
			x += "\n\t\t\t<span class=\"help\"><?php echo IGREGEX_HELP; ?></span><br><br>";
			x += "\n\t\t\t<div class=\"delete\"><?php echo REMOVE_ON_GENERATE; ?> <input id=\"remove_" + idx + "_" + idx2 + "\" name=\"remove_" + idx + "_" + idx2 + "\" type=\"checkbox\" value=\"1\" onclick=\"if($('input[id^=remove_" + idx + "_]').not(':checked').length===0){ $('#remove_" + idx + "').attr('checked','checked'); $('input[id^=remove_" + idx + "_]').attr('disabled','disabled'); }\"></div>";
			x += "\n\t\t\t<div class=\"delete\"><?php echo ADD; ?> <select id=\"newop_" + idx + "_" + idx2 + "\" name=\"newop[" + idx + "][" + idx2 + "]\">";
			x += "\n\t\t\t\t<option value=\"0\" selected=\"selected\">0</option>";
			x += "\n\t\t\t\t<option value=\"1\">1</option>";
			x += "\n\t\t\t\t<option value=\"2\">2</option>";
			x += "\n\t\t\t\t<option value=\"3\">3</option>";
			x += "\n\t\t\t</select> <?php echo NEW_OPERATIONS; ?> <span class=\"gen\">[<?php echo NOW; ?>]</span></div>";
			x += "\n\t\t</fieldset>";
			x += "\n\t</div>";
			
			$(".file:last").append(x);
			
			var $elem = $('body');
			$('html, body').animate({scrollTop: $elem.height()}, 800);
		}
	});

	$("#add").click(function() {
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
	x += "\n\t<fieldset id=\"filefieldset_" + idx + "\" class=\"fi\">";
	x += "\n\t<legend><?php echo FILE_TO_EDIT; ?></legend>";
	x += "\n\t\t<label for=\"path_" + idx + "\"><?php echo PATH_TO_FILENAMES; ?></label>";
	x += "\n\t\t<input id=\"path_" + idx + "\" name=\"path[" + idx + "]\" type=\"text\" style=\"width:750px;\"><br><br>"; 
	x += "\n\t\t<label for=\"file_" + idx + "\"><?php echo FILENAMES; ?></label>";
	x += "\n\t\t<input id=\"file_" + idx + "\" name=\"file[" + idx + "]\" type=\"text\" style=\"width:750px;\"><br><br>"; 
	x += "\n\t\t<div class=\"delete\"><?php echo REMOVE_ON_GENERATE; ?> <input id=\"remove_" + idx + "\" name=\"remove_" + idx + "\" type=\"checkbox\" value=\"1\" onclick=\"if($('#remove_" + idx + "').is(':checked')){ $('input[id^=remove_" + idx + "_]').attr('checked','checked').attr('disabled','disabled'); } else { $('input[id^=remove_" + idx + "_]').removeAttr('checked').removeAttr('disabled'); }\"></div>";
	x += "\n\t</fieldset>";
	x += "\n\t<div class=\"operation\">";    
	x += "\n\t\t<fieldset id=\"operationfieldset_" + idx + "_" + idx2 + "\" class=\"op\">";
	x += "\n\t\t<legend><?php echo OPERATION_TO_PERFORM; ?></legend>";
	x += "\n\t\t\t<label for=\"info_" + idx + "_" + idx2 + "\"><?php echo INFO; ?><br><span class=\"help\"><?php echo INFO_ASSIST; ?></span></label>";
	x += "\n\t\t\t<input id=\"info_" + idx + "_" + idx2 + "\" name=\"info[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:750px;margin-bottom:10px;\"><br><br>";
	x += "\n\t\t\t<label for=\"search_" + idx + "_" + idx2 + "\"><?php echo SEARCH; ?><br><span class=\"help\"><?php echo SEARCH_ASSIST; ?></span></label>";
	x += "\n\t\t\t<input id=\"search_" + idx + "_" + idx2 + "\" name=\"search[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:750px;margin-bottom:10px;\"><br><br>";
	x += "\n\t\t\t<label for=\"position_" + idx + "_" + idx2 + "\"><?php echo POSITION; ?></label>";
	x += "\n\t\t\t<select id=\"position_" + idx + "_" + idx2 + "\" name=\"position[" + idx + "][" + idx2 + "]\">";
	x += "\n\t\t\t\t<option value=\"replace\" selected=\"selected\"><?php echo REPLACE; ?></option>";
	x += "\n\t\t\t\t<option value=\"before\"><?php echo BEFORE; ?></option>";
	x += "\n\t\t\t\t<option value=\"after\"><?php echo AFTER; ?></option>";
	x += "\n\t\t\t\t<option value=\"top\"><?php echo TOP; ?></option>";
	x += "\n\t\t\t\t<option value=\"bottom\"><?php echo BOTTOM; ?></option>";
	x += "\n\t\t\t\t<option value=\"all\"><?php echo ALL; ?></option>";
	x += "\n\t\t\t</select>";
	x += "\n\t\t\t<span class=\"help\"><?php echo POSITION_HELP; ?></span><br><br>";
	x += "\n\t\t\t<label for=\"offset_" + idx + "_" + idx2 + "\"><?php echo OFFSET; ?><br><span class=\"help\"><?php echo OFFSET_ASSIST; ?></span></label>";
	x += "\n\t\t\t<input id=\"offset_" + idx + "_" + idx2 + "\" name=\"offset[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:40px;margin-bottom:10px;\"> <span class=\"help\"><?php echo OFFSET_HELP; ?></span><br><br>";
	x += "\n\t\t\t<label for=\"index_" + idx + "_" + idx2 + "\"><?php echo INDEX; ?><br><span class=\"help\"><?php echo INDEX_ASSIST; ?></span></label>";
	x += "\n\t\t\t<input id=\"index_" + idx + "_" + idx2 + "\" name=\"index[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:60px;margin-bottom:10px;\"> <span class=\"help\"><?php echo INDEX_HELP; ?></span><br><br>";
	x += "\n\t\t\t<label for=\"error_" + idx + "_" + idx2 + "\"><?php echo ERROR; ?><br><span class=\"help\"><?php echo ERROR_ASSIST; ?></span></label>";
	x += "\n\t\t\t<select id=\"error_" + idx + "_" + idx2 + "\" name=\"error[" + idx + "][" + idx2 + "]\">";
	x += "\n\t\t\t\t<option value=\"abort\" selected=\"selected\"><?php echo ABORT_LOG; ?></option>";
	x += "\n\t\t\t\t<option value=\"log\"><?php echo SKIP_LOG; ?></option>";
	x += "\n\t\t\t\t<option value=\"skip\"><?php echo SKIP_NO_LOG; ?></option>";
	x += "\n\t\t\t</select> <span class=\"help\"><?php echo ERROR_HELP; ?></span><br><br>";
	x += "\n\t\t\t<label for=\"regex_" + idx + "_" + idx2 + "\"><?php echo REGEX; ?><br><span class=\"help\"><?php echo REGEX_ASSIST; ?></span></label>";
	x += "\n\t\t\t<select id=\"regex_" + idx + "_" + idx2 + "\" name=\"regex[" + idx + "][" + idx2 + "]\">";
	x += "\n\t\t\t\t<option value=\"false\" selected=\"selected\"><?php echo ISFALSE; ?></option>";
	x += "\n\t\t\t\t<option value=\"true\"><?php echo ISTRUE; ?></option>";
	x += "\n\t\t\t</select>";
	x += "\n\t\t\t<span class=\"help\"><?php echo REGEX_HELP; ?></span><br><br>";
	x += "\n\t\t\t<textarea id=\"add_" + idx + "_" + idx2 + "\" name=\"add[" + idx + "][" + idx2 + "]\" style=\"width:940px;height:240px;\"></textarea><br><br>";
	x += "\n\t\t\t<label for=\"ignoreif_" + idx + "_" + idx2 + "\"><?php echo IGNOREIF; ?><br><span class=\"help\"><?php echo IGNOREIF_ASSIST; ?></span></label>";
	x += "\n\t\t\t<input id=\"ignoreif_" + idx + "_" + idx2 + "\" name=\"ignoreif[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:750px;margin-bottom:10px;\"><br><br>";
	x += "\n\t\t\t<label for=\"igregex_" + idx + "_" + idx2 + "\"><?php echo REGEX; ?><br><span class=\"help\"><?php echo REGEX_ASSIST; ?></span></label>";
	x += "\n\t\t\t<select id=\"igregex_" + idx + "_" + idx2 + "\" name=\"igregex[" + idx + "][" + idx2 + "]\">";
	x += "\n\t\t\t\t<option value=\"false\" selected=\"selected\"><?php echo ISFALSE; ?></option>";
	x += "\n\t\t\t\t<option value=\"true\"><?php echo ISTRUE; ?></option>";
	x += "\n\t\t\t</select>";
	x += "\n\t\t\t<span class=\"help\"><?php echo IGREGEX_HELP; ?></span><br><br>";
	x += "\n\t\t\t<div class=\"delete\"><?php echo REMOVE_ON_GENERATE; ?> <input id=\"remove_" + idx + "_" + idx2 + "\" name=\"remove_" + idx + "_" + idx2 + "\" type=\"checkbox\" value=\"1\" onclick=\"if($('input[id^=remove_" + idx + "_]').not(':checked').length===0){ $('#remove_" + idx + "').attr('checked','checked'); $('input[id^=remove_" + idx + "_]').attr('disabled','disabled'); }\"></div>";
	x += "\n\t\t\t<div class=\"delete\"><?php echo ADD; ?> <select id=\"newop_" + idx + "_" + idx2 + "\" name=\"newop[" + idx + "][" + idx2 + "]\">";
	x += "\n\t\t\t\t<option value=\"0\" selected=\"selected\">0</option>";
	x += "\n\t\t\t\t<option value=\"1\">1</option>";
	x += "\n\t\t\t\t<option value=\"2\">2</option>";
	x += "\n\t\t\t\t<option value=\"3\">3</option>";
	x += "\n\t\t\t</select> <?php echo NEW_OPERATIONS; ?> <span class=\"gen\">[<?php echo NOW; ?>]</span></div>";
	x += "\n\t\t</fieldset>";
	x += "\n\t</div>";
	x += "\n</div>";

	$("#container").append(x);

	$("#add1").click(function() {
		idx ++;
		idx2 ++;
		
		var x = "\n<div class=\"file\">";
		x += "\n\t<fieldset id=\"filefieldset_" + idx + "\" class=\"fi\">";
		x += "\n\t<legend><?php echo FILE_TO_EDIT; ?></legend>";
		x += "\n\t\t<label for=\"path_" + idx + "\"><?php echo PATH_TO_FILENAMES; ?></label>";
		x += "\n\t\t<input id=\"path_" + idx + "\" name=\"path[" + idx + "]\" type=\"text\" style=\"width:750px;\"><br><br>"; 
		x += "\n\t\t<label for=\"file_" + idx + "\"><?php echo FILENAMES; ?></label>";
		x += "\n\t\t<input id=\"file_" + idx + "\" name=\"file[" + idx + "]\" type=\"text\" style=\"width:750px;\"><br><br>"; 
		x += "\n\t\t<!-- <a onclick=\"idx = idx - 1; $(this).parent().parent().slideUp(function(){ $(this).remove() }); return false\"><span class=\"remove\">Remove</span></a> //-->";
		x += "\n\t\t<div class=\"delete\"><?php echo REMOVE_ON_GENERATE; ?> <input id=\"remove_" + idx + "\" name=\"remove_" + idx + "\" type=\"checkbox\" value=\"1\" onclick=\"if($('#remove_" + idx + "').is(':checked')){ $('input[id^=remove_" + idx + "_]').attr('checked','checked').attr('disabled','disabled'); } else { $('input[id^=remove_" + idx + "_]').removeAttr('checked').removeAttr('disabled'); }\"></div>";
		x += "\n\t</fieldset>";
		x += "\n\t<div class=\"operation\">";    
		x += "\n\t\t<fieldset id=\"operationfieldset_" + idx + "_" + idx2 + "\" class=\"op\">";
		x += "\n\t\t<legend><?php echo OPERATION_TO_PERFORM; ?></legend>";
		x += "\n\t\t\t<label for=\"info_" + idx + "_" + idx2 + "\"><?php echo INFO; ?><br><span class=\"help\"><?php echo INFO_ASSIST; ?></span></label>";
		x += "\n\t\t\t<input id=\"info_" + idx + "_" + idx2 + "\" name=\"info[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:750px;margin-bottom:10px;\"><br><br>";
		x += "\n\t\t\t<label for=\"search_" + idx + "_" + idx2 + "\"><?php echo SEARCH; ?><br><span class=\"help\"><?php echo SEARCH_ASSIST; ?></span></label>";
		x += "\n\t\t\t<input id=\"search_" + idx + "_" + idx2 + "\" name=\"search[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:750px;margin-bottom:10px;\"><br><br>";
		x += "\n\t\t\t<label for=\"position_" + idx + "_" + idx2 + "\"><?php echo POSITION; ?></label>";
		x += "\n\t\t\t<select id=\"position_" + idx + "_" + idx2 + "\" name=\"position[" + idx + "][" + idx2 + "]\">";
		x += "\n\t\t\t\t<option value=\"replace\" selected=\"selected\"><?php echo REPLACE; ?></option>";
		x += "\n\t\t\t\t<option value=\"before\"><?php echo BEFORE; ?></option>";
		x += "\n\t\t\t\t<option value=\"after\"><?php echo AFTER; ?></option>";
		x += "\n\t\t\t\t<option value=\"top\"><?php echo TOP; ?></option>";
		x += "\n\t\t\t\t<option value=\"bottom\"><?php echo BOTTOM; ?></option>";
		x += "\n\t\t\t\t<option value=\"all\"><?php echo ALL; ?></option>";
		x += "\n\t\t\t</select>";
		x += "\n\t\t\t<span class=\"help\"><?php echo POSITION_HELP; ?></span><br><br>";
		x += "\n\t\t\t<label for=\"offset_" + idx + "_" + idx2 + "\"><?php echo OFFSET; ?><br><span class=\"help\"><?php echo OFFSET_ASSIST; ?></span></label>";
		x += "\n\t\t\t<input id=\"offset_" + idx + "_" + idx2 + "\" name=\"offset[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:40px;margin-bottom:10px;\"> <span class=\"help\"><?php echo OFFSET_HELP; ?></span><br><br>";
		x += "\n\t\t\t<label for=\"index_" + idx + "_" + idx2 + "\"><?php echo INDEX; ?><br><span class=\"help\"><?php echo INDEX_ASSIST; ?></span></label>";
		x += "\n\t\t\t<input id=\"index_" + idx + "_" + idx2 + "\" name=\"index[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:60px;margin-bottom:10px;\"> <span class=\"help\"><?php echo INDEX_HELP; ?></span><br><br>";
		x += "\n\t\t\t<label for=\"error_" + idx + "_" + idx2 + "\"><?php echo ERROR; ?><br><span class=\"help\"><?php echo ERROR_ASSIST; ?></span></label>";
		x += "\n\t\t\t<select id=\"error_" + idx + "_" + idx2 + "\" name=\"error[" + idx + "][" + idx2 + "]\">";

		x += "\n\t\t\t\t<option value=\"abort\" selected=\"selected\"><?php echo ABORT_LOG; ?></option>";
		x += "\n\t\t\t\t<option value=\"log\"><?php echo SKIP_LOG; ?></option>";
		x += "\n\t\t\t\t<option value=\"skip\"><?php echo SKIP_NO_LOG; ?></option>";
		x += "\n\t\t\t</select> <span class=\"help\"><?php echo ERROR_HELP; ?></span><br><br>";
		x += "\n\t\t\t<label for=\"regex_" + idx + "_" + idx2 + "\"><?php echo REGEX; ?><br><span class=\"help\"><?php echo REGEX_ASSIST; ?></span></label>";
		x += "\n\t\t\t<select id=\"regex_" + idx + "_" + idx2 + "\" name=\"regex[" + idx + "][" + idx2 + "]\">";
		x += "\n\t\t\t\t<option value=\"false\" selected=\"selected\"><?php echo ISFALSE; ?></option>";
		x += "\n\t\t\t\t<option value=\"true\"><?php echo ISTRUE; ?></option>";
		x += "\n\t\t\t</select>";
		x += "\n\t\t\t<span class=\"help\"><?php echo REGEX_HELP; ?></span><br><br>";
		x += "\n\t\t\t<textarea id=\"add_" + idx + "_" + idx2 + "\" name=\"add[" + idx + "][" + idx2 + "]\" style=\"width:940px;height:240px;\"></textarea><br><br>";
		x += "\n\t\t\t<label for=\"ignoreif_" + idx + "_" + idx2 + "\"><?php echo IGNOREIF; ?><br><span class=\"help\"><?php echo IGNOREIF_ASSIST; ?></span></label>";
		x += "\n\t\t\t<input id=\"ignoreif_" + idx + "_" + idx2 + "\" name=\"ignoreif[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:750px;margin-bottom:10px;\"><br><br>";
		x += "\n\t\t\t<label for=\"igregex_" + idx + "_" + idx2 + "\"><?php echo REGEX; ?><br><span class=\"help\"><?php echo REGEX_ASSIST; ?></span></label>";
		x += "\n\t\t\t<select id=\"igregex_" + idx + "_" + idx2 + "\" name=\"igregex[" + idx + "][" + idx2 + "]\">";
		x += "\n\t\t\t\t<option value=\"false\" selected=\"selected\"><?php echo ISFALSE; ?></option>";
		x += "\n\t\t\t\t<option value=\"true\"><?php echo ISTRUE; ?></option>";
		x += "\n\t\t\t</select>";
		x += "\n\t\t\t<span class=\"help\"><?php echo IGREGEX_HELP; ?></span><br><br>";
		x += "\n\t\t\t<div class=\"delete\"><?php echo REMOVE_ON_GENERATE; ?> <input id=\"remove_" + idx + "_" + idx2 + "\" name=\"remove_" + idx + "_" + idx2 + "\" type=\"checkbox\" value=\"1\" onclick=\"if($('input[id^=remove_" + idx + "_]').not(':checked').length===0){ $('#remove_" + idx + "').attr('checked','checked'); $('input[id^=remove_" + idx + "_]').attr('disabled','disabled'); }\"></div>";
		x += "\n\t\t\t<div class=\"delete\"><?php echo ADD; ?> <select id=\"newop_" + idx + "_" + idx2 + "\" name=\"newop[" + idx + "][" + idx2 + "]\">";
		x += "\n\t\t\t\t<option value=\"0\" selected=\"selected\">0</option>";
		x += "\n\t\t\t\t<option value=\"1\">1</option>";
		x += "\n\t\t\t\t<option value=\"2\">2</option>";
		x += "\n\t\t\t\t<option value=\"3\">3</option>";
		x += "\n\t\t\t</select> <?php echo NEW_OPERATIONS; ?> <span class=\"gen\">[<?php echo NOW; ?>]</span></div>";
		x += "\n\t\t</fieldset>";
		x += "\n\t</div>";
		x += "\n</div>";
		
		$("#container").append(x);
		var $elem = $('body');
		$('html, body').animate({scrollTop: $elem.height()}, 800);
	});
	
	$("#add2").click(function() {
		if($('#remove_' + idx ).is(':checked')){
			alert('<?php echo CLEAR_REMOVE_ON_GENERATE; ?>');
		}else{
			idx2 ++;
			
			var x = "\n\t<div class=\"operation\">";    
			x += "\n\t\t<fieldset id=\"operationfieldset_" + idx + "_" + idx2 + "\" class=\"op\">";
			x += "\n\t\t<legend><?php echo OPERATION_TO_PERFORM; ?></legend>";
			x += "\n\t\t\t<label for=\"info_" + idx + "_" + idx2 + "\"><?php echo INFO; ?><br><span class=\"help\"><?php echo INFO_ASSIST; ?></span></label>";
			x += "\n\t\t\t<input id=\"info_" + idx + "_" + idx2 + "\" name=\"info[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:750px;margin-bottom:10px;\"><br><br>";
			x += "\n\t\t\t<label for=\"search_" + idx + "_" + idx2 + "\"><?php echo SEARCH; ?><br><span class=\"help\"><?php echo SEARCH_ASSIST; ?></span></label>";
			x += "\n\t\t\t<input id=\"search_" + idx + "_" + idx2 + "\" name=\"search[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:750px;margin-bottom:10px;\"><br><br>";
			x += "\n\t\t\t<label for=\"position_" + idx + "_" + idx2 + "\"><?php echo POSITION; ?></label>";
			x += "\n\t\t\t<select id=\"position_" + idx + "_" + idx2 + "\" name=\"position[" + idx + "][" + idx2 + "]\">";
			x += "\n\t\t\t\t<option value=\"replace\" selected=\"selected\"><?php echo REPLACE; ?></option>";
			x += "\n\t\t\t\t<option value=\"before\"><?php echo BEFORE; ?></option>";
			x += "\n\t\t\t\t<option value=\"after\"><?php echo AFTER; ?></option>";
			x += "\n\t\t\t\t<option value=\"top\"><?php echo TOP; ?></option>";
			x += "\n\t\t\t\t<option value=\"bottom\"><?php echo BOTTOM; ?></option>";
			x += "\n\t\t\t\t<option value=\"all\"><?php echo ALL; ?></option>";
			x += "\n\t\t\t</select>";
			x += "\n\t\t\t<span class=\"help\"><?php echo POSITION_HELP; ?></span><br><br>";
			x += "\n\t\t\t<label for=\"offset_" + idx + "_" + idx2 + "\"><?php echo OFFSET; ?><br><span class=\"help\"><?php echo OFFSET_ASSIST; ?></span></label>";
			x += "\n\t\t\t<input id=\"offset_" + idx + "_" + idx2 + "\" name=\"offset[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:40px;margin-bottom:10px;\"> <span class=\"help\"><?php echo OFFSET_HELP; ?></span><br><br>";
			x += "\n\t\t\t<label for=\"index_" + idx + "_" + idx2 + "\"><?php echo INDEX; ?><br><span class=\"help\"><?php echo INDEX_ASSIST; ?></span></label>";
			x += "\n\t\t\t<input id=\"index_" + idx + "_" + idx2 + "\" name=\"index[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:60px;margin-bottom:10px;\"> <span class=\"help\"><?php echo INDEX_HELP; ?></span><br><br>";
			x += "\n\t\t\t<label for=\"error_" + idx + "_" + idx2 + "\"><?php echo ERROR; ?><br><span class=\"help\"><?php echo ERROR_ASSIST; ?></span></label>";
			x += "\n\t\t\t<select id=\"error_" + idx + "_" + idx2 + "\" name=\"error[" + idx + "][" + idx2 + "]\">";
			x += "\n\t\t\t\t<option value=\"abort\" selected=\"selected\"><?php echo ABORT_LOG; ?></option>";
			x += "\n\t\t\t\t<option value=\"log\"><?php echo SKIP_LOG; ?></option>";
			x += "\n\t\t\t\t<option value=\"skip\"><?php echo SKIP_NO_LOG; ?></option>";
			x += "\n\t\t\t</select> <span class=\"help\"><?php echo ERROR_HELP; ?></span><br><br>";
			x += "\n\t\t\t<label for=\"regex_" + idx + "_" + idx2 + "\"><?php echo REGEX; ?><br><span class=\"help\"><?php echo REGEX_ASSIST; ?></span></label>";
			x += "\n\t\t\t<select id=\"regex_" + idx + "_" + idx2 + "\" name=\"regex[" + idx + "][" + idx2 + "]\">";
			x += "\n\t\t\t\t<option value=\"false\" selected=\"selected\"><?php echo ISFALSE; ?></option>";
			x += "\n\t\t\t\t<option value=\"true\"><?php echo ISTRUE; ?></option>";
			x += "\n\t\t\t</select>";
			x += "\n\t\t\t<span class=\"help\"><?php echo REGEX_HELP; ?></span><br><br>";
			x += "\n\t\t\t<textarea id=\"add_" + idx + "_" + idx2 + "\" name=\"add[" + idx + "][" + idx2 + "]\" style=\"width:940px;height:240px;\"></textarea><br><br>";
			x += "\n\t\t\t<label for=\"ignoreif_" + idx + "_" + idx2 + "\"><?php echo IGNOREIF; ?><br><span class=\"help\"><?php echo IGNOREIF_ASSIST; ?></span></label>";
			x += "\n\t\t\t<input id=\"ignoreif_" + idx + "_" + idx2 + "\" name=\"ignoreif[" + idx + "][" + idx2 + "]\" type=\"text\" style=\"width:750px;margin-bottom:10px;\"><br><br>";
			x += "\n\t\t\t<label for=\"igregex_" + idx + "_" + idx2 + "\"><?php echo REGEX; ?><br><span class=\"help\"><?php echo REGEX_ASSIST; ?></span></label>";
			x += "\n\t\t\t<select id=\"igregex_" + idx + "_" + idx2 + "\" name=\"igregex[" + idx + "][" + idx2 + "]\">";
			x += "\n\t\t\t\t<option value=\"false\" selected=\"selected\"><?php echo ISFALSE; ?></option>";
			x += "\n\t\t\t\t<option value=\"true\"><?php echo ISTRUE; ?></option>";
			x += "\n\t\t\t</select>";
			x += "\n\t\t\t<span class=\"help\"><?php echo IGREGEX_HELP; ?></span><br><br>";
			x += "\n\t\t\t<div class=\"delete\"><?php echo REMOVE_ON_GENERATE; ?> <input id=\"remove_" + idx + "_" + idx2 + "\" name=\"remove_" + idx + "_" + idx2 + "\" type=\"checkbox\" value=\"1\" onclick=\"if($('input[id^=remove_" + idx + "_]').not(':checked').length===0){ $('#remove_" + idx + "').attr('checked','checked'); $('input[id^=remove_" + idx + "_]').attr('disabled','disabled'); }\"></div>";
			x += "\n\t\t\t<div class=\"delete\"><?php echo ADD; ?> <select id=\"newop_" + idx + "_" + idx2 + "\" name=\"newop[" + idx + "][" + idx2 + "]\">";
			x += "\n\t\t\t\t<option value=\"0\" selected=\"selected\">0</option>";
			x += "\n\t\t\t\t<option value=\"1\">1</option>";
			x += "\n\t\t\t\t<option value=\"2\">2</option>";
			x += "\n\t\t\t\t<option value=\"3\">3</option>";
			x += "\n\t\t\t</select> <?php echo NEW_OPERATIONS; ?> <span class=\"gen\">[<?php echo NOW; ?>]</span></div>";
			x += "\n\t\t</fieldset>";
			x += "\n\t</div>";
			
			$(".file:last").append(x);
			
			var $elem = $('body');
			$('html, body').animate({scrollTop: $elem.height()}, 800);
		}
	});

	$("#add").click(function() {
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
</div>
<div class="ui-layout-east">East</div>
<script src="js/jquery-ui-latest.js"></script>
<script src="js/jquery.layout-latest.js"></script>
<script src="js/jquery.tabSlideOut.v1.3.js"></script>
<script src="js/jquery.zrssfeed.min.js"></script>
<script src="js/jquery.vticker.js"></script>
<script src="js/jquery.textarea.js"></script>
<script>
var myLayout;
$(function(){
	myLayout = $('body').layout({
		
		applyDemoStyles: true,
		initClosed: true,
		initHidden: true,
		east__slidable: false,
		east__resizable: false,
		east__size:$(document).width()-1000,
		east__minSize:$(document).width()-1000,
		east__maxSize:$(document).width()-1000,
		//east__resizerTip: 'Drag to Resize!',
		east__fxName: 'slide',
		east__fxSpeed: 'fast'
		
	});
 
 	$('.slide-out-div3').tabSlideOut({
		tabHandle: '.handle3',                              //class of the element that will be your tab
		pathToTabImage: './images/cache_top_tab.png',          //path to the image for the tab (optionaly can be set using css)
		imageHeight: '32px',                               //height of tab image
		imageWidth: '142px',                               //width of tab image    
		tabLocation: 'top',                               //side of screen where tab lives, top, right, bottom, or left
		speed: 300,                                        //speed of animation
		action: 'click',                                   //options: 'click' or 'hover', action to trigger animation
		topPos: '0px',                                   //position from the top
		leftPos: '0px',                                   //position from the left
		fixedPosition: false                               //options: true makes it stick(fixed position) on scroll
	});

	$('.slide-out-div2').tabSlideOut({
		tabHandle: '.handle2',                              //class of the element that will be your tab
		pathToTabImage: './images/logs_top_tab.png',          //path to the image for the tab (optionaly can be set using css)
		imageHeight: '32px',                               //height of tab image
		imageWidth: '142px',                               //width of tab image    
		tabLocation: 'top',                               //side of screen where tab lives, top, right, bottom, or left
		speed: 300,                                        //speed of animation
		action: 'click',                                   //options: 'click' or 'hover', action to trigger animation
		topPos: '0px',                                   //position from the top
		leftPos: '0px',                                   //position from the left
		fixedPosition: false                               //options: true makes it stick(fixed position) on scroll
	});

	$('.slide-out-div').tabSlideOut({
		tabHandle: '.handle',                              //class of the element that will be your tab
		pathToTabImage: './images/files_top_tab.png',          //path to the image for the tab (optionaly can be set using css)
		imageHeight: '32px',                               //height of tab image
		imageWidth: '142px',                               //width of tab image    
		tabLocation: 'top',                               //side of screen where tab lives, top, right, bottom, or left
		speed: 300,                                        //speed of animation
		action: 'click',                                   //options: 'click' or 'hover', action to trigger animation
		topPos: '0px',                                   //position from the top

		leftPos: '50px',                                   //position from the left
		fixedPosition: false                               //options: true makes it stick(fixed position) on scroll
	});
	
	$('.news').tabSlideOut({
		tabHandle: '.handlenews',                              //class of the element that will be your tab


		pathToTabImage: './images/news_top_tab.png',          //path to the image for the tab (optionaly can be set using css)
		imageHeight: '32px',                               //height of tab image
		imageWidth: '142px',                               //width of tab image    
		tabLocation: 'top',                               //side of screen where tab lives, top, right, bottom, or left
		speed: 300,                                        //speed of animation
		action: 'click',                                   //options: 'click' or 'hover', action to trigger animation
		topPos: '0px',                                   //position from the top

		leftPos: '0px',                                   //position from the left
		fixedPosition: false                               //options: true makes it stick(fixed position) on scroll
	});

	$("textarea").tabby();
	
<?php if(current_log_file(LOG)!=''&&filesize(LOG . current_log_file(LOG))>1&&filesize(LOG . current_log_file(LOG))<((LOGMAX*1048576)+1)){ ?>
	$('.handle2').click(function() {
		$.ajax({
			url : "logfile.php?log=<?php echo LOG . current_log_file(LOG); ?>",
			dataType: "json",
			success: function(data){
				$("#log").val(data);
			}
		});
		
	});
<?php } ?>

	$('.handle3').click(function() {
		$.ajax({
			url : "vqcachefile.php?cachefile=<?php echo (isset($_GET['vqcachefile'])&&$_GET['vqcachefile']=='mods.cache'?MODSCACHE:CACHE . $_GET['vqcachefile']); ?>",
			dataType: "json",
			success: function(data){
				$("#cache").val(data);
			}
		});
	});
	
	$('.handlenews').click(function() {
		$('#news').rssfeed('<?php echo (NEWS==""?"http://www.opencart-extensions.co.uk/news/feed.xml":NEWS); ?>',{dateformat: 'MMMM yyyy',errormsg: '<?php echo NEWSERROR; ?>', linktarget: '_blank'}, function(e) {
			$(e).find('div.rssBody').vTicker({ showItems: 3});
			$('h4 a',e).each(function(i) {

				var title = $(this).text();
				if (title.length > 44) $(this).text(title.substring(0,40)+'...');
			});
		});
	});
	
	$('#add3').click(function() {
		location.href = '<?php echo './?enable=' .$_GET['file']; ?>';
	});
	
	$('#file_list').change(function() {
		location.href = './?vqcachefile=' + $(this).val();
	});
	
<?php if(isset($_GET['handle1'])){ ?>
	$('.handle').trigger('click');
<?php }elseif(isset($_GET['handle2'])){ ?>
	$('.handle2').trigger('click');
<?php }elseif(isset($_GET['vqcachefile'])||isset($_GET['cleared'])){ ?>
	$('.handle3').trigger('click');
<?php } ?>	
});
</script>
<?php } ?>
</body>
</html>