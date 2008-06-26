<?php
//W. Kaiser - AJAX
/* -----------------------------------------------------------------------------------------
$Id: olc_smarty_init.inc.php,v 1.1.1.2.2.1 2007/04/08 07:17:41 gswkaiser Exp $

Initialize Smarty and set some commom values

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce; www.oscommerce.com
(c) 2003	    nextcommerce ; www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

if (OL_COMMERCE)
{
	$inc_path=DIR_FS_INC;
}
else
{
	$inc_path=INC_PATH;
	$s='FULL_CURRENT_TEMPLATE';
	if (!defined($s))
	{
		include_once($inc_path.'olc_define_global_constants.inc.php');
		$current_template=CURRENT_TEMPLATE.SLASH;
		define($s,TEMPLATE_PATH.$current_template);
		include_once($inc_path.'olc_get_box_code_script_path.inc.php');
		include_once($inc_path.'olc_get_box_configuration.inc.php');
		if (!class_exists('std_Smarty'))
		{
			include_once($inc_path.'olc_smarty_hack.inc.php');
		}
		define("USE_AJAX", false);		//Do not use AJAX
		define("IS_AJAX_PROCESSING", false);
		define("DO_AJAX_VALIDATION", false);
		define("NOT_USE_AJAX", !USE_AJAX);
		define("NOT_IS_AJAX_PROCESSING", !IS_AJAX_PROCESSING);
		define('ADMIN_PATH_PREFIX',EMPTY_STRING);
		define('IS_ADMIN_FUNCTION',false);
		define('OL_COMMERCE',false);
		//define('CHECK_UNIFIED_BOXES',CHECK_LAYOUT_DEFINITION);
		define('SESSION_LANGUAGE',$_SESSION['language']);
		define('SESSION_LANGUAGE_ID',$_SESSION['languages_id']);
		define('SESSION_CURRENCY',$_SESSION['currency']);

		define('DO_GROUP_CHECK',GROUP_CHECK==TRUE_STRING_S);
		define('SQL_GROUP_CONDITION',"group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'");
		include_once($inc_path.'olc_get_box_code_script_path.inc.php');
		include_once($inc_path.'olc_get_box_configuration.inc.php');
		if (!class_exists('std_Smarty'))
		{
			include_once($inc_path.'olc_smarty_hack.inc.php');
		}
		define("USE_AJAX", false);		//Do not use AJAX
		define("IS_AJAX_PROCESSING", false);
		define("DO_AJAX_VALIDATION", false);
		define("NOT_USE_AJAX", !USE_AJAX);
		define("NOT_IS_AJAX_PROCESSING", !IS_AJAX_PROCESSING);
		include_once($inc_path.'olc_backtrace.inc.php');
		include_once($inc_path.'olc_error_handler.inc.php');
		set_error_handler("my_error_handler");  //set my own handler

		define('SESSION_LANGUAGE_DIR','lang'.SLASH.SESSION_LANGUAGE.SLASH);
		define('NO_IMAGE_NAME',SESSION_LANGUAGE_DIR.'no_image.jpg');
		$current_template=CURRENT_TEMPLATE.SLASH;
		define('FULL_CURRENT_TEMPLATE',TEMPLATE_PATH . $current_template);
		$buttons='buttons'.SLASH.SESSION_LANGUAGE.SLASH;
		define('CURRENT_TEMPLATE_BUTTONS',FULL_CURRENT_TEMPLATE.$buttons);
		define('CURRENT_TEMPLATE_ADMIN',ADMIN_PATH_PREFIX.FULL_CURRENT_TEMPLATE.$admin);
		define('CURRENT_TEMPLATE_ADMIN_BUTTONS',CURRENT_TEMPLATE_ADMIN.$buttons);
		define('CURRENT_TEMPLATE_ADMIN_IMG',CURRENT_TEMPLATE_ADMIN.'images'.SLASH);
		$admin='admin'.SLASH;
		$boxes='boxes'.SLASH;
		$module='module'.SLASH;
		$base=ADMIN_PATH_PREFIX.TEMPLATE_PATH.COMMON_TEMPLATE;
		$base=is_dir($base.$boxes);
		define('CHECK_UNIFIED_TEMPLATES',$base);
		//Define some global, often used constants. No need to always recompute them
		$session_language='mail'.SLASH.SESSION_LANGUAGE.SLASH;
		define('CURRENT_TEMPLATE_MAIL',$current_template.$session_language);
		define('CURRENT_TEMPLATE_BOXES',$current_template.$boxes);
		define('CURRENT_TEMPLATE_MODULE',$current_template.$module);
		define('CURRENT_TEMPLATE_IMG',FULL_CURRENT_TEMPLATE.'img'.SLASH);
		$template_path=ADMIN_PATH_PREFIX.TEMPLATE_PATH.CURRENT_TEMPLATE.SLASH;
		$file='images/bullet.gif';
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
		$customers_status_text='customers_status';
		$customers_id_text='customers_id';
		$customers_status_lead_text=$customers_status_text.UNDERSCORE;
		$customers_status_id_text=$customers_status_lead_text.'id';
		define('CUSTOMER_ID', $_SESSION[customers_id_text]);
		$customers_status_id=$_SESSION[customers_status_text]['customers_status_id'];
		define('CUSTOMER_IS_ADMIN', $customers_status_id==DEFAULT_CUSTOMERS_STATUS_ID_ADMIN);
		define('ISSET_CUSTOMER_ID', CUSTOMER_ID<>EMPTY_STRING);
		define('CUSTOMER_STATUS_ID',$customers_status_id);
		define('SQL_GROUP_CONDITION',"group_ids LIKE '%c_".$customers_status_id."_group%'");
		define('CUSTOMER_SHOW_PRICE', $_SESSION[$customers_status_text][$customers_status_lead_text.'show_price']==ONE_STRING);
		define('CUSTOMER_SHOW_PRICE_TAX',
			$_SESSION[$customers_status_text][$customers_status_lead_text.'show_price_tax'] == ONE_STRING);
		define('CUSTOMER_SHOW_GRADUATED_PRICE',
			$_SESSION[$customers_status_text][$customers_status_lead_text.'graduated_prices']==ONE_STRING);
		define('CUSTOMER_IS_FSK18', $_SESSION[$customers_status_text]['customers_fsk18']==ONE_STRING);
		define('CUSTOMER_NOT_IS_FSK18', !CUSTOMER_IS_FSK18);
		define('CUSTOMER_IS_FSK18_DISPLAY', $_SESSION[$customers_status_text]['customers_fsk18_display']==ONE_STRING);
		define('CUSTOMER_DISCOUNT', $_SESSION[$customers_status_text][$customers_status_lead_text.'discount']);
		define('CUSTOMER_OT_DISCOUNT', (float)$_SESSION[$customers_status_text][$customers_status_lead_text.'ot_discount']);
		define('CUSTOMER_SHOW_OT_DISCOUNT',
			$_SESSION[$customers_status_text][$customers_status_lead_text.'ot_discount_flag'] == ONE_STRING);
		define('INT_CUSTOMER_ID', (int)CUSTOMER_ID);
		define('CUSTOMER_COUNTRY_ID',$customers_country_id);
		define('CUSTOMER_ZONE_ID',$customers_zone_id);
		define('CURRENT_SCRIPT',basename($_SERVER['PHP_SELF']));
	}
}

include_once($inc_path.'olc_get_smarty_config_variable.inc.php');

function olc_smarty_init(&$smarty,&$cacheid,$full_init=true)
{
	global $http_protocol,$server;

	//Set common Smarty data
	if (defined('CURRENT_TEMPLATE'))
	{
		define('FULL_CURRENT_TEMPLATE',TEMPLATE_PATH.CURRENT_TEMPLATE.SLASH);
	}
	else
	{
		$tpl_path=$tpl_path;
	}
	if (!is_object($smarty))
	{
		//Create smarty elements
		$smarty = new Smarty;
	}
	$tpl_path=FULL_CURRENT_TEMPLATE;
	$template_dir='templates';
	$template_c_dir='cache/templates_c'.SLASH;
	$compile_dir='cache/templates_c/'.CURRENT_TEMPLATE;
	$config_dir='lang';
	$cache_dir='cache';
	if (IS_ADMIN_FUNCTION)		//Running admin function or multi-shop-function?
	{
		$compile_dir=ADMIN_PATH_PREFIX.$compile_dir;
		$smarty->cache_dir=ADMIN_PATH_PREFIX.$cache_dir;
		$config_dir=ADMIN_PATH_PREFIX.$config_dir;
		$template_dir=ADMIN_PATH_PREFIX.$template_dir;
		$tpl_path=ADMIN_PATH_PREFIX.$tpl_path;
		$smarty->assign('tpl_path_catalog',$tpl_path);
		$tpl_path.="admin".SLASH;
	}
	//$smarty->assign(BULLET_TEXT,BULLET);
	$smarty->cache_dir=$cache_dir;
	$smarty->compile_dir=$compile_dir;
	$smarty->config_dir=$config_dir;
	$smarty->template_dir=$template_dir;
	if ($full_init)
	{
		$not_have_dir=!is_dir($compile_dir);
		if ($not_have_dir)
		{
			$compile_dirs=array($compile_dir,$template_c_dir);
			for ($i=0,$n=sizeof($compile_dirs);$i<$n;$i++)
			{
				$compile_dir=$compile_dirs[$i];
				@mkdir($compile_dir);
				$ok_rights=is_dir($compile_dir);
				if ($ok_rights)
				{
					$ok_rights=decoct(fileperms($compile_dir))>=0777;
					$error=TEXT_SMARTY_COMPILE_DIR_RIGHTS;
				}
				else
				{
					$error=TEXT_NO_SMARTY_COMPILE_DIR;
				}
				if (!$ok_rights)
				{
					if (IS_ADMIN_FUNCTION)
					{
						$lang_dir=$config_dir.SLASH.SESSION_LANGUAGE.SLASH;
						require(ADMIN_PATH_PREFIX.$lang_dir.SESSION_LANGUAGE.PHP);
					}
					my_error_handler(E_USER_ERROR, sprintf($error,$compile_dir));
				}
			}
		}
		else
		{
			$ok_rights=decoct(fileperms($compile_dir))>=0777;
		}
		if ($ok_rights)
		{
			$smarty->assign('tpl_path',$tpl_path);
			$smarty->assign('PROJECT_VERSION',PROJECT_VERSION);
			$smarty->assign('OL_COMMERCE',$ol_commerce);
			$smarty->assign('USE_AJAX',USE_AJAX);
			$smarty->assign('FORM_END','</form>');
			$use_caching=USE_CACHE==TRUE_STRING_S;
			if ($use_caching)
			{
				$smarty->cache_lifetime=CACHE_LIFETIME;
				$smarty->cache_modified_check=CACHE_CHECK;
				$caret="^";
				$cacheid=SESSION_LANGUAGE_ID.$caret.CUSTOMER_ID.$caret.
				str_replace(DOT,"%",$_SERVER['REMOTE_ADDR'].$caret.CURRENT_SCRIPT);
			}
			if (defined('SESSION_LANGUAGE'))
			{
				$smarty->assign('language', SESSION_LANGUAGE);
				$smarty->assign('HTTP_PROTOCOL', $http_protocol);
				$smarty->assign('SERVER', $server);
				$s='SMARTY_CACHE_ID';
				if (defined($s))
				{
					$text_footer=$_SESSION[$text_footer_text];
				}
				else
				{
					define($s,$cacheid);
					$text_footer_text='text_footer';
					$text_footer=$_SESSION[$text_footer_text];
					if (!$text_footer)
					{
						$text_footer=olc_get_smarty_config_variable($smarty,'index','text_footer');
						$text_footer=str_replace(HASH,STORE_NAME,$text_footer).PROJECT_VERSION.HTML_A_END;
						$s='GENERAL_DISCLAIMER';
						if (defined($s))
						{
							if (GENERAL_DISCLAIMER)
							{
								$text_footer.=HTML_BR.'<font style="font-weight:normal">'.constant($s).'</font>';
							}
						}
						$_SESSION[$text_footer_text]=$text_footer;
					}
				}
				$smarty->assign($text_footer_text,$text_footer);
			}
		}
		else
		{
			my_error_handler(E_USER_ERROR,sprintf(TEXT_SMARTY_COMPILE_DIR_RIGHTS,$compile_dir));
		}
	}
	$smarty->caching = $use_caching;
}
//W. Kaiser - AJAX
?>