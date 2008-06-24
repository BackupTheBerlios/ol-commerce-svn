<?php
/*
  $Id: attributemanagerconfig.inc.php,v 1.1.1.1 2006/12/22 13:37:21 gswkaiser Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License

  Web Development
  http://www.kangaroopartners.com
*/


/**
 * Main session Var Name:
 * this is used for storing the current product attributes before the product is entered into the db
 */
define('AM_SESSION_VAR_NAME','am_session_var');

/**
 * Valid Include session Name:
 * this is used to check that the attributeMangager.php file cannot be called without a valid session
 */
define('AM_SESSION_VALID_INCLUDE','am_valid_include');


define('AM_VALID_INCLUDE_PASSWORD','password');
/**
 * For now this is a singular static id, if comunity response to this contribution is good and people require it to be multiligual.
 * I will implement that in the future.
 */
define('AM_LANGUAGE_ID',SESSION_LANGUAGE_ID);

/**
 * By default (false) when you are EDITING a product this script will automaticly update the database as you go along.
 * Every value you change will be instantly updated in the database.
 *
 * Change this value to tre, if you would like to wait until the final step of the product addition process to update the database.
 * This only affects EDITING products. All NEW products are always atomic.
 */
define('AM_ATOMIC_PRODUCT_UPDATES', false);

/**
 * Default Open / Closed states of the attribute manager sections
 */
define('AM_USE_TEMPLAETS',false);
define('AM_TEMPLATES_OPEN',false);
define('AM_ATTRIBUTES_OPEN',true);
define('AM_NEW_ATTRIBUTES_OPEN',true);
?>