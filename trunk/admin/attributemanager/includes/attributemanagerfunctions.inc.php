<?php
/*
  $Id: attributemanagerfunctions.inc.php,v 1.1.1.1 2006/12/22 13:37:21 gswkaiser Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License

  Web Development
  http://www.kangaroopartners.com
*/

function drawDropDownPrefix($name,$params,$selected = '') {
	return olc_draw_pull_down_menu(
		$name,
		array(
			array('id'=>'','text'=>''),
			array('id'=>urlencode('+'),'text'=>'+'),
			array('id'=>'-','text'=>'-')
		),
		($selected == '+') ? urlencode('+') : $selected,
		$params,
		false,
		false
	);
}
?>