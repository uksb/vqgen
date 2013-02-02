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
 * @version $Id: logfile.php, v3.2.0 2013-02-02 01:30:00 sp Exp $
 * @license http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-ShareAlike 3.0 Unported License
 */
 
echo json_encode(file_get_contents($_GET['log'], FILE_USE_INCLUDE_PATH, null));
?>