<?php
/* --------------------------------------------------------------
   $Id: file_manager.php,v 2.0.0 2006/12/14 05:48:37 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(file_manager.php,v 1.17 2003/02/16); www.oscommerce.com 
   (c) 2003	    nextcommerce (file_manager.php,v 1.4 2003/08/14); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'File Manager');

define('TABLE_HEADING_FILENAME', 'Name');
define('TABLE_HEADING_SIZE', 'Size');
define('TABLE_HEADING_PERMISSIONS', 'Permissions');
define('TABLE_HEADING_USER', 'User');
define('TABLE_HEADING_GROUP', 'Group');
define('TABLE_HEADING_LAST_MODIFIED', 'Last Modified');
define('TABLE_HEADING_ACTION', 'Action');

define('TEXT_INFO_HEADING_UPLOAD', 'Upload');
define('TEXT_FILE_NAME', 'Filename:');
define('TEXT_FILE_SIZE', 'Size:');
define('TEXT_FILE_CONTENTS', 'Contents:');
define('TEXT_LAST_MODIFIED', 'Last Modified:');
define('TEXT_NEW_FOLDER', 'New Folder');
define('TEXT_NEW_FOLDER_INTRO', 'Enter the name for the new folder:');
define('TEXT_DELETE_INTRO', 'Are you sure you want to delete this file?');
define('TEXT_UPLOAD_INTRO', 'Please select the files to upload.');

define('ERROR_DIRECTORY_NOT_WRITEABLE', 'Error: I can not write to this directory. Please set the right user permissions on: %s');
define('ERROR_FILE_NOT_WRITEABLE', 'Error: I can not write to this file. Please set the right user permissions on: %s');
define('ERROR_DIRECTORY_NOT_REMOVEABLE', 'Error: I can not remove this directory. Please set the right user permissions on: %s');
define('ERROR_FILE_NOT_REMOVEABLE', 'Error: I can not remove this file. Please set the right user permissions on: %s');
define('ERROR_DIRECTORY_DOES_NOT_EXIST', 'Error: Directory does not exist: %s');
?>
