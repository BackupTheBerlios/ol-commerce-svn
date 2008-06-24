<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_standard_products_query.inc.php,v 1.1.1.1 2006/12/22 13:41:30 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_break_string.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

define('PRODUCTS_FIELDS','
p.group_ids,
p.manufacturers_id,
p.options_template,
p.product_template,
p.products_baseprice_show,
p.products_baseprice_value,
p.products_date_added,
p.products_date_available,
p.products_discount_allowed,
p.products_ean,
p.products_fsk18,
p.products_id,
p.products_image,
p.products_image_large,
p.products_image_medium,
p.products_last_modified,
p.products_min_order_quantity,
p.products_min_order_vpe,
p.products_model,
p.products_ordered,
p.products_price,
p.products_promotion_show_desc,
p.products_promotion_show_title,
p.products_promotion_status,
p.products_quantity,
p.products_shippingtime,
p.products_sort,
p.products_status,
p.products_tax_class_id,
p.products_uvp,
p.products_vpe,
p.products_vpe_status,
p.products_vpe_value,
p.products_weight,
pd.language_id,
pd.products_name,
pd.products_description,
pd.products_short_description,
pd.products_meta_title,
pd.products_meta_description,
pd.products_meta_keywords,
pd.products_url,
pd.products_viewed,
pd.products_promotion_desc,
pd.products_promotion_title,
pd.products_promotion_image
');

function olc_standard_products_query($new_products_category_id,$get_product=false)
{
	if (NOT_IS_ADMIN_FUNCTION)
	{
		if (DO_GROUP_CHECK)
		{
			$group_check=" and p.".SQL_GROUP_CONDITION;
		}
		if (CUSTOMER_NOT_IS_FSK18)
		{
			$group_check.=" and p.products_fsk18 != 1";
		}
		$products_status="p.products_status='1' and ";
		$categories_status=" and c.categories_status = 1";
	}
	else
	{
		$group_check=EMPTY_STRING;
		$products_status=EMPTY_STRING;
		$categories_status=EMPTY_STRING;
	}
	$use_cat=$new_products_category_id<>EMPTY_STRING;
	$prodcuts_sql_standard=SELECT.
	PRODUCTS_FIELDS.
	SQL_FROM.
	TABLE_PRODUCTS . " p, " .
	TABLE_PRODUCTS_DESCRIPTION . " pd";
	if ($use_cat)
	{
		$prodcuts_sql_standard.=COMMA_BLANK.
		TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " .
		TABLE_CATEGORIES . " c ";
	}
	$prodcuts_sql_standard.=SQL_WHERE.
$products_status."
pd.products_id=p.products_id and
pd.language_id=".SESSION_LANGUAGE_ID.
	$group_check;
	if ($use_cat)
	{
		$prodcuts_sql_standard.="
and p2c.products_id = p.products_id
and c.categories_id = p2c.categories_id".
$categories_status;
		if ($get_product)
		{
			$prodcuts_sql_standard.="
and p2c.categories_id=".$new_products_category_id;
		}
		else
		{
			$prodcuts_sql_standard.="
and p2c.categories_id=c.categories_id
and c.parent_id=".$new_products_category_id;
		}
	}
	return $prodcuts_sql_standard;
}
?>