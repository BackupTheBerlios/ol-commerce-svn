<?PHP
/* -----------------------------------------------------------------------------------------
$Id: olc_start_paypal.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:41 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2003	    nextcommerce (olc_add_tax.inc.php,v 1.4 2003/08/24); www.nextcommerce.org

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
/*
if (!defined('USE_PAYPAL_IPN'))
{
	define('USE_PAYPAL_IPN',IS_LOCAL_HOST);
}
if (!defined('USE_PAYPAL_WPP'))
{
	define('USE_PAYPAL_WPP',IS_LOCAL_HOST);
}
*/

if (!defined('USE_PAYPAL_IPN'))
{
	define('USE_PAYPAL_IPN',IS_LOCAL_HOST);
}
if (!defined('USE_PAYPAL_WPP'))
{
	define('USE_PAYPAL_WPP',IS_LOCAL_HOST);
}
$paypal_ipn_text='paypal_ipn';
define('PAYPAL_IPN_DIR',ADMIN_PATH_PREFIX . DIR_WS_MODULES .'payment'.SLASH.$paypal_ipn_text.SLASH);
$paypal_scripts=FILENAME_EC_PROCESS.FILENAME_IPN.$paypal_ipn_text.PHP;
if (strpos(CURRENT_SCRIPT,'checkout_')!==false or strpos($paypal_scripts,CURRENT_SCRIPT)!==false)
{
	if (USE_PAYPAL_IPN)
	{
		// begin PayPal_Shopping_Cart_IPN
		require_once(PAYPAL_IPN_DIR.'Classes/osC/osC.class.php');
		// end PayPal_Shopping_Cart_IPN
		// begin PayPal_Shopping_Cart_IPN
		PayPal_osC::check_order_status(true);
		// end PayPal_Shopping_Cart_IPN
		if (strpos(CURRENT_SCRIPT,"ipn.")!==false)
		{
			define('IPN_PAYMENT_MODULE_NAME', 'PayPal_Shopping_Cart_IPN');
			require(PAYPAL_IPN_DIR.'database_tables.inc.php');
			include(PAYPAL_IPN_DIR.'Classes/osC/Order.class.php');
			$PayPal_osC_Order = new PayPal_osC_Order();
			$PayPal_osC_Order->loadTransactionSessionInfo($_POST['custom']);
			if(isset($PayPal_osC_Order->language))
			{
				// include the language translations
				$language = $PayPal_osC_Order->language;
				include(DIR_WS_LANGUAGES . $language . PHP);
			} else {
				//later on change to Store Default
				include(PAYPAL_IPN_DIR.'languages/'.SESSION_LANGUAGE.PHP);
			}
		}
	}
	if (USE_PAYPAL_WPP)
	{
		switch ($_SESSION['language_code'])
		{
			case 'us':
				$paypal_button_dir="en_US";
				break;
			case 'fr':
				$paypal_button_dir="fr_FR";
				break;
			case 'it':
				$paypal_button_dir="it_IT";
				break;
			case 'ja':
				$paypal_button_dir="jp_JP";
				break;
			default:
				$paypal_button_dir="de_DE";
		}
		define('MODULE_PAYMENT_PAYPAL_EC_BUTTON_URL',$http_protocol.'://www.paypal.com/'.$paypal_button_dir.
		'/i/btn/btn_xpressCheckout.gif');
	}
}
?>