<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_image_submit.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:36 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com
(c) 2003	    nextcommerce (olc_src_submit.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// The HTML form submit button wrapper function
// Outputs a button in the selected language
function olc_image_submit($src, $alt = '', $parameters = '', $Ajax_reset_cart_data_dirty=false)
{
	$rep=array(QUOTE => '&quot;');
	$src=olc_parse_input_field_data($src, $rep);
	if (IS_ADMIN_FUNCTION)
	{
		$src=CURRENT_TEMPLATE_ADMIN_BUTTONS.$src;
	}
	else
	{
		$src=CURRENT_TEMPLATE_BUTTONS.$src;
	}
	/*
	if (IS_MULTI_SHOP)
	{
		$src=olc_set_multi_shop_dir_info($src);
	}
	*/
	$src = '<input type="image" class="image" src="'.$src.'"  style="border:0px"';
	if (olc_not_null($alt))
	{
		$alt=olc_parse_input_field_data($alt, $rep);
		$src .= ' title="' . $alt . QUOTE;
	}
	$src .= ' alt="'.$alt.QUOTE;
	//W. Kaiser - AJAX
	if ($Ajax_reset_cart_data_dirty)
	{
		//Reset "cart_data_dirty"-flag, if form is submitted
		$parameters.=' onclick="javascript:sticky_cart_data_dirty=false;"';
	}
	if (olc_not_null($parameters))
	{
		$src .= BLANK . $parameters;
	}
	$src .= '/>';
	return $src;
}
?>