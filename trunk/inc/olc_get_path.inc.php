<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_path.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:31 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_get_path.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_get_path($current_category_id = EMPTY_STRING)
{
	global $cPath_array;

	if (olc_not_null($current_category_id))
	{
		$cp_size = sizeof($cPath_array);
		if ($cp_size == 0)
		{
			$cPath_new = $current_category_id;
		}
		else
		{
			$cPath_new = EMPTY_STRING;
			$sql0="select parent_id from " . TABLE_CATEGORIES . " where categories_id = '#'" ;
			$sql=str_replace(HASH,$cPath_array[($cp_size-1)],$sql0);
			$last_category_query = olc_db_query($sql);
			$last_category = olc_db_fetch_array($last_category_query);

			$sql=str_replace(HASH,$current_category_id,$sql0);
			$current_category_query = olc_db_query($sql);
			$current_category = olc_db_fetch_array($current_category_query);

			if ($last_category['parent_id'] == $current_category['parent_id'])
			{
				for ($i=0,$n=($cp_size-1); $i<$n; $i++)
				{
					$cPath_new .= UNDERSCORE . $cPath_array[$i];
				}
			}
			else
			{
				for ($i=0; $i<$cp_size; $i++)
				{
					$cPath_new .= UNDERSCORE . $cPath_array[$i];
				}
			}
			$cPath_new .= UNDERSCORE . $current_category_id;

			if (substr($cPath_new, 0, 1) == UNDERSCORE)
			{
				$cPath_new = substr($cPath_new, 1);
			}
		}
	}
	else
	{
		$cPath_new = implode(UNDERSCORE, $cPath_array);
	}
	return 'cPath=' . $cPath_new;
}
?>