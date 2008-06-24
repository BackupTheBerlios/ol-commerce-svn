<?php
/*
$Id: order_send_money.inc.php,v 1.1.1.1.2.1 2007/04/08 07:18:08 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

DevosC, Developing open source Code
http://www.devosc.com

Copyright (c) 2003 osCommerce
Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

Released under the GNU General Public License
*/

if(strtolower($order->info['payment_method']) == 'paypal' &&
	$order->info['orders_status_id'] == MODULE_PAYMENT_PAYPAL_PROCESSING_STATUS_ID &&
	MODULE_PAYMENT_PAYPAL_INVOICE_REQUIRED == TRUE_STRING_S )
{
	include_once(DIR_WS_MODULES . 'payment/'.FILENAME_PAYPAL_IPN);
	$paypal = new PayPal();
	$paypal_confirm='<div style="float:right">' . NEW_LINE;
	$paypal_confirm.=olc_draw_form('paypal', $paypal->form_paypal_url, 'post');
	$paypal_confirm.=$paypal->sendMoneyFields($order,$HTTP_GET_VARS['order_id']).NEW_LINE;
	$paypal_confirm.=olc_image_submit('button_confirm_order.gif', IMAGE_BUTTON_CONFIRM_ORDER) . '</form>' . NEW_LINE;
	$paypal_confirm.='</div>' . NEW_LINE;
}
?>
