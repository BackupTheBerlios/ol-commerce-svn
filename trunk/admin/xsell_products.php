<?php
/* -----------------------------------------------------------------------------------------
$Id: xsell_products.php,v 1.1.1.1.2.1 2007/04/08 07:16:34 gswkaiser Exp $

OL-Commerce 2.0
http://www.ol-commerce.de, http://www.seifenparadies.de


Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com
(c) 2003	    nextcommerce (xsell_products.php,v 1.5 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

(c) 2003  xt:commerce; www.xt-commerce.com


Released under the GNU General Public License

-----------------------------------------------------------------------------------------
Third Party contribution:
Cross-Sell (X-Sell) Admin 1				Autor: Joshua Dechant (dreamscape)

and has little changed ( Filter categories & manufactures ) Medreces medreces@yandex.ru
-----------------------------------------------------------------------------------------
Also converted for XT-Commerce Witalij Olejnik(xaoc,xaoc2) xaoc@o2.pl
---------------------------------------------------------------------------------------*/

require('includes/application_top.php');

require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();

//Medreces insert Filter categories & manufactures !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$manufacturers_array = array(array('id' => '', 'text' => TEXT_NONE));
$manufacturers_query = olc_db_query("select manufacturers_id, manufacturers_name from " .
	TABLE_MANUFACTURERS . " order by manufacturers_name");
while ($manufacturers = olc_db_fetch_array($manufacturers_query)) {
	$manufacturers_array[] = array('id' => $manufacturers['manufacturers_id'],
	'text' => $manufacturers['manufacturers_name']);
}

$CATEGORIES_id = 0;
if ( isset($HTTP_POST_VARS['categories_id']) ) {
	$CATEGORIES_id = $HTTP_POST_VARS['categories_id'];
} elseif ( isset($HTTP_GET_VARS['categories_id']) ) $CATEGORIES_id = $HTTP_GET_VARS['categories_id'];

$MANUFACTURES_id = 0;
if ( isset($HTTP_POST_VARS['manufacturers_id']) ) {
	$MANUFACTURES_id = $HTTP_POST_VARS['manufacturers_id'];
} elseif ( isset($HTTP_GET_VARS['manufacturers_id']) ) $MANUFACTURES_id = $HTTP_GET_VARS['manufacturers_id'];


//Medreces insert Filter categories & manufactures !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

?>
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<script language="JavaScript1.2">

function cOn(td)
{
	if(document.getElementById||(document.all && !(document.getElementById)))
	{
		td.style.backgroundColor="#CCCCCC";
	}
}

function cOnA(td)
{
	if(document.getElementById||(document.all && !(document.getElementById)))
	{
		td.style.backgroundColor="#CCFFFF";
	}
}

function cOut(td)
{
	if(document.getElementById||(document.all && !(document.getElementById)))
	{
		td.style.backgroundColor="DFE4F4";
	}
}
</script>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
<tr>
  <td class="columnLeft2" nowrap="nowrap" valign="top"><table border="0" cellspacing="1" cellpadding="1" class="columnLeft" nowrap="nowrap">
      <!-- left_navigation //-->
      <?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
      <!-- left_navigation_eof //-->
    </table>
  </td>
  <!-- body_text //-->
  <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
            <tr>
              <td class="pageHeading">
								<?php
									define('AJAX_TITLE','Cross-Marketing (X-Sell) Admin');
									echo AJAX_TITLE;
								?>
              </td>
              <td class="pageHeading" align="right"><?php echo olc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
            </tr>
<?php //Medreces insert Filter categories & manufactures !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! ?>
            <tr class="dataTableHeadingRow"><?php echo olc_draw_form('filter_xsell_products', FILENAME_XSELL_PRODUCTS, ($first_entrance ? '' : olc_get_all_get_params())); ?>
                <td class="dataTableHeadingRow" align="left">Set Filters</td>
                <td class="smallText" align="right">
                  <?php echo 'to Categories:&nbsp' . olc_draw_pull_down_menu('categories_id', olc_get_category_tree(), $CATEGORIES_id);
                  echo '<br/>to Manufacturers:&nbsp' . olc_draw_pull_down_menu('manufacturers_id', $manufacturers_array, $MANUFACTURES_id);
       			  ?>
                </td>
				<td class="dataTableContent" align="right"><?php echo olc_image_submit('button_select.gif', 'GO!!!'); ?></td>
            </form></tr>
<?  // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! ?>
          </table>
        </td>
      </tr>
      <!-- body_text //-->
      <tr><td width="100%" valign="top">
          <!-- Start of cross sale //-->
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td align=center>
                <?php
                /* general_db_conct($query) Function */
                /* To call use: list ($test_a, $test_b) = general_db_conct($query); */
                function general_db_conct($query_1)
                {
                	$result_1 = olc_db_query($query_1);
                	$num_of_rows = olc_db_num_rows($result_1);
                	for ($i=0; $i < $num_of_rows; $i++) {
                		$fields = olc_db_fetch_row($result_1);
                		$a_to_pass[$i] = $fields[$y=0];
                		$b_to_pass[$i] = $fields[++$y];
                		$c_to_pass[$i] = $fields[++$y];
                		$d_to_pass[$i] = $fields[++$y];
                		$e_to_pass[$i] = $fields[++$y];
                		$f_to_pass[$i] = $fields[++$y];
                		$g_to_pass[$i] = $fields[++$y];
                		$h_to_pass[$i] = $fields[++$y];
                		$i_to_pass[$i] = $fields[++$y];
                		$j_to_pass[$i] = $fields[++$y];
                		$k_to_pass[$i] = $fields[++$y];
                		$l_to_pass[$i] = $fields[++$y];
                		$m_to_pass[$i] = $fields[++$y];
                		$n_to_pass[$i] = $fields[++$y];
                		$o_to_pass[$i] = $fields[++$y];
                	}

                	return array($a_to_pass,$b_to_pass,$c_to_pass,$d_to_pass,$e_to_pass,$f_to_pass,$g_to_pass,$h_to_pass,$i_to_pass,$j_to_pass,$k_to_pass,$l_to_pass,$m_to_pass,$n_to_pass,$o_to_pass);
                } // End of function general_db_conct()

                ////////////////////////////////////////////////////////////////////////////////////////////////
                // This bit does the first page. Lists all products and their X-sells

                if (!$add_related_product_ID && !$first_entrance)
                {

                	/* Multiple Language fix --- mail@michaelding.net <mailto:mail@michaelding.net> */
                	$query = "select distinct
                	b.language_id,a.products_id, b.products_name, b.products_description,a.products_quantity, a.products_model,
                	 a.products_image,b.products_url, a.products_price FROM " . TABLE_PRODUCTS . " a, " .
                	TABLE_PRODUCTS_DESCRIPTION . " b, " . TABLE_PRODUCTS_TO_CATEGORIES .
                	" p2c WHERE b.products_id = a.products_id AND b.products_id=p2c.products_id AND b.language_id ='" .
                	$languages_id . APOS .
                	($CATEGORIES_id ?  " AND p2c.categories_id ='" . $CATEGORIES_id . APOS : "") .
                	($MANUFACTURES_id ? " AND a.manufacturers_id ='" .
                	$MANUFACTURES_id . APOS : "" ) . " ORDER BY b.products_name;";
                	list ($LANGUAGE_id,$PRODUCTS_id, $PRODUCTS_name, $PRODUCTS_description , $PRODUCTS_quantity ,
                	$PRODUCTS_model , $PRODUCTS_image , $PRODUCTS_url , $PRODUCTS_price ) = general_db_conct($query);
?>
                <table border="0" cellspacing="1" cellpadding="2" bgcolor="#999999">
                  <tr class="dataTableHeadingRow">
                    <td class="dataTableHeadingContent" width="75">Product id</td>
                    <td class="dataTableHeadingContent">Quickfind code</td>
                    <td class="dataTableHeadingContent">Product Name</td>
                    <td class="dataTableHeadingContent" nowrap="nowrap">Current Cross-Sells</td>
                    <td class="dataTableHeadingContent" colspan=2 nowrap="nowrap" align=center>Update
                      cross-sells</td>
                  </tr>
<?php
$num_of_products = sizeof($PRODUCTS_id);
for ($i=0; $i < $num_of_products; $i++)
{
	/* now we will query the DB for existing related items */
	$query = "select b.products_name, a.xsell_id, c.products_model from " . TABLE_PRODUCTS_XSELL . " a," .
	TABLE_PRODUCTS_DESCRIPTION . " b," . TABLE_PRODUCTS ." c WHERE b.products_id = a.xsell_id and a.products_id ='" .
	$PRODUCTS_id[$i] . "' and b.products_id = c.products_id ORDER BY sort_order";
	list ($related_items, $xsell_ids, $product_models) = general_db_conct($query);
	echo "
	<tr onmouseover=\"cOn(this); this.style.cursor='pointer'; this.style.cursor='hand';\" onmouseout=\"cOut(this);\" onclick=\"javascript:" .
		olc_onclick_link(FILENAME_XSELL_PRODUCTS, 'add_related_product_ID=' . $PRODUCTS_id[$i] .
		'&categories_id=' . $CATEGORIES_id . '&manufacturers_id=' . $MANUFACTURES_id , NONSSL) . "\">";
	$td="<td class=\"dataTableContent\" valign=\"top\">&nbsp;";
	$td_end="&nbsp;</td>\n";
	echo $td.$PRODUCTS_id[$i].$td_end;
	echo $td.$PRODUCTS_model[$i].$td_end;
	echo $td.$PRODUCTS_name[$i].$td_end;
	if ($related_items)
	{
		echo "<td class=\"dataTableContent\"><ol>";
		for ($j = 0; $j < count($related_items); $j++) {
			echo '<li><strong>' . $product_models[$j] . '</strong> ' . $related_items[$j] .  '</li>';
		}
		echo"</ol></td>\n";
	}
	else
	echo "<td class=\"dataTableContent\">--</td>\n";
	echo '<td class="dataTableContent" valign="top">&nbsp;<a href="' . olc_href_link(FILENAME_XSELL_PRODUCTS, 'add_related_product_ID=' . $PRODUCTS_id[$i] . '&categories_id=' . $CATEGORIES_id . '&manufacturers_id=' . $MANUFACTURES_id , NONSSL) . '">Edit</a>&nbsp;</td>';

	if (count($related_items)>1)
	{
		echo '<td class="dataTableContent" valign="top">&nbsp;<a href="' . olc_href_link(FILENAME_XSELL_PRODUCTS, 'sort=1&add_related_product_ID=' . $PRODUCTS_id[$i] . '&categories_id=' . $CATEGORIES_id . '&manufacturers_id=' . $MANUFACTURES_id , NONSSL) . '">Prioritise</a>&nbsp;</td>';
	} else {
		echo "<td class=\"dataTableContent\" valign=top align=center>--</td>";
	}
	echo "</tr>\n";
	unset($related_items);
}
?>
                </table>
                <?
                } // the end of -> if (!$add_related_product_ID)

                //////////////////////////////////////////////////////////////////////////////////
                // This bit does the 'EDIT' page (previously Add/Remove)

                if ( ($_POST[run_update] || $_POST[xsell_id]) && $_POST[add_related_product_ID] && !$sort && !$first_entrance) {
                	if ($_POST[run_update]==true) {
                		$query =DELETE_FROM . TABLE_PRODUCTS_XSELL . " WHERE products_id = '".$_POST[add_related_product_ID].APOS;
                		if (!olc_db_query($query)) exit('could not delete');
                	}
                	if ($_POST[xsell_id])
                	foreach ($_POST[xsell_id] as $temp) {
                		$query = INSERT_INTO . TABLE_PRODUCTS_XSELL . " VALUES ('',$_POST[add_related_product_ID],$temp,1)";
                		if (!olc_db_query($query)) exit('could not insert to DB');
                	}
                	echo HTML_A_START . olc_href_link(FILENAME_XSELL_PRODUCTS, 'categories_id=' . $CATEGORIES_id .
                	'&manufacturers_id=' . $MANUFACTURES_id, NONSSL) . '">Click Here to add a new cross sale</a><br/>' . NEW_LINE;
                	if ($_POST[xsell_id])
                	echo HTML_A_START . olc_href_link(FILENAME_XSELL_PRODUCTS, 'sort=1&add_related_product_ID=' .
                	 $_POST[add_related_product_ID] . '&categories_id=' . $CATEGORIES_id . '&manufacturers_id=' .
                	 $MANUFACTURES_id, NONSSL) . '">Click here to sort (top to bottom) the added cross sale</a>' . NEW_LINE;
                }

                if ($add_related_product_ID && ! ($_POST[run_update] || $_POST[xsell_id] ) && !$sort && !$first_entrance)
{ ?>
                <table border="0" cellpadding="2" cellspacing="1" bgcolor="#999999">
								  <?php
									olc_draw_form('xsell_products', FILENAME_XSELL_PRODUCTS, EMPTY_STRING, 'post');
								   //<form action="<?php olc_href_link(FILENAME_XSELL_PRODUCTS, '', NONSSL); ?>" method="post">
									?>

                    <tr class="dataTableHeadingRow">
                      <?php
                      $query = "select b.language_id, a.products_id, b.products_name, b.products_description, " .
                      "a.products_quantity, a.products_model, a.products_image, " .
                      "b.products_url, a.products_price from " . TABLE_PRODUCTS . " a, " . TABLE_PRODUCTS_DESCRIPTION .
                      " b where b.products_id = a.products_id and b.language_id = '" . $languages_id .
                      "' and a.products_id = '".$add_related_product_ID.APOS;
                      list ($language_id, $PRODUCTS_id, $PRODUCTS_name, $PRODUCTS_description , $PRODUCTS_quantity ,
                       $PRODUCTS_model , $PRODUCTS_image , $PRODUCTS_url , $PRODUCTS_price ) = general_db_conct($query);
											define('AJAX_TITLE','Cross-Marketing Produkte für: ' . $PRODUCTS_model[0] . ' (Produkt id: ' . $PRODUCTS_id[0] . RPAREN);
                      echo '<span class="pageHeading">'.AJAX_TITLE. '<br/><br/>' . ($PRODUCTS_image[0] ? olc_image(DIR_WS_CATALOG_THUMBNAIL_IMAGES .
                      $PRODUCTS_image[0], $PRODUCTS_name[0]) : "") . '</span><br/><br/>';
?>

                      <td class="dataTableHeadingContent">Product id</td>
                      <td class="dataTableHeadingContent">Quickfind code</td>
                      <td class="dataTableHeadingContent">Cross-sell this?</td>
                      <td class="dataTableHeadingContent">Item Name</td>
                      <td class="dataTableHeadingContent">Price</td>
                    </tr>
                    <?php

                    $run_update = false; // Set False to insert new entry in the DB
                    $query = "select * from " . TABLE_PRODUCTS_XSELL . " WHERE products_id = '" . $add_related_product_ID . APOS;
                    list ($ID_PR, $PRODUCTS_id_PR, $xsell_id_PR) = general_db_conct($query);

                    if ($xsell_id_PR) {
                    	$run_update = true;
                    	$num_of_products = sizeof($xsell_id_PR);
?>
                    <tr bgcolor='#FFFFFF'><td colspan=6>Products are already in Cross-Sell (X-Sell). Please remove if need...</td></tr>
<?php
for ($i=0; $i < $num_of_products; $i++) {
	$query = 'select b.language_id, a.products_id, b.products_name, b.products_description, a.products_quantity, a.products_model,
	a.products_image, b.products_url, a.products_price FROM ' . TABLE_PRODUCTS . ' a, ' . TABLE_PRODUCTS_DESCRIPTION .
	' b where b.products_id=a.products_id and b.language_id="' . $languages_id . '" and b.products_id="' . $xsell_id_PR[$i] .
	'" ORDER BY b.products_name';
	list ($language_id, $PRODUCTS_id, $PRODUCTS_name, $PRODUCTS_description , $PRODUCTS_quantity , $PRODUCTS_model ,
	$PRODUCTS_image , $PRODUCTS_url , $PRODUCTS_price ) = general_db_conct($query);
?>
                    <tr bgcolor='#DFE4F4'>
					  <td class="dataTableContent" align=center><?php echo $PRODUCTS_id[0]; ?></td>
					  <td class="dataTableContent" align=center>&nbsp;<?php echo $PRODUCTS_model[0]; ?>&nbsp;</td>

                      <td class="dataTableContent" align="center" valign="middle">
                        <label onmouseover="this.style.cursor='pointer'; this.style.cursor='hand'">
                        <input onmouseover="this.style.cursor='pointer'; this.style.cursor='hand'" checked="checked" size="20" name="xsell_id[]" type="checkbox" value="<?php echo $PRODUCTS_id[0]; ?>">Cross-sell</label>
                      </td>
					  <td class="dataTableContent"><?php echo $PRODUCTS_name[0]; ?></td>
					  <td class="dataTableContent"><?php echo $currencies->display_price($PRODUCTS_price[0], olc_get_tax_rate($product_info_values['products_tax_class_id'])); ?></td>
                    </tr>
<?php
}
                    }
                    $query = 'select distinct b.language_id, a.products_id, b.products_name, b.products_description,
                     a.products_quantity, a.products_model, a.products_image, b.products_url, a.products_price FROM ' .
                    TABLE_PRODUCTS . ' a, ' . TABLE_PRODUCTS_DESCRIPTION .
										' b, products_to_categories p2c WHERE b.products_id=a.products_id and b.language_id = "' .
										 $languages_id . '" AND a.products_id=p2c.products_id ' .
										 ($CATEGORIES_id ?  ' and p2c.categories_id="' . $CATEGORIES_id . '" ' : '') .
										 ($MANUFACTURES_id ? ' and a.manufacturers_id="' . $MANUFACTURES_id . '" ' : '' ) .
										 ' and a.products_id != "' . $add_related_product_ID . '" ORDER BY b.products_name';
                    list ($language_id, $PRODUCTS_id, $PRODUCTS_name, $PRODUCTS_description , $PRODUCTS_quantity ,
                    $PRODUCTS_model , $PRODUCTS_image , $PRODUCTS_url , $PRODUCTS_price ) = general_db_conct($query);

                    if($PRODUCTS_id) {
?>
                    <tr bgcolor='#FFFFFF'><td colspan=6>List of products for adding in Cross-Sell (X-Sell). Please check it...</td></tr>
<?php
$num_of_products = sizeof($PRODUCTS_id);
for ($i=0; $i < $num_of_products; $i++) {
	if ($xsell_id_PR) /* See if item is in the DB. Not Display - Medreces */
	foreach ($xsell_id_PR as $compare_checked){
		if ($PRODUCTS_id[$i] === $compare_checked) continue 2;
	}
?>
                    <tr bgcolor='#DFE4F4'>
					  <td class="dataTableContent" align=center><?php echo $PRODUCTS_id[$i]; ?></td>
					  <td class="dataTableContent" align=center>&nbsp;<?php echo $PRODUCTS_model[$i]; ?>&nbsp;</td>

                      <td class="dataTableContent" align="center" valign="middle">
                        <label onmouseover="this.style.cursor='pointer'; this.style.cursor='hand'">
                        <input onmouseover="this.style.cursor='pointer'; this.style.cursor='hand'" size="20" name="xsell_id[]" type="checkbox" value="<?php echo $PRODUCTS_id[$i]; ?>">Cross-sell</label>
                      </td>
					  <td class="dataTableContent"><?php echo $PRODUCTS_name[$i]; ?></td>
					  <td class="dataTableContent"><?php echo $currencies->display_price($PRODUCTS_price[$i], olc_get_tax_rate($product_info_values['products_tax_class_id'])); ?></td>
                    </tr>
<?}?>
                    <tr>
                      <td colspan="4">
                        <input type="hidden" name="run_update" value="<?php if ($run_update==true) echo "true"; else echo "false" ?>">

                        <input type="hidden" name="categories_id" value="<?php echo $CATEGORIES_id;?>">
                        <input type="hidden" name="manufacturers_id" value="<?php echo $MANUFACTURES_id;?>">

                        <input type="hidden" name="add_related_product_ID" value="<?php echo $add_related_product_ID; ?>">
                        <input type="submit" name="Submit" value="Submit">
                      </td>
                    </tr>
                  </form>
                </table>
<?}
}
// sort routines
if ($sort==1 && !$first_entrance)
{
	// first lets take care of the DB update.
	$run_once=0;
	if ($_POST)
	foreach ($_POST as $key_a => $value_a)
	{
		olc_db_connect();
		$query = SQL_UPDATE . TABLE_PRODUCTS_XSELL . " SET sort_order = '" . $value_a . "' WHERE xsell_id= '$key_a' ";
		if ($value_a != 'Update')
		if (!olc_db_query($query))
		exit('Could not SQL_UPDATE DB');
		else if ($run_once==0)
		{
			echo '<b class=\'main\'>Cross-sells updated <a href="' . olc_href_link(FILENAME_XSELL_PRODUCTS, '', NONSSL) . '">Back to cross-sell admin</a></b><br/>' . NEW_LINE;
			$run_once++;
		}

	}// end of foreach.

	//////////////////////////////////////////////////////////////////////////////////
	// This bit does the 'PRIORITISE' page (previously Sort)

	$query = "select b.language_id, a.products_id, b.products_name, b.products_description, " .
	"a.products_quantity, a.products_model, a.products_image, " .
	"b.products_url, a.products_price from " . TABLE_PRODUCTS . " a, " . TABLE_PRODUCTS_DESCRIPTION .
	" b where b.products_id = a.products_id and b.language_id = '" . $languages_id . "' and a.products_id = '" . $add_related_product_ID . APOS;

	list ($language_id, $PRODUCTS_id, $PRODUCTS_name, $PRODUCTS_description , $PRODUCTS_quantity , $PRODUCTS_model ,
	$PRODUCTS_image , $PRODUCTS_url , $PRODUCTS_price ) = general_db_conct($query);

?>

								  <?php
									olc_draw_form('xsell_products', FILENAME_XSELL_PRODUCTS, 'sort=1&add_related_product_ID=' . $add_related_product_ID, 'post');
								   //<form method="post" action="<?php olc_href_link(FILENAME_XSELL_PRODUCTS, 'sort=1&add_related_product_ID=' . $add_related_product_ID, NONSSL); ?>">
									?>
											<?php
											define('AJAX_TITLE','Cross-Marketing Produkte für: ' . $PRODUCTS_model[0] . ' (Produkt id: ' . $PRODUCTS_id[0] . RPAREN);
                      echo '<span class="pageHeading">'.AJAX_TITLE. '<br/><br/>' . ($PRODUCTS_image[0] ? olc_image(DIR_WS_CATALOG_THUMBNAIL_IMAGES .
                      $PRODUCTS_image[0], $PRODUCTS_name[0]) : "") . '</span><br/><br/>';
?>

                  <table cellpadding="2" cellspacing="1" bgcolor=999999 border="0">
                    <tr class="dataTableHeadingRow">
                      <td class="dataTableHeadingContent" width="75">Product
                        id</td>
                      <td class="dataTableHeadingContent" width="75">Quickfind
                        code</td>

                      <td class="dataTableHeadingContent">Name</td>
                      <td class="dataTableHeadingContent" width="150">Price</td>
                      <td class="dataTableHeadingContent" width="150">Order (1=Top)</td>
                    </tr>
                    <?
                    $query = "select * from " . TABLE_PRODUCTS_XSELL . " WHERE products_id = '" . $add_related_product_ID . APOS;
                    list ($ID_PR, $PRODUCTS_id_PR, $xsell_id_PR, $order_PR) = general_db_conct($query);
                    $ordering_size = sizeof($ID_PR);

                    for ($i=0; $i<$ordering_size; $i++)
                    {
                    	$query = "select b.language_id, a.products_id, b.products_name, b.products_description, " .
                    	"a.products_quantity, a.products_model, a.products_image, " .
                    	"b.products_url, a.products_price from " . TABLE_PRODUCTS . " a, " . TABLE_PRODUCTS_DESCRIPTION .
											" b where b.products_id = a.products_id and b.language_id = '" . $languages_id .
											"' and a.products_id = " . $xsell_id_PR[$i] . "";

                    	list ($language_id, $PRODUCTS_id, $PRODUCTS_name, $PRODUCTS_description , $PRODUCTS_quantity , $PRODUCTS_model , $PRODUCTS_image , $PRODUCTS_url , $PRODUCTS_price ) = general_db_conct($query);

?>
                    <tr class="dataTableContentRow" bgcolor='#DFE4F4'>
                      <td class="dataTableContent"><?php echo $PRODUCTS_id[0]; ?></td>
                      <!--// Adam@CP: Added Model Number and image thumbnail. -->
                      <td class="dataTableContent"><?php echo $PRODUCTS_model[0] ?></td>

                      <td class="dataTableContent"><?php echo $PRODUCTS_name[0]; ?></td>
                      <td class="dataTableContent"><?php echo $currencies->display_price($PRODUCTS_price[0], olc_get_tax_rate($product_info_values['products_tax_class_id'])); ?></td>
                      <td class="dataTableContent"><select name="<?php echo $PRODUCTS_id[0]; ?>">
                          <? for ($y=1;$y<=$ordering_size;$y++)
                          {
                          	echo "<option value=\"$y\"";
                          	if (!(strcmp($y, "$order_PR[$i]"))) {echo "SELECTED";}
                          	echo ">$y</option>";
                          }
?>
                        </select>
                      </td>
                    </tr>
                    <? } // the end of foreach ?>
                    <tr>
                      <td colspan="6" bgcolor='#DFE4F4'><input name="runing_update" type="submit" id="runing_update" value="Update">
                      </td>
                    </tr>
                  </table>
                </form>
                <?php }?>
              </td>
            </tr>
          </table>
          <!-- End of cross sale //-->
        </td>
        <!-- products_attributes_eof //-->
<? include(DIR_WS_INCLUDES . 'application_bottom.php');?>