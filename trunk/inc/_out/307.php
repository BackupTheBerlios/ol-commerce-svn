<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_draw_selection_field.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:23 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com
(c) 2003	    nextcommerce (olc_draw_selection_field.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// Output a selection field - alias function for olc_draw_checkbox_field() and olc_draw_radio_field()

function olc_draw_selection_field($name, $type, $value = '', $checked = false, $parameters = '')
{
	$name=$name='"'.olc_parse_input_field_data($name, array(QUOTE => '&quot;')) . '"';
	$selection = '<input type="' . olc_parse_input_field_data($type, array(QUOTE => '&quot;')) . '" name=' . $name;
	$id_text="id=";
	if (strpos($parameters,$id_text)===false)
	{
		$selection .= BLANK . $id_text . $name;
	}
	if (olc_not_null($value)) $selection .= ' value="' .
		olc_parse_input_field_data($value, array(QUOTE => '&quot;')) . '"';
	if (($checked == true) || ($GLOBALS[$name] == 'on') || ($value && ($GLOBALS[$name] == $value)))
	{
		$selection .= ' checked="checked"';
	}
	if (olc_not_null($parameters)) $selection .= BLANK . $parameters;
	$selection .= '/>';
	return $selection;
}
?>