<?php
/* -----------------------------------------------------------------------------------------
 $Id: olc_set_customer_status_upgrade.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:40 gswkaiser Exp $   

 OL-Commerce Version 5.x/AJAX
 http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on: 
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
(c) 2003	    nextcommerce (olc_set_customer_status_upgrade.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License 
---------------------------------------------------------------------------------------*/
   
//set customer satus to new customer for upgrade account
function olc_set_customer_status_upgrade($customer_id)
{
	if (CUSTOMER_STATUS_ID ==  DEFAULT_CUSTOMERS_STATUS_ID_NEWSLETTER )
	{
		if ($_SESSION['customer_status_value']['customers_is_newsletter'] == 0 )  
		{
			olc_db_query(SQL_UPDATE . TABLE_CUSTOMERS . " set customers_status = '" . DEFAULT_CUSTOMERS_STATUS_ID . 
			"' where customers_id = '" . $_SESSION['customer_id'] . APOS);
			olc_db_query(INSERT_INTO . TABLE_CUSTOMERS_STATUS_HISTORY . 
			" (customers_id, new_value, old_value, date_added, customer_notified) values ('".
			CUSTOMER_ID."', '" . DEFAULT_CUSTOMERS_STATUS_ID . "', '" . DEFAULT_CUSTOMERS_STATUS_ID_NEWSLETTER . 
			"', now(), '" . $customer_notified . "')");
		}
	}
	return true;
}
?>
