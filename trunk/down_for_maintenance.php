<?php
/* -----------------------------------------------------------------------------------------
$Id: down_for_maintenance.php,v 1.1.1.1.2.1 2007/04/08 07:16:13 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(default.php,v 1.84 2003/05/07); www.oscommerce.com
(c) 2003	    nextcommerce (default.php,v 1.13 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contributions

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

if (!defined('EMPTY_STRING'))
{
	define('PHP','.php');
	define('INC_PHP','.inc.php');
	include('includes/configure.php');
	define('IS_ADMIN_FUNCTION',strpos($_SERVER['REQUEST_URI'],'admin/')>0);
	define("USE_AJAX", false);						//Do not use AJAX
	define("NOT_USE_AJAX", true);
	define("IS_AJAX_PROCESSING", false);
	define("NOT_IS_AJAX_PROCESSING", true);
	define('ADMIN_PATH_PREFIX','');
	require(DIR_WS_MODULES . 'application_init.php');
	// Include Template Engine
	require_once(DIR_WS_CLASSES.'smarty/Smarty.class.php');
	require_once(DIR_FS_INC.'olc_smarty_init.inc.php');
}
olc_smarty_init($smarty,$cacheid);
require_once(DIR_FS_INC.'olc_image.inc.php');
require_once(DIR_FS_INC.'olc_parse_input_field_data.inc.php');
require_once(DIR_FS_INC.'olc_draw_separator.inc.php');
$ErrorMessage = 'TEXT_ADMIN_DOWN_FOR_MAINTENANCE';
if (!defined($ErrorMessage))
{
	include_once(ADMIN_PATH_PREFIX.'lang'.SLASH.SESSION_LANGUAGE.SLASH.SESSION_LANGUAGE.PHP);
}

if (PERIOD_DOWN_FOR_MAINTENANCE != EMPTY_STRING)
{
	$s=HTML_BR.HTML_BR;
	$ErrorMessage=constant($ErrorMessage).
	$s . LPAREN.DOWN_FOR_MAINTENANCE_NAME . BLANK . ltrim(PERIOD_DOWN_FOR_MAINTENANCE).RPAREN.
	$s . TEXT_DOWN_FOR_MAINTENANCE_CALL_LATER;
}
$smarty->assign(MAIN_CONTENT, $ErrorMessage);
$smarty->display(CURRENT_TEMPLATE_MODULE . 'down_for_maintenance'.HTML_EXT);
?>