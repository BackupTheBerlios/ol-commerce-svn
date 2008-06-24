<?php
/* --------------------------------------------------------------
$Id: manufacturers.php,v 1.1.1.1.2.1 2007/04/08 07:16:29 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(manufacturers.php,v 1.52 2003/03/22); www.oscommerce.com
(c) 2003	    nextcommerce (manufacturers.php,v 1.9 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application_top.php');

$page=$_GET['page'];
$page_parameter='page='.$page;
$mID=olc_db_prepare_input($_GET['mID']);
$action=$_GET['action'];
switch ($action)
{
	case 'insert':
	case 'save':
		$manufacturers_id = $mID;
		$manufacturers_id_sql="manufacturers_id = '".olc_db_input($manufacturers_id) .APOS;
		$manufacturers_name = olc_db_prepare_input($_POST['manufacturers_name']);
		$sql_data_array = array('manufacturers_name' => $manufacturers_name);
		$is_insert=$action == 'insert';
		if ($is_insert)
		{
			$insert_sql_data = array('date_added' => 'now()');
			$sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
			olc_db_perform(TABLE_MANUFACTURERS, $sql_data_array);
			$manufacturers_id = olc_db_insert_id();
		} else{ //if ($action == 'save')
			$update_sql_data = array('last_modified' => 'now()');
			$sql_data_array = olc_array_merge($sql_data_array, $update_sql_data);
			olc_db_perform(TABLE_MANUFACTURERS, $sql_data_array, 'update', $manufacturers_id_sql);
		}
		$dir_manufacturers=DIR_FS_CATALOG_IMAGES."/manufacturers";
		if ($manufacturers_image = new upload('manufacturers_image', $dir_manufacturers))
		{
			if ($manufacturers_image->filename)
			{
				olc_db_query(SQL_UPDATE.TABLE_MANUFACTURERS."
				set manufacturers_image ='manufacturers/".$manufacturers_image->filename."' where ".$manufacturers_id_sql);
			}
		}
		$languages = olc_get_languages();
		$manufacturers_url_array = $_POST['manufacturers_url'];
		for ($i = 0, $n = sizeof($languages); $i < $n; $i++)
		{
			$language_id = $languages[$i]['id'];
			$sql_data_array = array('manufacturers_url' => olc_db_prepare_input($manufacturers_url_array[$language_id]));
			if ($is_insert)
			{
				$insert_sql_data = array('manufacturers_id' => $manufacturers_id,
				'languages_id' => $language_id);
				$sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
				olc_db_perform(TABLE_MANUFACTURERS_INFO, $sql_data_array);
			} else {	//if ($action == 'save') {
				olc_db_perform(TABLE_MANUFACTURERS_INFO, $sql_data_array, 'update',
				$manufacturers_id_sql." and languages_id = '".$language_id.APOS);
			}
		}
		if (USE_CACHE == TRUE_STRING_S)
		{
			olc_reset_cache_block('manufacturers');
		}
		//olc_redirect(olc_href_link(FILENAME_MANUFACTURERS, $page_parameter.'&mID='.$manufacturers_id));
		$mID=$manufacturers_id;
		break;

	case 'deleteconfirm':
		$manufacturers_id = $mID;
		$manufacturers_id_sql=" where manufacturers_id = '".olc_db_input($manufacturers_id) .APOS;
		if ($_POST['delete_image'] == 'on') {
			$manufacturer_query = olc_db_query("select manufacturers_image from ".TABLE_MANUFACTURERS.$manufacturers_id_sql);
			$manufacturer = olc_db_fetch_array($manufacturer_query);
			$image_location = DIR_FS_DOCUMENT_ROOT.DIR_WS_IMAGES.$manufacturer['manufacturers_image'];
			if (file_exists($image_location)) @unlink($image_location);
		}
		olc_db_query(DELETE_FROM.TABLE_MANUFACTURERS.$manufacturers_id_sql);
		olc_db_query(DELETE_FROM.TABLE_MANUFACTURERS_INFO.$manufacturers_id_sql);
		if ($_POST['delete_products'] == 'on')
		{
			$products_query = olc_db_query("select products_id from ".TABLE_PRODUCTS.$manufacturers_id_sql);
			while ($products = olc_db_fetch_array($products_query)) {
				olc_remove_product($products['products_id']);
			}
		} else {
			olc_db_query(SQL_UPDATE.TABLE_PRODUCTS." set manufacturers_id = ''".$manufacturers_id_sql);
		}

		if (USE_CACHE == TRUE_STRING_S)
		{
			olc_reset_cache_block('manufacturers');
		}
		//olc_redirect(olc_href_link(FILENAME_MANUFACTURERS, $page_parameter));
		$mID=EMPTY_STRING;
		break;
}
?>
<?php require(DIR_WS_INCLUDES.'header.php'); ?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td class="columnLeft2" nowrap="nowrap" valign="top"><table border="0" cellspacing="1" cellpadding="1" class="columnLeft" nowrap="nowrap">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES.'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo olc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_MANUFACTURERS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
$manufacturers_query_raw = "select manufacturers_id, manufacturers_name, manufacturers_image, date_added, last_modified from ".TABLE_MANUFACTURERS." order by manufacturers_name";
$manufacturers_split = new splitPageResults($page, MAX_DISPLAY_SEARCH_RESULTS, $manufacturers_query_raw, $manufacturers_query_numrows);
$manufacturers_query = olc_db_query($manufacturers_query_raw);
$not_is_new=substr($action, 0, 3) != 'new';
while ($manufacturers = olc_db_fetch_array($manufacturers_query)) {
	$manufacturers_id=$manufacturers['manufacturers_id'];
	if (((!$mID) || ($mID == $manufacturers_id)) && (!$mInfo) && $not_is_new)
	{
		$manufacturer_products_query = olc_db_query("select count(*) as products_count from ".TABLE_PRODUCTS .
		" where manufacturers_id = '".$manufacturers_id.APOS);
		$manufacturer_products = olc_db_fetch_array($manufacturer_products_query);

		$mInfo_array = olc_array_merge($manufacturers, $manufacturer_products);
		$mInfo = new objectInfo($mInfo_array);
	}
	if ( (is_object($mInfo)) && ($manufacturers_id == $mInfo->manufacturers_id) ) {
		echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:'.olc_onclick_link(FILENAME_MANUFACTURERS, $page_parameter.'&mID='.$manufacturers_id.'&action=edit').'">'.NEW_LINE;
	} else {
		echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="javascript:'.olc_onclick_link(FILENAME_MANUFACTURERS, $page_parameter.'&mID='.$manufacturers_id).'">'.NEW_LINE;
	}
?>
                <td class="dataTableContent"><?php echo $manufacturers['manufacturers_name']; ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($mInfo)) && ($manufacturers_id == $mInfo->manufacturers_id) ) { echo olc_image(DIR_WS_IMAGES.'icon_arrow_right.gif'); } else { echo HTML_A_START.olc_href_link(FILENAME_MANUFACTURERS, $page_parameter.'&mID='.$manufacturers_id).'">'.olc_image(DIR_WS_IMAGES.'icon_info.gif', IMAGE_ICON_INFO).HTML_A_END; } ?>&nbsp;</td>
              </tr>
<?php
}
?>
              <tr>
                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $manufacturers_split->display_count($manufacturers_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $page, TEXT_DISPLAY_NUMBER_OF_MANUFACTURERS); ?></td>
                    <td class="smallText" align="right"><?php echo $manufacturers_split->display_links($manufacturers_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $page); ?></td>
                  </tr>
                </table></td>
              </tr>
<?php
if ($action != 'new') {
?>
              <tr>
                <td align="right" colspan="2" class="smallText"><?php echo HTML_A_START.olc_href_link(FILENAME_MANUFACTURERS, $page_parameter.'&mID='.$mInfo->manufacturers_id.'&action=new').'">'.olc_image_button('button_insert.gif', IMAGE_INSERT).HTML_A_END; ?></td>
              </tr>
<?php
}
?>
            </table></td>
<?php
$heading = array();
$contents = array();
$field_size='size="40"';
switch ($action)
{
	case 'new':
		$heading[] = array('text' => HTML_B_START.TEXT_HEADING_NEW_MANUFACTURER.HTML_B_END);

		$contents = array('form' => olc_draw_form('manufacturers', FILENAME_MANUFACTURERS, 'action=insert', 'post',
		'enctype="multipart/form-data"'));
		$contents[] = array('text' => TEXT_NEW_INTRO);
		$contents[] = array('text' => HTML_BR.TEXT_MANUFACTURERS_NAME.HTML_BR.
		olc_draw_input_field('manufacturers_name',$field_size));
		$contents[] = array('text' => HTML_BR.TEXT_MANUFACTURERS_IMAGE.HTML_BR.olc_draw_file_field('manufacturers_image'));

		$manufacturer_inputs_string = '';
		$languages = olc_get_languages();
		for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
			$manufacturer_inputs_string .= HTML_BR.olc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/' .
			$languages[$i]['image'], $languages[$i]['name']).HTML_NBSP .
			olc_draw_input_field('manufacturers_url['.$languages[$i]['id'].']',$field_size);
		}

		$contents[] = array('text' => HTML_BR.TEXT_MANUFACTURERS_URL.$manufacturer_inputs_string);
		$contents[] = array('align' => 'center', 'text' => HTML_BR.olc_image_submit('button_save.gif', IMAGE_SAVE) .
		BLANK.HTML_A_START.olc_href_link(FILENAME_MANUFACTURERS, $page_parameter.'&mID='.$mID).'">' .
		olc_image_button('button_cancel.gif', IMAGE_CANCEL).HTML_A_END);
		break;

	case 'edit':
		$heading[] = array('text' => HTML_B_START.TEXT_HEADING_EDIT_MANUFACTURER.HTML_B_END);

		$contents = array('form' => olc_draw_form('manufacturers', FILENAME_MANUFACTURERS,
		$page_parameter.'&mID='.$mInfo->manufacturers_id.'&action=save', 'post', 'enctype="multipart/form-data"'));
		$contents[] = array('text' => TEXT_EDIT_INTRO);
		$contents[] = array('text' => HTML_BR.TEXT_MANUFACTURERS_NAME.HTML_BR .
		olc_draw_input_field('manufacturers_name', $mInfo->manufacturers_name,$field_size));
		$contents[] = array('text' => HTML_BR.TEXT_MANUFACTURERS_IMAGE.HTML_BR .
		olc_draw_file_field('manufacturers_image').HTML_BR.$mInfo->manufacturers_image);

		$manufacturer_inputs_string = '';
		$languages = olc_get_languages();
		for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
			$manufacturer_inputs_string .= HTML_BR.olc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/' .
			$languages[$i]['image'], $languages[$i]['name']).HTML_NBSP .
			olc_draw_input_field('manufacturers_url['.$languages[$i]['id'].']',
			olc_get_manufacturer_url($mInfo->manufacturers_id, $languages[$i]['id']),$field_size);
		}

		$contents[] = array('text' => HTML_BR.TEXT_MANUFACTURERS_URL.$manufacturer_inputs_string);
		$contents[] = array('align' => 'center', 'text' => HTML_BR.olc_image_submit('button_save.gif', IMAGE_SAVE) .
		BLANK.HTML_A_START.olc_href_link(FILENAME_MANUFACTURERS, $page_parameter.'&mID='.$mInfo->manufacturers_id).'">' .
		olc_image_button('button_cancel.gif', IMAGE_CANCEL).HTML_A_END);
		break;

	case 'delete':
		$heading[] = array('text' => HTML_B_START.TEXT_HEADING_DELETE_MANUFACTURER.HTML_B_END);

		$contents = array('form' => olc_draw_form('manufacturers', FILENAME_MANUFACTURERS,
		$page_parameter.'&mID='.$mInfo->manufacturers_id.'&action=deleteconfirm'));
		$contents[] = array('text' => TEXT_DELETE_INTRO);
		$contents[] = array('text' => '<br/><b>'.$mInfo->manufacturers_name.HTML_B_END);
		$contents[] = array('text' => HTML_BR.olc_draw_checkbox_field('delete_image', '', true).BLANK.TEXT_DELETE_IMAGE);
		if ($mInfo->products_count > 0) {
			$contents[] = array('text' => HTML_BR.olc_draw_checkbox_field('delete_products').BLANK.TEXT_DELETE_PRODUCTS);
			$contents[] = array('text' => HTML_BR.sprintf(TEXT_DELETE_WARNING_PRODUCTS, $mInfo->products_count));
		}
		$contents[] = array('align' => 'center', 'text' => HTML_BR.olc_image_submit('button_delete.gif', IMAGE_DELETE) .
		BLANK.HTML_A_START.olc_href_link(FILENAME_MANUFACTURERS, $page_parameter.'&mID='.$mInfo->manufacturers_id).'">' .
		olc_image_button('button_cancel.gif', IMAGE_CANCEL).HTML_A_END);
		break;
	default:
		if (is_object($mInfo)) {
			$heading[] = array('text' => HTML_B_START.$mInfo->manufacturers_name.HTML_B_END);

			$contents[] = array('align' => 'center', 'text' => HTML_A_START .
			olc_href_link(FILENAME_MANUFACTURERS, $page_parameter.'&mID='.$mInfo->manufacturers_id.'&action=edit').'">' .
			olc_image_button('button_edit.gif', IMAGE_EDIT).'</a>
			<a href="'.olc_href_link(FILENAME_MANUFACTURERS, $page_parameter.'&mID='.$mInfo->manufacturers_id.'&action=delete').'">'.
			olc_image_button('button_delete.gif', IMAGE_DELETE).HTML_A_END);
			$contents[] = array('text' => HTML_BR.TEXT_DATE_ADDED.BLANK.olc_date_short($mInfo->date_added));
			if (olc_not_null($mInfo->last_modified))
				$contents[] = array('text' => TEXT_LAST_MODIFIED.BLANK.olc_date_short($mInfo->last_modified));
			$contents[] = array('text' => HTML_BR.olc_info_image($mInfo->manufacturers_image, $mInfo->manufacturers_name));
			$contents[] = array('text' => HTML_BR.TEXT_PRODUCTS.BLANK.$mInfo->products_count);
		}
		break;
}

if ( (olc_not_null($heading)) && (olc_not_null($contents)) ) {
	echo '            <td width="25%" valign="top">'.NEW_LINE;

	$box = new box;
	echo $box->infoBox($heading, $contents);

	echo '            </td>'.NEW_LINE;
}
?>
          	</tr>
        	</table>
        </td>
      </tr>
    </table>
  </td>
<?php require(DIR_WS_INCLUDES.'application_bottom.php'); ?>
