<?php
/* --------------------------------------------------------------
$Id: group_prices.php,v 1.1.1.1.2.1 2007/04/08 07:16:46 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(based on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35); www.oscommerce.com
(c) 2003	    nextcommerce (group_prices.php,v 1.16 2003/08/21); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------
based on Third Party contribution:
Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/
require_once(DIR_FS_INC.'olc_get_tax_rate.inc.php');
require_once(DIR_FS_INC.'olc_format_price.inc.php');
$i = 0;
$group_query = olc_db_query("
SELECT
customers_status_image,
customers_status_id,
customers_status_name
FROM".
TABLE_CUSTOMERS_STATUS . "
WHERE
language_id = " . SESSION_LANGUAGE_ID . " AND
customers_status_id != '0'");
while ($group_values = olc_db_fetch_array($group_query)) {
	// load data into array
	$i++;
	$group_data[$i] = array(
	'STATUS_NAME' => $group_values['customers_status_name'],
	'STATUS_IMAGE' => $group_values['customers_status_image'],
	'STATUS_ID' => $group_values['customers_status_id']);
}
echo HTML_BR.'<span class="pageHeading">'.HEADING_PRICES_OPTIONS.'</span>';
?>
<table width="100%" border="0" class="table_bordered" style="border: 1px solid;">
          <tr>
            <td width="15%" class="main"><?php echo TEXT_PRODUCTS_PRICE; ?></td>
<?php
// calculate brutto price for display
$tax_rate=((100+olc_get_tax_rate($pInfo->products_tax_class_id))/100);
$is_brutto=PRICE_IS_BRUTTO==TRUE_STRING_S;
$products_price0=olc_round($pInfo->products_price,PRICE_PRECISION);
$products_price=$products_price0;
if ($is_brutto)
{
	$products_price = $products_price*$tax_rate;
}
//$products_price = olc_round($products_price,PRICE_PRECISION);
?>
            <td width="85%" class="main">
<?php
            	echo olc_draw_input_field('products_price',str_replace(COMMA,DOT,$products_price));
if ($is_brutto){
	echo BLANK.TEXT_NETTO .HTML_B_START.olc_format_price($products_price0,'1','0','1').'</b>  ';
}
?>
						</td>
          </tr>
<?php
// W. Kaiser - AJAX
if (USE_AJAX_ATTRIBUTES_MANAGER)
{
?>
<!-- osc@kangaroopartners.com - AJAX Attribute Manager  -->
<tr>
	<td colspan="2"><?php require_once(AJAX_ATTRIBUTES_MANAGER_LEADIN.'placeholder.inc.php' )?></td>
</tr>
<!-- osc@kangaroopartners.com - AJAX Attribute Manager  end -->
<?php
}
// W. Kaiser - AJAX
?>

<?php
for ($col = 0, $n = sizeof($group_data); $col < $n+1; $col++) {
	if ($group_data[$col]['STATUS_NAME'] != EMPTY_STRING) {
?>
          <tr>
            <td style="border-top: 1px solid;" valign="top" class="main"><?php echo $group_data[$col]['STATUS_NAME']; ?></td>
<?php
$products_id=$pInfo->products_id;
$group_status=$group_data[$col]['STATUS_ID'];
$group_price0=get_group_price($group_status, $products_id);
$group_price=$group_price0;
if ($is_brutto){
	$group_price = $group_price*$tax_rate;
}
$group_price = olc_round($group_price,PRICE_PRECISION);
?>
            <td style="border-top: 1px solid;" class="main">
<?php
            	echo olc_draw_input_field('products_price_' . $group_status, $group_price);

            if ($is_brutto)
            {
	            if ($group_price!='0')
	            {
	            	echo BLANK.TEXT_NETTO . HTML_B_START.olc_format_price($group_price0,1,1).'</b>  ';
	            }
            }
            if ($_GET['pID'] != EMPTY_STRING) {
            	echo BLANK . TXT_STAFFELPREIS; ?>
            	<img onmouseover="this.style.cursor='hand'" src="images/arrow_down.gif" height="12" width="12"
            	onclick="javascript:toggleBox('staffel_<?php echo $group_status; ?>');"><?php
            }
            ?>
            <div id="staffel_<?php echo $group_status; ?>" class="longDescription"><br/><?php
            // ok, lets check if there is already a staffelpreis
            $staffel_query = olc_db_query("
            	SELECT
                 products_id,
                 quantity,
                 personal_offer
             FROM
                 ".TABLE_PERSONAL_OFFERS_BY_CUSTOMERS_STATUS . $group_status . "
             WHERE
                 products_id = '" . $products_id . "' AND quantity != 1
             ORDER BY
             		quantity ASC");
            echo '<table width="247" border="0" cellpadding="0" cellspacing="0">';
            while ($staffel_values = olc_db_fetch_array($staffel_query)) {
            	// load data into array
?>
              <tr>
                <td width="20" class="main" style="border: 1px solid;"><?php echo $staffel_values['quantity']; ?></td>
                <td width="5">&nbsp;</td>
                <td nowrap="nowrap" width="142" class="main" style="border: 1px solid;">
<?php
$personal_offer0=$staffel_values['personal_offer'];
$personal_offer=$personal_offer0;
if ($is_brutto)
{
	/*
	$tax_query = olc_db_query("select tax_rate from " . TABLE_TAX_RATES . " where tax_class_id = '" .
		$pInfo->products_tax_class_id . "' ");
	$tax = olc_db_fetch_array($tax_query);
	*/
	$personal_offer = $personal_offer*$tax_rate;
}
$products_price = olc_round($personal_offer,PRICE_PRECISION);
echo $products_price;
if ($is_brutto)
{
	echo ' <br/>'.TEXT_NETTO .HTML_B_START. olc_format_price((olc_round($personal_offer0,PRICE_PRECISION)),1,1).'</b>  ';
}
 ?>
 </td>
                <td width="80" align="left"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?>
                	<a href="<?php echo olc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&function=delete&quantity=' .
                	$staffel_values['quantity'] . '&statusID=' . $products_id . '&action=new_product&pID=' . $_GET['pID']); ?>">
                	<?php echo olc_image_button('button_delete.gif', IMAGE_DELETE); ?></a>
                </td>
              </tr>
              <tr>
                <td colspan="3" height="5"></td>
              </tr>
<?php
            }

            echo '</table>';
            echo TXT_STK;
            echo olc_draw_small_input_field('products_quantity_staffel_'.$products_id, 0);
            echo TXT_PRICE;
            echo olc_draw_input_field('products_price_staffel_'.$products_id, 0);
            echo olc_draw_separator('pixel_trans.gif', '10', '10');
            echo olc_image_submit('button_insert.gif', IMAGE_INSERT);
?><br/></td>
          </tr>
<?php
	}
}
?></div>
          <tr>
            <td style="border-top: 1px solid;" class="main"><?php echo TEXT_PRODUCTS_DISCOUNT_ALLOWED; ?></td>
            <td style="border-top: 1px solid;" class="main"><?php echo olc_draw_input_field('products_discount_allowed', $pInfo->products_discount_allowed); ?>%</td>
          </tr>
          <tr>
            <td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_TAX_CLASS; ?></td>
            <td class="main"><?php echo olc_draw_pull_down_menu('products_tax_class_id', $tax_class_array, $pInfo->products_tax_class_id); ?></td>
          </tr>
        </table>