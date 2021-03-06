<?php
/* --------------------------------------------------------------
$Id: products_attributes.php,v 1.1.1.1.2.1 2007/04/08 07:16:31 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(products_attributes.php,v 1.48 2002/11/22); www.oscommerce.com
(c) 2003	    nextcommerce (products_attributes.php,v 1.10 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application_top.php');
$languages = olc_get_languages();
$action=$_GET['action'];
if ($action)
{
	$page_info = 'option_page=' . $_GET['option_page'] . '&value_page=' .
	$_GET['value_page'] . '&attribute_page=' . $_GET['attribute_page'];
	switch($action) {
		case 'add_product_options':
			for ($i = 0, $n = sizeof($languages); $i < $n; $i ++) {
				$option_name = $_POST['option_name'];
				olc_db_query(INSERT_INTO . TABLE_PRODUCTS_OPTIONS . " (products_options_id, products_options_name, language_id) values ('" . $_POST['products_options_id'] . "', '" . $option_name[$languages[$i]['id']] . "', '" . $languages[$i]['id'] . "')");
			}
			olc_redirect(olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
			break;
		case 'add_product_option_values':
			for ($i = 0, $n = sizeof($languages); $i < $n; $i ++) {
				$value_name = $_POST['value_name'];
				olc_db_query(INSERT_INTO . TABLE_PRODUCTS_OPTIONS_VALUES . " (products_options_values_id, language_id, products_options_values_name) values ('" . $_POST['value_id'] . "', '" . $languages[$i]['id'] . "', '" . $value_name[$languages[$i]['id']] . "')");
			}
			olc_db_query(INSERT_INTO . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " (products_options_id, products_options_values_id) values ('" . $_POST['option_id'] . "', '" . $_POST['value_id'] . "')");
			olc_redirect(olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
			break;
		case 'add_product_attributes':
			olc_db_query(INSERT_INTO . TABLE_PRODUCTS_ATTRIBUTES . " values ('', '" . $_POST['products_id'] . "', '" . $_POST['options_id'] . "', '" . $_POST['values_id'] . "', '" . $_POST['value_price'] . "', '" . $_POST['price_prefix'] . "')");
			$products_attributes_id = olc_db_insert_id();
			if ((DOWNLOAD_ENABLED == TRUE_STRING_S) && $_POST['products_attributes_filename'] != '') {
				olc_db_query(INSERT_INTO . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " values (" . $products_attributes_id . ", '" . $_POST['products_attributes_filename'] . "', '" . $_POST['products_attributes_maxdays'] . "', '" . $_POST['products_attributes_maxcount'] . "')");
			}
			olc_redirect(olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
			break;
		case 'update_option_name':
			for ($i = 0, $n = sizeof($languages); $i < $n; $i ++) {
				$option_name = $_POST['option_name'];
				olc_db_query(SQL_UPDATE . TABLE_PRODUCTS_OPTIONS . " set products_options_name = '" . $option_name[$languages[$i]['id']] . "' where products_options_id = '" . $_POST['option_id'] . "' and language_id = '" . $languages[$i]['id'] . APOS);
			}
			olc_redirect(olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
			break;
		case 'update_value':
			$value_name = $_POST['value_name'];
			for ($i = 0, $n = sizeof($languages); $i < $n; $i ++) {
				olc_db_query(SQL_UPDATE . TABLE_PRODUCTS_OPTIONS_VALUES . " set products_options_values_name = '" . $value_name[$languages[$i]['id']] . "' where products_options_values_id = '" . $_POST['value_id'] . "' and language_id = '" . $languages[$i]['id'] . APOS);
			}
			olc_db_query(SQL_UPDATE . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " set products_options_id = '" . $_POST['option_id'] . "' where products_options_values_id = '" . $_POST['value_id'] . APOS);
			olc_redirect(olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
			break;
		case 'update_product_attribute':
			olc_db_query(SQL_UPDATE . TABLE_PRODUCTS_ATTRIBUTES . " set products_id = '" . $_POST['products_id'] . "', options_id = '" . $_POST['options_id'] . "', options_values_id = '" . $_POST['values_id'] . "', options_values_price = '" . $_POST['value_price'] . "', price_prefix = '" . $_POST['price_prefix'] . "' where products_attributes_id = '" . $_POST['attribute_id'] . APOS);
			if ((DOWNLOAD_ENABLED == TRUE_STRING_S) && $_POST['products_attributes_filename'] != '') {
				olc_db_query(SQL_UPDATE . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . "
                        set products_attributes_filename='" . $_POST['products_attributes_filename'] . "',
                            products_attributes_maxdays='" . $_POST['products_attributes_maxdays'] . "',
                            products_attributes_maxcount='" . $_POST['products_attributes_maxcount'] . "'
                        where products_attributes_id = '" . $_POST['attribute_id'] . APOS);
			}
			olc_redirect(olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
			break;
		case 'delete_option':
			olc_db_query(DELETE_FROM . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . $_GET['option_id'] . APOS);
			olc_redirect(olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
			break;
		case 'delete_value':
			olc_db_query(DELETE_FROM . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . $_GET['value_id'] . APOS);
			olc_db_query(DELETE_FROM . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . $_GET['value_id'] . APOS);
			olc_db_query(DELETE_FROM . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_values_id = '" . $_GET['value_id'] . APOS);
			olc_redirect(olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
			break;
		case 'delete_attribute':
			olc_db_query(DELETE_FROM . TABLE_PRODUCTS_ATTRIBUTES . " where products_attributes_id = '" . $_GET['attribute_id'] . APOS);
			// Added for DOWNLOAD_ENABLED. Always try to remove attributes, even if downloads are no longer enabled
			olc_db_query(DELETE_FROM . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " where products_attributes_id = '" . $_GET['attribute_id'] . APOS);
			olc_redirect(olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
			break;
	}
}
?>
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<script language="javascript" type="text/javascript"><!--
function go_option() {
	if (document.option_order_by.selected.options[document.option_order_by.selected.selectedIndex].value != "none") {
		location = "<?php echo olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'option_page=' . ($_GET['option_page'] ? $_GET['option_page'] : 1)); ?>&option_order_by="+document.option_order_by.selected.options[document.option_order_by.selected.selectedIndex].value;
	}
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
<td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
<!-- options and values//-->
<tr>
<td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td valign="top" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="2">

<!-- options //-->
<?php
if ($action == 'delete_product_option') { // delete product option
	$options = olc_db_query("select products_options_id, products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . $_GET['option_id'] . "' and language_id = '" . SESSION_LANGUAGE_ID . APOS);
	$options_values = olc_db_fetch_array($options);
	?>
	<tr>
	<td class="pageHeading">&nbsp;
	<?php
	define('AJAX_TITLE',$options_values['products_options_name']);
	echo AJAX_TITLE;
	?>
	&nbsp;
	</td>
	<td>&nbsp;<?php echo olc_image(DIR_WS_IMAGES . 'pixel_trans.gif', '', '1', '53'); ?>&nbsp;</td>
	</tr>
	<tr>
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td colspan="3"><?php echo olc_black_line(); ?></td>
	</tr>
	<?php
	$products = olc_db_query("select p.products_id, pd.products_name, pov.products_options_values_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov, " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id = p.products_id and pov.language_id = '" . SESSION_LANGUAGE_ID . "' and pd.language_id = '" . SESSION_LANGUAGE_ID . "' and pa.products_id = p.products_id and pa.options_id='" . $_GET['option_id'] . "' and pov.products_options_values_id = pa.options_values_id order by pd.products_name");
	if (olc_db_num_rows($products)) {
		?>
		<tr class="dataTableHeadingRow">
		<td class="dataTableHeadingContent" align="center">&nbsp;<?php echo TABLE_HEADING_ID; ?>&nbsp;</td>
		<td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_PRODUCT; ?>&nbsp;</td>
		<td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_OPT_VALUE; ?>&nbsp;</td>
		</tr>
		<tr>
		<td colspan="3"><?php echo olc_black_line(); ?></td>
		</tr>
		<?php
		while ($products_values = olc_db_fetch_array($products)) {
			$rows++;
			?>
			<tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'attributes-even' : 'attributes-odd'); ?>">
			<td align="center" class="smallText">&nbsp;<?php echo $products_values['products_id']; ?>&nbsp;</td>
			<td class="smallText">&nbsp;<?php echo $products_values['products_name']; ?>&nbsp;</td>
			<td class="smallText">&nbsp;<?php echo $products_values['products_options_values_name']; ?>&nbsp;</td>
			</tr>
			<?php
		}
		?>
		<tr>
		<td colspan="3"><?php echo olc_black_line(); ?></td>
		</tr>
		<tr>
		<td colspan="3" class="main"><br/><?php echo TEXT_WARNING_OF_DELETE; ?></td>
		</tr>
		<tr>
		<td align="right" colspan="3" class="main"><br/><?php echo HTML_A_START . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, '&value_page=' . $_GET['value_page'] . '&attribute_page=' . $attribute_page, NONSSL) . '">'; ?><?php echo olc_image_button('button_cancel.gif', ' cancel '); ?></a>&nbsp;</td>
		</tr>
		<?php
	} else {
		?>
		<tr>
		<td class="main" colspan="3"><br/><?php echo TEXT_OK_TO_DELETE; ?></td>
		</tr>
		<tr>
		<td class="main" align="right" colspan="3"><br/><?php echo HTML_A_START . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=delete_option&option_id=' . $_GET['option_id'], NONSSL) . '">'; ?><?php echo olc_image_button('button_delete.gif', ' delete '); ?></a>&nbsp;&nbsp;&nbsp;<?php echo HTML_A_START . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, '&order_by=' . $order_by . '&page=' . $page, NONSSL) . '">'; ?><?php echo olc_image_button('button_cancel.gif', ' cancel '); ?></a>&nbsp;</td>
		</tr>
		<?php
	}
	?>
	</table></td>
	</tr>
	<?php
} else {
	if ($_GET['option_order_by']) {
		$option_order_by = $_GET['option_order_by'];
	} else {
		$option_order_by = 'products_options_id';
	}
	?>
	<tr>
	<td colspan="2" class="pageHeading">&nbsp;
	<?php
	define('AJAX_TITLE',HEADING_TITLE_OPT);
	echo AJAX_TITLE;
	?>
	&nbsp;</td>
	<td align="right"><br/>
	<?php
	olc_draw_form('option_order_by', FILENAME_PRODUCTS_ATTRIBUTES, EMPTY_STRING, 'post');	?>
	<select name="selected" onchange="go_option()"><option value="products_options_id"<?php if ($option_order_by == 'products_options_id')
	{ echo ' selected="selected"'; } ?>><?php echo TEXT_OPTION_ID; ?></option><option value="products_options_name"<?php if ($option_order_by == 'products_options_name') { echo ' SELECTED'; } ?>><?php echo TEXT_OPTION_NAME; ?></option></select></form></td>
	</tr>
	<tr>
	<td colspan="3" class="smallText">
	<?php
	$per_page = MAX_ROW_LISTS_OPTIONS;
	$options = "select * from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . SESSION_LANGUAGE_ID . "' order by " . $option_order_by;
	if (!$option_page) {
		$option_page = 1;
	}
	$prev_option_page = $option_page - 1;
	$next_option_page = $option_page + 1;

	$option_query = olc_db_query($options);

	$option_page_start = ($per_page * $option_page) - $per_page;
	$num_rows = olc_db_num_rows($option_query);

	if ($num_rows <= $per_page) {
		$num_pages = 1;
	} else if (($num_rows % $per_page) == 0) {
		$num_pages = ($num_rows / $per_page);
	} else {
		$num_pages = ($num_rows / $per_page) + 1;
	}
	$num_pages = (int) $num_pages;

	$options = $options . " LIMIT $option_page_start, $per_page";

	// Previous
	if ($prev_option_page)  {
		echo HTML_A_START . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'option_page=' . $prev_option_page) . '"> &lt;&lt; </a> | ';
	}

	for ($i = 1; $i <= $num_pages; $i++) {
		if ($i != $option_page) {
			echo HTML_A_START . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'option_page=' . $i) . '">' . $i . '</a> | ';
		} else {
			echo '<b><font color=red>' . $i . '</font></b> | ';
		}
	}

	// Next
	if ($option_page != $num_pages) {
		echo HTML_A_START . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'option_page=' . $next_option_page) . '"> &gt;&gt; </a>';
	}
	?>
	</td>
	</tr>
	<tr>
	<td colspan="3"><?php echo olc_black_line(); ?></td>
	</tr>
	<tr class="dataTableHeadingRow">
	<td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_ID; ?>&nbsp;</td>
	<td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_OPT_NAME; ?>&nbsp;</td>
	<td class="dataTableHeadingContent" align="center">&nbsp;<?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
	</tr>
	<tr>
	<td colspan="3"><?php echo olc_black_line(); ?></td>
	</tr>
	<?php
	$next_id = 1;
	$options = olc_db_query($options);
	while ($options_values = olc_db_fetch_array($options)) {
		$rows++;
		?>
		<tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'attributes-even' : 'attributes-odd'); ?>">
		<?php
		if (($action == 'update_option') && ($_GET['option_id'] == $options_values['products_options_id'])) {
			echo olc_draw_form('option', FILENAME_PRODUCTS_ATTRIBUTES, 'action=update_option_name', 'post');
			//'<form name="option" action="' . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=update_option_name', NONSSL) . '" method="post">';
			$inputs = '';
			for ($i = 0, $n = sizeof($languages); $i < $n; $i ++) {
				$option_name = olc_db_query("select products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . $options_values['products_options_id'] . "' and language_id = '" . $languages[$i]['id'] . APOS);
				$option_name = olc_db_fetch_array($option_name);
				$inputs .= $languages[$i]['code'] . ':&nbsp;<input type="text" name="option_name[' . $languages[$i]['id'] . ']" size="20" value="' . $option_name['products_options_name'] . '">&nbsp;<br/>';
			}
			?>
			<td align="center" class="smallText">&nbsp;<?php echo $options_values['products_options_id']; ?><input type="hidden" name="option_id" value="<?php echo $options_values['products_options_id']; ?>">&nbsp;</td>
			<td class="smallText"><?php echo $inputs; ?></td>
			<td align="center" class="smallText">&nbsp;<?php echo olc_image_submit('button_update.gif', IMAGE_UPDATE); ?>&nbsp;<?php echo HTML_A_START . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, '', NONSSL) . '">'; ?><?php echo olc_image_button('button_cancel.gif', IMAGE_CANCEL); ?></a>&nbsp;</td>
			<?php
			echo '</form>' . NEW_LINE;
		} else {
			?>
			<td align="center" class="smallText">&nbsp;<?php echo $options_values["products_options_id"]; ?>&nbsp;</td>
			<td class="smallText">&nbsp;<?php echo $options_values["products_options_name"]; ?>&nbsp;</td>
			<td align="center" class="smallText">&nbsp;<?php echo HTML_A_START . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=update_option&option_id=' . $options_values['products_options_id'] . '&option_order_by=' . $option_order_by . '&option_page=' . $option_page, NONSSL) . '">'; ?><?php echo olc_image_button('button_edit.gif', IMAGE_UPDATE); ?></a>&nbsp;&nbsp;<?php echo HTML_A_START . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=delete_product_option&option_id=' . $options_values['products_options_id'], NONSSL) , '">'; ?><?php echo olc_image_button('button_delete.gif', IMAGE_DELETE); ?></a>&nbsp;</td>
			<?php
		}
		?>
		</tr>
		<?php
		$max_options_id_query = olc_db_query("select max(products_options_id) + 1 as next_id from " . TABLE_PRODUCTS_OPTIONS);
		$max_options_id_values = olc_db_fetch_array($max_options_id_query);
		$next_id = $max_options_id_values['next_id'];
	}
	?>
	<tr>
	<td colspan="3"><?php echo olc_black_line(); ?></td>
	</tr>
	<?php
	if ($action != 'update_option') {
		?>
		<tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'attributes-even' : 'attributes-odd'); ?>">
		<?php
		echo olc_draw_form('option', FILENAME_PRODUCTS_ATTRIBUTES, 'action=update_option_name', 'post').
		//'<form name="option" action="' . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=update_option_name', NONSSL) . '" method="post">';
		'<input type="hidden" name="products_options_id" value="' . $next_id . '">';
		$inputs = '';
		for ($i = 0, $n = sizeof($languages); $i < $n; $i ++) {
			$inputs .= $languages[$i]['code'] . ':&nbsp;<input type="text" name="option_name[' . $languages[$i]['id'] . ']" size="20">&nbsp;<br/>';
		}
		?>
		<td align="center" class="smallText">&nbsp;<?php echo $next_id; ?>&nbsp;</td>
		<td class="smallText"><?php echo $inputs; ?></td>
		<td align="center" class="smallText">&nbsp;<?php echo olc_image_submit('button_insert.gif', IMAGE_INSERT); ?>&nbsp;</td>
		<?php
		echo '</form>';
		?>
		</tr>
		<tr>
		<td colspan="3"><?php echo olc_black_line(); ?></td>
		</tr>
		<?php
	}
}
?>
</table></td>
<!-- options eof //-->
</tr><tr></tr>
<td valign="top" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="2">
<!-- value //-->
<?php
if ($action == 'delete_option_value') { // delete product option value
	$values = olc_db_query("select products_options_values_id, products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . $_GET['value_id'] . "' and language_id = '" . SESSION_LANGUAGE_ID . APOS);
	$values_values = olc_db_fetch_array($values);
	?>
	<tr>
	<td colspan="3" class="pageHeading">&nbsp;
	<?php
	define('AJAX_TITLE',$values_values['products_options_values_name']);
	echo AJAX_TITLE;
	?>
	&nbsp;</td>
	<td>&nbsp;<?php echo olc_image(DIR_WS_IMAGES . 'pixel_trans.gif', '', '1', '53'); ?>&nbsp;</td>
	</tr>
	<tr>
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td colspan="3"><?php echo olc_black_line(); ?></td>
	</tr>
	<?php
	$products = olc_db_query("select p.products_id, pd.products_name, po.products_options_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS . " po, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id = p.products_id and pd.language_id = '" . SESSION_LANGUAGE_ID . "' and po.language_id = '" . SESSION_LANGUAGE_ID . "' and pa.products_id = p.products_id and pa.options_values_id='" . $_GET['value_id'] . "' and po.products_options_id = pa.options_id order by pd.products_name");
	if (olc_db_num_rows($products)) {
		?>
		<tr class="dataTableHeadingRow">
		<td class="dataTableHeadingContent" align="center">&nbsp;<?php echo TABLE_HEADING_ID; ?>&nbsp;</td>
		<td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_PRODUCT; ?>&nbsp;</td>
		<td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_OPT_NAME; ?>&nbsp;</td>
		</tr>
		<tr>
		<td colspan="3"><?php echo olc_black_line(); ?></td>
		</tr>
		<?php
		while ($products_values = olc_db_fetch_array($products)) {
			$rows++;
			?>
			<tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'attributes-even' : 'attributes-odd'); ?>">
			<td align="center" class="smallText">&nbsp;<?php echo $products_values['products_id']; ?>&nbsp;</td>
			<td class="smallText">&nbsp;<?php echo $products_values['products_name']; ?>&nbsp;</td>
			<td class="smallText">&nbsp;<?php echo $products_values['products_options_name']; ?>&nbsp;</td>
			</tr>
			<?php
		}
		?>
		<tr>
		<td colspan="3"><?php echo olc_black_line(); ?></td>
		</tr>
		<tr>
		<td class="main" colspan="3"><br/><?php echo TEXT_WARNING_OF_DELETE; ?></td>
		</tr>
		<tr>
		<td class="main" align="right" colspan="3"><br/><?php echo HTML_A_START . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, '&value_page=' . $_GET['value_page'] . '&attribute_page=' . $attribute_page, NONSSL) . '">'; ?><?php echo olc_image_button('button_cancel.gif', ' cancel '); ?></a>&nbsp;</td>
		</tr>
		<?php
	} else {
		?>
		<tr>
		<td class="main" colspan="3"><br/><?php echo TEXT_OK_TO_DELETE; ?></td>
		</tr>
		<tr>
		<td class="main" align="right" colspan="3"><br/><?php echo HTML_A_START . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=delete_value&value_id=' . $_GET['value_id'], NONSSL) . '">'; ?><?php echo olc_image_button('button_delete.gif', ' delete '); ?></a>&nbsp;&nbsp;&nbsp;<?php echo HTML_A_START . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, '&option_page=' . $option_page . '&value_page=' . $_GET['value_page'] . '&attribute_page=' . $attribute_page, NONSSL) . '">'; ?><?php echo olc_image_button('button_cancel.gif', ' cancel '); ?></a>&nbsp;</td>
		</tr>
		<?php
	}
	?>
	</table></td>
	</tr>
	<?php
} else {
	?>
	<tr>
	<td colspan="3" class="pageHeading">&nbsp;
	<?php
	define('AJAX_TITLE',HEADING_TITLE_VAL);
	echo AJAX_TITLE;
	?>
	&nbsp;</td>
	<td>&nbsp;<?php echo olc_image(DIR_WS_IMAGES . 'pixel_trans.gif', '', '1', '53'); ?>&nbsp;</td>
	</tr>
	<tr>
	<td colspan="4" class="smallText">
	<?php
	$per_page = MAX_ROW_LISTS_OPTIONS;
	$values = "select pov.products_options_values_id, pov.products_options_values_name, pov2po.products_options_id from " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov left join " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " pov2po on pov.products_options_values_id = pov2po.products_options_values_id where pov.language_id = '" . SESSION_LANGUAGE_ID . "' order by pov.products_options_values_id";
	if (!$_GET['value_page']) {
		$_GET['value_page'] = 1;
	}
	$prev_value_page = $_GET['value_page'] - 1;
	$next_value_page = $_GET['value_page'] + 1;

	$value_query = olc_db_query($values);

	$value_page_start = ($per_page * $_GET['value_page']) - $per_page;
	$num_rows = olc_db_num_rows($value_query);

	if ($num_rows <= $per_page) {
		$num_pages = 1;
	} else if (($num_rows % $per_page) == 0) {
		$num_pages = ($num_rows / $per_page);
	} else {
		$num_pages = ($num_rows / $per_page) + 1;
	}
	$num_pages = (int) $num_pages;

	$values = $values . " LIMIT $value_page_start, $per_page";

	// Previous
	if ($prev_value_page)  {
		echo HTML_A_START . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'option_order_by=' . $option_order_by . '&value_page=' . $prev_value_page) . '"> &lt;&lt; </a> | ';
	}

	for ($i = 1; $i <= $num_pages; $i++) {
		if ($i != $_GET['value_page']) {
			echo HTML_A_START . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'option_order_by=' . $option_order_by . '&value_page=' . $i) . '">' . $i . '</a> | ';
		} else {
			echo '<b><font color=red>' . $i . '</font></b> | ';
		}
	}

	// Next
	if ($_GET['value_page'] != $num_pages) {
		echo HTML_A_START . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'option_order_by=' . $option_order_by . '&value_page=' . $next_value_page) . '"> &gt;&gt;</a> ';
	}
	?>
	</td>
	</tr>
	<tr>
	<td colspan="4"><?php echo olc_black_line(); ?></td>
	</tr>
	<tr class="dataTableHeadingRow">
	<td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_ID; ?>&nbsp;</td>
	<td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_OPT_NAME; ?>&nbsp;</td>
	<td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_OPT_VALUE; ?>&nbsp;</td>
	<td class="dataTableHeadingContent" align="center">&nbsp;<?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
	</tr>
	<tr>
	<td colspan="4"><?php echo olc_black_line(); ?></td>
	</tr>
	<?php
	$next_id = 1;
	$values = olc_db_query($values);
	while ($values_values = olc_db_fetch_array($values)) {
		$options_name = olc_options_name($values_values['products_options_id']);
		$values_name = $values_values['products_options_values_name'];
		$rows++;
		?>
		<tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'attributes-even' : 'attributes-odd'); ?>">
		<?php
		if (($action == 'update_option_value') && ($_GET['value_id'] == $values_values['products_options_values_id'])) {
			echo olc_draw_form('values', FILENAME_PRODUCTS_ATTRIBUTES, 'action=update_value', 'post').
			//'<form name="values" action="' . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=update_value', NONSSL) . '" method="post">';
			$inputs = '';
			for ($i = 0, $n = sizeof($languages); $i < $n; $i ++) {
				$value_name = olc_db_query("select products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . $values_values['products_options_values_id'] . "' and language_id = '" . $languages[$i]['id'] . APOS);
				$value_name = olc_db_fetch_array($value_name);
				$inputs .= $languages[$i]['code'] . ':&nbsp;<input type="text" name="value_name[' . $languages[$i]['id'] . ']" size="15" value="' . $value_name['products_options_values_name'] . '">&nbsp;<br/>';
			}
			?>
			<td align="center" class="smallText">&nbsp;<?php echo $values_values['products_options_values_id']; ?><input type="hidden" name="value_id" value="<?php echo $values_values['products_options_values_id']; ?>">&nbsp;</td>
			<td align="center" class="smallText">&nbsp;<?php echo NEW_LINE; ?><select name="option_id">
			<?php
			$options = olc_db_query("select products_options_id, products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . SESSION_LANGUAGE_ID . "' order by products_options_name");
			while ($options_values = olc_db_fetch_array($options)) {
				echo NEW_LINE . '<option name="' . $options_values['products_options_name'] . '" value="' . $options_values['products_options_id'] . '"';
				if ($values_values['products_options_id'] == $options_values['products_options_id']) {
					echo ' selected';
				}
				echo '>' . $options_values['products_options_name'] . '</option>';
			}
			?>
			</select>&nbsp;</td>
			<td class="smallText"><?php echo $inputs; ?></td>
			<td align="center" class="smallText">&nbsp;<?php echo olc_image_submit('button_update.gif', IMAGE_UPDATE); ?>&nbsp;<?php echo HTML_A_START . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, '', NONSSL) . '">'; ?><?php echo olc_image_button('button_cancel.gif', IMAGE_CANCEL); ?></a>&nbsp;</td>
			<?php
			echo '</form>';
		} else {
			?>
			<td align="center" class="smallText">&nbsp;<?php echo $values_values["products_options_values_id"]; ?>&nbsp;</td>
			<td align="center" class="smallText">&nbsp;<?php echo $options_name; ?>&nbsp;</td>
			<td class="smallText">&nbsp;<?php echo $values_name; ?>&nbsp;</td>
			<td align="center" class="smallText">&nbsp;<?php echo HTML_A_START . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=update_option_value&value_id=' . $values_values['products_options_values_id'] . '&value_page=' . $_GET['value_page'], NONSSL) . '">'; ?><?php echo olc_image_button('button_edit.gif', IMAGE_UPDATE); ?></a>&nbsp;&nbsp;<?php echo HTML_A_START . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=delete_option_value&value_id=' . $values_values['products_options_values_id'], NONSSL) , '">'; ?><?php echo olc_image_button('button_delete.gif', IMAGE_DELETE); ?></a>&nbsp;</td>
			<?php
		}
		$max_values_id_query = olc_db_query("select max(products_options_values_id) + 1 as next_id from " . TABLE_PRODUCTS_OPTIONS_VALUES);
		$max_values_id_values = olc_db_fetch_array($max_values_id_query);
		$next_id = $max_values_id_values['next_id'];
	}
	?>
	</tr>
	<tr>
	<td colspan="4"><?php echo olc_black_line(); ?></td>
	</tr>
	<?php
	if ($action != 'update_option_value') {
		?>
		<tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'attributes-even' : 'attributes-odd'); ?>">
		<?php
		echo olc_draw_form('values', FILENAME_PRODUCTS_ATTRIBUTES, 'action=add_product_option_values&value_page=' . $_GET['value_page'], 'post')
		//'<form name="values" action="' . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=add_product_option_values&value_page=' . $_GET['value_page'], NONSSL) . '" method="post">';
		?>
		<td align="center" class="smallText">&nbsp;<?php echo $next_id; ?>&nbsp;</td>
		<td align="center" class="smallText">&nbsp;<select name="option_id">
		<?php
		$options = olc_db_query("select products_options_id, products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . SESSION_LANGUAGE_ID . "' order by products_options_name");
		while ($options_values = olc_db_fetch_array($options)) {
			echo '<option name="' . $options_values['products_options_name'] . '" value="' . $options_values['products_options_id'] . '">' . $options_values['products_options_name'] . '</option>';
		}

		$inputs = '';
		for ($i = 0, $n = sizeof($languages); $i < $n; $i ++) {
			$inputs .= $languages[$i]['code'] . ':&nbsp;<input type="text" name="value_name[' . $languages[$i]['id'] . ']" size="15">&nbsp;<br/>';
		}
		?>
		</select>&nbsp;</td>
		<td class="smallText"><input type="hidden" name="value_id" value="<?php echo $next_id; ?>"><?php echo $inputs; ?></td>
		<td align="center" class="smallText">&nbsp;<?php echo olc_image_submit('button_insert.gif', IMAGE_INSERT); ?>&nbsp;</td>
		<?php
		echo '</form>';
		?>
		</tr>
		<tr>
		<td colspan="4"><?php echo olc_black_line(); ?></td>
		</tr>
		<?php
	}
}
?>
</table></td>
</tr>
</table></td>
<!-- option value eof //-->
</tr>
</table></td>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
