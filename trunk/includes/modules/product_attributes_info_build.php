<?php
/* -----------------------------------------------------------------------------------------
$Id: product_attributes_info_build.php,v 1.1.1.1.2.1 2007/04/08 07:17:59 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(product_info.php,v 1.94 2003/05/04); www.oscommerce.com
(c) 2003      nextcommerce (product_info.php,v 1.46 2003/08/25); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contribution:
Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ |
CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist
New Attribute Manager v4b                            Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
Cross-Sell (X-Sell) Admin 1                          Autor: Joshua Dechant (dreamscape)
Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//W. Kaiser - AJAX

$products_id=(int)$_GET['products_id'];
$currency=SESSION_CURRENCY; // $_SESSION['currency'];

$sql_from=
	SQL_FROM . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib
	where
	patrib.products_id=" . (int)$_GET['products_id'] .	"
	and patrib.options_id = popt.products_options_id
	and popt.language_id = " . SESSION_LANGUAGE_ID;
$products_attributes_query = olc_db_query(SELECT_COUNT."as total".$sql_from);
$products_attributes = olc_db_fetch_array($products_attributes_query);
if ($products_attributes['total'] > 0)
{
	$DATA_text='DATA';
	$ID_text='ID';
	$MODEL_text='MODEL';
	$NAME_text='NAME';
	$PREFIX_text='PREFIX';
	$PRICE_text='PRICE';
	$TEXT_text='TEXT';
	$attributes_model_text='attributes_model';
	$id_text='id';
	$options_values_price_text='options_values_price';
	$price_prefix_text='price_prefix';
	$products_options_id_text='products_options_id';
	$products_options_name_text='products_options_name';
	$products_options_values_id_text='products_options_values_id';
	$products_options_values_name_text='products_options_values_name';
	$text_text='text';
	$products_options_name_query = olc_db_query(SELECT."popt.products_options_id, popt.products_options_name".
		$sql_from." order by popt.products_options_name");
	$products_options_sql0=
		SELECT."
		pov.products_options_values_id,
		pov.products_options_values_name,
		pa.attributes_model,
		pa.options_values_price,
		pa.price_prefix,
		pa.attributes_stock,
		pa.attributes_model
		from " . TABLE_PRODUCTS_ATTRIBUTES . " pa,
		" . TABLE_PRODUCTS_OPTIONS_VALUES . " pov
		where
		pa.products_id = '#'
		and pa.options_id = '@'
		and pa.options_values_id = pov.products_options_values_id
		and pov.language_id = '" . SESSION_LANGUAGE_ID . "'
		order by pa.sortorder";
	$options_have_price=false;
	$row = 0;
	$products_options_data=array();
	$products_tax_class_id=$product_info['products_tax_class_id'];
	while ($products_options_name = olc_db_fetch_array($products_options_name_query))
	{
		//$selected = 0;
		$products_options_array = array();
		$products_options_id=$products_options_name[$products_options_id_text];
		$products_options_data[$row]=array(
		$NAME_text=>$products_options_name[$products_options_name_text],
		$ID_text => $products_options_id,
		$DATA_text =>EMPTY_STRING);
		$products_options_sql=str_replace(HASH,$products_id,$products_options_sql0);
		$products_options_sql=str_replace(ATSIGN,$products_options_id,$products_options_sql);
		$products_options_query = olc_db_query($products_options_sql);
		$col = 0;
		while ($products_options = olc_db_fetch_array($products_options_query))
		{
			$products_options_values_id=$products_options[$products_options_values_id_text];
			$roducts_options_values_name=$products_options[$products_options_values_name_text];
			$price_prefix=$products_options[$price_prefix_text];
			$products_options_array[] = array(
			$id_text => $products_options_values_id,
			$text_text => $roducts_options_values_name);
			$options_values_price=(float)$products_options[$options_values_price_text];
			if ($options_values_price != 0)
			{
				$products_options_array[sizeof($products_options_array)-1][$text_text] .= BLANK.
				$price_prefix.BLANK.olc_get_products_attribute_price($options_values_price,
				$tax_class=$products_tax_class_id,$price_special=0,$quantity=1,
				$prefix=$price_prefix).BLANK.$currency ;

				$price = olc_format_price(olc_get_products_attribute_price($options_values_price,
				$tax_class=$products_tax_class_id,$price_special=0,$quantity=1, $prefix=$price_prefix),1,false,1);
				$options_have_price=true;
			}
			else
			{
				$price=EMPTY_STRING;
				$price_prefix=EMPTY_STRING;
			}
			$products_options_data[$row][$DATA_text][$col]=array(
			$ID_text => $products_options_values_id,
			$TEXT_text =>$roducts_options_values_name,
			$MODEL_text =>$products_options[$attributes_model_text],
			$PRICE_text =>$price,
			$PREFIX_text =>$price_prefix);
			$col++;
		}
		$row++;
	}
}
?>