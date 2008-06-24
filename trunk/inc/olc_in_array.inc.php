<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_in_array.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:36 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.3 2002/08/16); www.oscommerce.com
(c) 2003	    nextcommerce (olc_in_array.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_in_array($value, $array) {
	if (is_array($array))
	{
		if (is_array($value))
		{
			for ($i=0; $i<sizeof($value); $i++)
			{
				if (in_array($value[$i], $array))
				{
					return true;
				}
			}
			return false;
		}
		else
		{
			return in_array($value, $array);
		}
	}
	else
	{
		return false;
	}
}
?>