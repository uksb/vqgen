# vQmod XML Generator v3.3.0

* Generate & Edit XML files for use with vQmod versions 2.4.0 or greater
* Built-in vQmod File Manager, vQmod Log Viewer and vQmod Cache File Viewer

**Pre-Requisite**

vQmod version 2.4.0 or greater is required for this package

For further information on vQmod and to download it, please visit http://www.vqmod.com/

**author** Simon Powers - UK Site Buidler Ltd <info@uksitebuilder.net> - http://www.opencart-extensions.co.uk/

Copyright (c) 2014, UK Site Builder Ltd

**version** $Id: README.md, v3.3.0 2013-08-19 22:30:00 sp Exp $

**license** http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-ShareAlike 3.0 Unported License


**Installation & Defaults**

1. Edit index.php and add a Password for the define('PASSWORD', ''); line
e.g. define('PASSWORD', 'SOMETHING MEMORABLE');
If you leave the Password undefined, no login screen will be presented [Anyone can access the vQgen tool]
It is only recommended to leave the Password blank if you are using this tool on your local machine and not on the www.
You can of course secure the vqgen folder using a htaccess/htpasswd combination if you wish - see (https://www.google.co.uk/search?hl=en-GB&source=hp&biw=&bih=&q=htaccess+htpasswd+tutorial)  

2. Upload or upload and rename the 'vqgen' directory in this archive to your site root.

If not putting the folder on the same level as the vqmod directory, edit the vqgen/index.php and change the relative paths for the set of 4 defines.


**Known Issues**

* Fails to read vqmod xml files that contain html comments which are outside of CDATA tags.


**Future Would Likes**

Generate a manual installation text or html file from the vqmod with easy to follow instructions
Display list of vqmodable files (.php .tpl) load in to side-by-side panel
