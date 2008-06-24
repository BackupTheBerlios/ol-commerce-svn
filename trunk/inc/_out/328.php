<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_attributes_model.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:29 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2003	    nextcommerce (olc_get_attributes_model.inc.php,v 1.1 2003/08/19); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_get_attributes_model($product_id, $attribute_name)
{

	$options_value_id_query=olc_db_query("SELECT
                products_options_values_id
                FROM ".TABLE_PRODUCTS_OPTIONS_VALUES."
                WHERE products_options_values_name='".$attribute_name.APOS);
	while ($options_value_id_data=olc_db_fetch_array($options_value_id_query))
	{
		$options_attr_query=olc_db_query("SELECT
                attributes_model
                FROM ".TABLE_PRODUCTS_ATTRIBUTES."
                WHERE options_values_id='".
								$options_value_id_data['products_options_values_id']."' AND products_id =" . $product_id);
		$options_attr_data=olc_db_fetch_array($options_attr_query);
		if ($options_attr_data['attributes_model']!='')
		{
			return $options_attr_data['attributes_model'];
		}
	}
}
?>