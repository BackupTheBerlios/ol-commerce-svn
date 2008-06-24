<?php
/* --------------------------------------------------------------
   $Id: orders_edit.php,v 1.0

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

   OLC-Bestellbearbeitung:
   http://www.xtc-webservice.de / Matthias Hinsche
   info@xtc-webservice.de

   Copyright (c) 2003 OL-Commerce 2.0
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders.php,v 1.27 2003/02/16); www.oscommerce.com 
   (c) 2003	    nextcommerce (orders.php,v 1.7 2003/08/14); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 

   To do: Erweitern auf Artikelmerkmale, Rabatte und Gutscheine
   --------------------------------------------------------------*/
   require_once(DIR_FS_INC.'olc_get_tax_rate.inc.php');
   require_once(DIR_FS_INC.'olc_get_tax_class_id.inc.php');
   require_once(DIR_FS_INC.'olc_format_price.inc.php');

?>
<!-- Artikelbearbeitung Anfang //-->

<?php
  $products_query = olc_db_query("select * from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" . $_GET['oID'] . "' and orders_products_id = '" . $_GET['opID'] . APOS);
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">

<tr class="dataTableHeadingRow">
<td class="dataTableHeadingContent"><b><?php echo TEXT_PRODUCT_OPTION;?></b></td>
<td class="dataTableHeadingContent"><b><?php echo TEXT_PRODUCT_OPTION_VALUE;?></b></td>
<td class="dataTableHeadingContent"><b><?php echo TEXT_PRICE;?></b></td>
<td class="dataTableHeadingContent"><b><?php echo TEXT_PRICE_PREFIX;?></b></td>
<td class="dataTableHeadingContent">&nbsp;</td>
<td class="dataTableHeadingContent">&nbsp;</td>
<td class="dataTableHeadingContent">&nbsp;</td>
</tr>

<?php
while($products = olc_db_fetch_array($products_query)) {
?>
<tr class="dataTableRow">
<?php
echo olc_draw_form('product_option_edit', FILENAME_ORDERS_EDIT, 'action=product_option_edit', 'post');
echo olc_draw_hidden_field('cID', $_GET['cID']);
echo olc_draw_hidden_field('oID', $_GET['oID']);
echo olc_draw_hidden_field('pID', $_GET['pID']);
echo olc_draw_hidden_field('pTX', $_GET['pTX']);
echo olc_draw_hidden_field('aTX', $_GET['aTX']);
echo olc_draw_hidden_field('qTY', $_GET['qTY']);
echo olc_draw_hidden_field('opID', $_GET['opID']);
echo olc_draw_hidden_field('opAID', $products['orders_products_attributes_id']);

$brutto = PRICE_IS_BRUTTO;
if($brutto == TRUE_STRING_S){
$options_values_price = olc_round(($products['options_values_price']*(1+($_GET['pTX']/100))), PRICE_PRECISION);
}else{
$options_values_price = olc_round($products['options_values_price'], PRICE_PRECISION);
}

?>
<td class="dataTableContent"><?php echo olc_draw_input_field('products_options', $products['products_options'], 'size="20"');?></td>
<td class="dataTableContent"><?php echo olc_draw_input_field('products_options_values', $products['products_options_values'], 'size="20"');?></td>
<td class="dataTableContent"><?php echo olc_draw_input_field('options_values_price',$options_values_price, 'size="10"');?></td>
<td class="dataTableContent"><?php echo $products['price_prefix'];?></td>
<td class="dataTableContent">
<select name="prefix">
<option value="+">+
<option value="-">-
</SELECT>
</td>
<td class="dataTableContent">
<?php
echo olc_image_submit('button_save.gif', TEXT_EDIT,'style="cursor:hand" ');
?>
</form>
</td>

<td class="dataTableContent">
<?php
echo olc_draw_form('product_option_delete', FILENAME_ORDERS_EDIT, 'action=product_option_delete', 'post');
echo olc_draw_hidden_field('cID', $_GET['cID']);
echo olc_draw_hidden_field('oID', $_GET['oID']);
echo olc_draw_hidden_field('pID', $_GET['pID']);
echo olc_draw_hidden_field('pTX', $_GET['pTX']);
echo olc_draw_hidden_field('aTX', $_GET['aTX']);
echo olc_draw_hidden_field('qTY', $_GET['qTY']);
echo olc_draw_hidden_field('opID', $_GET['opID']);
echo olc_draw_hidden_field('opAID', $products['orders_products_attributes_id']);
echo olc_image_submit('button_delete.gif', TEXT_DELETE,'style="cursor:hand" ');
?>
</form>
</td>
</tr>
<?php
}
?>
</table>
<br/><br/>
<!-- Artikelbearbeitung Ende //-->



<!-- Artikel Einfügen Anfang //-->

<table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
     $products_query = olc_db_query("select
     products_attributes_id,
     products_id,
     options_id,
     options_values_id,
     options_values_price,
     price_prefix
     from
     " . TABLE_PRODUCTS_ATTRIBUTES . "
     where
     products_id = '" . $_GET['pID'] . "'
     order by
     sortorder");

?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">

<tr class="dataTableHeadingRow">
<td class="dataTableHeadingContent"><b><?php echo TEXT_PRODUCT_ID;?></b></td>
<td class="dataTableHeadingContent"><b><?php echo TEXT_QUANTITY;?></b></td>
<td class="dataTableHeadingContent"><b><?php echo TEXT_PRODUCT;?></b></td>
<td class="dataTableHeadingContent"><b><?php echo TEXT_PRICE;?></b></td>
<td class="dataTableHeadingContent">&nbsp;</td>
</tr>

<?php
while($products = olc_db_fetch_array($products_query)) {
?>
<tr class="dataTableRow">
<?php
echo olc_draw_form('product_option_ins', FILENAME_ORDERS_EDIT, 'action=product_option_ins', 'post');
echo olc_draw_hidden_field('cID', $_GET['cID']);
echo olc_draw_hidden_field('oID', $_GET['oID']);
echo olc_draw_hidden_field('pID', $_GET['pID']);
echo olc_draw_hidden_field('pTX', $_GET['pTX']);
echo olc_draw_hidden_field('aTX', $_GET['aTX']);
echo olc_draw_hidden_field('qTY', $_GET['qTY']);
echo olc_draw_hidden_field('opID', $_GET['opID']);
echo olc_draw_hidden_field('aID', $products['products_attributes_id']);

$brutto = PRICE_IS_BRUTTO;
if($brutto == TRUE_STRING_S){
$options_values_price = olc_round(($products['options_values_price']*(1+($_GET['pTX']/100))), PRICE_PRECISION);
}else{
$options_values_price = olc_round($products['options_values_price'], PRICE_PRECISION);
}

?>
<td class="dataTableContent"><?php echo $products['products_attributes_id'];?></td>
<td class="dataTableContent"><?php echo olc_oe_get_options_name($products['options_id']);?></td>
<td class="dataTableContent"><?php echo olc_oe_get_options_values_name($products['options_values_id']);?></td>
<td class="dataTableContent">
<?php echo olc_draw_hidden_field('options_values_price', $products['options_values_price']);?>
<?php echo $options_values_price;?>
</td>
<td class="dataTableContent">
<?php
echo olc_image_submit('button_insert.gif', TEXT_EDIT,'style="cursor:hand" ');
?>
</form>
</td>
</tr>
<?php
}
?>
</table>

<br/><br/>
<!-- Artikel Einfügen Ende //-->












