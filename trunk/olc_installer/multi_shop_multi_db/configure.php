<?php
/* --------------------------------------------------------------

olCommerce v4/AJAX

http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 olCommerce, 2006 Dipl-Ing(TH) Winfried Kaiser (wkaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------

based on:

(c) 2000-2001 	The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 	osCommerce (configurephp,v 113 2003/02/10); www.oscommerce.com
(c) 2004  			XT - Commerce; www.ol-Commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/
//
//	Multi-Store parameters
//

// Directory of the full olCommerce installation
define('MASTER_SHOP_DIRECTORY', '/seifenparadies/Kopie_von_olcommerce_1_2_2A_AJAX_Test/olcommerce/');		//Is set by the installer
// Directory of the Multi-Shop
define('MULTI_SHOP_DIRECTORY', '/seifenparadies/Kopie_von_olcommerce_1_2_2A_AJAX_Test/olcommerce/_1');		//M u s t  be  m a n u a l l y  set to the actual value!!!!

//We want "Cool-Menu" for this store
define('SHOW_COOL_MENU', true); // Set to 'true' to use DHTML-menu

//If a different database then that of the master shop is to be used for that store, define it here
/*
// define alternative database connection
define('DB_SERVER', '');
define('DB_SERVER_USERNAME', '');
define('DB_SERVER_PASSWORD', '');
define('DB_DATABASE', '');
*/
/*
//And/or you can use different tables (in the same database), by installing the DB with a different table prefix
//define('TABLE_PREFIX', 'olc_1_'); // eg, olc1_
*/

/*
//
//Multi-DB function!
//
//Split DB into 2 DB's!
//
//One "common" products (and other) database plus
//multiple "individual" databases for orders, customers (et.al.)
//
//This allows the creation of shop portals with a common products structure, but different merchants!
//
//The "common" database m u s t always be installed on the main database of the installation!
//(either the DB of the olCommerce-installation, or the one specified previously)
//
//The "individual" databases m u s t always be installed on a second(!) database!
//
// ***** Note: Multiple DB servers(!) are not allowed (yet?)! Do not remove comments on the following lines!
//define('DB_SERVER_1', '');
//define('DB_SERVER_USERNAME_1', '');
//define('DB_SERVER_PASSWORD_1', '');
//define('DB_DATABASE_1', '');
// ***** Note: Multiple DB servers(!) are not allowed (yet?)! Do not remove comments on the previous lines!
//
*/
//"Individual" database for this store
define('DB_DATABASE_1', '`olc_test`.'); //You can use different DB's on then s a m e server!
define('TABLE_PREFIX_INDIVIDUAL_DATA',''); //and/or different prefixes in the  s a m e  DB!!

//Set "Multi-Shop" host
$host=getenv('HTTP_HOST');
define('HTTP_SERVER', 'http://'.$host);
define('HTTPS_SERVER', 'https://'.$host);
?>