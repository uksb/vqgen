<?php
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