<?php
/* -----------------------------------------------------------------------------------------
$Id: product_notifications.php,v 1.1 2004/02/07 23:02:54 fanta2k Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(product_notifications.php,v 1.7 2003/05/25); www.oscommerce.com
(c) 2003	    nextcommerce (product_notifications.php,v 1.9 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

if ($is_checkout_shipping)
{
	if (IS_AJAX_PROCESSING)
	{
		$box_notifications=HTML_NBSP;
	}
}
else
{
	olc_smarty_init($box_smarty,$cacheid);
	// include needed files
	require_once(DIR_FS_INC.'olc_get_products_name.inc.php');
	$products_id=$_GET['products_id'];
	if ($products_id)
	{
		if (CUSTOMER_ID)
		{
			$check_query = olc_db_query("select count(*) as count from " . TABLE_PRODUCTS_NOTIFICATIONS .
			" where products_id = '" . (int)$products_id . "' and customers_id = '" . CUSTOMER_ID . APOS);
			$check = olc_db_fetch_array($check_query);
			$notification_exists = $check['count'] > 0;
		}
		else
		{
			$notification_exists = false;
		}
		$info_box_contents = array();
		$box_content0='
		<td class="infoBoxContents">
			<a href="' . olc_href_link(CURRENT_SCRIPT, olc_get_all_get_params(array('action')) .
			'action=notify', $request_type) . '">
			#
			</a>
		</td>
';
		$products_name=olc_get_products_name($products_id);
		$image=DIR_WS_IMAGES . 'box_products_notifications@.gif';
		if ($notification_exists)
		{
			$image = str_replace(ATSIGN,'_remove',$image);
			$box_content = str_replace(HASH,olc_image($image,IMAGE_BUTTON_REMOVE_NOTIFICATIONS),$box_content0);
			$box_content .= str_replace(HASH,sprintf(BOX_NOTIFICATIONS_NOTIFY_REMOVE, $products_name),$box_content0);
		}
		else
		{
			$image = str_replace(ATSIGN,EMPTY_STRING,$image);
			$box_content = str_replace(HASH,olc_image($image,IMAGE_BUTTON_NOTIFICATIONS),$box_content0);
			$box_content .= str_replace(HASH,sprintf(BOX_NOTIFICATIONS_NOTIFY, $products_name),$box_content0);
		}
	}
	$box_content = '
<table border="0" cellspacing="0" cellpadding="2">
	<tr>
'.$box_content . '
	</tr>
</table>
';
	$box_smarty->assign('BOX_CONTENT', $box_content);
	$box_notifications= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_notifications'.HTML_EXT,$cacheid);
}
$smarty->assign('box_NOTIFICATIONS',$box_notifications);
?>