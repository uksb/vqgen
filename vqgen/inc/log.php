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
 * @version $Id: log.php,v 3.1.0 2013-01-30 10:00:00 sp Exp $
 * @license http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-ShareAlike 3.0 Unported License
 */

// Clear Log File
if(isset($_GET['clearlog'])){
	$handle = fopen(LOG . current_log_file(LOG), 'w+'); 
	fclose($handle);
	header("Location:./?handle2=".current_log_file(LOG));
}

if(isset($_GET['clearlogs'])){
	$files = glob(LOG . '*'); // get all file names
	foreach($files as $file){ // iterate files
	  if(is_file($file))
		unlink($file); // delete file
	}
	header("Location:./?handle2=alllogs");
}

// Get vQmod Log file data
if(current_log_file(LOG) != '' && filesize(LOG . current_log_file(LOG))>(LOGMAX*1048576)) {
	$log = sprintf(LOG_LARGE, LOGMAX, current_log_file(LOG)) . '
	
	
	
	
		    ____
		   / __ \
		  ( (__) )
		  _\____/___
		 /  |  |   /\
		/_________/  \_
	       /          \    \
	      /            \    \_
	     /              \     \
	    /    _     _     \     \_
	   /    / |   //      \      \
	  /    //||  //        \      \_
	 /       || || __       \       \
	/        || ||/__\       \       \_
       /         || ||/  \\       \        \
      /         _||_ \\__//        \        \_
     /          ----  ----     __   \         \
    /      _____   _   _   _  //     \        /
   /      |__ __| / \ | \ | | \\      \      /
  /         | |  | O ||  \| |  \\      \    /
 /          |_|   \_/ |_|\__| _//       \  /
/________________________________________\/


';
}elseif(current_log_file(LOG)!=''&&filesize(LOG . current_log_file(LOG))<1) {
	$log = sprintf(LOG_EMPTY, current_log_file(LOG)) . '






                                    oooo$$$$$$$$$$$$oooo
                                oo$$$$$$$$$$$$$$$$$$$$$$$$o
                             oo$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$o         o$   $$ o$
             o $ oo        o$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$o       $$ $$ $$o$
          oo $ $ "$      o$$$$$$$$$    $$$$$$$$$$$$$    $$$$$$$$$o       $$$o$$o$
          "$$$$$$o$     o$$$$$$$$$      $$$$$$$$$$$      $$$$$$$$$$o    $$$$$$$$
            $$$$$$$    $$$$$$$$$$$      $$$$$$$$$$$      $$$$$$$$$$$$$$$$$$$$$$$
            $$$$$$$$$$$$$$$$$$$$$$$    $$$$$$$$$$$$$    $$$$$$$$$$$$$$  """$$$
             "$$$""""$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$     "$$$
              $$$   o$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$     "$$$o
             o$$"   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$       $$$o
             $$$    $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$" "$$$$$$ooooo$$$$o
            o$$$oooo$$$$$  $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$   o$$$$$$$$$$$$$$$$$
            $$$$$$$$"$$$$   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$     $$$$""""""""""""""
            """"""""  $$$$    "$$$$$$$$$$$$$$$$$$$$$$$$$$$$"      o$$$
                      "$$$o     """$$$$$$$$$$$$$$$$$$"$$"         $$$
                        $$$o          "$$""$$$$$$""""           o$$$
                         $$$$o                                o$$$"
                          "$$$$o      o$$$$$$o"$$$$o        o$$$$
                            "$$$$$oo     ""$$$$o$$$$$o   o$$$$""
                               ""$$$$$oooo  "$$$o$$$$$$$$$"""
                                  ""$$$$$$$oo $$$$$$$$$$
                                          """"$$$$$$$$$$$
                                              $$$$$$$$$$$$
                                               $$$$$$$$$$"
                                                "$$$""  ';
}elseif(!file_exists(LOG . date("D") . '.log')){
	$handle = fopen(LOG . date("D") . '.log', 'w+'); 
	fclose($handle);
	$log = sprintf(LOG_EMPTY, date("D") . '.log') . '






                                    oooo$$$$$$$$$$$$oooo
                                oo$$$$$$$$$$$$$$$$$$$$$$$$o
                             oo$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$o         o$   $$ o$
             o $ oo        o$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$o       $$ $$ $$o$
          oo $ $ "$      o$$$$$$$$$    $$$$$$$$$$$$$    $$$$$$$$$o       $$$o$$o$
          "$$$$$$o$     o$$$$$$$$$      $$$$$$$$$$$      $$$$$$$$$$o    $$$$$$$$
            $$$$$$$    $$$$$$$$$$$      $$$$$$$$$$$      $$$$$$$$$$$$$$$$$$$$$$$
            $$$$$$$$$$$$$$$$$$$$$$$    $$$$$$$$$$$$$    $$$$$$$$$$$$$$  """$$$
             "$$$""""$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$     "$$$
              $$$   o$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$     "$$$o
             o$$"   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$       $$$o
             $$$    $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$" "$$$$$$ooooo$$$$o
            o$$$oooo$$$$$  $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$   o$$$$$$$$$$$$$$$$$
            $$$$$$$$"$$$$   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$     $$$$""""""""""""""
            """"""""  $$$$    "$$$$$$$$$$$$$$$$$$$$$$$$$$$$"      o$$$
                      "$$$o     """$$$$$$$$$$$$$$$$$$"$$"         $$$
                        $$$o          "$$""$$$$$$""""           o$$$
                         $$$$o                                o$$$"
                          "$$$$o      o$$$$$$o"$$$$o        o$$$$
                            "$$$$$oo     ""$$$$o$$$$$o   o$$$$""
                               ""$$$$$oooo  "$$$o$$$$$$$$$"""
                                  ""$$$$$$$oo $$$$$$$$$$
                                          """"$$$$$$$$$$$
                                              $$$$$$$$$$$$
                                               $$$$$$$$$$"
                                                "$$$""  ';
}else{
	$log = LOADING;
}
