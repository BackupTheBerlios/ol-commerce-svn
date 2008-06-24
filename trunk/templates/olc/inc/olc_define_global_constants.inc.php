<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_define_global_constants.inc.php,v 1.1.1.2 2006/12/23 09:14:14 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(banner.php,v 1.10 2003/02/11); www.oscommerce.com
(c) 2003	    nextcommerce (olc_banner_exists.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

$s='NOT_USE_AJAX_ADMIN';
if (!defined($s))
{
	define($s,USE_AJAX_ADMIN==false);
	define('RM',true);
	define('PHP','.php');
	define('EMPTY_STRING','');
	define('ONE_STRING','1');
	define('ZERO_STRING','0');
	define('BLANK',' ');
	define('DASH','-');
	define('HASH','#');
	define('SLASH','/');
	define('ATSIGN','@');
	define('DOT','.');
	define('APOS','\'');
	define('QUESTION','?');
	define('QUOTE','"');
	define('COMMA',',');
	define('COLON',':');
	define('EQUAL','=');
	define('TILDE','~');
	define('PARA','§');
	define('LPAREN',' (');
	define('RPAREN',')');
	define('HTML_NDASH','&ndash;');
	define('HTML_MDASH','&mdash;');
	define('XDASH_REPLACE','--');

	define('SEMI_COLON',';');
	define('UNDERSCORE','_');
	define('PERCENT','%');
	define('COMMA_BLANK',COMMA.BLANK);
	define('COLON_BLANK', COLON.BLANK);
	define('HTML_NBSP','&nbsp;');
	define('HTML_BR','<br/>');
	define('HTML_A_START','<a href="');
	define('HTML_A_END','</a>');
	define('HTML_B_START','<b>');
	define('HTML_B_END','</b>');
	define('AMP','&');
	//define('HTML_AMP','&amp;');
	define('HTML_AMP',AMP);
	define('HTML_SELECTED',' selected="selected" ');
	define('HTML_HR','<hr/>');
	define('HTTP','HTTP');
	define('HTTPS','HTTPS');
	define('SSL','SSL');
	define('NONSSL','NONSSL');
	define('MAIN_CONTENT','main_content');
	define('MODULE_CONTENT','module_content');
	define('HTM_EXT','.htm');
	define('HTML_EXT','.html');
	define('NEW_LINE',"\n");
	define('DEBUG_OUPUT','debug_output');
	define('DELETE_FROM','delete from ');
	define('INSERT_INTO','insert into ');
	define('SQL_FROM',' from ');
	define('SELECT','select ');
	define('SELECT_ALL',SELECT.'*'.SQL_FROM);
	define('SELECT_COUNT',SELECT.'count(*) ');
	define('SQL_WHERE',' where ');
	define('SQL_AND', ' and ');
	define('SQL_OR', ' or ');
	define('SQL_LIKE', ' like ');
	define('SQL_ORDER_BY',' ORDER BY ');
	define('SQL_UPDATE','update ');
	define('UPDATE',rtrim(SQL_UPDATE));
	define('INSERT','insert');
	define('TRUE_STRING_S','true');
	define('TRUE_STRING_L','True');
	define('FALSE_STRING_S','false');
	define('FALSE_STRING_L','False');
	define("AJAX_ID", "ajax=true");
	define('BEGIN','BEGIN');
	define('END','END');
	define('BOX','box_');
	define('BOX_CONTENT',BOX.'content');
	define('COMMENT',"\n<!-- @ #-->\n");
	define('PRODUCTS_INFO_LINE','PRODUCTS_INFO_LINE_');
	define('PRODUCTS_LINE_IMAGE','PRODUCTS_LINE_IMAGE_');
	define('FULL_ERRORS','full_errors');
	define('TEMPLATE_PATH','templates'.SLASH);
	define('TEMPLATE_C_PATH','cache/templates_c'.SLASH);
	define('OLC_SMARTY_DIR','smarty_dir');
	define('IS_LOCAL_HOST',file_exists('d:\vb6\C2.EXE'));
	if ($_SERVER[HTTPS] != null)
	{
		$http_protocol = 'https';
		$server=HTTPS_SERVER;
	}
	else
	{
		$http_protocol = 'http';
		$server=HTTP_SERVER;
	}
	define('SERVER',$server);
}
?>