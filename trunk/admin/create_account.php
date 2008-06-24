<?php
/* --------------------------------------------------------------
$Id: create_account.php,v 1.1.1.1.2.1 2007/04/08 07:16:26 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(customers.php,v 1.76 2003/05/04); www.oscommerce.com
(c) 2003	    nextcommerce (create_account.php,v 1.17 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------
Third Party contribution:
Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

Released under the GNU General Public License
--------------------------------------------------------------*/

require_once('includes/application_top.php');
$customers_statuses_array = olc_get_customers_statuses();
$IsCreateAccount =true;
if ($_GET['action'] == 'edit')
{
	//	W. Kaiser - Common code for "create_account.php" and "customers.php"
	$from_table_zones =SQL_FROM . TABLE_ZONES . " where zone_country_id = '";
	include(DIR_FS_INC.'olc_get_check_customer_data.inc.php');
	//	W. Kaiser - Common code for "create_account.php" and "customers.php"
		// Create insert into admin access table if admin is created.
	if (!$error)
	{
		olc_db_query(INSERT_INTO . TABLE_CUSTOMERS_INFO .
			" (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('" .
			$cc_id . "', '0', now())");

		// Create eMail
		if ($customers_send_mail == 'yes')
		{
			$name=trim($customers_lastname . BLANK . $customers_firstname);
			$smarty->assign('NAME',$name);
			$smarty->assign('EMAIL',$customers_email_address);
			$smarty->assign('COMMENTS',$customers_mail_comments);
			$smarty->assign('PASSWORD',$customers_password);
			$txt_mail=CURRENT_TEMPLATE_ADMIN_MAIL.'create_account_mail';
			$html_mail=$smarty->fetch($txt_mail.HTML_EXT);
			$txt_mail=$smarty->fetch($txt_mail.'.txt');
			//	W. Kaiser - eMail-type by customer
			olc_php_mail(EMAIL_SUPPORT_ADDRESS,EMAIL_SUPPORT_NAME,$customers_email_address,
			$name , EMAIL_SUPPORT_FORWARDING_STRING, EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME,
			EMPTY_STRING, EMPTY_STRING, EMAIL_SUBJECT, $html_mail , $txt_mail, $customers_email_type);
			//	W. Kaiser - eMail-type by customer
		}
		olc_redirect(olc_href_link(FILENAME_CUSTOMERS, 'cID=' . $cc_id, SSL));
	}
}
//	W. Kaiser - eMail-type by customer
else
{
	$customers_email_type =  EMAIL_USE_HTML ?  EMAIL_TYPE_HTML : EMAIL_TYPE_TEXT;
}
	include(DIR_WS_INCLUDES . 'html_head_full.php');
	//	W. Kaiser - Common code for "create_account.php" and "customers.php"
	include(DIR_WS_INCLUDES . 'check_form.js.php');
	//	W. Kaiser - Common code for "create_account.php" and "customers.php"
?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
		<?php require_once(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="middle" class="pageHeading"><?php echo HEADING_TITLE; ?></td>
          </tr>
        </table></td>
      </tr>
<?php

	//	W. Kaiser - Common code for "create_account.php" and "customers.php"
	include(DIR_FS_INC.'olc_show_customer_data_form.inc.php');
	//	W. Kaiser - Common code for "create_account.php" and "customers.php"

?>
      </table></td>
      </tr>
    </table></td>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
