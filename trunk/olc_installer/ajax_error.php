<?php
//W. Kaiser - AJAX
/* -----------------------------------------------------------------------------------------
$Id: ajax_error.php,v 1.1.1.1 2006/12/22 13:35:35 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

AJAX = Asynchronous JavaScript and XML
Info: http://de.wikipedia.org/wiki/Ajax_(Programmierung)

AJAX error reporting on startup

Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de), w.kaiser@fortune.de

-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(shopping_cart.php,v 1.18 2003/02/10); www.oscommerce.com
(c) 2003	  nextcommerce (shopping_cart.php,v 1.15 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------
*/

require_once('../inc/xtc_define_global_constants.inc.php');
// Some FileSystem Directories
if (!defined('DIR_FS_DOCUMENT_ROOT'))
{
	define('DIR_FS_DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
	$local_install_path=str_replace('/xtc_installer',EMPTY_STRING,$_SERVER['PHP_SELF']);
	$local_install_path=dirname($local_install_path);
	$local_install_path=str_replace("\\",SLASH,$local_install_path);
	if (substr($local_install_path,-1,1)<>SLASH)
	{
		$local_install_path.=SLASH;
	}
	define('DIR_WS_CATALOG', $local_install_path);
	define('DIR_FS_CATALOG', DIR_FS_DOCUMENT_ROOT . $local_install_path);
}
define('DIR_FS_INCLUDES', DIR_FS_CATALOG.'includes/');
define('DIR_FS_INC', DIR_FS_CATALOG.'inc/');
define('ADMIN_PATH_PREFIX','../');
include(DIR_FS_INCLUDES.'configure.php');

define('IS_ADMIN_FUNCTION',false);
define("USE_AJAX", false);						//Do not use AJAX
define("NOT_USE_AJAX", true);
define("IS_AJAX_PROCESSING", false);
define("NOT_IS_AJAX_PROCESSING", true);
// Include Template Engine
require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES . 'smarty/Smarty.class.php');
include_once(DIR_FS_INC.'xtc_smarty_init.inc.php');
xtc_smarty_init($smarty,$cacheid);
$smarty->assign('tpl_path', $smarty->template_dir.'/'.CURRENT_TEMPLATE.'/');
$smarty->assign('cat_path',DIR_WS_CATALOG);
$no_ajax_link=$_GET['request_url'];
if ( empty($no_ajax_link) )
{
	$no_ajax_link = 'sitemap.php';
}
if (strpos($no_ajax_link,'?'))
{
	$no_ajax_link.="&";
}
else
{
	$no_ajax_link.="?";
}
$smarty->assign('no_ajax_link',$no_ajax_link);
$reason=$_GET['reason'];
if ($reason=="")
{
	$reason="no_javascript";
}
$smarty->display($current_template.'/module/ajax_'.$reason.'.html');
exit();
//W. Kaiser - AJAX
?>