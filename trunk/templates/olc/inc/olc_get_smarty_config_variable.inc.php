<?PHP
//W. Kaiser - AJAX

/* -----------------------------------------------------------------------------------------
$Id: olc_get_smarty_config_variable.inc.php,v 1.0 2006/03/14 fanta2k Exp $

Get variable value from smarty config file

Winfried kaiser, w.kaiser@fortune.de

OL-Commerce Version 2.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_array_to_string.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_get_smarty_config_variable($smarty,$section,$variable='')
{
	$config_file=SESSION_LANGUAGE.'/lang_'.SESSION_LANGUAGE.'.conf';
	$smarty->config_load($config_file, $section);
	$return=$smarty->_config[0]['vars'];
	if ($variable<>'')
	{
		$return=$return[$variable];
	}
	return $return;
}
//W. Kaiser - AJAX
?>