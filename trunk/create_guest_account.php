<?php
/* -----------------------------------------------------------------------------------------
$Id: create_guest_account.php,v 1.1.1.1.2.1 2007/04/08 07:16:13 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(create_account.php,v 1.63 2003/05/28); www.oscommerce.com
(c) 2003	    nextcommerce (create_account.php,v 1.27 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License

Guest account idea by Ingo T. <xIngox@web.de>
---------------------------------------------------------------------------------------*/

$IsGuest = true;

require_once('includes/application_top.php');

require_once(BOXES);

$IsCreateAccount = true;
$IsUserMode = true;
define('MESSAGE_STACK_NAME', 'create_account');
define('SMARTY_TEMPLATE', MESSAGE_STACK_NAME) ;

$process = $_POST['action'] == 'process';
if ($process) {
	//	W. Kaiser - Common code for "create_account.php" and "customers.php"
	include(DIR_FS_INC.'olc_get_check_customer_data.php');
	//	W. Kaiser - Common code for "create_account.php" and "customers.php"
	if ($error)
	{
		if (IS_AJAX_PROCESSING)
		{
			//Add messagestackinfo
			if (is_object($messageStack))
			{
				$m=$messageStack->size(MESSAGE_STACK_NAME);
				if ($m > 0)
				{
					ajax_error($messageStack->output(MESSAGE_STACK_NAME));
				}
			}
		}
	}
	else
	{
		olc_redirect(olc_href_link(FILENAME_CHECKOUT_SHIPPING));
	}
}
//	W. Kaiser - Common code for "create_account.php" and "customers.php"
include(DIR_FS_INC.'olc_show_customer_data_form.inc.php');
//	W. Kaiser - Common code for "create_account.php" and "customers.php"
?>