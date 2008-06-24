<?php
/* --------------------------------------------------------------
$Id: new_attributes_select.php,v 1.1.1.1.2.1 2007/04/08 07:16:30 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(new_attributes_select.php); www.oscommerce.com
(c) 2003	    nextcommerce (new_attributes_select.php,v 1.9 2003/08/21); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------
Third Party contributions:
New Attribute Manager v4b				Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
copy attributes                          Autor: Hubi | http://www.netz-designer.de
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

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
$query = SELECT_ALL . TABLE_PRODUCTS_DESCRIPTION . " where language_id = '" . SESSION_LANGUAGE_ID .
"' ORDER BY products_name ASC";
$result = olc_db_query($query);
$matches = olc_db_num_rows($result);

if ($matches)
{
	echo olc_draw_form('SELECT_PRODUCT', CURRENT_SCRIPT, EMPTY_STRING, 'post');
	echo '<input type="hidden" name="action" value="edit">';
	echo "<tr>";
	echo "<td class=\"main\"><br/><b>". TEXT_SELECT_PRODUCT ."<br/></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=\"main\"><select NAME=\"current_product_id\">";
	
	while ($line = olc_db_fetch_array($result, olc_db_ASSOC)) {
		$title = $line['products_name'];
		$current_product_id = $line['products_id'];
		echo "<option VALUE=\"" . $current_product_id . "\">" . $title;
	}
	echo "</SELECT>";
	echo "</td></tr>";
	// start change for Attribute Copy
	$copy_query = olc_db_query("SELECT DISTINCT pd.products_name, pd.products_id FROM " .
	TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_ATTRIBUTES .
	" pa where pa.products_id = pd.products_id AND pd.products_id LIKE '%' AND pd.language_id = '" .
	SESSION_LANGUAGE_ID . "' ORDER BY pd.products_name ASC");
	if (olc_db_num_rows($copy_query))
	{
		echo "<tr>";
		echo "<td class=\"main\"><br/><b>".TEXT_SELECT_PRODUCT_COPY."<br/></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class=\"main\"><select name=\"copy_product_id\">";
		echo '<option value="0">'.TEXT_SELECT_PRODUCT_COPY_NO_COPY.'</option>';
		while ($copy_res = olc_db_fetch_array($copy_query, olc_db_ASSOC)) {
			echo '<option value="' . $copy_res['products_id'] . '">' . $copy_res['products_name'] . '</option>';
		}
		echo '</select></td></tr>';
		echo "<tr>";
		echo "	<td class=\"main\">".HTML_BR.olc_draw_checkbox_field('no_edit',TRUE_STRING_S,false).
		HTML_NBSP.TEXT_ATTRIBUTES_DIRECT_STORE."</td>";
		echo "</tr>";
		// end change for Attribute Copy
	}
	echo "<tr>";
	echo "	<td class=\"main\"><br/>".olc_image_submit('button_edit.gif',EMPTY_STRING)."</td>";
	echo "</tr>";
}
else
{
	echo TEXT_ATTRIBUTES_NO_PRODUCTS;
}
?>
</form>
