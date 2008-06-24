<?php
/* -----------------------------------------------------------------------------------------
$Id: popup_image.php,v 1.1.1.1.2.1 2007/04/08 07:16:18 gswkaiser Exp $

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

$pID= $_GET['pID'] ;
$products_query_where="
	where p.products_status = '1'
	and p.products_id = pd.products_id
	and p.products_id = '" .  $pID . "'
	and pd.language_id = '" . SESSION_LANGUAGE_ID . APOS;
$products_query_from = " from " . TABLE_PRODUCTS . " p , " . TABLE_PRODUCTS_DESCRIPTION . " pd";
$products_query_sql0="select pd.products_name, p.products_image";
$products_query_sql=$products_query_sql0 . $products_query_from. $products_query_where;
$imgID=$_GET['imgID'];
if ($imgID == 0)
{
	$products_query = olc_db_query($products_query_sql);
	$products_values = olc_db_fetch_array($products_query);
}
else
{
	$sql=$products_query_sql0.", pi.image_name" . $products_query_from . ", " . TABLE_PRODUCTS_IMAGES . " pi, " .
	$products_query_where . " and pi.image_nr = '" . $imgID;
	$products_query = olc_db_query($sql);
	if (olc_db_numrows($products_query)>0)
	{
		$products_values = olc_db_fetch_array($products_query);
		$products_values['products_image'] = $products_values['image_name'];
	}
	else
	{
		//Fall back if no multi-image data
		$products_query = olc_db_query($products_query_sql);
		$products_values = olc_db_fetch_array($products_query);
	}
}
// get x and y of the image
$products_image=$products_values['products_image'];
$img = DIR_WS_POPUP_IMAGES.$products_image;
$osize = GetImageSize($img);
$obwidth = $osize[0];
$oheight = $osize[1];
$bwidth = obwidth ;
$bheight = $oheight;

//get data for mo_images
$mo_images = olc_get_products_mo_images($pID);
if (isset($mo_images))
{
	foreach ($mo_images as $mo_img)
	{
		$img = DIR_WS_POPUP_IMAGES.$mo_img['image_name'];
		$mo_size = GetImageSize($img);
		if ($mo_size[0] > $bwidth)
		{
			$bwidth  = $mo_size[0];
		}
		if ($mo_size[1] > $bheight)
		{
			$bheight = $mo_size[1];
		}
	}
	$bheight += 50;
}
include(DIR_WS_INCLUDES.'header.php');
$products_name= $products_values['products_name'];
if (IS_IE)
{
	$i=0;
}
else
{
	$i=40;
}
//	var height='.($oheight + $bheight+125-$i).';
$text='
	var width='.($obwidth + 105).';
	var height='.($oheight + 125-$i).';
';
?>
<script language="javascript" type="text/javascript"><!--
function resize()
{
<?php echo $text;?>
	window.resizeTo(width, height);
	window.moveTo((screen.width-width)/2,(screen.height-height)/2);
	self.focus();
}
//--></script>
</head>
<body onload="resize();" >


<!-- big image -->
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr>
<td ><div align="center"><font size="2"><strong><?php echo $products_name; ?></strong></font></div></td>
</tr>
<tr>
<td>
<table border=0 align="center" cellpadding=5 cellspacing=0>
<tr>
<td align=center><?  echo olc_image(DIR_WS_POPUP_IMAGES . $products_image, $products_name, $obwidth, $oheight); ?></td>
</tr>
</table>
</table>

<!-- thumbs -->
<center>
<?
if (isset($mo_images))
{
	$link=olc_href_link('show_product_thumbs.php','pID='.$pID.'&imgID='.$imgID);
?>
	<iframe src="<? echo $link; ?>" width="<? echo $obwidth +40 ?>" height="<? echo $bheight+5; ?>" border="0" frameborder="0">
	<a href="<? echo $link; ?>">Weitere Bilder</a>
	</iframe><br/>
	<?
}
?>
<a href="#" onclick='javascript:window.close();'><?php echo TEXT_CLOSE_WINDOW ?></a>
</body>
</html>