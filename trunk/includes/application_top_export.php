<?php
/* -----------------------------------------------------------------------------------------
   $Id: application_top_export.php,v 1.1.1.1.2.1 2007/04/08 07:17:44 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(application_top.php,v 1.273 2003/05/19); www.oscommerce.com
   (c) 2003	 nextcommerce (application_top.php,v 1.54 2003/08/25); www.nextcommerce.org
(c) 2004  XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:
   Add A Quickie v1.0 Autor  Harald Ponce de Leon
       (c) 2004  XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  // start the timer for the page parse time log
  define('PAGE_PARSE_START_TIME', microtime());

  define('PHP','.php');
  define('INC_PHP','.inc.php');
  $PHP_SELF = $_SERVER['PHP_SELF'];

  // set the level of error reporting
  error_reporting(E_ALL & ~E_NOTICE);
//  error_reporting(E_ALL);

include('../includes/configure.php');
// require_once('../inc/olc_define_global_constants.inc.php');

  define('DIR_FS_INC', DIR_FS_CATALOG . 'inc/');
  define('DIR_FS_INCLUDES', DIR_FS_CATALOG . 'includes/');
  define('DIR_FS_CLASSES', DIR_FS_INCLUDES . 'classes/');


  // define the project version
  define('PROJECT_VERSION', 'OL-Commerce X');
  define('OL_COMMERCE',true);
  
  // set the type of request (secure or not)
  $request_type = (getenv(HTTPS) !=null) ? SSL : NONSSL;

  // set php_self in the local scope
  $PHP_SELF = $_SERVER['PHP_SELF'];

  // include the list of project filenames
  require(DIR_FS_INCLUDES . 'filenames.php');

  // include the list of project database tables
  require(DIR_FS_INCLUDES . 'database_tables.php');

  // customization for the design layout
  define('BOX_WIDTH', 125); // how wide the boxes should be in pixels (default: 125)

  // Store DB-Querys in a Log File
  define('STORE_DB_TRANSACTIONS', FALSE_STRING_S);

// require_once('../inc/olc_connect_and_get_config.inc.php');
  require_once('../inc/olc_error_handler.inc.php');
  require_once('../inc/olc_error_message.inc.php');

  // include used functions
	$db_inc=DIR_FS_INC.'olc_db_';
  require_once($db_inc.'connect.inc.php');
  require_once($db_inc.'close.inc.php');
 
  require_once($db_inc.'error.inc.php');
  require_once($db_inc.'perform.inc.php');
  require_once($db_inc.'query.inc.php');
  require_once($db_inc.'fetch_array.inc.php');
  require_once($db_inc.'num_rows.inc.php');
  require_once($db_inc.'data_seek.inc.php');
  require_once($db_inc.'insert_id.inc.php');
  require_once($db_inc.'free_result.inc.php');
  require_once($db_inc.'fetch_fields.inc.php');
  require_once($db_inc.'output.inc.php');
  require_once($db_inc.'input.inc.php');
  require_once($db_inc.'prepare_input.inc.php');

  require_once(DIR_FS_INC.'olc_get_products_attribute_price.inc.php');
  
  //!!!
//  olc_connect_and_get_config(NULL,$admin_path_prefix);
  // modification for new graduated system
 // make a connection to the database... now
  olc_db_connect() or die('Unable to connect to database server!');

  // set the application parameters
  $configuration_query =
  	olc_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from ' . TABLE_CONFIGURATION);
  while ($configuration = olc_db_fetch_array($configuration_query)) {
    define($configuration['cfgKey'], $configuration['cfgValue']);
  }
  // if gzip_compression is enabled, start to buffer the output
  if ( (GZIP_COMPRESSION == TRUE_STRING_S) && ($ext_zlib_loaded = extension_loaded('zlib')) && (PHP_VERSION >= '4') ) {
    if (($ini_zlib_output_compression = (int)ini_get('zlib.output_compression')) < 1) {
      ob_start('ob_gzhandler');
    } else {
      ini_set('zlib.output_compression_level', GZIP_LEVEL);
    }
  }

    // Include Template Engine
 require_once(DIR_FS_CLASSES . 'smarty/Smarty.class.php');

?>