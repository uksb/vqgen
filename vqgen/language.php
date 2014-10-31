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
 * @version $Id: language.php, v3.3.0 2013-08-19 22:30:00 sp Exp $
 * @license http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-ShareAlike 3.0 Unported License
 */

// General
define('PACKAGE_NAME', 'vQmod XML File Generator');
define('OPENING_STATEMENT', '<p>First of all you need to install vQmod version 2.4.x or greater if you haven\'t got it already.</p><p>For more info on vQmod and what it does visit <a href="http://www.vqmod.com/">vQmod.com</a></p>');
define('FILL_OUT_FORM', 'Fill out the form below with your file edits');
define('LOGIN', 'Login');
define('LOGINFAIL', 'Incorrect Login - Please Try Again!');
define('LOGINPASSWORD', '<b>Password:</b> ');

// vQmod Files Pull Down section
define('VQMOD_FILES_INACTIVE', 'Newly Created, Edited and Inactive vQmod Files');
define('VQMOD_FILES_ACTIVE', 'Active vQmod Files');
define('DELETE_VQMOD_CACHE', 'vQmod Cache will be cleared on enable/delete');
define('ENABLE_ALL', 'Enable ALL');
define('TH_FILENAME', 'Filename');
define('TH_ACTION', 'Action');
define('VER', 'Ver:');
define('VQMOD', 'vQmod:');
define('SIZE', 'Size:');
define('DATE', 'Date:');
define('VQMOD_AUTHOR', 'Author:');
define('EDIT', 'Edit');
define('ENABLE', 'Enable');
define('GET', 'Get');
define('DELETE', 'Delete');
define('DELETE_CONFIRM', 'Are you sure you want to delete: ');
define('DISABLE_VQMOD_CACHE', 'vQmod Cache will be cleared on disable/delete<br>File will be disabled on edit and vQmod Cache cleared');
define('DISABLE_ALL', 'Disable ALL');
define('DISABLE', 'Disable');

// vQmod Log Pull Down section
define('VQMOD_LOG_FILES', 'vQmod Log Files');
define('CLEAR_VQMOD_LOGS', 'Clear ALL vQmod Logs');
define('CLEAR_THIS_LOG', 'Clear This vQmod Log');
define('LOG_LARGE', 'Log file too large to display (greater than %dmb) - Either manually download %s or clear the log file');
define('LOG_EMPTY', '%s is empty - No errors to report - Yippee!');

// vQmod Cache Pull Down section
define('VQMOD_CACHE_FILES', 'vQmod Cache Files');
define('CLEAR_VQMOD_CACHE', 'Clear vQmod Cache');
define('CLEAR_MODS_CACHE', 'Clear mods.cache file');
define('CACHE_FILES', 'vQmod Cache Files: ');
define('CHOOSE_ONE', 'Choose a File');
define('CHOOSE_CACHE_FILE', 'Please choose a Cache File from the drop down menu to view it\'s contents
	
If you have just created or amended a vQmod XML file, please visit the main website and perform all related actions so that the relevant vQmod Cache files are generated');
define('CACHE_IS_EMPTY', ' is empty - Please choose a Cache File from the drop down menu to view it\'s contents');

// Buttons
define('CREATE_NEW_FILE', 'Create a New file');
define('ENABLE_THIS_VQMOD', 'Enable this vQmod');
define('ADD_OPERATION', 'Add a new operation');
define('ADD_FILE', 'Add a new file to edit');
define('START_OVER', 'Start Over');
define('GENERATE_XML_FILE', 'Generate XML File');

// Legends
define('GENERAL_FILE_INFO', 'General file info');
define('FILE_TO_EDIT', 'File to edit');
define('OPERATION_TO_PERFORM', 'Operation to perform');

// Labels
define('FILENAME', '<b>Filename:</b>');
define('FILENAMES', '<b>Filename(s):</b>');
define('TITLE', '<b>Title:</b>');
define('FILE_VERSION', '<b>File Version:</b>');
define('VQMOD_VERSION', '<b>vQmod Version:</b>');
define('AUTHOR', '<b>Author:</b>');
define('PATH_TO_FILENAMES', '<b>Path to Filename(s):</b>');
define('REMOVE_ON_GENERATE', 'Remove on Generate');
define('INFO', '<b>Info:</b>');
define('SEARCH', '<b>Search:</b>');
define('POSITION', '<b>Action:</b>');
define('OFFSET', '<b>Offset:</b>');
define('INDEX', '<b>Index:</b>');
define('ERROR', '<b>Error:</b>');
define('REGEX', '<b>Regex:</b>');
define('IGNOREIF', '<b>Ignore If:</b>');

// Help Text
define('FILENAME_HELP', 'This will be the Generated XML filename');
define('TITLE_HELP', 'The extension name or a brief summary of what this mod does');
define('FILE_VERSION_HELP', 'The extension version number');
define('VQMOD_VERSION_HELP', 'The version of vQmod this extension was tested on');
define('AUTHOR_HELP', 'Your name and/or website address');
define('INFO_ASSIST', 'Summary of Operation');
define('SEARCH_ASSIST', 'Single Line or String to Search for');
define('POSITION_HELP', 'What to do with the \"Add\" data');
define('OFFSET_ASSIST', 'Single Integer ONLY');
define('OFFSET_HELP', 'When Adding, add before/after \"Search\" + this number of lines. When Replacing, replace \"Search\" + this number of lines');
define('INDEX_ASSIST', 'Single or Comma Separated Integers ONLY');
define('INDEX_HELP', 'If the \"Search\" string is \'echo\' and there are 5 echos in the file, but you only want to replace the 1st and 3rd, use Index: 1,3');
define('ERROR_ASSIST', 'Abort & Log is default');
define('ERROR_HELP', 'What to do when \"Search\" can not be found');
define('REGEX_ASSIST', 'False is default');
define('REGEX_HELP', 'To use a regular expression for \"Search\", set to \'True\'');
define('IGNOREIF_ASSIST', 'Ignore this operation IF this string is found in file');
define('IGREGEX_HELP', 'To use a regular expression for \"Ignore If\", set to \'True\'');

// Select Lists Text
define('REPLACE', 'Replace \"Search\"');
define('BEFORE', 'Add Before \"Search\"');
define('AFTER', 'Add After \"Search\"');
define('IBEFORE', 'Add Inline Before \"Search\"');
define('IAFTER', 'Add Inline After \"Search\"');
define('TOP', 'Add to Top of File');
define('BOTTOM', 'Add to Bottom of File');
define('ALL', 'Replace Entire File');
define('ABORT_LOG', 'Abort &amp; Log');
define('SKIP_LOG', 'Skip &amp; Log');
define('SKIP_NO_LOG', 'Skip don\'t Log');
define('ISTRUE', 'True');
define('ISFALSE', 'False');
define('ADD', 'Add');
define('NEW_OPERATIONS', 'new operation(s) after this one');
define('NOW', 'Now!');

// Alerts
define('CLEAR_REMOVE_ON_GENERATE', "Please clear the \'Remove on Generate\' checkbox for this file, if you wish to add a new operation to it.\\n\\nAlternatively, you can add a new file to edit.");

// Messages
define('FILE_GENERATED', 'File Generated Successfully at ');
define('CONTENT', 'Content');
define('LOADING', 'Loading...');
define('DONATE', 'If you find this tool useful, please buy me a beer or two :-)');
define('CLEARED_MODSCACHE', 'The mods.cache file has been cleared!');
define('CLEARED_VQCACHE', 'The vqmod/vqcache folder has been emptied!');
define('CLEARED_VQCACHEFILE', 'vqmod/vqcache/%s has been deleted!');
define('CLEARED_ALL_LOGS', 'All vqmod/logs files have been deleted!');
define('CLEARED_LOG_FILE', 'vqmod/logs/%s has been deleted!');
define('VQMOD_FILE_DELETED', 'vqmod/xml/%s has been deleted!');
define('VQMOD_FILE_DISABLED', 'vqmod/xml/%s has been disabled!');
define('VQMOD_FILES_DISABLED', 'All vqmod/xml files have been disabled!');
define('VQMOD_FILE_ENABLED', 'vqmod/xml/%s has been enabled!');
define('VQMOD_FILES_ENABLED', 'All vqmod/xml files have been enabled!');
define('NEWSERROR', '<span style="color:red;font-weight:bold;">UKSB News could not be loaded.</span><br><br><b>Possible causes:</b><ul><li style="margin:6px;0;">You edited the index.php NEWS define with a malformed RSS feed URL.</li><li style="margin:6px;0;">UKSB forgot to update the News feed.</li><li style="margin:6px;0;">The UKSB server is down. Someone forgot to plug it in.</li><li style="margin:6px;0;">You do not have an internet connection.</li></ul>');
