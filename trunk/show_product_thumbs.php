<?php
/* -----------------------------------------------------------------------------------------
   $Id: show_product_thumbs.php,v 1.1.1.1.2.1 2007/04/08 07:16:19 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(popup_image.php,v 1.12 2001/12/12); www.oscommerce.com 
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Modified by BIA Solutions (www.biasolutions.com) to create a bordered look to the image
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  require('includes/application_top.php');
  require_once(DIR_FS_INC.'olc_get_products_mo_images.inc.php'); 
   
?>

<table align="center">
<tr>
<?
$mo_images = olc_get_products_mo_images((int)$_GET['pID']);
if ((int)$_GET['imgID'] == 0) $actual = ' bgcolor="#FF0000"'; else unset($actual);
echo '<td align="left"'.$actual.'>';
$products_query = olc_db_query("select pd.products_name, p.products_image from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id where p.products_status = '1' and p.products_id = '" . (int)$_GET['pID'] . "' and pd.language_id = '" . SESSION_LANGUAGE_ID . APOS);
$products_values = olc_db_fetch_array($products_query);
echo '<a href="popup_image.php?pID='.(int)$_GET['pID'].'&imgID=0" target="_parent">' . olc_image(DIR_WS_THUMBNAIL_IMAGES . $products_values['products_image'], $products_values['products_name']) . HTML_A_END;
echo '</td>';
foreach ($mo_images as $mo_img){
	if ($mo_img['image_nr'] == (int)$_GET['imgID']) $actual = ' bgcolor="#FF0000"'; else unset($actual);	
	echo '<td align=left'.$actual.'><a href="popup_image.php?pID='.(int)$_GET['pID'].'&imgID='.$mo_img['image_nr'].'" target="_parent">' . olc_image(DIR_WS_THUMBNAIL_IMAGES . $mo_img['image_name'], $products_values['products_name']) . '</a></td>';	
} 
?>
</tr>
</table>