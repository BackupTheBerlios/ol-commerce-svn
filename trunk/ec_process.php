<?php
/*
ec_process.php -- PayPal WPP Easy Checkout

Copyright (c) 2005 Mr. Brian Burton - brian@dynamoeffects.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

Released under the GNU General Public License
*/

require('includes/application_top.php');
require_once(DIR_FS_INC.'olc_paypal_wpp_enabled.inc.php');
if (olc_paypal_wpp_enabled())
{
	unset($_SESSION['paypal_error']);
	$paypal_ec_text='paypal_ec_';
	if ($_GET['clearSess'])
	{
		unset($_SESSION[$paypal_ec_text.'temp']);
		unset($_SESSION[$paypal_ec_text.'token']);
		unset($_SESSION[$paypal_ec_text.'payer_id']);
		unset($_SESSION[$paypal_ec_text.'payer_info']);
	}
	if($_SESSION[$paypal_ec_text.'token'])
	{
		require(DIR_WS_LANGUAGES . SESSION_LANGUAGE . SLASH . FILENAME_EC_PROCESS);
		require(DIR_WS_CLASSES . 'payment.php');
		$payment_modules = new payment('paypal_wpp');
		$payment_modules->ec_step2();
	}
	else
	{
		if ($_GET['action']=='process')
		{
			//W. Kaiser - AJAX
			$error_message=EMPTY_STRING;
			if (!$_POST['conditions'])
			{
				$error_message=ERROR_CONDITIONS_NOT_ACCEPTED;
			}
			//	W. Kaiser
			if (!$_POST['fernag'])
			{
				if (strlen($error_message)>0)
				{
					$error_message.="\n\n";
				}
			}
			//	W. Kaiser
			if (strlen($error_message)>0)
			{
				if (IS_AJAX_PROCESSING)
				{
					ajax_error($error_message);
				}
				else
				{
					$smarty->assign('error',nl2br($error_message));
				}
			}
			else
			{
				$process=true;
			}
		}
		if (!$process)
		{
			//check if display conditions on checkout page is true
			if (DISPLAY_CONDITIONS_ON_CHECKOUT == TRUE_STRING_S && MODULE_PAYMENT_PAYPAL_DP_DISPLAY_PAYMENT_PAGE != 'Yes')
			{
				require_once(DIR_FS_INC.'olc_image_button.inc.php');
				require_once(DIR_FS_INC.'olc_draw_checkbox_field.inc.php');
				$shop_content_query=olc_db_query("SELECT
 					content_title,
 					content_heading,
 					content_text,
 					content_file
 					FROM ".
				TABLE_CONTENT_MANAGER."
 					WHERE
 					content_group='3' AND
 					languages_id='".SESSION_LANGUAGE_ID.APOS);
				$shop_content_data=olc_db_fetch_array($shop_content_query);
				if ($shop_content_data['content_file']!=EMPTY_STRING)
				{
					$conditions= '<iframe SRC="'.DIR_WS_CATALOG.'media/content/'.$shop_content_data['content_file'].
					'" width="100%" height="500" style="background-color:transparent";>';
					$conditions.= '</iframe>';
				} else {
					$conditions= '<textarea name="blabla" cols="60" rows="10" readonly="readonly">'.
					strip_tags(str_replace(HTML_BR,NEW_LINE,$shop_content_data['content_text'])).'</textarea>';
				}
				$smarty->assign('FORM_ACTION',olc_draw_form('ec_checkout',FILENAME_EC_PROCESS,
				olc_href_link(FILENAME_CHECKOUT_CONFIRMATION, EMPTY_STRING, SSL), 'post','action=process'));
				$smarty->assign('AGB',$conditions);
				$smarty->assign('AGB_checkbox',olc_draw_checkbox_field('conditions',TRUE_STRING_S));
				$checkout_payment='checkout_payment';
				$accept_agb='accept_agb';
				$s=olc_get_smarty_config_variable($smarty,$checkout_payment,'text_'.$accept_agb);
				$smarty->assign(strtoupper($accept_agb),str_replace('@',SESSION_LANGUAGE,$s));
				// W. Kaiser
				$smarty->assign('FERNAG_checkbox',olc_draw_checkbox_field('fernag',TRUE_STRING_S));
				$accept_fernag='accept_fernag';
				$s=olc_get_smarty_config_variable($smarty,$checkout_payment,'text_'.$accept_fernag);
				$smarty->assign(strtoupper($accept_fernag),str_replace('@',SESSION_LANGUAGE,$s));
				// W. Kaiser
				$smarty->assign('BUTTON_CONTINUE',olc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
				$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'ec_process'.HTML_EXT,SMARTY_CACHE_ID);
				$smarty->assign(MAIN_CONTENT,$main_content);
				$smarty->display(INDEX_HTML);
			}
			else
			{
				$process=true;
			}
		}
		if ($process)
		{
			require(DIR_WS_LANGUAGES . SESSION_LANGUAGE . SLASH . FILENAME_EC_PROCESS);
			require(DIR_WS_CLASSES . 'payment.php');
			$payment_modules = new payment('paypal_wpp');
			$payment_modules->ec_step1();
		}
	}
}
?>
