<?PHP
/* --------------------------------------------------------------
$Id: application_init.php,v 1.1.1.3.2.1 2007/04/08 07:17:59 gswkaiser Exp $

Common init_routine for admin and user area

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

// define the project version
define('PROJECT_VERSION', 'OL-Commerce X');
define('OL_COMMERCE',true);
$fake_print=isset($_GET['fake_print']);
global $http_protocol,$server;

if (!function_exists('file_put_contents'))
{
	function file_put_contents($n,$d)
	{
		$f=@fopen($n,"w");
		if ($f)
		{
			fwrite($f,$d);
			fclose($f);
			return true;
		}
		else
		{
			return false;
		}
	}
}

// start the timer for the page parse time log
define('PAGE_PARSE_START_TIME', microtime());

require_once(DIR_FS_INC.'olc_define_global_constants.inc.php');
require_once(DIR_FS_INC.'olc_connect_and_get_config.inc.php');
$current_template_text='CURRENT_TEMPLATE';
$connected=false;
$prefix_only=false;
olc_connect_and_get_config(array(),ADMIN_PATH_PREFIX);

// include needed functions
require_once(DIR_FS_INC.'olc_db_data_seek.inc.php');
require_once(DIR_FS_INC.'olc_db_free_result.inc.php');
require_once(DIR_FS_INC.'olc_db_output.inc.php');
require_once(DIR_FS_INC.'olc_db_perform.inc.php');
require_once(DIR_FS_INC.'olc_db_modules.inc.php');
require_once(DIR_FS_INC.'olc_standard_products_query.inc.php');

require_once(DIR_FS_INC.'olc_get_ip_address.inc.php');
require_once(DIR_FS_INC.'olc_get_ip_info.inc.php');
require_once(DIR_FS_INC.'olc_update_whos_online.inc.php');
require_once(DIR_FS_INC.'olc_seo_url.inc.php');
require_once(DIR_FS_INC.'olc_get_vpe_name.inc.php');
require_once(DIR_FS_INC.'ajax_error.inc.php');
require_once(DIR_FS_INC.'olc_image.inc.php');

// split-page-results
require_once(DIR_WS_CLASSES . 'split_page_results.php');
// Include Template Engine
$smarty_dir=DIR_FS_CATALOG.DIR_WS_CLASSES . 'smarty/';
$smarty_class='Smarty.class.php';
require_once($smarty_dir.$smarty_class);
require_once(DIR_FS_INC.'olc_smarty_init.inc.php');
global $smarty;

$s='USE_PAYPAL_IPN';
if (!defined($s))
{
	define($s,IS_LOCAL_HOST);
}
$s='USE_PAYPAL_WPP';
if (!defined($s))
{
	define($s,IS_LOCAL_HOST);
}
while (list($key,$value)=each($_GET))
{
	$_GET[$key]=strip_tags($value);
}
/*
while (list($key,$value)=each($_POST))
{
	$_POST[$key]=strip_tags($value);
}
*/
if (IS_ADMIN_FUNCTION)
{
	define('TRACKING','tracking');
	define('PRODUCTS_HISTORY','products_history');
	$s='TRACKING_PRODUCTS_HISTORY_ENTRIES';
	if (!defined($s))
	{
		define($s,9);		//10 history entries
	}
	$s=CURRENT_SCRIPT==FILENAME_GOOGLE_SITEMAP;
}
else
{
	$s=SEARCH_ENGINE_FRIENDLY_URLS==TRUE_STRING_S;
}
define('USE_SEO',$s);
define('USE_EBAY',IS_LOCAL_HOST && EBAY_FUNCTIONS_INCLUDE==TRUE_STRING_S);
if (USE_EBAY)
{
	$auctions='auctions';
	define('FILENAME_AUCTIONS_NEW', $auctions.PHP);
	$is_auction=CURRENT_SCRIPT==FILENAME_AUCTIONS_NEW;
}
else
{
	$is_auction=false;
}
$seo_const_text='USE_SEO_EXTENDED';
if (USE_SEO || $is_auction)
{
	//global $seo_search,$seo_replace;
	if (!defined($seo_const_text))
	{
		define($seo_const_text,false);
	}
	$seo_categories_text='seo_categories_text';
	$seo_search_text='seo_search';
	$seo_replace_text='seo_replace';
	define('DO_SEO_EXTENDED',USE_SEO_EXTENDED==TRUE_STRING_S);
	if (USE_SEO)
	{
		$seo_const_text='SEO_SEPARATOR';
		if (!defined($seo_const_text))
		{
			define($seo_const_text,DASH);
		}
		$seo_const_text='SEO_TERMINATOR';
		if (!defined($seo_const_text))
		{
			define($seo_const_text,HTM_EXT);
		}
		define('SEO_PAGENAME_START','seo'.SEO_SEPARATOR);
		require_once(DIR_FS_INC.'olc_get_products_name.inc.php');
		require_once(DIR_FS_INC.'olc_get_manufacturers.inc.php');
		define("AJAX_ID_SEO", SEO_SEPARATOR.str_replace('=',SEO_SEPARATOR,AJAX_ID));
		$seo_array_1=array('=',AMP,'?');
		$seo_array_2=array('&&',HTML_AMP);
		$seo_urls_to_convert=FILENAME_DEFAULT.DASH.FILENAME_PRODUCT_INFO.DASH.FILENAME_CONTENT;
		/*
		SEO is handled by "mod_rewrite"

		// Set the HTTP GET parameters manually in case search_engine_friendly_urls is enabled!
		// W. Kaiser - Note: "AcceptPathInfo On" must be set in the htaccess-file!
		//$path_info=getenv('PATH_INFO');
		$path_info=$_SERVER['PATH_INFO'];
		if (strlen($path_info) > 1)
		{
		$GET_array = array();
		$PHP_SELF = str_replace($path_info, EMPTY_STRING, $PHP_SELF);
		$vars = explode(SLASH, substr($path_info, 1));
		for ($i=0, $n=sizeof($vars); $i<$n; $i++) {
		if (strpos($vars[$i], '[]')) {
		$GET_array[substr($vars[$i], 0, -2)][] = $vars[$i+1];
		} else {
		$_GET[$vars[$i]] = $vars[$i+1];
		}
		$i++;
		}
		if (sizeof($GET_array) > 0) {
		while (list($key, $value) = each($GET_array)) {
		$_GET[$key] = $value;
		}
		}
		}
		*/
	}
}
else
{
	define($seo_const_text,false);
	define('DO_SEO_EXTENDED',false);
}
define('NOT_DO_SEO_EXTENDED',!DO_SEO_EXTENDED);
$not_update_whois=!$update_whois;
$catalog_class_dir=ADMIN_PATH_PREFIX. DIR_WS_CLASSES;
$catalog_includes_dir=ADMIN_PATH_PREFIX.DIR_WS_INCLUDES;
if ($update_whois)
{
	$is_spider_visit=false;
	$not_is_spider_visit=true;
}
else
{
	// include shopping cart class
	require_once($catalog_class_dir. 'shopping_cart.php');
}
// include navigation history class
$navigation='navigation';
require($catalog_class_dir . $navigation.'_history.php');

include_once(DIR_FS_INC.'olc_start_session.inc.php');
require_once(DIR_FS_INC.'olc_check_agent.inc.php');
if ($not_update_whois)
{
	if (defined(DIR_FS_MULTI_SHOP_TEXT))
	{
		$_SESSION[DIR_FS_MULTI_SHOP_TEXT]=DIR_FS_MULTI_SHOP;
	}
	else
	{
		define('DIR_FS_MULTI_SHOP_TEXT','DIR_FS_MULTI_SHOP');
		$working_directory=$_SESSION[DIR_FS_MULTI_SHOP_TEXT];
		if (!isset($working_directory))
		{
			$working_directory=EMPTY_STRING;
		}
		define(DIR_FS_MULTI_SHOP_TEXT,$working_directory);
	}
	if (!defined(DIR_FS_MULTI_SHOP_TEXT))
	{
		define(DIR_FS_MULTI_SHOP_TEXT,EMPTY_STRING);
	}
	if (!is_object($_SESSION[$navigation]))
	{
		$_SESSION[$navigation] = new navigationHistory;
	}

	//Check for user-selected template
	$cookie_name="olc_current_template";
	$template_file=DIR_FS_MULTI_SHOP.ADMIN_PATH_PREFIX.'template.txt';
	if (file_exists($template_file))
	{
		$current_template_file=@file_get_contents($template_file);
		$current_template_file=trim($current_template_file);
	}
	$write_template_file=!$current_template_file;
	$current_template_cookie=$_COOKIE[$cookie_name];
	$have_template_cookie=$current_template_cookie<>EMPTY_STRING;
	if ($have_template_cookie)
	{
		$have_template_cookie=$current_template_cookie<>$current_template_text;
	}
	if ($have_template_cookie)
	{
		if ($current_template_cookie<>$current_template_file)
		{
			$have_template_cookie=false;
			$current_template_cookie=$current_template_file;
		}
	}
	else
	{
		$current_template_cookie=$current_template_file;
	}
	if ($current_template_cookie)
	{
		$current_template=$current_template_cookie;
		if (is_dir(ADMIN_PATH_PREFIX.TEMPLATE_PATH.$current_template))
		{
			$current_template_db=$current_template;
		}
	}
	if ($current_template_db)
	{
		define($current_template_text,$current_template_db);
		if ($write_template_file)
		{
			@file_put_contents($template_file,CURRENT_TEMPLATE);
		}
	}
	$my_user_agent = strtolower(getenv('HTTP_USER_AGENT'));
	define('USER_AGENT',$my_user_agent);
	if ($my_user_agent)
	{
		$position=strpos($my_user_agent,'msie');
		define('IS_IE', !($position === false));
	}
	$spider_visit_text='spider_visit';
	if (isset($_SESSION[$spider_visit_text]))
	{
		$is_spider_visit=$_SESSION[$spider_visit_text];
	}
	else
	{
		$is_spider_visit=isset($_GET[$spider_visit_text]);
		if ($is_spider_visit)
		{
			if ($my_user_agent)
			{
				//Check for spider access
				$spiders = file($catalog_includes_dir . 'spiders.txt');
				for ($i=0, $n=sizeof($spiders); $i<$n; $i++)
				{
					$spider_name=trim($spiders[$i]);
					if ($spider_name)
					{
						if (strpos($my_user_agent, $spider_name!==false))
						{
							$is_spider_visit = true;
							break;
						}
					}
				}
			}
		}
		$_SESSION[$spider_visit_text]=$is_spider_visit;
		if ($is_spider_visit)
		{
			$_SESSION['ajax']=false;
			$_SESSION['no_ajax']=true;
		}
	}
	$not_is_spider_visit=!$is_spider_visit;
	define('ADD_SESSION_ID',$not_is_spider_visit);
	require_once(DIR_FS_INC.'olc_get_top_level_domain.inc.php');
	require_once(DIR_FS_INC.'olc_create_random_value.inc.php');
	require_once(DIR_FS_INC.'olc_redirect.inc.php');
	require_once(DIR_FS_INC.'olc_href_link.inc.php');
	require_once(DIR_FS_INC.'olc_get_templates.inc.php');

	global $session_started,$http_domain,$https_domain, $request_type;

	// set the type of request (secure or not)
	$request_type=(getenv(HTTPS) == !null) ? SSL : NONSSL;

	// set the top level domains
	$http_domain = olc_get_top_level_domain(HTTP_SERVER);
	$https_domain = olc_get_top_level_domain(HTTPS_SERVER);
	$current_domain = (($request_type == NONSSL) ? $http_domain : $https_domain);
	$current_domain_1=olc_not_null($current_domain) ? DOT . $current_domain : EMPTY_STRING;
	/*
	// set the session cookie parameters
	if (function_exists('session_set_cookie_params'))
	{
		session_set_cookie_params(0, SLASH, $current_domain_1);
	}
	elseif (function_exists('ini_set'))
	{
		$session_cookie='session.cookie_';
		ini_set($session_cookie.'lifetime', '0');
		ini_set($session_cookie.'path', SLASH);
		ini_set($session_cookie.'domain', $current_domain_1);
	}
	*/
	// Store DB-Querys in a Log File
	define('STORE_DB_TRANSACTIONS', FALSE_STRING_S);

	$use_adodb='USE_ADODB';
	if (!defined($use_adodb))
	{
		define($use_adodb,IS_LOCAL_HOST);
		//define($use_adodb,false);
	}
	if (USE_ADODB===true)
	{
		$ado_db_type='ADOBD_DB_TYPE';
		$ado_use_caching='ADOBD_USE_CACHING';
		$ado_use_stats='ADOBD_USE_STATS';
		$ado_use_logging='ADODB_USE_LOGGING';
		if (!defined($ado_db_type))
		{
			define($ado_db_type,'mysql');
		}
		if (!defined($ado_use_caching))
		{
			define($ado_use_caching,IS_LOCAL_HOST);
			define('ADOBD_CACHING_SECONDS',3600);
		}
		if (!defined($ado_use_stats))
		{
			define($ado_use_stats,IS_LOCAL_HOST);
		}
		if (!defined($ado_use_logging))
		{
			define($ado_use_logging,IS_LOCAL_HOST);
		}
	}
	$one_day=60*60*24;
	if (!$have_template_cookie)
	{
		$expires=time()+$one_day*10000;
		setcookie($cookie_name, CURRENT_TEMPLATE,$expires);
	}
	//Set PDF-invoice-handling
	define('INCLUDE_PDF_INVOICE',USE_PDF_INVOICE=='1');

	$allowkeys_text='allow_keys';
	$allowkeys=$_SESSION[$allowkeys_text];
	if (!$allowkeys)
	{
		$allowkeys=$_GET[$allowkeys_text];
		$_SESSION[$allowkeys_text]=$allowkeys;
	}
	if ($allowkeys)
	{
		$_SESSION[$allowkeys_text]=true;
	}
	$_SESSION['is_admin']=$IsAdminFunction;
	if (IS_LOCAL_HOST || $IsAdminFunction)
	{
		$full_errors=true;
	}
	else
	{
		$full_errors=$_SESSION[FULL_ERRORS];
		if (!$full_errors)
		{
			$full_errors=$_GET[FULL_ERRORS];
		}
	}
	if ($full_errors)
	{
		$_SESSION[FULL_ERRORS]=true;
		//local host --> full error reporting
		error_reporting(E_ALL & ~E_NOTICE);
	}
	else
	{
		//remote host --> reduced error reporting
		error_reporting(E_ERROR);
	}
	set_error_handler("my_error_handler");  //set my own handler
	$_SESSION['header']=false;
	// verify the ssl_session_id if the feature is enabled
	if ($session_started == true)
	{
		if (ENABLE_SSL == true)
		{
			if ($request_type == SSL)
			{
				if (SESSION_CHECK_SSL_SESSION_ID == TRUE_STRING_L)
				{
					$ssl_session_id_text="SSL_SESSION_ID";
					$ssl_session_id = getenv($ssl_session_id_text);
					if (!session_is_registered($ssl_session_id_text))
					{
						$_SESSION[$ssl_session_id_text] = $ssl_session_id;
					}
					elseif ($_SESSION[$ssl_session_id_text] != $ssl_session_id)
					{
						session_destroy();
						olc_redirect(olc_href_link(FILENAME_SSL_CHECK));
					}
				}
			}
		}
	}

	// for tracking of customers
	$user_info_text='user_info';
	$user_ip_text='user_ip';
	if (!isset($_SESSION[$user_info_text][$user_ip_text]))
	{
		$_SESSION[$user_info_text] = array();
		$remote_addr=olc_get_ip_address();
		$_SESSION[$user_info_text][$user_ip_text] = $remote_addr;
		$_SESSION[$user_info_text]['user_host'] = gethostbyaddr($remote_addr);
		$_SESSION[$user_info_text]['advertiser'] = $_GET['ad'];
		$_SESSION[$user_info_text]['referer_url'] = $_SERVER['HTTP_REFERER'];
	}
	// verify the browser user agent if the feature is enabled
	if (SESSION_CHECK_USER_AGENT == TRUE_STRING_L)
	{
		$http_user_agent = getenv('HTTP_USER_AGENT');
		$session_user_agent_text='SESSION_USER_AGENT';
		if (!isset($_SESSION[$session_user_agent_text])) {
			$_SESSION[$session_user_agent_text] = $http_user_agent;
		}
		if ($_SESSION[$session_user_agent_text] != $http_user_agent)
		{
			session_destroy();
			olc_redirect(olc_href_link(FILENAME_LOGIN));
		}
	}
	//W. Kaiser - AJAX
	// The session is started, now include the AJAX-related code
	if (IS_ADMIN_FUNCTION)
	{
		if (START_AJAX)
		{
			define('BOX_RIGHT','box_RIGHT');
			define('BOX_LEFT1','box_LEFT1');
			define('BOX_LEFT2','box_LEFT2');
		}
		else
		{
			define('IS_AJAX_PROCESSING',false);
			define('NOT_IS_AJAX_PROCESSING',true);
			define('USE_AJAX',false);
			define("NOT_USE_AJAX", !USE_AJAX);
		}
		//Restrict admin access if MULTI-DB!
		$limited_access_text='limited_access';
		$limited_access_data_text=$limited_access_text.'_data';
		$limited_access=$_SESSION[$limited_access_text];
		if (isset($limited_access))
		{
			if ($limited_access)
			{
				$limited_access_data=$_SESSION[$limited_access_data_text];
			}
		}
		else
		{
			$limited_access=(TABLE_PREFIX_COMMON<>TABLE_PREFIX_INDIVIDUAL) || (DB_DATABASE<>DB_DATABASE_1);
			if ($limited_access)
			{
				//Functions not allowed in Multi-DB mode!
				$limited_access_data=
				array(
				'attributeManager',
				'backup',
				'blz_update',
				'cache',
				'categories',
				'countries',
				'currencies',
				'define_language',
				'geo_zones',
				'languages',
				'manufacturers',
				'new_attributes',
				'products_attributes',
				'products_vpe',
				'specials',
				'shipping_status',
				'tax_classes',
				'tax_rates',
				'xsell_products',
				'zones'
				);
				$_SESSION[$limited_access_data_text]=$limited_access_data;
			}
			$_SESSION[$limited_access_text]=$limited_access;
		}
		define('LIMITED_ACCESS',$limited_access);
		define('LIMITED_ACCESS_DATA',$limited_access_data);
	}
	else
	{
		// include currencies class and create an instance
		require_once($catalog_class_dir . 'currencies.php');
		$currencies = new currencies();
	}
	// set the language
	$language_text='language';
	$language=$_GET[$language_text];
	$force_language=$language!=EMPTY_STRING;
 	if ($force_language)
	{
		unset($_GET[$language_text]);
		if ($language==$_SESSION[$language_text.'_code'])
		{
			if (CURRENT_SCRIPT==FILENAME_DEFAULT or IS_AJAX_PROCESSING)
			{
				if (USE_AJAX)
				{
					//No change -- ignore
					echo AJAX_NODATA;
				}
				exit();
			}
		}
		elseif (IS_AJAX_PROCESSING)
		{
			//We have to rebuild the complete screen framework!
			define('AJAX_REBUILD_ALL',true);
		}
		$set_language=true;
	}
	else
	{
		$set_language=!isset($_SESSION[$language_text]);
	}
	if ($set_language)
	{
		include_once($catalog_class_dir . $language_text.PHP);
		$lng = new language($language);
		if (!$force_language) $lng->get_browser_language();
		$_SESSION[$language_text.'_id'] = $lng->language['id'];
		$_SESSION[$language_text.'_code'] = $lng->language['code'];
		$_SESSION[$language_text] = $lng->language['directory'];
		$_SESSION[$language_text.'_charset'] = $lng->language['charset'];
		$_SESSION[$language_text.'_name'] = $lng->language['name'];
		unset($_SESSION[$seo_search_text]);		//Force reload of categories texts!
	}
	define('SESSION_LANGUAGE', $_SESSION[$language_text]);
	define('SESSION_LANGUAGE_ID', $_SESSION[$language_text.'_id']);
	define('SESSION_LANGUAGE_DIR','lang'.SLASH.SESSION_LANGUAGE.SLASH);
	define('NO_IMAGE_NAME',SESSION_LANGUAGE_DIR.'no_image.jpg');
	$current_template=CURRENT_TEMPLATE.SLASH;
	define('FULL_CURRENT_TEMPLATE',TEMPLATE_PATH . $current_template);
	require_once(DIR_FS_INC.'olc_get_box_code_script_path.inc.php');
	$buttons='buttons'.SLASH.SESSION_LANGUAGE.SLASH;
	define('CURRENT_TEMPLATE_BUTTONS',FULL_CURRENT_TEMPLATE.$buttons);
	define('CURRENT_TEMPLATE_ADMIN',ADMIN_PATH_PREFIX.FULL_CURRENT_TEMPLATE.$admin);
	define('CURRENT_TEMPLATE_ADMIN_BUTTONS',CURRENT_TEMPLATE_ADMIN.$buttons);
	define('CURRENT_TEMPLATE_ADMIN_IMG',CURRENT_TEMPLATE_ADMIN.'images'.SLASH);
	$admin='admin'.SLASH;
	$boxes='boxes'.SLASH;
	$module='module'.SLASH;
	$base=ADMIN_PATH_PREFIX.FULL_COMMON_TEMPLATE;
	if (!class_exists('std_Smarty'))
	{
		require_once($base.'inc/'.$smarty_class);
	}
	$base=is_dir($base.$boxes);
	define('CHECK_UNIFIED_TEMPLATES',USE_UNIFIED_TEMPLATES!=false && $base);
	//Define some global, often used constants. No need to always recompute them
	$session_language='mail'.SLASH.SESSION_LANGUAGE.SLASH;
	define('CURRENT_TEMPLATE_MAIL',$current_template.$session_language);
	define('CURRENT_TEMPLATE_BOXES',$current_template.$boxes);
	define('CURRENT_TEMPLATE_MODULE',$current_template.$module);
	if (IS_ADMIN_FUNCTION)
	{
		define('CURRENT_TEMPLATE_ADMIN_MAIL',ADMIN_PATH_PREFIX.FULL_CURRENT_TEMPLATE.$admin.$session_language);
		$session_language='admin/start';
	}
	else
	{
		$session_language='index';
	}
	define('INDEX_HTML',$current_template.$session_language.HTML_EXT);
	define('CURRENT_TEMPLATE_IMG',FULL_CURRENT_TEMPLATE.'img'.SLASH);
	include(DIR_FS_INC.'olc_get_box_configuration.inc.php');
	if ($start_ajax)
	{

		if (DO_SEO_EXTENDED || $is_auction)
		{
			include(DIR_FS_INC.'olc_get_seo_data.inc.php');
		}
		//include(DIR_FS_INC.'olc_get_box_configuration.inc.php');
		$start_ajax=false;
		if (START_AJAX)
		{
			if (strpos($my_user_agent,'safari')===false)
			{
				$start_ajax=ADD_SESSION_ID;
			}
		}
		require($catalog_includes_dir.'ajax.php');
		if (IS_ADMIN_FUNCTION)
		{
			if (USE_EBAY)
			{
				if (EBAY_TEST_MODE==TRUE_STRING_S)
				{
					$sandbox=".sandbox";
				}
				else
				{
					$sandbox=EMPTY_STRING;
				}
				define('EBAY_SERVER','http://cgi'.$sandbox.'.ebay.de/ws/eBayISAPI.dll');
				define('EBAY_VIEWITEM','ViewItem&item=');
				require(ADMIN_PATH_PREFIX.'lang'.SLASH.SESSION_LANGUAGE.SLASH.$admin.FILENAME_AUCTIONS_NEW);
			}
		}
		//	W. Kaiser	chCounter and livehelp inclusion
		$chCounter_active='chCounter_active';
		$livehelp_active='livehelp_active';
		$s='chCounter_checked';
		if (!isset($_SESSION[$s]))
		{
			//	W. Kaiser	chCounter inclusion
			//chCounter for shop statistic -- http://www.christoph-bachner.net/chcounter
			//http://www.christoph-bachner.net/chcounter
			//The "chCounter"-Pakage must be separately installed and configured.
			//(into the shop's "chCounter"directory)
			//Check availability of counter
			//Check chCounter existance
			$rs=olc_db_query("SHOW TABLES LIKE 'chc_downloads_and_hyperlinks_logs'");
			$_SESSION[$chCounter_active] = olc_db_num_rows($rs)>0;
			if (SHOW_LIVEHELP && IS_LOCAL_HOST)
			{
				//	W. Kaiser	livehelp inclusion
				//The "livehelp"-Pakage must be separately installed and configured.
				//(into the shop's "livehelp" directory)
				//Check availability of livehelp
				//Check chCounter existance
				$rs=olc_db_query("SHOW TABLES LIKE 'livehelp_autoinvite'");
				$_SESSION[$livehelp_active] = olc_db_num_rows($rs)>0;
			}
		}
		if (USE_AJAX)
		{
			if (IS_ADMIN_FUNCTION)
			{
				ob_start();		//Start output buffering
			}
			//W. Kaiser - AJAX
			$validation='_validation';
			$blz_validation='blz'.$validation;
			$plz_validation='plz'.$validation;
			$vornamen_validation='vornamen'.$validation;
			if (!isset($_SESSION[$blz_validation]))
			{
				//Check if DB has data for validation!!
				$query0="SELECT * FROM # LIMIT 1";

				$query=str_replace(HASH,TABLE_BANKTRANSFER_BLZ,$query0);
				$query=olc_db_query($query);
				$_SESSION[$blz_validation]=olc_db_num_rows($query)>0;

				$query=str_replace(HASH,TABLE_PLZ,$query0);
				$query=olc_db_query($query);
				$_SESSION[$plz_validation]=olc_db_num_rows($query)>0;

				$query=str_replace(HASH,TABLE_VORNAMEN,$query0);
				$query=olc_db_query($query);
				$_SESSION[$vornamen_validation]=olc_db_num_rows($query)>0;
			}
		}
		define('AJAX_BLZ_VALIDATION',$_SESSION[$blz_validation]);
		define('AJAX_PLZ_VALIDATION',$_SESSION[$plz_validation]);
		define('AJAX_VORNAMEN_VALIDATION',$_SESSION[$vornamen_validation]);
		//require_once(DIR_WS_CLASSES.'logger.php');
		require_once(DIR_FS_INC.'olc_validate_email.inc.php');
		// some code to solve compatibility issues
		require(DIR_WS_FUNCTIONS.'compatibility.php');
		// set php_self in the local scope
		// include the mail classes
		$class=DIR_WS_CLASSES . 'class.';
		if (EMAIL_TRANSPORT == 'sendmail')
		{
			include($class.'phpmailer.php');
		}
		elseif (EMAIL_TRANSPORT == 'smtp')
		{
			include($class.'smtp.php');
		}
		if (IS_ADMIN_FUNCTION)
		{
			// include the language translations
			$filename= $admin;
			require(DIR_FS_LANGUAGES .SESSION_LANGUAGE.SLASH.$filename.SESSION_LANGUAGE.PHP);
			$path=DIR_FS_LANGUAGES;
			if (USE_EBAY)
			{
				$class=$is_auction;
				require_once (DIR_WS_FUNCTIONS.'auction_helpers.php');
				$is_auction=$class;
			}
		}
		else
		{
			$path=DIR_WS_LANGUAGES;
			$filename= EMPTY_STRING;
		}
		if (!$is_auction)
		{
			$filename=$path.SESSION_LANGUAGE.SLASH.$filename.CURRENT_SCRIPT;
			if (file_exists($filename))
			{
				include($filename);
			}
		}
		// currency
		$currency_text="currency";
		$currency=(USE_DEFAULT_LANGUAGE_CURRENCY == TRUE_STRING_S) ? LANGUAGE_CURRENCY : DEFAULT_CURRENCY;
		if (
		!isset($_SESSION[$currency_text]) ||
		isset($_GET[$currency_text]) ||
		((USE_DEFAULT_LANGUAGE_CURRENCY == TRUE_STRING_S) && (LANGUAGE_CURRENCY != $_SESSION[$currency_text]))
		)
		{
			if (isset($_GET[$currency_text]))
			{
				if (!function_exists("olc_currency_exists"))
				{
					require_once(DIR_FS_INC.'olc_currency_exists.inc.php');
				}
				if (!$_SESSION[$currency_text] =
				olc_currency_exists($_GET[$currency_text])) $_SESSION[$currency_text] = $currency;
			}
			else
			{
				$_SESSION[$currency_text] = $currency;
			}
		}
		if ($_SESSION[$currency_text] == EMPTY_STRING)
		{
			$_SESSION[$currency_text] = DEFAULT_CURRENCY;
		}
		if (CURRENT_SCRIPT==FILENAME_LOGOFF)
		{
			unset($_SESSION['customer_id']);
		}
		if (NOT_IS_ADMIN_FUNCTION || $is_auction)
		{
			// create the shopping cart & fix the cart if necesary
			$s='cart';
			if (!is_object($_SESSION[$s]))
			{
				$_SESSION[$s] = new shoppingCart;
			}
			if ($is_auction)
			{
				require_once(DIR_FS_INC.'olc_precision.inc.php');
				require_once(DIR_FS_INC.'olc_format_price.inc.php');
			}
		}
		// store customers status into session
		define('SESSION_CURRENCY',$_SESSION[$currency_text]);
		$filename=$path.SESSION_LANGUAGE.SLASH.SESSION_LANGUAGE.PHP;
		require($filename);
		require_once($catalog_includes_dir.'write_customers_status.php');
		define('CHCOUNTER_ACTIVE',$_SESSION[$chCounter_active]);
		define('LIVE_HELP_ACTIVE',$_SESSION[$livehelp_active]);
		if (CHCOUNTER_ACTIVE)
		{
			define('FILENAME_CHCOUNTER', DIR_FS_CATALOG.'chCounter/counter.php');
		}
		//W. Kaiser - AJAX

		// Below are some defines which affect the way the discount coupon/gift voucher system work
		// Be careful when editing them.
		//
		// Set the length of the redeem code, the longer the more secure
		define('SECURITY_CODE_LENGTH', '10');
		//
		// The settings below determine whether a new customer receives an incentive when they first signup
		//
		// Set the amount of a Gift Voucher that the new signup will receive, set to 0 for none
		//  define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT', '10');  // placed in the admin configuration mystore
		//
		// Set the coupon id that will be sent by email to a new signup, if no id is set then no email :)
		//  define('NEW_SIGNUP_DISCOUNT_COUPON', '3'); // placed in the admin configuration mystore
		// W. Kaiser BOF: Down for Maintenance
		if (CURRENT_SCRIPT<>FILENAME_DOWN_FOR_MAINTENANCE)
		{
			include(DIR_FS_INC . FILENAME_DOWN_FOR_MAINTENANCE);
		}
		// W. Kaiser EOF: Down for Maintenance
		$template_path=ADMIN_PATH_PREFIX.TEMPLATE_PATH.CURRENT_TEMPLATE.SLASH;
		$file='img/bullet.gif';
		if (file_exists($template_path.$file))
		{
			$file=olc_image($template_path.$file,EMPTY_STRING,EMPTY_STRING,EMPTY_STRING,'align="top"');
		}
		else
		{
			$file='&raquo;';
		}
		define('BULLET',$file);
		define('BULLET_TEXT','bullet');
		// W. Kaiser BOF: PayPal IPN
		require_once(DIR_FS_INC.'olc_start_paypal.inc.php');
		// W. Kaiser EOF: PayPal IPN

		// Get category path
		$cPath_text='cPath';
		$cPath = $_GET[$cPath_text];
		if (!$cPath)
		{
			$cPath=$_POST[$cPath_text];
		}
		if ($cPath)
		{
			$cPath_array = explode(UNDERSCORE, $cPath);
			$current_category_id = $cPath_array[(sizeof($cPath_array)-1)];
		}
		else
		{
			$current_category_id = 0;
		}
		if ($start_ajax)
		{
			if ($not_is_spider_visit)
			{
				olc_update_whos_online($_GET['url']);
			}
			if ($update_whois)
			{
				echo AJAX_NODATA;
			}
			elseif (!defined('SHOW_COOL_MENU'))
			{
				define('SHOW_COOL_MENU',false);
			}
			if (SHOW_COOL_MENU==TRUE_STRING_S)
			{
				if (USE_AJAX)
				{
					$cat_sql="select categories_id from ".TABLE_CATEGORIES." LIMIT 1";
					$cat_query=olc_db_query($cat_sql);
					$show_cool_menu=olc_db_num_rows($cat_query)>0;
				}
			}
		}
	}
}
?>