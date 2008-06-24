<?php
/* -----------------------------------------------------------------------------------------
$Id: products_promotion.php,v 1.1.1.1 2006/12/22 13:43:03 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
All rights reserved!

N o t (!) released under the GNU General Public License
---------------------------------------------------------------------------------------*/

$products_promotion_image_text='products_promotion_image';
$products_promotion_desc_text='products_promotion_desc';
if ($products_id)
{
	$promotion_sql="
SELECT
products_promotion_title,
products_promotion_image,
products_promotion_desc
FROM " .
TABLE_PRODUCTS_DESCRIPTION . "
WHERE
products_id = " . $products_id . " AND
language_id = " . $lang_id;
	$promotion_query = olc_db_query($promotion_sql);
	$promotion = olc_db_fetch_array($promotion_query);
	while (list($key,$value)=each($promotion))
	{
		$value=stripslashes($value);
		$value=str_replace('\\',EMPTY_STRING,$value);
		$promotion[$key]=$value;
	}
}
else
{
	$promotion = array();
}
$title =
olc_draw_input_field('products_promotion_title[' . $lang_id . ']',
$promotion['products_promotion_title'],' size="150"').HTML_BR;
$products_promotion_image=$promotion[$products_promotion_image_text];
$products_promotion_image_text.=$i;
if ($products_promotion_image)
{
	$image= olc_image(ADMIN_PATH_PREFIX.DIR_WS_PROMOTION_IMAGES. $products_promotion_image). NEW_LINE .
	olc_draw_hidden_field($products_promotion_image_text, $products_promotion_image). HTML_BR.
	olc_draw_checkbox_field('del_'.$products_promotion_image_text).BLANK. PROMOTION_DELETE .HTML_BR.HTML_BR;
}
else
{
	$image=EMPTY_STRING;
}
$image .= olc_draw_file_field($products_promotion_image_text).HTML_BR;

$s=$products_promotion_desc_text.UNDERSCORE.$lang_id;
$content=$promotion['products_promotion_desc'];
if ($use_spaw)
{
	ob_start();
	$sw = new SPAW_Wysiwyg(
	$control_name=$s , 					// control's name
	$value= $content,           // initial value
	$lang=EMPTY_STRING,         // language
	$mode = 'full',             // toolbar mode
	$theme='default',           // theme (skin)
	$width='600px',              // width
	$height='400px',            // height
	$css_stylesheet=SPAW_STYLESHEET,         // css stylesheet file for content
	$dropdown_data=EMPTY_STRING           // data for dropdowns (style, font, etc.)
	);
	$sw->show();
	$editor=ob_get_contents();
	ob_end_clean();
}
else
{
	$editor=olc_draw_textarea_field($s,'soft', '70', '15', $content);
}
$description = $editor. HTML_BR;
$lang_image .= HTML_B_START;
echo '
	<br /><span class="pageHeading">'.PROMOTION_HEADER.'</span>
	<table width="100%" cellpadding="3" cellspacing="0" border="0">
	  <tr>
	    <td valign="top" colspan="2">
				<table width="100%" cellpadding="0" cellspacing="1" border="0">
				  <tr>
				    <td class="main">'.
olc_draw_checkbox_field("products_promotion_status",
ONE_STRING, $pInfo->products_promotion_status==ONE_STRING).
HTML_NBSP.HTML_B_START.PROMOTION_ON.HTML_B_END.'
				    </td>
				  </tr>
				  <tr>
				    <td class="main">'.
olc_draw_checkbox_field("products_promotion_show_title",
ONE_STRING,$pInfo->products_promotion_show_title==ONE_STRING).
HTML_NBSP.HTML_B_START.PROMOTION_PRODUCT_TITLE.HTML_B_END.'
					   </td>
				  </tr>
				  <tr>
				    <td class="main">'.
olc_draw_checkbox_field("products_promotion_show_desc", ONE_STRING,
$pInfo->products_promotion_show_desc==ONE_STRING).
HTML_NBSP.HTML_B_START.PROMOTION_PRODUCT_DESCRIPTION.HTML_B_END.'
					   </td>
				  </tr>
				</table>
				<br/>
				<table cellpadding="2" cellspacing="1" border="0" style="padding-top: 5px;">
				  <tr>
				    <td class="main">'.$lang_image.PROMOTION_TITLE.HTML_B_END.'</td>
				  </tr>
				  <tr>
				    <td class="main">'.$title.'</td>
				  </tr>
				  <tr>
				    <td class="main">'.$lang_image.PROMOTION_IMAGE.HTML_B_END.'</td>
				  </tr>
				  <tr>
				    <td class="main">'.$image.'</td>
				  </tr>
				  <tr>
				    <td class="main">'.$lang_image.PROMOTION_DESCRIPTION.HTML_B_END.'</td>
				  </tr>
				  <tr>
				    <td class="main">'.$description.'</td>
				  </tr>
				</table>
	    </td>
	  </tr>
	</table>
';
?>