<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_random_select.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:39 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_random_select.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
//W. Kaiser - AJAX
function olc_random_select($query,$rows=1) {
	global $random_rows;

	$random_product = '';
	$random_query = olc_db_query($query);
	$num_rows = olc_db_num_rows($random_query);
	if ($num_rows > 1)
	{
		$num_rows1=$num_rows - 1;
		for ($row=1;$row<=$rows;$row++)
		{
			$tries=0;
			$random_row = olc_rand(0, $num_rows1);
			$random_row_store = "|".$random_row."|";
			$include_row=true;
			while (!(strpos($random_rows,$random_row_store )===false))
			{
				$tries++;
				if ($tries>10)
				{
					$include_row=false;
					break;
				}
				else
				{
					$random_row = olc_rand(0, $num_rows1);
				}
			}
			if ($include_row)
			{
				$random_rows.=$random_row_store;
				olc_db_data_seek($random_query, $random_row);
				$random_product[] = olc_db_fetch_array($random_query);
			}
		}
	}
	else if ($num_rows > 0)
	{
		$random_product[] = olc_db_fetch_array($random_query);
	}
	return $random_product;
}
//W. Kaiser - AJAX
?>