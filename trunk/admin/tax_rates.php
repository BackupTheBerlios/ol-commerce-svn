<?php
/* --------------------------------------------------------------
$Id: tax_rates.php,v 1.1.1.1.2.1 2007/04/08 07:16:33 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(tax_rates.php,v 1.28 2003/03/12); www.oscommerce.com
(c) 2003	    nextcommerce (tax_rates.php,v 1.9 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application_top.php');

$action=$_GET['action'];
if ($action) {
	switch ($action) {
		case 'insert':
			$tax_zone_id = olc_db_prepare_input($_POST['tax_zone_id']);
			$tax_class_id = olc_db_prepare_input($_POST['tax_class_id']);
			$tax_rate = olc_db_prepare_input($_POST['tax_rate']);
			$tax_description = olc_db_prepare_input($_POST['tax_description']);
			$tax_priority = olc_db_prepare_input($_POST['tax_priority']);
			$date_added = olc_db_prepare_input($_POST['date_added']);
			olc_db_query(INSERT_INTO . TABLE_TAX_RATES .
				" (tax_zone_id, tax_class_id, tax_rate, tax_description, tax_priority, date_added) values ('" .
				olc_db_input($tax_zone_id) . "', '" . olc_db_input($tax_class_id) . "', '" . olc_db_input($tax_rate) . "', '" .
				olc_db_input($tax_description) . "', '" . olc_db_input($tax_priority) . "', now())");
			olc_redirect(olc_href_link(FILENAME_TAX_RATES));
			break;

		case 'save':
			$tax_rates_id = olc_db_prepare_input($_GET['tID']);
			$tax_zone_id = olc_db_prepare_input($_POST['tax_zone_id']);
			$tax_class_id = olc_db_prepare_input($_POST['tax_class_id']);
			$tax_rate = olc_db_prepare_input($_POST['tax_rate']);
			$tax_description = olc_db_prepare_input($_POST['tax_description']);
			$tax_priority = olc_db_prepare_input($_POST['tax_priority']);
			$last_modified = olc_db_prepare_input($_POST['last_modified']);
			olc_db_query(SQL_UPDATE . TABLE_TAX_RATES . " set tax_rates_id = '" .
			olc_db_input($tax_rates_id) . "', tax_zone_id = '" . olc_db_input($tax_zone_id) . "', tax_class_id = '" .
			olc_db_input($tax_class_id) . "', tax_rate = '" . olc_db_input($tax_rate) . "', tax_description = '" .
			olc_db_input($tax_description) . "', tax_priority = '" . olc_db_input($tax_priority) .
			"', last_modified = now() where tax_rates_id = '" . olc_db_input($tax_rates_id) . APOS);
			olc_redirect(olc_href_link(FILENAME_TAX_RATES, 'page=' . $_GET['page'] . '&tID=' . $tax_rates_id));
			break;

		case 'deleteconfirm':
			$tax_rates_id = olc_db_prepare_input($_GET['tID']);
			olc_db_query(DELETE_FROM . TABLE_TAX_RATES . " where tax_rates_id = '" . olc_db_input($tax_rates_id) . APOS);
			olc_redirect(olc_href_link(FILENAME_TAX_RATES, 'page=' . $_GET['page']));
			break;
	}
}
?>
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
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
    <td width="80" rowspan="2"><?php echo olc_image(DIR_WS_ICONS.'heading_configuration.gif'); ?></td>
    <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
  </tr>
  <tr>
    <td class="main" valign="top">OLC Konfiguration</td>
  </tr>
</table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TAX_RATE_PRIORITY; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TAX_CLASS_TITLE; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_ZONE; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TAX_RATE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
$rates_query_raw = "select r.tax_rates_id, z.geo_zone_id, z.geo_zone_name, tc.tax_class_title, tc.tax_class_id, r.tax_priority, r.tax_rate, r.tax_description, r.date_added, r.last_modified from " . TABLE_TAX_CLASS . " tc, " . TABLE_TAX_RATES . " r left join " . TABLE_GEO_ZONES . " z on r.tax_zone_id = z.geo_zone_id where r.tax_class_id = tc.tax_class_id";
$rates_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $rates_query_raw, $rates_query_numrows);
$rates_query = olc_db_query($rates_query_raw);
while ($rates = olc_db_fetch_array($rates_query)) {
	if (((!$_GET['tID']) || (@$_GET['tID'] == $rates['tax_rates_id'])) && (!$trInfo) && (substr($action, 0, 3) != 'new')) {
		$trInfo = new objectInfo($rates);
	}

	if ( (is_object($trInfo)) && ($rates['tax_rates_id'] == $trInfo->tax_rates_id) ) {
		echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' . olc_onclick_link(FILENAME_TAX_RATES, 'page=' . $_GET['page'] . '&tID=' . $trInfo->tax_rates_id . '&action=edit') . '">' . NEW_LINE;
	} else {
		echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' . olc_onclick_link(FILENAME_TAX_RATES, 'page=' . $_GET['page'] . '&tID=' . $rates['tax_rates_id']) . '">' . NEW_LINE;
	}
?>
                <td class="dataTableContent"><?php echo $rates['tax_priority']; ?></td>
                <td class="dataTableContent"><?php echo $rates['tax_class_title']; ?></td>
                <td class="dataTableContent"><?php echo $rates['geo_zone_name']; ?></td>
                <td class="dataTableContent"><?php echo olc_display_tax_value($rates['tax_rate']); ?>%</td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($trInfo)) && ($rates['tax_rates_id'] == $trInfo->tax_rates_id) ) { echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo HTML_A_START . olc_href_link(FILENAME_TAX_RATES, 'page=' . $_GET['page'] . '&tID=' . $rates['tax_rates_id']) . '">' . olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END; } ?>&nbsp;</td>
              </tr>
<?php
}
?>
              <tr>
                <td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $rates_split->display_count($rates_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_TAX_RATES); ?></td>
                    <td class="smallText" align="right"><?php echo $rates_split->display_links($rates_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
if (!$action) {
?>
                  <tr>
                    <td colspan="5" align="right"><?php echo HTML_A_START . olc_href_link(FILENAME_TAX_RATES, 'page=' . $_GET['page'] . '&action=new') . '">' . olc_image_button('button_new_tax_rate.gif', IMAGE_NEW_TAX_RATE) . HTML_A_END; ?></td>
                  </tr>
<?php
}
?>
                </table></td>
              </tr>
            </table></td>
<?php
$heading = array();
$contents = array();
switch ($action) {
	case 'new':
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_NEW_TAX_RATE . HTML_B_END);

		$contents = array('form' => olc_draw_form('rates', FILENAME_TAX_RATES, 'page=' . $_GET['page'] . '&action=insert'));
		$contents[] = array('text' => TEXT_INFO_INSERT_INTRO);
		$contents[] = array('text' => HTML_BR . TEXT_INFO_CLASS_TITLE . HTML_BR . olc_tax_classes_pull_down('name="tax_class_id" style="font-size:10px"'));
		$contents[] = array('text' => HTML_BR . TEXT_INFO_ZONE_NAME . HTML_BR . olc_geo_zones_pull_down('name="tax_zone_id" style="font-size:10px"'));
		$contents[] = array('text' => HTML_BR . TEXT_INFO_TAX_RATE . HTML_BR . olc_draw_input_field('tax_rate'));
		$contents[] = array('text' => HTML_BR . TEXT_INFO_RATE_DESCRIPTION . HTML_BR . olc_draw_input_field('tax_description'));
		$contents[] = array('text' => HTML_BR . TEXT_INFO_TAX_RATE_PRIORITY . HTML_BR . olc_draw_input_field('tax_priority'));
		$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_insert.gif', IMAGE_INSERT) . '&nbsp;<a href="' . olc_href_link(FILENAME_TAX_RATES, 'page=' . $_GET['page']) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;

	case 'edit':
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_EDIT_TAX_RATE . HTML_B_END);

		$contents = array('form' => olc_draw_form('rates', FILENAME_TAX_RATES, 'page=' . $_GET['page'] . '&tID=' . $trInfo->tax_rates_id  . '&action=save'));
		$contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
		$contents[] = array('text' => HTML_BR . TEXT_INFO_CLASS_TITLE . HTML_BR . olc_tax_classes_pull_down('name="tax_class_id" style="font-size:10px"', $trInfo->tax_class_id));
		$contents[] = array('text' => HTML_BR . TEXT_INFO_ZONE_NAME . HTML_BR . olc_geo_zones_pull_down('name="tax_zone_id" style="font-size:10px"', $trInfo->geo_zone_id));
		$contents[] = array('text' => HTML_BR . TEXT_INFO_TAX_RATE . HTML_BR . olc_draw_input_field('tax_rate', $trInfo->tax_rate));
		$contents[] = array('text' => HTML_BR . TEXT_INFO_RATE_DESCRIPTION . HTML_BR . olc_draw_input_field('tax_description', $trInfo->tax_description));
		$contents[] = array('text' => HTML_BR . TEXT_INFO_TAX_RATE_PRIORITY . HTML_BR . olc_draw_input_field('tax_priority', $trInfo->tax_priority));
		$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_update.gif', IMAGE_UPDATE) . '&nbsp;<a href="' . olc_href_link(FILENAME_TAX_RATES, 'page=' . $_GET['page'] . '&tID=' . $trInfo->tax_rates_id) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;

	case 'delete':
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_DELETE_TAX_RATE . HTML_B_END);

		$contents = array('form' => olc_draw_form('rates', FILENAME_TAX_RATES, 'page=' . $_GET['page'] . '&tID=' . $trInfo->tax_rates_id  . '&action=deleteconfirm'));
		$contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
		$contents[] = array('text' => '<br/><b>' . $trInfo->tax_class_title . BLANK . number_format($trInfo->tax_rate, TAX_DECIMAL_PLACES) . '%</b>');
		$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_delete.gif', IMAGE_DELETE) . '&nbsp;<a href="' . olc_href_link(FILENAME_TAX_RATES, 'page=' . $_GET['page'] . '&tID=' . $trInfo->tax_rates_id) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;

	default:
		if (is_object($trInfo)) {
			$heading[] = array('text' => HTML_B_START . $trInfo->tax_class_title . HTML_B_END);

			$contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_TAX_RATES, 'page=' . $_GET['page'] . '&tID=' . $trInfo->tax_rates_id . '&action=edit') . '">' . olc_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . olc_href_link(FILENAME_TAX_RATES, 'page=' . $_GET['page'] . '&tID=' . $trInfo->tax_rates_id . '&action=delete') . '">' . olc_image_button('button_delete.gif', IMAGE_DELETE) . HTML_A_END);
			$contents[] = array('text' => HTML_BR . TEXT_INFO_DATE_ADDED . BLANK . olc_date_short($trInfo->date_added));
			$contents[] = array('text' => '' . TEXT_INFO_LAST_MODIFIED . BLANK . olc_date_short($trInfo->last_modified));
			$contents[] = array('text' => HTML_BR . TEXT_INFO_RATE_DESCRIPTION . HTML_BR . $trInfo->tax_description);
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
    </table></td>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
