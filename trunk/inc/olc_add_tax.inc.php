<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_add_tax.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:09 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2003	    nextcommerce (olc_add_tax.inc.php,v 1.4 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_add_tax($price, $tax)
{
	$price=$price+$price/100*$tax;
	return $price;
}
 ?>