<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_recalculate_price.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:39 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
by Mario Zanier for XTcommerce

based on:
(c) 2003	    nextcommerce (olc_recalculate_price.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_recalculate_price($price, $discount)
{
	$price=-100*$price/($discount-100)/100*$discount;
	return $price;
}
?>