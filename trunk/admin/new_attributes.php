<?php
/* --------------------------------------------------------------
$Id: new_attributes.php,v 1.1.1.1.2.1 2007/04/08 07:16:29 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(new_attributes); www.oscommerce.com
(c) 2003	    nextcommerce (new_attributes.php,v 1.13 2003/08/21); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------
Third Party contributions:
New Attribute Manager v4b				Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
copy attributes                          Autor: Hubi | http://www.netz-designer.de
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application_top.php');
require('new_attributes_config.php');
require(DIR_FS_INC.'olc_findTitle.inc.php');

//W. Kaiser - AJAX
$button_action=(USE_AJAX)? $button_action="button_left()":"history.back(1)";
$backLink = "<a href=\"javascript:".$button_action."\">";
$current_product_id=$_POST['current_product_id'];
//W. Kaiser - AJAX
$action=$_POST['action'];
if (isset($cPathID))
{
	if ($action == 'change')
	{
		include('new_attributes_change.php');

		olc_redirect( './' . FILENAME_CATEGORIES . '?cPath=' . $cPathID . '&pID=' . $current_product_id );
	}
}
require(DIR_WS_INCLUDES . 'header.php');
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
<?php
switch($action)
{
	case 'edit':
		$copy_product_id=(int)$_POST['copy_product_id'];
		if ($copy_product_id>0)
		{
			$sql_insert=
			INSERT_INTO . TABLE_PRODUCTS_ATTRIBUTES .
			" (
				products_id, 
				options_id, 
				options_values_id, 
				options_values_price, 
				price_prefix,
				attributes_model, 
				attributes_stock, 
				options_values_weight,
				sortorder,
				weight_prefix
				) VALUES ('";
			$delete=DELETE_FROM . TABLE_PRODUCTS_ATTRIBUTES . SQL_WHERE;
			$comma_blank="', '";
			$attrib_query = olc_db_query("
			SELECT 
			products_id, 
			options_id, 
			options_values_id, 
			options_values_price,
      price_prefix, 
      attributes_model, 
      attributes_stock, 
      options_values_weight,
      sortorder,
      weight_prefix FROM " .
			TABLE_PRODUCTS_ATTRIBUTES ." WHERE products_id = " . $copy_product_id);
			if (olc_db_num_rows($attrib_query)>0)
			{
				while ($attrib_res = olc_db_fetch_array($attrib_query))
				{
					$options_id=$attrib_res['options_id'];
					$options_values_id =$attrib_res['options_values_id'];
					//Delete for safety
					olc_db_query($delete . 
					"products_id='".$current_product_id .APOS. SQL_AND.
					"options_id='".$options_id .APOS. SQL_AND.
					"options_values_id='".$options_values_id .APOS);

					$sql=
					$sql_insert .
					$current_product_id . $comma_blank .
					$options_id . $comma_blank .
					$options_values_id . $comma_blank .
					$attrib_res['options_values_price'] . $comma_blank .
					$attrib_res['price_prefix'] . $comma_blank .
					$attrib_res['attributes_model'] . $comma_blank .
					$attrib_res['attributes_stock'] . $comma_blank .
					$attrib_res['options_values_weight'] . $comma_blank .
					$attrib_res['sortorder'] . $comma_blank .
					$attrib_res['weight_prefix'] . "')";
					olc_db_query($sql);
				}
			}
		}
		else
		{
			unset($_POST['no_edit']);
		}
		if ($_POST['no_edit']==TRUE_STRING_S)
		{
			$action=EMPTY_STRING;
		}
		else
		{
			$pageTitle = TEXT_EDIT_ATTRIBUTES.' -> ' . olc_findTitle($current_product_id, $languageFilter);
			include('new_attributes_include.php');
			break;
		}
	case 'change':
		$pageTitle = TEXT_UPDATE_ATTRIBUTES;
		include('new_attributes_change.php');
		include('new_attributes_select.php');
		break;
	default:
		$pageTitle = TEXT_EDIT_ATTRIBUTES;
		include('new_attributes_select.php');
		break;
}
?>
    </table></td>
  </tr>
<!-- body_eof //-->
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
