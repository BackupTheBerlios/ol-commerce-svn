<?php
/* --------------------------------------------------------------
$Id: languages.php,v 1.1.1.1.2.1 2007/04/08 07:16:28 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(languages.php,v 1.33 2003/05/07); www.oscommerce.com
(c) 2003	    nextcommerce (languages.php,v 1.10 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application_top.php');
$lID = $_GET['lID'];
$page=$_GET['page'];
$action=$_GET['action'];
$comma_blank="', '";
$is_delete=false;
switch ($action)
{
	case 'insert':
		$name = $_POST['name'];
		$code = $_POST['code'];
		$image = $_POST['image'];
		$directory = $_POST['directory'];
		$sort_order = $_POST['sort_order'];
		$charset = $_POST['charset'];
		olc_db_query(INSERT_INTO . TABLE_LANGUAGES ." (
		name,
		code,
		image,
		directory,
		sort_order,
		language_charset
		) values ('" .
		olc_db_input($name) . $comma_blank .
		olc_db_input($code) . $comma_blank .
		olc_db_input($image) . $comma_blank .
		olc_db_input($directory) . $comma_blank .
		olc_db_input($sort_order) . $comma_blank .
		olc_db_input($charset) . "')");
		$insert_id = olc_db_insert_id();
		$lID=$insert_id;
		// create additional categories_description records
		$language_id_text='language_id';
		$where_language_id=SQL_WHERE.$language_id_text.EQUAL.SESSION_LANGUAGE_ID;
		$languages_id_text='languages_id';
		$where_languages_id=SQL_WHERE.$languages_id_text.EQUAL.SESSION_LANGUAGE_ID;

		$categories_query = olc_db_query(SELECT_ALL.TABLE_CATEGORIES_DESCRIPTION . $where_language_id);
		while ($categories = olc_db_fetch_array($categories_query))
		{
			$categories[$language_id_text]=$insert_id;
			olc_db_perform(TABLE_CATEGORIES_DESCRIPTION,$categories);
		}
		// create additional products_description records
		$products_query = olc_db_query(SELECT_ALL.TABLE_PRODUCTS_DESCRIPTION .$where_language_id);
		while ($products = olc_db_fetch_array($products_query))
		{
			$products[$language_id_text]=$insert_id;
			$products['products_viewed']=0;
			olc_db_perform(TABLE_PRODUCTS_DESCRIPTION,$products);
		}
		// create additional products_options records
		$products_options_query = olc_db_query(SELECT_ALL. TABLE_PRODUCTS_OPTIONS . $where_language_id);
		while ($products_options = olc_db_fetch_array($products_options_query))
		{
			$products_options[$language_id_text]=$insert_id;
			olc_db_perform(TABLE_PRODUCTS_OPTIONS,$products_options);
		}
		// create additional products_options_values records
		$products_options_values_query = olc_db_query(SELECT_ALL. TABLE_PRODUCTS_OPTIONS_VALUES . $where_language_id);
		while ($products_options_values = olc_db_fetch_array($products_options_values_query))
		{
			$products_options_values[$language_id_text]=$insert_id;
			olc_db_perform(TABLE_PRODUCTS_OPTIONS_VALUES,$products_options_values);
		}
		// create additional orders_status records
		$orders_status_query = olc_db_query(SELECT_ALL. TABLE_ORDERS_STATUS . $where_language_id);
		while ($orders_status = olc_db_fetch_array($orders_status_query))
		 {
			$orders_status[$language_id_text]=$insert_id;
			olc_db_perform(TABLE_ORDERS_STATUS,$orders_status);
		}
		// create additional customers status
		$customers_status_query = olc_db_query(SELECT_ALL. TABLE_CUSTOMERS_STATUS . $where_language_id);
		while ($customers_status=olc_db_fetch_array($customers_status_query))
		{
			$customers_status[$language_id_text]=$insert_id;
			olc_db_perform(TABLE_CUSTOMERS_STATUS,$customers_status);
		}
		// create additional coupons_description
		$coupons_description_query = olc_db_query(SELECT_ALL. TABLE_COUPONS_DESCRIPTION . $where_language_id);
		while ($coupons_description=olc_db_fetch_array($coupons_description_query))
		{
			$coupons_description[$language_id_text]=$insert_id;
			olc_db_perform( TABLE_COUPONS_DESCRIPTION,$coupons_description	);
		}
		// create additional coupons_description
		$coupons_description_query = olc_db_query(SELECT_ALL. TABLE_COUPONS_DESCRIPTION . $where_language_id);
		while ($coupons_description=olc_db_fetch_array($coupons_description_query))
		{
			$coupons_description[$language_id_text]=$insert_id;
			olc_db_perform( TABLE_COUPONS_DESCRIPTION,$coupons_description	);
		}
		// create additional products_vpe records
		$products_vpe_query = olc_db_query(SELECT_ALL. TABLE_PRODUCTS_VPE . $where_language_id);
		while ($products_vpe = olc_db_fetch_array($products_vpe_query))
		{
			$products_vpe[$language_id_text]=$insert_id;
			olc_db_perform(TABLE_PRODUCTS_VPE,$products_vpe);
		}
		// create additional shipping_status records
		$shipping_status = olc_db_query(SELECT_ALL. TABLE_SHIPPING_STATUS . $where_language_id);
		while ($shipping_status = olc_db_fetch_array($shipping_status_query))
		{
			$shipping_status[$language_id_text]=$insert_id;
			olc_db_perform(TABLE_SHIPPING_STATUS,$shipping_status);
		}

		// create content manager data
		$content_manager_query = olc_db_query(SELECT_ALL. TABLE_CONTENT_MANAGER . $where_languages_id);
		while ($content_manager=olc_db_fetch_array($content_manager_query))
		{
			$content_manager[$languages_id_text]=$insert_id;
			unset($content_manager['content_id']);
			olc_db_perform(TABLE_CONTENT_MANAGER,$content_manager);
		}
		// create product_content data
		$product_content_query = olc_db_query(SELECT_ALL. TABLE_PRODUCTS_CONTENT . $where_languages_id);
		while ($product_content=olc_db_fetch_array($product_content_query))
		{
			$product_content[$languages_id_text]=$insert_id;
			unset($product_content['content_id']);
			$product_content['content_read']=0;
			olc_db_perform(TABLE_CONTENT_MANAGER,$product_content);
		}

		if ($_POST['default'] == 'on')
		{
			olc_db_query(SQL_UPDATE . TABLE_CONFIGURATION . " set configuration_value = '" . olc_db_input($code) .
			"' where configuration_key = 'DEFAULT_LANGUAGE'");
		}
		//olc_redirect(olc_href_link(FILENAME_LANGUAGES, 'page=' . $page . '&lID=' . $insert_id));
		break;
	case 'save':
		$name = $_POST['name'];
		$code = $_POST['code'];
		$image = $_POST['image'];
		$directory = $_POST['directory'];
		$sort_order = $_POST['sort_order'];
		$charset = $_POST['charset'];
		olc_db_query(SQL_UPDATE . TABLE_LANGUAGES . " set
		name = '" . olc_db_input($name) . "',
		code = '" . olc_db_input($code) . "',
		image = '" . olc_db_input($image) . "',
		directory = '" . olc_db_input($directory) . "',
		sort_order = '" . olc_db_input($sort_order) . "',
		language_charset = '" . olc_db_input($charset) . "'
		where languages_id = " . olc_db_input($lID));

		if ($_POST['default'] == 'on')
		{
			olc_db_query(SQL_UPDATE . TABLE_CONFIGURATION . " set configuration_value = '" . olc_db_input($code) .
			"' where configuration_key = 'DEFAULT_LANGUAGE'");
		}
		//olc_redirect(olc_href_link(FILENAME_LANGUAGES, 'page=' . $page . '&lID=' . $lID));
		break;

	case 'deleteconfirm':
		$is_delete=true;
		$lng_query = olc_db_query("select languages_id from " . TABLE_LANGUAGES .
		" where code = '" . DEFAULT_LANGUAGE . APOS);
		$lng = olc_db_fetch_array($lng_query);
		$languages_id_text="languages_id";
		if ($lng[$languages_id_text] != $lID)
		{
			//Do not delete default language
			$where_language_id=SQL_WHERE."language_id".EQUAL.$lID;
			$where_languages_id=SQL_WHERE.$languages_id_text.EQUAL.$lID;
			$sql_commands=Array(
			DELETE_FROM.TABLE_CATEGORIES_DESCRIPTION.$where_language_id,
			DELETE_FROM.TABLE_PRODUCTS_DESCRIPTION.$where_language_id,
			DELETE_FROM.TABLE_PRODUCTS_OPTIONS.$where_language_id,
			DELETE_FROM.TABLE_PRODUCTS_OPTIONS_VALUES.$where_language_id,
			DELETE_FROM.TABLE_MANUFACTURERS_INFO.$where_languages_id,
			DELETE_FROM.TABLE_ORDERS_STATUS.$where_language_id,
			DELETE_FROM.TABLE_COUPONS_DESCRIPTION.$where_language_id,
			DELETE_FROM.TABLE_PRODUCTS_VPE.$where_language_id,

			DELETE_FROM.TABLE_SHIPPING_STATUS.$where_language_id,
			DELETE_FROM.TABLE_CONTENT_MANAGER.$where_languages_id,
			DELETE_FROM.TABLE_LANGUAGES.$where_languages_id,
			DELETE_FROM.TABLE_PRODUCTS_CONTENT.$where_languages_id,
			DELETE_FROM.TABLE_CUSTOMERS_STATUS.$where_language_id);
			while (list(,$sql)=each($sql_commands))
			{
				olc_db_query($sql);
			}
			/*
			olc_db_query(SQL_UPDATE . TABLE_CONFIGURATION .
			" set configuration_value = '' where configuration_key = 'DEFAULT_LANGUAGE'");
			*/
		}
		//olc_redirect(olc_href_link(FILENAME_LANGUAGES, 'page=' . $page));
		$lID = EMPTY_STRING;
		$page=EMPTY_STRING;
		$action=EMPTY_STRING;
		break;
	case 'delete':
		$lng_query = olc_db_query("select code from " . TABLE_LANGUAGES . " where languages_id = " . $lID);
		$lng = olc_db_fetch_array($lng_query);
		$remove_language = $lng['code'] != DEFAULT_LANGUAGE;
		if (!$remove_language)
		{
			$messageStack->add(ERROR_REMOVE_DEFAULT_LANGUAGE, 'error');
		}
		break;
}
?>
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td class="columnLeft2" nowrap="nowrap" valign="top">
    	<table border="0" cellspacing="1" cellpadding="1" class="columnLeft" nowrap="nowrap">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    	</table>
    </td>
<!-- body_text //-->
    <td width="100%" valign="top">
	    <table border="0" width="100%" cellspacing="0" cellpadding="2">
	      <tr>
	        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
			  <tr>
			    <td width="80" rowspan="2"><?php echo olc_image(DIR_WS_ICONS.'heading_configuration.gif'); ?></td>
			    <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
			  </tr>
			  <tr>
			    <td class="main" valign="top">OLC Konfiguration</td>
			  </tr>
			</table>
		</td>
  </tr>
  <tr>
    <td>
    	<table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top">
          	<table border="0" width="100%" cellspacing="0" cellpadding="2">
	            <tr class="dataTableHeadingRow">
	              <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_LANGUAGE_NAME; ?></td>
	              <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_LANGUAGE_CODE; ?></td>
	              <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
	            </tr>
<?php
$languages_query_raw = "select languages_id, name, code, image, directory, sort_order,language_charset from " .
	TABLE_LANGUAGES . " order by sort_order";
$languages_split = new splitPageResults($page, MAX_DISPLAY_SEARCH_RESULTS, $languages_query_raw, $languages_query_numrows);
$languages_query = olc_db_query($languages_query_raw);
$text_text='text';
$id_text='id';
$params='page=' . $page . '&lID=' . $lID;
$not_is_new=substr($action, 0, 3) != 'new';
while ($languages = olc_db_fetch_array($languages_query))
{
	$languages_id=$languages['languages_id'];
	$l_params='page=' . $page . '&lID=' . $languages_id;
	if (((!$lID) || (@$lID == $languages_id)) && (!$lInfo) && $not_is_new)
	{
		$lInfo = new objectInfo($languages);
	}
	$lang_name=$languages['name'];
	$is_delete=true;
	$is_default_language=DEFAULT_LANGUAGE == $languages['code'];
	if ((is_object($lInfo)) && ($languages_id == $lInfo->languages_id))
	{
		$content=
		'                  <tr class="dataTableRowSelected"
												onmouseover="this.style.cursor=\'hand\'"
												onclick="javascript:' .olc_onclick_link(FILENAME_LANGUAGES, $l_params. '&action=edit');
		$params=$l_params;
	}
	else
	{
		$content=
		'                  <tr class="dataTableRow"
													onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'"
													onmouseout="this.className=\'dataTableRow\'"
													onclick="javascript:' . olc_onclick_link(FILENAME_LANGUAGES, $l_params);
	}
	$content.='">' . NEW_LINE;
	if ($is_default_language)
	{
		$content.=
		'                			<td class="dataTableContent"><b>' . $lang_name . LPAREN . TEXT_DEFAULT . RPAREN.HTML_B_END;
	}
	else
	{
		$content.=
		'			                <td class="dataTableContent">' . $lang_name ;
	}
	echo $content.'</td>' . NEW_LINE;
?>
	              <td class="dataTableContent"><?php echo $languages['code']; ?></td>
	              <td class="dataTableContent" align="right">
                	<?php if ((is_object($lInfo)) && ($languages_id == $lInfo->languages_id))
                	{
                		echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif');
                	}
                	else
                	{
                		echo HTML_A_START . olc_href_link(FILENAME_LANGUAGES, 'page=' . $page . '&lID=' .
                		 $languages_id) . '">' .
                		 olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END; }
                	?>&nbsp;
                </td>
              </tr>
<?php
}
?>
              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top">
                    	<?php
                    		echo $languages_split->display_count($languages_query_numrows, MAX_DISPLAY_SEARCH_RESULTS,
                    			$page, TEXT_DISPLAY_NUMBER_OF_LANGUAGES); ?>
                    </td>
                    <td class="smallText" align="right">
                    	<?php echo $languages_split->display_links($languages_query_numrows, MAX_DISPLAY_SEARCH_RESULTS,
                    		MAX_DISPLAY_PAGE_LINKS, $page); ?>
                    </td>
                  </tr>
<?php
if (!$action)
{
?>
                  <tr>
                    <td align="right" colspan="2"><?php echo HTML_A_START .
											olc_href_link(FILENAME_LANGUAGES,$params.'&action=new').'">'.
	                    olc_image_button('button_new_language.gif', IMAGE_NEW_LANGUAGE) . HTML_A_END; ?>
	                   </td>
                  </tr>
<?php
}
?>
                </table></td>
              </tr>
            </table></td>
<?php
$direction_options =
array(array($id_text => EMPTY_STRING, $text_text => TEXT_INFO_LANGUAGE_DIRECTION_DEFAULT),
array($id_text => 'ltr', $text_text => TEXT_INFO_LANGUAGE_DIRECTION_LEFT_TO_RIGHT),
array($id_text => 'rtl', $text_text => TEXT_INFO_LANGUAGE_DIRECTION_RIGHT_TO_LEFT));

$heading = array();
$contents = array();
switch ($action)
{
	case 'new':
		$heading[] = array($text_text => HTML_B_START . TEXT_INFO_HEADING_NEW_LANGUAGE . HTML_B_END);
		$contents = array('form' => olc_draw_form('languages', FILENAME_LANGUAGES, 'action=insert'));
		$contents[] = array($text_text => TEXT_INFO_INSERT_INTRO);
		$contents[] = array($text_text => HTML_BR . TEXT_INFO_LANGUAGE_NAME . HTML_BR . olc_draw_input_field('name'));
		$contents[] = array($text_text => HTML_BR . TEXT_INFO_LANGUAGE_CODE . HTML_BR . olc_draw_input_field('code'));
		$contents[] = array($text_text => HTML_BR . TEXT_INFO_LANGUAGE_CHARSET . HTML_BR . olc_draw_input_field('charset'));
		$contents[] = array($text_text => HTML_BR . TEXT_INFO_LANGUAGE_IMAGE . HTML_BR . olc_draw_input_field('image', 'icon.gif'));
		$contents[] = array($text_text => HTML_BR . TEXT_INFO_LANGUAGE_DIRECTORY . HTML_BR . olc_draw_input_field('directory'));
		$contents[] = array($text_text => HTML_BR . TEXT_INFO_LANGUAGE_SORT_ORDER . HTML_BR . olc_draw_input_field('sort_order'));
		$contents[] = array($text_text => HTML_BR . olc_draw_checkbox_field('default') . BLANK . TEXT_SET_DEFAULT);
		$contents[] = array('align' => 'center', $text_text => HTML_BR . olc_image_submit('button_insert.gif', IMAGE_INSERT) .
			BLANK.HTML_A_START . olc_href_link(FILENAME_LANGUAGES, $params) . '">' .
			olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;
	case 'edit':
		$heading[] = array($text_text => HTML_B_START . TEXT_INFO_HEADING_EDIT_LANGUAGE . HTML_B_END);
		$contents = array('form' => olc_draw_form('languages', FILENAME_LANGUAGES, $params . '&action=save'));
		$contents[] = array($text_text => TEXT_INFO_EDIT_INTRO);
		$contents[] = array($text_text => HTML_BR . TEXT_INFO_LANGUAGE_NAME . HTML_BR . olc_draw_input_field('name', $lInfo->name));
		$contents[] = array($text_text => HTML_BR . TEXT_INFO_LANGUAGE_CODE . HTML_BR . olc_draw_input_field('code', $lInfo->code));
		$contents[] = array($text_text => HTML_BR . TEXT_INFO_LANGUAGE_CHARSET . HTML_BR .
			olc_draw_input_field('charset', $lInfo->language_charset));
		$contents[] = array($text_text => HTML_BR . TEXT_INFO_LANGUAGE_IMAGE . HTML_BR .
			olc_draw_input_field('image', $lInfo->image));
		$contents[] = array($text_text => HTML_BR . TEXT_INFO_LANGUAGE_DIRECTORY . HTML_BR .
			olc_draw_input_field('directory', $lInfo->directory));
		$contents[] = array($text_text => HTML_BR . TEXT_INFO_LANGUAGE_SORT_ORDER . HTML_BR .
			olc_draw_input_field('sort_order', $lInfo->sort_order));
		if (DEFAULT_LANGUAGE != $lInfo->code)
		{
			$contents[] = array($text_text => HTML_BR .
				olc_draw_checkbox_field('default') . BLANK . TEXT_SET_DEFAULT);
		}
		$contents[] = array('align' => 'center', $text_text => HTML_BR . olc_image_submit('button_update.gif', IMAGE_UPDATE) .
			BLANK.HTML_A_START . olc_href_link(FILENAME_LANGUAGES, $params) . '">' .
			olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;
	case 'delete':
		$heading[] = array($text_text => HTML_B_START . TEXT_INFO_HEADING_DELETE_LANGUAGE . HTML_B_END);
		$contents[] = array($text_text => TEXT_INFO_DELETE_INTRO);
		$contents[] = array($text_text => '<br/><b>' . $lInfo->name . HTML_B_END);
		$contents[] = array('align' => 'center', $text_text => HTML_BR . (($remove_language) ? HTML_A_START .
		olc_href_link(FILENAME_LANGUAGES, $params . '&action=deleteconfirm') . '">' .
		olc_image_button('button_delete.gif', IMAGE_DELETE) . HTML_A_END : EMPTY_STRING) . BLANK.HTML_A_START .
		olc_href_link(FILENAME_LANGUAGES, $params) . '">' .
		olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;
	default:
		if (is_object($lInfo))
		{
			$heading[] = array($text_text => HTML_B_START . $lInfo->name . HTML_B_END);

			$contents[] = array('align' => 'center', $text_text => HTML_A_START .
			olc_href_link(FILENAME_LANGUAGES, $params. '&action=edit') . '">' .
			olc_image_button('button_edit.gif', IMAGE_EDIT) . HTML_A_END.BLANK.HTML_A_START .
			olc_href_link(FILENAME_LANGUAGES, $params . '&action=delete') . '">' .
			olc_image_button('button_delete.gif', IMAGE_DELETE) . HTML_A_END);
			$contents[] = array($text_text => HTML_BR . TEXT_INFO_LANGUAGE_NAME . BLANK . $lInfo->name);
			$contents[] = array($text_text => TEXT_INFO_LANGUAGE_CODE . BLANK . $lInfo->code);
			$contents[] = array($text_text => TEXT_INFO_LANGUAGE_CHARSET_INFO . BLANK . $lInfo->language_charset);
			$lang_dir='lang/';
			$contents[] = array($text_text => HTML_BR .
				olc_image(ADMIN_PATH_PREFIX . $lang_dir.$lInfo->directory.SLASH.$lInfo->image, $lInfo->name));
			$contents[] = array($text_text => HTML_BR . TEXT_INFO_LANGUAGE_DIRECTORY . HTML_BR . $lang_dir .
			HTML_B_START . $lInfo->directory . HTML_B_END);
			$contents[] = array($text_text => HTML_BR . TEXT_INFO_LANGUAGE_SORT_ORDER . BLANK . $lInfo->sort_order);
		}
		break;
}
if ((olc_not_null($heading)) && (olc_not_null($contents)))
{
	$box = new box;
	echo '            <td width="25%" valign="top">' . NEW_LINE;
	echo $box->infoBox($heading, $contents);
	echo '            </td>' . NEW_LINE;
}
?>
          </tr>
        </table></td>
      </tr>
    </table></td>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
