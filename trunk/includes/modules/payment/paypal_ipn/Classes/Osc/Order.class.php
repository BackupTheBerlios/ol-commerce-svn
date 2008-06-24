<?php
/*
  $Id: Order.class.php,v 1.1.1.1.2.1 2007/04/08 07:18:08 gswkaiser Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  DevosC, Developing open source Code
  http://www.devosc.com

  Copyright (c) 2003 osCommerce
  Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

  Released under the GNU General Public License
*/

class PayPal_osC_Order {

  function PayPal_osC_Order()
  {
  }

  function setCommonVars($osC)
  {
    $this->setContentType($osC['content_type']);
    $this->setPaymentTitle($osC['payment_title']);
    $this->setLanguage($osC['language']);
    $this->setLanguageID($osC['language_id']);
    $this->setBillTo($osC['billto']);
    $this->setSendTo($osC['sendto']);
    $this->currency = $osC['currency'];
    $this->currency_value = $osC['currency_value'];
    $this->affiliate_id = $osC['affiliate_id'];
    $this->affiliate_clickthroughs_id = $osC['affiliate_clickthroughs_id'];
    $this->affiliate_date = $osC['affiliate_date'];
    $this->affiliate_browser = $osC['affiliate_browser'];
    $this->affiliate_ipaddress = $osC['affiliate_ipaddress'];
  }

  function loadTransactionSessionInfo($txn_sign)
  {
    $txn_signature = olc_db_prepare_input($txn_sign);
    $orders_session_query = olc_db_query(
    "select orders_id, content_type, payment_title, language, language_id, billto, sendto, currency, currency_value, payment_amount, payment_currency, affiliate_id, affiliate_clickthroughs_id, affiliate_date, affiliate_browser, affiliate_ipaddress from " . TABLE_ORDERS_SESSION_INFO . " where txn_signature ='" . olc_db_input($txn_signature) . "' limit 1");
    if(olc_db_num_rows($orders_session_query))
    {
      $orders_session = olc_db_fetch_array($orders_session_query);
      $this->setCommonVars($orders_session);
      $this->setOrderID($orders_session['orders_id']);
      $this->payment_amount = $orders_session['payment_amount'];
      $this->payment_currency = $orders_session['payment_currency'];
    }
  }

  function loadOrdersSessionInfo() {
    $orders_session_query = olc_db_query("select content_type, payment_title, language, language_id, billto, sendto, currency, currency_value, affiliate_id, affiliate_clickthroughs_id, affiliate_date, affiliate_browser, affiliate_ipaddress from " . TABLE_ORDERS_SESSION_INFO . " where orders_id ='" . (int)$this->orderID . "' limit 1");
    if(olc_db_num_rows($orders_session_query)) {
      $orders_session = olc_db_fetch_array($orders_session_query);
      $this->setCommonVars($orders_session);
    }
  }

  function removeOrdersSession() {
    olc_db_query(DELETE_FROM . TABLE_ORDERS_SESSION_INFO . " where orders_id = '" . (int)$this->orderID . APOS);
  }

  function updateOrderStatus($order_status = MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID) {
    // update the order's status
    olc_db_query(SQL_UPDATE . TABLE_ORDERS . " set orders_status = '" . olc_db_input($order_status) . "', last_modified = now() where orders_id = '" . (int)$this->orderID . APOS);
  }

  function updateProducts(&$order) {
    // initialized for the email confirmation
    $this->products_ordered = '';
    $subtotal = 0;
    $total_tax = 0;
    for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
    // Stock Update - Joao Correia
      if (STOCK_LIMITED == TRUE_STRING_S) {
        if (DOWNLOAD_ENABLED == TRUE_STRING_S) {
          $stock_query_raw = "SELECT products_quantity, pad.products_attributes_filename
                              FROM " . TABLE_PRODUCTS . " p
                              LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                               ON p.products_id=pa.products_id
                              LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                               ON pa.products_attributes_id=pad.products_attributes_id
                              WHERE p.products_id = '" . olc_get_prid($order->products[$i]['id']) . APOS;
          // Will work with only one option for downloadable products
          // otherwise, we have to build the query dynamically with a loop
          $products_attributes = $order->products[$i]['attributes'];
          if (is_array($products_attributes)) {
            $stock_query_raw .= " AND pa.options_id = '" . $products_attributes[0]['option_id'] . "' AND pa.options_values_id = '" . $products_attributes[0]['value_id'] . APOS;
          }
          $stock_query = olc_db_query($stock_query_raw);
        } else {
          $stock_query = olc_db_query("select products_quantity from " . TABLE_PRODUCTS . " where products_id = '" . olc_get_prid($order->products[$i]['id']) . APOS);
        }
        if (olc_db_num_rows($stock_query) > 0) {
          $stock_values = olc_db_fetch_array($stock_query);
          // do not decrement quantities if products_attributes_filename exists
          if ((DOWNLOAD_ENABLED != TRUE_STRING_S) || (!$stock_values['products_attributes_filename'])) {
            $stock_left = $stock_values['products_quantity'] - $order->products[$i]['qty'];
          } else {
            $stock_left = $stock_values['products_quantity'];
          }
          olc_db_query(SQL_UPDATE . TABLE_PRODUCTS . " set products_quantity = '" . $stock_left . "' where products_id = '" . olc_get_prid($order->products[$i]['id']) . APOS);
          if ( ($stock_left < 1) && (STOCK_ALLOW_CHECKOUT == FALSE_STRING_S) ) {
            olc_db_query(SQL_UPDATE . TABLE_PRODUCTS . " set products_status = '0' where products_id = '" . olc_get_prid($order->products[$i]['id']) . APOS);
          }
        }
      }

      // Update products_ordered (for bestsellers list)
      olc_db_query(SQL_UPDATE . TABLE_PRODUCTS . " set products_ordered = products_ordered + " . sprintf('%d', $order->products[$i]['qty']) . " where products_id = '" . olc_get_prid($order->products[$i]['id']) . APOS);

      //------insert customer choosen option to order--------
      $attributes_exist = '0';
      $products_ordered_attributes = '';
      if (isset($order->products[$i]['attributes'])) {
        $attributes_exist = '1';
        for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
          if (DOWNLOAD_ENABLED == TRUE_STRING_S) {
            $attributes_query = "select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix, pad.products_attributes_maxdays, pad.products_attributes_maxcount , pad.products_attributes_filename
                                 from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                 left join " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                                  on pa.products_attributes_id=pad.products_attributes_id
                                 where pa.products_id = '" . $order->products[$i]['id'] . "'
                                  and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "'
                                  and pa.options_id = popt.products_options_id
                                  and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "'
                                  and pa.options_values_id = poval.products_options_values_id
                                  and popt.language_id = '" . $this->languageID . "'
                                  and poval.language_id = '" . $this->languageID . APOS;
            $attributes = olc_db_query($attributes_query);
          } else {
            $attributes = olc_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . $order->products[$i]['id'] . "' and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . $this->languageID . "' and poval.language_id = '" . $this->languageID . APOS);
          }
          $attributes_values = olc_db_fetch_array($attributes);
          if ((DOWNLOAD_ENABLED == TRUE_STRING_S) && isset($attributes_values['products_attributes_filename']) && olc_not_null($attributes_values['products_attributes_filename']) ) {
            $sql_data_array = array('orders_id' => $this->orderID,
                                    'orders_products_id' => $order->products[$i]['orders_products_id'],
                                    'orders_products_filename' => $attributes_values['products_attributes_filename'],
                                    'download_maxdays' => $attributes_values['products_attributes_maxdays'],
                                    'download_count' => $attributes_values['products_attributes_maxcount']);
            olc_db_perform(TABLE_ORDERS_PRODUCTS_DOWNLOAD, $sql_data_array);
          }
          $products_ordered_attributes .= "\n\t" . $attributes_values['products_options_name'] . ' ' . $attributes_values['products_options_values_name'];
        }
      }
      //------insert customer choosen option eof ----
      $total_weight += ($order->products[$i]['qty'] * $order->products[$i]['weight']);
      $total_tax += olc_calculate_tax($total_products_price, $products_tax) * $order->products[$i]['qty'];
      $total_cost += $total_products_price;

      //$currency_price = $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']);
      $products_ordered_price = $this->displayPrice($order->products[$i]['final_price'],$order->products[$i]['tax'],$order->products[$i]['qty']);

      $this->products_ordered .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . LPAREN . $order->products[$i]['model'] . ') = ' . $products_ordered_price . $products_ordered_attributes . NEW_LINE;
    }
  }

  function displayPrice($amount, $tax, $qty = 1) {
    global $currencies;

    if ( (DISPLAY_PRICE_WITH_TAX == TRUE_STRING_S) && ($tax > 0) ) {
      return $currencies->format(olc_add_tax($amount, $tax) * $qty, true, $this->currency, $this->currency_value);
    }

    return $currencies->format($amount * $qty, true, $this->currency, $this->currency_value);
  }


  function getCustomerComments() {
    $orders_history_query = olc_db_query("select comments from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = '" . (int)$this->orderID . "' order by date_added limit 1");
    if (olc_db_num_rows($orders_history_query)) {
      $orders_history = olc_db_fetch_array($orders_history_query);
      return $orders_history['comments'];
    }
    return false;
  }


  function setLanguage($lng) {
    $this->language = $lng;
  }

  function setLanguageID($id) {
    $this->languageID = $id;
  }

  function setOrderID($id) {
    $this->orderID = $id;
  }

  function setBillTo($id) {
    $this->billTo = $id;
  }

  function setSendTo($id) {
    $this->sendTo = $id;
  }

  function setPaymentTitle($title) {
    $this->paymentTitle = $title;
  }

  function setContentType($type) {
    $this->contentType = $type;
  }

  function setCheckoutProcessLanguageFile($filename) {
    $this->checkoutProcessLanguageFile = $filename;
  }

  function setAccountHistoryInfoURL($url) {
    $this->accountHistoryInfoURL= $url;
  }

  function notifyCustomer(&$order) {
    $customer_notification = (SEND_EMAILS == TRUE_STRING_S) ? '1' : '0';
    olc_db_query(INSERT_INTO . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified) values ('" . (int)$this->orderID . "', '" . MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID . "', now(), '" . $customer_notification . "')");

    // lets start with the email confirmation
    include($this->checkoutProcessLanguageFile);

    $email_order = STORE_NAME . NEW_LINE .
                   EMAIL_SEPARATOR . NEW_LINE .
                   EMAIL_TEXT_ORDER_NUMBER . ' ' . $this->orderID . NEW_LINE .
                   EMAIL_TEXT_INVOICE_URL . ' ' . $this->accountHistoryInfoURL . NEW_LINE .
                   EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n\n";

    $customerComments = $this->getCustomerComments();

    if ($customerComments) {
      $email_order .= olc_db_output($customerComments) . "\n\n";
    }
    $email_order .= EMAIL_TEXT_PRODUCTS . NEW_LINE .
                    EMAIL_SEPARATOR . NEW_LINE .
                    $this->products_ordered .
                    EMAIL_SEPARATOR . NEW_LINE;

    for ($i=0, $n=sizeof($order->totals); $i<$n; $i++) {
      $email_order .= strip_tags($order->totals[$i]['title']) . ' ' . strip_tags($order->totals[$i]['text']) . NEW_LINE;
    }

    if ($this->contentType != 'virtual') {
      $email_order .= NEW_LINE . EMAIL_TEXT_DELIVERY_ADDRESS . NEW_LINE .
                      EMAIL_SEPARATOR . NEW_LINE .
                      olc_address_label($order->customer['id'], $this->sendTo, 0, '', NEW_LINE) . NEW_LINE;
    }

    $email_order .= NEW_LINE . EMAIL_TEXT_BILLING_ADDRESS . NEW_LINE .
                    EMAIL_SEPARATOR . NEW_LINE .
                    olc_address_label($order->customer['id'], $this->billTo, 0, '', NEW_LINE) . "\n\n";

    $email_order .= EMAIL_TEXT_PAYMENT_METHOD . NEW_LINE .
                    EMAIL_SEPARATOR . NEW_LINE;
    $email_order .= $this->paymentTitle . "\n\n";

    olc_mail($order->customer['name'], $order->customer['email_address'], EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);

    // send emails to other people
    if (SEND_EXTRA_ORDER_EMAILS_TO != '') {
      olc_mail('', SEND_EXTRA_ORDER_EMAILS_TO, EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
    }
  }

  function setOrderPaymentID($payment_id,$oID='') {
      $order_id = !empty($oID) ? $oID : $this->orderID;
      olc_db_query(SQL_UPDATE . TABLE_ORDERS . " set payment_id = '" . (int)$payment_id . "' where orders_id = '" . (int)$order_id . APOS);
  }

  function removeCustomersBasket($customer_id) {
      olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_BASKET . " where customers_id = '" . (int)$customer_id . APOS);
      olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where customers_id = '" . (int)$customer_id . APOS);
  }

}//end class
?>