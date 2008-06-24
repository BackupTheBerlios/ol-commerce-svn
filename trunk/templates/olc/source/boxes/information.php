<?php
/* -----------------------------------------------------------------------------------------
$Id: information.php,v 1.4 2004/02/22 16:15:30 fanta2k Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(information.php,v 1.6 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (information.php,v 1.8 2003/08/21); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
olc_smarty_init($box_smarty,$cacheid);
$content_string ='';
$content_query=olc_db_query("SELECT
 					content_id,
 					categories_id,
 					parent_id,
 					content_title,
 					content_group
 					FROM ".TABLE_CONTENT_MANAGER."
 					WHERE languages_id='".SESSION_LANGUAGE_ID."'
 					and file_flag=0 and content_status=1 ORDER BY content_id");

while ($content_data=olc_db_fetch_array($content_query)) {
	$content_string .= HTML_A_START . olc_href_link(FILENAME_CONTENT,'coID='.$content_data['content_group']) . '">' .
	$content_data['content_title'] . HTML_A_END;
}
if ($content_string!='')
{
	$box_smarty->assign('BOX_CONTENT',$content_string);
	$box_information= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_information'.HTML_EXT,$cacheid);
	$smarty->assign('box_INFORMATION',$box_information);
}
?>