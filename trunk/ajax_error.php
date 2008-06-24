<?php
//W. Kaiser - AJAX
/* -----------------------------------------------------------------------------------------
$Id: ajax_error.php,v 1.1.1.1.2.1 2007/04/08 07:16:08 gswkaiser Exp $

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

define('PHP','.php');
define('INC_PHP','.inc.php');
include('includes/configure.php');
include('inc/olc_get_template.inc.php');
$current_template=olc_get_template(true);

// include needed functions
require_once(DIR_FS_INC.'olc_db_connect.inc.php');
require_once(DIR_FS_INC.'olc_db_fetch_array.inc.php');
require_once(DIR_FS_INC.'olc_db_query.inc.php');
require_once(DIR_FS_INC.'olc_smarty_init.inc.php');
define('MULTI_DB_SERVER',false);
// make a connection to the database... now
olc_db_connect() or die('Kann keine Verbindung zur Datenbank erhalten!');
// set the application parameters
$configuration_query =
olc_db_query("select configuration_key, configuration_value from " .
TABLE_PREFIX."configuration where configuration_key='CURRENT_TEMPLATE'");
$configuration = olc_db_fetch_array($configuration_query);
define($configuration['configuration_key'], $configuration['configuration_value']);
define('IS_ADMIN_FUNCTION',strpos($_SERVER['REQUEST_URI'],'admin/')>0);
//define('FULL_CURRENT_TEMPLATE',$configuration_query);
define("USE_AJAX", false);						//Do not use AJAX
define("NOT_USE_AJAX", true);
define("IS_AJAX_PROCESSING", false);
define("NOT_IS_AJAX_PROCESSING", true);
// Include Template Engine
require_once(DIR_WS_CLASSES . 'smarty/Smarty.class.php');
olc_smarty_init($smarty,$cacheid);
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