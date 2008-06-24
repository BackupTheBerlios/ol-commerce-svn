<?php
/* --------------------------------------------------------------
$Id: new_attributes_change.php,v 1.1.1.1.2.1 2007/04/08 07:16:29 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(new_attributes_change); www.oscommerce.com
(c) 2003	    nextcommerce (new_attributes_change.php,v 1.8 2003/08/14); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------
Third Party contributions:
New Attribute Manager v4b				Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/
require_once(DIR_FS_INC.'olc_get_tax_rate.inc.php');
require_once(DIR_FS_INC.'olc_get_tax_class_id.inc.php');
require_once(DIR_FS_INC.'olc_format_price.inc.php');

$current_product_id=$_POST['current_product_id'];
// I found the easiest way to do this is just delete the current attributes & start over =)
olc_db_query(DELETE_FROM . TABLE_PRODUCTS_ATTRIBUTES . " WHERE products_id = '" . $current_product_id . APOS );
// Simple, yet effective.. loop through the selected Option Values.. find the proper price & prefix.. insert.. yadda yadda yadda.
for ($i = 0; $i < sizeof($_POST['optionValues']); $i++) {
	$optionValues=$_POST['optionValues'][$i];
	$query = "SELECT * FROM " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS .
	" where products_options_values_id = '" . $optionValues . APOS;
	$result = olc_db_query($query);
	$matches = olc_db_num_rows($result);
	while ($line = olc_db_fetch_array($result, olc_db_ASSOC)) {
		$optionsID = $line['products_options_id'];
	}
	$value_price =  $_POST[$optionValues . '_price'];
	if (PRICE_IS_BRUTTO==TRUE_STRING_S){

		$value_price= ($value_price/((olc_get_tax_rate(olc_get_tax_class_id($current_product_id)))+100)*100);
	}
	$value_price=olc_round($value_price,PRICE_PRECISION);
	$value_prefix = $_POST[$optionValues . '_prefix'];
	$value_sortorder = $_POST[$optionValues . '_sortorder'];
	$value_weight_prefix = $_POST[$optionValues . '_weight_prefix'];
	$value_model =  $_POST[$optionValues . '_model'];
	$value_stock =  $_POST[$optionValues . '_stock'];
	$value_weight =  $_POST[$optionValues . '_weight'];
	$insert_into=INSERT_INTO.TABLE_PRODUCTS_ATTRIBUTES.
		"(products_id,options_id,options_values_id,options_values_price,price_prefix".COMMA;
	$comma_blank="','";
	if ($optionTypeInstalled=='1')
	{
		$value_type=$_POST[$optionValues.'_type'];
		$value_qty=$_POST[$optionValues.'_qty'];
		$value_order=$_POST[$optionValues.'_order'];
		$value_linked=$_POST[$optionValues.'_linked'];
		olc_db_query($insert_into.
			"attributes_model,attributes_stock,options_type_id,options_values_qty,attribute_order,collegamento) VALUES ('".
			$current_product_id.$comma_blank.	optionsID.$comma_blank.$optionValues.$comma_blank.$value_price.
			$comma_blank.$value_model.$comma_blank.$value_stock.$comma_blank.$value_prefix.$comma_blank.$value_type.
			$comma_blank.$value_qty.$comma_blank.$value_order.$comma_blank.
		$value_linked."')");
	}
	elseif ($optionSortCopyInstalled=='1')
	{
		$value_sort=$_POST[$optionValues.'_sort'];
		$value_weight=$_POST[$optionValues.'_weight'];
		$value_weight_prefix=$_POST[$optionValues.'_weight_prefix'];
		olc_db_query($insert_into.
			"products_options_sort_order,	products_attributes_weight,products_attributes_weight_prefix,sordorder) VALUES ('".
			$current_product_id.$comma_blank.$optionsID.$comma_blank.$optionValues.$comma_blank.$value_price.$comma_blank.
			$value_prefix.$comma_blank.$value_sort.$comma_blank.$value_weight.$comma_blank.$value_weight_prefix.
			$comma_blank.$value_sortorder."')");
	}
	else
	{
		olc_db_query($insert_into.
		"attributes_model,attributes_stock,options_values_weight,weight_prefix,sortorder) VALUES ('".
		$current_product_id.$comma_blank.$optionsID.$comma_blank.$optionValues.$comma_blank.$value_price.$comma_blank.
		$value_prefix.$comma_blank.$value_model.$comma_blank.$value_stock.$comma_blank.$value_weight.$comma_blank.
		$value_weight_prefix.$comma_blank.$value_sortorder."')");
	}
}
//Fortextinputoptiontypefeaturebychandra
if ($optionTypeTextInstalled=='1')
{
	if (is_array($_POST['optionValuesText']))
	{
		for($i=0;$i<sizeof($_POST['optionValuesText']);$i++){
			$value_price=$_POST[$optionValues.'_price'];
			$value_prefix=$_POST[$optionValues.'_prefix'];
			$value_product_id=$_POST[$optionValues.'_options_id'];
			olc_db_query($insert_into.") VALUES ('".
			$current_product_id.$comma_blank.$value_product_id.$comma_blank.$optionTypeTextInstalledID.$comma_blank.
			$value_price.$comma_blank.$value_prefix."')");
		}
	}
}
?>