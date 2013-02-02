<?php
/**
 * vQmod XML Generator v3.2.0
 * 
 * Generate XML files for use with vQmod.
 * Built-in File Manager and Log Viewer.
 *
 * For further information please visit {@link http://www.vqmod.com/}
 * 
 * @author Simon Powers - UK Site Buidler Ltd <info@uksitebuilder.net> {@link http://uksb.github.com/vqgen/}
 * @copyright Copyright (c) 2013, UK Site Builder Ltd
 * @version $Id: files.php, v3.2.0 2013-02-02 01:30:00 sp Exp $
 * @license http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-ShareAlike 3.0 Unported License
 */

// Get the list of active vqmod files
$a=0;
foreach (glob(PATH . '*.xml') as $path) {
    $file = str_replace(PATH, "", $path);
	if($file!='vqmod_opencart.xml'){
		$xml = simplexml_load_file($path);
		
		$activevqmods[$a]['file']=$file;
		$activevqmods[$a]['size']=size_display(filesize($path));
		$activevqmods[$a]['date']=date ("M jS Y H:i", filemtime($path));
		$activevqmods[$a]['id']= (isset($xml->id) ? $xml->id : '');
		$activevqmods[$a]['version']= (isset($xml->version) ? $xml->version : '');
		$activevqmods[$a]['vqmver']= (isset($xml->vqmver) ? $xml->vqmver : '');
		$activevqmods[$a]['author']= (isset($xml->author) ? $xml->author : '');
		
		$a++;
	}
}
if(isset($activevqmods)){
	multi_natcasesort($activevqmods);
}

// Get the list of disabled vqmod files
$d=0;
foreach (glob(PATH . '*.xml_') as $path) {
    $file = rtrim(str_replace(PATH, "", $path), '_');

	$xml = simplexml_load_file($path);

	$inactivevqmods[$d]['file']=$file;
	$inactivevqmods[$d]['size']=size_display(filesize($path));
	$inactivevqmods[$d]['date']=date ("M jS Y H:i", filemtime($path));
	$inactivevqmods[$d]['id']= (isset($xml->id) ? $xml->id : '');
	$inactivevqmods[$d]['version']= (isset($xml->version) ? $xml->version : '');
	$inactivevqmods[$d]['vqmver']= (isset($xml->vqmver) ? $xml->vqmver : '');
	$inactivevqmods[$d]['author']= (isset($xml->author) ? $xml->author : '');

	$d++;
}
if(isset($inactivevqmods)){
	multi_natcasesort($inactivevqmods);
}