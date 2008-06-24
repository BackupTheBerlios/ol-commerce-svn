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
?>


<!-- Adressbearbeitung Anfang //-->
<?php if ($_GET['edit_action']=='address'){?>
<br/>
<?php
  $address_query = olc_db_query("select * from " . TABLE_ORDERS . " where orders_id = '". $_GET['oID'] ."' ");
  $address = olc_db_fetch_array($address_query);

echo olc_draw_form('adress_edit', FILENAME_ORDERS_EDIT, 'action=address_edit', 'post');
 echo olc_draw_hidden_field('oID', $_GET['oID']);
 echo olc_draw_hidden_field('cID', $address['customers_id']);
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
<tr class="dataTableHeadingRow">
<td class="dataTableHeadingContent" width="33%" align="left"><?php echo TEXT_INVOICE_ADDRESS;?></td>
<td class="dataTableHeadingContent" width="33%" align="left"><?php echo TEXT_SHIPPING_ADDRESS;?></td>
<td class="dataTableHeadingContent" width="33%" align="left"><?php echo TEXT_BILLING_ADDRESS;?></td>
</tr>

<tr class="dataTableRow">
<td class="dataTableContent" align="left">
<?php echo olc_draw_input_field('customers_company', $address[customers_company]);?>
</td>
<td class="dataTableContent" align="left">
<?php echo olc_draw_input_field('delivery_company', $address[delivery_company]);?>
</td>
<td class="dataTableContent" align="left">
<?php echo olc_draw_input_field('billing_company', $address[billing_company]);?>
</td>
</tr>

<tr class="dataTableRow">
<td class="dataTableContent" align="left">
<?php echo olc_draw_input_field('customers_name', $address[customers_name]);?>
</td>
<td class="dataTableContent" align="left">
<?php echo olc_draw_input_field('delivery_name', $address[delivery_name]);?>
</td>
<td class="dataTableContent" align="left">
<?php echo olc_draw_input_field('billing_name', $address[billing_name]);?>
</td>
</tr>

<tr class="dataTableRow">
<td class="dataTableContent" align="left">
<?php echo olc_draw_input_field('customers_street_address', $address[customers_street_address]);?>
</td>
<td class="dataTableContent" align="left">
<?php echo olc_draw_input_field('delivery_street_address', $address[delivery_street_address]);?>
</td>
<td class="dataTableContent" align="left">
<?php echo olc_draw_input_field('billing_street_address', $address[billing_street_address]);?>
</td>
</tr>

<tr class="dataTableRow">
<td class="dataTableContent" align="left">
<?php echo olc_draw_input_field('customers_postcode', $address[customers_postcode]);?>
</td>
<td class="dataTableContent" align="left">
<?php echo olc_draw_input_field('delivery_postcode', $address[delivery_postcode]);?>
</td>
<td class="dataTableContent" align="left">
<?php echo olc_draw_input_field('billing_postcode', $address[billing_postcode]);?>
</td>
</tr>

<tr class="dataTableRow">
<td class="dataTableContent" align="left">
<?php echo olc_draw_input_field('customers_city', $address[customers_city]);?>
</td>
<td class="dataTableContent" align="left">
<?php echo olc_draw_input_field('delivery_city', $address[delivery_city]);?>
</td>
<td class="dataTableContent" align="left">
<?php echo olc_draw_input_field('billing_city', $address[billing_city]);?>
</td>
</tr>

<tr class="dataTableRow">
<td class="dataTableContent" align="left">
<?php echo olc_draw_input_field('customers_country', $address[customers_country]);?>
</td>
<td class="dataTableContent" align="left">
<?php echo olc_draw_input_field('delivery_country', $address[delivery_country]);?>
</td>
<td class="dataTableContent" align="left">
<?php echo olc_draw_input_field('billing_country', $address[billing_country]);?>
</td>
</tr>

<tr class="dataTableRow">
<td class="dataTableContent" align="left" colspan="3">
<?php echo olc_image_submit('button_update.gif', TEXT_UPDATE,'style="cursor:hand" ');?>
</td>
</tr>

<tr>
<td class="dataTableHeadingContent" width="33%" align="left">&nbsp;</td>
<td class="dataTableHeadingContent" width="33%" align="left">&nbsp;</td>
<td class="dataTableHeadingContent" width="33%" align="left">&nbsp;</td>
</tr>
</table>
</form>
<br/><br/>
<?php } ?>
<!-- Adressbearbeitung Ende //-->

















