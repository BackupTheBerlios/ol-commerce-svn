<?php
/* --------------------------------------------------------------
$Id: categories_view.php,v 1.1.1.1.2.1 2007/04/08 07:16:26 gswkaiser Exp $

OL-Commerce Version 1.0
http://www.ol-commerce.com

Copyright (c) 2004 OL-Commerce
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

$search=$_GET['search'];
$cPath=$_GET['cPath'];
if ($cPath_array) {
	$cPath_back = EMPTY_STRING;
	for($i = 0, $n = sizeof($cPath_array) - 1; $i < $n; $i++)
	{
		if ($cPath_back)
		{
			$cPath_back .= UNDERSCORE;
		}
		$cPath_back .= $cPath_array[$i];
	}
}
$cPath_back=($cPath_back)?'cPath='.$cPath_back:EMPTY_STRING;
$buttons=EMPTY_STRING;
if ($cPath)
{
	$buttons.='
												&nbsp;<a href="'.olc_href_link(FILENAME_CATEGORIES,$cPath_back.'&cID='.$current_category_id).'">'.
	olc_image_button('button_back.gif',IMAGE_BACK).'
												</a>
';
}
if (!$search)
{
	$buttons.='
												&nbsp;<a href="'.olc_href_link(FILENAME_CATEGORIES,'cPath='.$cPath.'&action=new_category').'">'.
	olc_image_button('button_new_category.gif',IMAGE_NEW_CATEGORY).'
												</a>
												&nbsp;<a href="'.olc_href_link(FILENAME_CATEGORIES,'cPath='.$cPath.'&action=new_product').'">'.
	olc_image_button('button_new_product.gif',IMAGE_NEW_PRODUCT).'
												</a>';
}
?>
      <tr>
        <td>
	        <table border="0" width="100%" cellspacing="0" cellpadding="0">
	          <tr>
	            <td class="pageHeading">
	            	<?php echo HEADING_TITLE.HTML_BR.HTML_BR.$buttons.HTML_BR.HTML_BR; ?>
	            	</td>
	            <td align="right">
		            <table border="0" width="100%" cellspacing="0" cellpadding="0">
		              <tr>
		                <td class="smallText" align="right">
			              	<?php echo
			              	olc_draw_form('search', FILENAME_CATEGORIES, EMPTY_STRING, 'get');
			              	echo HEADING_TITLE_SEARCH . BLANK . olc_draw_input_field('search', $search).
			              	olc_draw_hidden_field(olc_session_name(), olc_session_id());
		                	?>
			              	</form>
		                </td>
		              </tr>
		              <tr>
		                <td class="smallText" align="right">
			              	<?php echo
			              	olc_draw_form('goto', FILENAME_CATEGORIES, EMPTY_STRING, 'get');
			              	echo HEADING_TITLE_GOTO .BLANK . olc_draw_pull_down_menu('cPath', olc_get_category_tree(),
			              	$current_category_id, 'onchange="this.form.submit();"').olc_draw_hidden_field(olc_session_name(),
			              	olc_session_id());
			                 ?>
			              	</form>
		                </td>
		              </tr>
		            </table>
		           </td>
	          </tr>
	        </table>
	      </td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
              <td class="dataTableHeadingContent" width="10%"><?php echo TXT_SORT; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CATEGORIES_PRODUCTS; ?></td>
<?php
// check Produkt and attributes stock
if (STOCK_CHECK == TRUE_STRING_S) {
	if ($cPath != EMPTY_STRING) {
		echo '<td class="dataTableHeadingContent">' . TABLE_HEADING_STOCK . '</td>';
	}
}
?>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="center" nowrap="nowrap"><?php echo TABLE_HEADING_PRICE; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo '% max'; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_ACTION; ?></td>
              </tr>
<?php
$categories_count = 0;
$rows = 0;
$categories_query="select c.categories_id, cd.categories_name,c.sort_order, c.categories_image, c.parent_id,
		c.sort_order, c.date_added, c.last_modified, c.categories_status from " .
TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
	where c.categories_id = cd.categories_id and cd.language_id = '" . SESSION_LANGUAGE_ID . "' and ";
$order_by="' order by c.sort_order, cd.categories_name";
if ($search) {
	$categories_query = $categories_query .	"cd.categories_name like '%" . $search . "%".$order_by;
} else {
	$categories_query = $categories_query .	"c.parent_id = '" . $current_category_id . $order_by;
}
$action=$_GET['action'];
$not_is_new=substr($action, 0, 4) != 'new_';
$cID=$_GET['cID'];
$pID=$_GET['pID'];
$categories_query = olc_db_query($categories_query);
while ($categories = olc_db_fetch_array($categories_query)) {
	$categories_count++;
	$rows++;
	// Get parent_id for subcategories if search
	if ($search) $cPath= $categories['parent_id'];
	$categories_id=$categories['categories_id'];
	if (!$pID)
	{
		if ((!$cID || ($cID == $categories_id)) && (!$cInfo) && ($not_is_new))
		{
			$category_childs = array('childs_count' => olc_childs_in_category_count($categories_id));
			$category_products = array('products_count' => olc_products_in_category_count($categories_id));
			$cInfo_array = olc_array_merge($categories, $category_childs, $category_products);
			$cInfo = new objectInfo($cInfo_array);
			$categories_name=stripslashes($cInfo->categories_name);
			$cInfo->categories_name=str_replace('\\',EMPTY_STRING,$categories_name);
		}
	}

	if ((is_object($cInfo)) && ($categories_id == $cInfo->categories_id))
	{
		$selected ='Selected';
		echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' .
		olc_onclick_link(FILENAME_CATEGORIES, olc_get_path($categories_id)) . '">' . NEW_LINE;
	} else {
		$selected =EMPTY_STRING;
		echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" ' .
		'onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' .
		olc_onclick_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $categories_id) . '">' . NEW_LINE;
	}
	$td_start = '<td class="dataTableContent' .$selected . '" ';
	$categories_name=stripslashes($categories['categories_name']);
	$categories_name=str_replace('\\',EMPTY_STRING,$categories_name);
	echo
	$td_start . '>' . $categories['sort_order'] . '</td>' .
	$td_start . '><a href="' . olc_href_link(FILENAME_CATEGORIES, olc_get_path($categories_id)) . '">' .
	olc_image(DIR_WS_ICONS . 'folder.gif', ICON_FOLDER) .
	'<a>&nbsp;<b><a href="'.olc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $categories_id) .'">' .
	$categories_name . '</a></b></td>';
	// check Produkt and attributes stock
	if (STOCK_CHECK == TRUE_STRING_S) {
		if ($cPath != EMPTY_STRING) {
			echo $td_start . '>&nbsp;</td>';
		}
	}
	if ($categories['categories_status'] == '1') {
		$link = olc_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' .
		olc_href_link(FILENAME_CATEGORIES, 'action=setflag&flag=0&cID=' . $categories_id . '&cPath=' . $cPath) . '">' .
		olc_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . HTML_A_END;
	} else {
		$link = HTML_A_START . olc_href_link(FILENAME_CATEGORIES,
		'action=setflag&flag=1&cID=' . $categories_id . '&cPath=' . $cPath) . '">' .
		olc_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' .
		olc_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
	}
	echo $td_start . 'align="center">' . $link . '</td>';

	if ((is_object($cInfo)) && ($categories_id == $cInfo->categories_id))
	{
		$link = olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', EMPTY_STRING);
	} else {
		$link = HTML_A_START . olc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $categories_id) . '">' .
		olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END;
	}

	echo $td_start . 'align="center">--</td>' .
	$td_start . 'align="center">--</td>' .
	$td_start . 'align="right">' .$link . '</td>
           </tr>';
}

$products_count = 0;
//$search=$_GET['search'];
if ($search)
{
	$products_query="(pd.products_name like '%" . $search . "%' OR  p.products_model = '" . $search . "')";
} else {
	$products_query="p2c.categories_id = " . $current_category_id;
}
$products_query = "select
   p.products_tax_class_id,
   p.products_id,
   p.products_sort,
   pd.products_name,
   p.products_quantity,
   p.products_image,
   p.products_price,
   p.products_discount_allowed,
   p.products_date_added,
   p.products_last_modified,
   p.products_date_available,
   p.products_status,
   p2c.categories_id
   from " .
TABLE_PRODUCTS . " p, " .
TABLE_PRODUCTS_DESCRIPTION . " pd, " .
TABLE_PRODUCTS_TO_CATEGORIES . " p2c
   where
   p.products_id = pd.products_id and
   pd.language_id = " . SESSION_LANGUAGE_ID ." and
   p.products_id = p2c.products_id
	 and ".$products_query."
   order by pd.products_name";
//order by p.products_sort";

$products_query = olc_db_query($products_query);
while ($products = olc_db_fetch_array($products_query))
{
	$products_count++;
	$rows++;
	// Get categories_id for product if search
	if ($search)
	{
		$cPath=$products['categories_id'];
	}
	if ((!$pID && !$cID || (@$pID == $products['products_id'])) && !$pInfo && !$cInfo && $not_is_new)
	{
		// find out the rating average from customer reviews
		$reviews_query = olc_db_query("select (avg(reviews_rating) / 5 * 100) as average_rating from " . TABLE_REVIEWS .
		" where products_id = " . $products['products_id']);
		$reviews = olc_db_fetch_array($reviews_query);
		$pInfo_array = olc_array_merge($products, $reviews);
		$pInfo = new objectInfo($pInfo_array);
	}
	$is_selected =  (is_object($pInfo)) && ($products['products_id'] == $pInfo->products_id) ;
	$params='cPath=' . $cPath . '&pID=' . $products['products_id'];
	if ($is_selected)
	{
		$selected ='Selected';
		//echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" >' . NEW_LINE;
		echo '
              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' .
		olc_onclick_link(FILENAME_CATEGORIES, $params.'&action=new_product') . '">' . NEW_LINE;
	} else {
		$selected =EMPTY_STRING;
		echo '
              <tr class="dataTableRow"
              	onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'"
								onmouseout="this.className=\'dataTableRow\'" >' . NEW_LINE;
	}
	$td_start = '<td class="dataTableContent' . $selected . '" ';
	$products_name=stripslashes($products['products_name']);
	$products_name=str_replace('\\',EMPTY_STRING,$products_name);
	echo
	$td_start . 'width="1">' . $products['products_sort'] . '</td>' .
	$td_start . '><a href="' . olc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath .
	'&pID=' . $products['products_id']) . '">' .
	olc_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '&nbsp;</a><a href="'.
	olc_href_link(FILENAME_CATEGORIES, $params) .'">' . $products_name . '</a>
	</td>';
	// check Produkt and attributes stock
	if ($cPath != EMPTY_STRING) {
		echo check_stock($products['products_id']);
	}
	echo $td_start . 'align="center">';
	if ($products['products_status'] == '1') {
		echo olc_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) .
		'&nbsp;&nbsp;<a href="' .
		olc_href_link(FILENAME_CATEGORIES, 'action=setflag&flag=0&pID=' . $products['products_id'] .
		'&cPath=' . $cPath) . '">' .
		olc_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . HTML_A_END;
	} else {
		echo HTML_A_START . olc_href_link(FILENAME_CATEGORIES, 'action=setflag&flag=1&pID=' .
		$products['products_id'] . '&cPath=' . $cPath) . '">' .
		olc_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) .
		'</a>&nbsp;&nbsp;' .
		olc_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
	}
	echo '</td>' . 	$td_start . 'align="right" nowrap="nowrap" >'.
	// Show price
	$currencies->format($products['products_price']).
	//End Show price
	'</td>' . $td_start . 'align="right">'.
	// Show Max Allowed discount
	$products['products_discount_allowed'] . '%';
	//  End Show Max Allowed discount
	if ($is_selected)
	{
		$link = olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', EMPTY_STRING);
	}
	else
	{
		$link = HTML_A_START . olc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath .
		'&pID=' . $products['products_id']) . '">' .
		olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END;
	}
	echo '</td>' . $td_start . 'align="right">'. $link . '&nbsp;</td></tr>';
}
echo '
							<tr>
                <td colspan="3">
	                <table border="0" width="100%" cellspacing="0" cellpadding="2">
	                  <tr>
	                    <td class="smallText">'.TEXT_CATEGORIES . HTML_NBSP . $categories_count . HTML_BR .
												TEXT_PRODUCTS . HTML_NBSP . $products_count.'
											</td>
	                    <td align="right" class="smallText">
'.$buttons.'
	                    </td>
	                  </tr>
	                </table>
                </td>
              </tr>
';
?>
            </table>
            </td>
<?php
$heading = array();
$contents = array();
switch ($action) {
	case 'new_category':
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_NEW_CATEGORY . HTML_B_END);

		$contents = array('form' => olc_draw_form('newcategory', FILENAME_CATEGORIES, 'action=insert_category&cPath=' . $cPath,
		'post','enctype="multipart/form-data"'));
		$contents[] = array('text' => TEXT_NEW_CATEGORY_INTRO);

		$category_inputs_string = EMPTY_STRING;
		$languages = olc_get_languages();
		for ($i = 0, $n = sizeof($languages); $i < $n; $i++)
		{
			$category_inputs_string .= HTML_BR . olc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] .SLASH.
			$languages[$i]['image'],
			$languages[$i]['name']) . HTML_NBSP . olc_draw_input_field('categories_name[' . $languages[$i]['id'] . ']');
		}
		$contents[] = array('text' => HTML_BR . TEXT_CATEGORIES_NAME . $category_inputs_string);
		$contents[] = array('text' => HTML_BR . TEXT_CATEGORIES_IMAGE . HTML_BR . olc_draw_file_field('categories_image'));
		$contents[] = array('text' => HTML_BR . TEXT_SORT_ORDER . HTML_BR .
			olc_draw_input_field('sort_order',	EMPTY_STRING, 'size="2"'));
		$contents[] = array('align' => 'center', 'text' => HTML_BR .
		olc_image_submit('button_save.gif', IMAGE_SAVE) . BLANK.HTML_A_START .
		olc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath) . '">' .
		olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;

	case 'edit_category':
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_EDIT_CATEGORY . HTML_B_END);

		$contents = array('form' => olc_draw_form('categories', FILENAME_CATEGORIES, 'action=update_category&cPath=' . $cPath,
		'post','enctype="multipart/form-data"') . olc_draw_hidden_field('categories_id', $cInfo->categories_id));
		$contents[] = array('text' => TEXT_EDIT_INTRO);

		$category_inputs_string = EMPTY_STRING;
		$languages = olc_get_languages();
		for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
			$category_inputs_string .= HTML_BR . olc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] .SLASH.
			$languages[$i]['image'],
			$languages[$i]['name']) . HTML_NBSP . olc_draw_input_field('categories_name[' . $languages[$i]['id'] . ']',
			olc_get_categories_name($cInfo->categories_id, $languages[$i]['id']));
		}

		$contents[] = array('text' => HTML_BR . TEXT_EDIT_CATEGORIES_NAME . $category_inputs_string);
		$categories_image=$cInfo->categories_image;
		$contents[] = array('text' => HTML_BR . olc_image(DIR_WS_CATALOG_IMAGES .'categories/'. $categories_image,
		$cInfo->categories_name) . HTML_BR . DIR_WS_CATALOG_IMAGES . '<br/><b>' . $categories_image . HTML_B_END);
		$contents[] = array('text' => HTML_BR . TEXT_EDIT_CATEGORIES_IMAGE . HTML_BR .
			olc_draw_file_field('categories_image').HTML_NBSP.$categories_image.
			olc_draw_hidden_field('categories_previous_image', $categories_image));
		$contents[] = array('text' => HTML_BR . TEXT_EDIT_SORT_ORDER . HTML_BR .
		olc_draw_input_field('sort_order', $cInfo->sort_order,'size="2"'));
		$contents[] = array('text' => HTML_BR . TEXT_EDIT_STATUS . HTML_BR . olc_draw_input_field('categories_status',
		$cInfo->categories_status, 'size="2"') . '1=Enabled 0=Disabled');
		$contents[] = array('align' => 'center', 'text' => HTML_BR .
		olc_image_submit('button_save.gif', IMAGE_SAVE) . BLANK.HTML_A_START .
		olc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id) . '">' .
		olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;

	case 'delete_category':
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_DELETE_CATEGORY . HTML_B_END);

		$contents = array('form' => olc_draw_form('categories', FILENAME_CATEGORIES,
		'action=delete_category_confirm&cPath=' . $cPath) .
		olc_draw_hidden_field('categories_id', $cInfo->categories_id));
		$contents[] = array('text' => TEXT_DELETE_CATEGORY_INTRO);
		$contents[] = array('text' => '<br/><b>' . $cInfo->categories_name . HTML_B_END);
		if ($cInfo->childs_count > 0) $contents[] = array('text' => HTML_BR .
		sprintf(TEXT_DELETE_WARNING_CHILDS, $cInfo->childs_count));
		if ($cInfo->products_count > 0) $contents[] = array('text' => HTML_BR . sprintf(TEXT_DELETE_WARNING_PRODUCTS,
		$cInfo->products_count));
		$contents[] = array('align' => 'center', 'text' => HTML_BR .
		olc_image_submit('button_delete.gif', IMAGE_DELETE) . BLANK.HTML_A_START .
		olc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id) . '">' .
		olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;

	case 'move_category':
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_MOVE_CATEGORY . HTML_B_END);

		$contents = array('form' => olc_draw_form('categories', FILENAME_CATEGORIES, 'action=move_category_confirm') .
		olc_draw_hidden_field('categories_id', $cInfo->categories_id));
		$contents[] = array('text' => sprintf(TEXT_MOVE_CATEGORIES_INTRO, $cInfo->categories_name));
		$contents[] = array('text' => HTML_BR . sprintf(TEXT_MOVE, $cInfo->categories_name) . HTML_BR .
		olc_draw_pull_down_menu('move_to_category_id', olc_get_category_tree('0', EMPTY_STRING, $cInfo->categories_id),
		$current_category_id));
		$contents[] = array('align' => 'center', 'text' => HTML_BR .
		olc_image_submit('button_move.gif', IMAGE_MOVE) . BLANK.HTML_A_START .
		olc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id) . '">' .
		olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;

	case 'delete_product':
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_DELETE_PRODUCT . HTML_B_END);

		$contents = array('form' => olc_draw_form('products', FILENAME_CATEGORIES, 'action=delete_product_confirm&cPath=' . $cPath) .
		olc_draw_hidden_field('products_id', $pInfo->products_id));
		$contents[] = array('text' => TEXT_DELETE_PRODUCT_INTRO);
		$contents[] = array('text' => '<br/><b>' . $pInfo->products_name . HTML_B_END);

		$product_categories_string = EMPTY_STRING;
		$product_categories = olc_generate_category_path($pInfo->products_id, 'product');
		for ($i = 0, $n = sizeof($product_categories); $i < $n; $i++)
		{
			$category_path = EMPTY_STRING;
			for ($j = 0, $k = sizeof($product_categories[$i]); $j < $k; $j++)
			{
				if ($category_path)
				{
					$category_path.= '&nbsp;&gt;&nbsp;';
				}
				$category_path .= $product_categories[$i][$j]['text'];
			}
			if ($product_categories_string)
			{
				$product_categories_string.=HTML_BR;
			}
			$product_categories_string .= olc_draw_checkbox_field('product_categories[]',
			$product_categories[$i][sizeof($product_categories[$i])-1]['id'], true) . HTML_NBSP . $category_path;
		}
		$contents[] = array('text' => HTML_BR . $product_categories_string);
		$contents[] = array('align' => 'center', 'text' => HTML_BR .
		olc_image_submit('button_delete.gif', IMAGE_DELETE) . BLANK.HTML_A_START .
		olc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id) . '">' .
		olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;

	case 'move_product':
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_MOVE_PRODUCT . HTML_B_END);

		$contents = array('form' => olc_draw_form('products', FILENAME_CATEGORIES, 'action=move_product_confirm&cPath=' . $cPath) .
		olc_draw_hidden_field('products_id', $pInfo->products_id));
		$contents[] = array('text' => sprintf(TEXT_MOVE_PRODUCTS_INTRO, $pInfo->products_name));
		$contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENT_CATEGORIES . '<br/><b>' .
		olc_output_generated_category_path($pInfo->products_id, 'product') . HTML_B_END);
		$contents[] = array('text' => HTML_BR . sprintf(TEXT_MOVE, $pInfo->products_name) . HTML_BR .
		olc_draw_pull_down_menu('move_to_category_id', olc_get_category_tree(), $current_category_id));
		$contents[] = array('align' => 'center', 'text' => HTML_BR .
		olc_image_submit('button_move.gif', IMAGE_MOVE) . BLANK.HTML_A_START .
		olc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id) . '">' .
		olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;

	case 'copy_to':
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_COPY_TO . HTML_B_END);

		$contents = array('form' => olc_draw_form('copy_to', FILENAME_CATEGORIES, 'action=copy_to_confirm&cPath=' . $cPath) .
		olc_draw_hidden_field('products_id', $pInfo->products_id));
		$contents[] = array('text' => TEXT_INFO_COPY_TO_INTRO);
		$categories_contained=olc_output_generated_category_path($pInfo->products_id, 'product');
		$contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENT_CATEGORIES . '<br/><b>' .	$categories_contained . HTML_B_END);
		if (QUICKLINK_ACTIVATED==TRUE_STRING_S) {
			$contents[] = array('text' => '<hr noshade="noshade"/>');
			$contents[] = array('text' => HTML_B_START.TEXT_MULTICOPY.'</b><br/>'.TEXT_MULTICOPY_DESC);
			$cat_tree=olc_get_category_tree();
			$tree=EMPTY_STRING;
			for ($i=0;$n=sizeof($cat_tree),$i<$n;$i++)
			{
				$cat_tree_text=$cat_tree[$i]['text'];
				//$tree .='<input type="checkbox" name="cat_ids[]" value="'.$cat_tree[$i]['id'].'"><font size="1">'
				$tree.=olc_draw_checkbox_field('cat_ids[]',$cat_tree[$i]['id'],!(strpos($categories_contained,
				str_replace(HTML_NBSP,EMPTY_STRING,$cat_tree_text))===false)).$cat_tree_text.'</font><br/>';
			}
			$contents[] = array('text' => $tree.'<br/><hr noshade="noshade"/>');
			$contents[] = array('text' => HTML_B_START.TEXT_SINGLECOPY.'</b><br/>'.TEXT_SINGLECOPY_DESC);
		}
		$contents[] = array('text' => HTML_BR . TEXT_CATEGORIES . HTML_BR . olc_draw_pull_down_menu('categories_id',
		olc_get_category_tree(), $current_category_id));
		$contents[] = array('text' => HTML_BR . TEXT_HOW_TO_COPY . HTML_BR . olc_draw_radio_field('copy_as', 'link', true) .
		HTML_NBSP .TEXT_COPY_AS_LINK . HTML_BR . olc_draw_radio_field('copy_as', 'duplicate') . HTML_NBSP . TEXT_COPY_AS_DUPLICATE);
		$contents[] = array('align' => 'center', 'text' => HTML_BR .
		olc_image_submit('button_copy.gif', IMAGE_COPY) . BLANK.HTML_A_START .
		olc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id) . '">' .
		olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;

	default:
		if ($rows > 0) {
			if (is_object($cInfo)) { // category info box contents
				$heading[] = array('text' => HTML_B_START . $cInfo->categories_name . HTML_B_END);

				$contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath .
				'&cID=' . $cInfo->categories_id . '&action=edit_category') . '">' . olc_image_button('button_edit.gif', IMAGE_EDIT) . '</a>
		<a href="' . olc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id .
		'&action=delete_category') . '">' . olc_image_button('button_delete.gif', IMAGE_DELETE) . '</a> <a href="' .
		olc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id . '&action=move_category') . '">' .
		olc_image_button('button_move.gif', IMAGE_MOVE) . HTML_A_END);
		$contents[] = array('text' => HTML_BR . TEXT_DATE_ADDED . HTML_NBSP . olc_date_short($cInfo->date_added));
		if (olc_not_null($cInfo->last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . HTML_NBSP .
		olc_date_short($cInfo->last_modified));
		$contents[] = array('text' => HTML_BR . olc_info_image_c($cInfo->categories_image, $cInfo->categories_name) . HTML_BR .
		$cInfo->categories_image);
		$contents[] = array('text' => HTML_BR . TEXT_SUBCATEGORIES . HTML_NBSP . $cInfo->childs_count . HTML_BR . TEXT_PRODUCTS .
		HTML_NBSP .$cInfo->products_count);
			} elseif (is_object($pInfo)) { // product info box contents
				$heading[] = array('text' => HTML_B_START .
				olc_get_products_name($pInfo->products_id, $_SESSION['languages_id']) . HTML_B_END);

				$contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=new_product') . '">' . olc_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . olc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=delete_product') . '">' . olc_image_button('button_delete.gif', IMAGE_DELETE) . '</a> <a href="' . olc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=move_product') . '">' . olc_image_button('button_move.gif', IMAGE_MOVE) . '</a> <a href="' . olc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=copy_to') . '">' . olc_image_button('button_copy_to.gif', IMAGE_COPY_TO) . HTML_A_END.
				olc_draw_form('edit_attributes', FILENAME_NEW_ATTRIBUTES, EMPTY_STRING, 'post').'
		<input type="hidden" name="action" value="edit"><input type="hidden" name="current_product_id" value="' . $pInfo->products_id . '"><input type="hidden" name="cpath" value="' . $cPath . '">' . olc_image_submit('button_edit_attributes.gif', 'edit_attributes') . '</form>');

				$contents[] = array('text' => HTML_BR . TEXT_DATE_ADDED . HTML_NBSP . olc_date_short($pInfo->products_date_added));
				if (olc_not_null($pInfo->products_last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . HTML_NBSP .
				 olc_date_short($pInfo->products_last_modified));
				if (date('Y-m-d') < $pInfo->products_date_available)
				{
					$contents[] = array('text' => sprintf(TEXT_DATE_AVAILABLE, olc_date_short($pInfo->products_date_available)));
				}
				$contents[] = array('text' => HTML_BR . olc_product_info_image($pInfo->products_image, $pInfo->products_name) .
				HTML_BR . $pInfo->products_image);
				// START IN-SOLUTION Berechung des Bruttopreises
				$price=$pInfo->products_price;
				$price=olc_round($price,PRICE_PRECISION);
				$price_string=TEXT_PRODUCTS_PRICE_INFO . HTML_NBSP . $currencies->format($price);
				if (PRICE_IS_BRUTTO==TRUE_STRING_S && ($_GET['read'] == 'only' || $action != 'new_product_preview')){
					$price_netto=olc_round($price,PRICE_PRECISION);
					$tax_query = olc_db_query("select tax_rate from " . TABLE_TAX_RATES .
					" where tax_class_id = '" . $pInfo->products_tax_class_id . APOS);
					$tax = olc_db_fetch_array($tax_query);
					$price= ($price*($tax[tax_rate]+100)/100);

					$price_string=TEXT_PRODUCTS_PRICE_INFO  . $currencies->format($price) . ' - ' .
					TXT_NETTO . $currencies->format($price_netto);
				}


				$contents[] = array('text' => HTML_BR . $price_string. HTML_BR .  TEXT_PRODUCTS_DISCOUNT_ALLOWED_INFO .  HTML_NBSP .
				 $pInfo->products_discount_allowed . HTML_BR . TEXT_PRODUCTS_QUANTITY_INFO . HTML_NBSP . $pInfo->products_quantity);
				// END IN-SOLUTION

				//            $contents[] = array('text' => HTML_BR . TEXT_PRODUCTS_PRICE_INFO . HTML_NBSP . $currencies->format($pInfo->products_price) . HTML_BR . TEXT_PRODUCTS_QUANTITY_INFO . HTML_NBSP . $pInfo->products_quantity);
				$contents[] = array('text' => HTML_BR . TEXT_PRODUCTS_AVERAGE_RATING . HTML_NBSP .
				number_format($pInfo->average_rating, 2) . '%');
			}
		} else { // create category/product info
			$heading[] = array('text' => HTML_B_START . EMPTY_CATEGORY . HTML_B_END);

			$contents[] = array('text' => sprintf(TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS, $parent_categories_name));
		}
		break;
}

if ((olc_not_null($heading)) && (olc_not_null($contents))) {
	echo '            <td width="25%" valign="top">' . NEW_LINE;

	$box = new box;
	echo $box->infoBox($heading, $contents);

	echo '            </td>' . NEW_LINE;
}
?>
          </tr>
        </table></td>
      </tr>