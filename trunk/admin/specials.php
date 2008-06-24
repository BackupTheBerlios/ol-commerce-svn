<?php
/* --------------------------------------------------------------
$Id: specials.php,v 1.1.1.1.2.1 2007/04/08 07:16:32 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(specials.php,v 1.38 2002/05/16); www.oscommerce.com
(c) 2003	    nextcommerce (specials.php,v 1.9 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

$div_field='<div id="spiffycalendar" class="text"></div>';
require('includes/application_top.php');
require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();

require_once(DIR_FS_INC.'olc_get_tax_rate.inc.php');
require_once(DIR_FS_INC.'olc_format_price.inc.php');

$page=$_GET['page'];
$sID=olc_db_prepare_input($_GET['sID']);
$action=$_GET['action'];
$expires_date=$_POST['expires_date'];
$products_price_text='products_price';
$post_products_price_text=$_POST[$products_price_text];
$specials_price_text='specials_price';
$post_specials_price_text=$_POST[$specials_price_text];
//W. Kaiser - Use german date
if ($expires_date)
{
	if (!(strpos($expires_date,DOT)===false))
	{
		//Convert german date to american date
		$expires_date=
		substr($expires_date,6,4)."-".
		substr($expires_date,3,2)."-".
		substr($expires_date,0,2);
	}
}
$is_brutto=PRICE_IS_BRUTTO==TRUE_STRING_S;
switch ($action)
{
	case 'setflag':
		olc_set_specials_status($_GET['id'], $_GET['flag']);
		break;
	case 'insert':
		// insert a product on special
		if (substr($post_specials_price_text, -1) == '%') {
			$new_special_insert_query = olc_db_query("select products_id,products_tax_class_id, products_price from " .
			TABLE_PRODUCTS . " where products_id = '" . (int)$_POST['products_id'] . APOS);
			$new_special_insert = olc_db_fetch_array($new_special_insert_query);
			$post_products_price_text = $new_special_insert[$products_price_text];
			$post_specials_price_text = ($post_products_price_text - (($post_specials_price_text / 100) *
			$post_products_price_text))+5000;
		}  else {
			if ($is_brutto){
				$sql="select tr.tax_rate from " . TABLE_TAX_RATES . " tr, " . TABLE_PRODUCTS . " p
				where tr.tax_class_id = p. products_tax_class_id  and p.products_id = '". $_POST['products_id'] . "' ";
				$tax_query = olc_db_query($sql);
				$tax = olc_db_fetch_array($tax_query);
				$post_specials_price_text = ($post_specials_price_text/($tax[tax_rate]+100)*100);
			}
		}
		olc_db_query(INSERT_INTO . TABLE_SPECIALS .
		" (products_id, specials_new_products_price, specials_date_added, expires_date, status) values ('" .
		$_POST['products_id'] . "', '" . $post_specials_price_text . "', now(), '" . $expires_date . "', '1')");
		break;
	case 'update':
		// update a product on special
		if ($is_brutto && substr($post_specials_price_text, -1) != '%'){
			$sql="select tr.tax_rate from " . TABLE_TAX_RATES . " tr, " . TABLE_PRODUCTS .
			" p  where tr.tax_class_id = p. products_tax_class_id  and p.products_id = '". $_POST['products_up_id'] . "' ";
			$tax_query = olc_db_query($sql);
			$tax = olc_db_fetch_array($tax_query);
			$post_specials_price_text = ($post_specials_price_text/($tax[tax_rate]+100)*100);
		}
		if (substr($post_specials_price_text, -1) == '%')  {
			$post_specials_price_text = ($post_products_price_text - (($post_specials_price_text / 100) *
			$post_products_price_text));
		}
		olc_db_query(SQL_UPDATE . TABLE_SPECIALS . " set specials_new_products_price = '" .
		$post_specials_price_text . "', specials_last_modified = now(), expires_date = '" . $expires_date . "'
		where specials_id = '" . $_POST['specials_id'] . APOS);
		break;
	case 'deleteconfirm':
		olc_db_query(DELETE_FROM . TABLE_SPECIALS . " where specials_id = '" . $sID . APOS);
		break;
}
/*
$div_field='<div id="spiffycalendar" class="text"></div>';
require(DIR_WS_INCLUDES . 'header.php');
*/
$is_edit=$action == 'edit';
$is_new_or_edit=($action == 'new') || $is_edit;
if ($is_new_or_edit)
{
	if (NOT_USE_AJAX_ADMIN)
	{
		echo '
<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
';
	}
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
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right">
            	<?php echo olc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?>
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
<?php
if ($is_new_or_edit)
{
	$is_update=$is_edit && $sID;
	if ($is_update)
	{
		$form_action = 'update';
		$product_query = olc_db_query("select
		p.products_tax_class_id,
    p.products_id,
    pd.products_name,
    p.products_price,
    s.specials_new_products_price,
    s.expires_date from
    " . TABLE_PRODUCTS . " p,
    " . TABLE_PRODUCTS_DESCRIPTION . " pd,
    " . TABLE_SPECIALS . "
    s where p.products_id = pd.products_id
    and pd.language_id = '" . SESSION_LANGUAGE_ID . "'
    and p.products_id = s.products_id
    and s.specials_id = '" . $sID . APOS);
		$product = olc_db_fetch_array($product_query);
		$sInfo = new objectInfo($product);
	} else {
		$form_action = 'insert';
		$sInfo = new objectInfo(array());
		// create an array of products on special, which will be excluded from the pull down menu of products
		// (when creating a new product on special)
		$specials_array = array();
		$specials_query = olc_db_query("select
    p.products_id from
    " . TABLE_PRODUCTS . " p,
    " . TABLE_SPECIALS . " s
    where s.products_id = p.products_id");
		while ($specials = olc_db_fetch_array($specials_query)) {
			$specials_array[] = $specials['products_id'];
		}
	}
	echo olc_draw_form('specials', FILENAME_SPECIALS, olc_get_all_get_params(array('action', 'info', 'sID')) .
	'action=' . $form_action, 'post');
	if ($is_update)
	{
		echo olc_draw_hidden_field('specials_id', $sID);
	}
?>
        <td><br/><table border="0" cellspacing="0" cellpadding="2">
        <td class="main"><?php echo TEXT_SPECIALS_PRODUCT;?>&nbsp;</td>
<?php
	$price=abs($sInfo->products_price);
	$new_price=$sInfo->specials_new_products_price;
	if ($is_brutto)
	{
		$price_netto=olc_round($price,PRICE_PRECISION);
		$new_price_netto=olc_round($new_price,PRICE_PRECISION);
		$tax_factor=(olc_get_tax_rate($sInfo->products_tax_class_id)+100)/100;
		$price= $price*$tax_factor;
		$new_price= $new_price*$tax_factor;
	}
	$price=olc_round($price,PRICE_PRECISION);
	$new_price=olc_round($new_price,PRICE_PRECISION);
	echo olc_draw_hidden_field("products_up_id",$sInfo->products_id);
?>
	          <td class="main"><?php echo ($sInfo->products_name) ? $sInfo->products_name . ' <small>(' .
	          ltrim(olc_format_price($price,1,1)). ')</small>' :
	          olc_draw_products_pull_down('products_id', 'style="font-size:10px"', $specials_array);
	          echo olc_draw_hidden_field($products_price_text, $sInfo->products_price); ?></td>
				  </tr>
          <tr>
            <td class="main"><?php echo TEXT_SPECIALS_SPECIAL_PRICE; ?>&nbsp;</td>
            <td class="main"><?php echo olc_draw_input_field($specials_price_text, $new_price);?> </td>
          </tr>
          <tr>
            <td class="main">
            	<?php
            	$spiffy_date_field_caption=TEXT_SPECIALS_EXPIRES_DATE;
            	$spiffy_date=$sInfo->expires_date;
            	$spiffy_control_name="dateExpires";
            	$spiffy_form_name='specials';
            	$spiffy_date_field_name='expires_date';
            	include(DIR_FS_INC.'olc_create_spiffy_control.inc.php');
							?>
	          </td>
						<!-- W. Kaiser - Use german date-->
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><br/><?php echo TEXT_SPECIALS_PRICE_TIP; ?></td>
            <td class="main" align="right" valign="top"><br/><?php echo (($form_action == 'insert') ?
            olc_image_submit('button_insert.gif', IMAGE_INSERT) : olc_image_submit('button_update.gif', IMAGE_UPDATE)).
            '&nbsp;&nbsp;&nbsp;<a href="' . olc_href_link(FILENAME_SPECIALS, 'page=' . $page . '&sID=' . $sID) . '">' .
            olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END; ?></td>
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
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRODUCTS_PRICE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
$specials_query_raw = "select p.products_id, pd.products_name, p.products_price, s.specials_id, s.specials_new_products_price, s.specials_date_added, s.specials_last_modified, s.expires_date, s.date_status_change, s.status from " . TABLE_PRODUCTS . " p, " . TABLE_SPECIALS . " s, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = pd.products_id and pd.language_id = '" . SESSION_LANGUAGE_ID . "' and p.products_id = s.products_id order by pd.products_name";
$specials_split = new splitPageResults($page, MAX_DISPLAY_SEARCH_RESULTS, $specials_query_raw, $specials_query_numrows);
$specials_query = olc_db_query($specials_query_raw);
while ($specials = olc_db_fetch_array($specials_query)) {
	if (((!$sID) || ($sID == $specials['specials_id'])) && (!$sInfo)) {

		$products_query = olc_db_query("select products_image from " . TABLE_PRODUCTS .
		" where products_id = '" . $specials['products_id'] . APOS);
		$products = olc_db_fetch_array($products_query);
		$sInfo_array = olc_array_merge($specials, $products);
		$sInfo = new objectInfo($sInfo_array);
	}

	if ((is_object($sInfo)) && ($specials['specials_id'] == $sInfo->specials_id)) {
		echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' .
		olc_onclick_link(FILENAME_SPECIALS, 'page=' . $page . '&sID=' . $sInfo->specials_id . '&action=edit') . '">' . NEW_LINE;
	} else {
		echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' . olc_onclick_link(FILENAME_SPECIALS, 'page=' . $page . '&sID=' . $specials['specials_id']) . '">' . NEW_LINE;
	}
?>
                <td  class="dataTableContent"><?php echo $specials['products_name']; ?></td>
                <td  class="dataTableContent" align="right"><span class="oldPrice">
                <?php echo olc_format_price($specials[$products_price_text],1,1); ?></span>
                <span class="specialPrice">
                <?php echo olc_format_price($specials['specials_new_products_price'],1,1); ?></span></td>
                <td  class="dataTableContent" align="right">
<?php
if ($specials['status'] == '1') {
	echo olc_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' .
	olc_href_link(FILENAME_SPECIALS, 'action=setflag&flag=0&id=' . $specials['specials_id'], NONSSL) . '">' .
	olc_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . HTML_A_END;
} else {
	echo HTML_A_START . olc_href_link(FILENAME_SPECIALS, 'action=setflag&flag=1&id=' . $specials['specials_id'], NONSSL) . '">' .
	olc_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' .
	olc_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
}
?>
								</td>
                <td class="dataTableContent" align="right">
                <?php if ((is_object($sInfo)) && ($specials['specials_id'] == $sInfo->specials_id))
                {
                	echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', '');
                } else {
                	echo HTML_A_START . olc_href_link(FILENAME_SPECIALS, 'page=' . $page .
                	'&sID=' . $specials['specials_id']) . '">' .
                	olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END;
                } ?>
                &nbsp;
                </td>
      				</tr>
<?php
}
?>
              <tr>
                <td colspan="4">
                	<table border="0" width="100%" cellpadding="0"cellspacing="2">
		                <tr>
		                  <td class="smallText" valign="top">
		                    <?php echo $specials_split->display_count($specials_query_numrows, MAX_DISPLAY_SEARCH_RESULTS,
		                    $page, TEXT_DISPLAY_NUMBER_OF_SPECIALS); ?>
		                  </td>
		                  <td class="smallText" align="right">
		                    <?php echo $specials_split->display_links($specials_query_numrows, MAX_DISPLAY_SEARCH_RESULTS,
		                     MAX_DISPLAY_PAGE_LINKS, $page); ?>
		                  </td>
		                </tr>
<?php
if (!$action) {
?>
	                  <tr>
	                    <td colspan="2" align="right"><?php echo HTML_A_START . olc_href_link(FILENAME_SPECIALS,
	                    'page=' . $page . '&action=new') . '">' .
	                    olc_image_button('button_new_product.gif', IMAGE_NEW_PRODUCT) . HTML_A_END; ?></td>
	                  </tr>
<?php
}
?>
                	</table>
                </td>
              </tr>
            </table>
          </td>
<?php
$heading = array();
$contents = array();
switch ($action) {
	case 'delete':
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_DELETE_SPECIALS . HTML_B_END);

		$contents = array('form' => olc_draw_form('specials', FILENAME_SPECIALS, 'page=' . $page .
		'&sID=' . $sInfo->specials_id . '&action=deleteconfirm'));
		$contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
		$contents[] = array('text' => '<br/><b>' . $sInfo->products_name . HTML_B_END);
		$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_delete.gif', IMAGE_DELETE) .
		'&nbsp;<a href="' . olc_href_link(FILENAME_SPECIALS, 'page=' . $page . '&sID=' . $sInfo->specials_id) . '">' .
		olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;

	default:
		if (is_object($sInfo)) {
			$heading[] = array('text' => HTML_B_START . $sInfo->products_name . HTML_B_END);

			$contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_SPECIALS, 'page=' . $page .
			'&sID=' . $sInfo->specials_id . '&action=edit') . '">' . olc_image_button('button_edit.gif', IMAGE_EDIT) .
			'</a> <a href="' . olc_href_link(FILENAME_SPECIALS, 'page=' . $page . '&sID=' . $sInfo->specials_id .
			'&action=delete') . '">' . olc_image_button('button_delete.gif', IMAGE_DELETE) . HTML_A_END);
			$contents[] = array('text' => HTML_BR . TEXT_INFO_DATE_ADDED . BLANK . olc_date_short($sInfo->specials_date_added));
			$contents[] = array('text' => '' . TEXT_INFO_LAST_MODIFIED . BLANK . olc_date_short($sInfo->specials_last_modified));
			$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_product_info_image($sInfo->products_image,
			$sInfo->products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT));
			$contents[] = array('text' => HTML_BR . TEXT_INFO_ORIGINAL_PRICE . BLANK . $currencies->format($sInfo->products_price));
			$contents[] = array('text' => '' . TEXT_INFO_NEW_PRICE . BLANK . $currencies->format($sInfo->specials_new_products_price));
			$contents[] = array('text' => '' . TEXT_INFO_PERCENTAGE . BLANK .
			number_format(100 - (($sInfo->specials_new_products_price / $sInfo->products_price) * 100)) . '%');
			$contents[] = array('text' => HTML_BR . TEXT_INFO_EXPIRES_DATE . ' <b>' . olc_date_short($sInfo->expires_date) . HTML_B_END);
			$contents[] = array('text' => '' . TEXT_INFO_STATUS_CHANGE . BLANK . olc_date_short($sInfo->date_status_change));
		}
		break;
}
if ((olc_not_null($heading)) && (olc_not_null($contents))) {
	echo '            <td width="25%" valign="top">' . NEW_LINE;

	$box = new box;
	echo $box->infoBox($heading, $contents);

	echo '            </td>' . NEW_LINE;
}
}
?>
          </tr>
        </table></td>
      </tr>
    </table></td>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
