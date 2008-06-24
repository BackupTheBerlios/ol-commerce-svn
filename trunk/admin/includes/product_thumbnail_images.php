<?php
/* --------------------------------------------------------------
$Id: product_thumbnail_images.php,v 1.1.1.1.2.1 2007/04/08 07:16:38 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, THUMBNAIL@seifenparadies.de)
--------------------------------------------------------------
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

if (!$image_path)
{
	$image_path=DIR_FS_CATALOG_ORIGINAL_IMAGES . $products_image_name;
}
$a = new image_manipulation($image_path,PRODUCT_IMAGE_THUMBNAIL_WIDTH,PRODUCT_IMAGE_THUMBNAIL_HEIGHT,
DIR_FS_CATALOG_THUMBNAIL_IMAGES .$products_image_name,IMAGE_QUALITY,EMPTY_STRING);
if (PRODUCT_IMAGE_THUMBNAIL_BEVEL)
{
	$array=clear_string(PRODUCT_IMAGE_THUMBNAIL_BEVEL);
	$a->bevel($array[0],$array[1],$array[2]);
}

if (PRODUCT_IMAGE_THUMBNAIL_GREYSCALE)
{
	$array=clear_string(PRODUCT_IMAGE_THUMBNAIL_GREYSCALE);
	$a->greyscale($array[0],$array[1],$array[2]);
}

if (PRODUCT_IMAGE_THUMBNAIL_ELLIPSE)
{
	$array=clear_string(PRODUCT_IMAGE_THUMBNAIL_ELLIPSE);
	$a->ellipse($array[0]);
}

if (PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES)
{
	$array=clear_string(PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES);
	$a->round_edges($array[0],$array[1],$array[2]);
}

if (PRODUCT_IMAGE_THUMBNAIL_MERGE)
{
	$string=str_replace(APOS,EMPTY_STRING,PRODUCT_IMAGE_THUMBNAIL_MERGE);
	$string=str_replace(RPAREN,EMPTY_STRING,$string);
	$string=str_replace('(',DIR_FS_CATALOG_IMAGES,$string);
	$array=explode(COMMA,$string);
	$a->merge($array[0],$array[1],$array[2],$array[3],$array[4]);
}

$array=clear_string(PRODUCT_IMAGE_THUMBNAIL_FRAME);
if (PRODUCT_IMAGE_THUMBNAIL_FRAME)
{
	$a->frame($array[0],$array[1],$array[2],$array[3]);
}

if (PRODUCT_IMAGE_THUMBNAIL_DROP_SHADOW)
{
	$array=clear_string(PRODUCT_IMAGE_THUMBNAIL_DROP_SHADOW);
	$a->drop_shadow($array[0],$array[1],$array[2]);
}

if (PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR)
{
	$array=clear_string(PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR);
	$a->motion_blur($array[0],$array[1]);
}
$a->create();
?>
