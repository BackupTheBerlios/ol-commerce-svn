<?php
/* -----------------------------------------------------------------------------------------
$Id: gift_cart.php,v 1.1.1.1.2.1 2007/04/08 07:17:59 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(shopping_cart.php,v 1.32 2003/02/11); www.oscommerce.com
(c) 2003     nextcommerce (shopping_cart.php,v 1.21 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contributions:


Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
http://www.oscommerce.com/community/contributions,282
Copyright (c) Strider | Strider@oscworks.com
Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
Copyright (c) Andre ambidex@gmx.net
Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

olc_smarty_init($gift_smarty,$cacheid);
if (ACTIVATE_GIFT_SYSTEM==TRUE_STRING_S) {
	$gift_smarty->assign('ACTIVATE_GIFT',TRUE_STRING_S);
}
if (CUSTOMER_ID)
{
	$gift_smarty->assign('C_FLAG',TRUE_STRING_S);
	$gv_query = olc_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER .
	" where customer_id = '" . CUSTOMER_ID . APOS);
	$gv_result = olc_db_fetch_array($gv_query);
	if ($gv_result['amount'] > 0 ) {
		$gift_smarty->assign('GV_AMOUNT', olc_format_price($gv_result['amount'],true,true));
		$gift_smarty->assign('GV_SEND_TO_FRIEND_LINK', HTML_A_START. olc_href_link(FILENAME_GV_SEND) . '">');
	}
}
if (isset($_SESSION['gv_id'])) {
	$gv_query = olc_db_query("select coupon_amount from " . TABLE_COUPONS .
	" where coupon_id = '" . $_SESSION['gv_id'] . APOS);
	$coupon = olc_db_fetch_array($gv_query);
	$gift_smarty->assign('COUPON_AMOUNT2', olc_format_price($coupon['coupon_amount'],true,true));
}
if (isset($_SESSION['cc_id'])) {
	$gift_smarty->assign('COUPON_HELP_LINK', '<a style="cursor:hand" onclick="javascript:window.open(\''.olc_href_link(FILENAME_POPUP_COUPON_HELP, 'pop_up=true&cID='.$_SESSION['cc_id']).'\', \'popup\', \'toolbar=0,scrollbars=yes, width=400, height=400\')">');

}
$gift_smarty->assign('LINK_ACCOUNT',olc_href_link(FILENAME_CREATE_ACCOUNT));
//W. Kaiser - AJAX
$gift_smarty->assign('FORM_ACTION',olc_draw_form('gift_coupon',olc_href_link(FILENAME_SHOPPING_CART, 'action=check_gift',NONSSL)));
//W. Kaiser - AJAX
$gift_smarty->assign('INPUT_CODE',olc_draw_input_field('gv_redeem_code'));
$gift_smarty->assign('BUTTON_SUBMIT',olc_image_submit('button_redeem.gif', IMAGE_REDEEM_GIFT));
$smarty->assign('MODULE_gift_cart',$gift_smarty->fetch(CURRENT_TEMPLATE_MODULE . 'gift_cart'.HTML_EXT,$cacheid));
?>