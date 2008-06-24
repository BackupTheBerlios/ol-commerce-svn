<?php
/* --------------------------------------------------------------
$Id: install_step6.php,v 1.1.1.1.2.1 2007/04/08 07:18:30 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)   (c) 2004  		OL - Commerce; www.ol-Commerce.com

Released under the GNU General Public License
--------------------------------------------------------------
based on:
(c) 2003	    nextcommerce ($install_step.php,v 1.26 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com
(c) 2004  		OL - Commerce; www.ol-Commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application.php');

$status_discount_text = 'STATUS_DISCOUNT';
$status_ot_discount_flag_text = 'STATUS_OT_DISCOUNT_FLAG';
$status_ot_discount_text = 'STATUS_OT_DISCOUNT';
$graduated_price_text = 'STATUS_GRADUATED_PRICE';
$show_price_text = 'STATUS_SHOW_PRICE';
$show_tax_text = 'STATUS_SHOW_TAX';
$two_string='2';
$status_discount2_text =$status_discount_text .$two_string;
$status_ot_discount_flag2_text =$status_ot_discount_flag_text .$two_string;
$status_ot_discount2_text =$status_ot_discount_text .$two_string;
$graduated_price2_text =$graduated_price_text .$two_string;
$show_price2_text =$show_price_text .$two_string;
$show_tax2_text =$show_tax_text .$two_string;

if ($process)
{
	$error = false;
	// default guests
	$status_discount = get_check_input($status_discount_text,3,ENTRY_DISCOUNT_ERROR);
	$status_ot_discount = get_check_input($status_ot_discount_text,3,ENTRY_DISCOUNT_ERROR);
	$status_ot_discount_flag = get_check_bool_value($status_ot_discount_flag_text,SELECT_OT_DISCOUNT_ERROR);
	$graduated_price = get_check_bool_value($graduated_price_text,SELECT_GRADUATED_ERROR);
	$show_price = get_check_bool_value($show_price_text,SELECT_PRICE_ERROR);
	$show_tax = get_check_bool_value($show_tax_text,SELECT_TAX_ERROR);

	// default customers
	$status_discount2 = get_check_input($status_discount2_text,3,ENTRY_DISCOUNT_ERROR2);
	$status_ot_discount2 = get_check_input($status_ot_discount2_text,3,ENTRY_DISCOUNT_ERROR2);
	$status_ot_discount_flag2 = get_check_bool_value($status_ot_discount_flag2_text,SELECT_OT_DISCOUNT_ERROR2);
	$graduated_price2 = get_check_bool_value($graduated_price2_text,SELECT_GRADUATED_ERROR2);
	$show_price2 = get_check_bool_value($show_price2_text,SELECT_PRICE_ERROR2);
	$show_tax2 = get_check_bool_value($show_tax2_text,SELECT_TAX_ERROR2);
	if (!$error)
	{
		// admin
		//	W. Kaiser - Allow table-prefix
		$insert_string = INSERT_INTO . TABLE_CUSTOMERS_STATUS . '
		(customers_status_id, language_id, customers_status_name, customers_status_public, customers_status_image,
		customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount,
		customers_status_graduated_prices, customers_status_show_price, customers_status_show_price_tax) VALUES (';
		$insert_trailer = ", 'Admin', 1, 'admin_status.gif', '0.00', '1', '0.00', '1', '1', '1')";

		xtc_db_query($insert_string . "'0', '1'" . $insert_trailer);
		xtc_db_query($insert_string . "'0', '2'" . $insert_trailer);
		$sep=	"', '";
		// status Guest
		$insert_string_trailer =
		", 1, 'guest_status.gif".$sep.
		$status_discount.$sep.
		$status_ot_discount_flag.$sep.
		$status_ot_discount.$sep.
		$graduated_price.$sep.
		$show_price.$sep.
		$show_tax."')";
		xtc_db_query($insert_string . "1, 1, 'Guest'" . $insert_string_trailer);
		xtc_db_query($insert_string . "1, 2, 'Gast'" . $insert_string_trailer);
		// status New customer
		$insert_string_trailer =
		", 1, 'customer_status.gif".$sep.
		$status_discount2.$sep.
		$status_ot_discount_flag2.$sep.
		$status_ot_discount2.$sep.
		$graduated_price2.$sep.
		$show_price2.$sep.
		$show_tax2."')";
		xtc_db_query($insert_string . "2, 1, 'New customer'" . $insert_string_trailer);
		xtc_db_query($insert_string . "2, 2, 'Neuer Kunde'" . $insert_string_trailer);
		ActivateProg($next_step_link);
	}
}
unset($hidden_fields[$status_discount_text]);
unset($hidden_fields[$status_ot_discount_flag_text]);
unset($hidden_fields[$status_ot_discount_text]);
unset($hidden_fields[$graduated_price_text]);
unset($hidden_fields[$show_price_text]);
unset($hidden_fields[$show_tax_text]);
unset($hidden_fields[$status_discount2_text]);
unset($hidden_fields[$status_ot_discount_flag2_text]);
unset($hidden_fields[$status_ot_discount2_text]);
unset($hidden_fields[$graduated_price2_text]);
unset($hidden_fields[$show_price2_text]);
unset($hidden_fields[$show_tax2_text]);
$font='</font>';
$font_size_1='<font size="1">';
$font_size_1_br=$font_size_1.HTML_BR;
$p_start='<p align="left">'.$font_size_1.HTML_B_START;
$p_end=$font.'</p>';
$new_line=HTML_B_END.HTML_BR;
$font_end=BLANK.$font;
$zero_value='0.00';
$headline0='
  <tr>
  	<td colspan="2">
  		<br/>
      <table class="main_content_outer" cellspacing="0" cellpadding="0" align="left">
			  <tr>
			    <td class="header_image"></td>
			    <td class="header">#</td>
			  </tr>
			</table>
		</td>
  </tr>
  <tr>
    <td colspan="2" align="left">
			<br/>@<br/><br/>
		</td>
  </tr>
';
$headline=str_replace(HASH,TITLE_GUEST_CONFIG,$headline0);
$headline=str_replace(ATSIGN,TITLE_GUEST_CONFIG_NOTE,$headline);
$post_data.=$headline.'
  <tr>
    <td>
    '.$p_start.TEXT_STATUS_DISCOUNT.$new_line.
				xtc_draw_input_field_installer($status_discount_text,$zero_value).HTML_BR.TEXT_STATUS_DISCOUNT_LONG.
			$p_end.
      $p_start.TEXT_STATUS_OT_DISCOUNT_FLAG.$new_line.TEXT_ZONE_YES.$font_end.
				xtc_draw_radio_field_installer($status_ot_discount_flag_text, ONE_STRING).
				$font_size_1.TEXT_ZONE_NO.$font_end.
				xtc_draw_radio_field_installer($status_ot_discount_flag_text, ZERO_STRING, TRUE_STRING_S).
				$font_size_1_br.TEXT_STATUS_OT_DISCOUNT_FLAG_LONG.
			$p_end.
			$p_start.TEXT_STATUS_OT_DISCOUNT.$new_line.
				xtc_draw_input_field_installer($status_ot_discount_text,$zero_value).HTML_BR.TEXT_STATUS_OT_DISCOUNT_LONG.
			$p_end.
			$p_start.TEXT_STATUS_GRADUATED_PRICE.$new_line.TEXT_ZONE_YES.$font_end.
				xtc_draw_radio_field_installer($graduated_price_text, ONE_STRING).
				$font_size_1.TEXT_ZONE_NO.$font_end.
				xtc_draw_radio_field_installer($graduated_price_text, ZERO_STRING, TRUE_STRING_S).
				$font_size_1_br.TEXT_STATUS_GRADUATED_PRICE_LONG.
			$p_end.
    	$p_start.TEXT_STATUS_SHOW_PRICE.$new_line.TEXT_ZONE_YES.$font_end.
				xtc_draw_radio_field_installer($show_price_text, ONE_STRING, TRUE_STRING_S).
				$font_size_1.TEXT_ZONE_NO.$font_end.xtc_draw_radio_field_installer($show_price_text, ZERO_STRING).
				$font_size_1_br.TEXT_STATUS_SHOW_PRICE_LONG.
			$p_end.
			$p_start.TEXT_STATUS_SHOW_TAX.$new_line.TEXT_ZONE_YES.$font_end.
				xtc_draw_radio_field_installer($show_tax_text, ONE_STRING, TRUE_STRING_S).
				$font_size_1.TEXT_ZONE_NO.$font_end.xtc_draw_radio_field_installer($show_tax_text, ZERO_STRING).
				$font_size_1_br.TEXT_STATUS_SHOW_TAX_LONG.
			$p_end.'
    </td>
  </tr>
';
$headline=str_replace(HASH,TITLE_CUSTOMERS_CONFIG,$headline0);
$headline=str_replace(ATSIGN,TITLE_CUSTOMERS_CONFIG_NOTE,$headline);
$post_data.=$headline.'
  <tr>
    <td>'.
			$p_start.TEXT_STATUS_DISCOUNT.$new_line.
				xtc_draw_input_field_installer($status_discount2_text,$zero_value).HTML_BR.TEXT_STATUS_DISCOUNT_LONG.
			$p_end.
			$p_start.TEXT_STATUS_OT_DISCOUNT_FLAG.$new_line.TEXT_ZONE_YES.$font_end.
				xtc_draw_radio_field_installer($status_ot_discount_flag2_text, ONE_STRING).
				$font_size_1.TEXT_ZONE_NO.$font_end.
				xtc_draw_radio_field_installer($status_ot_discount_flag2_text, ZERO_STRING, TRUE_STRING_S).
				$font_size_1_br.TEXT_STATUS_OT_DISCOUNT_FLAG_LONG.
			$p_end.
			$p_start.TEXT_STATUS_OT_DISCOUNT.$new_line.
				xtc_draw_input_field_installer($status_ot_discount2_text,$zero_value).HTML_BR.TEXT_STATUS_OT_DISCOUNT_LONG.
			$p_end.
			$p_start.TEXT_STATUS_GRADUATED_PRICE.$new_line.TEXT_ZONE_YES.$font_end.
				xtc_draw_radio_field_installer($graduated_price2_text, ONE_STRING, TRUE_STRING_S).
				$font_size_1.TEXT_ZONE_NO.$font_end.xtc_draw_radio_field_installer($graduated_price2_text, ZERO_STRING).
				$font_size_1_br.TEXT_STATUS_GRADUATED_PRICE_LONG.
			$p_end.
			$p_start.TEXT_STATUS_SHOW_PRICE.$new_line.TEXT_ZONE_YES.$font_end.
				xtc_draw_radio_field_installer($show_price2_text, ONE_STRING, TRUE_STRING_S).
				$font_size_1.TEXT_ZONE_NO.$font_end.xtc_draw_radio_field_installer($show_price2_text, ZERO_STRING).
				$font_size_1_br.TEXT_STATUS_SHOW_PRICE_LONG.
			$p_end.
			$p_start.TEXT_STATUS_SHOW_TAX.$new_line.TEXT_ZONE_YES.$font_end.
				xtc_draw_radio_field_installer($show_tax2_text, ONE_STRING, TRUE_STRING_S).
				$font_size_1.TEXT_ZONE_NO.$font_end.xtc_draw_radio_field_installer($show_tax2_text, ZERO_STRING).
	     	$font_size_1_br.TEXT_STATUS_SHOW_TAX_LONG.
	    $p_end.'
    </td>
  </tr>
';
$include_form_check=true;
include('includes/program_frame.php');

function get_check_bool_value($field_name,$error_message)
{
	global $error,$messageStack,$install_step;

	$field=$_POST[$field_name];
	if (($field != ONE_STRING) && ($field != ZERO_STRING))
	{
		$error = true;
		$messageStack->add($install_step, $error_message);
	}
	else
	{
		return $field;
	}
}
?>
