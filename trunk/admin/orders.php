<?php
/* --------------------------------------------------------------
$Id: orders.php,v 1.1.1.1.2.1 2007/04/08 07:16:30 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(orders.php,v 1.109 2003/05/28); www.oscommerce.com
(c) 2003	    nextcommerce (orders.php,v 1.19 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------
Third Party contribution:
OSC German Banktransfer v0.85a       	Autor:	Dominik Guder <osc@guder.org>
Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

credit card encryption functions for the catalog module
BMC 2003 for the CC CVV Module

Released under the GNU General Public License
--------------------------------------------------------------*/

require_once('includes/application_top.php');
require_once(DIR_FS_CATALOG.DIR_WS_CLASSES.'class.phpmailer.php');
require_once(DIR_FS_INC.'olc_php_mail.inc.php');
require_once(DIR_FS_INC.'olc_add_tax.inc.php');
require_once(DIR_FS_INC . 'changedataout.inc.php');

// initiate template engine for mail
require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();

$orders_statuses = array();
$orders_status_array = array();
$language_text='language';
$orders_status_query = olc_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS .
" where language_id = '" . SESSION_LANGUAGE_ID . APOS);
while ($orders_status = olc_db_fetch_array($orders_status_query)) {
	$orders_statuses[] = array(
	'id' => $orders_status['orders_status_id'],
	'text' => $orders_status['orders_status_name']);
	$orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
}
$oID = olc_db_prepare_input($_GET['oID']);
$action=$_GET['action'];
if ($oID )
{
	if ($action == 'edit')
	{
		$orders_query = olc_db_query("select orders_id from " . TABLE_ORDERS . " where orders_id = '" . $oID . APOS);
		$order_exists = olc_db_num_rows($orders_query)>0;
		if (!$order_exists )
		{
			$messageStack->add(sprintf(ERROR_ORDER_DOES_NOT_EXIST, $oID), 'error');
		}
	}
}
//require_once(DIR_WS_CLASSES . 'order.php');
require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES . 'order.php');
if ($action == 'edit' )
{
	if ($order_exists)
	{
		$order = new order($oID);
	}
}
switch ($action)
{
	//begin PayPal_Shopping_Cart_IPN
	case 'accept_order':
		  include(PAYPAL_IPN_DIR.'Admin/AcceptOrder.inc.php');
		  break;
		//end PayPal_Shopping_Cart_IPN	case 'update_order':
	case 'update_order':
		$status = olc_db_prepare_input($_POST['status']);
		$comments = olc_db_prepare_input($_POST['comments']);
		$track_code = $_POST['trackcode'];
		if (!$track_code)
		{
			$track_code = $_GET['trackcode'];
		}
		$order = new order($oID);
		$update=$track_code<>$order->info['orders_trackcode'];
		if (!$update)
		{
			$update=$order->info['orders_status_id'] != $status;
			if (!$update)
			{
				$update=$comments <> EMPTY_STRING;
			}
		}
		if ($update)
		{
			olc_db_query("
			update " . TABLE_ORDERS . "
			set
			orders_status = '" . olc_db_input($status) ."',
			orders_trackcode = '" .$track_code ."',
			last_modified = now()
			where orders_id = '" . $oID . APOS);
			$customer_notified = 0;
			if ($_POST['notify'] == 'on')
			{
				$notify_comments = EMPTY_STRING;
				if ($_POST['notify_comments'] == 'on')
				{
					if ($comment)
					{
						$notify_comments = sprintf(EMAIL_TEXT_COMMENTS_UPDATE, $comments) . "\n\n";
					}
				}
				$customers_name=$order->customer['name'];
				$smarty->assign('NAME',$customers_name);
				$smarty->assign('ORDER_NR',$oID);
				$smarty->assign('ORDER_LINK',olc_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, SSL));
				$smarty->assign('ORDER_DATE',olc_date_long($order->info['date_purchased']));
				$smarty->assign('NOTIFY_COMMENTS',$notify_comments);
				$smarty->assign('ORDER_STATUS',$orders_status_array[$status]);
				//	W. Kaiser - Erlaube Sendungstracking
				$smarty->assign('SHIP_DATE',date('l, j F Y H:i'));
				$txt_mail=str_replace('admin/',EMPTY_STRING,olc_href_link(FILENAME_CUSTOMER_DEFAULT, EMPTY_STRING,NONSSL,false));
				$smarty->assign('HOME_LINK', $txt_mail);
				if ($status == 3)
				{
					//Status "Versendet"
					if ($track_code)
					{
						//Assign smarty Variable for tracking URL
						require_once(DIR_FS_INC.'olc_get_track_code.inc.php');
						$TrackURL=olc_get_track_code($order,$track_code);
						$smarty->assign('TRACK_URL',$TrackURL);
					}
				}
				if ($order->info[$language_text]==EMPTY_STRING)
				{
					$order->info[$language_text]=SESSION_LANGUAGE;
				}
				//	W. Kaiser - Erlaube Sendungstracking
				$customers_email_type=$order->customer['email_type'];
				$mail=CURRENT_TEMPLATE_ADMIN_MAIL.'change_order_mail';
				if ($customers_email_type==EMAIL_TYPE_HTML)
				{
					$html_mail=$smarty->fetch($mail.HTML_EXT);
				}
				else
				{
					$txt_mail=$smarty->fetch($mail.'.txt');
				}
				//	W. Kaiser - eMail-type by customer
				olc_php_mail(
				EMAIL_BILLING_ADDRESS,
				EMAIL_BILLING_NAME ,
				$order->customer['email_address'],
				$customers_name,
				EMPTY_STRING,
				EMAIL_BILLING_REPLY_ADDRESS,
				EMAIL_BILLING_REPLY_ADDRESS_NAME,
				EMPTY_STRING,
				EMPTY_STRING,
				EMAIL_BILLING_SUBJECT,
				$html_mail ,
				$txt_mail,
				$customers_email_type
				);
				//	W. Kaiser - eMail-type by customer
				$customer_notified = 1;
			}
			olc_db_query(INSERT_INTO . TABLE_ORDERS_STATUS_HISTORY .
			" (orders_id, orders_status_id, date_added, customer_notified, comments) values ('" . $oID .
			"', '" . $status . "', now(), '" . $customer_notified . "', '" . $comment  . "')");
			$messageStack->add_session(SUCCESS_ORDER_UPDATED, 'success');
		}
		else
		{
			$messageStack->add_session(WARNING_ORDER_NOT_UPDATED, 'warning');
		}
		olc_redirect(olc_href_link(FILENAME_ORDERS, olc_get_all_get_params(array('action','validate')) . 'action=edit'));
		break;
	case 'deleteconfirm':
		olc_remove_order($oID, $_POST['restock']);

		olc_redirect(olc_href_link(FILENAME_ORDERS, olc_get_all_get_params(array('oID', 'action'))));
		break;
		// BMC Delete CC info Start
		// Remove CVV Number
	case 'deleteccinfo':

		olc_db_query(SQL_UPDATE . TABLE_ORDERS .
		"setcc_cvv=null,cc_number='0000000000000000',cc_expires=null,cc_start=null,cc_issue=nullwhereorders_id='".$oID.APOS);
		olc_redirect(olc_href_link(FILENAME_ORDERS, 'oID=' . $oID  . '&action=edit'));
		break;
		// BMC Delete CC Info End
}
// W. Kaiser Check address validity
if ($order_exists)
{
	$country = $order->billing['country'];
	$is_germany = $country  == 'Deutschland' ;
	if ($is_germany) 		//Country is Germany?
	{
		if (isset($_GET['validate']))
		{
			$country_id = '81';
			$name = $order->billing['name'];
			$name_parts=explode(BLANK,$name);
			if (sizeof($name_parts)>1)
			{
				$firstname=$name_parts[0];
				$name=$name_parts[1];
			}
			$postcode = $order->billing['postcode'];
			$city = $order->billing['city'];
			$street_address0 = $order->billing['street_address'];
			$street_address = $street_address0;
			while (!is_numeric(substr($street_address0,-1)))
			{
				//Remove trailing characters from house number
				$street_address0=substr($street_address0,0,-1);
			}
			if ($street_address0!=EMPTY_STRING)
			{
				$street_address=$street_address0;
			}
			$fon=$order->billing['telephone'];
			$fax=$order->billing['fax'];
			$IsUserMode = false;
			IsValidAddress($country_id, $postcode, $city, $street_address, $name, $firstname,$fon, $fax, $message);
			$street_address_error = check_input_error(true, $message);
			$post_code_error = true;
			$city_error =  true;
		}
	}
}
?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
		<?php require_once(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
if (($action == 'edit') && $order_exists)
{
?>
      <tr>
	      <td width="100%">
					<table border="0" width="100%" cellspacing="0" cellpadding="0">
					  <tr>
					    <td width="80" rowspan="2"><?php echo olc_image(DIR_WS_ICONS.'heading_customers.gif'); ?></td>
					    <td class="pageHeading">
								<?php
								define('AJAX_TITLE',HEADING_TITLE . ' N° : ' . $oID . ' - ' .
								olc_datetime_short($order->info['date_purchased']));
								echo AJAX_TITLE;
								?>
				    	</td>
					  </tr>
					  <tr>
					    <td class="main" valign="top">OLC Kunden</td>
					  </tr>
					</table>

<?php
//begin PayPal_Shopping_Cart_IPN
$is_paypal_ipn=strtolower($order->info['payment_method']) == 'paypal_ipn' && $_GET['referer'] == 'ipn';
if ($is_paypal_ipn)
{
	$file_orders=FILENAME_PAYPAL_IPN;
}
else
{
	$file_orders=FILENAME_ORDERS;
}//else not paypal
echo HTML_A_START . olc_href_link($file_orders, olc_get_all_get_params(array('action','oID','referer'))) .'">' .
olc_image_button('button_back.gif', IMAGE_BACK) . HTML_A_END;
//end PayPal_Shopping_Cart_IPN
?>

 				</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="main" valign="top" bgcolor="#FFCC33">
        	<?php echo HTML_B_START.ENTRY_CID .'</b> '.$order->customer['csID']; ?>
        </td>
      </tr>
      <tr>
        <td colspan="3"><hr/></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><b><?php echo ENTRY_CUSTOMER; ?></b></td>
                <td class="main"><?php echo olc_address_format($order->customer['format_id'],
                $order->customer, 1, EMPTY_STRING, HTML_BR); ?></td>
              </tr>

              <tr>
                <td class="main" valign="top"><b><?php echo CUSTOMERS_MEMO; ?></b></td>
<?php
// memoquery
$memo_query=olc_db_query("SELECT count(*) as count FROM ".TABLE_CUSTOMERS_MEMO." where customers_id='".$order->customer['id'].APOS);
$memo_count=olc_db_fetch_array($memo_query);
?>
                <td class="main"><b><?php echo $memo_count['count'].HTML_B_END; ?>
                <a style="cursor:hand"
									onclick="javascript:ShowInfo('<?php echo olc_href_link(FILENAME_POPUP_MEMO,'pop_up=true&id=' .
                $order->customer['id']); ?>', '')">(<?php echo DISPLAY_MEMOS; ?>)</a></td>
              </tr>
              <tr>
                <td class="main"><b><?php echo ENTRY_TELEPHONE; ?></b></td>
                <td class="main"><?php echo $order->customer['telephone']; ?></td>
              </tr>
              <tr>
                <td class="main"><b><?php echo ENTRY_EMAIL_ADDRESS; ?></b></td>
                <td class="main">
	                	<?php echo '<a href="mailto:' . $order->customer['email_address'] . '"><u>' .
	                	$order->customer['email_address'] . '</u></a>';
	                	?>
                	</td>
              </tr>
            </table></td>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><b><?php echo ENTRY_SHIPPING_ADDRESS; ?></b></td>
                <td class="main"><?php echo olc_address_format($order->delivery['format_id'],
                $order->delivery, 1, EMPTY_STRING, HTML_BR); ?></td>
              </tr>
            </table></td>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><b><?php echo ENTRY_BILLING_ADDRESS; ?></b></td>
                <td class="main"><?php echo olc_address_format($order->billing['format_id'],
                $order->billing, 1, EMPTY_STRING, HTML_BR); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>
        	<table border="0" cellspacing="0" cellpadding="2">
            <tr>
              <td class="main"><b><?php echo IP; ?></b></td>
              <td class="main"><?php echo $order->customer['cIP']; ?></td>
            </tr>
		        <tr>
	            <td class="main"><b><?php echo ENTRY_LANGUAGE; ?></b></td>
	            <td class="main">
	            	<?php
	            		$order_language=$order->info[$language_text];
	            		$is_session_language=$order_language==$_SESSION[$language_text];
	            		if ($is_session_language)
	            		{
	            			$order_language=$_SESSION[$language_text.'_name'];
	            		}
	            		else
	            		{
										$language_query="SELECT name from ".TABLE_LANGUAGES." where directory ='".$order_language.APOS;
										$language_query=olc_db_query($language_query);
										if (olc_db_num_rows($language_query)==1)
										{
											$memo_query=olc_db_fetch_array($language_query);
											$order_language=$memo_query['name'];
										}
	            		}
	            		echo $order_language;
	            	?>
	            </td>
	          </tr>

				<?php
				//begin PayPal_Shopping_Cart_IPN
				if (strtolower($order->info['payment_method']) == 'paypal_ipn')
				{
					    include(PAYPAL_IPN_DIR . 'Admin/TransactionSummaryLogs.inc.php');
				}
				else
				{
				?>
          <tr>
            <td class="main"><b><?php echo ENTRY_PAYMENT_METHOD; ?></b></td>
            <td class="main">
            	<?php
            	$payment_method=$order->info['payment_method'];
            	require(ADMIN_PATH_PREFIX.'lang'.SLASH.SESSION_LANGUAGE.SLASH .'modules/payment'.SLASH.$payment_method.PHP);            		    echo constant('MODULE_PAYMENT_'.strtoupper($payment_method).'_TEXT_TITLE');
            	?>
            </td>
          </tr>
				<?php
				}//else not paypal
				//end PayPal_Shopping_Cart_IPN
				if ((($order->info['cc_type']) || ($order->info['cc_owner']) || ($order->info['cc_number'])) ) {
?>
	          <tr>
	            <td class="main"><?php echo ENTRY_CREDIT_CARD_TYPE; ?></td>
	            <td class="main"><?php echo $order->info['cc_type']; ?></td>
	          </tr>
	          <tr>
	            <td class="main"><?php echo ENTRY_CREDIT_CARD_OWNER; ?></td>
	            <td class="main"><?php echo $order->info['cc_owner']; ?></td>
	          </tr>
<?php
// BMC CC Mod Start
if ($order->info['cc_number'] != '0000000000000000') {
	if ( strtolower(CC_ENC) == TRUE_STRING_S ) {
		$key = changeme;
		$cipher_data = $order->info['cc_number'];
		$order->info['cc_number'] = changedataout($cipher_data,$key);
	}
}
// BMC CC Mod End
?>
	          <tr>
	            <td class="main"><?php echo ENTRY_CREDIT_CARD_NUMBER; ?></td>
	            <td class="main"><?php echo $order->info['cc_number']; ?></td>
	          </tr>
	          <tr>
	            <td class="main"><?php echo ENTRY_CREDIT_CARD_EXPIRES; ?></td>
	            <td class="main"><?php echo $order->info['cc_expires']; ?></td>
	          </tr>
<?php
				}

				// begin modification for banktransfer
				$banktransfer_query = olc_db_query("select banktransfer_prz, banktransfer_status, banktransfer_owner, banktransfer_number,
	banktransfer_bankname, banktransfer_blz, banktransfer_fax from ".TABLE_BANKTRANSFER." where orders_id = '" . $oID  . APOS);
				$banktransfer = olc_db_fetch_array($banktransfer_query);
				if (($banktransfer['banktransfer_bankname']) || ($banktransfer['banktransfer_blz']) || ($banktransfer['banktransfer_number'])) {
?>
	          <tr>
	            <td class="main"><?php echo TEXT_BANK_NAME; ?></td>
	            <td class="main"><?php echo $banktransfer['banktransfer_bankname']; ?></td>
	          </tr>
	          <tr>
	            <td class="main"><?php echo TEXT_BANK_BLZ; ?></td>
	            <td class="main"><?php echo $banktransfer['banktransfer_blz']; ?></td>
	          </tr>
	          <tr>
	            <td class="main"><?php echo TEXT_BANK_NUMBER; ?></td>
	            <td class="main"><?php echo $banktransfer['banktransfer_number']; ?></td>
	          </tr>
	          <tr>
	            <td class="main"><?php echo TEXT_BANK_OWNER; ?></td>
	            <td class="main"><?php echo $banktransfer['banktransfer_owner']; ?></td>
	          </tr>
<?php
if ($banktransfer['banktransfer_status'] == 0) {
?>
	          <tr>
	            <td class="main"><?php echo TEXT_BANK_STATUS; ?></td>
	            <td class="main"><?php echo "OK"; ?></td>
	          </tr>
<?php
} else {
?>
	          <tr>
	            <td class="main"><?php echo TEXT_BANK_STATUS; ?></td>
	            <td class="main"><?php echo $banktransfer['banktransfer_status']; ?></td>
	          </tr>
<?php
switch ($banktransfer['banktransfer_status']) {
	case 1: $error_val = TEXT_BANK_ERROR_1; break;
	case 2: $error_val = TEXT_BANK_ERROR_2; break;
	case 3: $error_val = TEXT_BANK_ERROR_3; break;
	case 4: $error_val = TEXT_BANK_ERROR_4; break;
	case 5: $error_val = TEXT_BANK_ERROR_5; break;
	case 8: $error_val = TEXT_BANK_ERROR_8; break;
	case 9: $error_val = TEXT_BANK_ERROR_9; break;
}
?>
		        <tr>
		          <td class="main"><?php echo TEXT_BANK_ERRORCODE; ?></td>
		          <td class="main"><?php echo $error_val; ?></td>
		        </tr>
		        <tr>
		          <td class="main"><?php echo TEXT_BANK_PRZ; ?></td>
		          <td class="main"><?php echo $banktransfer['banktransfer_prz']; ?></td>
		        </tr>
<?php
}
				}
				if ($banktransfer['banktransfer_fax']) {
?>
          <tr>
            <td class="main"><?php echo TEXT_BANK_FAX; ?></td>
            <td class="main"><?php echo $banktransfer['banktransfer_fax']; ?></td>
          </tr>
<?php
				}
				// end modification for banktransfer
?>
        </table>
        </td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr class="dataTableHeadingRow">
            <td class="dataTableHeadingContent" colspan="2"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_MODEL; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRICE_EXCLUDING_TAX; ?></td>
<?php
$products_allow_tax=$order->products[0]['allow_tax'] == 1;
if ($products_allow_tax)
{
?>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRICE_INCLUDING_TAX; ?></td>
<?php
}
if ($products_allow_tax)
{
	$heading=TABLE_HEADING_TOTAL_INCLUDING_TAX;
}
else
{
	$heading=TABLE_HEADING_TOTAL_EXCLUDING_TAX;
}
?>
            <td class="dataTableHeadingContent" align="center"><?php echo $heading;?></td>
          </tr>
<?php
$order_currency=$order->info['currency'];
$order_currency_value=$order->info['currency_value'];
for ($i = 0, $n = sizeof($order->products); $i < $n; $i++)
{
	$current_product=$order->products[$i];
	$current_product_allow_tax=$current_product['allow_tax'];
	echo
	'          <tr class="dataTableRow">' . NEW_LINE .
	'            <td class="dataTableContent" valign="top" align="right">' .
	$current_product['qty'] . '&nbsp;x&nbsp;</td>' . NEW_LINE .
	'            <td class="dataTableContent" valign="top">' . $current_product['name'];

	$current_product_attributes=$current_product['attributes'];
	$current_product_attributes_count=sizeof($current_product_attributes);
	if ($current_product_attributes_count > 0)
	{
		for ($j = 0, $k = $current_product_attributes_count; $j < $k; $j++)
		{
			$current_product_attribute=$current_product_attributes[$j];
			$attribute_text= '<br/><nobr><small>&nbsp;<i> - ' . $current_product_attribute['option'] . ': ' .
			$current_product_attribute['value'];

			$attribute_price=$current_product_attribute['price'];
			if ((int)$attribute_price)
			{
				$current_product_qty=$current_product['qty'];
				if ($current_product_allow_tax)
				{
					$attribute_price= olc_add_tax($attribute_price * $current_product_qty,$current_product['tax']);
				}
				$attribute_text.=LPAREN . $current_product_attribute['prefix'].
				$currencies->format($attribute_price * $current_product_qty, true, $order_currency, $order_currency_value).RPAREN;
			}
			echo $attribute_text.='</i></small></nobr>';
		}
	}

	echo '            </td>' . NEW_LINE .
	'            <td class="dataTableContent" valign="top">' . $current_product['model'] . '</td>' . NEW_LINE .
	'            <td class="dataTableContent" align="right" valign="top">' .
	format_price($current_product['final_price']/$current_product['qty'], 1, $order_currency, $current_product_allow_tax,
	$current_product['tax']) .
	'</td>' . NEW_LINE;
	if ($current_product_allow_tax)
	{
		echo '<td class="dataTableContent" align="right" valign="top">';
		echo olc_display_tax_value($current_product['tax']).'%';
		echo '</td>' . NEW_LINE;
		echo '<td class="dataTableContent" align="right" valign="top"><b>';

		echo format_price($current_product['final_price']/$current_product['qty'], 1, $order_currency, 0, 0);

		echo '</b></td>' . NEW_LINE;
	}
	echo '            <td class="dataTableContent" align="right" valign="top"><b>' .
	format_price(($current_product['final_price']),1,$order_currency,0,0). '</b></td>' . NEW_LINE;
	echo '          </tr>' . NEW_LINE;
}
?>
          <tr>
            <td align="right" colspan="10"><table border="0" cellspacing="0" cellpadding="2">
<?php
for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
	echo '              <tr>' . NEW_LINE .
	'                <td align="right" class="smallText">' . $order->totals[$i]['title'] . '</td>' . NEW_LINE .
	'                <td align="right" class="smallText">' . $order->totals[$i]['text'] . '</td>' . NEW_LINE .
	'              </tr>' . NEW_LINE;
}
?>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td class="main"><table border="1" cellspacing="0" cellpadding="5">
          <tr>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_DATE_ADDED; ?></b></td>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_CUSTOMER_NOTIFIED; ?></b></td>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_STATUS; ?></b></td>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_COMMENTS; ?></b></td>
          </tr>
<?php
$orders_history_query = olc_db_query("select orders_status_id, date_added, customer_notified, comments from " .
TABLE_ORDERS_STATUS_HISTORY . " where orders_id = '" . $oID . "' order by date_added");
if (olc_db_num_rows($orders_history_query)) {
	while ($orders_history = olc_db_fetch_array($orders_history_query)) {
		echo '          <tr>' . NEW_LINE .
		'            <td class="smallText" align="center">' . olc_datetime_short($orders_history['date_added']) . '</td>' . NEW_LINE .
		'            <td class="smallText" align="center">';
		if ($orders_history['customer_notified'] == '1') {
			echo olc_image(DIR_WS_ICONS . 'tick.gif', ICON_TICK) . "</td>\n";
		} else {
			echo olc_image(DIR_WS_ICONS . 'cross.gif', ICON_CROSS) . "</td>\n";
		}
		echo '            <td class="smallText">' . $orders_status_array[$orders_history['orders_status_id']] . '</td>' . NEW_LINE .
		'            <td class="smallText">' . nl2br(olc_db_output($orders_history['comments'])) . '&nbsp;</td>' . NEW_LINE .
		'          </tr>' . NEW_LINE;
	}
} else {
	echo '          <tr>' . NEW_LINE .
	'            <td class="smallText" colspan="5">' . TEXT_NO_ORDER_HISTORY . '</td>' . NEW_LINE .
	'          </tr>' . NEW_LINE;
}
?>
        </table></td>
      </tr>
      <tr>
        <td class="main"><br/><b><?php echo TABLE_HEADING_COMMENTS; ?></b></td>
      </tr>
      <tr>
      <?php echo olc_draw_form('status', FILENAME_ORDERS, olc_get_all_get_params(array('action')) .
      	'action=update_order'); ?>
        <td class="main">
        	<?php echo olc_draw_textarea_field('comments', 'soft', '60', '5', $order->info['comments']); ?>
        </td>
      </tr>
      <tr>
        <td>
		    <table border="0" cellspacing="0" cellpadding="2"  align="left">
		      <tr>
		        <td>
		           <table width="100%" border="0" cellspacing="0" cellpadding="2" align="left">
		              <?php
		              require_once(DIR_FS_INC.'olc_get_track_code.inc.php');
		              //Check if tracking enabled at all for shipping class!
		              $TrackURL=olc_get_track_code($order,$track_code);
		              if ($TrackURL)
		              {
		              	$track_code=$order->info['orders_trackcode'];
		              	$s.=HTML_BR.HTML_NBSP.olc_draw_input_field("trackcode", $track_code, "size=30") .
		              	ENTRY_TRACKCODE_EXPLAIN;
		              	if ($track_code)
		              	{
		              		$TrackURL=olc_get_track_code($order,$track_code);
		              		$s='
												<!--W. Kaiser - Erlaube Sendungstracking -->
					              <tr>
					                <td class="main">
										        <table border="0" width="100%" cellspacing="0" cellpadding="0">
										          <tr>
										            <td valign="top" class="main">
									                <br/><b>'. ENTRY_TRACKCODE.':</b>&nbsp;
								                </td>
										            <td valign="top" class="main">
';
		              		$s.=HTML_BR.HTML_NBSP.olc_draw_input_field("trackcode", $track_code, "size=30");
		              		if ($TrackURL)
		              		{
		              			$s.=HTML_BR.HTML_NBSP.HTML_A_START.$TrackURL.'" target="_blank">'.ENTRY_TRACK_URL_TEXT.'</a><br/><br/>';
		              		}
		              		$s.='
								                </td>
								              </tr>
								            </table>
			 		                </td>
					              </tr>
												<!--W. Kaiser - Erlaube Sendungstracking -->
';
		              		echo $s;
		              	}
		              }
?>
		              <tr>
		                <td class="main">
			                <b><?php echo ENTRY_NOTIFY_CUSTOMER; ?></b>
			                <?php echo olc_draw_checkbox_field('notify', EMPTY_STRING, true); ?>
			                <b><?php echo '&nbsp;&nbsp;&nbsp;'.ENTRY_NOTIFY_COMMENTS; ?></b>
											<?php echo olc_draw_checkbox_field('notify_comments', EMPTY_STRING, false); ?>
		                </td>
		              </tr>
		              <tr>
		                <td class="main" valign="top">
		                	<b><?php echo ENTRY_STATUS; ?></b>
		                		<?php echo olc_draw_pull_down_menu('status', $orders_statuses,
		                			$order->info['orders_status_id']); ?>
												<?php
												echo "<br/><br/>".olc_image_submit('button_update.gif', IMAGE_UPDATE, 'align="middle"')."<br/><br/>";
												?>
		                </td>
		              </tr>
		            </table>
		        </td>
		      </tr>
		    </table>
        </td>
      </form>
      </tr>
			<tr>
        <td colspan="2" align="left">
<?PHP
$params='pop_up=true&oID='.$oID.'&admin=true';
$pdf_link_invoice=olc_href_link(ADMIN_PATH_PREFIX.FILENAME_PRINT_ORDER,$params,NONSSL,false,false,false);
$pdf_link_packing_slip=
olc_href_link(ADMIN_PATH_PREFIX.FILENAME_PRINT_PACKINGSLIP,$params,NONSSL,false,false,false);
$pdf_alt_invoice=ENTRY_PRINTABLE;
$pdf_alt_packing_slip=ENTRY_PRINTABLE_PACKINGSLIP;
if (INCLUDE_PDF_INVOICE)
{
	$pdf_link_invoice=str_replace(strtolower(HTTPS),strtolower(HTTP),$pdf_link_invoice);
	$pdf_link_packing_slip=str_replace(strtolower(HTTPS),strtolower(HTTP),$pdf_link_packing_slip);
	$s=LPAREN.PDF_DATASHEET.RPAREN;
	$pdf_alt_invoice.=$s;
	$pdf_alt_packing_slip.=$s;
}
/*
$button=
'<a href="javascript:ShowInfo(\'#\', \'\')">'.
olc_image_button('button_@.gif',TILDE,'style="cursor:hand"').HTML_A_END.HTML_NBSP;
*/
$button=
'<a href="#" target="_blank">'.olc_image_button('button_@.gif',TILDE,'style="cursor:hand"').HTML_A_END.HTML_NBSP;
$buttons=
str_replace(TILDE,$pdf_alt_invoice,str_replace(ATSIGN,'invoice',str_replace(HASH,$pdf_link_invoice,$button))).
str_replace(TILDE,$pdf_alt_packing_slip,str_replace(ATSIGN,'packingslip',str_replace(HASH,$pdf_link_packing_slip,$button)));
echo $buttons;

// W. Kaiser Check address validity
if ($is_germany)
{
	echo HTML_A_START . olc_href_link(FILENAME_ORDERS, olc_get_all_get_params(array('validate')) . 'validate=1') . '">' .
	olc_image_button('button_validate_address.gif', ENTRY_VALIDATE_ADDRESS)	. HTML_A_END.HTML_NBSP;
}
// W. Kaiser Check address validity
if (ACTIVATE_GIFT_SYSTEM==TRUE_STRING_S)
{
	echo HTML_A_START . olc_href_link(FILENAME_GV_MAIL, olc_get_all_get_params(array('cID', 'action')) .
	'cID=' . $order->customer['id']) . '">' . olc_image_button('button_gift.gif', ENTRY_SEND_GIFT) . HTML_A_END.HTML_NBSP;
}
// BMC Delete CC Info Start
echo HTML_A_START . olc_href_link(FILENAME_ORDERS, 'oID=' . $oID  . '&action=deleteccinfo') . '">' .
olc_image_button('button_removeccinfo.gif', ENTRY_REMOVE_CVV) . HTML_A_END.HTML_NBSP;
// BMC Delete CC Info END
 echo olc_image_button('button_back.gif', IMAGE_BACK) . HTML_A_END; ?></td>
      </tr>
<?php
} else {
?>
      <tr>
        <td width="100%">
					<table border="0" width="100%" cellspacing="0" cellpadding="0">
					  <tr>
					    <td width="80" rowspan="2"><?php echo olc_image(DIR_WS_ICONS.'heading_customers.gif'); ?></td>
					    <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
					    <td class="pageHeading" align="right">
	              <?php echo olc_draw_form('orders', FILENAME_ORDERS, EMPTY_STRING, 'get'); ?>
	                <?php echo HEADING_TITLE_SEARCH . BLANK . olc_draw_input_field('oID', EMPTY_STRING,
	                'size="12"') . olc_draw_hidden_field('action',
	                 'edit').olc_draw_hidden_field(olc_session_name(), olc_session_id()); ?>
	              </form>
							</td>
					  </tr>
					  <tr>
					    <td class="main" valign="top">OLC Bestellungen</td>
					    <td class="main" valign="top" align="right">
					    	<?php echo olc_draw_form('status', FILENAME_ORDERS,EMPTY_STRING, 'get'); ?>
							    <?php echo HEADING_TITLE_STATUS . BLANK . olc_draw_pull_down_menu('status',
							    olc_array_merge(array(array('id' => EMPTY_STRING, 'text' => TEXT_ALL_ORDERS)),
							    $orders_statuses),EMPTY_STRING,'onchange="this.form.submit();"').
							    olc_draw_hidden_field(olc_session_name(),olc_session_id()); ?>
					      </form>
					     </td>
					  </tr>
					</table>
        </td>
      </tr>
      <tr>
        <td>
	        <table border="0" width="100%" cellspacing="0" cellpadding="0">
	          <tr>
	            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
	              <tr class="dataTableHeadingRow">
	                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CUSTOMERS; ?></td>
	                <td class="dataTableHeadingContent" align="right"><?php echo 'N°' ; ?></td>
	                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ORDER_TOTAL; ?></td>
	                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_DATE_PURCHASED; ?>
	                </td>
	                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>
	                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
	              </tr>
<?php
$orders_query_raw0 = "select o.orders_id, o.customers_name, o.payment_method, o.date_purchased, o.last_modified, o.currency,
o.currency_value, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o
left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " .
TABLE_ORDERS_STATUS . " s
where
#
o.orders_status = s.orders_status_id
and s.language_id = '" . SESSION_LANGUAGE_ID . "'
and ot.class = 'ot_total'
order by o.orders_id DESC";
$cID = olc_db_prepare_input($_GET['cID']);
if ($cID )
{
	$orders_query_raw="o.customers_id = '" . $cID;
}
else
{
	$status = olc_db_prepare_input($_GET['status']);
	if ($status)
	{
		$orders_query_raw="s.orders_status_id = '" . $status ;
	} else {
		$orders_query_raw=EMPTY_STRING;
	}
}
if ($orders_query_raw)
{
	$orders_query_raw.=APOS . ' and';
}
$orders_query_raw=str_replace(HASH,$orders_query_raw,$orders_query_raw0);
$page=$_GET['page'];
$orders_split = new splitPageResults($page, MAX_DISPLAY_SEARCH_RESULTS, $orders_query_raw, $orders_query_numrows);
$orders_query = olc_db_query($orders_query_raw);
while ($orders = olc_db_fetch_array($orders_query)) {
	if (((!$oID ) || ($oID  == $orders['orders_id'])) && (!$oInfo)) {
		$oInfo = new objectInfo($orders);
	}

	if ( (is_object($oInfo)) && ($orders['orders_id'] == $oInfo->orders_id) ) {
		echo
		'              	<tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' .
		olc_onclick_link(FILENAME_ORDERS, olc_get_all_get_params(array('oID', 'action')) . 'oID=' .
		$oInfo->orders_id . '&action=edit') . '">' . NEW_LINE;
		$selected = 'Selected"';
	} else {
		echo
		'              	<tr class="dataTableRow"
									onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'"
									onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' .
		olc_onclick_link(FILENAME_ORDERS, olc_get_all_get_params(array('oID')) . 'oID=' .
		$orders['orders_id']) . '">' . NEW_LINE;
		$selected = '"';
	}
	if ((is_object($oInfo)) && ($orders['orders_id'] == $oInfo->orders_id))
	{
		$link = olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', EMPTY_STRING);
	}
	else
	{
		$link = HTML_A_START . olc_href_link(FILENAME_ORDERS, olc_get_all_get_params(array('oID')) .
		'oID=' . $orders['orders_id']) . '">' . olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END;
	}
	$selected_right = $selected . ' align="right">';
	$selected_center = $selected . ' align="center">';
	$col_end = '</td>';
	echo  '
			<td class="dataTableContent' . $selected . '><a href="' . olc_href_link(FILENAME_ORDERS,
	olc_get_all_get_params(array('oID', 'action')) .
	'oID=' . $orders['orders_id'] . '&action=edit') . '">' . olc_image(DIR_WS_ICONS . 'preview.gif',
	ICON_PREVIEW) .
	'</a>&nbsp;' . $orders['customers_name'].
	'</td>
            <td class="dataTableContent' . $selected_right .$orders['orders_id'] . $col_end . '
            <td class="dataTableContent' . $selected_right .strip_tags($orders['order_total']) . $col_end . '
            <td class="dataTableContent' . $selected . $selected_center .
						olc_datetime_short($orders['date_purchased']) . $col_end . '
            <td class="dataTableContent' . $selected_right .$orders['orders_status_name'] . $col_end . '
            <td class="dataTableContent' . $selected_right . $link . HTML_NBSP . $col_end . '
          </tr>';
}
?>
              <tr>
                <td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top">
                    <?php echo $orders_split->display_count($orders_query_numrows,
                    MAX_DISPLAY_SEARCH_RESULTS, $page, TEXT_DISPLAY_NUMBER_OF_ORDERS); ?></td>
                    <td class="smallText" align="right">
                    <?php echo $orders_split->display_links($orders_query_numrows,
                    MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $page,
                    olc_get_all_get_params(array('page', 'oID', 'action'))); ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
$heading = array();
$contents = array();
switch ($action)
{
	case 'delete':
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_DELETE_ORDER . HTML_B_END);

		$contents = array('form' => olc_draw_form('orders', FILENAME_ORDERS, olc_get_all_get_params(array('oID', 'action')) .
		'oID=' . $oInfo->orders_id . '&action=deleteconfirm'));
		$contents[] = array('text' => TEXT_INFO_DELETE_INTRO . '<br/><br/><b>' . $cInfo->customers_firstname . BLANK .
		$cInfo->customers_lastname . HTML_B_END);
		$contents[] = array('text' => HTML_BR . olc_draw_checkbox_field('restock') . BLANK . TEXT_INFO_RESTOCK_PRODUCT_QUANTITY);
		$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_delete.gif', IMAGE_DELETE) .
		BLANK.HTML_A_START . olc_href_link(FILENAME_ORDERS, olc_get_all_get_params(array('oID', 'action')) .
		'oID=' . $oInfo->orders_id) . '">' .
		olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;
	default:
		if (is_object($oInfo)) {
			$heading[] = array('text' => '<b>[' . $oInfo->orders_id . ']&nbsp;&nbsp;' .
			olc_datetime_short($oInfo->date_purchased) . HTML_B_END);
			$contents[] = array('align' => 'center', 'text' => HTML_A_START .
			olc_href_link(FILENAME_ORDERS, olc_get_all_get_params(array('oID', 'action')) .
			'oID=' . $oInfo->orders_id . '&action=edit') . '">' .
			olc_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' .
			olc_href_link(FILENAME_ORDERS, olc_get_all_get_params(array('oID', 'action')) .
			'oID=' . $oInfo->orders_id . '&action=delete') . '">' .
			olc_image_button('button_delete.gif', IMAGE_DELETE) . HTML_A_END);
			//$contents[] = array('align' => 'center', 'text' => EMPTY_STRING);
			$contents[] = array('text' => HTML_BR . TEXT_DATE_ORDER_CREATED . BLANK .
			olc_date_short($oInfo->date_purchased));
			if (olc_not_null($oInfo->last_modified)) $contents[] = array('text' => TEXT_DATE_ORDER_LAST_MODIFIED .
			BLANK . olc_date_short($oInfo->last_modified));
			$contents[] = array('text' => HTML_BR . TEXT_INFO_PAYMENT_METHOD . BLANK  . $oInfo->payment_method);
			//begin PayPal_Shopping_Cart_IPN
			if (strtolower($oInfo->payment_method) == 'paypal_ipn')
			{
				include_once(PAYPAL_IPN_DIR.'Functions/general.func.php');
				$contents[] = array('text' => TABLE_HEADING_PAYMENT_STATUS . ': ' .
				paypal_payment_status($oInfo->orders_id));
			}
			//end PayPal_shopping_Cart_IPN

			// elari added to display product list for selected order
			$order = new order($oInfo->orders_id);
			$contents[] = array('text' => '<br/><br/>' . sizeof($order->products) . ' Products ' );
			for ($i=0; $i<sizeof($order->products); $i++)
			{
				$current_product=$order->products[$i];
				$contents[] = array('text' => $current_product['qty'] . '&nbsp;x&nbsp;' . $current_product['name']);
				$order_products_attributes=$current_product['attributes'];
				$order_products_attributes_count=sizeof($order_products_attributes);
				if ($order_products_attributes_count > 0)
				{
					for ($j=0; $j<$order_products_attributes_count; $j++)
					{
						$current_order_products_attributes=$order_products_attributes[$j];
						$contents[] = array('text' => '<small>&nbsp;<i> - ' .
						$current_order_products_attributes['option'] . ': '.
						$current_order_products_attributes['value'] . '</i></small></nobr>' );
					}
				}
			}
			// elari End add display products
		}
		break;
}

if ( (olc_not_null($heading)) && (olc_not_null($contents)) ) {
	echo '            <td width="25%" valign="top">' . NEW_LINE;

	$box = new box;
	echo $box->infoBox($heading, $contents);

	echo '            </td>' . NEW_LINE;
}
?>
          </tr>
        </table></td>
      </tr>
<?php
}
?>
    </table></td>
<?php
require(DIR_WS_INCLUDES . 'application_bottom.php');

?>
