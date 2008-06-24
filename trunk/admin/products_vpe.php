<?php
/* --------------------------------------------------------------
$Id: products_vpe.php

OL-Commerce Version 1.2
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(order_status.php,v 1.19 2003/02/06); www.oscommerce.com
(c) 2003	    nextcommerce (order_status.php,v 1.9 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application_top.php');
$default_products_vpe_id=DEFAULT_PRODUCTS_VPE_ID;
$oID = olc_db_prepare_input($_GET['oID']);
$action=$_GET['action'];
$table_configuration=TABLE_CONFIGURATION . " set configuration_value = '#'
 where configuration_key = 'DEFAULT_PRODUCTS_VPE_ID'";
switch ($action)
{
	case 'insert':
	case 'save':
		$products_vpe_id = $oID;
		$languages = olc_get_languages();
		for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
			$products_vpe_name_array = $_POST['products_vpe_name'];
			$language_id = $languages[$i]['id'];
			$sql_data_array = array('products_vpe_name' => olc_db_prepare_input($products_vpe_name_array[$language_id]));
			if ($action == 'insert')
			{
				if (!olc_not_null($products_vpe_id)) {
					$next_id_query = olc_db_query("select max(products_vpe_id) as products_vpe_id from " . TABLE_PRODUCTS_VPE . "");
					$next_id = olc_db_fetch_array($next_id_query);
					$products_vpe_id = $next_id['products_vpe_id'] + 1;
				}

				$insert_sql_data = array('products_vpe_id' => $products_vpe_id,
				'language_id' => $language_id);
				$sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
				olc_db_perform(TABLE_PRODUCTS_VPE, $sql_data_array);
			} elseif ($action == 'save') {
				olc_db_perform(TABLE_PRODUCTS_VPE, $sql_data_array, 'update', "products_vpe_id = '" .
				$products_vpe_id . "' and language_id = '" . $language_id . APOS);
			}
		}
		if ($_POST['default'] == 'on')
		{
			olc_db_query(SQL_UPDATE . str_replace(HASH,$oID,$table_configuration));
			$default_products_vpe_id=$products_vpe_id;
		}
		//olc_redirect(olc_href_link(FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page'] . '&oID=' . $products_vpe_id));
		break;

	case 'deleteconfirm':
		olc_db_query(DELETE_FROM . TABLE_PRODUCTS_VPE . " where products_vpe_id = '" . $oID . APOS);
		if ($default_products_vpe_id == $oID)
		{
			olc_db_query(SQL_UPDATE . str_replace(HASH,EMPTY_STRING,$table_configuration));
		}
		//olc_redirect(olc_href_link(FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page']));
		break;

	case 'delete':
		$remove_status = true;
		if ($oID == $default_products_vpe_id)
		{
			$remove_status = false;
			$messageStack->add(ERROR_REMOVE_DEFAULT_PRODUCTS_VPE, 'error');
		}
		break;
	default:
		{
			$action='edit';
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
    <td class="boxCenter" width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="80" rowspan="2"><?php echo olc_image(DIR_WS_ICONS.'heading_configuration.gif'); ?></td>
    <td class="pageHeading">
			<?php
			define('AJAX_TITLE',BOX_PRODUCTS_VPE);
			echo AJAX_TITLE;
			?>
    </td>
  </tr>
  <tr>
    <td class="main" valign="top">OLC Konfiguration</td>
  </tr>
</table></td>
      </tr>
      <tr>
        <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_VPE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
$products_vpe_query_raw = "select products_vpe_id, products_vpe_name from " . TABLE_PRODUCTS_VPE .
" where language_id = '" . SESSION_LANGUAGE_ID . "' order by products_vpe_id";
$products_vpe_split = new splitPageResults($_GET['page'], '20', $products_vpe_query_raw, $products_vpe_query_numrows);
$products_vpe_query = olc_db_query($products_vpe_query_raw);
while ($products_vpe = olc_db_fetch_array($products_vpe_query))
{
	if (((!$oID) || ($oID == $products_vpe['products_vpe_id'])) && (!$oInfo) &&
	(substr($action, 0, 3) != 'new')) {
		$oInfo = new objectInfo($products_vpe);
	}

	if ( (is_object($oInfo)) && ($products_vpe['products_vpe_id'] == $oInfo->products_vpe_id) ) {
		echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' .
		olc_onclick_link(FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_vpe_id .
		'&action=edit') . '">' . NEW_LINE;
	} else {
		echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' .
		olc_onclick_link(FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page'] . '&oID=' . $products_vpe['products_vpe_id']) . '">' . NEW_LINE;
	}
	if ($default_products_vpe_id == $products_vpe['products_vpe_id']) {
		echo '                <td class="dataTableContent"><b>' . $products_vpe['products_vpe_name'] . LPAREN . TEXT_DEFAULT . ')</b></td>' . NEW_LINE;
	} else {
		echo '                <td class="dataTableContent">' . $products_vpe['products_vpe_name'] . '</td>' . NEW_LINE;
	}
?>
                <td class="dataTableContent" align="right"><?php if ( (is_object($oInfo)) && ($products_vpe['products_vpe_id'] == $oInfo->products_vpe_id) ) { echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', EMPTY_STRING); } else { echo HTML_A_START . olc_href_link(FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page'] . '&oID=' . $products_vpe['products_vpe_id']) . '">' . olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END; } ?>&nbsp;</td>
              </tr>
<?php
}
?>
              <tr>
                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $products_vpe_split->display_count($products_vpe_query_numrows, '20', $_GET['page'], TEXT_DISPLAY_NUMBER_OF_PRODUCTS_VPE); ?></td>
                    <td class="smallText" align="right"><?php echo $products_vpe_split->display_links($products_vpe_query_numrows, '20', MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
if (substr($action, 0, 3) != 'new') {
?>
                  <tr>
                    <td colspan="2" align="right"><?php echo HTML_A_START . olc_href_link(FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page'] . '&action=new') . '">' . olc_image_button('button_insert.gif', IMAGE_INSERT) . HTML_A_END; ?></td>
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
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_NEW_PRODUCTS_VPE . HTML_B_END);

		$contents = array('form' => olc_draw_form('status', FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page'] . '&action=insert'));
		$contents[] = array('text' => TEXT_INFO_INSERT_INTRO);

		$products_vpe_inputs_string = EMPTY_STRING;
		$languages = olc_get_languages();
		for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
			$products_vpe_inputs_string .= HTML_BR .
			olc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/'.$languages[$i]['image']) . HTML_NBSP .
			olc_draw_input_field('products_vpe_name[' . $languages[$i]['id'] . ']');
		}

		$contents[] = array('text' => HTML_BR . TEXT_INFO_PRODUCTS_VPE_NAME . $products_vpe_inputs_string);
		$contents[] = array('text' => HTML_BR . olc_draw_checkbox_field('default') . BLANK . TEXT_SET_DEFAULT);
		$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_insert.gif', IMAGE_INSERT) .
		BLANK.HTML_A_START . olc_href_link(FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page']) . '">' .
		olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;

	case 'edit':
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_EDIT_PRODUCTS_VPE . HTML_B_END);

		$contents = array('form' => olc_draw_form('status', FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page'] .
		'&oID=' . $oInfo->products_vpe_id  . '&action=save'));
		$contents[] = array('text' => TEXT_INFO_EDIT_INTRO);

		$products_vpe_inputs_string = EMPTY_STRING;
		$languages = olc_get_languages();
		for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
			$products_vpe_inputs_string .= HTML_BR .
			olc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/'.$languages[$i]['image']) . HTML_NBSP .
			olc_draw_input_field('products_vpe_name[' . $languages[$i]['id'] . ']',
			olc_get_products_vpe_name($oInfo->products_vpe_id, $languages[$i]['id']));
		}

		$contents[] = array('text' => HTML_BR . TEXT_INFO_PRODUCTS_VPE_NAME . $products_vpe_inputs_string);
		if ($default_products_vpe_id != $oInfo->products_vpe_id) $contents[] = array('text' => HTML_BR .
		olc_draw_checkbox_field('default') . BLANK . TEXT_SET_DEFAULT);
		$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_update.gif', IMAGE_UPDATE) .
		BLANK.HTML_A_START . olc_href_link(FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_vpe_id) . '">' .
		olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;

	case 'delete':
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_DELETE_PRODUCTS_VPE . HTML_B_END);

		$contents = array('form' => olc_draw_form('status', FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page'] .
		'&oID=' . $oInfo->products_vpe_id  . '&action=deleteconfirm'));
		$contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
		$contents[] = array('text' => '<br/><b>' . $oInfo->products_vpe_name . HTML_B_END);
		if ($remove_status) $contents[] = array('align' => 'center', 'text' => HTML_BR .
		olc_image_submit('button_delete.gif', IMAGE_DELETE) . BLANK.HTML_A_START . olc_href_link(FILENAME_PRODUCTS_VPE,
		'page=' . $_GET['page'] . '&oID=' . $oInfo->products_vpe_id) . '">' .
		olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;
/*
	default:
		if (is_object($oInfo)) {

			$heading[] = array('text' => HTML_B_START . $oInfo->products_vpe_name . HTML_B_END);

			$contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_PRODUCTS_VPE,
			'page=' . $_GET['page'] . '&oID=' . $oInfo->products_vpe_id . '&action=edit') . '">' .
			olc_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . olc_href_link(FILENAME_PRODUCTS_VPE,
			'page=' . $_GET['page'] . '&oID=' . $oInfo->products_vpe_id . '&action=delete') . '">' .
			olc_image_button('button_delete.gif', IMAGE_DELETE) . HTML_A_END);

			$products_vpe_inputs_string = EMPTY_STRING;
			$languages = olc_get_languages();
			for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
				//     $products_vpe_inputs_string .= HTML_BR . olc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/'.$languages[$i]['image']) . HTML_NBSP . olc_get_products_vpe_name($oInfo->products_vpe_id, $languages[$i]['id']);
			}

			$contents[] = array('text' => $products_vpe_inputs_string);
		}
		break;
*/
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
