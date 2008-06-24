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

include_once(DIR_FS_INC.'olc_get_smarty_config_variable.inc.php');

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
		//$config_dir=ADMIN_PATH_PREFIX.$config_dir;
		$template_dir=ADMIN_PATH_PREFIX.$template_dir;
		$tpl_path=ADMIN_PATH_PREFIX.$tpl_path;
		$smarty->assign('tpl_path_catalog',$tpl_path);
		$tpl_path.="admin".SLASH;
	}
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
			/*
			$traceArr = debug_backtrace();
			$s = str_replace('\\',SLASH,strtolower($traceArr[0]['file']));
			$s = str_replace(strtolower(DIR_FS_CATALOG),EMPTY_STRING,$s);
			$smarty->assign('initted_in',$s.COLON.$traceArr[0]['line']);
			*/
			$smarty->assign('tpl_path',$tpl_path);
			$smarty->assign('PROJECT_VERSION',PROJECT_VERSION);
			$smarty->assign('OL_COMMERCE',true);
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