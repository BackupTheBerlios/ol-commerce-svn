<?php
/* --------------------------------------------------------------
   $Id: manufacturers.php,v 2.0.0 2006/12/14 05:48:38 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(manufacturers.php,v 1.14 2003/02/16); www.oscommerce.com 
   (c) 2003	    nextcommerce (manufacturers.php,v 1.4 2003/08/14); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Manufacturers');

define('TABLE_HEADING_MANUFACTURERS', 'Manufacturers');
define('TABLE_HEADING_ACTION', 'Action');

define('TEXT_HEADING_NEW_MANUFACTURER', 'New Manufacturer');
define('TEXT_HEADING_EDIT_MANUFACTURER', 'Edit Manufacturer');
define('TEXT_HEADING_DELETE_MANUFACTURER', 'Delete Manufacturer');

define('TEXT_MANUFACTURERS', 'Manufacturers:');
define('TEXT_DATE_ADDED', 'Date Added:');
define('TEXT_LAST_MODIFIED', 'Last Modified:');
define('TEXT_PRODUCTS', 'Products:');
define('TEXT_IMAGE_NONEXISTENT', 'IMAGE DOES NOT EXIST');

define('TEXT_NEW_INTRO', 'Please fill out the following information for the new manufacturer');
define('TEXT_EDIT_INTRO', 'Please make any necessary changes');

define('TEXT_MANUFACTURERS_NAME', 'Manufacturers Name:');
define('TEXT_MANUFACTURERS_IMAGE', 'Manufacturers Image:');
define('TEXT_MANUFACTURERS_URL', 'Manufacturers URL:');

define('TEXT_DELETE_INTRO', 'Are you sure you want to delete this manufacturer?');
define('TEXT_DELETE_IMAGE', 'Delete manufacturers image?');
define('TEXT_DELETE_PRODUCTS', 'Delete products from this manufacturer? (including product reviews, products on special, upcoming products)');
define('TEXT_DELETE_WARNING_PRODUCTS', '<b>WARNING:</b> There are %s products still linked to this manufacturer!');

define('ERROR_DIRECTORY_NOT_WRITEABLE', 'Error: I can not write to this directory. Please set the right user permissions on: %s');
define('ERROR_DIRECTORY_DOES_NOT_EXIST', 'Error: Directory does not exist: %s');
?>?>
