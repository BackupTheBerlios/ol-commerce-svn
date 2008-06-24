<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_slideshows.inc.php,v 1.1.1.1 2006/12/22 13:41:52 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(product_listing.php,v 1.42 2003/05/27); www.oscommerce.com
(c) 2003	    nextcommerce (product_listing.php,v 1.19 2003/08/1); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//if (false && NOT_IS_AJAX_PROCESSING)
$slideshow_text='SLIDESHOW';
$slideshow=false;
if (false && USE_AJAX && IS_LOCAL_HOST)
{
	if (NOT_IS_AJAX_PROCESSING)
	{
		//Slideshow only on first page!!!
		$slideshow_products_text=$slideshow_text.UNDERSCORE.'PRODUCTS';
		if (!defined($slideshow_products_text))
		{
			define($slideshow_products_text,FALSE_STRING_S);
		}
		$slideshow_images_text=$slideshow_text.UNDERSCORE.'IMAGES';
		if (!defined($slideshow_images_text))
		{
			define($slideshow_images_text,FALSE_STRING_S);
		}
		$slideshow_products=SLIDESHOW_PRODUCTS==TRUE_STRING_S;
		$slideshow_images=SLIDESHOW_IMAGES==TRUE_STRING_S;
		$slideshow=$slideshow_products || $slideshow_images;
		if ($slideshow)
		{
			$slideshow_id=array($slideshow_products,$slideshow_images);
			$slideshow_images_text=$slideshow_text.UNDERSCORE.'INTERVAL';
			if (!defined($slideshow_images_text))
			{
				define($slideshow_images_text,5);
			}
		}
	}
}
define($slideshow_text,$slideshow);
?>