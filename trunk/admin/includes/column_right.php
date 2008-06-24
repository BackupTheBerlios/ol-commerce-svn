<?php
/* --------------------------------------------------------------
$Id: column_right.php,v 1.1.1.1.2.1 2007/04/08 07:16:38 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project (earlier name of osCommerce)
(c) 2002-2003 osCommerce(column_left.php,v 1.15 2002/01/11); www.oscommerce.com
(c) 2003	    nextcommerce (column_left.php,v 1.25 2003/08/19); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

/*
if (!$admin_access)
{
	$admin_access_query = olc_db_query("select * from " . TABLE_ADMIN_ACCESS . " where customers_id = '" .	CUSTOMER_ID . APOS);
	$admin_access = olc_db_fetch_array($admin_access_query);
}
*/
$Content=EMPTY_STRING;
$smarty_box=BOX_RIGHT;
include(DIR_WS_INCLUDES.'column_right_content.php');
if (USE_AJAX)
{
/*
		get_main_content_from_buffer($smarty);
*/
}
else if ($not_css_menu)
{
	$Content.='
	<!-- body_text_eof //-->
	<!-- W. Kaiser Use right nav box in admin -->
	<td class="columnRight" nowrap="nowrap" valign="top">
	'.
	$R_Content.'
	</td>
	<!-- W. Kaiser Use right nav box in admin -->
';
	echo $Content;
}
?>