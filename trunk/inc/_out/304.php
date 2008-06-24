<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_draw_pull_down_menu.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:23 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com
(c) 2003	    nextcommerce (olc_draw_pull_down_menu.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// Output a form pull down menu
//W. Kaiser - AJAX
function olc_draw_pull_down_menu($name, $values, $default = '', $parameters = '', $required = false,
$AJAX_validation=false)
{
	$field = '<select name="' . $name . '" id="'. $name . QUOTE;
	if ($AJAX_validation)
	{
		$field .= '" onchange="pull_down_menu_change(this);"';
	}
	//W. Kaiser - AJAX
	if (olc_not_null($parameters)) $field .= BLANK . $parameters;

	$field .= '>';

	if (empty($default) && isset($GLOBALS[$name]))
	{
		$default = $GLOBALS[$name];
	}
	$special=array(QUOTE => '&quot;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;');
	for ($i=0, $n=sizeof($values); $i<$n; $i++)
	{
		$id=$values[$i]['id'];
		$field .= '<option value="' . htmlentities(olc_parse_input_field_data($id, array(QUOTE => '&quot;'))) . QUOTE;
		if ($default == $id)
		{
			$field .= ' selected="selected"';
		}
		//$field .= '>' . htmlentities(olc_parse_input_field_data($values[$i]['text'],$special)) . '</option>';
		$field .= '>' . olc_parse_input_field_data($values[$i]['text'],$special) . '</option>';
	}
	$field .= '</select>';
	//W. Kaiser - AJAX
	if (USE_AJAX)
	{
		$field = "<span id=\"".$name."_select\">".$field."</span>";
	}
	//W. Kaiser - AJAX
	if ($required)
	{
		$field .= TEXT_FIELD_REQUIRED;
	}
	return $field;
}
?>