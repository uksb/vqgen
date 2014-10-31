<?php
/**
 * vQmod XML Generator v3.3.0
* 
 * Generate XML files for use with vQmod.
 * Built-in File Manager and Log Viewer.
 *
 * For further information please visit {@link http://www.vqmod.com/}
 * 
 * @author Simon Powers - UK Site Buidler Ltd <info@uksitebuilder.net> {@link http://uksb.github.com/vqgen/}
 * @copyright Copyright (c) 2014, UK Site Builder Ltd
 * @version $Id: vqcachefile.php, v3.3.0 2013-08-19 22:30:00 sp Exp $
 * @license http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-ShareAlike 3.0 Unported License
 */
 
echo json_encode(file_get_contents($_GET['cachefile'], FILE_USE_INCLUDE_PATH, null));
?>