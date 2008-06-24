<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_prepare_products_listing_info.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:39 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(product_listing.php,v 1.42 2003/05/27); www.oscommerce.com
(c) 2003	    nextcommerce (product_listing.php,v 1.19 2003/08/1); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

global $special_info,	$price_data;

$first_run=!is_object($module_smarty);
if ($first_run)
{
	if ($products_use_short_date)
	{
		$products_use_short_date=false;
		$show_full_data=false;
	}
	else
	{
		$show_full_data=true;
	}
	require_once(DIR_FS_INC.'olc_date_short.inc.php');
	require_once(DIR_FS_INC.'olc_get_short_description.inc.php');
	require_once(DIR_FS_INC.'olc_get_products_name.inc.php');
	require_once (DIR_FS_INC.'olc_get_short_description.inc.php');
	require_once(DIR_FS_INC.'olc_get_smarty_config_variable.inc.php');

	olc_smarty_init($module_smarty,$cacheid);
	$module_smarty->assign('SLIDE_SHOW',$do_slide_show);

	$template_subdir="module";
	if ($products_listing_template==EMPTY_STRING or $products_listing_template=='default')
	{
		if ($do_slide_show)
		{
			$s="2";
		}
		elseif (PRODUCTS_LISTING_COLUMNS==EMPTY_STRING)
		{
			$s=ONE_STRING;
		}
		else
		{
			$s=PRODUCTS_LISTING_COLUMNS;
		}
		$products_listing_template = 'product_listing/product_listing_v'.$s;
	}
	if ($Entries==0)
	{
		$Entries=MAX_DISPLAY_SEARCH_RESULTS;
	}
	$do_boxes=$smarty_config_section=="boxes";
	if ($do_boxes)
	{
		$template_subdir=$smarty_config_section;
		$module_smarty->assign('entries_count',$Entries);
	}
	if (strlen($smarty_config_section)>0)
	{
		if (strlen($heading_text)==0)
		{
			$heading_text="heading_text";
		}
		$heading_text=olc_get_smarty_config_variable($module_smarty,$smarty_config_section,$heading_text);
		$module_smarty->assign('HEADING_TEXT', $heading_text);
		$heading_text=EMPTY_STRING;
	}
	$not_do_boxes=!$do_boxes;
	$products_listing_template=CURRENT_TEMPLATE.SLASH.$template_subdir.SLASH.$products_listing_template.HTML_EXT;
	$row = 0;
	$products_listing_entries=false;
	$random_rows=EMPTY_STRING;
	unset($module_content);
	if ($show_full_data)
	{
		// include needed functions
		require_once(DIR_FS_INC.'olc_get_products_price.inc.php');
		require_once(DIR_FS_INC.'olc_image_button.inc.php');
		$ThisDay=date('Y-m-d');
		$separator="|";
		if ($not_do_boxes)
		{
			require_once(DIR_FS_INC.'olc_get_all_get_params.inc.php');
			require_once(DIR_FS_INC.'olc_get_shipping_status_name.inc.php');
			require_once(DIR_FS_INC.'olc_get_vpe_and_baseprice_info.inc.php');
			$module_smarty->assign('UseShortFormat',$UseShortFormat);
			$module_smarty->assign('UsePrintVersion', $UsePrintVersion);
			$module_smarty->assign('UseSearchVersion', $UseSearchVersion);
		}
		$module_smarty->assign('section',$smarty_config_section);
		$not_UsePrintVersion=!$UsePrintVersion;
	}
}
$additional_selection=EMPTY_STRING;
if (DO_GROUP_CHECK) {
	$additional_selection.="
	and p.".SQL_GROUP_CONDITION;
}
if ($_SESSION['customers_status']['customers_fsk18_display']=='0')
{
	$additional_selection.="
	 and p.products_fsk18!=1";
}
$products_listing_sql=str_replace("#group_fsk18#",$additional_selection,$products_listing_sql);
$products_listing_split = new splitPageResults($products_listing_sql, $_GET['page'], $Entries, 'p.products_id');
$my_products_listing_entries=$products_listing_split->number_of_rows;
if ($my_products_listing_entries>0)
{
	if ($products_listing_simple)
	{
		if ($first_run && !$products_use_random_data)
		{
			$products_listing_query=olc_db_query($products_listing_sql);
			$my_products_listing_entries=olc_db_num_rows($products_listing_query);
		}
		else
		{
			$total_records=
			require_once(DIR_FS_INC.'olc_random_select.inc.php');
			$products_listing_query = olc_random_select($products_listing_sql,$random_records);
			//		$my_products_listing_entries=sizeof($products_listing_query);
		}
	}
	else
	{
		$products_listing_query = olc_db_query($products_listing_split->sql_query);
	}
	if (NO_TAX_RAISED)
	{
		$price_disclaimer=PRICE_DISCLAIMER_NO_TAX;
	}
	else
	{
		if (CUSTOMER_SHOW_PRICE_TAX)
		{
			$get_price_disclaimer=true;
		}
		else
		{
			$price_disclaimer=PRICE_DISCLAIMER_EXCL;
		}
	}
	$is_array=is_array($products_listing_query);
	$current_data_row=0;
	while (true)
	{
		if ($is_array)
		{
			$products_listing = $products_listing_query[$current_data_row];
		}
		else
		{
			$products_listing = olc_db_fetch_array($products_listing_query);
		}
		if ($products_listing)
		{
			$products_listing_entries=true;
			$products_id = $products_listing['products_id'];
			$products_name = $products_listing['products_name'];
			if (strlen($products_name)==0)
			{
				$products_name =  olc_get_products_name($products_id);
			}
			$products_name=str_replace(HTML_BR,BLANK,$products_name);
			$products_name=trim(strip_tags($products_name));
			$products_name=str_replace(HTML_AMP,AMP,$products_name );
			$products_name=str_replace('\\',EMPTY_STRING,$products_name);
			$products_short_description = $products_listing['products_short_description'];
			if (strlen($products_short_description)==0)
			{
				$products_short_description =  olc_get_short_description($products_id);
			}
			$products_short_description = strip_tags($products_short_description);
			$products_short_description =str_replace(HTML_AMP,AMP,$products_short_description);
			$products_short_description=str_replace('\\',EMPTY_STRING,$products_short_description);
			$products_date_available=$products_listing['products_date_available'];
			if ($show_full_data)
			{
				$products_image = $products_listing['products_image'];
				if ($products_image)
				{
					$s=str_replace("\r\n",BLANK,$products_short_description);
					$s=str_replace(NEW_LINE,BLANK,$s);
					$s=str_replace(BLANK.BLANK,BLANK,$s);
					if (IS_IE)
					{
						$title="\n\n";
					}
					else
					{
						$title=" -- ";
					}
					$title=$products_name.$title.$s.$title. TEXT_FURTHER_INFO;
					$products_image = olc_image(DIR_WS_THUMBNAIL_IMAGES . $products_image, $title);
				}
				$fsk18=$products_listing['products_fsk18']=='1';
				if (CUSTOMER_SHOW_PRICE)
				{
					//W. Kaiser - AJAX
					$products_price=olc_get_products_price_specials($products_id, $price_special=1, $quantity=1,
					$products_price_special_info,$products_price_real);
					$product_available=$products_price_real>=0;
					$price_display = $products_price;
					if ($products_price_real<0)
					{
						if (!$special_info)
						{
							$price_display=str_replace(HTML_NBSP,BLANK,$price_display);
							$price_display=str_replace(CURRENCY_DECIMAL_POINT,DOT,$price_display);
							$price_display=-(float)$price_display;
							$price_display=olc_format_price($price_display,true,true);
						}
					}
					//W. Kaiser - AJAX
					$buy_now=true;
					if ($products_date_available)
					{
						if (strpos($products_date_available,'0000') == false)	//Empty date
						{
							if (strtotime($products_date_available) <= strtotime($ThisDay))
							{
								$products_date_available=EMPTY_STRING;		//Outdated! Reset date
							}
							else
							{
								$buy_now=false;
							}
						}
					}
					$abs_products_price_real=abs($products_price_real);
					if ($products_price_real>0)
					{
						if (CUSTOMER_NOT_IS_FSK18)
						{
							$buy_now=true;
						}
						else
						{
							$buy_now=!$fsk18;
						}
						if ($buy_now)
						{
							$buy_now=$products_date_available==EMPTY_STRING;
						}
						$product_available=$buy_now;
					}
					else
					{
						if ($buy_now)
						{
							$products_date_available=EMPTY_STRING;		//Outdated! Reset date
							$products_price=abs($products_price);	//Force price positive
							$products_price_real=$abs_products_price_real;	//Force price positive
							$product_available=true;
						}
					}
					if ($not_do_boxes)
					{
						if ($buy_now)
						{
							$alt=TEXT_BUY . $products_name . TEXT_NOW;
							//$parameter=olc_get_all_get_params(array('action','cPath')).'action=buy_now&BUYproducts_id='.$products_id;
							$parameter='action=buy_now&BUYproducts_id='.$products_id;
							$products_min_order_quantity=max(1,$products_listing['products_min_order_quantity']);
							if ($products_min_order_quantity > 1)
							{
								$alt=str_replace(ONE_STRING,$products_min_order_quantity,$alt);
							}
							$buy_now=HTML_A_START . olc_href_link(FILENAME_DEFAULT, $parameter) . '">' .
							olc_image_button('button_buy_now.gif', $alt).HTML_A_END;
						}
						else
						{
							$buy_now=EMPTY_STRING;
						}
					}
				}
				if (strlen($buy_now)==0)
				{
					$file=CURRENT_TEMPLATE_BUTTONS.'button_not_buy_now.gif';
					if (file_exists($file))
					{
						$not_buy_now=olc_image($file);
					}
					else
					{
						$not_buy_now=EMPTY_STRING;
					}
					if (strlen($products_date_available)>0)
					{
						if ($do_boxes)
						{
							$NewDelta=TEXT_DATE_AVAILABLE_SHORT;
						}
						else
						{
							$NewDelta=TEXT_DATE_AVAILABLE;
						}
						$products_date_available=sprintf($NewDelta, olc_date_short($products_date_available));
					}
				}
				if ($not_do_boxes)
				{
					if ($is_listing)
					{
						$products_price_special_info=
						str_replace(TEMPLATE_SPECIAL_PRICE_DATE_1.BLANK,TEMPLATE_SPECIAL_PRICE_DATE_1.HTML_BR,
						$products_price_special_info);
					}
					if (ACTIVATE_SHIPPING_STATUS==TRUE_STRING_S)
					{
						$shipping_status=olc_get_shipping_status_name($products_listing['products_shippingtime']);
						$shipping_status_name=$shipping_status['name'];
						$shipping_status_image=$shipping_status['image'];
						if ($shipping_status_image)
						{
							$shipping_status_image=CURRENT_TEMPLATE_IMG.$shipping_status_image;
						}
					}
					//	W. Kaiser
					$NewDelta="+1 month ";
					$ShowNewMarker=false;
					if ($product_available)
					{
						if (!$ShowNewMarker)
						{
							$ShowNewMarker=
							$ThisDay <=date("Y-m-d", strtotime($NewDelta.$products_listing['products_date_added']));
						}
						if ($products_price_real==0)
						{
							$products_price=EMPTY_STRING;
							$price_display=EMPTY_STRING;
						}
					}
					else
					{
						if ($UseShortFormat)
						{
							$products_name  = STRIKE_START . $products_name  . STRIKE_END;
							$products_short_description  = STRIKE_START . $products_short_description  . STRIKE_END;
							$price_display  = STRIKE_START . $price_display  . STRIKE_END;
						}
					}
				}
				if ($not_UsePrintVersion)
				{
					$products_link=FILENAME_PRODUCT_INFO;
					$parameter='products_id=' . $products_id;
					if ($do_slide_show)
					{
						$link='javascript:slideshow_stop(0);ShowInfo(\''.$link.QUESTION.$parameter.AMP.'pop_up=true'.'\', \'\');"';
					}
					$products_link=olc_href_link($products_link, $parameter);
				}
				if ($not_do_boxes)
				{
					if ($get_price_disclaimer)
					{
						$price_disclaimer=sprintf(PRICE_DISCLAIMER_INCL,$price_data['PRODUCTS_TAX_VALUE']);
					}
					$price=$special_info['specials_new_products_price'];
					if (!$price)
					{
						$price=$products_price_real;
					}
					$this_array=array(
					'BUTTON_DETAIL'=>olc_image(CURRENT_TEMPLATE_BUTTONS.'button_detail.gif',$title),
					'PRODUCTS_MODEL'=>$products_listing['products_model'],
					'PRODUCTS_BUTTON_BUY_NOW'=>$buy_now,
					'PRODUCTS_BUTTON_NOT_BUY_NOW'=>$not_buy_now,
					'PRODUCTS_FSK18'=>$fsk18,
					'SHOW_NEW_MARKER'=>$ShowNewMarker,
					'SHIPPING_NAME'=>$shipping_status_name,
					'SHIPPING_IMAGE'=>$shipping_status_image,
					'PRICE_DISCLAIMER'=> $price_disclaimer,
					'PICTURE_DISCLAIMER'=> PICTURE_DISCLAIMER,
					'PRODUCTS_ID'=>$products_id);
					olc_get_vpe_and_baseprice_info($this_array,$products_listing,$price);
					if (DO_PROMOTION)
					{
						if (strpos($products_listing_template,'promotion')!==false)
						{
							$products_promotion_image = $products_listing['products_promotion_image'];
							if ($products_promotion_image)
							{
								$products_image = olc_image(DIR_WS_PROMOTION_IMAGES . $products_promotion_image, $title);
							}
							$this_array=array_merge($this_array,array(
							'PRODUCTS_PROMOTION_SHOW_TITLE' => $products_listing['products_promotion_show_title'],
							'PRODUCTS_PROMOTION_TITLE' => $products_listing['products_promotion_title'],
							'PRODUCTS_PROMOTION_SHOW_DESCRIPTION' => $products_listing['products_promotion_show_desc'],
							'PRODUCTS_PROMOTION_DESCRIPTION' => $products_listing['products_promotion_desc']));
						}
					}
				}
				$this_array=array_merge($this_array,array(
				'PRODUCTS_IMAGE'=>$products_image ,
				'PRODUCTS_PRICE_RAW'=>$products_price_real,
				'PRODUCTS_PRICE'=>$price_display,
				'PRODUCTS_SPECIALPRICE'=>$products_price_special_info,
				'PRODUCTS_LINK' =>$products_link));
			}
			else
			{
				if (strlen($products_date_available)>0)
				{
					$products_date_available=olc_date_short($products_date_available);
				}
				$this_array=EMPTY_STRING;
			}
			$module_content[]=array(
			'PRODUCTS_NAME'=>$products_name ,
			'PRODUCTS_SHORT_DESCRIPTION'=> $products_short_description,
			'PRODUCTS_DATE_AVAILABLE'=> $products_date_available);
			if ($this_array)
			{
				$module_content[$row]=array_merge($module_content[$row],$this_array);
			}
			$row++;
			$current_data_row++;
		}
		else
		{
			if ($do_boxes)
			{
				$module_smarty->assign('SHOW_MARQUEE',$show_marquee);
				$module_smarty->assign('MORE',1000);
				$module_smarty->assign('MORE_LINK',olc_href_link($smarty_listing_filename));
				$module_smarty->assign('MORE_TYPE',$products_listing_type);
				$module_smarty->assign(MODULE_CONTENT,$module_content);
				$box_content = $module_smarty->fetch($products_listing_template,$cacheid);
				$smarty->assign($smarty_box_name,$box_content);
			}
			break;
		}
	}
	$products_use_random_data=false;
}
else
{
	unset($module_content);
}
//W. Kaiser - AJAX
?>