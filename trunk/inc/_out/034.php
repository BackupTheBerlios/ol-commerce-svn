<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_check_categories_status.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:10 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_check_categories_status($categories_id)
{
	if ($categories_id)
	{
		$categorie_query=olc_db_query("
		SELECT
		parent_id,
		categories_status
		FROM ".TABLE_CATEGORIES."
		WHERE
		categories_id = ".$categories_id);
		$categorie_data=olc_db_fetch_array($categorie_query);
		if ($categorie_data['categories_status']==0)
		{
			$return=true;
		}
		else
		{
			$parent_id=$categorie_data['parent_id'];
			if ($parent_id)
			{
				$return=olc_check_categories_status($parent_id)>=1;
			}
			else
			{
				$return=false;
			}
		}
		return $return;
	}
}

function olc_get_categoriesstatus_for_product($product_id)
{
	$categorie_query=olc_db_query("
	SELECT
	categories_id
	FROM ".TABLE_PRODUCTS_TO_CATEGORIES."
	WHERE products_id=".$product_id);
	while ($categorie_data=olc_db_fetch_array($categorie_query))
	{
		return olc_check_categories_status($categorie_data['categories_id'])>=1;
	}
}
?>