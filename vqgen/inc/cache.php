<?php
/**
 * vQmod XML Generator v3.1.0
 * 
 * Generate XML files for use with vQmod.
 * Built-in File Manager and Log Viewer.
 *
 * For further information please visit {@link http://www.vqmod.com/}
 * 
 * @author Simon Powers - UK Site Buidler Ltd <info@uksitebuilder.net> {@link http://uksb.github.com/vqgen/}
 * @copyright Copyright (c) 2013, UK Site Builder Ltd
 * @version $Id: cache.php,v 3.1.0 2013-01-28 23:00:00 sp Exp $
 * @license http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-ShareAlike 3.0 Unported License
 */

// Clear Cache Files
if(isset($_GET['clearvqcache'])){
	$files = glob(CACHE . '*'); // get all file names
	foreach($files as $file){ // iterate files
	  if(is_file($file))
		unlink($file); // delete file
	}
	header("Location:./?cleared=vqcache");
}

if(isset($_GET['clearmodscache'])){
	$files = glob(MODSCACHE . '*'); // get all file names
	foreach($files as $file){ // iterate files
	  if(is_file($file))
		unlink($file); // delete file
	}
	header("Location:./?cleared=modscache");
}

if(isset($_GET['deletevqcachefile'])){
	unlink(CACHE . $_GET['deletevqcachefile']); // delete file

	header("Location:./?cleared=vqcachefile_".$_GET['deletevqcachefile']);
}

// Get vQmod Cache file data
if(!isset($_GET['vqcachefile'])||$_GET['vqcachefile']=='') {
	$cache = CHOOSE_CACHE_FILE . '









                                               ________
                                           _jgN########Ngg_
                                         _N##N@@""  ""9NN##Np_
                                        d###P            N####p
                                        "^^"              T####
                                                          d###P
                                                       _g###@F
                                                    _gN##@P
                                                  gN###F"
                                                 d###F
                                                0###F 
                                                0###F
                                                0###F
                                                "NN@"

                                                 ___
                                                q###r
                                                 ""   ';
		 

}elseif(file_exists(CACHE . $_GET['vqcachefile'])&&filesize(CACHE . $_GET['vqcachefile'])<1){
	$cache = $_GET['vqcachefile'] . CACHE_IS_EMPTY . '









                                               ________
                                           _jgN########Ngg_
                                         _N##N@@""  ""9NN##Np_
                                        d###P            N####p
                                        "^^"              T####
                                                          d###P
                                                       _g###@F
                                                    _gN##@P
                                                  gN###F"
                                                 d###F
                                                0###F 
                                                0###F
                                                0###F
                                                "NN@"

                                                 ___
                                                q###r
                                                 ""   ';
		 

}elseif($_GET['vqcachefile']=='mods.cache'&&!file_exists(MODSCACHE)){
	$cache = $_GET['vqcachefile'] . CACHE_IS_EMPTY . '

	







                                               ________
                                           _jgN########Ngg_
                                         _N##N@@""  ""9NN##Np_
                                        d###P            N####p
                                        "^^"              T####
                                                          d###P
                                                       _g###@F
                                                    _gN##@P
                                                  gN###F"
                                                 d###F
                                                0###F 
                                                0###F
                                                0###F
                                                "NN@"

                                                 ___
                                                q###r
                                                 ""   ';
		 

}else{
	$cache = LOADING;
}