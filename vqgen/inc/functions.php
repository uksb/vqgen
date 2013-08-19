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
 * @version $Id: functions.php, v3.2.1 2013-02-05 22:30:00 sp Exp $
 * @license http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-ShareAlike 3.0 Unported License
 */

// Get list of all vqmod cache files
function cache_list($path){
	$files = scandir($path, 0);
	
	$toDelete=array('.', '..');

	$files=array_diff($files, $toDelete);
	
	return $files;		
}

// Get current vqmod log file name
function current_log_file($path){
	$latest_ctime = 0;
	$latest_filename = '';    
	
	$d = scandir($path, 0);;
	
	$toDelete=array('.', '..');

	$d=array_diff($d, $toDelete);
	
	if(count($d)){
		foreach($d as $val) {
			$filepath = "{$path}/{$val}";
			if (is_file($filepath) && filectime($filepath) > $latest_ctime) {
				$latest_ctime = filectime($filepath);
				$latest_filename = $val;
			}
		}
	}
	
	return $latest_filename;
}

// Output Size in a nice format
function size_display($size){
	$sizetext = ($size>1023?' kb':' bytes');
	
	return ($size>1023?number_format(($size/1024),2,'.',''):$size) . $sizetext;
}

// Sort a multidimentional array
function multi_natcasesort($array, $index='file', $order='asc', $natsort=TRUE, $case_sensitive=FALSE){
	if(is_array($array) && count($array)>0){
			
		foreach(array_keys($array) as $key){
			$temp[$key]=$array[$key][$index];
		}
		
		if(!$natsort){ 
			($order=='asc')? asort($temp) : arsort($temp);
		}else{
			($case_sensitive)? natsort($temp) : natcasesort($temp);
			
			if($order!='asc'){ 
				$temp=array_reverse($temp,TRUE);
			}
		}
		   
		foreach(array_keys($temp) as $key){
			(is_numeric($key))? $sorted[]=$array[$key] : $sorted[$key]=$array[$key];
		}
		   
		return $sorted;
	}
	return $array;
}

function stripText($text)
{
	$text = ($text==''?time():$text);
	$text = strtolower(trim($text));
	$text = str_replace(' ', '-', str_replace(".", "-", $text));
	$clean = preg_replace("/[^A-Za-z0-9\-_]/", "", $text);
	
	return $clean;
}

function getTree($path = '../', $dirs = '', $files = 1) {
	$ignore = array('vqmod', 'config-dist.php', 'install', 'nbproject', '.svn', '.', '..' );
	$exts = array('php', 'tpl');

	$tree = array();
	$full_path = $path . $dirs;
	$multi = explode(',', $full_path);
	if (isset($multi[1])) {
		$full_path = explode('/', $dirs);
		$full_path = $path . array_pop($multi);
		$multi = str_replace($path, '', implode(',', $multi)) . ',';
	} else {
		$multi = '';
	}
	$full_path = explode('/', $full_path);
	$find = array_pop($full_path);
	$len = strlen($find);
	$full_path = implode('/', $full_path) . '/';
	if (strpos($full_path, '*') !== false) { // Search-Dir has wildcard: bla*/
		$tdir = explode('*', $full_path);
		$wild = $tdir[0];
		if (substr($tdir[1], 0, 1) == '/' && substr($wild, -1) == '/') $tdir[1] = substr($tdir[1], 1);
		$sdirs = $this->getTree($wild, '', $files);
		foreach ($sdirs as $sdir) {
			$tdirlen = strlen($sdir.$tdir[1]) * -1;
			if (!$tdirlen || substr($sdir, $tdirlen) == $tdir[1] || is_dir($wild . $sdir . $tdir[1])) { // Rest of wildcard found in results...
				if (is_dir($wild . $sdir . $tdir[1])) {
					$dirs = $this->getTree($wild . $sdir . $tdir[1], '', $files);
					$sdir = '*/' . $tdir[1];
				} else {
					$dirs = $this->getTree($wild . $sdir, '', $files);
					$sdir = str_replace(substr($sdir, 0, $tdirlen), '*', $sdir);
				}
				foreach ($dirs as $dir) {
					$file = $multi . str_replace($path, '', $wild . $sdir) . $dir;
					if (!in_array($file, $tree)) $tree[] = $file;
				}
			}
		}
	} else {
		if (file_exists($full_path)) {
			$dh = opendir($full_path);
			while (false !== ($file = readdir($dh))) {
				if (!in_array($file, $ignore) && (!$find || substr($file, 0, $len) == $find)) {
					$dir = $full_path . $file;
					if (is_dir($dir)) {
						$dir .= '/';
						$tree[] = $multi . str_replace($path, '', $dir);
					} else {
						$ext = explode('.', $file);
						$ext = array_pop($ext);
						if ($files && in_array($ext, $exts)) $tree[] = $multi . str_replace($path, '', $dir);
					}
				}
			}
			closedir($dh);
		}
	}
	return $tree;
}
