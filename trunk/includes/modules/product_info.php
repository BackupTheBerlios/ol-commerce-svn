<?php
/* -----------------------------------------------------------------------------------------
$Id: product_info.php,v 1.1.1.1.2.1 2007/04/08 07:17:59 gswkaiser Exp $

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

//include needed functions

require_once(DIR_FS_INC.'olc_get_download.inc.php');
require_once(DIR_FS_INC.'olc_delete_file.inc.php');
require_once(DIR_FS_INC.'olc_get_all_get_params.inc.php');
require_once(DIR_FS_INC.'olc_date_long.inc.php');
require_once(DIR_FS_INC.'olc_draw_hidden_field.inc.php');
require_once(DIR_FS_INC.'olc_image_button.inc.php');
//require_once(DIR_FS_INC.'olc_get_products_attribute_price.inc.php');
require_once(DIR_FS_INC.'olc_draw_form.inc.php');
require_once(DIR_FS_INC.'olc_get_products_price.inc.php');
require_once(DIR_FS_INC.'olc_draw_input_field.inc.php');
require_once(DIR_FS_INC.'olc_image_submit.inc.php');
require_once(DIR_FS_INC.'olc_get_shipping_status_name.inc.php');
require_once(DIR_FS_INC.'olc_check_categories_status.inc.php');
require_once(DIR_FS_INC.'olc_date_short.inc.php');
require_once(DIR_FS_INC.'olc_get_vpe_and_baseprice_info.inc.php');
require_once(DIR_FS_INC.'olc_get_products_mo_images.inc.php');
require_once(DIR_FS_INC.'olc_get_products_stock.inc.php');

if ($_GET['action']=='get_download')
{
	olc_get_download($_GET['cID']);
}
olc_smarty_init($info_smarty,$cacheid);
if (USE_AJAX)
{
	$gallery_text='gallery';
	$is_gallery=isset($_GET[$gallery_text]);
	if ($is_gallery)
	{
		$line=$_GET['line'];
		if ($line)
		{
			$area=PRODUCTS_INFO_LINE.$line;
		}
		else
		{
			$is_gallery=false;
		}
	}
}
$not_is_gallery=!$is_gallery;
$not_isprint_version=!$isprint_version;
$not_is_gallery_and_not_isprint_version=$not_is_gallery && $not_isprint_version;
if (DO_GROUP_CHECK)
{
	$group_check=" and p.".SQL_GROUP_CONDITION;
}
//
//W. Kaiser - allow search by 'products_model' (better approach for 'deep linking')!
//
$products_id = $_GET['products_id'];
if ($products_id == EMPTY_STRING)
{
	$products_id=$_GET['products_model'];
	$searchkey="model";
}
else
{
	$searchkey="id";
}
if ($products_id)
{
	$searchkey.="=".$products_id;
	$searchkey0="products_" . $searchkey ;
	$searchkey=" and p.".$searchkey0;
	$s='products_id_full';
	if (isset($_SESSION[$s]))
	{
		$products_id_full=$_SESSION[$s];
		unset($_SESSION[$s]);
	}
	//
	//W. Kaiser - allow search by 'products_model' (better approach for 'deep linking')!
	//
	//
	//W. Kaiser - Baseprice
	$product_info_query =	olc_standard_products_query(EMPTY_STRING) .$searchkey;
	$product_info_query = olc_db_query($product_info_query);
	//W. Kaiser - Baseprice
	//
	//W. Kaiser - allow search by 'products_model' (better approach for 'deep linking')			!
	//
	if (olc_db_num_rows($product_info_query))
	{
		$product_info = olc_db_fetch_array($product_info_query);

		$products_name = str_replace(array(HTML_BR,strtoupper(HTML_BR)),BLANK,$product_info['products_name']);
		$products_name =str_replace(HTML_AMP,AMP,$products_name );
		$products_name=str_replace('\\',EMPTY_STRING,$products_name);
		//W. Kaiser - AJAX
		$parameter='action=add_product';
		if (USE_AJAX)
		{
			require_once(DIR_FS_INC.'olc_get_uprid.inc.php');
			//Note: the quantity will no longer be added to the cart-quantity, but is set as the  t o t a l  quatity!
			$true='=true';
			$parameter.=AMP.'force_quantity'.$true;
			/*
			if ($is_gallery)
			{
				$parameter.=AMP.$gallery_text.$true;
			}
			*/
		}
		if ($not_isprint_version)
		{
			if (ACTIVATE_NAVIGATOR==TRUE_STRING_S)
			{
				include(DIR_WS_MODULES . 'product_navigator.php');
			}
			olc_db_query(SQL_UPDATE . TABLE_PRODUCTS_DESCRIPTION . " set products_viewed = products_viewed+1 where " .
			$searchkey0 . " and language_id = " . SESSION_LANGUAGE_ID);
			$form_action=olc_href_link(FILENAME_PRODUCT_INFO,olc_get_all_get_params(array('action')) . $parameter);
		}
		//W. Kaiser - AJAX

		//fsk18 lock
		if ($_SESSION['customers_status']['customers_fsk18_display']=='0' && $product_info['products_fsk18']=='1')
		{
			$error=TEXT_PRODUCT_NOT_FOUND;
			include(DIR_WS_MODULES . FILENAME_ERROR_HANDLER);
		}
		else
		{
			//W. Kaiser - AJAX
			$products_id=$product_info['products_id'];
			$products_price=olc_get_products_price_specials($products_id, $price_special=1, $quantity=1,
			$price_special_info,$products_price_real);
			$product_available=$products_price_real>=0;
			//W. Kaiser - AJAX
			if ($products_price_real==0)
			{
				$products_price=EMPTY_STRING;
			}
			// check if customer is allowed to add to cart
			//
			$par_prod_id='products_id='.$products_id;
			$onclick_text=' onclick="javascript:';
			$style='style="cursor:hand"'.$onclick_text;
			if (!IS_IE)
			{
				//Resize window for FireFox
				$onclick=$onclick_text.'window.moveTo(0,0);window.resizeTo(screen.width,screen.height)"';
			}
			$pdf_print=PDF_DATASHEET.HTML_NBSP.
			HTML_A_START.olc_href_link(FILENAME_PDF_DATASHEET,$par_prod_id,NONSSL,false,false,false).QUOTE.
			$onclick.' align="middle" target="_blank">'.olc_image(DIR_WS_ICONS.'pdf.gif',PDF_DATASHEET_TITLE).HTML_A_END;
			if ($isprint_version && $not_is_gallery)
			{
				$info_smarty->assign('PRINT_VERSION',true);
				$info_smarty->assign('PRODUCTS_PRINT',$pdf_print.str_repeat(HTML_NBSP,10));
			}
			else
			{
				$info_smarty->assign('FORM_ACTION',olc_draw_form('cart_quantity',$form_action));
				if (CUSTOMER_SHOW_PRICE)
				{
					// fsk18
					if (CUSTOMER_NOT_IS_FSK18)
					{
						$allow_purchase=$product_info['products_fsk18']=='0';
					}
					else
					{
						$allow_purchase=true;
					}
					if ($allow_purchase)
					{
						//W. Kaiser - AJAX
						$parameter='size="3"';
						if (USE_AJAX)
						{
							$action='products_quantity_changed(this,"'.$form_action.'",#)';
							//$parameter.=' onkeyup='.str_replace(HASH,'false',$action);
							$parameter.=' onchange='.str_replace(HASH,'true',$action);
						}
						$products_min_order_quantity=max(1,$product_info['products_min_order_quantity']);
						$qty_field=
							olc_draw_input_field('products_qty', $products_min_order_quantity,$parameter).
							olc_draw_hidden_field('products_id', $products_id).
							olc_draw_hidden_field('products_min_order_quantity', $products_min_order_quantity);
						$do_stock_check=STOCK_CHECK==TRUE_STRING_S;
						if ($do_stock_check)
						{
							$products_qty.=
							olc_draw_hidden_field('cart_stock_quantity',olc_get_products_stock($products_id));
						}
						if ($is_gallery)
						{
							$qty_field.=olc_draw_hidden_field($gallery_text,TRUE_STRING_S);
						}
						$info_smarty->assign('ADD_QTY',$qty_field );
						$info_smarty->assign('ADD_CART_BUTTON',
						olc_image_submit('button_in_cart.gif', IMAGE_BUTTON_IN_CART,' id="update_cart" align="middle"',USE_AJAX));
						if ($is_gallery)
						{
							$info_smarty->assign('ABORT_BUTTON',
							HTML_A_START.olc_href_link(FILENAME_GALLERY).'">'.olc_image(CURRENT_TEMPLATE_BUTTONS.'button_back.gif',
							IMAGE_BUTTON_CANCEL, EMPTY_STRING,EMPTY_STRING)).HTML_A_END;
						}
						//W. Kaiser - AJAX
					}
				}
				//	W. Kaiser	chCounter inclusion
				if ($not_is_gallery_and_not_isprint_version)
				{
					if (CHCOUNTER_ACTIVE)
					{
						//chCounter for shop statistics -- http://www.christoph-bachner.net/chcounter
						//The "chCounter"-Pakage must be separately installed and configured.
						//(into the shop's "chCounter"directory)
						//http://www.christoph-bachner.net/chcounter
						/*
						$chCounter=DIR_FS_DOCUMENT_ROOT . 'chCounter/counter.php';
						if (file_exists($chCounter))
						{
						*/
							if (CUSTOMER_STATUS_ID <> DEFAULT_CUSTOMERS_STATUS_ID_ADMIN)	//Only count non-admins!
							{
								//	Count product page selected
								//MAP "products_model" to "products_id"
								define('PRODUCTS_ID','products_id');
								define('PRODUCTS_MODEL','products_model');
								define('DEBUGGER_START','start_debug');
								$RequestURI=$_SERVER['REQUEST_URI'];
								//Check for ZEND-Debuger-info
								$Pos=strpos($RequestURI,DEBUGGER_START);
								if ($Pos >= 0) 		//Debug-info in URI?
								{
									// Remove ZEND-Debuger-info from URI
									$RequestURI = substr($RequestURI, 0, $Pos - 1);
								}
								$Pos=strpos($RequestURI, PRODUCTS_MODEL);
								if ($Pos >= 0) 		//"products_model" in URI
								{
									//MAP "products_model" to "products_id"
									$Pos1=strpos($RequestURI,AMP,$Pos + strlen(PRODUCTS_MODEL));		//Find parameter terminator
									if ($Pos1 == false)
									{
										$Pos1=strlen($RequestURI);
									}
									$ProductsModelString = substr($RequestURI,$Pos, $Pos1-$Pos);

									$_Server['REQUEST_URI']=str_replace($ProductsModelString,PRODUCTS_ID . EQUAL .
									$products_id ,$RequestURI);
								}
								$chCounter_visible = 0;
								$chCounter_page_title = PRODUCTS_PAGE . $products_name;
								include(FILENAME_CHCOUNTER);
							}
						//}
					}
					//	W. Kaiser	chCounter inclusion
					$pdf_link=olc_onclick_link(FILENAME_PRINT_PRODUCT_INFO,'pop_up=true&'.$par_prod_id);
					if (INCLUDE_PDF_INVOICE)
					{
						$pdf_link=str_replace(strtolower(HTTPS),strtolower(HTTP),$pdf_link);
					}
					$products_print_link='javascript:ShowInfo(\''.$pdf_link.'\', \'\')"';
					$products_print=olc_image(DIR_WS_ICONS.'print.gif',PRINT_DATASHEET,16,16,
					$style.$products_print_link);

					$info_smarty->assign('PRODUCTS_PRINT', $products_print);
					$info_smarty->assign('PRODUCTS_PRINT_LINK', $products_print_link);
					$info_smarty->assign('PRODUCTS_PRINT_PDF', $pdf_print);

					/*
					$info_smarty->assign('PRODUCTS_CHEAPLY', HTML_A_START.
					olc_href_link(FILENAME_CHEAPLY_SEE, 'pID='.$products_id).'">'.TEXT_PRODUCTS_CHEAPLY.HTML_A_END);

					// $info_smarty->assign('ASK_PRODUCT_QUESTION', '<img src="templates/'.CURRENT_TEMPLATE.'/buttons/'.$_SESSION['language'].'/ask_a_question.gif" style="cursor:hand" onclick="javascript:window.open(\''.olc_href_link('ask_a_question.php?products_id='.$product->data['products_id']).'\', \'popup\', \'toolbar=0, width=630, height=550\')" alt="" />');
		$info_smarty->assign('ASK_PRODUCT_QUESTION_LINK', '"#" onclick="javascript:window.open(\''.olc_href_link(FILENAME_ASK_PRODUCT_QUESTION, 'products_id='.$product->data['products_id']).'\', \'popup\', \'toolbar=0, width=630, height=550\'); return false";');
					*/

					//W. Kaiser - AJAX
					$products_popup_link_text='PRODUCTS_POPUP_LINK';
					$products_popup_link="javascript:popupWindow('" .
					olc_href_link(FILENAME_POPUP_IMAGE, 'pID='. $products_id.AMP.'pop_up=true',NONSSL,true,true,false) . "')";
					$info_smarty->assign($products_popup_link_text,$products_popup_link);

					//W. Kaiser - AJAX
					$products_url=$product_info['products_url'];
					if ($products_url)
					{
						$info_smarty->assign('PRODUCTS_URL',sprintf(TEXT_MORE_INFORMATION, olc_href_link(FILENAME_REDIRECT,
						'action=url&goto=' . urlencode($products_url), NONSSL, true, false)));
					}
				}
			}
			$info_smarty->assign('PRODUCTS_NAME', $products_name);
			$products_short_description = stripslashes(str_replace('\r\n',
			$replace_string,$product_info['products_short_description']));
			$products_short_description = str_replace('>rn<',$replace_string_1,$products_short_description);
			$products_short_description = str_replace('>n<',$replace_string_1,$products_short_description);
			$products_short_description =str_replace(HTML_AMP,AMP,$products_short_description );
			$products_short_description =str_replace('\\',EMPTY_STRING,$products_short_description );
			$info_smarty->assign('PRODUCTS_SHORT_DESCRIPTION',$products_short_description );
			if (ACTIVATE_SHIPPING_STATUS==TRUE_STRING_S)
			{
				$shipping_status=olc_get_shipping_status_name($product_info['products_shippingtime']);
				$info_smarty->assign('SHIPPING_NAME',$shipping_status['name']);
				$image=$shipping_status['image'];
				if ($image)
				{
					$info_smarty->assign('SHIPPING_IMAGE',CURRENT_TEMPLATE_IMG.$image);
				}
			}
			if ($product_info['products_fsk18']=='1')
			{
				$info_smarty->assign('PRODUCTS_FSK18',TRUE_STRING_S);
			}
			if ($is_pop_up)
			{
				$products_status=0;
			}
			else
			{
				$products_status=$product_info['products_status'];
			}
			$products_date_available=$product_info['products_date_available'];
			if ($products_price_real<0)
			{
				if (!empty($products_date_available))
				{
					//Not empty date
					if (strpos($products_date_available,'0000') == false)
					{
						if (strtotime($products_date_available) < strtotime(date('Y-m-d H:i:s')))
						{
							$products_date_available=EMPTY_STRING;		//Outdated! Reset date
						}
						else
						{
							require_once(DIR_FS_INC.'olc_date_short.inc.php');
							$products_date_available=sprintf(TEXT_DATE_AVAILABLE, olc_date_short($products_date_available));
							$products_status=EMPTY_STRING;
						}
					}
					else
					{
						$products_date_available=EMPTY_STRING;
					}
				}
				if ($products_date_available==EMPTY_STRING)
				{
					$products_price=str_replace(CURRENCY_DECIMAL_POINT,DOT,$products_price);
					$products_price=-$products_price;
					$products_price=olc_format_price($products_price,true,true);

					$products_price_real=str_replace(CURRENCY_DECIMAL_POINT,DOT,$products_price_real);
					$products_price_real=-$products_price_real;
					$products_price_real=olc_format_price($products_price_real,true,true);
				}
				else
				{
					require_once(DIR_FS_INC.'olc_get_smarty_config_variable.inc.php');
					$info_smarty->assign('PRODUCTS_SOLD_OUT',
					olc_get_smarty_config_variable($info_smarty,'product_info','product_not_in_stock'));
					$products_price=str_replace(DASH,EMPTY_STRING,$products_price);
				}
			}
			else
			{
				$products_date_available=EMPTY_STRING;
			}
			//W. Kaiser - Baseprice
			require_once(DIR_FS_INC.'olc_get_vpe_and_baseprice_info.inc.php');
			olc_get_vpe_and_baseprice_info($info_smarty,$product_info,$products_price);
			//W. Kaiser - Baseprice
			$info_smarty->assign('PRODUCTS_MODEL',$product_info['products_model']);
			$info_smarty->assign('PRODUCTS_DATE_AVAILABLE',$products_date_available);
			$info_smarty->assign('PRODUCTS_ADDED',sprintf(TEXT_DATE_ADDED,
			olc_date_short($product_info['products_date_added'])));
			$info_smarty->assign('PRODUCTS_PRICE_RAW',$products_price_real);
			$info_smarty->assign('PRODUCTS_PRICE',$products_price);
			$info_smarty->assign('PRODUCTS_SPECIALPRICE',$price_special_info);
			$info_smarty->assign('PRODUCTS_ID',$products_id);
			$info_smarty->assign('PRODUCTS_QUANTITY',$product_info['products_quantity']);
			$info_smarty->assign('PRODUCTS_WEIGHT',$product_info['products_weight']);
			$info_smarty->assign('PRODUCTS_STATUS',$products_status);
			$info_smarty->assign('PRODUCTS_ORDERED',$product_info['products_ordered']);
			$info_smarty->assign('GENERAL_DISCLAIMER',GENERAL_DISCLAIMER);
			//W. Kaiser - AJAX
			$info_smarty->assign('PRODUCTS_DATE_ADDED',$product_info['products_date_added']);
			$info_smarty->assign('PRODUCTS_ID_FULL',isset($products_id_full)?$products_id_full:$products_id);
			//W. Kaiser - AJAX
			$manufacturers_id=$product_info['manufacturers_id'];
			if ($manufacturers_id )
			{
				$where=" where manufacturers_id='".$manufacturers_id. APOS;
				$manufacturer=olc_db_query("
			  	SELECT manufacturers_name, manufacturers_image from " .TABLE_MANUFACTURERS . $where);
				if (olc_db_num_rows($manufacturer)>0)
				{
					$manufacturer=olc_db_fetch_array($manufacturer);
					$info_smarty->assign('PRODUCTS_MANUFACTURER_NAME',$manufacturer['manufacturers_name']);
					$info_smarty->assign('PRODUCTS_MANUFACTURER_IMAGE',DIR_WS_IMAGES.$manufacturer['manufacturers_image']);
					if ($not_isprint_version || $is_pdf)
					{
						$manufacturer=olc_db_query("select manufacturers_url from " . TABLE_MANUFACTURERS_INFO .
						$where . " and languages_id = '" . SESSION_LANGUAGE_ID . APOS);
						if (olc_db_num_rows($manufacturer)>0)
						{
							$manufacturer=olc_db_fetch_array($manufacturer);
							$info_smarty->assign('PRODUCTS_MANUFACTURER_URL',$manufacturer['manufacturers_url']);
						}
					}
				}
			}
			//Remove superflouus line breaks
			if ($is_pdf)
			{
				if (IS_LOCAL_HOST)
				{
					$replace_string='~~';
				}
				else
				{
					$replace_string=BLANK;
				}
			}
			else
			{
				$replace_string=EMPTY_STRING;
			}
			$products_description = str_replace(array(HTML_B_START,HTML_B_END), array(HTML_B_START, HTML_B_END),
			$product_info['products_description']);
			$s="\\\\";
			while (strpos($products_description,$s)>0)
			{
				$products_description = str_replace($s, '\\', $products_description);
			}
			$products_description = str_replace("\\r\\n",$replace_string,$products_description);
			$products_description = str_replace("\r\n",$replace_string,$products_description);
			$products_description=str_replace(HTML_AMP,AMP,$products_description);
			$products_description =str_replace('\\',EMPTY_STRING,$products_description);
			if ($replace_string)
			{
				$s=$replace_string.$replace_string;
				while (strpos($products_description,$s)>0)
				{
					$products_description = str_replace($s, $replace_string, $products_description);
				}
			}
			if (IS_LOCAL_HOST)
			{
				if ($not_is_gallery_and_not_isprint_version)
				{
					//Spezial-Handling für "Seifenparadies"!!!!!
					$Bestandteile_Search = 'Bestandteile:';
					if (strpos($products_description, $Bestandteile_Search) > 0)
					{
						$products_name=str_replace(APOS,"\\'",$products_name);
						$inci_sql="SELECT `products_name` FROM `inci_products` WHERE `products_name` = '".$products_name.APOS;
						$inci_query=olc_db_query($inci_sql);
						if (olc_db_num_rows($inci_query)>0)
						{
							$title = 'Hier können Sie eine detaillierte Inhaltsbeschreibung von \'' . $products_name .
							'\' aus unserer Datenbank von Kosmetik-Inhaltsstoffen anzeigen lassen';
							//W. Kaiser - AJAX
							define('INCI_LINK', HTML_A_START . olc_href_link(FILENAME_INCI_LISTING, "products_ean=" .
							$product_info["products_model"],'NONSSL',true,true,false) . '"
		  				title="' . $title . '" target="_blank">#</a>');
							//W. Kaiser - AJAX
							$products_inci_link = str_replace(HASH, olc_image(DIR_WS_ICONS . 'info.gif', $title), INCI_LINK) .
							HTML_NBSP;
							$products_inci_link = LPAREN . $products_inci_link .
							str_replace(HASH, 'Detaillierte "INCI"-Inhaltsbeschreibung anzeigen', INCI_LINK);
							$products_inci_link .= HTML_NBSP . str_replace(HASH,
							olc_image(CURRENT_TEMPLATE_BUTTONS .'new.gif', $title), INCI_LINK) . RPAREN;
							$Bestandteile_Replace = HTML_B_START.$Bestandteile_Search.HTML_B_END;
							$products_description = str_replace($Bestandteile_Search, $Bestandteile_Replace . $products_inci_link,
							$products_description);
						}
					}
				}
			}
			$info_smarty->assign('PRODUCTS_DESCRIPTION', $products_description);
			//	W. Kaiser	INCI-link
			//W. Kaiser - AJAX
			//$image_link0=HTML_A_START.'javascript:popupImageWindow(\''.
			olc_href_link(FILENAME_POPUP_IMAGE, "pID=" . $products_id).'\')">'.TILDE.HTML_A_END;
			$image=$product_info['products_image'];
			if ($image)
			{
				$image=DIR_WS_INFO_IMAGES .$image;
				if (!$is_pdf)
				{
					if ($fake_print || $is_gallery)
					{
						$text=EMPTY_STRING;
					}
					else
					{
						$text=TEXT_CLICK_TO_ENLARGE;
					}
					$image=olc_image($image,$text);
				}
			}
			$products_image='PRODUCTS_IMAGE';
			$info_smarty->assign($products_image,$image);
			//W. Kaiser	INCI-link
			//mo_images by Novalis@eXanto.de
			$mo_images = olc_get_products_mo_images($products_id);
			if (isset($mo_images))
			{
				foreach($mo_images as $img)
				{
					$mo_img = $img['image_name'];
					if ($mo_img )
					{
						$mo_img=olc_image(DIR_WS_INFO_IMAGES .$mo_img,TEXT_CLICK_TO_ENLARGE);
						//$image=str_replace(TILDE,$mo_img,$image_link0);
						$info_smarty->assign($products_image.UNDERSCORE.$img['image_nr'],$image);
					}
				}
			}
			//mo_images EOF

			if (CUSTOMER_DISCOUNT != '0.00')
			{
				if ($_SESSION['customers_status']['customers_status_public'] == 1)
				{
					$discount = CUSTOMER_DISCOUNT;
					if ($product_info['products_discount_allowed'] <= CUSTOMER_DISCOUNT)
					{
						$discount = $product_info['products_discount_allowed'];
					}
					if ($discount != '0.00' )
					{
						$info_smarty->assign('PRODUCTS_DISCOUNT',$discount . ' %');
					}
				}
			}
			if ($_SESSION['customers_status']['customers_status_graduated_prices'] == 1)
			{
				include(DIR_WS_MODULES.FILENAME_GRADUATED_PRICE);
			}
			if ($not_is_gallery_and_not_isprint_version)
			{
				include(DIR_WS_MODULES . FILENAME_XSELL_PRODUCTS);
				include(DIR_WS_MODULES . FILENAME_ALSO_PURCHASED_PRODUCTS);
				include(DIR_WS_MODULES . FILENAME_PRODUCT_REVIEWS);
				include(DIR_WS_MODULES . FILENAME_PRODUCTS_MEDIA);
			}
			include(DIR_WS_MODULES . FILENAME_PRODUCTS_ATTRIBUTES);
		}
		include(DIR_FS_INC.'olc_get_price_disclaimer.inc.php');
		$info_smarty->assign('PRICE_DISCLAIMER', $price_disclaimer);
		$info_smarty->assign('PICTURE_DISCLAIMER', PICTURE_DISCLAIMER);
		$product_template=$product_info['product_template'];
		$prod_info_dir=CURRENT_TEMPLATE_MODULE.'product_info/';
		if ($product_template==EMPTY_STRING or $product_template=='default')
		{
			$templates_dir=TEMPLATE_PATH.$prod_info_dir;
			$files=olc_get_templates($templates_dir);
			$product_template=$files[0]['id'];
		}
		if ($is_pdf)
		{
			$is_pdf=false;
		}
		else
		{
			$product_info=$info_smarty->fetch($prod_info_dir.$product_template,$cacheid);
			if ($isprint_version)
			{
				$isprint_version=false;
				$body='<body';
				if ($fake_print)
				{
					$product_info=HTML_BR.HTML_BR.HTML_BR.HTML_BR.$product_info;
					$product_info.=HTML_BR.'<p align="center">'.
					olc_image(CURRENT_TEMPLATE_BUTTONS.'button_window_close.gif',
					EMPTY_STRING,EMPTY_STRING,EMPTY_STRING,$onclick_text.'window.close()"').'</p>';
				}
				else
				{
					$body.=' onload="window.print()"';
				}
				$body.='>';
				echo $body.$product_info.'</body>';
			}
			else
			{
				if ($is_gallery)
				{
					define('SMARTY_FORCE_DISPLAY',$area);
					$body=HTML_BR.HTML_HR.HTML_BR;
					$product_info=$body.TEXT_ORDER_CONTINUE.$product_info.$body;
				}
				else
				{
					$area=MAIN_CONTENT;
				}
				$smarty->assign($area,$product_info);
			}
		}
		if (isset($_SESSION[TRACKING][PRODUCTS_HISTORY]))
		{
			$history_entries = count($_SESSION[TRACKING][PRODUCT_HISTORY]);
			if ($history_entries > TRACKING_PRODUCTS_HISTORY_ENTRIES)
			{
				array_shift($_SESSION[TRACKING][PRODUCT_HISTORY]);
				$history_entries=TRACKING_PRODUCTS_HISTORY_ENTRIES;
			}
		}
		else
		{
			$history_entries = 0;
			$_SESSION[TRACKING][PRODUCT_HISTORY]=array();
		}
		$_SESSION[TRACKING][PRODUCT_HISTORY][$history_entries] = $products_id;
		$_SESSION[TRACKING][PRODUCT_HISTORY]=array_unique($_SESSION[TRACKING][PRODUCT_HISTORY]);
	}
	else
	{
		// product not found in database
		$error=TEXT_PRODUCT_NOT_FOUND;
		include(DIR_WS_MODULES . FILENAME_ERROR_HANDLER);
	}
}
else
{
	olc_exit();
}
?>