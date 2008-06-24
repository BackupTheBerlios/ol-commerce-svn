<?php
/* --------------------------------------------------------------
$Id: auctions.php,v 1.1.1.2.2.1 2007/04/08 07:16:24 gswkaiser Exp $

v 0.1
http://www.lener.info/
This Part of auction.LISTER for ebay is Released under the GNU General Public License
For more informations contact andrea@lener.info

OL-Commerce Version 5.x/AJAX
http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce; www.oscommerce.com
(c) 2003	    nextcommerce; www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

function build_optional_image_html($i)
{
	global $pic_display_text0,$pic_table_text0,$pic_url_text,$pic_text,$onclick0,$sep,$use_multi_pic_text;
	global $multi_pictures,$pic_table0,$span_start,$thumbs_dir_local,$id_is,$dummy_span,$hidden_text,$end;
	global $original_dir_local,$thumbs_dir_local,$display_visible_text,$display_hidden_text,$pic_table0;
	global $dummy_span,$style_display,$fees,$rab,$div_tex,$onchange,$space;

	$next_i=$i+1;
	//$index=UNDERSCORE.$i;
	$index=UNDERSCORE.$next_i;

	$my_pic_display_text=$pic_display_text0.$index;
	$my_pic_table_text=$pic_table_text0.$next_i;
	$my_pic_url_text=$pic_url_text.$index;
	$my_pic_text=$pic_text.$index;

	$my_use_multi_pic_text=$use_multi_pic_text.$next_i;
	$my_use_multi_pic_div_text=$my_use_multi_pic_text.$div_text;
	$not_last=$i<12;

	$onclick=
	$onclick0.
	$my_pic_table_text.$sep.
	$my_pic_url_text.$sep.
	$my_pic_text;
	if ($not_last)
	{
		//$onclick.=$sep.$my_use_multi_pic_text.$sep.TRUE_STRING_S;
		$next_i_1=$next_i+1;
		$onclick.=
		$sep.$use_multi_pic_text.$next_i_1.$div_text.
		$sep.$next_i;
	}
	$onclick.=$end;
	if ($not_last)
	{
		$pic_file_name=$multi_pictures[$next_i];
		$use_multi_pic=$pic_file_name!=EMPTY_STRING;
		$id=$id_is.$my_pic_text.QUOTE;
		if ($use_multi_pic)
		{
			$display=$display_visible_text;
			$my_image=olc_image($thumbs_dir_local.$pic_file_name,
			EMPTY_STRING,EMPTY_STRING,EMPTY_STRING,$id.QUOTE);
			$my_pic_file_name=DIR_WS_ORIGINAL_IMAGES.$pic_file_name;
		}
		else
		{
			$display=$display_hidden_text;
			$my_image=SPAN_START.$id.$rab.SPAN_END;
			$my_pic_file_name=EMPTY_STRING;
		}
		$pic_table=str_replace(UNDERSCORE,$display,$pic_table0);
		$pic_table=str_replace(TILDE,$my_pic_table_text,$pic_table);
		$image_html.=HTML_BR.
		olc_draw_file_field($my_pic_url_text,EMPTY_STRING,str_replace(HASH,$index,$onchange)).
		HTML_BR.
		str_replace(HASH,$my_pic_display_text,$span_start).$my_pic_file_name.SPAN_END;
		$image_html=str_replace(HASH,$image_html,$pic_table);
		$image_html=
		str_replace(ATSIGN,$space.$my_image.$dummy_span,$image_html).
		olc_draw_hidden_field($my_pic_url_text.$hidden_text,$original_dir_local.$pic_file_name);

		if ($i==1 || $use_multi_pic)
		{
			$display=$display_visible_text;
		}
		else
		{
			$display=$display_hidden_text;
		}
		$display=$style_display.$display.QUOTE;
		$image_html='<div nowrap="nowrap"="nowrap" id="'.$my_use_multi_pic_div_text.QUOTE.BLANK.$display.$rab.HTML_BR.
		olc_draw_checkbox_field($my_use_multi_pic_text,ONE_STRING,$use_multi_pic,$onclick).
		HTML_NBSP.sprintf(AUCTIONS_TEXT_AUCTION_USE_MULTI_PIC,$next_i,$fees[$pic_text]).$image_html.'</div>';
	}
	return $image_html;
}

function display_error_if($error_condition,$error_text)
{
	if ($error_condition)
	{
		global $main_content;
		$main_content.=str_replace(HASH,$error_text,ERROR_LINE);
	}
}

function display_section_header($header_text)
{
	global $main_content;
	$main_content.=str_replace(HASH,$header_text,SECTION_HEADER_LINE);
}

function display_section_content_line($description,$content,$one_col_only=false,$use_eval=false,
	$section_id=EMPTY_STRING, $add_html=EMPTY_STRING)
{
	global $main_content;
	if ($use_eval)
	{
		if ($one_col_only)
		{
			$col_start=str_replace(TWO_STRING,ONE_STRING,COL_START);
		}
		else
		{
			$col_start=COL_START;
		}
		ob_start();
		eval($content);
		$content=$col_start.trim(ob_get_contents());
		ob_end_clean();
		if ($add_html)
		{
			$content.=$add_html;
		}
		$content.=COL_END;
	}
	else
	{
		if ($one_col_only)
		{
			$content=COL_START.$description.HTML_NBSP.$content.COL_END;
		}
		else
		{
			$content=
				COL_START_1.$description.HTML_NBSP.COL_END.
				COL_START_1.HTML_NBSP.$content.COL_END.'
';
		}
	}
	$row_html=
	'<tr';
	if ($section_id)
	{
		$row_html.=' id="'.$section_id.QUOTE;
	}
	$row_html.='>';
	$main_content.='
	'.$row_html.
		$content.
		ROW_END;
}

if (NOT_USE_AJAX_ADMIN)
{
	$option_page= $_GET['option_page'];
	$spiffyCal='includes/javascript/spiffyCal/spiffyCal_v2_1.';
	$header_addon='
	<link rel="stylesheet" type="text/css" href="'.$spiffyCal.'css">
	<script language="JavaScript" type="text/javascript" src="'.$spiffyCal.'js"></script>
';
}
$div_field='
<div id="spiffycalendar" class="text"></div>
';
require('includes/application_top.php');
// include needed functions
include_once (DIR_FS_INC.'olc_draw_pull_down_menu.inc.php');
include_once (DIR_FS_INC.'olc_get_categories.inc.php');
include_once (DIR_FS_INC.'olc_get_products_special_price.inc.php');
include_once (DIR_FS_INC.'olc_get_currency_parameters.inc.php');
include_once (DIR_FS_INC.'olc_get_parent_categories.inc.php');
require_once (DIR_WS_FUNCTIONS.'auction_CategorySQL.php');

$colspan=' colspan="2">';
$td_start='<td valign="top" class="dataTableContent"';
define('COL_START_1',$td_start.' nowrap="nowrap"="nowrap">');
define('COL_START', $td_start.$colspan);

define('COL_START_HEADER','
	<td  valign="top" class="dataTableHeadingContent"'.$colspan);
define('COL_START_HEADER_1','
	<td valign="top"'.$colspan);
define('COL_END','</td>');
define('ROW_END','
	</tr>
');
define('SECTION_HEADER_LINE','
		<tr>'.
			COL_START_HEADER_1.HTML_NBSP.COL_END.'
		</tr>
		<tr class="dataTableHeadingRow">'.
			COL_START_HEADER.HASH.COL_END.'
		</tr>
');
define('ERROR_LINE','
	<tr class="messageStackError">
		<td valign="top" class="errorText"'.$colspan.HASH.COL_END.'
	</tr>
');
define('SPAN_START','<span ');
define('SPAN_END','</span>');
define('TWO_STRING','2');

$catalog_dir_remote=EBAY_REAL_SHOP_URL;
if (substr($catalog_dir_remote,-1,1)!=SLASH)
{
	$catalog_dir_remote.=SLASH;
}
$ebay_express_only=EBAY_EBAY_EXPRESS_ONLY==TRUE_STRING_S;
$not_ebay_express_only=!$ebay_express_only;
$thumbs_dir_local=ADMIN_PATH_PREFIX.DIR_WS_THUMBNAIL_IMAGES;
$thumbs_dir_remote=$catalog_dir_remote.DIR_WS_THUMBNAIL_IMAGES;
$original_dir_local=ADMIN_PATH_PREFIX.DIR_WS_ORIGINAL_IMAGES;
$original_dir_remote=$catalog_dir_remote.DIR_WS_ORIGINAL_IMAGES;
//$currencies=new currencies();
$rab='>';
$comma_blank=COMMA.BLANK;
$dot_blank=DOT.BLANK;
$transfer_text='transfer';
$cod_text='cod';
$cop_text='cop';
$creditcard_text='creditcard';
$paypal_text='paypal';
$cc_text='cc';
$de_text='de';
$at_text='at';
$ch_text='ch';
$title_text='title';
$subtitle_text='subtitle';
$cat1_text='cat1';
$cat2_text='cat2';
$auction_text='auction';
$express_text='express';
$duration_text='duration';
$quantity_text='quantity';
$startprice_text='startprice';
$binprice_text='binprice';
$location_text='location';
$country_text='country';
$starttime_text='starttime';
$rebuild_text='rebuild';
//$city_text='city';
$use_gallery_pic_text='use_gallery_pic';
$description_text='description';
$description_template_text=$description_text.UNDERSCORE.$template_text;
$products_description_text='products_description';
$category_id_text='categorie_id';
$categories_id_text='categories_id';
$express_duration_text='express_duration';
$auction_type_text='auction_type';
$display_visible_text='block';
$display_hidden_text='none';
$div_text='_div';
$category_id=$_POST[$category_id_text];
$product_id_text='product_id';
$predef_id_text='predef_id';
$products_id_text='products_id';
$product_id=$_POST[$product_id_text];
$search=$_POST['search'];
if ($product_id)
{
	$choose=$_POST['choose'];
}
$edit=$_POST['edit'];
$rebuild=$_POST[$rebuild_text];
if (!$rebuild)
{
	$addItem=$_POST['addItem'];
	$saveItem=$_POST['saveItem'];
	$updateItem=$_POST['updateItem'];
}
$id_text='id';
$text_text='text';
$id=$_POST[$id_text];
$categories=array(array($id_text => EMPTY_STRING, $text_text => TEXT_ALL_CATEGORIES));
$categories=olc_get_categories($categories, 0, EMPTY_STRING);
$form_name='categories_form';
$sep='\',\'';
$onchange=' onchange="'.$form_name.'.submit()'.QUOTE;
$hidden_text='_hidden';

$template_text='template';
$auto_resubmit_text='auto_resubmit';
$images_dir=$catalog_dir_remote.DIR_WS_PRODUCT_IMAGES;
$template_dir=ADMIN_PATH_PREFIX.TEMPLATE_PATH.CURRENT_TEMPLATE_MODULE.'ebay'.SLASH;
if (!is_dir($template_dir))
{
	if (CHECK_UNIFIED_TEMPLATES)
	{
		$template_dir=str_replace(FULL_CURRENT_TEMPLATE,FULL_COMMON_TEMPLATE,$template_dir);
		$notemplate=!is_dir($template_dir);
	}
	else
	{
		$notemplate=true;
	}
	if ($notemplate)
	{
		my_error_handler(E_USER_ERROR,AUCTIONS_LIST_ERROR_NO_TEMPLATE.$template_dir.QUOTE);
	}
}
//check for errors, and set values
if ($category_id || $choose || $search)
{
	//get all products for dropdown
	if (!$search && ($category_id && $category_id<>TEXT_ALL_CATEGORIES))
	{
		$cat_table=", ".TABLE_PRODUCTS_TO_CATEGORIES . " p2c ";
		$cat_where="
		 and
		 p2c.products_id=p.products_id and
		 p2c.categories_id='" . $category_id . APOS;
	}
	else
	{
		$cat_table=EMPTY_STRING;
		if ($search)
		{
			$like=" LIKE '%".$search."%'";
			$cat_where="
			 and (
			 pd.products_name".$like." or
			 pd.products_short_description".$like." or
			 pd.products_description".$like.RPAREN;
		}
		else
		{
			$cat_where=EMPTY_STRING;
		}
	}
	$sqlstring=SELECT."
	p.products_id product_id,
	pd.products_name
	from " .
	TABLE_PRODUCTS . " p, " .
	TABLE_PRODUCTS_DESCRIPTION . " pd".$cat_table."
	where
	p.products_status=1 and
	pd.products_id=p.products_id and
	pd.language_id='" . SESSION_LANGUAGE_ID .APOS.
	$cat_where. "
	order by pd.products_name";

	$selectproducts=olc_db_query($sqlstring);
	if ($search)
	{
		$search_results=olc_db_num_rows($selectproducts);
		$search_ok=$search_results>0;
	}
	else
	{
		$search_ok=true;
	}
	if ($search_ok)
	{
		//Prepare products array
		$products_name_text='products_name';
		$products=array();
		if ($search_results==1)
		{
			//One result on search, open product directly
			$choose=true;
			$myproducts_values=olc_db_fetch_array($selectproducts);
			$product_id=$myproducts_values[$product_id_text];
			$products[]=array(
				$id_text => $product_id,
				$text_text => $myproducts_values[$products_name_text]
			);
			$sqlstring=SELECT.$categories_id_text.SQL_FROM.TABLE_PRODUCTS_TO_CATEGORIES .
			SQL_WHERE.$products_id_text.EQUAL.$product_id;
			$selectcategory=olc_db_query($sqlstring);
			$selectcategory=olc_db_fetch_array($selectcategory);
			$category_id=$selectcategory['categories_id'];
		}
		else
		{
			$products[]=array($id_text => EMPTY_STRING, $text_text => PULL_DOWN_DEFAULT);
			while ($myproducts_values=olc_db_fetch_array($selectproducts))
			{
				$products[]=array(
					$id_text => $myproducts_values[$product_id_text],
					$text_text => $myproducts_values[$products_name_text]
				);
			}
		}
	}
	else
	{
		$error_total=true;
		$error_search=true;
	}
	if ($product_id)
	{
		//get auction types
		$sqlstring_type=SELECT_ALL.TABLE_EBAY_AUCTIONTYPE;
		if ($ebay_express_only)
		{
			$sqlstring_type.=SQL_WHERE.$description_text." LIKE '%eBay Express%'";
		}
		$selecttype=olc_db_query($sqlstring_type);
		if ($ebay_express_only)
		{
			$mytype_values=olc_db_fetch_array($selecttype);
			$ebay_express_type=$mytype_values[$id_text];
		}
		else
		{
		//Get auction types
			$types=array();
			while ($mytype_values=olc_db_fetch_array($selecttype))
			{
				$types[]=array(
				$id_text => $mytype_values[$id_text],
				$text_text => $mytype_values[$description_text]
				);
			}
		}
		//get all countries
		$countries_iso_code_2_text='countries_iso_code_2';
		$countries_id_text='countries_id';
		$countries_name_text='countries_name';
		$sqlstring_countries=SELECT_ALL.TABLE_COUNTRIES;
		$selectcountries=olc_db_query($sqlstring_countries);
		$countries=array();
		while ($mycountries_values=olc_db_fetch_array($selectcountries))
		{
			$countries_iso_code_2=$mycountries_values[$countries_iso_code_2_text];
			$country_id=$mycountries_values[$countries_id_text];
			if ($country_id==STORE_COUNTRY)
			{
				$default_country=$countries_iso_code_2;
			}
			$countries[]=array(
				$id_text => $countries_iso_code_2,
				$text_text => $mycountries_values[$countries_name_text]
			);
		}
		//predefine store country
		if (!$country)
		{
			$country=$default_country;
		}
		$products_values[$country_text]=$country;
	}
}
if ($choose || $edit)
{
	//if choose is clicked - get all infos of chosen shop product
	//Check for multiple pictures
	$have_multi_pic=false;
	$have_multi_pic_error=false;
	$multi_pictures=array();
	if ($choose)
	{
		$tables=TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd";
		$productssql=SELECT.$products_id_text.SQL_FROM.TABLE_EBAY_PRODUCTS.SQL_WHERE.$products_id_text.EQUAL.$product_id;
		$myproducts=olc_db_query($productssql);
		if (olc_db_num_rows($myproducts)>0)
		{
			$tables.=", ".TABLE_EBAY_PRODUCTS." ep";
			$auction_description='ep.auction_description description,';
			$auction_condition='
			ep.products_id=p.products_id AND';
		}
		$productssql=SELECT."
		p.products_id product_id,
		p.products_image pic_url,
		p.products_price binprice,
	  p.products_vpe,
	  p.products_vpe_status,
	  p.products_vpe_value,
		p.products_min_order_quantity,
		p.products_min_order_vpe,
	  p.products_baseprice_show,
	  p.products_baseprice_value,
		pd.products_name title,
		pd.products_description,
		pd.products_short_description subtitle,
		".$auction_description."
		p.products_tax_class_id
		FROM ".$tables."
		WHERE
		p.products_status=1 AND
		p.products_id='".$product_id. "' AND
		".$auction_condition."
		pd.products_id=p.products_id AND
		pd.language_id='". SESSION_LANGUAGE_ID."'
		ORDER BY pd.products_name";

		$myproducts=olc_db_query($productssql);
		$products_values=olc_db_fetch_array($myproducts);
		if ($products_values[$description_text])
		{
			$stored_description=true;
		}
		else
		{
			$products_values[$description_text]=$products_values[$products_description_text];
		}
		$products_min_order_quantity=$products_values['products_min_order_quantity'];

		//$quantity=max(1,$products_min_order_quantity);
		$quantity=1;
		$products_values[$quantity_text]=$quantity;
		$pic_file_name=$products_values[$pic_url_text];
		$gallery_pic_file_name=$pic_file_name;
		$pic_url=$images_dir.$pic_file_name;
		$gallery_pic_url=$pic_url;
		$products_values[$gallery_pic_url_text]=$pic_url;
		$products_values[$pic_url_text]=$pic_url;
		$startprice=abs($products_values[$binprice_text]);
		$special_price=abs(olc_get_products_special_price($product_id));
		if ($special_price)
		{
			$startprice=min($startprice,abs($special_price));
		}
		$products_tax_rate=olc_get_tax_rate($products_values['products_tax_class_id']);
		if ((int)$products_tax_rate>0)
		{
			$t=100+$products_tax_rate;
			$startprice=($startprice*$t)/100;
		}
		$t=max($quantity,$products_min_order_quantity);
		$startprice=$startprice*$t;
		$products_values[$binprice_text]=round($startprice,CURRENCY_DECIMAL_PLACES);
		$olPrice=round($startprice*.5,CURRENCY_DECIMAL_PLACES);
		$products_values[$startprice_text]=$olPrice;
		$products_values[$country_text]=$country;
		include_once (DIR_FS_INC.'olc_get_vpe_and_baseprice_info.inc.php');
		$vpe=array();
		olc_get_vpe_and_baseprice_info($vpe,$products_values,$olPrice,true);
		$min_order_quantity=$vpe['PRODUCTS_MIN_ORDER_QTY'];
		if ($min_order_quantity)
		{
			$min_order_quantity=BLANK.$min_order_quantity;
		}
		$base_price=$vpe['PRODUCTS_BASEPRICE'];
		$vpe=$vpe['PRODUCTS_VPE'];
		if ($vpe)
		{
			$vpe=BOX_PRODUCTS_VPE.COLON.$vpe;
		}
		$products_values[$bold_text]=ZERO_STRING;
		$products_values[$highlight_text]=ZERO_STRING;
		$products_values[$border_text]=ZERO_STRING;
		$products_values[$transfer_text]=ONE_STRING;
		$products_values[$cod_text]=ONE_STRING;
		$products_values[$cop_text]=ONE_STRING;
		$products_values[$paypal_text]=ONE_STRING;
		$products_values[$cc_text]=ZERO_STRING;
		$products_values[$de_text]=ONE_STRING;
		$products_values[$at_text]=ONE_STRING;
		$products_values[$ch_text]=ONE_STRING;
		$products_values[$use_gallery_pic_text]=ZERO_STRING;
		$products_values[$gallery_pic_plus]=ZERO_STRING;
		$products_values[$auto_resubmit_text]=ONE_STRING;
		$products_values[$template_text]='ebay_standard';
		$products_values[$rebuild_text]=ZERO_STRING;
		$products_values[$duration_text]=7;

	}//get values of auction template
	else	// if ($edit)
	{
		$productssql=SELECT_ALL.TABLE_AUCTION_PREDEFINITION.SQL_WHERE.$predef_id_text.EQUAL.$id;
		$myproducts=olc_db_query($productssql);
		$products_values=olc_db_fetch_array($myproducts);
		$stored_description=true;
		$predefined_data=true;
		$cat1=$products_values[$cat1_text];
		if ($cat1)
		{
			$cat1=getCategoryPath($cat1);
			$cat1=revertCategoryPath($cat1);
		}
		$cat2=$products_values[$cat2_text];
		if ($cat2)
		{
			$cat2=getCategoryPath($cat2);
			$cat2=revertCategoryPath($cat2);
		}
		//check for multiple pictures
		//All file-names are packed into one field
		$multi_picfile_names=explode('|',$products_values[$pic_url_text]);
		$n=sizeof($multi_picfile_names);
		if ($n>1)
		{
			$products_values[$pic_url_text]=$multi_picfile_names[0];
			$error_multi_pic=array();
			for ($i=1;$i<$n;$i++)
			{
				$multi_picfile_name=$multi_picfile_names[$i];
				if (!file_exists($original_dir_local.$multi_picfile_name))
				{
					$error_total=true;
					$error_multi_pic[]=$i;
					$have_multi_pic_error=true;
				}
				else
				{
					$have_multi_pic=true;
					$multi_pictures[]=$multi_picfile_name;
				}
			}
			if (!$have_multi_pic)
			{
				unset($multi_pictures);
			}
		}
	}
	// set values
	$product_id=$products_values[$product_id_text];
	$auction_type=$products_values[$auction_type_text];
	$cat_path=EMPTY_STRING;
	$categories_path=array();
	olc_get_parent_categories($categories_path,$category_id);
	$categories_path[]=$category_id;
	for ($i=0,$n=sizeof($categories_path);$i<$n;$i++)
	{
		if ($cat_path)
		{
			$cat_path.=DASH;
		}
		$cat=$seo_categories[$categories_path[$i]];
		$cat=strtoupper(substr($cat,0,1)).substr($cat,1);
		$cat_path.=$cat;
	}
	$product_title=$cat_path.COLON.BLANK.$products_values[$title_text];
	$product_title=str_replace(HTML_BR,BLANK,$product_title);
	$product_title=strip_tags($product_title);
	$product_subtitle=$products_values[$subtitle_text];
	$product_subtitle=str_replace(HTML_BR,BLANK,$product_subtitle);
	$product_subtitle=strip_tags($product_subtitle);
	$products_description=$products_values[$description_text];
	if (!$products_description)
	{
		$products_description=$products_values[$products_description_text];
	}
	//$description_template=ONE_STRING;
	$duration=$products_values[$duration_text];
	$quantity=$products_values[$quantity_text];
	$auction=ONE_STRING;
	$express=ONE_STRING;
	$express_duration=ONE_STRING;
	$startprice=$products_values[$startprice_text];
	$buyitnow_price=$products_values[$binprice_text];
	$location=$products_values[$location_text];
	$country=$products_values[$country_text];
	$pic_url=$products_values[$pic_url_text];
	$gallery_pic_url=$products_values[$gallery_pic_url_text];
	$use_gallery_pic=$products_values[$use_gallery_pic_text];
	$bold=$products_values[$bold_text];
	$highlight=$products_values[$bold_text];
	$border=$products_values[$border_text];
	$cod=$products_values[$cod_text];
	$cop=$products_values[$cop_text];
	$cc=$products_values[$cc_text];
	$paypal=$products_values[$paypal_text];
	if (EBAY_PAYPAL_EMAIL_ADDRESS==EMPTY_STRING)
	{
		$error_total=true;
		$error_paypal=true;
	}
	$de=$products_values[$de_text];
	$ship2de=$de==ONE_STRING;
	$at=$products_values[$at_text];
	$ship2at=$at==ONE_STRING;
	$ch=$products_values[$ch_text];
	$ship2ch=$ch==ONE_STRING;

	$template=$products_values[$template_text];
	$rebuild=$products_values[$rebuild_text];
}
elseif ($addItem || $saveItem || $updateItem)
{
	$error_total=false;
	$error_title=false;
	$error_cat=false;
	$error_submit=false;
	$error_desc=false;
	$error_dur=false;
	$error_starttime=false;
	$error_quantity_1=false;
	$error_quantity_2=false;
	$error_quantity_3=false;
	$error_startprice=false;
	$error_fixprice=false;
	$error_location=false;
	$error_country=false;
	$error_pic=false;
	$error_gallerypic=false;
	$error_payment=false;
	$error_attributes=false;
	//set auction type
	$auction_type=$_POST[$auction_type_text];
	$auction_type_name=EMPTY_STRING;
	$my_selecttype=olc_db_query(SELECT_ALL.TABLE_EBAY_AUCTIONTYPE);
	while ($mytype_values=olc_db_fetch_array($my_selecttype))
	{
		if ($mytype_values[$id_text]==$auction_type)
		{
			$auction_type_name=$mytype_values['name'];
			break;
		}
	}
	//set productid and title
	$product_id=$_POST[$product_id_text];
	$product_title=stripcslashes($_POST[$title_text]);
	//title error
	if ($product_title==EMPTY_STRING)
	{
		$error_total=true;
		$error_title=true;
	}
	$product_title=stripcslashes($product_title);
	$product_subtitle=stripcslashes($_POST[$subtitle_text]);
	//set 1st category for ebay listing
	$cat1=$_POST[$cat1_text];
	//cat error
	if (!$cat1)
	{
		$error_total=true;
		$error_cat=true;
	}
	//set 2nd category for ebay listing
	$cat2=$_POST[$cat2_text];
	//set duration of ebay listing
	$auction=$_POST[$auction_text];
	$express=$_POST[$express_text];
	if (!$auction)
	{
		if (!$express)
		{
			$error_total=true;
			$error_submit=true;
		}
	}
	//set duration of ebay listing
	$duration=$_POST[$duration_text];
	//duration error
	if ($auction_type==9 && $duration)
	{
		$error_total=true;
		$error_dur=true;
	}
	else
	{
		$duration='Days_'.$duration;
	}
	$express_duration=$_POST[$express_duration_text];
	$is_gtc=$express_duration==ONE_STRING;
	if ($is_gtc)
	{
		$duration="GTC";
	}
	else
	{
		$duration='Days_'.$duration;
	}
	//set product description
	$products_description=stripcslashes($_POST[$products_description_text.UNDERSCORE.SESSION_LANGUAGE_ID]);
	//desc error
	if (!$products_description)
	{
		$error_total=true;
		$error_desc=true;
	}
	$products_description=stripcslashes($products_description);
	//set quantity
	$quantity=$_POST[$quantity_text];
	//quantity error
	if ($quantity==EMPTY_STRING || $quantity<1)
	{
		$error_total=true;
		$error_quantity_3=true;
	}
	elseif ($auction_type==1 && $quantity>1)
	{
		$error_total=true;
		$error_quantity_1=true; //chinese auction max. 1 product
	}
	else if ($auction_type==2 && $quantity<2)
	{
		$error_total=true;
		$error_quantity_2=true;
	} //dutch min. 2 products
	//set startprice
	$startprice=$_POST[$startprice_text];
	//startprice error
	if ($auction_type==1 && $startprice==EMPTY_STRING)
	{
		$error_total=true;
		$error_startprice=true;
	}
	$buyitnow_price=$buyitnow_price!=EMPTY_STRING;
	//fixprice error
	if ($auction_type==9 && $buyitnow_price==EMPTY_STRING)
	{
		$error_total=true;
		$error_fixprice=true;
	}//fix price auction must have a startprice
	//set location
	$location=$_POST[$location_text];
	//location error
	if ($location == EMPTY_STRING)
	{
		$error_total=true;
		$error_location=true;
	}
	//set country
	$country=$_POST[$country_text];
	//set starttime
	$mystarttime=$_POST[$starttime_text];
	if ($mystarttime)
	{
		$future_auction=true;
		if (eregi("[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}",$mystarttime))
		{//look if starttime is correct
			$mytime=substr($mystarttime,11);
			$starttime_array=explode(":",$mytime);
			$mydate=substr($mystarttime,0,10);
			$startdate_array=explode("-",$mydate);
			//makte GTM Time of GTM+1
			$mynewstarttime=toGMT(date(AUCTIONS_DATE_FORMAT,
			mktime($starttime_array[0],$starttime_array[1],$starttime_array[2],$startdate_array[1],
			$startdate_array[2],$startdate_array[0])));
		}
		else
		{
			//starttime error
			$error_total=true;
			$error_starttime=true;
		}
	}
	//set pic_url
	//We don't really need the pictures on the server as they are already there,
	//but it is more convenient to use a "file" input for picture selection.
	//They are transferred to the "temp" directory and get deleted after selection.
	$temp_dir=DIR_FS_CATALOG.'cache/cache';

	$pic_url = new upload($pic_url_text, $temp_dir);
	$pic_url=$pic_url['filename'];
	if ($pic_url)
	{
		$pic_file_name=basename($pic_url);
		@unlink($temp_dir.$pic_file_name);
	}
	else
	{
		$pic_url=$_POST[$pic_url_text.$hidden_text];
		$pic_file_name=basename($pic_url);
	}
	if ($pic_file_name==EMPTY_STRING)
	{
		$error_total=true;
		$error_pic=true;
	}
	else if (!file_exists($original_dir_local.$pic_file_name))
	{
		$error_total=true;
		$error_pic=true;
	}
	else
	{
		$pic_url=$images_dir.$pic_file_name;
		//Check for multiple pictures
		$have_multi_pic=false;
		$have_multi_pic_error=false;
		$multi_pictures=array();
		$error_multi_pic=array();
		$s=$pic_url_text.UNDERSCORE;
		$i=1;
		while (true)
		{
			$multi_pic_url_text=$s.$i;
			$multi_pic_url = new upload($multi_pic_url_text, $temp_dir);
			$multi_pic_url=$multi_pic_url['filename'];
			if ($multi_pic_url)
			{
				$multi_picfile_name=basename($multi_pic_url);
				@unlink($temp_dir.$multi_picfile_name);
			}
			else
			{
				$multi_pic_url=$_POST[$multi_pic_url_text.$hidden_text];
				$multi_picfile_name=basename($multi_pic_url);
			}
			if ($multi_picfile_name==EMPTY_STRING)
			{
					break;
			}
			else if (!file_exists($original_dir_local.$multi_picfile_name))
			{
				$error_total=true;
				$error_multi_pic[]=$i;
				$have_multi_pic_error=true;
			}
			else
			{
				$have_multi_pic=true;
				$multi_pictures[]=$multi_picfile_name;
			}
			$i++;
		}
		if (!$have_multi_pic)
		{
			unset($multi_pictures);
		}
	}
	//set gallerypic
	$use_gallery_pic=$_POST[$use_gallery_pic_text];
	if ($use_gallery_pic)
	{
		$gallery_pic_url = new upload($gallery_pic_url_text, $temp_dir);
		$gallery_pic_url=$gallery_pic_url['filename'];
		if ($gallery_pic_url)
		{
			$gallery_pic_file_name=basename($gallery_pic_url);
			@unlink($temp_dir.$gallery_pic_file_name);
		}
		else
		{
			$gallery_pic_file_name=basename($gallery_pic_url);
		}
		if ($gallery_pic_file_name==EMPTY_STRING)
		{
			$error_total=true;
			$error_gallerypic=true;
		}
		else if (!file_exists($original_dir_local.$gallery_pic_file_name))
		{
			$error_total=true;
			$error_pic=true;
		}
		else
		{
			$gallery_pic_url=$images_dir.$gallery_pic_file_name;
			$gallery_pic_plus=$_POST[$gallery_pic_plus_text];
		}
	}
	$auto_resubmit=$_POST[$auto_resubmit_text];
	$template=$_POST[$template_text];
	$rebuild=$_POST[$rebuild_text];
	//set special highlights
	$bold=$_POST[$bold_text];
	$highlight=$_POST[$bold_text];
	$border=$_POST[$border_text];
	//set money transfer
	$cod=$_POST[$cod_text];
	$cop=$_POST[$cop_text];
	$cc=$_POST[$creditcard_text];
	$paypal=$_POST[$paypal_text];
	//payment error
	if ($cod==0 && $cop==0 && $cc==0 && $paypal==0)
	{
		$error_total=true;
		$error_payment=true;
	}
	if ($papal)
	{
		if (EBAY_PAYPAL_EMAIL_ADDRESS==EMPTY_STRING)
		{
			$error_total=true;
			$error_paypal=true;
		}
	}
	//set shipping countries
	$de=$_POST[$de_text];
	$ship2de=$de==ONE_STRING;
	$at=$_POST[$at_text];
	$ship2at=$at==ONE_STRING;
	$ch=$_POST[$ch_text];
	$ship2ch=$ch==ONE_STRING;

	$stored_description=true;
	$predefined_data=true;
	if (!$error_total)
	{
		$pos=strpos($cat1,LPAREN);
		if ($pos)
		{
			$cat1=substr($cat1,$pos);
		}
		if ($cat2)
		{
			$pos=strpos($cat2,LPAREN);
			if ($pos)
			{
				$cat2=substr($cat2,$pos);
			}
		}
		//send auction to ebay
		if ($addItem)
		{
			require_once $ebatns_dir.'EbatNs_ServiceProxy.php';
			require_once $ebatns_dir.'EbatNs_Logger.php';
			require_once $ebatns_dir.'VerifyAddItemRequestType.php';
			require_once $ebatns_dir.'AddItemRequestType.php';
			require_once $ebatns_dir.'ItemType.php';
			require_once $ebatns_dir.'ListingEnhancementsCodeType.php';
			require_once $ebatns_dir.'BuyerPaymentMethodCodeType.php';
			require_once $ebatns_dir.'CountryCodeType.php';
			$session=create_ebay_session();
			if ($session)
			{
				$ListingEnhancementsCodeType=new BuyerPaymentMethodCodeType;
				$PaymentMethodCode=new BuyerPaymentMethodCodeType;
				$CountryCodeType=new CountryCodeType;
				$cs=new EbatNs_ServiceProxy($session);
				$item=new ItemType();
				//auction type
				$item->setListingType($auction_type_name);
				$item->Currency=DEFAULT_CURRENCY; //currency
				$item->Site='Germany'; //site (ebay.de)
				//use sheduling if there is one
				if (isset($future_auction))
				{
					$item->setScheduleTime($mynewstarttime);
				}
				//set title
				$product_title=stripcslashes($product_title);
				$product_title=striptags($product_title);
				$item->Title=$product_title;
				//set subtitle
				$product_title=stripcslashes($product_subtitle);
				$product_title=striptags($product_subtitle);
				$item->setSubTitle($product_subtitle);
				//set 1st category
				$item->PrimaryCategory=new CategoryType();
				$item->PrimaryCategory->CategoryID=$cat1;
				//set 2nd category
				$pos=strpos($cat1,LPAREN);
				if ($pos)
				{
					$cat1=substr($cat1,$pos);
				}
				if ($cat2)
				{
					$item->SecondaryCategory=new CategoryType();
					$item->SecondaryCategory->CategoryID=$cat2;
				}
				//set description
				$item->Description=$products_description;
				//set duration
				$item->ListingDuration=$duration;
				//set quantity
				$item->Quantity=$quantity;
				//set prices - depending on auction type
				$currencyID_text='currencyID';
				$buyitnow_price=number_format($buyitnow_price,CURRENCY_DECIMAL_PLACES,DOT,EMPTY_STRING);
				if ($auction_type >= 9)
				{
					$item->StartPrice=new AmountType();
					$item->StartPrice->setTypeAttribute($currencyID_text, DEFAULT_CURRENCY);
					$item->StartPrice->setTypeValue($buyitnow_price);
				}
				else
				{
					$item->StartPrice=new AmountType();
					$item->StartPrice->setTypeAttribute($currencyID_text, DEFAULT_CURRENCY);
					$item->BuyItNowPrice=new AmountType();
					$item->BuyItNowPrice->setTypeAttribute($currencyID_text, DEFAULT_CURRENCY);
					$item->StartPrice->setTypeValue(number_format($startprice,CURRENCY_DECIMAL_PLACES,DOT,EMPTY_STRING));
					if ($buyitnow_price)
					{
						$item->BuyItNowPrice->setTypeValue($buyitnow_price);
					}
				}
				//set location
				$item->Location=$location;
				//set country
				$item->Country=$country;
				//set picures
				$item->PictureDetails=new PictureDetailsType();
				$pic1=$thumbs_dir_remote.$pic_file_name;
				if ($have_multi_pic)
				{
					$item->PictureDetails->PictureURL=array();
					$item->PictureDetails->PictureURL[]=$pic1;
					for ($i=1,$n=sizeof($multi_pictures);$i<$n;$i++)
					{
						$item->PictureDetails->PictureURL[]=$thumbs_dir_remote.$multi_pictures[$i];
					}
				}
				else
				{
					$item->PictureDetails->PictureURL=$pic1;
				}
				$item->PictureDetails->setGalleryType('Gallery');
				$item->PictureDetails->setGalleryURL($thumbs_dir_remote.$gallery_pic_file_name);
				//set special highlights
				if ($bold)
				{
					$item->ListingEnhancement[]=$ListingEnhancementsCodeType->BoldTitle;
				}
				if ($highlight)
				{
					$item->ListingEnhancement[]=$ListingEnhancementsCodeType->Highlight;
				}
				if ($border)
				{
					$item->ListingEnhancement[]=$ListingEnhancementsCodeType->Border;
				}
				if ($cod)
				{
					$item->PaymentMethods[]=$PaymentMethodCode->COD;
				}
				if ($cop)
				{
					$item->PaymentMethods[]=$PaymentMethodCode->CashOnPickup;
				}
				if ($cc)
				{
					$item->PaymentMethods[]=$PaymentMethodCode->CCAccepted;
				}
				if ($paypal)
				{
					$item->PaymentMethods[]=$PaymentMethodCode->PayPal;
					$item->PayPalEmailAddress = EBAY_PAYPAL_EMAIL_ADDRESS;
				}
				//set shipping locations
				if ($ship2de)
				{
					$item->ShipToLocations[]=$CountryCodeType->DE;
				}
				if ($ship2at)
				{
					$item->ShipToLocations[]=$CountryCodeType->AT;
				}
				if ($ship2ch)
				{
					$item->ShipToLocations[]=$CountryCodeType->CH;
				}
				$item->setCheckoutSpecified(0);
				$item->setCheckoutInstructions(utf8_encode(AUCTIONS_TEXT_AFTERBUY));
				$item->AssignUUID();

				//First test all OK!
				$request='VerifyAddItem';
		    $req = new VerifyAddItemRequestType();
				//add item to request
				$req->Item=$item;
				$req->ErrorLanguage='de_DE';
				//send item and get result from ebay
				$res=$cs->VerifyAddItem($req);
				if ($res->getAck() == $Facet_AckCodeType->Success)
				{
					$request='AddItem';
					$req=new AddItemRequestType();
					//add item to request
					$req->ErrorLanguage='de_DE';
					$req->Item=$item;
					//send item and get result from ebay
					$res=$cs->AddItem($req);
				}
				//look if there was an error
				if ($res->getAck() != $Facet_AckCodeType->Success)
				{
					$error_xfer_text=EMPTY_STRING;
					foreach ($res->getErrors() as $error)
					{
						//$messageStack->add($request.': '.$error->getShortMessage()." - ".$error->getLongMessage(), 'error');
						if ($error_xfer_text)
						{
							$error_xfer_text.=HTML_BR;
						}
						$error_xfer_text.=$error->getShortMessage()." - ".$error->getLongMessage();
					}
					if ($error_xfer_text)
					{
						$error_xfer_text=HTML_B_START.$request.HTML_B_END.HTML_BR.HTML_BR.$error_xfer_text;
					}
					$error_total=true;
					$error_xfer=true;
				}
				else
				{
					$pic_url=basename($pic_url);
					$gallery_pic_url=basename($gallery_pic_url);
					//get id from ebay listing
					$auction_id=$res->getItemID();
					$resultstring=$auction_id." | ";
					//get set endtime
					$resultstring .= $res->getEndTime();
					$resultstring .=  HTML_HR;
					$resultstring .= sprintf(AUCTIONS_TEXT_XFER_OK,$auction_id). HTML_BR;
					$resultstring .= HTML_A_START.olc_href_link($getItem_text.$auction_id).$rab.AUCTIONS_TEXT_SHOW_ITEM. HTML_A_END;
					//set a link to ebay
					$resultstring .= HTML_BR.HTML_A_START.
					olc_href_string(EBAY_SERVER,EBAY_VIEWITEM.$auction_id).$rab.AUCTIONS_TEXT_SHOW_PRODUCT. HTML_A_END;
					//Insert in Auction List (DB)
					if ($auction_id)
					{
						$comma="','";
						$sqlstring =
						INSERT_INTO .TABLE_AUCTION_LIST ."
						 (".
								$auction_title_text.$comma.
								$auction_title_text.$comma.
								$product_id_text.$comma.
								$predef_id_text.$comma.
								$quantity_text.$comma.
								$startprice_text.$comma.
								"buynowprice".$comma.
								"buynow".$comma.
								"gtc".$comma.
								$starttime_text.$comma.
								"endtime".$comma.
								"ended
							)
							VALUES
							(".
								$auction_id.$comma.
								addslashes($product_title).$comma.
								$product_id.$comma.
								$id.$comma.
								$quantity.$comma.
								$startprice.$comma.
								$buyitnow_price.$comma.
								$buyitnow_price.$comma.
								$is_gtc.$comma.
								$res->getStartTime().$comma.
								$res->getEndTime()."','0')";
						$auctions_insert=olc_db_query($sqlstring);
						//set eBay products description
						$where=SQL_WHERE.$product_id_text.EQUAL.$product_id;
						$sqlstring = SELECT.$product_id_text. SQL_FROM.TABLE_EBAY_PRODUCTS.$where;
						$auction_description_text='auction_description';
						$products_description=APOS.olc_db_prepare_input($products_description).APOS;
						$auctions_insert=olc_db_query($sqlstring);
						if (olc_db_num_rows($auctions_insert)>0)
						{
							$sqlstring = SQL_UPDATE . " SET ".$auction_description_text.EQUAL.$products_description.$where;
						}
						else
						{
							$sqlstring = INSERT_INTO	. TABLE_EBAY_PRODUCTS."
							(".$product_id_text.$comma.$auction_description_text.")
							VALUES
							(".$product_id.$comma.$products_description.RPAREN;
						}
					}
					olc_redirect(olc_href_link(FILENAME_AUCTIONS_LIST_RUNNING));
				}
			}
			else
			{
				$error_total=true;
				$error_ebay_session=true;
			}
		}
		else
		{
			//if there is no error - and you don't wanna send it to ebay - just save a template
			if ($have_multi_pic)
			{
				//Pack all file-names into one field
				$pic_file_name.='|'.implode($multi_pictures,'|');
			}
			$sql_data_array=array(
			$product_id_text => $product_id,
			$auction_type_text => $auction_type,
			$title_text => olc_db_prepare_input($product_title),
			$subtitle_text => olc_db_prepare_input($product_subtitle),
			$cat1_text => olc_db_prepare_input($cat1),
			$cat2_text => olc_db_prepare_input($cat2),
			$auction_text => $auction,
			$express_text => $express,
			$express_duration_text => $express_duration,
			$description_text => olc_db_prepare_input($products_description),
			$description_template_text => $description_template,
			$duration_text => $duration,
			$quantity_text => $quantity,
			$startprice_text => $startprice,
			$binprice_text => $buyitnow_price,
			$location_text => olc_db_prepare_input(utf8_decode($location)),
			$country_text => $country,
			$pic_url_text => olc_db_prepare_input($pic_file_name),
			$gallery_pic_url_text => olc_db_prepare_input($gallery_pic_file_name),
			$gallery_pic_plus_text => $gallery_pic_plus,
			$auto_resubmit_text => $auto_resubmit,
			$bold_text => $bold,
			$bold_text => $highlight,
			$border_text => $border,
			$cod_text => $cod,
			$cop_text => $cop,
			$paypal_text => $paypal,
			$cc_text => $cc,
			$de_text => $de,
			$at_text => $at,
			$ch_text => $ch,
			$template_text => olc_db_prepare_input($template)
			);
			$parameters=$predef_id_text.EQUAL.$id.APOS;
			$predefined_query=SELECT.$predef_id_text.SQL_FROM .TABLE_AUCTION_PREDEFINITION.SQL_WHERE.$parameters;
			$predefined_query=olc_db_query($predefined_query);
			if (olc_db_num_rows($predefined_query)>0)
			{
				//update template
				$command='update';
			}
			else
			{
				//save template
				$command=EMPTY_STRING;
				$parameters=EMPTY_STRING;
			}
			olc_db_perform(TABLE_AUCTION_PREDEFINITION, $sql_data_array, $command, $parameters);
		}
		$resultstring=EMPTY_STRING;
		$search_and_search_ok=false;
		$error_search=false;
		$product_id=EMPTY_STRING;
	}
}
$size='size="';
$size_100=$size.'100'.QUOTE;
$search_and_search_ok=$search!=EMPTY_STRING and $search_ok;
$action_edit_field=olc_draw_hidden_field('action','edit');
$content=olc_draw_pull_down_menu($category_id_text,$categories,$category_id,$onchange);
if ($category_id || $search_and_search_ok)
{
	$content.=
	HTML_NBSP.HTML_NBSP.BOX_ENTRY_PRODUCTS.HTML_NBSP.
	olc_draw_pull_down_menu($product_id_text,$products,$product_id,$onchange);
}
$content.=HTML_NBSP.HTML_NBSP.olc_draw_submit_button("choose",AUCTIONS_TEXT_SUBMIT_SELECT);
$content.=HTML_BR.HTML_BR.IMAGE_SEARCH.HTML_NBSP.BOX_ENTRY_PRODUCTS.HTML_NBSP.
olc_draw_input_field('search',$search,$size_100).HTML_NBSP.
olc_image_submit('button_quick_find.gif', BOX_HEADING_SEARCH);
if ($error_search)
{
	$content.=HTML_NBSP.SPAN_START.'class="errorText">'.sprintf(AUCTIONS_LIST_ERROR_SEARCH,$search).SPAN_END;
}
$table_start='
	<table border="0" width="100%" cellspacing="0" cellpadding="2" class="dataTableRow">
';
$form_end='</form>';
$table_end_form_end='
	</table>
'.$form_end;
$main_content=EMPTY_STRING;
if ($resultstring)
{
	$main_content.='
<span class="smallText">'.$resultstring.'</span><br/><br/>
';
}
$main_content.=
olc_draw_form($form_name,FILENAME_AUCTIONS_NEW,EMPTY_STRING).$action_edit_field.
	$table_start;
		//display_section_header(AUCTIONS_TEXT_ARTICLE);
		display_section_content_line(ENTRY_CATEGORIES,$content,true);
		$main_content.=
	$table_end_form_end;
if ($product_id)
{
	$size_10=$size.'10'.QUOTE;
	$size_50=$size.'50'.QUOTE;
	$form_name="auction_data";
	$templates=olc_get_templates($template_dir,true);
	$content_template=olc_draw_pull_down_menu($template_text,$templates,$template,$onchange);
	$products_description=$myproducts[$description_text];
	$products_description=(($products_description) ? stripslashes($products_description) :
	olc_get_products_description($product_id, SESSION_LANGUAGE_ID));
	if (!$predefined_data || $rebuild)
	{
		if ($base_price)
		{
			$base_price=str_replace ('(',$dot_blank.AUCTIONS_TEXT_BASE_PRICE,$base_price);
			$vpe=$vpe.str_replace (RPAREN,EMPTY_STRING,ltrim($base_price));
			if ($not_ebay_express_only)
			{
				$vpe.=AUCTIONS_TEXT_BASE_BASE_STARTPRICE;
			}
		}
		$vpe.=DOT;
		$products_description.=$vpe;
		if (NO_TAX_RAISED)
		{
			$price_disclaimer=PRICE_DISCLAIMER_NO_TAX;
		}
		else
		{
			if (CUSTOMER_SHOW_PRICE_TAX)
			{
				$price_disclaimer=sprintf(PRICE_DISCLAIMER_INCL,$products_tax_rate);
			}
			else
			{
				$price_disclaimer=PRICE_DISCLAIMER_EXCL;
			}
		}
		$price_disclaimer=str_replace(FILENAME_CONTENT,EBAY_REAL_SHOP_URL.FILENAME_CONTENT,$price_disclaimer);
		$price_disclaimer=HTML_BR.HTML_BR.str_replace(HTML_BR,BLANK,$price_disclaimer);
	}
	if (!$stored_description || $rebuild)
	{
		$options_name_sql = "
			select distinct
			popt.products_options_id,
			popt.products_options_name
			from " .
			TABLE_PRODUCTS_OPTIONS . " popt, " .
			TABLE_PRODUCTS_ATTRIBUTES . " patrib
			where
			patrib.products_id='" . $product_id . "' and
			patrib.options_id = popt.products_options_id and
			popt.language_id = '" . SESSION_LANGUAGE_ID . APOS;
		$products_options_name = olc_db_query($options_name_sql);
		$options_name_count=olc_db_num_rows($products_options_name);
		$has_options=$options_name_count>0;
 		if ($has_options)
		{
			$count_options_name=0;
			$option_string=AUCTIONS_TEXT_ATTRIBUTES;
			$products_options_sql0 = "
			select
			pov.products_options_values_id,
			pov.products_options_values_name,
			pa.options_values_price,
			pa.price_prefix from " .
			TABLE_PRODUCTS_ATTRIBUTES . " pa, " .
			TABLE_PRODUCTS_OPTIONS_VALUES . " pov where
			pa.products_id = '" . $product_id . "'
			and pa.options_id = '#'
			and pa.options_values_id = pov.products_options_values_id
			and pov.language_id = '" . SESSION_LANGUAGE_ID . "'
			order by pov.products_options_values_name";
			$options_names=EMPTY_STRING;
			while ($options_name_values = olc_db_fetch_array($products_options_name))
			{
				$options_name=$products_options_name_values['products_options_name'];
				$count_options_name++;
				$options_names.=$options_name.($options_name_count != $count_options_name ? $comma_blank : EMPTY_STRING);
				$option_string.=HTML_BR.HTML_B_START.$options_name.HTML_B_END.': ';
				$products_options_sql=
					str_replace(HASH,$options_name_values['products_options_id'],$products_options_sql0);
				$products_options = olc_db_query($products_options_sql);
				$count_options_values = olc_db_num_rows($products_options);
				while ($products_options_values = olc_db_fetch_array($products_options))
				{
					$option_string.=$products_options_values['products_options_values_name'];
					$options_values_price=$products_options_values['options_values_price'];
					if ((float)$options_values_price != 0)
					{
						$option_has_price=true;
						$option_string.=LPAREN . $products_options_values['price_prefix'] .
						olc_format_price($options_values_price,true,true,true). RPAREN;
					}
					$count_options++;
					$option_string .=($count_options_values != $count_options ? $comma_blank : DOT);
				}
			}
			if ($option_has_price)
			{
				$error_attributes=true;
				$error_total=true;

			}
			$products_description.=$option_string;
		}
		$template_content=@file_get_contents($template_dir.$template.HTML_EXT);
		if ($template_content)
		{
			if ($has_options)
			{
				$s=sprintf(AUCTIONS_TEXT_ATTRIBUTES_REMARK,$options_names);
			}
			else
			{
				$s=EMPTY_STRING;
			}
			$template_content=str_replace('{$prod_short}',$product_subtitle,$template_content);
			$template_content=str_replace('{$prod_name}',$product_title,$template_content);
			$template_content=str_replace('{$prod_description}',$products_description,$template_content);
			$template_content=str_replace('{$price_disclaimer}',$price_disclaimer,$template_content);
			$template_content=str_replace('{$catalog_url}',$catalog_dir_remote,$template_content);
			$template_content=str_replace('{$prod_attributes}',$s,$template_content);
			$template_content=str_replace('{$catalog_url}',$catalog_dir_remote,$template_content);
			$template_content=str_replace('{$tpl_path}',TEMPLATE_PATH.CURRENT_TEMPLATE.SLASH,$template_content);
			$template_content=str_replace('{$store_name}',STORE_NAME,$template_content);
			$products_description=str_replace('{$ebay_name}',trim(EBAY_MEMBER_NAME),$template_content);
			//Fucking SPAW-Editor does not display "&ndash;" properly!
			$products_description=str_replace(HTML_NDASH,XDASH_REPLACE,$products_description);
		}
	}
	$eval_spaw=USE_SPAW==TRUE_STRING_S;
	if ($eval_spaw)
	{
		define('SPAW_CONTROL_NAME',$products_description_text.UNDERSCORE.SESSION_LANGUAGE_ID);
		define('SPAW_CONTROL_DATA',$products_description);
		$content_spaw="
			\$sw=new SPAW_Wysiwyg(
			\$control_name=SPAW_CONTROL_NAME,	// control's name
			\$value= SPAW_CONTROL_DATA,			  // initial value
			\$lang=EMPTY_STRING,         			// language
			\$mode='full',             		  	// toolbar mode
			\$theme='default',           			// theme (skin)
			\$width='100%',              			// width
			\$height='400px',            			// height
			\$css_stylesheet=SPAW_STYLESHEET,	// css stylesheet file for content
			\$dropdown_data=EMPTY_STRING 			// data for dropdowns (style, font, etc.)
			);
			\$sw->show(true);
		";
	}
	else
	{
		$content_spaw=olc_draw_textarea_field("description", 'soft', '100', '15', $products_description);
	}
	/*
	$onclick=' onclick="javascript:SPAW_UpdateFields();preview.submit();return false;"';
	$content_preview=HTML_A_START.olc_href_link(HASH).
	'" target="_blank"'.$onclick.'><font color="red"><b>'.
	AUCTIONS_TEXT_PREVIEW.'</b></font>'.HTML_A_END;
	*/
	define('SPIFFY_DATE_FIELD_CAPTION',sprintf(AUCTIONS_TEXT_AUCTION_START_DATE,$fees[$starttime_text]));
	if (!$mystarttime)
	{
		$mystarttime=date('d.m.Y',time()+24*60*60);
	}
	define('SPIFFY_DATE',$mystarttime);
	define('SPIFFY_FORM_NAME',$form_name);
	define('SPIFFY_DATE_FIELD_NAME',$starttime_text);
	define('SPIFFY_CONTROL_NAME','date'.SPIFFY_DATE_FIELD_NAME);
	$content_cal='include("'.DIR_FS_INC.'olc_create_spiffy_control.inc.php");';
	if ($ebay_express_only)
	{
		$content_aut=olc_draw_hidden_field($auction_type_text,$ebay_express_type);
		$desc_aut=EMPTY_STRING;
	}
	else
	{
		$content_aut=olc_draw_pull_down_menu($auction_type_text,$types,$auction_type);
		$desc_aut=AUCTIONS_TEXT_AUCTION_TYPE;

		$content_auto_sub=olc_draw_checkbox_field($auto_resubmit_text,ONE_STRING,$auto_resubmit==ONE_STRING).
		AUCTIONS_TEXT_AUCTION_AUTO_SUBMIT_EXPLAIN;
	}
	$content_exp_dur=
		olc_draw_radio_field($express_duration_text,ZERO_STRING,$express_duration==ZERO_STRING).
			AUCTIONS_TEXT_AUCTION_EXPRESS_DURATION_30.HTML_NBSP.HTML_NBSP.
		olc_draw_radio_field($express_duration_text,ONE_STRING,$express_duration==ONE_STRING).
			AUCTIONS_TEXT_AUCTION_EXPRESS_DURATION_PERMANENT;
	$content_ti=olc_draw_input_field($title_text,$product_title,$size_100);
	$content_sti=olc_draw_input_field($subtitle_text,$product_subtitle,$size_100);
	$field0=olc_draw_input_field("cat~",ATSIGN,$size_100).HTML_NBSP.
		HTML_A_START.'#" onclick="javascript:loadcategories(~)">'.AUCTIONS_TEXT_SUBMIT_SELECT.HTML_A_END;
	$content_cat1=str_replace(TILDE,ONE_STRING,$field0);
	$content_cat1=str_replace(ATSIGN,$cat1,$content_cat1);
	$content_cat2=str_replace(TILDE,TWO_STRING,$field0);
	$content_cat2=str_replace(ATSIGN,$cat2,$content_cat2);
	$content_rebuild=olc_draw_checkbox_field($rebuild_text,ONE_STRING,$rebuild==ONE_STRING).
	AUCTIONS_TEXT_AUCTION_DESCRIPTION_FORCE_REBUILD_EXPLAIN;
	if ($ebay_express_only)
	{
		$content_sub=AUCTIONS_TEXT_AUCTION_EXPRESS.olc_draw_hidden_field($auction_text,ONE_STRING);
	}
	else
	{
		$content_sub=olc_draw_checkbox_field($auction_text,ONE_STRING,$auction).HTML_NBSP.AUCTIONS_TEXT_AUCTION_AUCTION;
		$content_sub.=HTML_NBSP.HTML_NBSP;
		$content_sub.=olc_draw_checkbox_field($express_text,ONE_STRING,$express).HTML_NBSP.AUCTIONS_TEXT_AUCTION_EXPRESS;
		//Prepare durations array
		$duration_days= array('1','3','5','7','10');
		$durations= array();
		for ($i=0;$i<5;$i++)
		{
			$s=$duration_days[$i];
			$durations[]=array($id_text => $s,$text_text => $s);
		}
		$content_duration=olc_draw_pull_down_menu($duration_text,$durations,$duration).
		HTML_NBSP.AUCTIONS_TEXT_AUCTION_DURATION_DAYS;
	}
	if ($error_quantity_1)
	{
		$error_quantity_text=AUCTIONS_LIST_ERROR_AMOUNT_1;
	}
	else if ($error_quantity_text_2)
	{
		$error_quantity_text=AUCTIONS_LIST_ERROR_AMOUNT_2;
	}
	else if ($error_quantity_text_3)
	{
		$error_quantity_text=AUCTIONS_LIST_ERROR_AMOUNT_3;
	}
	//$quantity=max(1,$quantity,$products_min_order_quantity);
	$content_q=olc_draw_input_field($quantity_text,$quantity,$size_10).
	HTML_BR.str_replace($dot_blank,DOT.HTML_BR,$vpe);
	$currency=HTML_NBSP.DEFAULT_CURRENCY;
	$content_s=olc_draw_input_field($startprice_text,$startprice,$size_10).$currency;
	$content_b=olc_draw_input_field($buyitnow_text,$buyitnow_price,$size_10).$currency;
	if (!$location)
	{
		$location=nl2br(STORE_NAME_ADDRESS);
		$location=explode(HTML_BR,$location);
		$location=$location[2].$comma_blank.olc_get_zone_name(STORE_COUNTRY, STORE_ZONE);
	}
	$content_l=olc_draw_input_field($location_text,$location,$size_50);
	$content_c=olc_draw_pull_down_menu($country_text,$countries,$country);
	$span_start=SPAN_START.'id="#" style="font-size:6pt">';
	$space=HTML_NBSP.HTML_NBSP.HTML_NBSP;
	$pic_table0='
<table border="0" id="~" style="display:_">
	<tr>
		<td valign="top" class="dataTableContent">#</td>
		<td valign="top" class="dataTableContent">@</td>
	</tr>
</table>
';
	$end='\')"';
	$pic_table=str_replace(UNDERSCORE,$display_visible_text,$pic_table0);
	$pic_table=str_replace(TILDE,EMPTY_STRING,$pic_table);
	$pic_display_text0='pic_display';
	$pic_display_text=$pic_display_text0;
	$onchange0='onchange="adjust_picture(this,\'';
	$dummy_span='<span></span>';			//Do  n o t  remove!!!!!!
	$id_is='id="';
	$onclick0='onclick="javascript:show_hide(this,\'';
	$pic_table_text0=$pic_text.'_table_';
	$onchange=$onchange0.	$pic_display_text.HASH.$sep.$pic_text.HASH.$end;
	$use_multi_pic_text='use_multi_pic_';
	$style_display='style="display:';

	$content_pic=
	olc_draw_file_field($pic_url_text,$pic_url,str_replace(HASH,EMPTY_STRING,$onchange)).
	HTML_BR.
	str_replace(HASH,$pic_display_text,$span_start).str_replace(EBAY_REAL_SHOP_URL,EMPTY_STRING,$pic_url).SPAN_END;
	$content_pic=str_replace(HASH,$content_pic,$pic_table);
	$content_pic=str_replace(ATSIGN,$space.olc_image($thumbs_dir_local.$pic_file_name,
		EMPTY_STRING,EMPTY_STRING,EMPTY_STRING,$id_is.$pic_text.QUOTE).$dummy_span,$content_pic).
	olc_draw_hidden_field($pic_url_text.$hidden_text,$pic_url);

	$content_pic.=build_optional_image_html(1);
	//Allocate multiple pictures
	for ($i=2;$i<=12;$i++)
	{
		$content_pic.=build_optional_image_html($i);
	}
	$content_bo=olc_draw_checkbox_field($bold_text,ONE_STRING,$bold==ONE_STRING);
	$content_hi=olc_draw_checkbox_field($highlight_text,ONE_STRING,$highlight==ONE_STRING);
	$content_bd=olc_draw_checkbox_field($border_text,ONE_STRING,$border==ONE_STRING);

	$gallery_pic_table_text=$gallery_pic_text.'_table';
	if ($use_gallery_pic)
	{
		$display=$display_visible_text;
	}
	else
	{
		$display=$display_hidden_text;
	}
	$pic_table=str_replace(UNDERSCORE,$display,$pic_table0);
	$pic_table=str_replace(TILDE,$gallery_pic_table_text,$pic_table);
	$gallery_pic_display_text=$gallery_text.$pic_display_text;

	$onchange=$onchange0.	$gallery_pic_display_text.$sep.$gallery_pic_text.$end;

	$onclick=
	$onclick0.
	$gallery_pic_table_text.$sep.
	$gallery_pic_url_text.$sep.$gallery_pic_text.$end;

	$content_gp=
	olc_draw_checkbox_field($gallery_pic_plus_text,ONE_STRING,$gallery_pic_plus==ONE_STRING).
	HTML_NBSP.sprintf(AUCTIONS_TEXT_AUCTION_USE_GALLERY_PLUS,$fees[$gallery_pic_plus_text]).
	HTML_BR.HTML_BR.
	olc_draw_file_field($gallery_pic_url_text,$gallery_pic_url,$onchange).
	HTML_BR.
	str_replace(HASH,$gallery_pic_display_text,$span_start).
	str_replace(EBAY_REAL_SHOP_URL,EMPTY_STRING,$gallery_pic_url).SPAN_END;
	$content_gp=str_replace(HASH,$content_gp,$pic_table);
	$content_gp=
	str_replace(ATSIGN,$space.olc_image($thumbs_dir_local.$gallery_pic_file_name,
		EMPTY_STRING,EMPTY_STRING,EMPTY_STRING,$id_is.$gallery_pic_text.QUOTE).$dummy_span,$content_gp).
	olc_draw_hidden_field($gallery_pic_url_text.$hidden_text,$gallery_pic_url);
	$content_gp=
	olc_draw_checkbox_field($use_gallery_pic_text,ONE_STRING,$use_gallery_pic==ONE_STRING,$onclick).
	HTML_NBSP.sprintf(AUCTIONS_TEXT_AUCTION_USE_GALLERY_PIC,$fees[$gallery_pic_text]).HTML_BR.HTML_BR.$content_gp;

	$content_co=olc_draw_checkbox_field($cod_text,ONE_STRING,$cod==ONE_STRING);
	$content_cp=olc_draw_checkbox_field($cop_text,ONE_STRING,$cop==ONE_STRING);
	$content_cc=olc_draw_checkbox_field($creditcard_text,ONE_STRING,$cc==ONE_STRING);
	$content_pp=olc_draw_checkbox_field($paypal_text,ONE_STRING,$paypal==ONE_STRING);
	$content_de=olc_draw_checkbox_field($de_text,ONE_STRING,$ship2de);
	$content_at=olc_draw_checkbox_field($at_text,ONE_STRING,$ship2at);
	$content_ch=olc_draw_checkbox_field($ch_text,ONE_STRING,$ship2ch);

	$main_content.='
<script language="javascript"><!--
var illegal_directory="'.AUCTIONS_TEXT_ILLEGAL_IMG_DIR.'";
var legal_img_format=".jpg.jpeg.gif.png";
var illegal_format="'.AUCTIONS_TEXT_ILLEGAL_IMG_FORMAT.'";
var hidden_text="_hidden";
var next_show_hide_control;
var div_text="'.$div_text.'";
var pic_display_text="'.$pic_display_text0.UNDERSCORE.'";
var illegal_text="'.AUCTIONS_LIST_ERROR_NO_IMAGE.'";
var show_it,display_state,file_control_value,show_error;
var images="images",slash="/",dot=".",img="img";;
var thumbnail_images="'.DIR_WS_THUMBNAIL_IMAGES.'";
var pic_url,poss,short_pic_url,file_parts;
var backslash_rep="/\\/g";

function go_option()
{
	if (document.option_order_by.selected.options[document.option_order_by.selected.selectedIndex].value != "none")
	{
		location="'.olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'option_page=' .($option_page ? $option_page : 1)).
		'&option_order_by="+document.option_order_by.selected.options[document.option_order_by.selected.selectedIndex].value;
	}
}

function loadcategories(cat)
{
	var url="auctions_getCategoriesSQL.php'.'?ajax=true&x="+cat;
';
	if (false && IS_IE)
	{
		$main_content.='
		mycategories=window.showModalDialog(url, "Categories", "dialogHeight=800,dialogWidth=400,status=no,resizeable=no");
';
	}
	else
	{
		$main_content.='
		mycategories=window.open(url,"Categories", "height=800,width=400,top=0,left=0,scrollbars=yes,dependent=yes");
';
	}

	$main_content.='
	if (mycategories)
	{
		mycategories.focus();
	}
}

function show_hide(checkbox,show_hide_control,file_control,image_control,next_show_hide_control,show_hide_id)
{
	show_it=checkbox.checked;
	if (show_it)
	{
		display_state="'.$display_visible_text.'";
	}
	else
	{
		display_state="'.$display_hidden_text.'";
	}
	with (document)
	{
		if (next_show_hide_control)
		{
			show_error=false;
			if (show_it)
			{
				if (show_hide_id>2)
				{
					show_hide_id--;
					show_error=getElementById(pic_display_text+show_hide_id).innerHTML;
					show_error=!show_error;
				}
			}
			if (show_error)
			{
				checkbox.checked=false;
				show_it=illegal_text.replace(/%s/,show_hide_id);
				alert(show_it);
				return false;
			}
			else
			{
				next_show_hide_control=getElementById(next_show_hide_control);
				if (next_show_hide_control)
				{
					next_show_hide_control.style.display=display_state
				}
			}
		}

		show_hide_control=getElementById(show_hide_control);
		show_hide_control.style.display=display_state;
		if (show_it)
		{
			file_control=getElementById(file_control);
			file_control_value=file_control.value;
			if (file_control_value)
			{
				image_control=getElementById(image_control);
				image_control.src=file_control_value;
			}
		}
	}
}

function adjust_picture(file_control,file_name_control,image_control)
{
	pic_url=file_control.value;
	if (pic_url)
	{
		poss=pic_url.indexOf(images);
//debug_stop();
		if (poss!=-1)
		{
			short_pic_url=pic_url.substr(poss);
			file_parts=short_pic_url.split(dot);
			if (legal_img_format.indexOf(file_parts[1])!=-1)
			{
				with (document)
				{
					//short_pic_url=short_pic_url.replace(backslash_rep,slash);
					short_pic_url=short_pic_url.replace(/\\\/g,slash);
					file_parts=short_pic_url.split(slash);
					short_pic_url=thumbnail_images+file_parts[file_parts.length-1];
					getElementById(file_control.id+hidden_text).value=pic_url;
					getElementById(file_name_control).innerHTML=short_pic_url;
					var image_control_obj=getElementById(image_control);
					var image_control_parent=image_control_obj.parentElement;
					var image_control_sibling=image_control_obj.nextSibling;
					image_control_parent.removeChild(image_control_obj);

					image_control_obj = document.createElement(img);
					image_control_parent.insertBefore(image_control_obj, image_control_sibling)
					with (image_control_obj)
					{
						id=image_control;
						align="middle";
						src="../"+short_pic_url;
					}
					file_control.value="";
					file_control.defaultValue="";
				}
			}
			else
			{
				alert(illegal_img_format);
			}
		}
		else
		{
			alert(illegal_directory);
		}
	}
}

//W. Kaiser - AJAX
function ShowInfo(url,text,full_screen)
{
	var w_width,w_heigth,screen_width,screen_height,x_pos=0,y_pos=0;
	with (screen)
	{
		screen_width=width;
		screen_height=height;
	}
	if (full_screen)
	{
		//Full window size
		w_width=screen_width;
		w_heigth=screen_height;
	}
	else
	{
		//Standard window size
		w_width=800;
		w_heigth=800;
		if (url!="")
		{
			if (url.indexOf("product_images")!=-1)
			{
				//Reset size for images
				w_width = '.(PRODUCT_IMAGE_POPUP_WIDTH+30).';
				w_heigth = '.(PRODUCT_IMAGE_POPUP_HEIGHT+30).';
			}
		}
		//Center window
		x_pos = (screen_width - w_width) / 2;
		y_pos = (screen_height - w_heigth) / 2;
	}

	var win = window.open(url,"popupWindow","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,"+
		"resizable=no,copyhistory=no,width=" + w_width + ",height=" + w_heigth + ",top=" + y_pos + ",left=" + x_pos);
	if (win)
	{
		if (text != "")
		{
			with (win.document)
			{
				open("text/html");
				write(text);
				close();
			}
		}
		win.focus();
	}
	return false;
}

//--></script>
';
		$main_content.=
		olc_draw_form($form_name,FILENAME_AUCTIONS_NEW,EMPTY_STRING,EMPTY_STRING,'enctype="multipart/form-data"').
		$action_edit_field.
		olc_draw_hidden_field($category_id_text,$category_id).
		olc_draw_hidden_field($product_id_text,$product_id).
		$table_start;
			if ($error_ebay_session)
			{
				if (EBAY_TEST_MODE==TRUE_STRING_S)
				{
					$error=AUCTIONS_LIST_ERROR_EBAY_PARAMETER_TEST;
				}
				else
				{
					$error=AUCTIONS_LIST_ERROR_EBAY_PARAMETER_PRODUCTION;
				}
				display_error_if(true,$error);
			}
			display_error_if($error_xfer,$error_xfer_text);
			display_section_header(AUCTIONS_TEXT_AUCTION_DETAILS);
			display_section_content_line($desc_aut,$content_aut);
			display_error_if($error_submit,AUCTIONS_LIST_ERROR_SUBMIT);
			display_section_content_line(AUCTIONS_TEXT_AUCTION_SUBMIT,$content_sub);
			display_section_content_line(AUCTIONS_TEXT_AUCTION_EXPRESS_DURATION,$content_exp_dur,false,false,'exp_dur');
			if ($not_ebay_express_only)
			{
				display_section_content_line(AUCTIONS_TEXT_AUCTION_AUTO_SUBMIT,$content_auto_sub);
			}
			display_error_if($error_title,AUCTIONS_LIST_ERROR_TITLE);
			display_section_content_line(AUCTIONS_TEXT_AUCTION_TITLE,$content_ti);
			display_section_content_line(sprintf(AUCTIONS_TEXT_AUCTION_SUB_TITLE,$fees[$subtitle_text]),$content_sti);
			display_error_if($error_cat,AUCTIONS_LIST_ERROR_CAT);
			display_section_content_line(AUCTIONS_TEXT_AUCTION_CAT1,$content_cat1);
			display_section_content_line(AUCTIONS_TEXT_AUCTION_CAT2,$content_cat2);

			display_section_header(AUCTIONS_TEXT_ARTICLE_DESCRIPTION);
			display_section_content_line(AUCTIONS_TEXT_AUCTION_DESCRIPTION_TEMPLATE,$content_template);
			display_section_content_line(AUCTIONS_TEXT_AUCTION_DESCRIPTION_FORCE_REBUILD,$content_rebuild);
			display_error_if($error_desc,AUCTIONS_LIST_ERROR_DESC);
			display_error_if($error_attributes,AUCTIONS_TEXT_WRONG_ATTRIBUTES);
			display_section_content_line(EMPTY_STRING,$content_spaw,false,$eval_spaw);

			display_section_header(AUCTIONS_TEXT_ARTICLE_DURATION);
			if ($content_duration)
			{
				display_error_if($error_dur,AUCTIONS_LIST_ERROR_DUR);
				display_section_content_line(AUCTIONS_TEXT_AUCTION_DURATION,$content_duration);
			}
			display_error_if($error_starttime,AUCTIONS_LIST_ERROR_STARTTIME);
			display_section_content_line(EMPTY_STRING,$content_cal,true,true,false);

			display_error_if($error_quantity,$error_quantity_text);
			display_section_content_line(AUCTIONS_TEXT_AUCTION_QUANTITY,$content_q);
			display_error_if($error_startprice,AUCTIONS_LIST_ERROR_STARTPRICE);

			display_section_content_line(AUCTIONS_TEXT_AUCTION_PRICE,$content_s);
			display_error_if($error_fixprice,AUCTIONS_LIST_ERROR_FIXPRICE);
			display_section_content_line(sprintf(AUCTIONS_TEXT_AUCTION_FIXED_PRICE,$fees[$buyitnow_text]),$content_b).

			display_section_header(AUCTIONS_TEXT_ARTICLE_CITY);
			display_error_if($error_location,AUCTIONS_LIST_ERROR_LOCATION);
			display_section_content_line(AUCTIONS_TEXT_AUCTION_LOCATION,$content_l).
			display_error_if($error_country,AUCTIONS_LIST_ERROR_COUNTRY);
			display_section_content_line(AUCTIONS_TEXT_AUCTION_COUNTRY,$content_c);

			display_section_header(AUCTIONS_TEXT_ARTICLE_PICS).
			display_error_if($error_pic,sprintf(AUCTIONS_LIST_ERROR_PIC,EMPTY_STRING));
			display_section_content_line(AUCTIONS_TEXT_AUCTION_PIC_URL,EMPTY_STRING);
			display_section_content_line(EMPTY_STRING,$content_pic);
			if ($have_multi_pic_error)
			{
				for ($i=0,$n=sizeof($multi_pic_error);$i<$n;$i++)
				{
					display_error_if(true,sprintf(AUCTIONS_LIST_ERROR_PIC,($i+2).DOT));
				}
			}
			display_section_header(AUCTIONS_TEXT_ARTICLE_OPTIONS);
			display_section_content_line(sprintf(AUCTIONS_TEXT_AUCTION_FONT_BOLD,$fees[$bold_text]),$content_bo);
			display_section_content_line(sprintf(AUCTIONS_TEXT_AUCTION_FONT_HIGHLIGHT,$fees[$highlight_text]),$content_hi);
			display_section_content_line(sprintf(AUCTIONS_TEXT_AUCTION_FONT_BORDER,$fees[$highlight_text]),$content_bd);
			display_error_if($error_gallerypic,sprintf(AUCTIONS_LIST_ERROR_PIC,AUCTIONS_LIST_ERROR_GALLERY_TEXT));
			display_section_content_line(AUCTIONS_TEXT_AUCTION_GALLERY_PIC_URL,$content_gp);

			display_section_header(AUCTIONS_TEXT_ARTICLE_PAYMENT).
			display_error_if($error_payment,AUCTIONS_LIST_ERROR_PAYMENT);
			display_section_content_line(AUCTIONS_TEXT_AUCTION_PAYMENT_COD,$content_co);
			display_section_content_line(AUCTIONS_TEXT_AUCTION_PAYMENT_COP,$content_cp);
			display_section_content_line(AUCTIONS_TEXT_AUCTION_PAYMENT_CC,$content_cc);
			display_error_if($error_paypal,AUCTIONS_LIST_ERROR_PAYPAL);
			display_section_content_line(AUCTIONS_TEXT_AUCTION_PAYMENT_PAYPAL,$content_pp);

			display_section_header(AUCTIONS_TEXT_ARTICLE_SHIPMENT);
			display_section_content_line(AUCTIONS_TEXT_AUCTION_COUNTRY_DE,$content_de);
			display_section_content_line(AUCTIONS_TEXT_AUCTION_COUNTRY_AT,$content_at);
			display_section_content_line(AUCTIONS_TEXT_AUCTION_COUNTRY_CH,$content_ch);

			$content=HTML_BR.HTML_BR.
			olc_draw_submit_button("addItem",AUCTIONS_TEXT_AUCTION_ADD).HTML_NBSP.HTML_NBSP.
			olc_draw_submit_button("saveItem",AUCTIONS_TEXT_AUCTION_NEW);
			$main_content.=
			display_section_content_line(EMPTY_STRING,$content).
		$table_end_form_end.
	$form_end;
}
$show_column_right=true;
$no_left_menu=false;
$page_header_subtitle=AUCTIONS_TEXT_SUB_HEADER_AUCTION;
require(PROGRAM_FRAME);
?>
