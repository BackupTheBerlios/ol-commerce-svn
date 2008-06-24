<?PHP
//W. Kaiser - AJAX
/* -----------------------------------------------------------------------------------------
$Id: ajax.php,v 1.1.1.1.2.1 2007/04/08 07:17:43 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

AJAX = Asynchronous JavaScript and XML
Info: http://de.wikipedia.org/wiki/Ajax_(Programmierung)

AJAX-recognition routine

Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de), w.kaiser@fortune.de

-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(shopping_cart.php,v 1.18 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (shopping_cart.php,v 1.15 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------
*/

if ($start_ajax)
{
	if (!function_exists('replace_box_names'))
	{
		//W. Kaiser - DynamicX screen layout.
		function replace_box_names($box_list)
		{
			//We need to substitute real box names to position box names
			global $box_relations;

			$box_list_parts=explode(BLANK,$box_list);
			for ($i=0,$n=sizeof($box_list_parts);$i<$n;$i++)
			{
				$s=$box_relations[$box_list_parts[$i]];
				if ($s)
				{
					$box_list_parts[$i]=$s;
				}
			}
			$box_list=implode($box_list_parts,BLANK);
			return $box_list;

		}
		//W. Kaiser - Dynamic screen layout.
	}

	//Use AJAX (if possible, i.e. if the client computer supports Javascript)
	$enable_ajax_text='ENABLE_AJAX_MODE';
	if (!defined($enable_ajax_text))
	{
		define($enable_ajax_text,true);
	}
	if (ENABLE_AJAX_MODE)
	{
		$use_ajax_text='ajax';
		$use_ajax=$_SESSION[$use_ajax_text]==TRUE_STRING_S;
		if ($use_ajax)
		{
			$is_ajax_request=isset($_GET[$use_ajax_text]);
			if (!$is_ajax_request)
			{
				$is_ajax_request=isset($_POST[$use_ajax_text]);
			}
			if ($is_ajax_request)
			{
				$restart=$_GET['force_restart'];
				if ($restart)
				{
					while (list($key,)=each ($_SESSION))
					{
						unset($_SESSION[$key]);
					}
					$url_parts = parse_url($_SERVER['REQUEST_URI']);
					header('Location: '.basename($url_parts['path']));
					exit();
				}
			}
			else
			{
				//Runnining in AJAX mode, but no AJAX request==browser navigation via address-line!
				//We have to re-init AJAX-mode, as the AJAX-context is lost in the browser!!!!!
				//$restart=true;
				$_POST[$use_ajax_text]=true;
				$use_ajax=false;
				$is_ajax_processing=false;
				$restart=true;
			}
		}
	}
	if ($use_ajax)
	{
		$have_javascript_support=true;
		$is_ajax_processing=true;
	}
	else
	{
		$have_javascript_support=false;
		if (CURRENT_SCRIPT != FILENAME_INCI_LISTING)
		{
			$no_ajax_text='no_ajax';
			if ($_GET[$no_ajax_text])
			{
				$_SESSION[$no_ajax_text]=true;
			}
			if (!$_SESSION[$no_ajax_text])
			{
				$use_ajax=false;
				if (isset($_POST[$use_ajax_text]))
				{
					$use_ajax=$_POST[$use_ajax_text];
					$isset=true;
				}
				if (!$use_ajax)
				{
					if (isset($_GET[$use_ajax_text]))
					{
						$use_ajax=$_GET[$use_ajax_text];
						$isset=true;
					}
				}
				if ($isset)
				{
					$have_javascript_support=$use_ajax==TRUE_STRING_S;
					$_SESSION[$use_ajax_text]=$have_javascript_support;
					$ajax_init=!$restart;		//isset($_POST['ajax_init']);
				}
				else
				{
					if (ENABLE_AJAX_MODE)
					{
						//Check for JavaScript-Support on clients computer
						$force_javascript_check_text="force_javascript_check";
						$olc_force_javascript_check='olc_'.$force_javascript_check_text;
						$force_javascript_check=$_GET[$force_javascript_check_text]==true;
						if (!$force_javascript_check)
						{
							$force_javascript_check=$_COOKIE[$olc_force_javascript_check]==1;
							setcookie($olc_force_javascript_check,false);
						}
						$javascript_text="javascript";
						$javascript_check_done_text=$javascript_text."_check_done";
						if ($force_javascript_check)
						{
							unset($_SESSION[$force_javascript_check]);
							$_SESSION[$javascript_check_done_text] = false;
							$_SESSION[$javascript_text]=false;
						}
						$have_javascript_support = $_SESSION[$javascript_text] == true;
						if (!$have_javascript_support)
						{
							if (isset($_POST[$javascript_text]) || isset($_GET[$use_ajax_text]) || isset($_POST[$use_ajax_text]))
							{
								$have_javascript_support = true;
								$_SESSION[$javascript_text] = true;
								$_SESSION[$use_ajax_text]= true;
							}
							else
							{
								if ($_SESSION[$javascript_check_done_text])
								{

								}
								else
								{
									$_SESSION[$javascript_check_done_text] = true;
									$parameters = olc_get_all_get_params();
									$pos=strpos($parameters ,$force_javascript_check_text);
									if ($pos>0)
									{
										$parameters=substr($parameters,0,$pos-1);
									}
									//Exclude Zend debugger parameters!!!!
									$pos = strpos($parameters, "start_debug");
									if ($pos===false)
									{
										$pos=strpos($parameters,'DBGSESSION');
									}
									if ($pos!==false)
									{
										$parameters = substr($parameters,0,$pos-1);
										$_SESSION["parameters"]=substr($parameters,$pos-1);
									}
									if (strlen($parameters) > 0)
									{
										$parameters =str_replace('force_restart=true',EMPTY_STRING,$parameters);
										$parameters = QUESTION.$parameters;
									}
									/*
									Client-side Javascript-support detection!!!!!

									Return HTML-code which switches to the called routine  w i t h  (window.open)
									or  w i t h o u t  (meta http-equiv="Refresh") the "javascript" parameter.

									If Javascript is enabled on the clients computer, the "window.open" command is executed,
									else the "meta http-equiv="Refresh" HTML-Tag in the "<noscript>"-section is evaluated.

									If the "javascript" parameter is included in the subsequent call to the routine, JavaScript-support
									is available on the clients computer, and we can use the "AJAX" technologie,
									*/
									if (ENABLE_SSL==TRUE_STRING_S)
									{
										$url = HTTPS_SERVER;
									}
									else
									{
										$url = HTTP_SERVER;
									}
									$url.=$PHP_SELF.$parameters;
									$dir=dirname($PHP_SELF);
									$dir=str_replace("\\",SLASH,$dir);
									if (substr($dir,-1,1)<>SLASH)
									{
										$dir.=SLASH;
									}
									$html =
									'
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
	<head>
	<noscript>
		<meta http-equiv="refresh" content="0; URL='.$dir.'ajax_error.php'.'?reason=no_javascript&
			request_url='.$url.'">
	</noscript>
	</head>
	<body onload="script_check.submit();">
		<form method="post" action="' . $url. '" name="script_check">
			<input type="hidden" value="true" name="javascript">
';
										if (defined('DIR_FS_MULTI_SHOP'))
										{
											$html.=
'			<input type="hidden" value="'.DIR_FS_MULTI_SHOP.'" name="'.DIR_FS_MULTI_SHOP_TEXT.'">
';
										}
										$html.=
'		</form>
	</body>
</html>
';
									echo $html;
									exit();
								}
							}
						}
					}
				}
			}
		}
	}
	define("USE_AJAX", $have_javascript_support);		//Use AJAX, if client supports Javascript
	define('BOX_NAVIGATION','box_NAVIGATION');
	if (USE_AJAX)
	{
		//Use ajax_dhtmlHistory.js for browser navigation (true/false)
		define("USE_NATIVE_HISTORY_NAVIGATION",TRUE_STRING_S);
		//Use ajax_storage.js for cross-session state preservation (true/false)
		define("USE_CROSS_SESSION_STORAGE",FALSE_STRING_S);
		//define("USE_CROSS_SESSION_STORAGE","true");
		//Define parts for Javascript AJAX-link routine
		define("AJAX_REQUEST_FUNC_START","javascript:make_AJAX_Request('");
		define("AJAX_REQUEST_FUNC_END", "',false,'','')");
		if (!$is_ajax_processing)
		{
			if (!$restart)
			{
				$is_ajax_processing = $_POST[$use_ajax_text];
				if (!$is_ajax_processing)
				{
					$is_ajax_processing = $_GET[$use_ajax_text];
				}
				$is_ajax_processing=$is_ajax_processing==TRUE_STRING_S;
				$_SESSION[$use_ajax_text]=$is_ajax_processing;
			}
		}
		define("IS_AJAX_PROCESSING", $is_ajax_processing);
		define("NOT_IS_AJAX_PROCESSING", !$is_ajax_processing);
		$ajax_data_elements_main_content_navtrail = " main_content";
		if (IS_ADMIN_FUNCTION)
		{
			define("AJAX_DATA_ELEMENTS_TO_CHANGE",$ajax_data_elements_main_content_navtrail." box_LEFT2 box_RIGHT box_TOP_DIV");
		}
		else
		{
			$ajax_data_element_box_whatsnew_box_specials_box_specials = " box_WHATSNEW box_SPECIALS";
			$box_navigation=BLANK.BOX_NAVIGATION;
			$ajax_data_elements_main_content_navtrail.=" navtrail".$box_navigation;
			if (LIVE_HELP_ACTIVE===true)
			{
				$ajax_data_elements_main_content_navtrail.=" box_LIVEHELP";
			}
			$ajax_data_elements_to_change=
			"box_ADMIN box_CART box_CATEGORIES box_LOGIN box_NOTIFICATIONS box_REVIEWS box_TELL_FRIEND box_INFOBOX box_ORDER_HISTORY".
			" box_LANGUAGES box_CURRENCIES box_MANUFACTURERS box_MANUFACTURERS_INFO box_BESTSELLERS box_LAST_VIEWED".
			" box_ADD_A_QUICKIE box_TAB_NAVIGATION" .
			$ajax_data_element_box_whatsnew_box_specials .
			$ajax_data_element_box_specials .
			$ajax_data_elements_main_content_navtrail;
			if (USE_LAYOUT_DEFINITION==TRUE_STRING_S)
			{
				$ajax_data_elements_to_change=replace_box_names($ajax_data_elements_to_change);
			}
			define("AJAX_DATA_ELEMENTS_TO_CHANGE",$ajax_data_elements_to_change);
			$use_ajax_short_list = false;
			if (IS_AJAX_PROCESSING)
			{
				//Untersuchung, ob weitere Reduzierungen der Verarbeitung möglich sind.

				//Beim Bestellvorgang wird nur die Warenkorb-Box aktualisiert!
				$BUYproduct=$_GET['BUYproducts_id'];
				if ($BUYproduct == EMPTY_STRING)
				{
					$BUYproduct=$_GET['BUYproducts_model'];
				}
				if ($BUYproduct == EMPTY_STRING)
				{
					if (CURRENT_SCRIPT==FILENAME_PRODUCT_INFO)
					{
						if ($_GET['action']=="add_product")
						{
							$BUYproduct=$_GET['products_id'];
						}
					}
				}
				if ($BUYproduct != EMPTY_STRING)
				{
					$use_ajax_short_list = true;
					$ajax_short_list = "box_CART";
					if (DISPLAY_CART == TRUE_STRING_S)
					{
						//Also redisplay main_content and navigation,
						//if cart is to be displayed after product add.
						$ajax_short_list .= $ajax_data_elements_main_content_navtrail;
					}
					else
					{
						$ajax_short_list .= $box_navigation;
					}
				}
			}
			if ($use_ajax_short_list)
			{
				//Nur bestimmte Elemente rendern!!!!
				$ajax_short_list=$ajax_short_list . $ajax_data_element_box_whatsnew_box_specials;
				if (USE_LAYOUT_DEFINITION==TRUE_STRING_S)
				{
					$ajax_short_list=replace_box_names($ajax_short_list);
				}
				define("AJAX_SHORT_LIST", $ajax_short_list);
				define("AJAX_VALID_RESOURCES_SHORT_LIST", BLANK . strtolower(AJAX_SHORT_LIST));
			}
		}
		define("AJAX_VALID_RESOURCES", BLANK . strtolower(AJAX_DATA_ELEMENTS_TO_CHANGE));
		define('AJAX_BUILD_INDEX',true);
	}
	else
	{
		define("IS_AJAX_PROCESSING", false);
		define("AJAX_ID", EMPTY_STRING);
	}
}
else
{
	define("USE_AJAX", false);		//Do not use AJAX
	define("IS_AJAX_PROCESSING", false);
	define("DO_AJAX_VALIDATION", false);
}
define("NOT_USE_AJAX", !USE_AJAX);
define("NOT_IS_AJAX_PROCESSING", !IS_AJAX_PROCESSING);
//W. Kaiser - AJAX
?>