<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_track_code.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:35 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(banner.php,v 1.10 2003/02/11); www.oscommerce.com
(c) 2003	    nextcommerce (olc_banner_exists.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_get_track_code($order,$track_code)
{
	$shipping_class=$order->info['shipping_class'];
	if ($shipping_class)
	{
		if (!class_exists('shipping'))
		{
			// load all enabled shipping modules
			require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES . 'shipping.php');
			$shipping_module = new shipping(array('id' => $shipping_class.UNDERSCORE.$shipping_class));
		}
		$shipping_module=$GLOBALS[$shipping_class];
		if (method_exists($shipping_module, 'get_track_url'))
		{
			$TrackURL=$shipping_module->get_track_url();
			if ($TrackURL)
			{
				$TrackURL=str_replace('#track_code#',$track_code,$TrackURL);
				$TrackURL=str_replace('#post_code#',$order->customer['postcode'],$TrackURL);
				return $TrackURL;
			}
		}
	}
}
?>