<?php
/* --------------------------------------------------------------
$Id: products_images.php,v 1.1.1.1.2.1 2007/04/08 07:16:46 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
based on
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

//include needed functions
require_once(DIR_FS_INC.'olc_get_products_mo_images.inc.php');

// show images
if ($_GET['action']=='new_product')
{
	// display images fields:
	echo '<tr><td colspan="4">'. olc_draw_separator('pixel_trans.gif', '1', '10').'</td></tr>';
	if ($pInfo->products_image)
	{
		echo '<tr><td colspan="4"><table><tr><td align="center" class="main" width="'.(PRODUCT_IMAGE_THUMBNAIL_WIDTH+15).'">' .
		olc_image(DIR_WS_CATALOG_THUMBNAIL_IMAGES.$pInfo->products_image, 'Standard Image') . '</td>';
	}
	$products_previous_image='products_previous_image_';
	echo '<td class="main">'.TEXT_PRODUCTS_IMAGE.HTML_BR.olc_draw_file_field('products_image') . HTML_BR .
	olc_draw_separator('pixel_trans.gif', '24', '15') . HTML_NBSP . $pInfo->products_image .
	olc_draw_hidden_field($products_previous_image.'0', $pInfo->products_image);
	if ($pInfo->products_image){ echo '</td></tr></table>'; } else { echo '</td></tr>';}

	// display MO PICS
	if (MO_PICS > 0)
	{
		$mo_images = olc_get_products_mo_images($pInfo->products_id);
		for ($i=0;$i<MO_PICS;$i++)
		{
			echo '<tr><td colspan="4">'. olc_draw_separator('pixel_black.gif', '100%', '1').'</td></tr>';
			echo '<tr><td colspan="4">'. olc_draw_separator('pixel_trans.gif', '1', '10').'</td></tr>';
			$image_name=$mo_images[$i]["image_name"];
			$i1=$i+1;
			if ($image_name)
			{
				echo '<tr><td colspan="4"><table><tr><td align="center" class="main" width="'.
				(PRODUCT_IMAGE_THUMBNAIL_WIDTH+15).'">' . olc_image(DIR_WS_CATALOG_THUMBNAIL_IMAGES.$image_name,
				'Image '.$i1) .'</td>';
			}
			else
			{
				echo '<tr>';
			}
			echo '<td class="main">'.TEXT_PRODUCTS_IMAGE.BLANK.$i1.HTML_BR.olc_draw_file_field('mo_pics_'.$i) . HTML_BR .
			olc_draw_separator('pixel_trans.gif', '24', '15') . HTML_NBSP . $image_name .
			olc_draw_hidden_field($products_previous_image.$i1, $image_name);
			if ($image_name)
			{
				echo '</tr><tr><td align="center" valign="middle">' .
				olc_draw_selection_field('del_mo_pic[]', 'checkbox', $image_name) .BLANK. TEXT_DELETE .
				'</td></tr></table>';
			}
			else
			{
				echo '</td></tr>';
			}
		}
	}
}
?>