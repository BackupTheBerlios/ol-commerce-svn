<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_draw_input_field.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:22 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com
(c) 2003	    nextcommerce (olc_draw_input_field.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// Output a form input field
//W. Kaiser - AJAX
//function olc_draw_input_field($name, $value = '', $parameters = '', $type = 'text', $reinsert_value = true) {
function olc_draw_input_field($name, $value = '', $parameters = '', $type = 'text', $reinsert_value = true,
$AJAX_validate=false, $AJAX_required=false, $AJAX_caption="", $AJAX_add_span=false)
//W. Kaiser - AJAX
{
	$field = '<input type="' . olc_parse_input_field_data($type, array(QUOTE => '&quot;')) . '" name="' .
	olc_parse_input_field_data($name, array(QUOTE => '&quot;')) . QUOTE;
	/*
	if (false && (isset($GLOBALS[$name])) && ($reinsert_value == true) ) {
		$value=$GLOBALS[$name];
		//$field .= ' class="text" value="' . olc_parse_input_field_data($GLOBALS[$name], array(QUOTE => '&quot;')) . QUOTE;
	} elseif (olc_not_null($value)) {
		//$field .= ' class="text" value="' . olc_parse_input_field_data($value, array(QUOTE => '&quot;')) . QUOTE;
	}
	*/
	$field .= ' class="text" value="' . olc_parse_input_field_data($value, array(QUOTE => '&quot;')) . QUOTE;
	//W. Kaiser - AJAX
	if (AJAX_VALIDATE)
	{
		if (strpos($parameters," id=")===false)
		{
			$parameters .= " id=\"". $name . "\"";
		}
		if ($AJAX_validate)
		{
			$parameters .= " onchange=\"set_validation_required(this);AJAX_validate_element('" . $AJAX_caption .
			"','" . $name . "',". $AJAX_required .")\"";
			//$parameters .= " onkeydown=\"on_key_press();\"";
			//$parameters .= " onchange=\"set_validation_required(this);\"";
			$parameters .= " onfocus=\"clear_validation_required();\"";
		}
	}
	//W. Kaiser - AJAX

	if (olc_not_null($parameters)) $field .= BLANK . $parameters;

	$field .= '/>';

	//W. Kaiser - AJAX
	if (USE_AJAX)
	{
		if ($AJAX_validate)
		{
			if ($AJAX_add_span)
			{
				//If more then 1 valid answer is validated, offer selectionbox for selection of value
				//Allocate span for potential SELECT-box
				$field .= '<span id="'. $name . '_select"></span>';
			}
		}
	}
	//W. Kaiser - AJAX
	return $field;
}
?>