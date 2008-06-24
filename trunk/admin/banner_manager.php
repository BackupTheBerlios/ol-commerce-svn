<?php
/* --------------------------------------------------------------
$Id: banner_manager.php,v 1.1.1.1.2.1 2007/04/08 07:16:25 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(banner_manager.php,v 1.70 2003/03/22); www.oscommerce.com
(c) 2003	    nextcommerce (banner_manager.php,v 1.9 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

$div_field='<div id="spiffycalendar" class="text"></div>';
require('includes/application_top.php');

$banner_extension = olc_banner_image_extension();
$page=$_GET['page'];
$page_parameter='page=' . $page;
$action=$_GET['action'];
$flag=$_GET['flag'];
$bID=olc_db_prepare_input($_GET['bID']);
if ($action) {
	switch ($action) {
		case 'setflag':
			if ( ($flag == '0') || ($flag == '1') )
			{
				olc_set_banner_status($bID, $flag);
				$messageStack->add_session(SUCCESS_BANNER_STATUS_UPDATED, 'success');
			} else {
				$messageStack->add_session(ERROR_UNKNOWN_STATUS_FLAG, 'error');
			}
			olc_redirect(olc_href_link(FILENAME_BANNER_MANAGER, $page_parameter . '&bID=' . $bID));
			break;
		case 'insert':
		case 'update':
			$banners_id = olc_db_prepare_input($_POST['banners_id']);
			$banners_title = olc_db_prepare_input($_POST['banners_title']);
			$banners_url = olc_db_prepare_input($_POST['banners_url']);
			$new_banners_group = olc_db_prepare_input($_POST['new_banners_group']);
			$banners_group = (empty($new_banners_group)) ? olc_db_prepare_input($_POST['banners_group']) : $new_banners_group;
			$html_text = olc_db_prepare_input($_POST['html_text']);
			$banners_image_local = olc_db_prepare_input($_POST['banners_image_local']);
			$banners_image_target = olc_db_prepare_input($_POST['banners_image_target']);
			$db_image_location = EMPTY_STRING;
			$banner_error = false;
			if (empty($banners_title)) {
				$messageStack->add(ERROR_BANNER_TITLE_REQUIRED, 'error');
				$banner_error = true;
			}
			if (empty($banners_group)) {
				$messageStack->add(ERROR_BANNER_GROUP_REQUIRED, 'error');
				$banner_error = true;
			}
			if (empty($html_text)) {
				if (!$banners_image = new upload('banners_image', DIR_FS_CATALOG_IMAGES.'banner/' . $banners_image_target)) {
					$banner_error = true;
				}
			}
			if (!$banner_error) {
				$db_image_location = (olc_not_null($banners_image_local)) ? $banners_image_local : $banners_image_target .
				$banners_image->filename;
				$sql_data_array = array('banners_title' => $banners_title,
				'banners_url' => $banners_url,
				'banners_image' => $db_image_location,
				'banners_group' => $banners_group,
				'banners_html_text' => $html_text);
				if ($action == 'insert') {
					$insert_sql_data = array('date_added' => 'now()',
					'status' => '1');
					$sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
					olc_db_perform(TABLE_BANNERS, $sql_data_array);
					$banners_id = olc_db_insert_id();
					$messageStack->add_session(SUCCESS_BANNER_INSERTED, 'success');
				} elseif ($action == 'update') {
					olc_db_perform(TABLE_BANNERS, $sql_data_array, 'update', 'banners_id = \'' . $banners_id . '\'');
					$messageStack->add_session(SUCCESS_BANNER_UPDATED, 'success');
				}
				$expires_date=olc_db_prepare_input($_POST['expires_date']);
				if ($expires_date)
				{
					list($day, $month, $year) = explode('.', $expires_date);
					$expires_date = $year .
					((strlen($month) == 1) ? '0' . $month : $month) .
					((strlen($day) == 1) ? '0' . $day : $day);
					$sql_update=" set expires_date = '" . $expires_date ."', expires_impressions = null";
				}
				else
				{
					$impressions=olc_db_prepare_input($_POST['impressions']);
					if ($impressions)
					{
						$sql_update=" set expires_impressions = '" . $impressions . "', expires_date = null";
					}
				}
				$date_scheduled=olc_db_prepare_input($_POST['date_scheduled']);
				if ($date_scheduled)
				{
					list($day, $month, $year) = explode('.', $date_scheduled);
					$date_scheduled = $year .
					((strlen($month) == 1) ? '0' . $month : $month) .
					((strlen($day) == 1) ? '0' . $day : $day);
					$sql_update.=", status = '0', date_scheduled = '" . $date_scheduled;
				}
				olc_db_query(SQL_UPDATE . TABLE_BANNERS . $sql_update . " where banners_id = '" . $banners_id . APOS);
				olc_redirect(olc_href_link(FILENAME_BANNER_MANAGER, $page_parameter . '&bID=' . $banners_id));
			} else {
				$action = 'new';
			}
			break;
		case 'deleteconfirm':
			$banners_id = $bID;
			$delete_image = olc_db_prepare_input($_POST['delete_image']);
			if ($delete_image == 'on') {
				$sql_where=" where banners_id = '" . $banners_id . APOS;
				$banner_query = olc_db_query("select banners_image from " . TABLE_BANNERS . $sql_where);
				$banner = olc_db_fetch_array($banner_query);
				$file=DIR_FS_CATALOG_IMAGES . $banner['banners_image'];
				if (is_file($file)) {
					if (is_writeable($file))
					{
						unlink($file);
					}
					else
					{
						$messageStack->add_session(ERROR_IMAGE_IS_NOT_WRITEABLE, 'error');
					}
				}
				else
				{
					$messageStack->add_session(ERROR_IMAGE_DOES_NOT_EXIST, 'error');
				}
			}
			$sql_delete=DELETE_FROM;
			olc_db_query($sql_delete . TABLE_BANNERS . $sql_where);
			olc_db_query($sql_delete . TABLE_BANNERS_HISTORY . $sql_where);
			if ($banner_extension)
			{
				if (function_exists('imagecreate'))
				{
					$file0=DIR_WS_IMAGES . 'graphs/banner_#-' . $banners_id . DOT . $banner_extension;
					$banners=array('infobox','daily','monthly','yearly');
					for ($banner=0;$banner<sizeof($banners);$banner++)
					{
						$file=str_replace(HASH,$banners[$banner],$file0);
						if (is_file($file)) {
							if (is_writeable($file))
							{
								unlink($file);
							}
						}
					}
				}
			}
			$messageStack->add_session(SUCCESS_BANNER_REMOVED, 'success');
			olc_redirect(olc_href_link(FILENAME_BANNER_MANAGER, $page_parameter));
	}
}

// check if the graphs directory exists
$dir_ok = false;
if ( (function_exists('imagecreate')) && ($banner_extension) ) {
	if (is_dir(DIR_WS_IMAGES . 'graphs')) {
		if (is_writeable(DIR_WS_IMAGES . 'graphs')) {
			$dir_ok = true;
		} else {
			$messageStack->add(ERROR_GRAPHS_DIRECTORY_NOT_WRITEABLE, 'error');
		}
	} else {
		$messageStack->add(ERROR_GRAPHS_DIRECTORY_DOES_NOT_EXIST, 'error');
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
if ($action == 'new')
{
	if ($bID)
	{
		$form_action = 'update';
		$banner_query = olc_db_query("select banners_title, banners_url, banners_image, banners_group, banners_html_text, status, date_format(date_scheduled, '%d.%m.%Y') as date_scheduled, date_format(expires_date, '%d.%m.%Y') as expires_date, expires_impressions, date_status_change from " . TABLE_BANNERS . " where banners_id = '" . $bID . APOS);
		$banner = olc_db_fetch_array($banner_query);
		$bInfo = new objectInfo($banner);
	}
	else
	{
		$form_action = 'insert';
		if ($_POST) {
			$bInfo = new objectInfo($_POST);
		} else {
			$bInfo = new objectInfo(array());
		}
	}
	$groups_array = array();
	$groups_query = olc_db_query("select distinct banners_group from " . TABLE_BANNERS . " order by banners_group");
	while ($groups = olc_db_fetch_array($groups_query)) {
		$groups_array[] = array('id' => $groups['banners_group'], 'text' => $groups['banners_group']);
	}
	if (NOT_USE_AJAX_ADMIN)
	{
		echo '
<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
';
	}
	?>
	<tr>
	<td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
	</tr>
	<tr><?php echo olc_draw_form('new_banner', FILENAME_BANNER_MANAGER, $page_parameter . '&action=' . $form_action, 'post', 'enctype="multipart/form-data"'); if ($form_action == 'update') echo olc_draw_hidden_field('banners_id', $bID); ?>
	<td><table border="0" cellspacing="0" cellpadding="2">
	<tr>
	<td class="main"><?php echo TEXT_BANNERS_TITLE; ?></td>
	<td class="main"><?php echo olc_draw_input_field('banners_title', $bInfo->banners_title, EMPTY_STRING, true); ?></td>
	</tr>
	<tr>
	<td class="main"><?php echo TEXT_BANNERS_URL; ?></td>
	<td class="main"><?php echo olc_draw_input_field('banners_url', $bInfo->banners_url); ?></td>
	</tr>
	<tr>
	<td class="main" valign="top"><?php echo TEXT_BANNERS_GROUP; ?></td>
	<td class="main"><?php echo olc_draw_pull_down_menu('banners_group', $groups_array, $bInfo->banners_group) . TEXT_BANNERS_NEW_GROUP . HTML_BR . olc_draw_input_field('new_banners_group', EMPTY_STRING, EMPTY_STRING, ((sizeof($groups_array) > 0) ? false : true)); ?></td>
	</tr>
	<tr>
	<td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
	</tr>
	<tr>
	<td class="main" valign="top"><?php echo TEXT_BANNERS_IMAGE; ?></td>
	<td class="main"><?php echo olc_draw_file_field('banners_image') . BLANK . TEXT_BANNERS_IMAGE_LOCAL . HTML_BR . DIR_FS_CATALOG_IMAGES.'banner/' . olc_draw_input_field('banners_image_local', $bInfo->banners_image); ?></td>
	</tr>
	<tr>
	<td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
	</tr>
	<tr>
	<td class="main"><?php echo TEXT_BANNERS_IMAGE_TARGET; ?></td>
	<td class="main"><?php echo DIR_FS_CATALOG_IMAGES.'banner/' . olc_draw_input_field('banners_image_target'); ?></td>
	</tr>
	<tr>
	<td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
	</tr>
	<tr>
	<td valign="top" class="main"><?php echo TEXT_BANNERS_HTML_TEXT; ?></td>
	<td class="main"><?php echo olc_draw_textarea_field('html_text', 'soft', '60', '5', $bInfo->banners_html_text); ?></td>
	</tr>
	<tr>
	<td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
	</tr>
	<tr>
	<td class="main">
	<?php
	$spiffy_date_field_caption=TEXT_BANNERS_SCHEDULED_AT;
	$spiffy_date=$bInfo->date_scheduled;
	$spiffy_control_name="dateScheduled";
	$spiffy_form_name='new_banner';
	$spiffy_date_field_name='date_scheduled';
	$create_spiffy_control=DIR_FS_INC.'olc_create_spiffy_control.inc.php';
	include($create_spiffy_control);
	?>
	</td>
	</tr>
	<tr>
	<td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
	</tr>
	<tr>
	<td valign="top" class="main">
	<?php
	$spiffy_date_field_caption=TEXT_BANNERS_EXPIRES_ON;
	$spiffy_date=$bInfo->expires_date;
	$spiffy_control_name="dateExpires";
	$spiffy_form_name='new_banner';
	$spiffy_date_field_name='expires_date';
	include($create_spiffy_control);

	echo TEXT_BANNERS_OR_AT . HTML_BR .
	olc_draw_input_field('impressions', $bInfo->expires_impressions, 'maxlength="7" size="7"') .
	BLANK . TEXT_BANNERS_IMPRESSIONS; ?>
	</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
	</tr>
	<tr>
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td class="main"><?php echo TEXT_BANNERS_BANNER_NOTE . HTML_BR . TEXT_BANNERS_INSERT_NOTE . HTML_BR . TEXT_BANNERS_EXPIRCY_NOTE . HTML_BR . TEXT_BANNERS_SCHEDULE_NOTE; ?></td>
	<td class="main" align="right" valign="top" nowrap="nowrap"><?php echo (($form_action == 'insert') ? olc_image_submit('button_insert.gif', IMAGE_INSERT) : olc_image_submit('button_update.gif', IMAGE_UPDATE)). '&nbsp;&nbsp;<a href="' . olc_href_link(FILENAME_BANNER_MANAGER, $page_parameter . '&bID=' . $bID) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END; ?></td>
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
	<td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_GROUPS; ?></td>
	<td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATISTICS; ?></td>
	<td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>
	<td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
	</tr>
	<?php
	$banners_query_raw = "select banners_id, banners_title, banners_image, banners_group, status, expires_date, expires_impressions, date_status_change, date_scheduled, date_added from " . TABLE_BANNERS . " order by banners_title, banners_group";
	$banners_split = new splitPageResults($page, MAX_DISPLAY_SEARCH_RESULTS, $banners_query_raw, $banners_query_numrows);
	$banners_query = olc_db_query($banners_query_raw);
	while ($banners = olc_db_fetch_array($banners_query)) {
		$info_query = olc_db_query("select sum(banners_shown) as banners_shown, sum(banners_clicked) as banners_clicked from " . TABLE_BANNERS_HISTORY . " where banners_id = '" . $banners['banners_id'] . APOS);
		$info = olc_db_fetch_array($info_query);

		if (((!$bID) || ($bID == $banners['banners_id'])) && (!$bInfo) && (substr($action, 0, 3) != 'new')) {
			$bInfo_array = olc_array_merge($banners, $info);
			$bInfo = new objectInfo($bInfo_array);
		}

		$banners_shown = ($info['banners_shown'] != EMPTY_STRING) ? $info['banners_shown'] : '0';
		$banners_clicked = ($info['banners_clicked'] != EMPTY_STRING) ? $info['banners_clicked'] : '0';

		if ( (is_object($bInfo)) && ($banners['banners_id'] == $bInfo->banners_id) ) {
			echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' . olc_onclick_link(FILENAME_BANNER_STATISTICS, $page_parameter . '&bID=' . $bInfo->banners_id) . '">' . NEW_LINE;
		} else {
			echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' . olc_onclick_link(FILENAME_BANNER_MANAGER, $page_parameter . '&bID=' . $banners['banners_id']) . '">' . NEW_LINE;
		}
		?>
		<td class="dataTableContent"><?php echo '<a href="javascript:popupImageWindow(\'' . FILENAME_POPUP_IMAGE . '?banner=' . $banners['banners_id'] . '\')">' . olc_image(DIR_WS_IMAGES . 'icon_popup.gif', 'View Banner') . '</a>&nbsp;' . $banners['banners_title']; ?></td>
		<td class="dataTableContent" align="right"><?php echo $banners['banners_group']; ?></td>
		<td class="dataTableContent" align="right"><?php echo $banners_shown . ' / ' . $banners_clicked; ?></td>
		<td class="dataTableContent" align="right">
		<?php
		if ($banners['status'] == '1') {
			echo olc_image(DIR_WS_IMAGES . 'icon_status_green.gif', 'Active', 10, 10) . '&nbsp;&nbsp;<a href="' . olc_href_link(FILENAME_BANNER_MANAGER, $page_parameter . '&bID=' . $banners['banners_id'] . '&action=setflag&flag=0') . '">' . olc_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', 'Set Inactive', 10, 10) . HTML_A_END;
		} else {
			echo HTML_A_START . olc_href_link(FILENAME_BANNER_MANAGER, $page_parameter . '&bID=' . $banners['banners_id'] . '&action=setflag&flag=1') . '">' . olc_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', 'Set Active', 10, 10) . '</a>&nbsp;&nbsp;' . olc_image(DIR_WS_IMAGES . 'icon_status_red.gif', 'Inactive', 10, 10);
		}
		?></td>
		<td class="dataTableContent" align="right"><?php echo HTML_A_START . olc_href_link(FILENAME_BANNER_STATISTICS, $page_parameter . '&bID=' . $banners['banners_id']) . '">' . olc_image(DIR_WS_ICONS . 'statistics.gif', ICON_STATISTICS) . '</a>&nbsp;'; if ( (is_object($bInfo)) && ($banners['banners_id'] == $bInfo->banners_id) ) { echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', EMPTY_STRING); } else { echo HTML_A_START . olc_href_link(FILENAME_BANNER_MANAGER, $page_parameter . '&bID=' . $banners['banners_id']) . '">' . olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END; } ?>&nbsp;</td>
		</tr>
		<?php
	}
	?>
	<tr>
	<td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td class="smallText" valign="top"><?php echo $banners_split->display_count($banners_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $page, TEXT_DISPLAY_NUMBER_OF_BANNERS); ?></td>
	<td class="smallText" align="right"><?php echo $banners_split->display_links($banners_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $page); ?></td>
	</tr>
	<tr>
	<td align="right" colspan="2"><?php echo HTML_A_START . olc_href_link(FILENAME_BANNER_MANAGER, 'action=new') . '">' . olc_image_button('button_new_banner.gif', IMAGE_NEW_BANNER) . HTML_A_END; ?></td>
	</tr>
	</table></td>
	</tr>
	</table></td>
	<?php
	$heading = array();
	$contents = array();
	switch ($action) {
		case 'delete':
			$heading[] = array('text' => HTML_B_START . $bInfo->banners_title . HTML_B_END);

			$contents = array('form' => olc_draw_form('banners', FILENAME_BANNER_MANAGER, $page_parameter . '&bID=' . $bInfo->banners_id . '&action=deleteconfirm'));
			$contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
			$contents[] = array('text' => '<br/><b>' . $bInfo->banners_title . HTML_B_END);
			if ($bInfo->banners_image) $contents[] = array('text' => HTML_BR . olc_draw_checkbox_field('delete_image', 'on', true) . BLANK . TEXT_INFO_DELETE_IMAGE);
			$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_delete.gif', IMAGE_DELETE) . '&nbsp;<a href="' . olc_href_link(FILENAME_BANNER_MANAGER, $page_parameter . '&bID=' . $bID) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
			break;
		default:
			if (is_object($bInfo)) {
				$heading[] = array('text' => HTML_B_START . $bInfo->banners_title . HTML_B_END);

				$contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_BANNER_MANAGER, $page_parameter . '&bID=' . $bInfo->banners_id . '&action=new') . '">' . olc_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . olc_href_link(FILENAME_BANNER_MANAGER, $page_parameter . '&bID=' . $bInfo->banners_id . '&action=delete') . '">' . olc_image_button('button_delete.gif', IMAGE_DELETE) . HTML_A_END);
				$contents[] = array('text' => HTML_BR . TEXT_BANNERS_DATE_ADDED . BLANK . olc_date_short($bInfo->date_added));

				if ( (function_exists('imagecreate')) && ($dir_ok) && ($banner_extension) ) {
					$banner_id = $bInfo->banners_id;
					$days = '3';
					include(DIR_WS_INCLUDES . 'graphs/banner_infobox.php');
					$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image(DIR_WS_IMAGES . 'graphs/banner_infobox-' . $banner_id . '.' . $banner_extension));
				} else {
					include(DIR_WS_FUNCTIONS . 'html_graphs.php');
					$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_banner_graph_infoBox($bInfo->banners_id, '3'));
				}

				$contents[] = array('text' => olc_image(DIR_WS_IMAGES . 'graph_hbar_blue.gif', 'Blue', '5', '5') . BLANK . TEXT_BANNERS_BANNER_VIEWS . HTML_BR . olc_image(DIR_WS_IMAGES . 'graph_hbar_red.gif', 'Red', '5', '5') . BLANK . TEXT_BANNERS_BANNER_CLICKS);

				if ($bInfo->date_scheduled) $contents[] = array('text' => HTML_BR . sprintf(TEXT_BANNERS_SCHEDULED_AT_DATE, olc_date_short($bInfo->date_scheduled)));

				if ($bInfo->expires_date) {
					$contents[] = array('text' => HTML_BR . sprintf(TEXT_BANNERS_EXPIRES_AT_DATE, olc_date_short($bInfo->expires_date)));
				} elseif ($bInfo->expires_impressions) {
					$contents[] = array('text' => HTML_BR . sprintf(TEXT_BANNERS_EXPIRES_AT_IMPRESSIONS, $bInfo->expires_impressions));
				}

				if ($bInfo->date_status_change) $contents[] = array('text' => HTML_BR . sprintf(TEXT_BANNERS_STATUS_CHANGE, olc_date_short($bInfo->date_status_change)));
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
