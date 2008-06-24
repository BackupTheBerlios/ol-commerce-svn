<?php
/*------------------------------------------------------------------------------
$Id: affiliate_banners.php,v 1.1.1.1.2.1 2007/04/08 07:16:23 gswkaiser Exp $

OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

modified by http://www.ol-commerce.de, http://www.seifenparadies.de


Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------
based on:
(c) 2003 OSC-Affiliate (affiliate_banners.php, v 1.6 2003/07/12);
http://oscaffiliate.sourceforge.net/

Contribution based on:

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2002 - 2003 osCommerce
Copyright (c) 2003 netz-designer
Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

Copyright (c) 2002 - 2003 osCommerce

Released under the GNU General Public License
---------------------------------------------------------------------------*/

$div_field='<div id="spiffycalendar" class="text"></div>';
require('includes/application_top.php');

$affiliate_banner_extension = olc_banner_image_extension();

if ($_GET['action']) {
	switch ($_GET['action']) {
		case 'setaffiliate_flag':
			if ( ($_GET['affiliate_flag'] == '0') || ($_GET['affiliate_flag'] == '1') ) {
				olc_set_banner_status($_GET['abID'], $_GET['affiliate_flag']);
				$messageStack->add_session(SUCCESS_BANNER_STATUS_UPDATED, 'success');
			} else {
				$messageStack->add_session(ERROR_UNKNOWN_STATUS_FLAG, 'error');
			}

			olc_redirect(olc_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&abID=' . $_GET['abID']));
			break;
		case 'insert':
		case 'update':
			$affiliate_banners_id = olc_db_prepare_input($_POST['affiliate_banners_id']);
			$affiliate_banners_title = olc_db_prepare_input($_POST['affiliate_banners_title']);
			$affiliate_products_id  = olc_db_prepare_input($_POST['affiliate_products_id']);
			$new_affiliate_banners_group = olc_db_prepare_input($_POST['new_affiliate_banners_group']);
			$affiliate_banners_group = (empty($new_affiliate_banners_group)) ? olc_db_prepare_input($_POST['affiliate_banners_group']) : $new_affiliate_banners_group;
			$affiliate_banners_image_target = olc_db_prepare_input($_POST['affiliate_banners_image_target']);
			$affiliate_banners_image_local = olc_db_prepare_input($_POST['affiliate_banners_image_local']);
			$db_image_location = '';

			$affiliate_banner_error = false;
			if (empty($affiliate_banners_title)) {
				$messageStack->add(ERROR_BANNER_TITLE_REQUIRED, 'error');
				$affiliate_banner_error = true;
				$_GET['action'] = 'new';
			}
			/*      if (empty($affiliate_banners_group)) {
			$messageStack->add(ERROR_BANNER_GROUP_REQUIRED, 'error');
			$affiliate_banner_error = true;
			}
			*/
			if (($_FILES['affiliate_banners_image']['name'] != '')) {
				if (!is_writeable(DIR_FS_CATALOG_IMAGES)) {
					$messageStack->add(ERROR_IMAGE_DIRECTORY_NOT_WRITEABLE, 'error');
					$affiliate_banner_error = true;
					$_GET['action'] = 'new';
				}
				else {
					$image_location = DIR_FS_CATALOG_IMAGES . $_FILES['affiliate_banners_image']['name'];
					move_uploaded_file($_FILES['affiliate_banners_image']['tmp_name'], $image_location);

					$db_image_location = $_FILES['affiliate_banners_image']['name'];

					if (!$affiliate_products_id) $affiliate_products_id="0";
					$sql_data_array = array('affiliate_banners_title' => $affiliate_banners_title,
					'affiliate_products_id' => $affiliate_products_id,
					'affiliate_banners_image' => $db_image_location,
					'affiliate_banners_group' => $affiliate_banners_group);

					if ($_GET['action'] == 'insert') {
						$insert_sql_data = array('affiliate_date_added' => 'now()',
						'affiliate_status' => '1');
						$sql_data_array = array_merge($sql_data_array, $insert_sql_data);
						olc_db_perform(TABLE_AFFILIATE_BANNERS, $sql_data_array);
						$affiliate_banners_id = olc_db_insert_id();

						// Banner id 1 is generic Product Banner
						if ($affiliate_banners_id==1) olc_db_query(SQL_UPDATE . TABLE_AFFILIATE_BANNERS . " set affiliate_banners_id = affiliate_banners_id + 1");
						$messageStack->add_session(SUCCESS_BANNER_INSERTED, 'success');
					} elseif ($_GET['action'] == 'update') {
						$insert_sql_data = array('affiliate_date_status_change' => 'now()');
						$sql_data_array = array_merge($sql_data_array, $insert_sql_data);
						olc_db_perform(TABLE_AFFILIATE_BANNERS, $sql_data_array, 'update', 'affiliate_banners_id = \'' . $affiliate_banners_id . '\'');
						$messageStack->add_session(SUCCESS_BANNER_UPDATED, 'success');
					}
					olc_redirect(olc_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&abID=' . $affiliate_banners_id));
				}
			}
			break;
		case 'deleteconfirm':
			$affiliate_banners_id = olc_db_prepare_input($_GET['abID']);
			$delete_image = olc_db_prepare_input($_POST['delete_image']);

			if ($delete_image == 'on') {
				$affiliate_banner_query = olc_db_query("select affiliate_banners_image from " . TABLE_AFFILIATE_BANNERS . " where affiliate_banners_id = '" . olc_db_input($affiliate_banners_id) . APOS);
				$affiliate_banner = olc_db_fetch_array($affiliate_banner_query);
				if (file_exists(DIR_FS_CATALOG_IMAGES . $affiliate_banner['affiliate_banners_image'])) {
					if (is_writeable(DIR_FS_CATALOG_IMAGES . $affiliate_banner['affiliate_banners_image'])) {
						unlink(DIR_FS_CATALOG_IMAGES . $affiliate_banner['affiliate_banners_image']);
					} else {
						$messageStack->add_session(ERROR_IMAGE_IS_NOT_WRITEABLE, 'error');
					}
				} else {
					$messageStack->add_session(ERROR_IMAGE_DOES_NOT_EXIST, 'error');
				}
			}

			olc_db_query(DELETE_FROM . TABLE_AFFILIATE_BANNERS . " where affiliate_banners_id = '" . olc_db_input($affiliate_banners_id) . APOS);
			olc_db_query(DELETE_FROM . TABLE_AFFILIATE_BANNERS_HISTORY . " where affiliate_banners_id = '" . olc_db_input($affiliate_banners_id) . APOS);
			$messageStack->add_session(SUCCESS_BANNER_REMOVED, 'success');
			olc_redirect(olc_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page']));
			break;
	}
}
/*
$div_field='<div id="spiffycalendar" class="text"></div>';
require(DIR_WS_INCLUDES . 'header.php');
*/
?>
<script language="javascript" type="text/javascript"><!--
function popupImageWindow(url) {
	window.open(url,'popupImageWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=100,height=100,screenX=150,screenY=150,top=150,left=150')
}
//--></script>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
<tr>
<td class="columnLeft2" nowrap="nowrap" valign="top"><table border="0" cellspacing="1" cellpadding="1" class="columnLeft" nowrap="nowrap">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
</table></td>
<!-- body_text //-->
<td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
<tr>
<td><table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr>
<td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
<td class="pageHeading" align="right"><?php echo olc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
</tr>
</table></td>
</tr>
<?php
if ($_GET['action'] == 'new') {
	$form_action = 'insert';
	if ($_GET['abID']) {
		$abID = olc_db_prepare_input($_GET['abID']);
		$form_action = 'update';

		$affiliate_banner_query = olc_db_query("select * from " . TABLE_AFFILIATE_BANNERS . " where affiliate_banners_id = '" . olc_db_input($abID) . APOS);
		$affiliate_banner = olc_db_fetch_array($affiliate_banner_query);

		$abInfo = new objectInfo($affiliate_banner);
	} elseif ($_POST) {
		$abInfo = new objectInfo($_POST);
	} else {
		$abInfo = new objectInfo(array());
	}

	$groups_array = array();
	$groups_query = olc_db_query("select distinct affiliate_banners_group from " . TABLE_AFFILIATE_BANNERS . " order by affiliate_banners_group");
	while ($groups = olc_db_fetch_array($groups_query)) {
		$groups_array[] = array('id' => $groups['affiliate_banners_group'], 'text' => $groups['affiliate_banners_group']);
	}
	?>
	<tr>
	<td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
	</tr>
	<tr><?php echo olc_draw_form('new_banner', FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&action=' . $form_action, 'post', 'enctype="multipart/form-data"'); if ($form_action == 'update') echo olc_draw_hidden_field('affiliate_banners_id', $abID); ?>
	<td><table border="0" cellspacing="2" cellpadding="2">
	<tr>
	<td class="main"><?php echo TEXT_BANNERS_TITLE; ?></td>
	<td class="main"><?php echo olc_draw_input_field('affiliate_banners_title', $abInfo->affiliate_banners_title, '', true); ?></td>
	</tr>
	<tr>
	<td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
	</tr>
	<tr>
	<td class="main"><?php echo TEXT_BANNERS_LINKED_PRODUCT; ?></td>
	<td class="main"><?php echo olc_draw_input_field('affiliate_products_id', $abInfo->affiliate_products_id, '', false); ?></td>
	</tr>
	<tr>
	<td class="main" colspan=2><?php echo TEXT_BANNERS_LINKED_PRODUCT_NOTE ?></td>
	</tr>
	<tr>
	<td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
	</tr>
	<?php
	/*
	<tr>
	<td class="main" valign="top"><?php echo TEXT_BANNERS_GROUP; ?></td>
	<td class="main"><?php echo olc_draw_pull_down_menu('affiliate_banners_group', $groups_array, $abInfo->affiliate_banners_group) . TEXT_BANNERS_NEW_GROUP . HTML_BR . olc_draw_input_field('new_affiliate_banners_group', '', '', ((sizeof($groups_array) > 0) ? false : true)); ?></td>
	</tr>
	<tr>
	<td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
	</tr>
	*/
	?>
	<tr>
	<td class="main" valign="top"><?php echo TEXT_BANNERS_IMAGE; ?></td>
	<td class="main"><?php echo olc_draw_file_field('affiliate_banners_image') . BLANK . TEXT_BANNERS_IMAGE_LOCAL . HTML_BR . DIR_FS_CATALOG_IMAGES . olc_draw_input_field('affiliate_banners_image_local', $abInfo->affiliate_banners_image); ?></td>
	</tr>
	<tr>
	<td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
	</tr>
	<tr>
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td class="main" align="right" valign="top" nowrap="nowrap"><?php echo (($form_action == 'insert') ? olc_image_submit('button_insert.gif', IMAGE_INSERT) : olc_image_submit('button_update.gif', IMAGE_UPDATE)). '&nbsp;&nbsp;<a href="' . olc_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&abID=' . $_GET['abID']) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END; ?></td>
	</tr>
	</table></td>
	</form></tr>
	<?php
} else {
	?>
	<tr>
	<td><table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
	<td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr class="dataTableHeadingRow">
	<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_BANNERS; ?></td>
	<td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRODUCT_ID; ?></td>
	<td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATISTICS; ?></td>
	<td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
	</tr>
	<?php
	$affiliate_banners_query_raw = "select * from " . TABLE_AFFILIATE_BANNERS . " order by affiliate_banners_title, affiliate_banners_group";
	$affiliate_banners_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $affiliate_banners_query_raw, $affiliate_banners_query_numrows);
	$affiliate_banners_query = olc_db_query($affiliate_banners_query_raw);
	while ($affiliate_banners = olc_db_fetch_array($affiliate_banners_query)) {
		$info_query = olc_db_query("select sum(affiliate_banners_shown) as affiliate_banners_shown, sum(affiliate_banners_clicks) as affiliate_banners_clicks from " . TABLE_AFFILIATE_BANNERS_HISTORY . " where affiliate_banners_id = '" . $affiliate_banners['affiliate_banners_id'] . APOS);
		$info = olc_db_fetch_array($info_query);

		if (((!$_GET['abID']) || ($_GET['abID'] == $affiliate_banners['affiliate_banners_id'])) && (!$abInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
			$abInfo_array = array_merge($affiliate_banners, $info);
			$abInfo = new objectInfo($abInfo_array);
		}

		$affiliate_banners_shown = ($info['affiliate_banners_shown'] != '') ? $info['affiliate_banners_shown'] : '0';
		$affiliate_banners_clicked = ($info['affiliate_banners_clicks'] != '') ? $info['affiliate_banners_clicks'] : '0';

		if ( (is_object($abInfo)) && ($affiliate_banners['affiliate_banners_id'] == $abInfo->affiliate_banners_id) ) {
			echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' . olc_onclick_link(FILENAME_AFFILIATE_BANNERS,'abID=' . $abInfo->affiliate_banners_id . '&action=new')  . '">' . NEW_LINE;
		} else {
			echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' . olc_onclick_link(FILENAME_AFFILIATE_BANNERS, 'abID=' . $affiliate_banners['affiliate_banners_id']) . '">' . NEW_LINE;
		}
		?>
		<td class="dataTableContent"><?php echo '<a href="javascript:popupImageWindow(\'' . FILENAME_AFFILIATE_POPUP_IMAGE . '?banner=' . $affiliate_banners['affiliate_banners_id'] . '\')">' . olc_image(DIR_WS_IMAGES . 'icon_popup.gif', ICON_PREVIEW) . '</a>&nbsp;' . $affiliate_banners['affiliate_banners_title']; ?></td>
		<td class="dataTableContent" align="right"><?php if ($affiliate_banners['affiliate_products_id']>0) echo $affiliate_banners['affiliate_products_id']; else echo HTML_NBSP; ?></td>
		<td class="dataTableContent" align="right"><?php echo $affiliate_banners_shown . ' / ' . $affiliate_banners_clicked; ?></td>
		<td class="dataTableContent" align="right"><?php if ( (is_object($abInfo)) && ($affiliate_banners['affiliate_banners_id'] == $abInfo->affiliate_banners_id) ) { echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo HTML_A_START . olc_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&abID=' . $affiliate_banners['affiliate_banners_id']) . '">' . olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END; } ?>&nbsp;</td>
		</tr>
		<?php
	}
	?>
	<tr>
	<td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td class="smallText" valign="top"><?php echo $affiliate_banners_split->display_count($affiliate_banners_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_BANNERS); ?></td>
	<td class="smallText" align="right"><?php echo $affiliate_banners_split->display_links($affiliate_banners_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
	</tr>
	<tr>
	<td align="right" colspan="2"><?php echo HTML_A_START . olc_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'action=new') . '">' . olc_image_button('button_new_banner.gif', IMAGE_NEW_BANNER) . HTML_A_END; ?></td>
	</tr>
	</table></td>
	</tr>
	</table></td>
	<?php
	$heading = array();
	$contents = array();
	switch ($_GET['action']) {
		case 'delete':
			$heading[] = array('text' => HTML_B_START . $abInfo->affiliate_banners_title . HTML_B_END);

			$contents = array('form' => olc_draw_form('affiliate_banners', FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&abID=' . $abInfo->affiliate_banners_id . '&action=deleteconfirm'));
			$contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
			$contents[] = array('text' => '<br/><b>' . $abInfo->affiliate_banners_title . HTML_B_END);
			if ($abInfo->affiliate_banners_image) $contents[] = array('text' => HTML_BR . olc_draw_checkbox_field('delete_image', 'on', true) . BLANK . TEXT_INFO_DELETE_IMAGE);
			$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_delete.gif', IMAGE_DELETE) . '&nbsp;<a href="' . olc_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&abID=' . $_GET['abID']) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
			break;
		default:
			if (is_object($abInfo)) {
				$sql = "select products_name from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . $abInfo->affiliate_products_id . "' and language_id = '" . SESSION_LANGUAGE_ID . APOS;
				$product_description_query = olc_db_query($sql);
				$product_description = olc_db_fetch_array($product_description_query);
				$heading[] = array('text' => HTML_B_START . $abInfo->affiliate_banners_title . HTML_B_END);

				$contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&abID=' . $abInfo->affiliate_banners_id . '&action=new') . '">' . olc_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . olc_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&abID=' . $abInfo->affiliate_banners_id . '&action=delete') . '">' . olc_image_button('button_delete.gif', IMAGE_DELETE) . HTML_A_END);
				$contents[] = array('text' => $product_description['products_name']);
				$contents[] = array('text' => HTML_BR . TEXT_BANNERS_DATE_ADDED . BLANK . olc_date_short($abInfo->affiliate_date_added));
				$contents[] = array('text' => '' . sprintf(TEXT_BANNERS_STATUS_CHANGE, olc_date_short($abInfo->affiliate_date_status_change)));
			}
			break;
	}

	if ( (olc_not_null($heading)) && (olc_not_null($contents)) ) {
		echo '            <td width="25%" valign="top">' . NEW_LINE;

		$box = new box;
		echo $box->infoBox($heading, $contents);

		echo '            </td>' . NEW_LINE;
	}
	?>
	</tr>
	</table></td>
	</tr>
	<?php
}
?>
</table></td>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
