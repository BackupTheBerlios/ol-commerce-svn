<?php
/*
  $Id: attributemanagerupdateatomic.inc.php,v 1.1.1.1 2006/12/22 13:37:21 gswkaiser Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
  
  Web Development
  http://www.kangaroopartners.com
*/

require_once('attributemanager/includes/attributemanagerconfig.inc.php');
require_once('attributemanager/classes/db.class.php');
require_once('attributemanager/classes/stopdirectaccess.class.php');
	
// Check the session var exists
if(is_array(${AM_SESSION_VAR_NAME}) && is_numeric($products_id)){
	
	// get a new db instance
	$objDB = new DB();
	
	foreach(${AM_SESSION_VAR_NAME} as $newAttribute) {
		
		$newAttributeData = array(
			'products_id' => $objDB->input($productsId),
			'options_id' => $objDB->input($newAttribute['options_id']),
        	'options_values_id' => $objDB->input($newAttribute['options_values_id']),
        	'options_values_price' => $objDB->input($newAttribute['options_values_price']),
        	'price_prefix' => $objDB->input($newAttribute['price_prefix'])
        );
		
		// insert it into the database
		$objDB->perform(TABLE_PRODUCTS_ATTRIBUTES, $newAttribute);
	}
	
	/**
	 * Delete the temporary session var
	 */
	unset(${AM_SESSION_VAR_NAME});
	olc_session_unregister(AM_SESSION_VAR_NAME);
	
	/**
	 * remove the direct access authorization so that if the session is hijacked they wont be able
	 * access the attributeManagerFile directly without first going to the product addition page.
	 * If thats not secured then it doesn't really matter what this script does they have compleate access anyway im not at fault
	 */
	stopdirectaccess::deAuthorise(AM_SESSION_VALID_INCLUDE);
}

?>