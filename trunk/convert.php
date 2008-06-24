<?php
/* --------------------------------------------------------------
$Id: newsletter.php,v 1.0

OLC-NEWSLETTER_RECIPIENTS RC1 - Contribution for XT-Commerce http://www.xt-commerce.com
by Matthias Hinsche http://www.gamesempire.de

Copyright (c) 2003 XT-Commerce
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce www.oscommerce.com
(c) 2003	    nextcommerce www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

(c) 2003 xt-commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

require('includes/application_top.php');
require_once(DIR_FS_INC.'olc_encrypt_password.inc.php');

function olc_array_merge($array1, $array2, $array3 = '') {
	if ($array3 == '') $array3 = array();
	if (function_exists('array_merge')) {
		$array_merged = array_merge($array1, $array2, $array3);
	} else {
		while (list($key, $val) = each($array1)) $array_merged[$key] = $val;
		while (list($key, $val) = each($array2)) $array_merged[$key] = $val;
		if (sizeof($array3) > 0) while (list($key, $val) = each($array3)) $array_merged[$key] = $val;
	}

	return (array) $array_merged;
}

$cn_query = olc_db_query("select * from " . TABLE_CUSTOMERS . " where customers_newsletter= '1' ");
while($cn = olc_db_fetch_array($cn_query)){

	$key = olc_encrypt_password($cn['customers_email_address']);
	$sql_data_array = array('customers_email_address' => olc_db_prepare_input($cn['customers_email_address']),
	'customers_id' => olc_db_prepare_input($cn['customers_id']),
	'customers_status' => olc_db_prepare_input($cn['customers_status']),
	'customers_firstname' => olc_db_prepare_input($cn['customers_firstname']),
	'customers_lastname' => olc_db_prepare_input($cn['customers_lastname']),
	'mail_status' => '1',
	'mail_key' => $key);

	$insert_sql_data = array('date_added' => 'now()');
	$sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
	olc_db_perform(TABLE_NEWSLETTER_RECIPIENTS, $sql_data_array);
}

echo 'DONE'

?>
