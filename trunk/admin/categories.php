<?php
/* --------------------------------------------------------------
$Id: categories.php,v 1.1.1.2.2.1 2007/04/08 07:16:26 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(categories.php,v 1.140 2003/03/24); www.oscommerce.com
(c) 2003  nextcommerce (categories.php,v 1.37 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------
Third Party contribution:
Enable_Disable_Categories 1.3               Autor: Mikel Williams | mikel@ladykatcostumes.com
New Attribute Manager v4b                   Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
Category Descriptions (Version: 1.5 MS2)    Original Author:   Brian Lowe <blowe@wpcusrgrp.org> | Editor: Lord Illicious <shaolin-venoms@illicious.net>
Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

Released under the GNU General Public License
--------------------------------------------------------------*/

$is_periodic=true;
$sample_interval_text='x';
$periodic_settings[$sample_interval_text]=0;
$div_field='
<div id="spiffycalendar" class="text"></div>
';
require('includes/application_top.php');
include_once(DIR_WS_CLASSES.'image_manipulator.php');
require_once(DIR_FS_INC.'olc_get_tax_rate.inc.php');
require_once(DIR_FS_INC.'olc_get_products_mo_images.inc.php');
require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES . 'currencies.php');

$currencies = new currencies();

$products_id_text='products_id';
$categories_id_text='categories_id';

$comma_blank="', '";
$pID=$_GET['pID'];
$cPath_text='cPath=';
$cID_text='&cID=';
$cID=$_GET['cID'];
$cPath=$_GET['cPath'];
$cPath_parameter=$cPath_text.$cPath;
$function=$_GET['function'];
$action0=$_GET['action'];
$action=$action0;
$insert=$action == 'insert_product';
$update=$action == 'update_product';
if ($function)
{
	switch ($function)
	{
		case 'delete':
			olc_db_query(DELETE_FROM . TABLE_PERSONAL_OFFERS_BY_CUSTOMERS_STATUS . $_GET['statusID'] .
			" WHERE products_id = " . $pID . " AND quantity = " . $_GET['quantity']);
			break;
	}
	$action0=EMPTY_STRING;	//'new_product';
	$pID=EMPTY_STRING;
	//olc_redirect(olc_href_link(FILENAME_CATEGORIES, $cPath_parameter . '&action=new_product&pID=' . $pID));
}
if ($action)
{
	switch ($action)
	{
		case 'setflag':
			$flag=$_GET['flag'];
			if (($flag == '0') || ($flag == '1'))
			{
				if ($pID)
				{
					olc_set_product_status($pID, $flag);
				}
				if ($cID)
				{
					olc_set_categories_rekursiv($cID, $flag);
				}
			}
			//olc_redirect(olc_href_link(FILENAME_CATEGORIES, $cPath_parameter));
			$action0=EMPTY_STRING;
			break;
		case 'new_category':
		case 'edit_category':
			if (ALLOW_CATEGORY_DESCRIPTIONS == TRUE_STRING_S)
			{
				$action0=$action . '_ACD';
				$_GET['action']=$action0;
			}
			break;
		case 'insert_category':
		case 'update_category':
			if (($_POST['edit_x']) || ($_POST['edit_y'])) {
				$action = 'edit_category_ACD';
			} else {
				$categories_id = olc_db_prepare_input($_POST[$categories_id_text]);
				if ($categories_id == EMPTY_STRING)
				{
					$categories_id = $cID;
				}
				$sort_order = olc_db_prepare_input($_POST['sort_order']);
				$categories_status = olc_db_prepare_input($_POST['categories_status']);
				// set allowed c.groups
				$groups=$_POST['groups'];
				if ($groups)
				{
					$group_ids=EMPTY_STRING;
					foreach ($groups as $b)
					{
						$group_ids .= 'c_'.$b."_group ,";
					}
					if (strstr($group_ids,'c_all_group'))
					{
						$customers_statuses_array=olc_get_customers_statuses();
						$group_ids='c_all_group,';
						for ($i=0;$n=sizeof($customers_statuses_array),$i<$n;$i++) {
							$group_ids .='c_'.$customers_statuses_array[$i]['id'].'_group,';
						}
					}
				}
				$sql_data_array = array(
				'sort_order' => $sort_order,
				'group_ids'=>$group_ids,
				'products_sorting' => olc_db_prepare_input($_POST['products_sorting']),
				'products_sorting2' => olc_db_prepare_input($_POST['products_sorting2']),
				'categories_template'=>olc_db_prepare_input($_POST['categorie_template']),
				'listing_template'=>olc_db_prepare_input($_POST['listing_template']));
				if ($action == 'insert_category')
				{
					$insert_sql_data = array('parent_id' => $current_category_id,
					'date_added' => 'now()');
					$sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
					olc_db_perform(TABLE_CATEGORIES, $sql_data_array);
					$categories_id = olc_db_insert_id();
				}
				elseif ($action == 'update_category')
				{
					$update_sql_data = array('last_modified' => 'now()');
					$sql_data_array = olc_array_merge($sql_data_array, $update_sql_data);
					olc_db_perform(TABLE_CATEGORIES, $sql_data_array, 'update', 'categories_id=' .	$categories_id);
				}
				olc_set_groups($categories_id,$group_ids);
				$_GET['cID']=$categories_id;
				$languages = olc_get_languages();
				for ($i = 0, $n = sizeof($languages); $i < $n; $i++)
				{
					$categories_name_array = $_POST['categories_name'];
					$language_id = $languages[$i]['id'];
					$sql_data_array = array('categories_name' =>
					olc_db_prepare_input($categories_name_array[$language_id]));
					if (ALLOW_CATEGORY_DESCRIPTIONS == TRUE_STRING_S)
					{
						$categories_name=olc_db_prepare_input($_POST['categories_name'][$language_id]);
						$categories_heading_title=olc_db_prepare_input($_POST['categories_heading_title'][$language_id]);
						$categories_description=olc_db_prepare_input($_POST['categories_description_'.$language_id]);
						$categories_meta_title=olc_db_prepare_input($_POST['categories_meta_title'][$language_id]);
						if ($categories_meta_title==EMPTY_STRING)
						{
							$categories_meta_title=$categories_name;
						}
						$categories_meta_description=olc_db_prepare_input($_POST['categories_meta_description'][$language_id]);
						if ($categories_meta_description==EMPTY_STRING)
						{
							$categories_meta_description=$categories_description;
						}
						$categories_meta_keywords=olc_db_prepare_input($_POST['categories_meta_keywords'][$language_id]);
						if ($categories_meta_keywords==EMPTY_STRING)
						{
							$categories_meta_keywords=
							str_replace(BLANK,COMMA,$categories_name).COMMA.str_replace(BLANK,COMMA,$categories_description);
						}

						$sql_data_array = array(
						'categories_name' =>$categories_name,
						'categories_heading_title' => $categories_heading_title,
						'categories_description' => $categories_description,
						'categories_meta_title' => $categories_meta_title,
						'categories_meta_description' => $categories_meta_description,
						'categories_meta_keywords' => $categories_meta_keywords);
					}
					if ($action == 'insert_category')
					{
						$insert_sql_data = array(
						$categories_id_text => $categories_id,
						'language_id' => $language_id);
						$sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
						olc_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_array);
					}
					elseif ($action == 'update_category')
					{
						olc_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_array, 'update', 'categories_id = ' .
						$categories_id . ' and language_id = ' . $language_id);
					}
				}
				if ($categories_image = new upload('categories_image', DIR_FS_CATALOG_IMAGES.'categories/'))
				{
					$categories_image=$categories_image->filename;
				}
				if (!$categories_image)
				{
					$categories_image=$_POST['categories_previous_image'];
				}
				if ($categories_image)
				{
					olc_db_query(SQL_UPDATE . TABLE_CATEGORIES . " set categories_image = '" .
					olc_db_input($categories_image) ."' where categories_id = " . $categories_id);
				}
				//olc_redirect(olc_href_link(FILENAME_CATEGORIES, $cPath_parameter . $cID_text . $categories_id));
				$cID=$categories_id;
				$action0=EMPTY_STRING;
			}
			break;
		case 'delete_category_confirm':
			if ($_POST[$categories_id_text]) {
				$categories_id = olc_db_prepare_input($_POST[$categories_id_text]);
				$categories = olc_get_category_tree($categories_id, EMPTY_STRING, '0', EMPTY_STRING, true);
				$products = array();
				$products_delete = array();
				for ($i = 0, $n = sizeof($categories); $i < $n; $i++) {
					$product_ids_query = olc_db_query("select products_id from " . TABLE_PRODUCTS_TO_CATEGORIES .
					" where categories_id = '" . $categories[$i]['id'] . APOS);
					while ($product_ids = olc_db_fetch_array($product_ids_query)) {
						$products[$product_ids[$products_id_text]]['categories'][] = $categories[$i]['id'];
					}
				}
				reset($products);
				while (list($key, $value) = each($products))
				{
					$category_ids = EMPTY_STRING;
					for ($i = 0, $n = sizeof($value['categories']); $i < $n; $i++)
					{
						if ($category_ids)
						{
							$category_ids.=COMMA;
						}
						$category_ids .=$value['categories'][$i];
					}
					$check_query = olc_db_query(SELECT_COUNT."as total from " . TABLE_PRODUCTS_TO_CATEGORIES .
					" where products_id = " . $key . " and categories_id not in (" . $category_ids . RPAREN);
					$check = olc_db_fetch_array($check_query);
					if ($check['total'] < 1)
					{
						$products_delete[$key] = $key;
					}
				}
				// Removing categories can be a lengthy process
				@olc_set_time_limit(0);
				for ($i = 0, $n = sizeof($categories); $i < $n; $i++)
				{
					olc_remove_category($categories[$i]['id']);
				}
				reset($products_delete);
				while (list($key) = each($products_delete))
				{
					olc_remove_product($key);
				}
			}
			//olc_redirect(olc_href_link(FILENAME_CATEGORIES, $cPath_parameter));
			$action0=EMPTY_STRING;
			break;
		case 'delete_product_confirm':
			$product_id = olc_db_prepare_input($_POST[$products_id_text]);
			if ($product_id)
			{
				$product_categories = $_POST['product_categories'];
				if (is_array($product_categories))
				{
					for ($i = 0, $n = sizeof($product_categories); $i < $n; $i++)
					{
						olc_db_query(DELETE_FROM . TABLE_PRODUCTS_TO_CATEGORIES .
						" where products_id = " . $product_id .
						" and categories_id = " . $product_categories[$i]);
					}
					$product_categories_query = olc_db_query(SELECT_COUNT."as total from " .
					TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . $product_id . APOS);
					$product_categories = olc_db_fetch_array($product_categories_query);
					if ($product_categories['total'] == '0')
					{
						olc_remove_product($product_id);
					}
				}
			}
			//olc_redirect(olc_href_link(FILENAME_CATEGORIES, $cPath_parameter));
			$action0=EMPTY_STRING;
			break;
		case 'move_category_confirm':
			$categories_id=$_POST[$categories_id_text];
			if (($categories_id) && ($categories_id != $_POST['move_to_category_id']))
			{
				$categories_id = olc_db_prepare_input($categories_id);
				$new_parent_id = olc_db_prepare_input($_POST['move_to_category_id']);
				olc_db_query(SQL_UPDATE . TABLE_CATEGORIES . " set parent_id = " . olc_db_input($new_parent_id) .
				", last_modified = now() where categories_id = " . olc_db_input($categories_id));
			}
			//olc_redirect(olc_href_link(FILENAME_CATEGORIES, $cPath_text . $new_parent_id . $cID_text . $categories_id));
			$cPath=$new_parent_id;
			$action0=EMPTY_STRING;
			break;
		case 'move_product_confirm':
			$products_id = olc_db_prepare_input($_POST[$products_id_text]);
			$new_parent_id = olc_db_prepare_input($_POST['move_to_category_id']);
			$duplicate_check_query = olc_db_query(SELECT_COUNT."as total from " .
			TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = " . olc_db_input($products_id) .
			" and categories_id = " . olc_db_input($new_parent_id));
			$duplicate_check = olc_db_fetch_array($duplicate_check_query);
			if ($duplicate_check['total'] < 1) olc_db_query(SQL_UPDATE . TABLE_PRODUCTS_TO_CATEGORIES .
			" set categories_id = '" . olc_db_input($new_parent_id) . "' where products_id = " .
			olc_db_input($products_id) . " and categories_id = " . $current_category_id);
			//olc_redirect(olc_href_link(FILENAME_CATEGORIES, $cPath_text . $new_parent_id . '&pID=' . $products_id));
			$cPath=$new_parent_id;
			$pID=$products_id;
			$action0=EMPTY_STRING;
			break;
		case 'insert_product':
		case 'update_product':
			$products_price=$_POST['products_price'];
			if (PRICE_IS_BRUTTO==TRUE_STRING_S)
			{
				if ($products_price)
				{
					$products_price = ($products_price/(olc_get_tax_rate($_POST['products_tax_class_id'])+100)*100);
				}
			}
			//Make sure price uses then correct decimal separator (DOT)
			for ($i=strlen($products_price)-1;$i>=0;$i--)
			{
				$s=substr($products_price,$i,1);
				if (!is_numeric($s))
				{
					if ($s==COMMA)
					{
						$products_price=str_replace($s,DOT,$products_price);
					}
					break;
				}
			}
			if (($_POST['edit_x']) || ($_POST['edit_y']))
			{
				$action = 'new_product';
			}
			else
			{
				$products_id = olc_db_prepare_input($_GET['pID']);
				//W. Kaiser - Use german date
				$products_date_available = olc_db_prepare_input($_POST['products_date_available']);
				if (strpos($products_date_available,DOT)!==false)
				{
					//Convert german date to american date
					$products_date_available=
					substr($products_date_available,6,4).DASH.
					substr($products_date_available,3,2).DASH.
					substr($products_date_available,0,2);
				}
				//W. Kaiser - Use german date
				$products_date_available =
				(date('Y-m-d') < $products_date_available) ? $products_date_available : 'null';

				$sql_data_array=array();
				// set allowed c.groups $_POST['groups']
				$groups=$_POST['groups'];
				if ($groups)
				{
					if (in_array('all',$groups))
					{
						$customers_statuses_array=olc_get_customers_statuses();
						$group_ids='c_all_group,';
						for ($i=0;$n=sizeof($customers_statuses_array),$i<$n;$i++) {
							$group_ids .='c_'.$customers_statuses_array[$i]['id'].'_group,';
						}
					}
					else
					{
						$group_ids=EMPTY_STRING;
						foreach ($groups as $b)
						{
							$group_ids .= 'c_'.$b."_group ,";
						}
					}
				}
				$sql_data_array['group_ids']=$group_ids;

				$fields=array(
				'manufacturers_id',
				'options_template',
				'product_template',
				'products_baseprice_show',
				'products_baseprice_value',
				'products_date_available',
				'products_discount_allowed',
				'products_fsk18',
				'products_min_order_quantity',
				'products_min_order_vpe',
				'products_model',
				'products_price',
				'products_promotion_show_desc',
				'products_promotion_show_title',
				'products_promotion_status',
				'products_quantity',
				'products_shippingtime',
				'products_sort',
				'products_status',
				'products_tax_class_id',
				'products_uvp',
				'products_vpe',
				'products_vpe_status',
				'products_vpe_value',
				'products_weight');
				while (list(,$key)=each($fields))
				{
					$value=$_POST[$key];
					if (isset($value))
					{
						$sql_data_array[$key]=olc_db_prepare_input($value);
					}
				}
				$not_pictures_on_the_fly=PRODUCT_IMAGE_ON_THE_FLY<>TRUE_STRING_S;
				$products_image_text='products_image';
				if ($products_image = new upload($products_image_text, DIR_FS_CATALOG_ORIGINAL_IMAGES))
				{
					$products_image_name = $products_image->filename;
					if ($products_image_name)
					{
						if ($not_pictures_on_the_fly)
						{
							require(DIR_WS_INCLUDES . 'product_thumbnail_images.php');
							require(DIR_WS_INCLUDES . 'product_info_images.php');
							require(DIR_WS_INCLUDES . 'product_popup_images.php');
						}
					}
					else
					{
						$products_image_name = $_POST['products_previous_image'];
					}
					$sql_data_array[$products_image_text] = olc_db_prepare_input($products_image_name);
				}
				//mo_images BOF
				if (MO_PICS>0)
				{
					//MO_PICS
					//are we asked to delete some mo_pics?
					$del_mo_pic=$_POST['del_mo_pic'];
					if ($del_mo_pic)
					{
						$sql=DELETE_FROM . TABLE_PRODUCTS_IMAGES . " where products_id = " . olc_db_input($products_id) .
						" AND image_name = '";
						foreach ($del_mo_pic as $val)
						{
							@olc_del_image_file($val);
							olc_db_query($sql.$val.APOS);
						}
					}
					for ($img=0;$img<MO_PICS;$img++)
					{
						if ($pIMG = new upload('mo_pics_'.$img, DIR_FS_CATALOG_ORIGINAL_IMAGES, '777', EMPTY_STRING, true))
						{
							$img_1=$img+1;
							$products_previous_image=$_POST['products_previous_image_'.$img_1];
							$pname_arr = explode(DOT,$pIMG->filename);
							$nsuffix = array_pop($pname_arr);
							$products_image_name = $products_id . UNDERSCORE . $img_1 . DOT . $nsuffix;
							@olc_del_image_file($products_previous_image);
							@olc_del_image_file($products_image_name);
							rename(DIR_FS_CATALOG_ORIGINAL_IMAGES.SLASH.$pIMG->filename,
							DIR_FS_CATALOG_ORIGINAL_IMAGES.SLASH.$products_image_name);
							//get data & write to table
							$mo_img = array(
							$products_id_text => olc_db_prepare_input($products_id),
							'image_nr' => olc_db_prepare_input($img_1),
							'image_name' => olc_db_prepare_input($products_image_name));
							if ($insert)
							{
								olc_db_perform(TABLE_PRODUCTS_IMAGES, $mo_img);
							}
							elseif ($update && $products_previous_image)
							{
								foreach ($del_mo_pic as $val)
								{
									if ($val == $products_previous_image)
									{
										olc_db_perform(TABLE_PRODUCTS_IMAGES, $mo_img);
										break;
									}
								}
								olc_db_perform(TABLE_PRODUCTS_IMAGES, $mo_img, 'update', 'image_name = \'' .
								olc_db_input($products_previous_image). APOS);
							}
							elseif (!$products_previous_image)
							{
								olc_db_perform(TABLE_PRODUCTS_IMAGES, $mo_img);
							}
							if ($not_pictures_on_the_fly)
							{
								//image processing
								require(DIR_WS_INCLUDES . 'product_thumbnail_images.php');
								require(DIR_WS_INCLUDES . 'product_info_images.php');
								require(DIR_WS_INCLUDES . 'product_popup_images.php');
							}
						}
					}
				}
				//mo_images EOF

				$products_image_post=$_POST[$products_image_text];
				if (olc_not_null($products_image_post))
				{
					if ($products_image_post != 'none')
					{
						$sql_data_array[$products_image_text] = $products_image_post;
					}
				}
				if ($insert)
				{
					$insert_sql_data = array('products_date_added' => 'now()');
					$sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
					olc_db_perform(TABLE_PRODUCTS, $sql_data_array);
					$products_id = olc_db_insert_id();
					olc_db_query(INSERT_INTO . TABLE_PRODUCTS_TO_CATEGORIES . " (products_id, categories_id) values (" .
					$products_id .COMMA . $current_category_id . RPAREN);
				}
				elseif ($update)
				{
					$update_sql_data = array('products_last_modified' => 'now()');
					$sql_data_array = olc_array_merge($sql_data_array, $update_sql_data);
					olc_db_perform(TABLE_PRODUCTS, $sql_data_array, UPDATE, 'products_id = ' . olc_db_input($products_id));

					//W. Kaiser - AJAX
					if (USE_AJAX_ATTRIBUTES_MANAGER)
					{
						/** osc@kangaroopartners.com - AJAX Attribute Manager  **/
						require_once(AJAX_ATTRIBUTES_MANAGER_LEADIN.'updateatomic.inc.php');
						/** osc@kangaroopartners.com - AJAX Attribute Manager  end **/
					}
					//W. Kaiser - AJAX
				}
				$_GET['pID']=$products_id;
				$languages = olc_get_languages();
				// Here we go, lets write Group prices into db
				// start
				$group_data=array();
				$group_query_sql="SELECT customers_status_id  FROM " . TABLE_CUSTOMERS_STATUS .
					" WHERE language_id = " . SESSION_LANGUAGE_ID . " AND customers_status_id != '0'";
				$group_query = olc_db_query($group_query_sql);
				while ($group_values = olc_db_fetch_array($group_query))
				{
					// load data into array
					$group_data[] = array('STATUS_ID' => $group_values['customers_status_id']);
				}
				for ($col = 0, $n = sizeof($group_data); $col < $n+1; $col++) {
					$group_data_status_id=$group_data[$col]['STATUS_ID'];
					if ($group_data_status_id != EMPTY_STRING)
					{
						$personal_price = olc_db_prepare_input($_POST['products_price_' . $group_data_status_id]);
						if ($personal_price == EMPTY_STRING or $personal_price=='0.0000') {
							$personal_price = '0.00';
						} else {
							if (PRICE_IS_BRUTTO==TRUE_STRING_S){
								$personal_price= ($personal_price/(olc_get_tax_rate($_POST['products_tax_class_id']) +100)*100);
							}
							$personal_price=olc_round($personal_price,PRICE_PRECISION);
						}
						olc_db_query(SQL_UPDATE . TABLE_PERSONAL_OFFERS_BY_CUSTOMERS_STATUS . $group_data_status_id .
						" SET personal_offer = '" . $personal_price . "' WHERE products_id = " .
						$products_id . " AND quantity = '1'");
					}
				}
				// end
				for ($col = 0, $n = sizeof($group_data); $col < $n+1; $col++)
				{
					$group_data_status_id=$group_data[$col]['STATUS_ID'];
					if ($group_data_status_id != EMPTY_STRING)
					{
						$quantity = olc_db_prepare_input($_POST['products_quantity_staffel_' . $group_data_status_id]);
						$staffelpreis = olc_db_prepare_input($_POST['products_price_staffel_' . $group_data_status_id]);
						if (PRICE_IS_BRUTTO==TRUE_STRING_S){
							$staffelpreis= ($staffelpreis/(olc_get_tax_rate($_POST['products_tax_class_id']) +100)*100);
						}
						$staffelpreis=olc_round($staffelpreis,PRICE_PRECISION);
						if ($staffelpreis!=EMPTY_STRING && $quantity!=EMPTY_STRING)
						{
							// ok, lets check entered data to get rid of user faults
							if ($quantity<=1)
							{
								$quantity=2;
							}
							$table=TABLE_PERSONAL_OFFERS_BY_CUSTOMERS_STATUS . $group_data_status_id;
							$check_query=olc_db_query("SELECT quantity FROM " . $table.
							" WHERE products_id=". $products_id." and quantity=".$quantity);
							// dont insert if same qty!
							if (olc_db_num_rows($check_query)<1)
							{
								olc_db_query(INSERT_INTO . $table.
								" (price_id, products_id, quantity, personal_offer) values ('', '" .
								$products_id . COMMA . $quantity . $comma_blank . $staffelpreis . "')");
							}
						}
					}
				}
				$products_promotion_title_text='products_promotion_title';
				$products_promotion_image_text='products_promotion_image';
				for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
					$language_id = $languages[$i]['id'];
					$products_name=olc_db_prepare_input($_POST['products_name'][$language_id]);
					$products_short_description=olc_db_prepare_input($_POST['products_short_description_'.$language_id]);

					$products_meta_title=olc_db_prepare_input($_POST['products_meta_title'][$language_id]);
					if ($products_meta_title == EMPTY_STRING)
					{
						$products_meta_title=$products_short_description;
					}
					$products_meta_description=olc_db_prepare_input($_POST['products_meta_description'][$language_id]);
					if ($products_meta_description == EMPTY_STRING)
					{
						$products_meta_description=$products_name;
					}
					$products_meta_keywords=olc_db_prepare_input($_POST['products_meta_keywords'][$language_id]);
					if ($products_meta_keywords == EMPTY_STRING)
					{
						$products_meta_keywords=$products_name;
					}
					$current_products_promotion_image_text=$products_promotion_image_text.$i;
					$products_promotion_dir=ADMIN_PATH_PREFIX.DIR_WS_PROMOTION_IMAGES;
					if ($products_promotion_image = new upload($current_products_promotion_image_text,$products_promotion_dir))
					{
						$file_name=$products_promotion_image->filename;
						$pos=strrpos($file_name,DOT);
						$products_promotion_imagename=$products_id. UNDERSCORE . $i.substr($file_name,$pos);
						rename($products_promotion_dir.$file_name,$products_promotion_dir.$products_promotion_imagename);
					}
					elseif ($_POST['del_'.$current_products_promotion_image_text])
					{
						$products_promotion_imagename = EMPTY_STRING;
					}
					else
					{
						$products_promotion_imagename = $_POST[$current_products_promotion_image_text];
					}
					$sql_data_array = array(
					'products_name' => $products_name,
					'products_description' => olc_db_prepare_input($_POST['products_description_'.$language_id]),
					'products_short_description' => $products_short_description,
					'products_url' => olc_db_prepare_input($_POST['products_url'][$language_id]),
					$products_promotion_title_text => olc_db_prepare_input($_POST[$products_promotion_title_text][$language_id]),
					'products_promotion_image' => $products_promotion_imagename,
					'products_promotion_desc' => olc_db_prepare_input($_POST['products_promotion_desc_'.$language_id]),
					'products_meta_title' => $products_meta_title,
					'products_meta_description' => $products_meta_description,
					'products_meta_keywords' => $products_meta_keywords);
					if ($insert)
					{
						$insert_sql_data = array(
						$products_id_text => $products_id,
						'language_id' => $language_id);
						$sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
						olc_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array);
					}
					else	//if ($update)
					{
						olc_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array, UPDATE, 'products_id = ' .
						$products_id . ' and language_id = ' . $language_id );
					}
				}
				//olc_redirect(olc_href_link(FILENAME_CATEGORIES, $cPath_parameter . '&pID=' . $products_id));
				$pID=$products_id;
				$action0=EMPTY_STRING;
			}
			break;
		case 'copy_to_confirm':
			if(isset($_POST['cat_ids']) && $_POST['copy_as'] == 'link')
			{
				$products_id = olc_db_prepare_input($_POST[$products_id_text]);
				foreach($_POST['cat_ids'] as $key){
					$check_query = olc_db_query(SELECT_COUNT."as total from " . TABLE_PRODUCTS_TO_CATEGORIES .
					" where products_id = " . $products_id . " and categories_id = " . $key);
					$check = olc_db_fetch_array($check_query);
					if ($check['total'] < '1')
					{
						olc_db_query(INSERT_INTO . TABLE_PRODUCTS_TO_CATEGORIES .
						" (products_id, categories_id) values (" . $products_id . COMMA . $key . RPAREN);
					} else  {
						$messageStack->add_session(ERROR_CANNOT_LINK_TO_SAME_CATEGORY, 'error');
					}
				}
				break;
			}
			if ((olc_not_null($_POST[$products_id_text])) && (olc_not_null($_POST[$categories_id_text])))
			{
				$products_id = olc_db_prepare_input($_POST[$products_id_text]);
				$categories_id = olc_db_prepare_input($_POST[$categories_id_text]);
				$cat_ids=$_POST['cat_ids'];
				if($cat_ids==EMPTY_STRING)
				{
					$cat_ids=array(0=>$categories_id);
				}
				foreach($cat_ids as $key) {
					$categories_id=$key;
					if ($_POST['copy_as'] == 'link')
					{
						if ($_POST[$categories_id_text] != $current_category_id)
						{
							$check_query = olc_db_query(SELECT_COUNT."as total from " . TABLE_PRODUCTS_TO_CATEGORIES .
							" where products_id = " . $products_id . " and categories_id = " . $categories_id);
							$check = olc_db_fetch_array($check_query);
							if ($check['total'] < 1)
							{
								olc_db_query(INSERT_INTO . TABLE_PRODUCTS_TO_CATEGORIES ." (
								products_id,
								categories_id
								) values (" .
								olc_db_input($products_id) . COMMA .
								olc_db_input($categories_id) . RPAREN);
							}
						}
						else
						{
							$messageStack->add_session(ERROR_CANNOT_LINK_TO_SAME_CATEGORY, 'error');
						}
					}
					elseif ($_POST['copy_as'] == 'duplicate')
					{
						$where=SQL_WHERE.'products_id=' .$products_id;
						$product_query = olc_db_query(SELECT_ALL.TABLE_PRODUCTS.$where);
						$product = olc_db_fetch_array($product_query);
						unset($product[$products_id_text]);
						olc_db_perform(TABLE_PRODUCTS,$product);
						$dup_products_id = olc_db_insert_id();

						$description_query = olc_db_query(SELECT_ALL.TABLE_PRODUCTS_DESCRIPTION.$where);
						while ($description = olc_db_fetch_array($description_query))
						{
							$description[$products_id_text]=$dup_products_id;
							$description['products_viewed']=0;
							olc_db_perform(TABLE_PRODUCTS_DESCRIPTION,$description);
						}

						olc_db_query(INSERT_INTO . TABLE_PRODUCTS_TO_CATEGORIES . " (
						products_id,
						categories_id
						) values (" .
						$dup_products_id . COMMA .
						$categories_id . RPAREN);
						//mo_images by Novalis@eXanto.de
						$mo_images = olc_get_products_mo_images($products_id);
						if (isset($mo_images))
						{
							$insert=INSERT_INTO . TABLE_PRODUCTS_IMAGES ." (products_id, image_nr, image_name) values ('";
							foreach ($mo_images as $mo_img)
							{
								olc_db_query($insert. $dup_products_id . $comma_blank .
								$mo_img['image_nr'] . $comma_blank . $mo_img['image_name'] . "')");
							}
						}
						//mo_images EOF

						$group_data=array();
						$group_query_sql="SELECT customers_status_id  FROM " . TABLE_CUSTOMERS_STATUS .
							" WHERE language_id = " . SESSION_LANGUAGE_ID . " AND customers_status_id != '0'";
						$group_query = olc_db_query($group_query_sql);
						while ($group_values = olc_db_fetch_array($group_query)) {
							// load data into array
							$group_data=array('STATUS_ID' => $group_values['customers_status_id']);
						}
						$select="select quantity,personal_offer FROM " . TABLE_PERSONAL_OFFERS_BY_CUSTOMERS_STATUS;
						$insert=INSERT_INTO . TABLE_PERSONAL_OFFERS_BY_CUSTOMERS_STATUS . HASH . "
                	(price_id,
                	products_id,
                	quantity,
                	personal_offer)
                 	values ('', '";
						for ($col = 0, $n = sizeof($group_data); $col < $n+1; $col++)
						{
							$group_data_status_id=$group_data[$col]['STATUS_ID'];
							if ($group_data_status_id != EMPTY_STRING)
							{
								$copy_query=olc_db_query($select . $group_data_status_id .$where);
								while ($copy_data=olc_db_fetch_array($copy_query))
								{
									olc_db_query(str_replace(HASH,$group_data_status_id,$insert) .
									$dup_products_id . $comma_blank . $copy_data['quantity'].
									$comma_blank . $copy_data['personal_offer'] . "')");
								}
							}
						}
					}
				}

			}
			//olc_redirect(olc_href_link(FILENAME_CATEGORIES, $cPath_text . $categories_id . '&pID=' . $products_id));
			$cPath=$categories_id;
			$pID=$products_id;
			$action0=EMPTY_STRING;
			break;
	}
}
/*
// check if the catalog image directory exists
if (is_dir(DIR_FS_CATALOG_IMAGES))
{
	if (!is_writeable(DIR_FS_CATALOG_IMAGES))
	{
		$messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE, 'error');
	}
} else {
	$messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST, 'error');
}
*/
$action=$action0;
?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
	<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
    <td width="100%" valign="top">
    	<table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
//----- new_category / edit_category (when ALLOW_CATEGORY_DESCRIPTIONS is TRUE_STRING_S) -----
if ($action == 'new_category_ACD' || $action == 'edit_category_ACD')
{
	include('new_categorie.php');
	//----- new_category_preview (active when ALLOW_CATEGORY_DESCRIPTIONS is TRUE_STRING_S) -----
} elseif ($action == 'new_category_preview')
{
	// removed
//} elseif ($action == 'new_product' || $insert)
} elseif ($action == 'new_product')
{
	include('new_product.php');
} elseif ($action == 'new_product_preview')
{
	// preview removed
} else {
	include('categories_view.php');
}
?>
    </table></td>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
