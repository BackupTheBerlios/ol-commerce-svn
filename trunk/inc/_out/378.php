<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_uprid.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:35 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_get_uprid.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// Return a product id with attributes

function olc_get_uprid($prid, $params)
{
	if (is_numeric($prid))
	{
		$uprid = $prid;
		if (is_array($params) && (sizeof($params) > 0))
		{
			$attributes_check = true;
			$attributes_ids = '';
			reset($params);
			while (list($option, $value) = each($params))
			{
				if (is_numeric($option) && is_numeric($value))
				{
					$attributes_ids .= '{' . (int)$option . '}' . (int)$value;
				}
				else
				{
					$attributes_check = false;
					break;
				}
			}
			if ($attributes_check == true)
			{
				$uprid .= $attributes_ids;
			}
		}
	}
	else
	{
		$uprid = olc_get_prid($prid);
		if (is_numeric($uprid))
		{
			if (strpos($prid, '{') !== false)
			{
				$attributes_check = true;
				$attributes_ids = '';
				$attributes = explode('{', substr($prid, strpos($prid, '{')+1));
				for ($i=0, $n=sizeof($attributes); $i<$n; $i++)
				{
					$pair = explode('}', $attributes[$i]);
					if (is_numeric($pair[0]) && is_numeric($pair[1]))
					{
						$attributes_ids .= '{' . (int)$pair[0] . '}' . (int)$pair[1];
					}
					else
					{
						$attributes_check = false;
						break;
					}
				}
				if ($attributes_check == true)
				{
					$uprid .= $attributes_ids;
				}
			}
		}
		else
		{
			return false;
		}
	}
	return $uprid;
}
 ?>