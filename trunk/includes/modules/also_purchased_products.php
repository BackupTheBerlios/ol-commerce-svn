<?php
/* -----------------------------------------------------------------------------------------
$Id: also_purchased_products.php,v 1.1.1.1.2.1 2007/04/08 07:17:59 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(also_purchased_products.php,v 1.21 2003/02/12); www.oscommerce.com
(c) 2003	    nextcommerce (also_purchased_products.php,v 1.9 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//W. Kaiser - AJAX

// include needed files
require_once(DIR_FS_INC.'olc_rand.inc.php');

$products_id_main=(int)$_GET['products_id'];
if (isset($products_id_main))
{
	//W. Kaiser - Baseprice
	$sql_select="select distinct
		p.products_fsk18,
		p.products_id,
		p.products_model,
		p.products_image,
	  p.products_date_added,
	  p.products_date_available,
		p.products_shippingtime,
	  p.products_uvp,
	  p.products_vpe,
	  p.products_vpe_status,
	  p.products_vpe_value,
		p.products_min_order_quantity,
		p.products_min_order_vpe,
	  p.products_baseprice_show,
	  p.products_baseprice_value
		from ";
	$sql_where="
		where p.products_status=1
		and p.products_price >= 0
		#group_fsk18#
		";
	unset($module_smarty);
	$products_listing_template=EMPTY_STRING;
	$smarty_config_section="also_purchased";
	$products_listing_simple=true;
	$products_use_random_data=false;
	$heading_text=EMPTY_STRING;

	$total_also_purchased=olc_rand(5,8);		//Nr. of products to display
	for ($loop=0;$loop<=1;$loop++)
	{
		$loop0=$loop==0;
		if ($loop0)
		{
			$Entries=MAX_DISPLAY_ALSO_PURCHASED;
			$products_listing_sql=$sql_select.
				TABLE_ORDERS_PRODUCTS . " opa, " .
				TABLE_ORDERS_PRODUCTS . " opb, " .
				TABLE_ORDERS . " o, " . TABLE_PRODUCTS . " p".
				$sql_where."
				and opa.products_id = '" . $products_id_main . "'
				and opb.products_id != '" . $products_id_main . "'
				and opa.orders_id = opb.orders_id
				and opb.products_id = p.products_id
				and opb.orders_id = o.orders_id
				group by p.products_id order by o.date_purchased desc limit " . MAX_DISPLAY_ALSO_PURCHASED;
		}
		else
		{
			$Entries="100000";
			$products_listing_sql=$sql_select .
				TABLE_PRODUCTS . " p, " .
				TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " .
				TABLE_CATEGORIES . " c".
				$sql_where."
				and p.products_id = p2c.products_id
				and p.products_id !='".$products_id_main."'
				and c.categories_id = p2c.categories_id
				and c.categories_status=1 order by
				p.products_date_added asc limit " . $Entries;
		}
		//W. Kaiser - Baseprice
		include(DIR_FS_INC.'olc_prepare_products_listing_info.inc.php');
		if ($loop0)
		{
			$random_records=max($total_also_purchased-$my_products_listing_entries,0);
			if ($random_records==0)
			{
				break;
			}
		}
	}
	if ($products_listing_entries)
	{
		$module_smarty->assign(MODULE_CONTENT,$module_content);
		$module= $module_smarty->fetch($products_listing_template,SMARTY_CACHE_ID);
		$info_smarty->assign('MODULE_'.$smarty_config_section,$module);
	}
}
$smarty_config_section=EMPTY_STRING;
// W. Kaiser - AJAX
?>