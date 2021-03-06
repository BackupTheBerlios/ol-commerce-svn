<?php
/*------------------------------------------------------------------------------
$Id: affiliate_affiliates.php,v 1.1.1.1.2.1 2007/04/08 07:16:23 gswkaiser Exp $

OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

modified by http://www.ol-commerce.de, http://www.seifenparadies.de


Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------
based on:
(c) 2003 OSC-Affiliate (affiliate_affiliates.php, v 1.12 2003/07/12);
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

require('includes/application_top.php');

// include used functions
require_once(DIR_FS_INC.'olc_add_tax.inc.php');

require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();

if ($_GET['action']) {
	switch ($_GET['action']) {
		case 'update':
			$affiliate_id = olc_db_prepare_input($_GET['acID']);
			$affiliate_gender = olc_db_prepare_input($_POST['affiliate_gender']);
			$affiliate_firstname = olc_db_prepare_input($_POST['affiliate_firstname']);
			$affiliate_lastname = olc_db_prepare_input($_POST['affiliate_lastname']);
			$affiliate_dob = olc_db_prepare_input($_POST['affiliate_dob']);
			$affiliate_email_address = olc_db_prepare_input($_POST['affiliate_email_address']);
			$affiliate_company = olc_db_prepare_input($_POST['affiliate_company']);
			$affiliate_company_taxid = olc_db_prepare_input($_POST['affiliate_company_taxid']);
			$affiliate_payment_check = olc_db_prepare_input($_POST['affiliate_payment_check']);
			$affiliate_payment_paypal = olc_db_prepare_input($_POST['affiliate_payment_paypal']);
			$affiliate_payment_bank_name = olc_db_prepare_input($_POST['affiliate_payment_bank_name']);
			$affiliate_payment_bank_branch_number = olc_db_prepare_input($_POST['affiliate_payment_bank_branch_number']);
			$affiliate_payment_bank_swift_code = olc_db_prepare_input($_POST['affiliate_payment_bank_swift_code']);
			$affiliate_payment_bank_account_name = olc_db_prepare_input($_POST['affiliate_payment_bank_account_name']);
			$affiliate_payment_bank_account_number = olc_db_prepare_input($_POST['affiliate_payment_bank_account_number']);
			$affiliate_street_address = olc_db_prepare_input($_POST['affiliate_street_address']);
			$affiliate_suburb = olc_db_prepare_input($_POST['affiliate_suburb']);
			$affiliate_postcode=olc_db_prepare_input($_POST['affiliate_postcode']);
			$affiliate_city = olc_db_prepare_input($_POST['affiliate_city']);
			$affiliate_country_id=olc_db_prepare_input($_POST['affiliate_country_id']);
			$affiliate_telephone=olc_db_prepare_input($_POST['affiliate_telephone']);
			$affiliate_fax=olc_db_prepare_input($_POST['affiliate_fax']);
			$affiliate_homepage=olc_db_prepare_input($_POST['affiliate_homepage']);
			$affiliate_state = olc_db_prepare_input($_POST['affiliate_state']);
			$affiliatey_zone_id = olc_db_prepare_input($_POST['affiliate_zone_id']);
			$affiliate_commission_percent = olc_db_prepare_input($_POST['affiliate_commission_percent']);
			if ($affiliate_zone_id > 0) $affiliate_state = EMPTY_STRING;
			// If someone uses , instead of .
			$affiliate_commission_percent = str_replace (',' , '.' , $affiliate_commission_percent);

			$sql_data_array = array('affiliate_firstname' => $affiliate_firstname,
			'affiliate_lastname' => $affiliate_lastname,
			'affiliate_email_address' => $affiliate_email_address,
			'affiliate_payment_check' => $affiliate_payment_check,
			'affiliate_payment_paypal' => $affiliate_payment_paypal,
			'affiliate_payment_bank_name' => $affiliate_payment_bank_name,
			'affiliate_payment_bank_branch_number' => $affiliate_payment_bank_branch_number,
			'affiliate_payment_bank_swift_code' => $affiliate_payment_bank_swift_code,
			'affiliate_payment_bank_account_name' => $affiliate_payment_bank_account_name,
			'affiliate_payment_bank_account_number' => $affiliate_payment_bank_account_number,
			'affiliate_street_address' => $affiliate_street_address,
			'affiliate_postcode' => $affiliate_postcode,
			'affiliate_city' => $affiliate_city,
			'affiliate_country_id' => $affiliate_country_id,
			'affiliate_telephone' => $affiliate_telephone,
			'affiliate_fax' => $affiliate_fax,
			'affiliate_homepage' => $affiliate_homepage,
			'affiliate_commission_percent' => $affiliate_commission_percent,
			'affiliate_agb' => '1');

			if (ACCOUNT_DOB == TRUE_STRING_S) $sql_data_array['affiliate_dob'] = olc_date_short($affiliate_dob);
			if (ACCOUNT_GENDER == TRUE_STRING_S) $sql_data_array['affiliate_gender'] = $affiliate_gender;
			if (ACCOUNT_COMPANY == TRUE_STRING_S) {
				$sql_data_array['affiliate_company'] = $affiliate_company;
				$sql_data_array['affiliate_company_taxid'] =  $affiliate_company_taxid;
			}
			if (ACCOUNT_SUBURB == TRUE_STRING_S) $sql_data_array['affiliate_suburb'] = $affiliate_suburb;
			if (ACCOUNT_STATE == TRUE_STRING_S) {
				$sql_data_array['affiliate_state'] = $affiliate_state;
				$sql_data_array['affiliate_zone_id'] = $affiliate_zone_id;
			}

			$sql_data_array['affiliate_date_account_last_modified'] = 'now()';

			olc_db_perform(TABLE_AFFILIATE, $sql_data_array, 'update', "affiliate_id = '" . olc_db_input($affiliate_id) . APOS);

			olc_redirect(olc_href_link(FILENAME_AFFILIATE, olc_get_all_get_params(array('acID', 'action')) . 'acID=' . $affiliate_id));
			break;
		case 'deleteconfirm':
			$affiliate_id = olc_db_prepare_input($_GET['acID']);

			affiliate_delete(olc_db_input($affiliate_id));

			olc_redirect(olc_href_link(FILENAME_AFFILIATE, olc_get_all_get_params(array('acID', 'action'))));
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
<?php
if ($_GET['action'] == 'edit') {
	$affiliate_query = olc_db_query("select * from " . TABLE_AFFILIATE . " where affiliate_id = '" . $_GET['acID'] . APOS);
	$affiliate = olc_db_fetch_array($affiliate_query);
	$aInfo = new objectInfo($affiliate);
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo olc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
    	//W. Kaiser - AJAX
      <tr><?php
      echo olc_draw_form('affiliate', FILENAME_AFFILIATE, olc_get_all_get_params(array('action')) . 'action=update', 'post',
      'onsubmit="return check_form(\'affiliate\');"');
      	 ?>
        <td class="formAreaTitle"><?php echo CATEGORY_PERSONAL; ?></td>
      </tr>
			//W. Kaiser - AJAX
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
<?php
if (ACCOUNT_GENDER == TRUE_STRING_S) {
?>
          <tr>
            <td class="main"><?php echo ENTRY_GENDER; ?></td>
            <td class="main"><?php echo olc_draw_radio_field('affiliate_gender', 'm', false, $aInfo->affiliate_gender) . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . olc_draw_radio_field('affiliate_gender', 'f', false, $aInfo->affiliate_gender) . '&nbsp;&nbsp;' . FEMALE; ?></td>
          </tr>
<?php
}
?>
          <tr>
            <td class="main"><?php echo ENTRY_FIRST_NAME; ?></td>
            <td class="main"><?php echo olc_draw_input_field('affiliate_firstname', $aInfo->affiliate_firstname, 'maxlength="32"', true); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_LAST_NAME; ?></td>
            <td class="main"><?php echo olc_draw_input_field('affiliate_lastname', $aInfo->affiliate_lastname, 'maxlength="32"', true); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
            <td class="main"><?php echo olc_draw_input_field('affiliate_email_address', $aInfo->affiliate_email_address, 'maxlength="96"', true); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
if (AFFILATE_INDIVIDUAL_PERCENTAGE == TRUE_STRING_S) {
?>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_COMMISSION; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_COMMISSION; ?></td>
            <td class="main"><?php echo olc_draw_input_field('affiliate_commission_percent', $aInfo->affiliate_commission_percent, 'maxlength="5"'); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
}
?>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_COMPANY; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_COMPANY; ?></td>
            <td class="main"><?php echo olc_draw_input_field('affiliate_company', $aInfo->affiliate_company, 'maxlength="32"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_COMPANY_TAXID; ?></td>
            <td class="main"><?php echo olc_draw_input_field('affiliate_company_taxid', $aInfo->affiliate_company_taxid, 'maxlength="64"'); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_PAYMENT_DETAILS; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
<?php
if (AFFILIATE_USE_CHECK == TRUE_STRING_S) {
?>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_PAYMENT_CHECK; ?></td>
            <td class="main"><?php echo olc_draw_input_field('affiliate_payment_check', $aInfo->affiliate_payment_check, 'maxlength="100"'); ?></td>
          </tr>
<?php
}
if (AFFILIATE_USE_PAYPAL == TRUE_STRING_S) {
?>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_PAYMENT_PAYPAL; ?></td>
            <td class="main"><?php echo olc_draw_input_field('affiliate_payment_paypal', $aInfo->affiliate_payment_paypal, 'maxlength="64"'); ?></td>
          </tr>
<?php
}
if (AFFILIATE_USE_BANK == TRUE_STRING_S) {
?>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_PAYMENT_BANK_NAME; ?></td>
            <td class="main"><?php echo olc_draw_input_field('affiliate_payment_bank_name', $aInfo->affiliate_payment_bank_name, 'maxlength="64"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_PAYMENT_BANK_BRANCH_NUMBER; ?></td>
            <td class="main"><?php echo olc_draw_input_field('affiliate_payment_bank_branch_number', $aInfo->affiliate_payment_bank_branch_number, 'maxlength="64"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_PAYMENT_BANK_SWIFT_CODE; ?></td>
            <td class="main"><?php echo olc_draw_input_field('affiliate_payment_bank_swift_code', $aInfo->affiliate_payment_bank_swift_code, 'maxlength="64"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NAME; ?></td>
            <td class="main"><?php echo olc_draw_input_field('affiliate_payment_bank_account_name', $aInfo->affiliate_payment_bank_account_name, 'maxlength="64"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NUMBER; ?></td>
            <td class="main"><?php echo olc_draw_input_field('affiliate_payment_bank_account_number', $aInfo->affiliate_payment_bank_account_number, 'maxlength="64"'); ?></td>
          </tr>
<?php
}
?>
        </table></td>
      </tr>
      <tr>
        <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_ADDRESS; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_STREET_ADDRESS; ?></td>
            <td class="main"><?php echo olc_draw_input_field('affiliate_street_address', $aInfo->affiliate_street_address, 'maxlength="64"', true); ?></td>
          </tr>
<?php
if (ACCOUNT_SUBURB == TRUE_STRING_S) {
?>
          <tr>
            <td class="main"><?php echo ENTRY_SUBURB; ?></td>
            <td class="main"><?php echo olc_draw_input_field('affiliate_suburb', $aInfo->affiliate_suburb, 'maxlength="64"', false); ?></td>
          </tr>
<?php
}
?>
          <tr>
            <td class="main"><?php echo ENTRY_CITY; ?></td>
            <td class="main"><?php echo olc_draw_input_field('affiliate_city', $aInfo->affiliate_city, 'maxlength="32"', true); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_POST_CODE; ?></td>
            <td class="main"><?php echo olc_draw_input_field('affiliate_postcode', $aInfo->affiliate_postcode, 'maxlength="8"', true); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_COUNTRY; ?></td>
            <td class="main"><?php echo olc_draw_pull_down_menu('affiliate_country_id', olc_get_countries(), $aInfo->affiliate_country_id, 'onchange="update_zone(this.form);"'); ?></td>
          </tr>
<?php
if (ACCOUNT_STATE == TRUE_STRING_S) {
?>
          <tr>
            <td class="main"><?php echo ENTRY_STATE; ?></td>
            <td class="main"><?php echo olc_draw_pull_down_menu('affiliate_zone_id', olc_prepare_country_zones_pull_down($aInfo->affiliate_country_id), $aInfo->affiliate_zone_id, 'onchange="resetStateText(this.form);"'); ?></td>
          </tr>
          <tr>
            <td class="main">&nbsp;</td>
            <td class="main"><?php echo olc_draw_input_field('affiliate_state', $aInfo->affiliate_state, 'maxlength="32" onchange="resetZoneSelected(this.form);"'); ?></td>
          </tr>
<?php
}
?>
        </table></td>
      </tr>
      <tr>
        <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_CONTACT; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
            <td class="main"><?php echo olc_draw_input_field('affiliate_telephone', $aInfo->affiliate_telephone, 'maxlength="32"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_FAX_NUMBER; ?></td>
            <td class="main"><?php echo olc_draw_input_field('affiliate_fax', $aInfo->affiliate_fax, 'maxlength="32"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_HOMEPAGE; ?></td>
            <td class="main"><?php echo olc_draw_input_field('affiliate_homepage', $aInfo->affiliate_homepage, 'maxlength="64"', true); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
       <tr>
        <td align="right" class="main"><?php echo olc_image_submit('button_update.gif', IMAGE_UPDATE) . BLANK.HTML_A_START .
        olc_href_link(FILENAME_AFFILIATE, olc_get_all_get_params(array('action'))) .'">' .
        	olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END;?></td>
      </tr></form>
<?php
} else {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr><?php echo olc_draw_form('search', FILENAME_AFFILIATE, EMPTY_STRING, 'get'); ?>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo olc_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td class="smallText" align="right"><?php echo HEADING_TITLE_SEARCH . BLANK . olc_draw_input_field('search'); ?></td>
          </form></tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_AFFILIATE_ID; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_LASTNAME; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_FIRSTNAME; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_COMMISSION; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_USERHOMEPAGE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
$search = EMPTY_STRING;
if ( ($_GET['search']) && (olc_not_null($_GET['search'])) ) {
	$keywords = olc_db_input(olc_db_prepare_input($_GET['search']));
	$search = " where affiliate_id like '" . $keywords . "' or affiliate_firstname like '" . $keywords . "' or affiliate_lastname like '" . $keywords . "' or affiliate_email_address like '" . $keywords . APOS;
}
$affiliate_query_raw = "select * from " . TABLE_AFFILIATE . $search . " order by affiliate_lastname";
$affiliate_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS,
$affiliate_query_raw, $affiliate_query_numrows);
$affiliate_query = olc_db_query($affiliate_query_raw);
while ($affiliate = olc_db_fetch_array($affiliate_query)) {
	$info_query = olc_db_query("select affiliate_commission_percent, affiliate_date_account_created as date_account_created, affiliate_date_account_last_modified as date_account_last_modified, affiliate_date_of_last_logon as date_last_logon, affiliate_number_of_logons as number_of_logons from " . TABLE_AFFILIATE . " where affiliate_id = '" . $affiliate['affiliate_id'] . APOS);
	$info = olc_db_fetch_array($info_query);

	if (((!$_GET['acID']) || (@$_GET['acID'] == $affiliate['affiliate_id'])) && (!$aInfo)) {
		$country_query = olc_db_query("select countries_name from " . TABLE_COUNTRIES . " where countries_id = '" . $affiliate['affiliate_country_id'] . APOS);
		$country = olc_db_fetch_array($country_query);

		$affiliate_info = array_merge($country, $info);

		$aInfo_array = array_merge($affiliate, $affiliate_info);
		$aInfo = new objectInfo($aInfo_array);
	}

	if ( (is_object($aInfo)) && ($affiliate['affiliate_id'] == $aInfo->affiliate_id) ) {
		echo '          <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' . olc_onclick_link(FILENAME_AFFILIATE, olc_get_all_get_params(array('acID', 'action')) . 'acID=' . $aInfo->affiliate_id . '&action=edit') . '">' . NEW_LINE;
	} else {
		echo '          <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' . olc_onclick_link(FILENAME_AFFILIATE, olc_get_all_get_params(array('acID')) . 'acID=' . $affiliate['affiliate_id']) . '">' . NEW_LINE;
	}
	if (substr($affiliate['affiliate_homepage'],0,7) != "http://") $affiliate['affiliate_homepage']="http://".$affiliate['affiliate_homepage'];
?>
                <td class="dataTableContent"><?php echo $affiliate['affiliate_id']; ?></td>
                <td class="dataTableContent"><?php echo $affiliate['affiliate_lastname']; ?></td>
                <td class="dataTableContent"><?php echo $affiliate['affiliate_firstname']; ?></td>
                <td class="dataTableContent" align="right"><?php if($affiliate['affiliate_commission_percent'] > AFFILIATE_PERCENT) echo $affiliate['affiliate_commission_percent']; else echo  AFFILIATE_PERCENT; ?> %</td>
                <td class="dataTableContent"><?php echo HTML_A_START . olc_href_link(FILENAME_AFFILIATE, olc_get_all_get_params(array('acID', 'action')) . 'acID=' . $affiliate['affiliate_id'] . '&action=edit') . '">' . olc_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . HTML_A_END; echo HTML_A_START . olc_href_link($affiliate['affiliate_homepage']) . '" target="_blank">' . $affiliate['affiliate_homepage'] . HTML_A_END; ?></td>
                <td class="dataTableContent" align="right"><?php echo HTML_A_START . olc_href_link(FILENAME_AFFILIATE_STATISTICS, olc_get_all_get_params(array('acID')) . 'acID=' . $affiliate['affiliate_id']) . '">' . olc_image(DIR_WS_ICONS . 'statistics.gif', ICON_STATISTICS) . '</a>&nbsp;'; if ( (is_object($aInfo)) && ($affiliate['affiliate_id'] == $aInfo->affiliate_id) ) { echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', EMPTY_STRING); } else { echo HTML_A_START . olc_href_link(FILENAME_AFFILIATE, olc_get_all_get_params(array('acID')) . 'acID=' . $affiliate['affiliate_id']) . '">' . olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END; } ?>&nbsp;</td>
              </tr>
<?php
}
?>
              <tr>
                <td colspan="6"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $affiliate_split->display_count($affiliate_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_AFFILIATES); ?></td>
                    <td class="smallText" align="right"><?php echo $affiliate_split->display_links($affiliate_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], olc_get_all_get_params(array('page', 'info', 'x', 'y', 'acID'))); ?></td>
                  </tr>
<?php
if (olc_not_null($_GET['search'])) {
?>
                  <tr>
                    <td align="right" colspan="2"><?php echo HTML_A_START . olc_href_link(FILENAME_AFFILIATE) . '">' . olc_image_button('button_reset.gif', IMAGE_RESET) . HTML_A_END; ?></td>
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
	case 'confirm':
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_DELETE_CUSTOMER . HTML_B_END);

		$contents = array('form' => olc_draw_form('affiliate', FILENAME_AFFILIATE, olc_get_all_get_params(array('acID', 'action')) . 'acID=' . $aInfo->affiliate_id . '&action=deleteconfirm'));
		$contents[] = array('text' => TEXT_DELETE_INTRO . '<br/><br/><b>' . $aInfo->affiliate_firstname . BLANK . $aInfo->affiliate_lastname . HTML_B_END);
		$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_delete.gif', IMAGE_DELETE) . BLANK.HTML_A_START .
		olc_href_link(FILENAME_AFFILIATE, olc_get_all_get_params(array('acID', 'action')) . 'acID=' . $aInfo->affiliate_id) . '">' .
		olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;
	default:
		if (is_object($aInfo)) {
			$heading[] = array('text' => HTML_B_START . $aInfo->affiliate_firstname . BLANK . $aInfo->affiliate_lastname . HTML_B_END);

			$contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_AFFILIATE, olc_get_all_get_params(array('acID', 'action')) . 'acID=' . $aInfo->affiliate_id . '&action=edit') . '">' . olc_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . olc_href_link(FILENAME_AFFILIATE, olc_get_all_get_params(array('acID', 'action')) . 'acID=' . $aInfo->affiliate_id . '&action=confirm') . '">' . olc_image_button('button_delete.gif', IMAGE_DELETE) . '</a> <a href="' . olc_href_link(FILENAME_AFFILIATE_CONTACT, 'selected_box=affiliate&affiliate=' . $aInfo->affiliate_email_address) . '">' . olc_image_button('button_email.gif', IMAGE_EMAIL) . HTML_A_END);

			$affiliate_sales_raw = "select count(*) as count, sum(affiliate_value) as total, sum(affiliate_payment) as payment from " .
			TABLE_AFFILIATE_SALES . " a left join " . TABLE_ORDERS . " o on (a.affiliate_orders_id=o.orders_id)
        where o.orders_status >= " . AFFILIATE_PAYMENT_ORDER_MIN_STATUS .
        " and  affiliate_id = '" . $aInfo->affiliate_id . APOS;
        $affiliate_sales_values = olc_db_query($affiliate_sales_raw);
        $affiliate_sales = olc_db_fetch_array($affiliate_sales_values);

        $contents[] = array('text' => HTML_BR . TEXT_DATE_ACCOUNT_CREATED . BLANK . olc_date_short($aInfo->date_account_created));
        $contents[] = array('text' => EMPTY_STRING . TEXT_DATE_ACCOUNT_LAST_MODIFIED . BLANK . olc_date_short($aInfo->date_account_last_modified));
        $contents[] = array('text' => EMPTY_STRING . TEXT_INFO_DATE_LAST_LOGON . BLANK  . olc_date_short($aInfo->date_last_logon));
        $contents[] = array('text' => EMPTY_STRING . TEXT_INFO_NUMBER_OF_LOGONS . BLANK . $aInfo->number_of_logons);
        $contents[] = array('text' => EMPTY_STRING . TEXT_INFO_COMMISSION . BLANK . $aInfo->affiliate_commission_percent . ' %');
        $contents[] = array('text' => EMPTY_STRING . TEXT_INFO_COUNTRY . BLANK . $aInfo->countries_name);
        $contents[] = array('text' => EMPTY_STRING . TEXT_INFO_NUMBER_OF_SALES . BLANK . $affiliate_sales['count'],EMPTY_STRING);
        $contents[] = array('text' => EMPTY_STRING . TEXT_INFO_SALES_TOTAL . BLANK . $currencies->display_price($affiliate_sales['total'],EMPTY_STRING));
        $contents[] = array('text' => EMPTY_STRING . TEXT_INFO_AFFILIATE_TOTAL . BLANK . $currencies->display_price($affiliate_sales['payment'],EMPTY_STRING));
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
