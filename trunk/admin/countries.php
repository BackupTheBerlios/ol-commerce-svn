<?php
/* --------------------------------------------------------------
$Id: countries.php,v 1.1.1.1.2.1 2007/04/08 07:16:26 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(countries.php,v 1.26 2003/05/17); www.oscommerce.com
(c) 2003	    nextcommerce (countries.php,v 1.9 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application_top.php');

if ($_GET['action']) {
	switch ($_GET['action']) {
		case 'insert':
			$countries_name = olc_db_prepare_input($_POST['countries_name']);
			$countries_iso_code_2 = olc_db_prepare_input($_POST['countries_iso_code_2']);
			$countries_iso_code_3 = olc_db_prepare_input($_POST['countries_iso_code_3']);
			$address_format_id = olc_db_prepare_input($_POST['address_format_id']);

			olc_db_query(INSERT_INTO . TABLE_COUNTRIES . " (countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('" . olc_db_input($countries_name) . "', '" . olc_db_input($countries_iso_code_2) . "', '" . olc_db_input($countries_iso_code_3) . "', '" . olc_db_input($address_format_id) . "')");
			olc_redirect(olc_href_link(FILENAME_COUNTRIES));
			break;
		case 'save':
			$countries_id = olc_db_prepare_input($_GET['cID']);
			$countries_name = olc_db_prepare_input($_POST['countries_name']);
			$countries_iso_code_2 = olc_db_prepare_input($_POST['countries_iso_code_2']);
			$countries_iso_code_3 = olc_db_prepare_input($_POST['countries_iso_code_3']);
			$address_format_id = olc_db_prepare_input($_POST['address_format_id']);

			olc_db_query(SQL_UPDATE . TABLE_COUNTRIES . " set countries_name = '" . olc_db_input($countries_name) . "', countries_iso_code_2 = '" . olc_db_input($countries_iso_code_2) . "', countries_iso_code_3 = '" . olc_db_input($countries_iso_code_3) . "', address_format_id = '" . olc_db_input($address_format_id) . "' where countries_id = '" . olc_db_input($countries_id) . APOS);
			olc_redirect(olc_href_link(FILENAME_COUNTRIES, 'page=' . $_GET['page'] . '&cID=' . $countries_id));
			break;
		case 'deleteconfirm':
			$countries_id = olc_db_prepare_input($_GET['cID']);

			olc_db_query(DELETE_FROM . TABLE_COUNTRIES . " where countries_id = '" . olc_db_input($countries_id) . APOS);
			olc_redirect(olc_href_link(FILENAME_COUNTRIES, 'page=' . $_GET['page']));
			break;
	}
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
  	      <td>
  	      	<table border="0" width="100%" cellspacing="0" cellpadding="0">
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
		            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
		              <tr class="dataTableHeadingRow">
		                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_COUNTRY_NAME; ?></td>
		                <td class="dataTableHeadingContent" align="center" colspan="2"><?php echo TABLE_HEADING_COUNTRY_CODES; ?></td>
		                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
		              </tr>
<?php
$countries_query_raw = "select countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id from " . TABLE_COUNTRIES . " order by countries_name";
$countries_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $countries_query_raw, $countries_query_numrows);
$countries_query = olc_db_query($countries_query_raw);
while ($countries = olc_db_fetch_array($countries_query)) {
	if (((!$_GET['cID']) || (@$_GET['cID'] == $countries['countries_id'])) && (!$cInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
		$cInfo = new objectInfo($countries);
	}

	if ( (is_object($cInfo)) && ($countries['countries_id'] == $cInfo->countries_id) ) {
		echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' . olc_onclick_link(FILENAME_COUNTRIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->countries_id . '&action=edit') . '">' . NEW_LINE;
	} else {
		echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' . olc_onclick_link(FILENAME_COUNTRIES, 'page=' . $_GET['page'] . '&cID=' . $countries['countries_id']) . '">' . NEW_LINE;
	}
?>
                <td class="dataTableContent"><?php echo $countries['countries_name']; ?></td>
                <td class="dataTableContent" align="center" width="40"><?php echo $countries['countries_iso_code_2']; ?></td>
                <td class="dataTableContent" align="center" width="40"><?php echo $countries['countries_iso_code_3']; ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($cInfo)) && ($countries['countries_id'] == $cInfo->countries_id) ) { echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo HTML_A_START . olc_href_link(FILENAME_COUNTRIES, 'page=' . $_GET['page'] . '&cID=' . $countries['countries_id']) . '">' . olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END; } ?>&nbsp;</td>
              </tr>
<?php
}
?>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $countries_split->display_count($countries_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_COUNTRIES); ?></td>
                    <td class="smallText" align="right"><?php echo $countries_split->display_links($countries_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
if (!$_GET['action']) {
?>
                  <tr>
                    <td colspan="2" align="right"><?php echo HTML_A_START . olc_href_link(FILENAME_COUNTRIES, 'page=' . $_GET['page'] . '&action=new') . '">' . olc_image_button('button_new_country.gif', IMAGE_NEW_COUNTRY) . HTML_A_END; ?></td>
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
switch ($_GET['action']) {
	case 'new':
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_NEW_COUNTRY . HTML_B_END);

		$contents = array('form' => olc_draw_form('countries', FILENAME_COUNTRIES, 'page=' . $_GET['page'] . '&action=insert'));
		$contents[] = array('text' => TEXT_INFO_INSERT_INTRO);
		$contents[] = array('text' => HTML_BR . TEXT_INFO_COUNTRY_NAME . HTML_BR . olc_draw_input_field('countries_name'));
		$contents[] = array('text' => HTML_BR . TEXT_INFO_COUNTRY_CODE_2 . HTML_BR . olc_draw_input_field('countries_iso_code_2'));
		$contents[] = array('text' => HTML_BR . TEXT_INFO_COUNTRY_CODE_3 . HTML_BR . olc_draw_input_field('countries_iso_code_3'));
		$contents[] = array('text' => HTML_BR . TEXT_INFO_ADDRESS_FORMAT . HTML_BR . olc_draw_pull_down_menu('address_format_id', olc_get_address_formats()));
		$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_insert.gif', IMAGE_INSERT) . '&nbsp;<a href="' . olc_href_link(FILENAME_COUNTRIES, 'page=' . $_GET['page']) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;
	case 'edit':
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_EDIT_COUNTRY . HTML_B_END);

		$contents = array('form' => olc_draw_form('countries', FILENAME_COUNTRIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->countries_id . '&action=save'));
		$contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
		$contents[] = array('text' => HTML_BR . TEXT_INFO_COUNTRY_NAME . HTML_BR . olc_draw_input_field('countries_name', $cInfo->countries_name));
		$contents[] = array('text' => HTML_BR . TEXT_INFO_COUNTRY_CODE_2 . HTML_BR . olc_draw_input_field('countries_iso_code_2', $cInfo->countries_iso_code_2));
		$contents[] = array('text' => HTML_BR . TEXT_INFO_COUNTRY_CODE_3 . HTML_BR . olc_draw_input_field('countries_iso_code_3', $cInfo->countries_iso_code_3));
		$contents[] = array('text' => HTML_BR . TEXT_INFO_ADDRESS_FORMAT . HTML_BR . olc_draw_pull_down_menu('address_format_id', olc_get_address_formats(), $cInfo->address_format_id));
		$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_update.gif', IMAGE_UPDATE) . '&nbsp;<a href="' . olc_href_link(FILENAME_COUNTRIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->countries_id) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;
	case 'delete':
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_DELETE_COUNTRY . HTML_B_END);

		$contents = array('form' => olc_draw_form('countries', FILENAME_COUNTRIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->countries_id . '&action=deleteconfirm'));
		$contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
		$contents[] = array('text' => '<br/><b>' . $cInfo->countries_name . HTML_B_END);
		$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_delete.gif', IMAGE_UPDATE) . '&nbsp;<a href="' . olc_href_link(FILENAME_COUNTRIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->countries_id) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;
	default:
		if (is_object($cInfo)) {
			$heading[] = array('text' => HTML_B_START . $cInfo->countries_name . HTML_B_END);

			$contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_COUNTRIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->countries_id . '&action=edit') . '">' . olc_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . olc_href_link(FILENAME_COUNTRIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->countries_id . '&action=delete') . '">' . olc_image_button('button_delete.gif', IMAGE_DELETE) . HTML_A_END);
			$contents[] = array('text' => HTML_BR . TEXT_INFO_COUNTRY_NAME . HTML_BR . $cInfo->countries_name);
			$contents[] = array('text' => HTML_BR . TEXT_INFO_COUNTRY_CODE_2 . BLANK . $cInfo->countries_iso_code_2);
			$contents[] = array('text' => HTML_BR . TEXT_INFO_COUNTRY_CODE_3 . BLANK . $cInfo->countries_iso_code_3);
			$contents[] = array('text' => HTML_BR . TEXT_INFO_ADDRESS_FORMAT . BLANK . $cInfo->address_format_id);
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
