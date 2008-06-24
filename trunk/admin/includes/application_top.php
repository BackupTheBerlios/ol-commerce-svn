<?php
/* --------------------------------------------------------------
$Id: application_top.php,v 1.1.1.2.2.1 2007/04/08 07:16:38 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(application_top.php,v 1.158 2003/03/22); www.oscommerce.com
(c) 2003	    nextcommerce (application_top.php,v 1.46 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------
Third Party contribution:

Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
http://www.oscommerce.com/community/contributions,282
Copyright (c) Strider | Strider@oscworks.com
Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
Copyright (c) Andre ambidex@gmx.net
Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

Released under the GNU General Public License
--------------------------------------------------------------*/

// W. Kaiser - AJAX
$IsAdminFunction=true;
if (defined('IS_AJAX_PROCESSING_FORCED'))
{
	//Include Smarty class
	olc_smarty_init($smarty,$cacheid);
}
else
{
	define('IS_LOCAL_HOST',file_exists('d:\vb6\C2.EXE'));
	if (IS_LOCAL_HOST)
	{
		//local host --> full error reporting
/*	!!!	error_reporting((E_ERROR || E_WARNING) && ~E_STRICT); */
                error_reporting(E_ERROR || E_WARNING);
	}
	else
	{
		//remote host --> reduced error reporting
	/* !!!	error_reporting(E_ERROR && ~E_STRICT); */
	error_reporting(E_ERROR);
	}
	global $ajax_script_id;

	$my_user_agent = strtolower(getenv('HTTP_USER_AGENT'));
	$position=strpos($my_user_agent,'msie');
	define('IS_IE', $position !== false);
	//define('USE_AJAX_ADMIN',true);
	//define('USE_AJAX_ADMIN',IS_IE);
	define('USE_AJAX_ADMIN',false);
	define('USE_AJAX_ADMIN_OR_USE_SMARTY',USE_AJAX_ADMIN || IS_LOCAL_HOST);
	$PHP_SELF = $_SERVER['PHP_SELF'];
	define('PHP','.php');
	define('INC_PHP','.inc.php');
	define('IS_ADMIN_FUNCTION',true);
	define('NOT_IS_ADMIN_FUNCTION',FALSE);
	define('ADMIN_PATH_PREFIX','../');
	if (isset($path_prefix))
	{
		chdir($path_prefix);
	}
	$config_file='includes/configure.php';
	include($config_file);
	//W. Kaiser - AJAX
	if (filesize($config_file)>2000)
	{
		//Presumably the old style with 2 config files!!!
		include(ADMIN_PATH_PREFIX.$config_file);		//Also read user parameters to get any unassigned constants
	}
	//W. Kaiser - AJAX
	// define our general functions used application-wide
	define('START_AJAX',USE_AJAX_ADMIN);

	//W. Kaiser Google Sitemap
	define('FILENAME_GOOGLE_SITEMAP', 'google_sitemap.php');
	//W. Kaiser Google Sitemap
	//W. Kaiser Down for Maintenance
	define('FILENAME_DOWN_FOR_MAINTENANCE', 'down_for_maintenance.php');
	//W. Kaiser Down for Maintenance
	define('HEADING_MODULES_ICON',DIR_WS_ICONS.'heading_modules.gif');
	define('HEADING_CONFIGURATION_ICON',DIR_WS_ICONS.'heading_configuration.gif');
	require_once(DIR_WS_FUNCTIONS . 'general.php');

	include_once(DIR_FS_INC.'olc_get_products_price.inc.php');
	include_once(DIR_FS_INC.'olc_get_tax_description.inc.php');

	$start_ajax=true;
	require(DIR_FS_CATALOG_MODULES . 'application_init.php');
	//define('USE_SMARTY',IS_LOCAL_HOST || USE_AJAX);
	define('USE_SMARTY',USE_AJAX);
	require(DIR_WS_FUNCTIONS . 'html_output.php');

	define('FILENAME_LOGIN','login.php');

	$current_page = split('\?', CURRENT_SCRIPT);
	$current_page = $current_page[0];
	$pagename = strtok($current_page, DOT);
	$login=ADMIN_PATH_PREFIX.FILENAME_LOGIN;
	if (!defined('ISSET_CUSTOMER_ID'))
	{
		//Allow short-cut logins.
		//Like: script.php?email_address=mail@server-de&password=mypassword
		$email_address=$_GET['email_address'];
		if ($email_address)
		{
			$force_login=true;
			$password=$_GET['password'];
			if ($password)
			{
				$_POST['email_address']=$email_address;
				$_POST['password']=$password;
				$_GET['action']='process';
				include($login);
				$force_login=false;
			}
		}
	}
	if (CUSTOMER_ID<>1)		//Master Admin ist allowed all!
	{
		$force_login=!olc_check_permission($pagename);
	}
	else
	{
		$force_login=false;
	}
	if ($force_login)
	{
		define('IS_ADMIN_FUNCTION',false);
		define('NOT_IS_ADMIN_FUNCTION',true);
		define('ENABLE_SSL',false);
		$_SESSION['is_admin']=false;
		olc_redirect(olc_href_link($login,true));
	}
	else
	{
		$_SESSION['is_admin']=true;
	}
	// customization for the design layout
	if (!$ajax_attributemanager)
	{
		define('PROGRAM_FRAME',DIR_WS_INCLUDES.'program_frame.php');
		define('BOX_WIDTH', 175); // how wide the boxes should be in pixels (default: 125)
		// Used in the "Backup Manager" to compress backups
		define('LOCAL_EXE_GZIP', '/usr/bin/gzip');
		define('LOCAL_EXE_GUNZIP', '/usr/bin/gunzip');
		define('LOCAL_EXE_ZIP', '/usr/local/bin/zip');
		define('LOCAL_EXE_UNZIP', '/usr/local/bin/unzip');
		//define('USE_AJAX_ATTRIBUTES_MANAGER',IS_IE);
		define('USE_AJAX_ATTRIBUTES_MANAGER',true);
		//define('USE_AJAX_ATTRIBUTES_MANAGER',false);
		define('AJAX_ATTRIBUTES_MANAGER_LEADIN','attributemanager/includes/attributemanager');
		// define the filenames used in the project
		//	W. Kaiser - Erlaube Sendungstracking
		define('FILENAME_CUSTOMER_DEFAULT', ADMIN_PATH_PREFIX.'index.php');
		//	W. Kaiser - Erlaube Sendungstracking
		define('FILENAME_ACCOUNTING', 'accounting.php');
		define('FILENAME_ATTRIBUTE_MANAGER', 'attributemanager.php');
		define('FILENAME_AJAX_VALIDATION','ajax_validation.php');
		define('FILENAME_BACKUP', 'backup.php');
		define('FILENAME_BANNER_MANAGER', 'banner_manager.php');
		define('FILENAME_BANNER_STATISTICS', 'banner_statistics.php');
		define('FILENAME_CACHE', 'cache.php');
		define('FILENAME_CATALOG_ACCOUNT_HISTORY_INFO', 'account_history_info.php');
		define('FILENAME_CATEGORIES', 'categories.php');
		define('FILENAME_CONFIGURATION', 'configuration.php');
		define('FILENAME_BOX_CONFIGURATION', 'box_'.FILENAME_CONFIGURATION);
		define('FILENAME_COUNTRIES', 'countries.php');
		define('FILENAME_CURRENCIES', 'currencies.php');
		define('FILENAME_CUSTOMERS', 'customers.php');
		define('FILENAME_CUSTOMERS_STATUS', 'customers_status.php');
		define('FILENAME_DEFAULT', 'start.php');
		define('FILENAME_DEFINE_LANGUAGE', 'define_language.php');
		define('FILENAME_GEO_ZONES', 'geo_zones.php');
		define('FILENAME_LANGUAGES', 'languages.php');
		define('FILENAME_MAIL', 'mail.php');
		define('FILENAME_MANUFACTURERS', 'manufacturers.php');
		define('FILENAME_MODULES', 'modules.php');
		define('FILENAME_ORDERS', 'orders.php');
		define('FILENAME_ORDERS_INVOICE', 'invoice.php');
		define('FILENAME_ORDERS_PACKINGSLIP', 'packingslip.php');
		define('FILENAME_ORDERS_STATUS', 'orders_status.php');
		define('FILENAME_POPUP_IMAGE', 'popup_image.php');
		define('FILENAME_PRODUCTS_ATTRIBUTES', 'products_attributes.php');
		define('FILENAME_PRODUCTS_EXPECTED', 'products_expected.php');
		define('FILENAME_REVIEWS', 'reviews.php');
		define('FILENAME_SERVER_INFO', 'server_info.php');
		define('FILENAME_SHIPPING_MODULES', 'shipping_modules.php');
		define('FILENAME_SPECIALS', 'specials.php');
		define('FILENAME_STATS_CUSTOMERS', 'stats_customers.php');
		define('FILENAME_STATS_PRODUCTS_PURCHASED', 'stats_products_purchased.php');
		define('FILENAME_STATS_PRODUCTS_VIEWED', 'stats_products_viewed.php');
		define('FILENAME_TAX_CLASSES', 'tax_classes.php');
		define('FILENAME_TAX_RATES', 'tax_rates.php');
		$whos_online='whos_online';
		define('FILENAME_WHOS_ONLINE', $whos_online.PHP);
		define('FILENAME_WHOS_ONLINE_LIVE', $whos_online.'_live.php');
		define('FILENAME_LIVE_HELP', 'live.php');
		define('FILENAME_LIVE_HELP_ADMIN', '../livehelp/admin.php');
		define('FILENAME_IMPORT_EXPORT','import_export.php');
		define('FILENAME_PAYPAL_IPN', 'paypal_ipn.php');
		define('FILENAME_PAYPAL_wpp', 'paypal_wpp.php');
		define('FILENAME_ZONES', 'zones.php');
		define('FILENAME_START', 'start.php');
		define('FILENAME_STATS_STOCK_WARNING', 'stats_stock_warning.php');
		define('FILENAME_TPL_BOXES','templates_boxes.php');
		define('FILENAME_TPL_MODULES','templates_modules.php');
		define('FILENAME_NEW_ATTRIBUTES','new_attributes.php');
		define('FILENAME_XSELL_PRODUCTS', 'xsell_products.php');
		define('FILENAME_NEW_PRODUCT','new_product.php');
		define('FILENAME_PDF_EXPORT', 'pdf_export.php');
		define('FILENAME_ORDERS_INVOICE_PDF', 'pdf_invoice.php');
		define('FILENAME_PRODUCTS_VPE','products_vpe.php');
		define('FILENAME_LOGOUT',ADMIN_PATH_PREFIX.'logoff.php');
		define('FILENAME_CREATE_ACCOUNT','create_account.php');
		define('FILENAME_CREATE_ACCOUNT_SUCCESS','create_account_success.php');
		define('FILENAME_CUSTOMER_MEMO','customer_memo.php');
		define('FILENAME_CONTENT_MANAGER','content_manager.php');
		define('FILENAME_CONTENT_PREVIEW','content_preview.php');
		define('FILENAME_SECURITY_CHECK','security_check.php');
		define('FILENAME_PRINT_ORDER','print_order.php');
		define('FILENAME_CREDITS','credits.php');
		define('FILENAME_PRINT_PACKINGSLIP','print_packingslip.php');
		define('FILENAME_MODULE_NEWSLETTER','module_newsletter.php');
		define('FILENAME_METATAGS','metatags.php');
		define('FILENAME_GV_QUEUE', 'gv_queue.php');
		define('FILENAME_GV_MAIL', 'gv_mail.php');
		define('FILENAME_GV_SENT', 'gv_sent.php');
		define('FILENAME_COUPON_ADMIN', 'coupon_admin.php');
		define('FILENAME_POPUP_MEMO', 'popup_memo.php');
		define('FILENAME_SHIPPING_STATUS', 'shipping_status.php');
		define('FILENAME_SALES_REPORT','stats_sales_report.php');
		define('FILENAME_MODULE_EXPORT','module_export.php');
		define('FILENAME_EASYPOPULATE','easypopulate.php');
		define('FILENAME_BLACKLIST', 'blacklist.php');
		define('FILENAME_FROOGLE','froogle.php');
		define('FILENAME_BOX_CONFIGURATION','box_configuration.php');
		// Erweiterung für Newsletter
		define('FILENAME_CATALOG_NEWSLETTER', 'newsletter.php');
		// W. Kaiser - AJAX
		define('FILENAME_AJAX_VALIDATION','ajax_validation.php');
		// W. Kaiser - AJAX
		//W. Kaiser Elm@r
		define('FILENAME_ELMAR',ADMIN_PATH_PREFIX.'elmar_start.php');
		//W. Kaiser Elm@r
		//W. Kaiser Blz-Update
		define('FILENAME_BLZ_UPDATE', 'blz_update.php');
		//W. Kaiser Blz-Update
		if (USE_EBAY)
		{
			$auctions_list=$auctions.'_list';
			$auctions_list_sold=$auctions_list.'_sold';
			define('FILENAME_AUCTIONS_LIST_BASKET', $auctions_list_sold.'basket.php');
			define('FILENAME_AUCTIONS_LIST_NOT_SOLD', $auctions_list_sold.'not.php');
			define('FILENAME_AUCTIONS_LIST_ORDER', $auctions_list_sold.'order.php');
			define('FILENAME_AUCTIONS_LIST_PLAN', $auctions_list.'_plan.php');
			define('FILENAME_AUCTIONS_LIST_RUNNING', $auctions_list.PHP);
			define('FILENAME_AUCTIONS_LIST_SOLD', $auctions_list_sold.PHP);
			define('FILENAME_AUCTIONS_PREDEFINED', $auctions.'predefined.php');
			define('FILENAME_AUCTIONS_PREVIEW', $auctions.'preview.php');
			define('FILENAME_CONTENT','shop_content.php');
			if (strpos(CURRENT_SCRIPT,$auctions)!==false)
			{
				// auction.lister ############
				// include the password crypto functions
				require_once (DIR_WS_FUNCTIONS.'password_funcs.php');
			}
		}
		//W. Kaiser - AJAX
		if (SHOW_AFFILIATE)
		{
			// inclusion for affiliate program
			include('affiliate_application_top.php');
		}
		$s='USE_CSS_ADMIN_MENU';
		$s1='USE_CSS_DYNAMIC_ADMIN_MENU';
		if (!defined($s))
		{
			define($s,false);
			//define($s,IS_LOCAL_HOST);
		}
		define('USE_COOL_ADMIN_MENU',false && IS_LOCAL_HOST);
		if (USE_CSS_ADMIN_MENU)
		{
			$css_menu=true;
			if (IS_IE)
			{
				$pos=strpos($my_user_agent,'msie');
				if ($pos!==false)
				{
					$css_menu=(int)substr($my_user_agent,$pos+5)>=6;		//Check IE version
				}
			}
			$css_menu=IS_LOCAL_HOST and ($_SESSION['ajax'] || $css_menu);
		}
		else
		{
			$css_menu=false;
		}
		$not_css_menu=!$css_menu;
		if ($css_menu)
		{
			if (!defined($s1))
			{
				define($s1,IS_LOCAL_HOST);
			}
			$s='USE_CSS_ADMIN_MENU_H';
			$menu_orientation='v';
			if (USE_CSS_DYNAMIC_ADMIN_MENU)
			{
				if (!defined($s))
				{
					define($s,false);
				}
				if (USE_CSS_ADMIN_MENU_H)
				{
					$menu_orientation='h';
				}
				$menu_type='dynamic';
				$header_addon='
<!--[if lt IE 7]><style type="text/css" media="screen">body{behavior:url('.CURRENT_TEMPLATE_ADMIN.'csshover.htc);}</style>
<![ENDIF]-->
';
			}
			else
			{
				$header_addon=EMPTY_STRING;
				define($s,true);
				$menu_type='static';
			}
			$header_addon.='
<style type="text/css">
	@import url("'.CURRENT_TEMPLATE_ADMIN.$menu_type.'_menu_'.$menu_orientation.'.css");
</style>
';
			if (USE_CSS_DYNAMIC_ADMIN_MENU)
			{
				if ($menu_horizontal)
				{
					$header_addon.='
<!--[if IE]>
<style type="text/css" media="screen">
 #menu ul li {float: left; width: 100%;}
</style>
<![endif]-->
<!--[if lt IE 7]>
<style type="text/css" media="screen">
body {
font-size: 100%;
}

#menu ul li a {height: 1%;}

#menu a, #menu h2 {
font: bold 0.7em/1.4em arial, helvetica, sans-serif;
}
</style>
<![endif]-->
';
				}
			}
			require(DIR_WS_INCLUDES . 'column_left.php');
		}
		else
		{
			define($s,false);
			define($s1,false);
			if (USE_COOL_ADMIN_MENU)
			{
				$header_addon='
<script language="JavaScript1.2" src="../includes/cool_menu.js"></script>
<style type="text/css">
	@import url("'.CURRENT_TEMPLATE_ADMIN.'dynamic_menu_v");
</style>
';
				require(DIR_WS_INCLUDES . 'column_left.php');
			}
		}
		// Define how do we update currency exchange rates
		// Possible values are 'oanda xe' or ''
		define('CURRENCY_SERVER_PRIMARY', 'oanda');
		define('CURRENCY_SERVER_BACKUP', 'xe');

		define('INTERNATIONAL', '_INTERNATIONAL');
		define('KEY_MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER', 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER');

		// W. Kaiser Check address validity
		require_once(ADMIN_PATH_PREFIX.DIR_WS_FUNCTIONS . 'address_validation.php');
		// W. Kaiser Check address validity

		// define our localization functions
		require(DIR_WS_FUNCTIONS . 'localization.php');

		// Include validation functions (right now only email address)
		//require(DIR_WS_FUNCTIONS . 'validations.php');

		// setup our boxes
		require_once(DIR_WS_CLASSES . 'table_block.php');
		require_once(DIR_WS_CLASSES . 'box.php');

		// initialize the message stack for output messages
		require_once(DIR_WS_CLASSES . 'message_stack.php');
		$messageStack = new messageStack;

		// entry/item info classes
		require_once(DIR_WS_CLASSES . 'object_info.php');

		// email classes
		require_once(DIR_WS_CLASSES . 'mime.php');
		require_once(DIR_WS_CLASSES . 'email.php');

		// file uploading class
		require_once(DIR_WS_CLASSES . 'upload.php');

		// default open navigation box
		if (!isset($_SESSION['selected_box'])) {
			$_SESSION['selected_box'] = 'configuration';
		}
		if (isset($_GET['selected_box'])) {
			$_SESSION['selected_box'] = $_GET['selected_box'];
		}
		// the following cache blocks are used in the Tools->Cache section
		// ('language' in the filename is automatically replaced by available languages)
		$cache_blocks = array(array('title' => TEXT_CACHE_CATEGORIES, 'code' => 'categories', 'file' => 'categories_box-language.cache', 'multiple' => true),
		array('title' => TEXT_CACHE_MANUFACTURERS, 'code' => 'manufacturers', 'file' => 'manufacturers_box-language.cache', 'multiple' => true),
		array('title' => TEXT_CACHE_ALSO_PURCHASED, 'code' => 'also_purchased', 'file' => 'also_purchased-language.cache', 'multiple' => true)
		);

		// check if a default currency is set
		if (!defined('DEFAULT_CURRENCY')) {
			$messageStack->add(ERROR_NO_DEFAULT_CURRENCY_DEFINED, 'error');
		}

		// check if a default language is set
		if (!defined('DEFAULT_LANGUAGE')) {
			$messageStack->add(ERROR_NO_DEFAULT_LANGUAGE_DEFINED, 'error');
		}

		// for Customers Status
		olc_get_customers_statuses();

		//W. Kaiser - AJAX
		olc_smarty_init($smarty,$cacheid);
		define('IS_IE', !($position === false));
		$spaw_dir='spaw'.SLASH;
		$spaw_stylesheet=$server.DIR_WS_CATALOG.FULL_CURRENT_TEMPLATE.'admin/stylesheet.css';
		if (USE_AJAX)
		{
			if (NOT_IS_AJAX_PROCESSING)
			{
				$spaw_root=DIR_FS_ADMIN.DIR_WS_CLASSES.$spaw_dir;
				include($spaw_root.'config/spaw_control.config.php');
				$smarty->assign('SPAW_STYLESHEET',$spaw_stylesheet);
				$smarty->assign('SPAW_THEME',$spaw_default_theme);
				$smarty->assign('SPAW_ACTIVE_TOOLBAR',$spaw_default_toolbars);
			}
		}
		$spaw_scripts=FILENAME_CONTENT_MANAGER . FILENAME_MODULE_NEWSLETTER .FILENAME_NEW_PRODUCT . FILENAME_CATEGORIES.
		FILENAME_AUCTIONS_NEW;
		if (strpos($spaw_scripts,CURRENT_SCRIPT)!==false)
		{
			//Include SPAW wyswyg Editor (only if really needed!)
			$action_text='action';
			$action=$_GET[$action_text];
			if (!$action)
			{
				$action=$_POST[$action_text];
			}
			if ($action)
			{
				$spaw_actions=DOT.'new_category.edit_category.edit_categories.new_product.new_products_content.'.
				'insert_product.edit.new.safe'.DOT;
				if (strpos($spaw_actions,DOT.$action.DOT)!==false)
				{
					if (strpos(CURRENT_SCRIPT,'auctions')!==false)
					{
						$load_spaw=$action=='edit' || $_POST['product_id']!=EMPTY_STRING || $_POST['search']!=EMPTY_STRING;
					}
					else
					{
						$load_spaw=true;
					}
					if ($load_spaw)
					{
						$spaw_root=DIR_FS_ADMIN.DIR_WS_CLASSES.$spaw_dir;
						require_once($spaw_root.'spaw_control.class.php');
						define('SPAW_STYLESHEET',$spaw_stylesheet);
					}
				}
			}
		}
		// include used functions (not contained in common "application_init.php")
		require_once(DIR_FS_INC.'olc_add_tax.inc.php');
		require_once(DIR_FS_INC.'olc_get_tax_rate.inc.php');
		require_once(DIR_FS_INC.'olc_get_vpe_name.inc.php');
		/*
		// for BadBlue(Win32) webserver compatibility
		$filename= DIR_FS_LANGUAGES . SESSION_LANGUAGE . '/admin/'. $current_page;
		if (file_exists($filename))
		{
			include($filename);
		}
		*/
		//define('FULL_CURRENT_TEMPLATE','TEMPLATE_PATH . CURRENT_TEMPLATE.'/');
		//define('CURRENT_TEMPLATE_BUTTONS',FULL_CURRENT_TEMPLATE.'buttons/'.SESSION_LANGUAGE.'/');
		//require($path. SESSION_LANGUAGE.SLASH.SESSION_LANGUAGE . PHP);

		include(DIR_WS_INCLUDES . 'html_head_full.php');
	}
}
?>