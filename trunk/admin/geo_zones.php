<?php
/* --------------------------------------------------------------
   $Id: geo_zones.php,v 1.1.1.1.2.1 2007/04/08 07:16:27 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(geo_zones.php,v 1.27 2003/05/07); www.oscommerce.com
   (c) 2003	    nextcommerce (geo_zones.php,v 1.9 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  switch ($_GET['saction']) {
    case 'insert_sub':
      $zID = olc_db_prepare_input($_GET['zID']);
      $zone_country_id = olc_db_prepare_input($_POST['zone_country_id']);
      $zone_id = olc_db_prepare_input($_POST['zone_id']);

      olc_db_query(INSERT_INTO . TABLE_ZONES_TO_GEO_ZONES . " (zone_country_id, zone_id, geo_zone_id, date_added) values ('" . olc_db_input($zone_country_id) . "', '" . olc_db_input($zone_id) . "', '" . olc_db_input($zID) . "', now())");
      $new_subzone_id = olc_db_insert_id();

      olc_redirect(olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $new_subzone_id));
      break;

    case 'save_sub':
      $sID = olc_db_prepare_input($_GET['sID']);
      $zID = olc_db_prepare_input($_GET['zID']);
      $zone_country_id = olc_db_prepare_input($_POST['zone_country_id']);
      $zone_id = olc_db_prepare_input($_POST['zone_id']);

      olc_db_query(SQL_UPDATE . TABLE_ZONES_TO_GEO_ZONES . " set geo_zone_id = '" . olc_db_input($zID) . "', zone_country_id = '" . olc_db_input($zone_country_id) . "', zone_id = " . ((olc_db_input($zone_id)) ? APOS . olc_db_input($zone_id) . APOS : 'null') . ", last_modified = now() where association_id = '" . olc_db_input($sID) . APOS);

      olc_redirect(olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $_GET['sID']));
      break;

    case 'deleteconfirm_sub':
      $sID = olc_db_prepare_input($_GET['sID']);

      olc_db_query(DELETE_FROM . TABLE_ZONES_TO_GEO_ZONES . " where association_id = '" . olc_db_input($sID) . APOS);

      olc_redirect(olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage']));
      break;
  }

  switch ($_GET['action']) {
    case 'insert_zone':
      $geo_zone_name = olc_db_prepare_input($_POST['geo_zone_name']);
      $geo_zone_description = olc_db_prepare_input($_POST['geo_zone_description']);

      olc_db_query(INSERT_INTO . TABLE_GEO_ZONES . " (geo_zone_name, geo_zone_description, date_added) values ('" . olc_db_input($geo_zone_name) . "', '" . olc_db_input($geo_zone_description) . "', now())");
      $new_zone_id = olc_db_insert_id();

      olc_redirect(olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $new_zone_id));
      break;

    case 'save_zone':
      $zID = olc_db_prepare_input($_GET['zID']);
      $geo_zone_name = olc_db_prepare_input($_POST['geo_zone_name']);
      $geo_zone_description = olc_db_prepare_input($_POST['geo_zone_description']);

      olc_db_query(SQL_UPDATE . TABLE_GEO_ZONES . " set geo_zone_name = '" . olc_db_input($geo_zone_name) . "', geo_zone_description = '" . olc_db_input($geo_zone_description) . "', last_modified = now() where geo_zone_id = '" . olc_db_input($zID) . APOS);

      olc_redirect(olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID']));
      break;

    case 'deleteconfirm_zone':
      $zID = olc_db_prepare_input($_GET['zID']);

      olc_db_query(DELETE_FROM . TABLE_GEO_ZONES . " where geo_zone_id = '" . olc_db_input($zID) . APOS);
      olc_db_query(DELETE_FROM . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . olc_db_input($zID) . APOS);

      olc_redirect(olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage']));
      break;
  }
	require_once(DIR_WS_INCLUDES . 'header.php');
  if ($_GET['zID']  && (($_GET['saction'] == 'edit') || ($_GET['saction'] == 'new'))) {
?>
<script language="javascript" type="text/javascript"><!--
function resetZoneSelected(theForm) {
  if (theForm.state.value != '') {
    theForm.zone_id.selectedIndex = '0';
    if (theForm.zone_id.options.length > 0) {
      theForm.state.value = '<?php echo JS_STATE_SELECT; ?>';
    }
  }
}

function update_zone(theForm) {
  var NumState = theForm.zone_id.options.length;
  var SelectedCountry = "";

  while(NumState > 0) {
    NumState--;
    theForm.zone_id.options[NumState] = null;
  }

  SelectedCountry = theForm.zone_country_id.options[theForm.zone_country_id.selectedIndex].value;

<?php echo olc_js_zone_list('SelectedCountry', 'theForm', 'zone_id'); ?>

}
//--></script>
<?php
  }
?>
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
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
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
            <td valign="top">
<?php
  if ($_GET['action'] == 'list') {
?>
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_COUNTRY; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_COUNTRY_ZONE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $rows = 0;
    $zones_query_raw = "select a.association_id, a.zone_country_id, c.countries_name, a.zone_id, a.geo_zone_id, a.last_modified, a.date_added, z.zone_name from " . TABLE_ZONES_TO_GEO_ZONES . " a left join " . TABLE_COUNTRIES . " c on a.zone_country_id = c.countries_id left join " . TABLE_ZONES . " z on a.zone_id = z.zone_id where a.geo_zone_id = " . $_GET['zID'] . " order by association_id";
    $zones_split = new splitPageResults($_GET['spage'], MAX_DISPLAY_SEARCH_RESULTS, $zones_query_raw, $zones_query_numrows);
    $zones_query = olc_db_query($zones_query_raw);
    while ($zones = olc_db_fetch_array($zones_query)) {
      $rows++;
      if (((!$_GET['sID']) || (@$_GET['sID'] == $zones['association_id'])) && (!$sInfo) && (substr($_GET['saction'], 0, 3) != 'new')) {
        $sInfo = new objectInfo($zones);
      }
      if ( (is_object($sInfo)) && ($zones['association_id'] == $sInfo->association_id) ) {
        echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' . olc_onclick_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $sInfo->association_id . '&saction=edit') . '">' . NEW_LINE;
      } else {
        echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' . olc_onclick_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $zones['association_id']) . '">' . NEW_LINE;
      }
?>
                <td class="dataTableContent"><?php echo (($zones['countries_name']) ? $zones['countries_name'] : TEXT_ALL_COUNTRIES); ?></td>
                <td class="dataTableContent"><?php echo (($zones['zone_id']) ? $zones['zone_name'] : PLEASE_SELECT); ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($sInfo)) && ($zones['association_id'] == $sInfo->association_id) ) { echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo HTML_A_START . olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $zones['association_id']) . '">' . olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END; } ?>&nbsp;</td>
              </tr>
<?php
    }
?>
              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $zones_split->display_count($zones_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['spage'], TEXT_DISPLAY_NUMBER_OF_COUNTRIES); ?></td>
                    <td class="smallText" align="right"><?php echo $zones_split->display_links($zones_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['spage'], 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list', 'spage'); ?></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="right" colspan="3"><?php if (!$_GET['saction']) echo HTML_A_START . olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID']) . '">' . olc_image_button('button_back.gif', IMAGE_BACK) . '</a> <a href="' . olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $sInfo->association_id . '&saction=new') . '">' . olc_image_button('button_insert.gif', IMAGE_INSERT) . HTML_A_END; ?></td>
              </tr>
            </table>
<?php
  } else {
?>
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TAX_ZONES; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $zones_query_raw = "select geo_zone_id, geo_zone_name, geo_zone_description, last_modified, date_added from " . TABLE_GEO_ZONES . " order by geo_zone_name";
    $zones_split = new splitPageResults($_GET['zpage'], MAX_DISPLAY_SEARCH_RESULTS, $zones_query_raw, $zones_query_numrows);
    $zones_query = olc_db_query($zones_query_raw);
    while ($zones = olc_db_fetch_array($zones_query)) {
      if (((!$_GET['zID']) || (@$_GET['zID'] == $zones['geo_zone_id'])) && (!$zInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
        $num_zones_query = olc_db_query("select count(*) as num_zones from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . $zones['geo_zone_id'] . "' group by geo_zone_id");
        if (olc_db_num_rows($num_zones_query) > 0) {
          $num_zones = olc_db_fetch_array($num_zones_query);
          $zones['num_zones'] = $num_zones['num_zones'];
        } else {
          $zones['num_zones'] = 0;
        }
        $zInfo = new objectInfo($zones);
      }
      if ( (is_object($zInfo)) && ($zones['geo_zone_id'] == $zInfo->geo_zone_id) ) {
        echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' . olc_onclick_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $zInfo->geo_zone_id . '&action=list') . '">' . NEW_LINE;
      } else {
        echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' . olc_onclick_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $zones['geo_zone_id']) . '">' . NEW_LINE;
      }
?>
                <td class="dataTableContent"><?php echo HTML_A_START . olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $zones['geo_zone_id'] . '&action=list') . '">' . olc_image(DIR_WS_ICONS . 'folder.gif', ICON_FOLDER) . '</a>&nbsp;' . $zones['geo_zone_name']; ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($zInfo)) && ($zones['geo_zone_id'] == $zInfo->geo_zone_id) ) { echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo HTML_A_START . olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $zones['geo_zone_id']) . '">' . olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END; } ?>&nbsp;</td>
              </tr>
<?php
    }
?>
              <tr>
                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo $zones_split->display_count($zones_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['zpage'], TEXT_DISPLAY_NUMBER_OF_TAX_ZONES); ?></td>
                    <td class="smallText" align="right"><?php echo $zones_split->display_links($zones_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['zpage'], '', 'zpage'); ?></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="right" colspan="2"><?php if (!$_GET['action']) echo HTML_A_START . olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $zInfo->geo_zone_id . '&action=new_zone') . '">' . olc_image_button('button_insert.gif', IMAGE_INSERT) . HTML_A_END; ?></td>
              </tr>
            </table>
<?php
  }
?>
            </td>
<?php
  $heading = array();
  $contents = array();

  if ($_GET['action'] == 'list') {
    switch ($_GET['saction']) {
      case 'new':
        $heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_NEW_SUB_ZONE . HTML_B_END);

        $contents = array('form' => olc_draw_form('zones', FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $_GET['sID'] . '&saction=insert_sub'));
        $contents[] = array('text' => TEXT_INFO_NEW_SUB_ZONE_INTRO);
        $contents[] = array('text' => HTML_BR . TEXT_INFO_COUNTRY . HTML_BR . olc_draw_pull_down_menu('zone_country_id', olc_get_countries(TEXT_ALL_COUNTRIES), '', 'onchange="update_zone(this.form);"'));
        $contents[] = array('text' => HTML_BR . TEXT_INFO_COUNTRY_ZONE . HTML_BR . olc_draw_pull_down_menu('zone_id', olc_prepare_country_zones_pull_down()));
        $contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_insert.gif', IMAGE_INSERT) . BLANK.HTML_A_START . olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $_GET['sID']) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
        break;

      case 'edit':
        $heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_EDIT_SUB_ZONE . HTML_B_END);

        $contents = array('form' => olc_draw_form('zones', FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $sInfo->association_id . '&saction=save_sub'));
        $contents[] = array('text' => TEXT_INFO_EDIT_SUB_ZONE_INTRO);
        $contents[] = array('text' => HTML_BR . TEXT_INFO_COUNTRY . HTML_BR . olc_draw_pull_down_menu('zone_country_id', olc_get_countries(TEXT_ALL_COUNTRIES), $sInfo->zone_country_id, 'onchange="update_zone(this.form);"'));
        $contents[] = array('text' => HTML_BR . TEXT_INFO_COUNTRY_ZONE . HTML_BR . olc_draw_pull_down_menu('zone_id', olc_prepare_country_zones_pull_down($sInfo->zone_country_id), $sInfo->zone_id));
        $contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_update.gif', IMAGE_UPDATE) . BLANK.HTML_A_START . olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $sInfo->association_id) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
        break;

      case 'delete':
        $heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_DELETE_SUB_ZONE . HTML_B_END);

        $contents = array('form' => olc_draw_form('zones', FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $sInfo->association_id . '&saction=deleteconfirm_sub'));
        $contents[] = array('text' => TEXT_INFO_DELETE_SUB_ZONE_INTRO);
        $contents[] = array('text' => '<br/><b>' . $sInfo->countries_name . HTML_B_END);
        $contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_delete.gif', IMAGE_DELETE) . BLANK.HTML_A_START . olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $sInfo->association_id) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
        break;

      default:
        if (is_object($sInfo)) {
          $heading[] = array('text' => HTML_B_START . $sInfo->countries_name . HTML_B_END);

          $contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $sInfo->association_id . '&saction=edit') . '">' . olc_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $sInfo->association_id . '&saction=delete') . '">' . olc_image_button('button_delete.gif', IMAGE_DELETE) . HTML_A_END);
          $contents[] = array('text' => HTML_BR . TEXT_INFO_DATE_ADDED . BLANK . olc_date_short($sInfo->date_added));
          if (olc_not_null($sInfo->last_modified)) $contents[] = array('text' => TEXT_INFO_LAST_MODIFIED . BLANK . olc_date_short($sInfo->last_modified));
        }
        break;
    }
  } else {
    switch ($_GET['action']) {
      case 'new_zone':
        $heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_NEW_ZONE . HTML_B_END);

        $contents = array('form' => olc_draw_form('zones', FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=insert_zone'));
        $contents[] = array('text' => TEXT_INFO_NEW_ZONE_INTRO);
        $contents[] = array('text' => HTML_BR . TEXT_INFO_ZONE_NAME . HTML_BR . olc_draw_input_field('geo_zone_name'));
        $contents[] = array('text' => HTML_BR . TEXT_INFO_ZONE_DESCRIPTION . HTML_BR . olc_draw_input_field('geo_zone_description'));
        $contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_insert.gif', IMAGE_INSERT) . BLANK.HTML_A_START . olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID']) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
        break;

      case 'edit_zone':
        $heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_EDIT_ZONE . HTML_B_END);

        $contents = array('form' => olc_draw_form('zones', FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $zInfo->geo_zone_id . '&action=save_zone'));
        $contents[] = array('text' => TEXT_INFO_EDIT_ZONE_INTRO);
        $contents[] = array('text' => HTML_BR . TEXT_INFO_ZONE_NAME . HTML_BR . olc_draw_input_field('geo_zone_name', $zInfo->geo_zone_name));
        $contents[] = array('text' => HTML_BR . TEXT_INFO_ZONE_DESCRIPTION . HTML_BR . olc_draw_input_field('geo_zone_description', $zInfo->geo_zone_description));
        $contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_update.gif', IMAGE_UPDATE) . BLANK.HTML_A_START . olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $zInfo->geo_zone_id) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
        break;

      case 'delete_zone':
        $heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_DELETE_ZONE . HTML_B_END);

        $contents = array('form' => olc_draw_form('zones', FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $zInfo->geo_zone_id . '&action=deleteconfirm_zone'));
        $contents[] = array('text' => TEXT_INFO_DELETE_ZONE_INTRO);
        $contents[] = array('text' => '<br/><b>' . $zInfo->geo_zone_name . HTML_B_END);
        $contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_delete.gif', IMAGE_DELETE) . BLANK.HTML_A_START . olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $zInfo->geo_zone_id) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
        break;

      default:
        if (is_object($zInfo)) {
          $heading[] = array('text' => HTML_B_START . $zInfo->geo_zone_name . HTML_B_END);

          $contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $zInfo->geo_zone_id . '&action=edit_zone') . '">' . olc_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $zInfo->geo_zone_id . '&action=delete_zone') . '">' . olc_image_button('button_delete.gif', IMAGE_DELETE) . HTML_A_END . BLANK.HTML_A_START . olc_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $zInfo->geo_zone_id . '&action=list') . '">' . olc_image_button('button_details.gif', IMAGE_DETAILS) . HTML_A_END);
          $contents[] = array('text' => HTML_BR . TEXT_INFO_NUMBER_ZONES . BLANK . $zInfo->num_zones);
          $contents[] = array('text' => HTML_BR . TEXT_INFO_DATE_ADDED . BLANK . olc_date_short($zInfo->date_added));
          if (olc_not_null($zInfo->last_modified)) $contents[] = array('text' => TEXT_INFO_LAST_MODIFIED . BLANK . olc_date_short($zInfo->last_modified));
          $contents[] = array('text' => HTML_BR . TEXT_INFO_ZONE_DESCRIPTION . HTML_BR . $zInfo->geo_zone_description);
        }
        break;
    }
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
