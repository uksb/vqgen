<?php
// Get a file
if(isset($_GET['get'])){
	$filen = (substr($_GET['get'], -1)=='_'?rtrim($_GET['get'], '_'):$_GET['get']);
	
	header('Content-disposition: attachment; filename=' . $filen);
	header('Content-type: text/xml');
	header("Content-length: " . filesize(PATH . $_GET['get']));
    header("Cache-control: private");
	readfile(PATH . $_GET['get']);
	exit();
}

// Delete a file
if(isset($_GET['delete'])){
	if(file_exists(PATH . $_GET['delete'])){
		@unlink(PATH . $_GET['delete']);
		if(substr($_GET['delete'],-1)!='_'){
			foreach (glob(CACHE . '*.*') as $cachefile) {
				@unlink($cachefile);
			}
		}
	}
	header("Location:./");
	exit;
}

// Disable a file
if(isset($_GET['disable'])){
	if(file_exists(PATH . $_GET['disable'])){
		@rename(PATH . $_GET['disable'], PATH . $_GET['disable'].'_');
		foreach (glob(CACHE . '*.*') as $cachefile) {
			@unlink($cachefile);
		}
	}
	header("Location:./");
	exit;
}

// Disable all files
if(isset($_GET['disableall'])){
	foreach (glob(PATH . '*.xml') as $path) {
		if($path != PATH . 'vqmod_opencart.xml'){
			@rename($path, $path.'_');
		}
		foreach (glob(CACHE . '*.*') as $cachefile) {
			@unlink($cachefile);
		}
	}
	header("Location:./");
	exit;
}

// Enable a file
if(isset($_GET['enable'])){
	if(file_exists(PATH . $_GET['enable'])){
		@rename(PATH . $_GET['enable'], rtrim(PATH . $_GET['enable'], '_'));
		foreach (glob(CACHE . '*.*') as $cachefile) {
			@unlink($cachefile);
		}
	}
	header("Location:./");
	exit;
}

// Enable all files
if(isset($_GET['enableall'])){
	foreach (glob(PATH . '*.xml_') as $path) {
		@rename($path, rtrim($path, '_'));
		foreach (glob(CACHE . '*.*') as $cachefile) {
			@unlink($cachefile);
		}
	}
	header("Location:./");
	exit;
}

// Edit a file

// Generate a new file
if(isset($_POST['generatexml'])){
	$file = PATH . stripText($_POST['filename']) . '.xml_';

	$output = '<!-- Created using vQmod XML Generator by UKSB - http://www.opencart-extensions.co.uk //-->'."\n";
	$output .= '<modification>'."\n";
	$output .= "\t" . '<id><![CDATA[' . stripslashes($_POST['fileid']) . ']]></id>' . "\n";
	$output .= "\t" . '<version><![CDATA[' . stripslashes($_POST['version']) . ']]></version>' . "\n";
	$output .= "\t" . '<vqmver><![CDATA[' . stripslashes($_POST['vqmodver']) . ']]></vqmver>' . "\n";
	$output .= "\t" . '<author><![CDATA[' . stripslashes($_POST['author']) . ']]></author>';
	
	foreach ($_POST['file'] as $key => $value){
		if(!isset($_POST['remove_'.$key])){
			$output .= "\n\t" . '<file name="' . stripslashes($value) . '">';
		
			foreach ($_POST['search'][$key] as $key2 => $val) {
				if(!isset($_POST['remove_'.$key.'_'.$key2])){
					$output .= "\n\t\t" . '<operation>';
					$output .= "\n\t\t\t" . '<search';
					$output .= ' position="' . $_POST['position'][$key][$key2] . '"';
					$output .= ((int)$_POST['offset'][$key][$key2]>0?' offset="'.(int)$_POST['offset'][$key][$key2].'"':'');
					$output .= ((int)$_POST['index'][$key][$key2]>0?' index="'.(int)$_POST['index'][$key][$key2].'"':'');
					$output .= ($_POST['error'][$key][$key2]!='abort'?' error="' . $_POST['error'][$key][$key2] . '"':'');
					$output .= ($_POST['regex'][$key][$key2]=='true'?' regex="true"':'');
					$output .= '>';
					$output .= '<![CDATA[' . stripslashes($val) . ']]></search>';
					$output .= "\n\t\t\t" . '<add><![CDATA[' . stripslashes($_POST['add'][$key][$key2])  . ']]></add>';
					$output .= "\n\t\t" . '</operation>';
					
					if($_POST['newop'][$key][$key2]>0){
						for($i=0; $i< $_POST['newop'][$key][$key2]; $i++){
							$output .= "\n\t\t" . '<operation>';
							$output .= "\n\t\t\t" . '<search';
							$output .= ' position="replace">';
							$output .= '<![CDATA[]]></search>';
							$output .= "\n\t\t\t" . '<add><![CDATA[]]></add>';
							$output .= "\n\t\t" . '</operation>';
						}
					}
				}
			}
			$output .= "\n\t" . '</file>';
		}
	}
	$output .= "\n" . '</modification>';
	
	$fp = fopen( $file , "w" );
	$fout = fwrite( $fp , $output );
	fclose( $fp );
	chmod($file, 0777);
	header("Location:./?generated=1&file=" . stripText($_POST['filename']). '.xml_');
}

if(isset($_GET['file'])){
	if(substr($_GET['file'], -1)!='_'){
		@rename(PATH . $_GET['file'], PATH . $_GET['file'].'_');
		$_GET['file'] .= '_';
	}else{
		foreach (glob(CACHE . '*.*') as $cachefile) {
			@unlink($cachefile);
		}
	}
	
	function xml2assoc($xml) {
		$tree = null;
		while($xml->read())
			switch ($xml->nodeType) {
				case XMLReader::END_ELEMENT: return $tree;
				case XMLReader::ELEMENT:
					$node = array('tag' => $xml->name, 'value' => $xml->isEmptyElement ? '' : xml2assoc($xml));
					if($xml->hasAttributes)
						while($xml->moveToNextAttribute())
							$node['attributes'][$xml->name] = $xml->value;
					$tree[] = $node;
				break;
				case XMLReader::TEXT:
				case XMLReader::CDATA:
					$tree .= $xml->value;
			}
		return $tree;
	} 

    $xml = new XMLReader();
    $xml->open(PATH . $_GET['file']);
	$assoc = xml2assoc($xml);
    $xml->close();
	
	// Get Modification Data
	$data = $assoc[0]['value'];
	
	// Get header Info
	$id = array_shift($data);
	$version = array_shift($data);
	$vqmver = array_shift($data);
	$author = array_shift($data);
}
