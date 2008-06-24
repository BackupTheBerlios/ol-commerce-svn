<?php
/* --------------------------------------------------------------
$Id: product_popup_images.php,v 1.1.1.1.2.1 2007/04/08 07:16:38 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, POPUP@seifenparadies.de)
--------------------------------------------------------------
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

if (!$image_path)
{
	$image_path=DIR_FS_CATALOG_ORIGINAL_IMAGES . $products_image_name;
}
$a = new image_manipulation($image_path,PRODUCT_IMAGE_POPUP_WIDTH,PRODUCT_IMAGE_POPUP_HEIGHT,
DIR_FS_CATALOG_POPUP_IMAGES .$products_image_name,IMAGE_QUALITY,EMPTY_STRING);
if (PRODUCT_IMAGE_POPUP_BEVEL)
{
	$array=clear_string(PRODUCT_IMAGE_POPUP_BEVEL);
	$a->bevel($array[0],$array[1],$array[2]);
}

if (PRODUCT_IMAGE_POPUP_GREYSCALE)
{
	$array=clear_string(PRODUCT_IMAGE_POPUP_GREYSCALE);
	$a->greyscale($array[0],$array[1],$array[2]);
}

if (PRODUCT_IMAGE_POPUP_ELLIPSE)
{
	$array=clear_string(PRODUCT_IMAGE_POPUP_ELLIPSE);
	$a->ellipse($array[0]);
}

if (PRODUCT_IMAGE_POPUP_ROUND_EDGES)
{
	$array=clear_string(PRODUCT_IMAGE_POPUP_ROUND_EDGES);
	$a->round_edges($array[0],$array[1],$array[2]);
}

if (PRODUCT_IMAGE_POPUP_MERGE)
{
	$string=str_replace(APOS,EMPTY_STRING,PRODUCT_IMAGE_POPUP_MERGE);
	$string=str_replace(RPAREN,EMPTY_STRING,$string);
	$string=str_replace('(',DIR_FS_CATALOG_IMAGES,$string);
	$array=explode(',',$string);
	$a->merge($array[0],$array[1],$array[2],$array[3],$array[4]);
}

if (PRODUCT_IMAGE_POPUP_FRAME)
{
	$array=clear_string(PRODUCT_IMAGE_POPUP_FRAME);
	$a->frame($array[0],$array[1],$array[2],$array[3]);
}

if (PRODUCT_IMAGE_POPUP_DROP_SHADOW)
{
	$array=clear_string(PRODUCT_IMAGE_POPUP_DROP_SHADOW);
	$a->drop_shadow($array[0],$array[1],$array[2]);
}

if (PRODUCT_IMAGE_POPUP_MOTION_BLUR)
{
	$array=clear_string(PRODUCT_IMAGE_POPUP_MOTION_BLUR);
	$a->motion_blur($array[0],$array[1]);
}
$a->create();
?>