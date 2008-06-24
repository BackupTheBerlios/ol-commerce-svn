<?php
/* -----------------------------------------------------------------------------------------
$Id: languages.php,v 1.2 2004/02/17 16:20:07 fanta2k Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(languages.php,v 1.14 2003/02/12); www.oscommerce.com
(c) 2003	    nextcommerce (languages.php,v 1.8 2003/08/17); www.nextcommerce.org

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

if (!is_object($lng))
{
	include_once(DIR_WS_CLASSES . 'language'.PHP);
	$lng = new language;
}
$count_lng=sizeof($lng->catalog_languages);
// dont show box if there's only 1 language
if ($count_lng > 1)
{
	$languages_string = EMPTY_STRING;
	reset($lng->catalog_languages);
	while (list($key, $value) = each($lng->catalog_languages))
	{
		$directory=$value['directory'];
		if ($directory)
		{
			$count_lng++;
			$languages_string .= BLANK.HTML_A_START .
			olc_href_link(CURRENT_SCRIPT, 'language=' . $key, $request_type) . '">' .
			olc_image('lang/' .  $directory .SLASH . $value['image'], $value['name']) . HTML_A_END;
		}
	}
	olc_smarty_init($box_smarty,$cacheid);
	$box_content=EMPTY_STRING;
	$box_smarty->assign('BOX_CONTENT', $languages_string);
	$box_languages= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_languages'.HTML_EXT,$cacheid);
	$smarty->assign('box_LANGUAGES',$box_languages);
}
?>