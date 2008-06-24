<?php
/* --------------------------------------------------------------
$Id: new_attributes_include.php,v 1.1.1.1.2.1 2007/04/08 07:16:30 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(new_attributes_functions); www.oscommerce.com
(c) 2003	    nextcommerce (new_attributes_include.php,v 1.11 2003/08/21); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------
Third Party contributions:
New Attribute Manager v4b				Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

// include needed functions

require_once(DIR_FS_INC.'olc_get_tax_rate.inc.php');
require_once(DIR_FS_INC.'olc_get_tax_class_id.inc.php');
require_once(DIR_FS_INC.'olc_format_price.inc.php');
?>
  <tr>
    <td class="pageHeading" colspan="3">
		<?php
		define('AJAX_TITLE',$pageTitle);
		echo AJAX_TITLE;
		?>
    </td>
  </tr>
  <?php
  echo olc_draw_form('SUBMIT_ATTRIBUTES', CURRENT_SCRIPT, EMPTY_STRING, 'post');
	?>
	<input type="hidden" name="current_product_id" value="<?php echo $_POST['current_product_id']; ?>">
	<input type="hidden" name="action" value="change">
<?php
if ($cPath) echo '<input type="hidden" name="cPathID" value="' . $cPath . '">';

require('new_attributes_functions.php');

// Temp id for text input contribution.. I'll put them in a seperate array.
$tempTextID = '1999043';

// Lets get all of the possible options
$query = "SELECT * FROM " . TABLE_PRODUCTS_OPTIONS . "  where products_options_id LIKE '%' AND language_id = '" . SESSION_LANGUAGE_ID . APOS;
$result = olc_db_query($query);
$matches = olc_db_num_rows($result);

if ($matches) {
	while ($line = olc_db_fetch_array($result, olc_db_ASSOC)) {
		$current_product_option_name = $line['products_options_name'];
		$current_product_option_id = $line['products_options_id'];
		// Print the Option Name
		echo "<tr class=\"dataTableHeadingRow\">";
		echo "<td class=\"dataTableHeadingContent\"><b>" . $current_product_option_name . "</b></td>";
		echo "<td class=\"dataTableHeadingContent\"><b>".TEXT_ATTRIBUTES_SORT_ORDER."</b></td>";
		echo "<td class=\"dataTableHeadingContent\"><b>".TEXT_ATTRIBUTES_ATTRIBUTE_MODEL."</b></td>";
		echo "<td class=\"dataTableHeadingContent\"><b>".TEXT_ATTRIBUTES_STOCK."</b></td>";
		echo "<td class=\"dataTableHeadingContent\"><b>".TEXT_ATTRIBUTES_WEIGTH."</b></td>";
		echo "<td class=\"dataTableHeadingContent\"><b>".TEXT_ATTRIBUTES_WEIGTH_PREFIX."</b></td>";
		echo "<td class=\"dataTableHeadingContent\"><b>".TEXT_ATTRIBUTES_PRICE."</b></td>";
		echo "<td class=\"dataTableHeadingContent\"><b>".TEXT_ATTRIBUTES_PRICE_PREFIX."</b></td>";

		if ($optionTypeInstalled == '1') {
			echo "<td class=\"dataTableHeadingContent\"><b>".TEXT_ATTRIBUTES_OPTION_TYPE."</b></td>";
			echo "<td class=\"dataTableHeadingContent\"><b>".TEXT_ATTRIBUTES_QUANTITY."</b></td>";
			echo "<td class=\"dataTableHeadingContent\"><b>".TEXT_ATTRIBUTES_ORDER."</b></td>";
			echo "<td class=\"dataTableHeadingContent\"><b>".TEXT_ATTRIBUTES_LINKED_ATTR."</b></td>";
			echo "<td class=\"dataTableHeadingContent\"><b>".TEXT_ATTRIBUTES_ID."</b></td>";
		}

		if ($optionSortCopyInstalled == '1') {
			echo "<td class=\"dataTableHeadingContent\"><b>".TEXT_ATTRIBUTES_WEIGTH."</b></td>";
			echo "<td class=\"dataTableHeadingContent\"><b>".TEXT_ATTRIBUTES_WEIGTH_PREFIX."</b></td>";
			echo "<td class=\"dataTableHeadingContent\"><b>".TEXT_ATTRIBUTES_SORT_ORDER."</b></td>";
		}
		echo "</tr>";

		// Find all of the Current Option's Available Values
		$query2 = "SELECT * FROM " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS .
		" WHERE products_options_id = '" . $current_product_option_id . "' ORDER BY products_options_values_id DESC";
		$result2 = olc_db_query($query2);
		$matches2 = olc_db_num_rows($result2);

		if ($matches2) {
			$i = '0';
			while ($line = olc_db_fetch_array($result2, olc_db_ASSOC)) {
				$i++;
				$rowClass = rowClass($i);
				$current_value_id = $line['products_options_values_id'];
				$isSelected = checkAttribute($current_value_id, $_POST['current_product_id'], $current_product_option_id);
				if ($isSelected) {
					$CHECKED = ' CHECKED';
				} else {
					$CHECKED = '';
				}

				$query3 = "SELECT * FROM " . TABLE_PRODUCTS_OPTIONS_VALUES . " WHERE products_options_values_id = '" .
				$current_value_id . "' AND language_id = '" . SESSION_LANGUAGE_ID . APOS;
				$result3 = olc_db_query($query3);
				while($line = olc_db_fetch_array($result3, olc_db_ASSOC)) {
					$current_value_name = $line['products_options_values_name'];
					// Print the Current Value Name
					echo "<tr class=\"" . $rowClass . "\">";
					echo "<td class=\"main\">";
					// Add Support for multiple text input option types (for Chandra's contribution).. and using ' to begin/end strings.. less of a mess.
					if ($optionTypeTextInstalled == '1' && $current_value_id == $optionTypeTextInstalledID) {
						$current_value_id_old = $current_value_id;
						$current_value_id = $tempTextID;
						echo '<input type="checkbox" name="optionValuesText[]" value="' . $current_value_id . '"' . $CHECKED . '>&nbsp;&nbsp;' . $current_value_name . '&nbsp;&nbsp;';
						echo '<input type="hidden" name="' . $current_value_id . '_options_id" value="' . $current_product_option_id . '">';
					} else {
						echo "<input type=\"checkbox\" name=\"optionValues[]\" value=\"" . $current_value_id . "\"" . $CHECKED . ">&nbsp;&nbsp;" . $current_value_name . "&nbsp;&nbsp;";
					}
					echo "</td>";
					echo "<td class=\"main\" align=\"left\"><input type=\"text\" name=\"" . $current_value_id . "_sortorder\" value=\"" . $sortorder . "\" size=\"4\"></td>";
					echo "<td class=\"main\" align=\"left\"><input type=\"text\" name=\"" . $current_value_id . "_model\" value=\"" . $attribute_value_model . "\" size=\"15\"></td>";
					echo "<td class=\"main\" align=\"left\"><input type=\"text\" name=\"" . $current_value_id . "_stock\" value=\"" . $attribute_value_stock . "\" size=\"4\"></td>";
					echo "<td class=\"main\" align=\"left\"><input type=\"text\" name=\"" . $current_value_id . "_weight\" value=\"" . $attribute_value_weight . "\" size=\"10\"></td>";
					echo "<td class=\"main\" align=\"left\"><select name=\"" . $current_value_id . "_weight_prefix\"><option value=\"+\"" . $posCheck_weight . ">+<option value=\"-\"" . $negCheck_weight . ">-</SELECT></td>";

					// brutto Admin
					if (PRICE_IS_BRUTTO==TRUE_STRING_S){
						$attribute_value_price_calculate = olc_format_price(olc_round($attribute_value_price*((100+(olc_get_tax_rate(olc_get_tax_class_id($_POST['current_product_id']))))/100),PRICE_PRECISION),false,false);
					} else {
						$attribute_value_price_calculate = olc_round($attribute_value_price,PRICE_PRECISION);
					}
					echo "<td class=\"main\" align=\"left\"><input type=\"text\" name=\"" . $current_value_id . "_price\" value=\"" . $attribute_value_price_calculate . "\" size=\"10\">";
					// brutto Admin
					if (PRICE_IS_BRUTTO==TRUE_STRING_S){
						echo TEXT_NETTO .HTML_B_START.olc_format_price(olc_round($attribute_value_price,PRICE_PRECISION),true,false).'</b>  ';
					}

					echo "</td>";

					if ($optionTypeInstalled == '1') {
						extraValues($current_value_id, $_POST['current_product_id']);
						echo "<td class=\"main\" align=\"left\"><input type=\"text\" name=\"" . $current_value_id . "_prefix\" value=\"" . $attribute_prefix . "\" size=\"4\"></td>";
						echo "<td class=\"main\" align=\"left\"><select name=\"" . $current_value_id . "_type\">";
						displayOptionTypes($attribute_type);
						echo "</SELECT></td>";
						echo "<td class=\"main\" align=\"left\"><input type=\"text\" name=\"" . $current_value_id . "_qty\" value=\"" . $attribute_qty . "\" size=\"4\"></td>";
						echo "<td class=\"main\" align=\"left\"><input type=\"text\" name=\"" . $current_value_id . "_order\" value=\"" . $attribute_order . "\" size=\"4\"></td>";
						echo "<td class=\"main\" align=\"left\"><input type=\"text\" name=\"" . $current_value_id . "_linked\" value=\"" . $attribute_linked . "\" size=\"4\"></td>";
						echo "<td class=\"main\" align=\"left\">" . $current_value_id . "</td>";
					} else {
						echo "<td class=\"main\" align=\"left\"><select name=\"" . $current_value_id . "_prefix\"> <option value=\"+\"" . $posCheck . ">+<option value=\"-\"" . $negCheck . ">-</SELECT></td>";
						if ($optionSortCopyInstalled == '1') {
							getSortCopyValues($current_value_id, $_POST['current_product_id']);
							echo "<td class=\"main\" align=\"left\"><input type=\"text\" name=\"" . $current_value_id . "_weight\" value=\"" . $attribute_weight . "\" size=\"10\"></td>";
							echo "<td class=\"main\" align=\"left\"><select name=\"" . $current_value_id . "_weight_prefix\">";
							sortCopyWeightPrefix($attribute_weight_prefix);
							echo "</SELECT></td>";
							echo "<td class=\"main\" align=\"left\"><input type=\"text\" name=\"" . $current_value_id . "_sort\" value=\"" . $attribute_sort . "\" size=\"4\"></td>";
						}
					}

					echo "</tr>";

					if ($optionTypeTextInstalled == '1' && $current_value_id_old == $optionTypeTextInstalledID) {
						$tempTextID++;
					}
				}
				if ($i == $matches2 ) $i = '0';
			}
		} else {
			echo "<tr>";
			echo "<td class=\"main\"><SMALL>No values under this option.</SMALL></td>";
			echo "</tr>";
		}
	}
}
?>
  <tr>
    <td colspan="10" class="main"><br/>
<?php
echo olc_image_submit('button_save.gif','');
echo $backLink.olc_image_button('button_cancel.gif','').HTML_A_END;
?>
</td>
  </tr>
</form>