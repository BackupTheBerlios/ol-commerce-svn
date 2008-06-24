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

   To do: Rabatte berücksichtigen
   --------------------------------------------------------------*/

  require('includes/application_top.php');
  require_once(DIR_FS_INC.'olc_oe_products_price.inc.php');
  require_once(DIR_FS_INC.'olc_oe_get_allow_tax.inc.php');
  require_once(DIR_FS_INC.'olc_oe_get_customers_status.inc.php');
  require_once(DIR_FS_INC.'olc_oe_get_price_o_tax.inc.php');
  require_once(DIR_FS_INC.'olc_oe_get_price_i_tax.inc.php');
  require_once(DIR_FS_INC.'olc_oe_get_tax_rate.inc.php');
  require_once(DIR_FS_INC.'olc_oe_get_options_name.inc.php');
  require_once(DIR_FS_INC.'olc_oe_get_options_values_name.inc.php');
  require_once(DIR_FS_INC.'olc_oe_get_products_attribute_price.inc.php');

  require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

// Adressbearbeitung Anfang
if ($_GET['action'] == "address_edit") {
          $sql_data_array = array('customers_id' => olc_db_prepare_input($_POST['customers_id']),
                                  'customers_company' => olc_db_prepare_input($_POST['customers_company']),
                                  'customers_name' => olc_db_prepare_input($_POST['customers_name']),
                                  'customers_street_address' => olc_db_prepare_input($_POST['customers_street_address']),
                                  'customers_city' => olc_db_prepare_input($_POST['customers_city']),
                                  'customers_postcode' => olc_db_prepare_input($_POST['customers_postcode']),
                                  'customers_country' => olc_db_prepare_input($_POST['customers_country']),
                                  'delivery_company' => olc_db_prepare_input($_POST['delivery_company']),
                                  'delivery_name' => olc_db_prepare_input($_POST['delivery_name']),
                                  'delivery_street_address' => olc_db_prepare_input($_POST['delivery_street_address']),
                                  'delivery_city' => olc_db_prepare_input($_POST['delivery_city']),
                                  'delivery_postcode' => olc_db_prepare_input($_POST['delivery_postcode']),
                                  'delivery_country' => olc_db_prepare_input($_POST['delivery_country']),
                                  'billing_company' => olc_db_prepare_input($_POST['billing_company']),
                                  'billing_name' => olc_db_prepare_input($_POST['billing_name']),
                                  'billing_street_address' => olc_db_prepare_input($_POST['billing_street_address']),
                                  'billing_city' => olc_db_prepare_input($_POST['billing_city']),
                                  'billing_postcode' => olc_db_prepare_input($_POST['billing_postcode']),
                                  'billing_country' => olc_db_prepare_input($_POST['billing_country']));

            $update_sql_data = array('last_modified' => 'now()');
            $sql_data_array = olc_array_merge($sql_data_array, $update_sql_data);
            olc_db_perform(TABLE_ORDERS, $sql_data_array, 'update', 'orders_id = \'' . olc_db_input($_POST['oID']) . '\'');

             olc_redirect(olc_href_link(FILENAME_ORDERS_EDIT, 'text=address&cID='.$_POST['cID'].'&oID=' . $_POST['oID']));
}
// Adressbearbeitung Ende

// Artikel bearbeiten Anfang

if ($_GET['action'] == "product_edit") {

$allow_tax = olc_oe_get_allow_tax($_POST['cID']);
$customers_status = olc_oe_get_customers_status($_POST['cID']);

if ($_POST['products_price'] !=''){

if ($allow_tax == '1'){
$inp_price = $_POST['products_price'];
$final_price = ($_POST['products_price']*$_POST['products_quantity']);
}else{
$inp_price = olc_oe_get_price_o_tax($_POST['products_price'], $_POST['products_tax'], 0);
$final_price = ($inp_price*$_POST['products_quantity']);
}

}else{
$final_price = olc_oe_products_price($_POST['products_id'],$price_special='0',$_POST['products_quantity'],$customers_status);
$inp_price = ($final_price/$_POST['products_quantity']);
}

          $sql_data_array = array('orders_id' => olc_db_prepare_input($_POST['oID']),
                                  'products_id' => olc_db_prepare_input($_POST['products_id']),
                                  'products_name' => olc_db_prepare_input($_POST['products_name']),
                                  'products_price' => olc_db_prepare_input($inp_price),
                                  'products_discount_made' => '',
                                  'final_price' => olc_db_prepare_input($final_price),
                                  'products_tax' => olc_db_prepare_input($_POST['products_tax']),
                                  'products_quantity' => olc_db_prepare_input($_POST['products_quantity']),
                                  'allow_tax' => olc_db_prepare_input($allow_tax));

            $update_sql_data = array('products_model' => olc_db_prepare_input($_POST['products_model']));
            $sql_data_array = olc_array_merge($sql_data_array, $update_sql_data);
            olc_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array, 'update', 'orders_products_id = \'' . olc_db_input($_POST['opID']) . '\'');

             olc_redirect(olc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=products&cID='.$_POST['cID'].'&oID=' . $_POST['oID']));
}
// Artikel bearbeiten Ende

// Artikel einfügen Anfang

if ($_GET['action'] == "product_ins") {

  $product_query = olc_db_query("select p.products_model, p.products_tax_class_id, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . $_POST['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '2'");
  $product = olc_db_fetch_array($product_query);

  $tax = olc_oe_get_tax_rate($product['products_tax_class_id']);
  $customers_status = olc_oe_get_customers_status($_POST['cID']);

  $final_price = olc_oe_products_price($_POST['products_id'],$price_special='0', $_POST['products_quantity'], $customers_status);
  $inp_price = ($final_price/$_POST['products_quantity']);

  $allow_tax = olc_oe_get_allow_tax($_POST['cID']);

          $sql_data_array = array('orders_id' => olc_db_prepare_input($_POST['oID']),
                                  'products_id' => olc_db_prepare_input($_POST['products_id']),
                                  'products_name' => olc_db_prepare_input($product['products_name']),
                                  'products_price' => olc_db_prepare_input($inp_price),
                                  'products_discount_made' => '',
                                  'final_price' => olc_db_prepare_input($final_price),
                                  'products_tax' => olc_db_prepare_input($tax),
                                  'products_quantity' => olc_db_prepare_input($_POST['products_quantity']),
                                  'allow_tax' => olc_db_prepare_input($allow_tax));

            $insert_sql_data = array('products_model' => olc_db_prepare_input($_POST['products_model']));
            $sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
            olc_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);

             olc_redirect(olc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=products&cID='.$_POST['cID'].'&oID=' . $_POST['oID']));
}
// Artikel einfügen Ende

// Versandkosten bearbeiten Anfang

if ($_GET['action'] == "shipping_edit") {
$customers_status = olc_oe_get_customers_status($_POST['cID']);
$allow_tax = olc_oe_get_allow_tax($_POST['cID']);

if ($allow_tax == '1'){
$inp_price = $_POST['value'];
}else{
$inp_price = olc_oe_get_price_o_tax($_POST['value'], $_POST['tax'], 0);
}

$text = $currencies->format(olc_round($inp_price,PRICE_PRECISION));

          $sql_data_array = array('orders_id' => olc_db_prepare_input($_POST['oID']),
                                  'title' => olc_db_prepare_input($_POST['title']),
                                  'value' => olc_db_prepare_input($inp_price));

            $update_sql_data = array('text' => $text);
            $sql_data_array = olc_array_merge($sql_data_array, $update_sql_data);
            olc_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array, 'update', 'orders_total_id = \'' . olc_db_input($_POST['otID']) . '\'');

             olc_redirect(olc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=shipping&cID='.$_POST['cID'].'&oID=' . $_POST['oID']));
}
// Versandkosten bearbeiten Ende

// Versandkosten Einfügen Anfang
if ($_GET['action'] == "shipping_ins") {
$customers_status = olc_oe_get_customers_status($_POST['cID']);
$allow_tax = olc_oe_get_allow_tax($_POST['cID']);

if ($allow_tax == '1'){
$inp_price = $_POST['value'];
}else{
$inp_price = olc_oe_get_price_o_tax($_POST['value'], $_POST['tax'], 0);
}

$text = $currencies->format(olc_round($inp_price,PRICE_PRECISION));
$sort = MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER;


          $sql_data_array = array('orders_id' => olc_db_prepare_input($_POST['oID']),
                                  'title' => olc_db_prepare_input($_POST['title']),
                                  'text' => olc_db_prepare_input($text),
                                  'value' => olc_db_prepare_input($inp_price),
                                  'class' => 'ot_shipping');

            $insert_sql_data = array('sort_order' => $sort);
            $sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
            olc_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

             olc_redirect(olc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=shipping&cID='.$_POST['cID'].'&oID=' . $_POST['oID']));
}
// Versandkosten Einfügen Ende

// Nachnahmegebühr bearbeiten Anfang
if ($_GET['action'] == "cod_edit") {

$customers_status = olc_oe_get_customers_status($_POST['cID']);
$allow_tax = olc_oe_get_allow_tax($_POST['cID']);

if ($allow_tax == '1'){
$inp_price = $_POST['value'];
}else{
$inp_price = olc_oe_get_price_o_tax($_POST['value'], $_POST['tax'], 0);
}

$text = $currencies->format(olc_round($inp_price,PRICE_PRECISION));

          $sql_data_array = array('orders_id' => olc_db_prepare_input($_POST['oID']),
                                  'title' => olc_db_prepare_input($_POST['title']),
                                  'value' => olc_db_prepare_input($inp_price));

            $update_sql_data = array('text' => $text);
            $sql_data_array = olc_array_merge($sql_data_array, $update_sql_data);
            olc_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array, 'update', 'orders_total_id = \'' . olc_db_input($_POST['otID']) . '\'');

             olc_redirect(olc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=shipping&cID='.$_POST['cID'].'&oID=' . $_POST['oID']));
}
// Nachnahmegebühr bearbeiten Ende

// Nachnahmegebühr Einfügen Anfang
if ($_GET['action'] == "cod_ins") {
$customers_status = olc_oe_get_customers_status($_POST['cID']);
$allow_tax = olc_oe_get_allow_tax($_POST['cID']);

if ($allow_tax == '1'){
$inp_price = $_POST['value'];
}else{
$inp_price = olc_oe_get_price_o_tax($_POST['value'], $_POST['tax'], 0);
}

$text = $currencies->format(olc_round($inp_price,PRICE_PRECISION));
$sort = MODULE_ORDER_TOTAL_COD_SORT_ORDER;


          $sql_data_array = array('orders_id' => olc_db_prepare_input($_POST['oID']),
                                  'title' => olc_db_prepare_input($_POST['title']),
                                  'text' => olc_db_prepare_input($text),
                                  'value' => olc_db_prepare_input($inp_price),
                                  'class' => 'ot_cod_fee');

            $insert_sql_data = array('sort_order' => $sort);
            $sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
            olc_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

             olc_redirect(olc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=shipping&cID='.$_POST['cID'].'&oID=' . $_POST['oID']));
}
// Nachnahmegebühr Einfügen Ende

// Produkt Optionen bearbeiten Anfang

if ($_GET['action'] == "product_option_edit") {

$allow_tax = $_POST['aTX'];
$customers_status = olc_oe_get_customers_status($_POST['cID']);

$brutto = PRICE_IS_BRUTTO;
if($brutto == TRUE_STRING_S){
$a_price = olc_round(($_POST['options_values_price']/(1+($_POST['pTX']/100))), PRICE_PRECISION);
}else{
$a_price = $a1_price;
}

          $sql_data_array = array('products_options' => olc_db_prepare_input($_POST['products_options']),
                                  'products_options_values' => olc_db_prepare_input($_POST['products_options_values']),
                                  'options_values_price' => olc_db_prepare_input($a_price));

            $update_sql_data = array('price_prefix' => olc_db_prepare_input($_POST['prefix']));
            $sql_data_array = olc_array_merge($sql_data_array, $update_sql_data);
            olc_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array, 'update', 'orders_products_attributes_id = \'' . olc_db_input($_POST['opAID']) . '\'');

     		$products_query = olc_db_query("select
            products_id,
            products_price,
            products_tax_class_id
            from
            " . TABLE_PRODUCTS . "
            where
            products_id = '" . $_POST['pID'] . APOS);

			$products = olc_db_fetch_array($products_query);

            $products_a_query = olc_db_query("select
            options_values_price,
            price_prefix
            from
            " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . "
            where
            orders_id = '" . $_POST['oID'] . "' and
            orders_products_id = '" . $_POST['opID'] . APOS);

            while($products_a = olc_db_fetch_array($products_a_query)){
            $total_price += $products_a['price_prefix'].$products_a['options_values_price'];
            };

$sa_price = olc_oe_get_products_attribute_price($total_price,$products['products_tax_class_id'],$price_special='0',1,$_POST['prefix'],$calculate_currencies=TRUE_STRING_S,$customers_status);
$sp_price = olc_oe_products_price($_POST['pID'],$price_special='0',1,$customers_status);

$inp_price = ($sa_price + $sp_price);
$final_price = ($inp_price*$_POST['qTY']);


          $sql_data_array = array('products_price' => olc_db_prepare_input($inp_price));
          $update_sql_data = array('final_price' => olc_db_prepare_input($final_price));
          $sql_data_array = olc_array_merge($sql_data_array, $update_sql_data);
          olc_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array, 'update', 'orders_products_id = \'' . olc_db_input($_POST['opID']) . '\'');

          olc_redirect(olc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=options&oID='.$_POST['oID'].'&cID='.$_POST['cID'].'&pID='.$_POST['pID'].'&pTX='.$_POST['pTX'].'&aTX='.$_POST['aTX'].'&qTY='.$_POST['qTY'].'&opID='.$_POST['opID']));
}

// Produkt Optionen bearbeiten Ende


// Produkt Optionen Einfügen Anfang

if ($_GET['action'] == "product_option_ins") {

$allow_tax = $_POST['aTX'];
$customers_status = olc_oe_get_customers_status($_POST['cID']);

            $products_attributes_query = olc_db_query("select
            products_attributes_id,
            products_id,
            options_id,
            options_values_id,
            options_values_price,
            price_prefix,
            attributes_model,
            attributes_stock,
            options_values_weight,
            weight_prefix,
            sortorder
            from
            " . TABLE_PRODUCTS_ATTRIBUTES . "
            where
            products_attributes_id = '" . $_POST['aID'] . APOS);

            $products_attributes = olc_db_fetch_array($products_attributes_query);

            $products_options = olc_oe_get_options_name($products_attributes['options_id']);
            $products_options_values = olc_oe_get_options_values_name($products_attributes['options_values_id']);

            $sql_data_array = array('orders_id' => olc_db_prepare_input($_POST['oID']),
                                    'orders_products_id' => olc_db_prepare_input($_POST['opID']),
                                    'products_options' => olc_db_prepare_input($products_options),
                                    'products_options_values' => olc_db_prepare_input($products_options_values),
                                    'options_values_price' => olc_db_prepare_input($products_attributes['options_values_price']));

            $insert_sql_data = array('price_prefix' => olc_db_prepare_input($products_attributes['price_prefix']));
            $sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
            olc_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);


$products_query = olc_db_query("select products_id, products_price, products_tax_class_id from " . TABLE_PRODUCTS . " where products_id = '" . $_POST['pID'] . APOS);
$products = olc_db_fetch_array($products_query);

$products_a_query = olc_db_query("select options_values_price, price_prefix from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" . $_POST['oID'] . "' and orders_products_id = '" . $_POST['opID'] . APOS);
while($products_a = olc_db_fetch_array($products_a_query)){
$total_price += $products_a['price_prefix'].$products_a['options_values_price'];
};

$sa_price = olc_oe_get_products_attribute_price($total_price,$products['products_tax_class_id'],$price_special='0',1,$_POST['prefix'],$calculate_currencies=TRUE_STRING_S,$customers_status);
$sp_price = olc_oe_products_price($_POST['pID'],$price_special='0',1,$customers_status);

$inp_price = ($sa_price + $sp_price);
$final_price = ($inp_price*$_POST['qTY']);


          $sql_data_array = array('products_price' => olc_db_prepare_input($inp_price));
          $update_sql_data = array('final_price' => olc_db_prepare_input($final_price));
          $sql_data_array = olc_array_merge($sql_data_array, $update_sql_data);
          olc_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array, 'update', 'orders_products_id = \'' . olc_db_input($_POST['opID']) . '\'');

          olc_redirect(olc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=options&oID='.$_POST['oID'].'&cID='.$_POST['cID'].'&pID='.$_POST['pID'].'&pTX='.$_POST['pTX'].'&aTX='.$_POST['aTX'].'&qTY='.$_POST['qTY'].'&opID='.$_POST['opID']));
}

// Produkt Optionen Einfügen Ende



// Berechnung der Bestellung Anfang
if ($_GET['action'] == "save_order") {
// Werte für alle Berechnungen
$customers_status = olc_oe_get_customers_status($_POST['cID']);
$allow_tax = olc_oe_get_allow_tax($_POST['cID']);

// Errechne neue Zwischensumme für die Bestellung Anfang
  $products_query = olc_db_query("select SUM(final_price) as subtotal_final from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $_POST['orders_id'] . "' ");
  $products = olc_db_fetch_array($products_query);
  $subtotal_final = $products['subtotal_final'];
  $subtotal_text = $currencies->format(olc_round($subtotal_final,PRICE_PRECISION));
  olc_db_query(SQL_UPDATE . TABLE_ORDERS_TOTAL . " set text = '" . $subtotal_text . "', value = '" . $subtotal_final . "' where orders_id = '" . $_POST['orders_id'] . "' and class = 'ot_subtotal' ");
// Errechne neue Zwischensumme für die Bestellung Ende


// Errechne neue Netto Zwischensumme für die Bestellung Anfang
if ($allow_tax == '0'){
  $subtotal_no_tax_value_query = olc_db_query("select SUM(value) as subtotal_no_tax_value from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $_POST['orders_id'] . "' and class != 'ot_tax' and class != 'ot_total' and class != 'ot_subtotal_no_tax' and class != 'ot_coupon' and class != 'ot_gv'");
  $subtotal_no_tax_value = olc_db_fetch_array($subtotal_no_tax_value_query);
  $subtotal_no_tax_final = $subtotal_no_tax_value['subtotal_no_tax_value'];
  $subtotal_no_tax_text = $currencies->format(olc_round($subtotal_no_tax_final,PRICE_PRECISION));
  olc_db_query(SQL_UPDATE . TABLE_ORDERS_TOTAL . " set text = '" . $subtotal_no_tax_text . "', value = '" . $subtotal_no_tax_final . "' where orders_id = '" . $_POST['orders_id'] . "' and class = 'ot_subtotal_no_tax' ");
}
// Errechne neue Netto Zwischensumme für die Bestellung Ende


// Errechne neue MWSt. für die Bestellung Anfang
  // Produkte
  $products_query = olc_db_query("select final_price, products_tax from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $_POST['orders_id'] . "' ");
  while($products = olc_db_fetch_array($products_query)){

if ($allow_tax == '1'){
$tax_rate = $products['products_tax'];
$nprice = olc_oe_get_price_o_tax($products['final_price'], $products['products_tax'], 0);
$bprice = $products['final_price'];
$tax = ($bprice - $nprice);
}else{
$tax_rate = $products['products_tax'];
$nprice = $products['final_price'];
$bprice = olc_oe_get_price_i_tax($products['final_price'], $products['products_tax'], 0);
$tax = ($bprice - $nprice);
}
          $sql_data_array = array('orders_id' => olc_db_prepare_input($_POST['orders_id']),
                                  'n_price' => olc_db_prepare_input($nprice),
                                  'b_price' => olc_db_prepare_input($bprice),
                                  'tax' => olc_db_prepare_input($tax),
                                  'tax_rate' => olc_db_prepare_input($tax_rate));


            $insert_sql_data = array('class' => 'products');
            $sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
            olc_db_perform(TABLE_ORDERS_RECALCULATE, $sql_data_array);
  }
  // Produkte Ende


  // Shipping

$tax_check = INVOICE_TAX_STATUS;
$tax_value = INVOICE_TAX_VALUE;

  $shipping_query = olc_db_query("select value from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $_POST['orders_id'] . "' and class='ot_shipping' ");
  $shipping = olc_db_fetch_array($shipping_query);

if ($allow_tax == '1'){

if ($tax_check ==TRUE_STRING_S){
$tax_rate = $tax_value;
$nprice = olc_oe_get_price_o_tax($shipping['value'], $tax_value, 0);
$bprice = $shipping['value'];
$tax = ($bprice - $nprice);
}else{
$tax_rate = '0';
$nprice = $shipping['value'];
$bprice = $shipping['value'];
$tax = '0';
}

}else{

if ($tax_check ==TRUE_STRING_S){
$tax_rate = $tax_value;
$nprice = $shipping['value'];
$bprice = olc_oe_get_price_i_tax($shipping['value'], $tax_value, 0);
$tax = ($bprice - $nprice);
}else{
$tax_rate = '0';
$nprice = $shipping['value'];
$bprice = $shipping['value'];
$tax = '0';
}

}
          $sql_data_array = array('orders_id' => olc_db_prepare_input($_POST['orders_id']),
                                  'n_price' => olc_db_prepare_input($nprice),
                                  'b_price' => olc_db_prepare_input($bprice),
                                  'tax' => olc_db_prepare_input($tax),
                                  'tax_rate' => olc_db_prepare_input($tax_rate));


            $insert_sql_data = array('class' => 'shipping');
            $sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
            olc_db_perform(TABLE_ORDERS_RECALCULATE, $sql_data_array);

  // Shipping Ende


  // COD

$tax_check = MODULE_ORDER_TOTAL_TAX_STATUS;
$tax_value = MODULE_ORDER_TOTAL_COD_TAX_CLASS;

  $cod_query = olc_db_query("select value from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $_POST['orders_id'] . "' and class='ot_cod_fee' ");
  $cod = olc_db_fetch_array($cod_query);

if ($allow_tax == '1'){

if ($tax_check ==TRUE_STRING_S){
$tax_rate = olc_oe_get_tax_rate($tax_value);
$nprice = olc_oe_get_price_o_tax($cod['value'], $tax_value, 1);
$bprice = $cod['value'];
$tax = ($bprice - $nprice);
}else{
$tax_rate = '0';
$nprice = $cod['value'];
$bprice = $cod['value'];
$tax = '0';
}

}else{

if ($tax_check ==TRUE_STRING_S){
$tax_rate = olc_oe_get_tax_rate($tax_value);
$nprice = $cod['value'];
$bprice = olc_oe_get_price_i_tax($cod['value'], $tax_value, 1);
$tax = ($bprice - $nprice);
}else{
$tax_rate = '0';
$nprice = $cod['value'];
$bprice = $cod['value'];
$tax = '0';
}

}
          $sql_data_array = array('orders_id' => olc_db_prepare_input($_POST['orders_id']),
                                  'n_price' => olc_db_prepare_input($nprice),
                                  'b_price' => olc_db_prepare_input($bprice),
                                  'tax' => olc_db_prepare_input($tax),
                                  'tax_rate' => olc_db_prepare_input($tax_rate));


            $insert_sql_data = array('class' => 'shipping');
            $sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
            olc_db_perform(TABLE_ORDERS_RECALCULATE, $sql_data_array);

  // COD Ende

  // Coupon

$tax_check = MODULE_ORDER_TOTAL_COUPON_INC_TAX;
$tax_value = MODULE_ORDER_TOTAL_COUPON_TAX_CLASS;

  $coupon_query = olc_db_query("select value from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $_POST['orders_id'] . "' and class='ot_coupon' ");
  $coupon = olc_db_fetch_array($coupon_query);

if ($allow_tax == '1'){

if ($tax_check ==TRUE_STRING_S){
$tax_rate = olc_oe_get_tax_rate($tax_value);
$nprice = olc_oe_get_price_o_tax($coupon['value'], $tax_value, 1);
$bprice = $coupon['value'];
$tax = ($bprice - $nprice);
}else{
$tax_rate = '0';
$nprice = $coupon['value'];
$bprice = $coupon['value'];
$tax = '0';
}

}else{

if ($tax_check ==TRUE_STRING_S){
$tax_rate = olc_oe_get_tax_rate($tax_value);
$nprice = $coupon['value'];
$bprice = olc_oe_get_price_i_tax($coupon['value'], $tax_value, 1);
$tax = ($bprice - $nprice);
}else{
$tax_rate = '0';
$nprice = $coupon['value'];
$bprice = $coupon['value'];
$tax = '0';
}

}
          $sql_data_array = array('orders_id' => olc_db_prepare_input($_POST['orders_id']),
                                  'n_price' => olc_db_prepare_input(($nprice*-1)),
                                  'b_price' => olc_db_prepare_input(($bprice*-1)),
                                  'tax' => olc_db_prepare_input(($tax*-1)),
                                  'tax_rate' => olc_db_prepare_input($tax_rate));


            $insert_sql_data = array('class' => 'discount');
            $sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
            olc_db_perform(TABLE_ORDERS_RECALCULATE, $sql_data_array);

  // Coupon Ende


  // GV

$tax_check = MODULE_ORDER_TOTAL_GV_INC_TAX;
$tax_value = MODULE_ORDER_TOTAL_GV_TAX_CLASS;

  $gv_query = olc_db_query("select value from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $_POST['orders_id'] . "' and class='ot_gv' ");
  $gv = olc_db_fetch_array($gv_query);

if ($allow_tax == '1'){

if ($tax_check ==TRUE_STRING_S){
$tax_rate = olc_oe_get_tax_rate($tax_value);
$nprice = olc_oe_get_price_o_tax($gv['value'], $tax_value, 1);
$bprice = $gv['value'];
$tax = ($bprice - $nprice);
}else{
$tax_rate = '0';
$nprice = $gv['value'];
$bprice = $gv['value'];
$tax = '0';
}

}else{

if ($tax_check ==TRUE_STRING_S){
$tax_rate = olc_oe_get_tax_rate($tax_value);
$nprice = $gv['value'];
$bprice = olc_oe_get_price_i_tax($gv['value'], $tax_value, 1);
$tax = ($bprice - $nprice);
}else{
$tax_rate = '0';
$nprice = $gv['value'];
$bprice = $gv['value'];
$tax = '0';
}

}
          $sql_data_array = array('orders_id' => olc_db_prepare_input($_POST['orders_id']),
                                  'n_price' => olc_db_prepare_input(($nprice*-1)),
                                  'b_price' => olc_db_prepare_input(($bprice*-1)),
                                  'tax' => olc_db_prepare_input(($tax*-1)),
                                  'tax_rate' => olc_db_prepare_input($tax_rate));


            $insert_sql_data = array('class' => 'discount');
            $sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
            olc_db_perform(TABLE_ORDERS_RECALCULATE, $sql_data_array);

  // GV Ende

  // Alte UST Löschen
            olc_db_query(DELETE_FROM . TABLE_ORDERS_TOTAL . " where orders_id = '" . olc_db_input($_POST['orders_id']) . "' and class='ot_tax'");
  // Alte UST Löschen ENDE

  // Neue UST Zusammenrechnen und in die DB Schreiben

  $ust_query = olc_db_query("select tax_rate, SUM(tax) as tax_value_new from " . TABLE_ORDERS_RECALCULATE . " where orders_id = '" . $_POST['orders_id'] . "' and tax !='0' GROUP by tax_rate ");
  while($ust = olc_db_fetch_array($ust_query)){

  $ust_desc_query = olc_db_query("select tax_description from " . TABLE_TAX_RATES . " where tax_rate = '" . $ust['tax_rate'] . APOS);
  $ust_desc = olc_db_fetch_array($ust_desc_query);

$title = $ust_desc['tax_description'];
$text = $currencies->format(olc_round($ust['tax_value_new'],PRICE_PRECISION));
$sort = MODULE_ORDER_TOTAL_TAX_SORT_ORDER;


          $sql_data_array = array('orders_id' => olc_db_prepare_input($_POST['orders_id']),
                                  'title' => olc_db_prepare_input($title),
                                  'text' => olc_db_prepare_input($text),
                                  'value' => olc_db_prepare_input($ust['tax_value_new']),
                                  'class' => 'ot_tax');

            $insert_sql_data = array('sort_order' => $sort);
            $sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
            olc_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

}
       olc_db_query(DELETE_FROM . TABLE_ORDERS_RECALCULATE . " where orders_id = '" . olc_db_input($_POST['orders_id']) . APOS);

  // Neue UST Zusammenrechnen und in die DB Schreiben ENDE


// Errechne neue MWSt. für die Bestellung Ende

// Errechne neue Gesamtsumme für die Bestellung Anfang

if ($allow_tax =='1'){
  $total_query = olc_db_query("select SUM(value) as value_new from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $_POST['orders_id'] . "' and class!='ot_coupon' and class!='ot_gv' and class!='ot_tax' and class!='ot_total'");
}else{
  $total_query = olc_db_query("select SUM(value) as value_new from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $_POST['orders_id'] . "' and class!='ot_coupon' and class!='ot_gv' and class!='ot_subtotal_no_tax' and class!='ot_total'");
}
  $total = olc_db_fetch_array($total_query);


$text = $currencies->format(olc_round($total['value_new'],PRICE_PRECISION));

          $sql_data_array = array('orders_id' => olc_db_prepare_input($_POST['orders_id']),
                                  'value' => olc_db_prepare_input($total['value_new']));

            $update_sql_data = array('text' => $text);
            $sql_data_array = olc_array_merge($sql_data_array, $update_sql_data);
            olc_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array, 'update', 'orders_id = \'' . olc_db_input($_POST['orders_id']) . '\' and class="ot_total"');



            olc_redirect(olc_href_link(FILENAME_ORDERS, 'action=edit&oID=' . $_POST['orders_id']));
}
// Errechne neue Gesamtsumme für die Bestellung Ende

// Löschfunktionen Anfang

if ($_GET['action'] == "product_delete") {
            olc_db_query(DELETE_FROM . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . olc_db_input($_POST['oID']) . "' and orders_products_id = '" . olc_db_input($_POST['opID']) . APOS);
			$products_attrbutes_query = olc_db_query("select orders_products_attributes_id from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_products_id = '" . olc_db_input($_POST['opID']) . APOS);
            if (olc_db_num_rows(products_attrbutes_query)) {
            olc_db_query(DELETE_FROM . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_products_id = '" . olc_db_input($_POST['opID']) . APOS);
            }
             olc_redirect(olc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=products&cID='.$_POST['cID'].'&oID=' . $_POST['oID']));
}

if ($_GET['action'] == "product_option_delete") {

            olc_db_query(DELETE_FROM . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" . olc_db_input($_POST['oID']) . "' and orders_products_attributes_id = '" . olc_db_input($_POST['opAID']) . APOS);

$products_query = olc_db_query("select products_id, products_price, products_tax_class_id from " . TABLE_PRODUCTS . " where products_id = '" . $_POST['pID'] . APOS);
$products = olc_db_fetch_array($products_query);

$products_a_query = olc_db_query("select options_values_price, price_prefix from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" . $_POST['oID'] . "' and orders_products_id = '" . $_POST['opID'] . APOS);
while($products_a = olc_db_fetch_array($products_a_query)){
$total_price += $products_a['price_prefix'].$products_a['options_values_price'];
};

$sa_price = olc_oe_get_products_attribute_price($total_price,$products['products_tax_class_id'],$price_special='0',1,$_POST['prefix'],$calculate_currencies=TRUE_STRING_S,$customers_status);
$sp_price = olc_oe_products_price($_POST['pID'],$price_special='0',1,$customers_status);

$inp_price = ($sa_price + $sp_price);
$final_price = ($inp_price*$_POST['qTY']);


          $sql_data_array = array('products_price' => olc_db_prepare_input($inp_price));
          $update_sql_data = array('final_price' => olc_db_prepare_input($final_price));
          $sql_data_array = olc_array_merge($sql_data_array, $update_sql_data);
          olc_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array, 'update', 'orders_products_id = \'' . olc_db_input($_POST['opID']) . '\'');
            

             olc_redirect(olc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=products&cID='.$_POST['cID'].'&oID=' . $_POST['oID']));
}

if ($_GET['action'] == "shipping_del") {
            olc_db_query(DELETE_FROM . TABLE_ORDERS_TOTAL . " where orders_total_id = '" . olc_db_input($_POST['otID']) . APOS);
            olc_redirect(olc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=shipping&cID='.$_POST['cID'].'&oID=' . $_POST['oID']));
}

if ($_GET['action'] == "cod_del") {
            olc_db_query(DELETE_FROM . TABLE_ORDERS_TOTAL . " where orders_total_id = '" . olc_db_input($_POST['otID']) . APOS);
            olc_redirect(olc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=shipping&cID='.$_POST['cID'].'&oID=' . $_POST['oID']));
}

// Löschfunktionen Ende


?>
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td valign="top"><table border="0" cellspacing="1" cellpadding="1" class="columnLeft" nowrap="nowrap">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading">
							<?php 
								define('AJAX_TITLE',TABLE_HEADING);
								echo AJAX_TITLE;
							?>
            </td>
            <td class="pageHeading" align="right"></td>
          </tr>
        </table></td>
      </tr>
  <tr>
<td>
<!-- Anfang //-->
<br/><br/>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
<tr class="dataTableHeadingRow">
<td class="dataTableHeadingContent" align="left">
<?php
echo olc_draw_form('select_address', FILENAME_ORDERS_EDIT, '', 'GET');
echo olc_draw_hidden_field('edit_action', 'address');
echo olc_draw_hidden_field('oID', $_GET['oID']);
echo olc_draw_hidden_field('cID', $_GET[cID]);
echo olc_image_submit('button_orders_address_edit.gif', TEXT_EDIT_ADDRESS,'style="cursor:hand" ');
?>
</form>
</td>
<td class="dataTableHeadingContent" align="left">
<?php
echo olc_draw_form('select_products', FILENAME_ORDERS_EDIT, '', 'GET');
echo olc_draw_hidden_field('edit_action', 'products');
echo olc_draw_hidden_field('oID', $_GET['oID']);
echo olc_draw_hidden_field('cID', $_GET[cID]);
echo olc_image_submit('button_orders_products_edit.gif', TEXT_EDIT_PRODUCTS,'style="cursor:hand" ');
?>
</form>
</td>
<td class="dataTableHeadingContent" align="left">
<?php
echo olc_draw_form('select_shipping', FILENAME_ORDERS_EDIT, '', 'GET');
echo olc_draw_hidden_field('edit_action', 'shipping');
echo olc_draw_hidden_field('oID', $_GET['oID']);
echo olc_draw_hidden_field('cID', $_GET[cID]);
echo olc_image_submit('button_orders_shipping_edit.gif', TEXT_EDIT_SHIPPING,'style="cursor:hand" ');
?>
</form>
</td>
<td class="dataTableHeadingContent" align="left">
<?php
echo olc_draw_form('select_gift', FILENAME_ORDERS_EDIT, '', 'GET');
echo olc_draw_hidden_field('edit_action', 'gift');
echo olc_draw_hidden_field('oID', $_GET['oID']);
echo olc_draw_hidden_field('cID', $_GET[cID]);
echo olc_image_submit('button_orders_gift_edit.gif', TEXT_EDIT_GIFT,'style="cursor:hand" ');
?>
</form>
</td>
</tr>
</table>

<!-- Meldungen Anfang //-->
<br/><br/>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
<tr>
<td class="main">
<b>
<?php
if($_GET['text']=='address'){
echo TEXT_EDIT_ADDRESS_SUCCESS;
}
?>
</b>
</td>
</tr>
</table>
<!-- Meldungen Ende //-->
<?php
if ($_GET['edit_action']=='address'){
  include('orders_edit_address.php');
} elseif ($_GET['edit_action']=='products'){
  include('orders_edit_products.php');
} elseif ($_GET['edit_action']=='shipping'){
  include('orders_edit_shipping.php');
} elseif ($_GET['edit_action']=='options'){
  include('orders_edit_options.php');
}
?>

<!-- Bestellung Sichern Anfang //-->
<br/><br/>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
<tr class="dataTableRow">
<td class="dataTableContent" align="right">
<?php
echo TEXT_SAVE_ORDER;
echo olc_draw_form('save_order', FILENAME_ORDERS_EDIT, 'action=save_order', 'post');
echo olc_draw_hidden_field('customers_status_id', $address[customers_status]);
echo olc_draw_hidden_field('orders_id', $_GET['oID']);
echo olc_image_submit('button_save.gif', TEXT_BUTTON_SAVE_ORDER,'style="cursor:hand" ');
?>
</form>
</td>
</tr>
<tr><td><?php echo olc_draw_separator(); ?></td></tr>
</table>
<br/><br/>
<!-- Bestellung Sichern Ende //-->


<!-- Ende //-->
</td>
  </tr>

<!-- body_text_eof //-->
        </table></td>
      </tr>
    </table></td>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
