<?
/*******************************************************************************************
*                                                                                          *
*  CAO-Faktura für Windows Version 1.2 (http://www.cao-wawi.de)                            *
*  Copyright (C) 2003 Jan Pokrandt / Jan@JP-SOFT.de                                        *
*                                                                                          *
*  This program is free software; you can redistribute it and/or                           *
*  modify it under the terms of the GNU General Public License                             *
*  as published by the Free Software Foundation; either version 2                          *
*  of the License, or any later version.                                                   *
*                                                                                          *
*  This program is distributed in the hope that it will be useful,                         *
*  but WITHOUT ANY WARRANTY; without even the implied warranty of                          *
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                           *
*  GNU General Public License for more details.                                            *
*                                                                                          *
*  You should have received a copy of the GNU General Public License                       *
*  along with this program; if not, write to the Free Software                             *
*  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.             *
*                                                                                          *
*  ******* CAO-Faktura comes with ABSOLUTELY NO WARRANTY ***************                   *
*                                                                                          *
********************************************************************************************
*                                                                                          *
* Eine Entfernung oder Veraenderung dieses Dateiheaders ist nicht zulaessig !!!            *
* Wenn Sie diese Datei veraendern dann fuegen Sie ihre eigenen Copyrightmeldungen          *
* am Ende diese Headers an                                                                 *
*                                                                                          *
********************************************************************************************
*                                                                                          *
*  Programm     : CAO-Faktura                                                              *
*  Modul        : cao_olc.php                                                              *
*  Stand        : 07.11.2005                                                               *
*  Version      : 1.51                                                                     *
*  Beschreibung : Script zum Datenaustausch CAO-Faktura <--> OL-Commerce-Shop               *
*                                                                                          *
*  based on:                                                                               *
* (c) 2000 - 2001 The Exchange Project                                                     *
* (c) 2001 - 2003 osCommerce, Open Source E-Commerce Solutions                             *
* (c) 2001 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers                                      *
* (c) 2003 JP-Soft, Jan Pokrandt                                                           *
* (c) 2003 IN-Solution, Henri Schmidhuber                                                  *
* (c) 2003 www.websl.de, Karl Langmann                                                     *
* (c) 2003 RV-Design Raphael Vullriede                                                     *
* (c) 2004 XT-Commerce                                                                     *
*                                                                                          *
* Released under the GNU General Public License                                            *
*                                                                                          *
*  History :                                                                               *
*                                                                                          *
*  - 26.09.2005 JP Funktionen aus xml_export.php und cao_import.php erstellt               *
*  - 04.10.2005 JP/KL Version 1.44 released, Scripte komplett ueberarbeitet                *
*  - 06.10.2005 KL/JP Bugfix bei olc_set_time_limit                                        *
*  - 17.10.2005 JP Bugfixes fuer OLC 304                                                   *
*  - 21.10.2005 KL/JP Bugfix fuer OLC 2.x Spalte products_Ean angelegt                     *
*  - 23.10.2005 hartleib Fehlende $LangID in OrderUpdate hinzugefuegt                      *
*  - 02.11.2005 JP Fehler bei doppelter Funktion xtDBquery gefixt                          *
*  - 07.11.2005 JP Export Orders/VAT_ID implementiert                                      *
*******************************************************************************************/
  define('DIR_FS_INCLUDES', DIR_FS_CATALOG . 'includes/');
  define('DIR_FS_CLASSES', DIR_FS_INCLUDES . 'classes/');
  
if (!function_exists('olDBquery')) : 

	function olDBquery($query) 
	{
	//	if (DB_CACHE == TRUE_STRING_S) 
	//	{
	//		$result =olc_db_queryCached($query);
	//	} 
	//	  else 
	//	{
			$result = olc_db_query($query);
	//	}
		return $result;
	}
	
endif;
	
//--------------------------------------------------------------

function SendScriptVersion ()
{
   global $_GET, $version_nr, $version_datum;

   $schema = '<?xml version="1.0" encoding="' . CHARSET . '"?>' . NEW_LINE .
             '<STATUS>' . NEW_LINE .
             '<STATUS_DATA>' . NEW_LINE .
             '<ACTION>' . $_GET['action'] . '</ACTION>' . NEW_LINE .
             '<CODE>' . '111' . '</CODE>' . NEW_LINE .              
             '<SCRIPT_VER>' . $version_nr . '</SCRIPT_VER>' . NEW_LINE . 
             '<SCRIPT_DATE>' . $version_datum . '</SCRIPT_DATE>' . NEW_LINE . 
             '</STATUS_DATA>' . NEW_LINE .
             '</STATUS>' . "\n\n";
   echo $schema; 
}


//--------------------------------------------------------------

function print_xml_status ($code, $action, $msg, $mode, $item, $value)
{
  $schema = '<?xml version="1.0" encoding="' . CHARSET . '"?>' . NEW_LINE .
            '<STATUS>' . NEW_LINE .
            '<STATUS_DATA>' . NEW_LINE .
            '<CODE>' . $code . '</CODE>' . NEW_LINE .
            '<ACTION>' . $action . '</ACTION>' . NEW_LINE .
            '<MESSAGE>' . $msg . '</MESSAGE>' . NEW_LINE;
	    
  if (strlen($mode)>0) {
    $schema .= '<MODE>' . $mode . '</MODE>' . NEW_LINE;
  }
  
  if (strlen($item)>0) {
    $schema .= '<' . $item . '>' . $value . '</' . $item . '>' . NEW_LINE;
  }
  $schema .= '</STATUS_DATA>' . NEW_LINE .
             '</STATUS>' . "\n\n";

  echo $schema;
  
  return;
}

//--------------------------------------------------------------

function table_exists($table_name) 
{
  $Table = mysql_query("show tables like '" . $table_name . "'");
  if(mysql_fetch_row($Table) === false) 
  { 
    return(false); 
  } else {
    return(true);
  }
}

//--------------------------------------------------------------
	
function column_exists($table, $column) 
{
  $Table = mysql_query("show columns from $table LIKE '" . $column . "'");
  if(mysql_fetch_row($Table) === false) 
  {
    return(false);
  } else {
    return(true);
  }
}

//--------------------------------------------------------------

function SendCategories ()
{
  if (defined('SET_TIME_LIMIT')) { @set_time_limit(0);}

  $schema = '<?xml version="1.0" encoding="' . CHARSET . '"?>' . NEW_LINE .
            '<CATEGORIES>' . NEW_LINE;
                  
  echo $schema;
                  
  $cat_query = olc_db_query("select categories_id, categories_image, parent_id, sort_order, date_added, last_modified ".
                            " from " . TABLE_CATEGORIES . " order by parent_id, categories_id");
  while ($cat = olc_db_fetch_array($cat_query))
  {
    $schema  = '<CATEGORIES_DATA>' . NEW_LINE .
               '<id>' . $cat['categories_id'] . '</id>' . NEW_LINE .
               '<pARENT_ID>' . $cat['parent_id'] . '</pARENT_ID>' . NEW_LINE .
               '<IMAGE_URL>' . htmlspecialchars($cat['categories_image']) . '</IMAGE_URL>' . NEW_LINE .
               '<SORT_ORDER>' . $cat['sort_order'] . '</SORT_ORDER>' . NEW_LINE .
               '<DATE_ADDED>' . $cat['date_added'] . '</DATE_ADDED>' . NEW_LINE .
               '<LAST_MODIFIED>' . $cat['last_modified'] . '</LAST_MODIFIED>' . NEW_LINE;

    $detail_query = olc_db_query("select categories_id, language_id,
                                  categories_name,
                                  categories_heading_title,
                                  categories_description,
                                  categories_meta_title,
                                  categories_meta_description,
                                  categories_meta_keywords, " . TABLE_LANGUAGES . ".code as lang_code, " . TABLE_LANGUAGES . ".name as lang_name from " . TABLE_CATEGORIES_DESCRIPTION . "," . TABLE_LANGUAGES .
                                  " where " . TABLE_CATEGORIES_DESCRIPTION . ".categories_id=" . $cat['categories_id'] . " and " . TABLE_LANGUAGES . ".languages_id=" . TABLE_CATEGORIES_DESCRIPTION . ".language_id");

    while ($details = olc_db_fetch_array($detail_query))
    {
      $schema .= "<CATEGORIES_DESCRIPTION id='" . $details["language_id"] ."' CODE='" . $details["lang_code"] . "' name='" . $details["lang_name"] . "'>\n";
      $schema .= "<NAME>" . htmlspecialchars($details["categories_name"]) . "</NAME>" . NEW_LINE;
      $schema .= "<HEADING_TITLE>" . htmlspecialchars($details["categories_heading_title"]) . "</HEADING_TITLE>" . NEW_LINE;
      $schema .= "<DESCRIPTION>" . htmlspecialchars($details["categories_description"]) . "</DESCRIPTION>" . NEW_LINE;
      $schema .= "<META_TITLE>" . htmlspecialchars($details["categories_meta_title"]) . "</META_TITLE>" . NEW_LINE;
      $schema .= "<META_DESCRIPTION>" . htmlspecialchars($details["categories_meta_description"]) . "</META_DESCRIPTION>" . NEW_LINE;
      $schema .= "<META_KEYWORDS>" . htmlspecialchars($details["categories_meta_keywords"]) . "</META_KEYWORDS>" . NEW_LINE;
      $schema .= "</CATEGORIES_DESCRIPTION>\n";
    }

    // Produkte in dieser Categorie auflisten
    $prod2cat_query = olc_db_query("select categories_id, products_id from " . TABLE_PRODUCTS_TO_CATEGORIES .
                                   " where categories_id='" . $cat['categories_id'] . "'");
                                       
    while ($prod2cat = olc_db_fetch_array($prod2cat_query))
    {
      $schema .="<pRODUCTS id='" . $prod2cat["products_id"] ."'></pRODUCTS>" . NEW_LINE;
    }
    $schema .= '</CATEGORIES_DATA>' . NEW_LINE;
    echo $schema;
  }
  $schema = '</CATEGORIES>' . NEW_LINE;
  echo $schema;
}

//--------------------------------------------------------------

function  SendManufacturers ()
{
  if (defined('SET_TIME_LIMIT')) { @set_time_limit(0);}
  
  $schema = '<?xml version="1.0" encoding="' . CHARSET . '"?>' . NEW_LINE .
            '<MANUFACTURERS>' . NEW_LINE;
  echo $schema;
                  
  $cat_query = olc_db_query("select manufacturers_id, manufacturers_name, manufacturers_image, date_added, last_modified ".
 	                         " from " . TABLE_MANUFACTURERS . " order by manufacturers_id");
  
  while ($cat = olc_db_fetch_array($cat_query))
  {
    $schema  = '<MANUFACTURERS_DATA>' . NEW_LINE .
               '<id>' . $cat['manufacturers_id'] . '</id>' . NEW_LINE .
               '<NAME>' . htmlspecialchars($cat['manufacturers_name']) . '</NAME>' . NEW_LINE .
               '<IMAGE>' . htmlspecialchars($cat['manufacturers_image']) . '</IMAGE>' . NEW_LINE .
               '<DATE_ADDED>' . $cat['date_added'] . '</DATE_ADDED>' . NEW_LINE .
               '<LAST_MODIFIED>' . $cat['last_modified'] . '</LAST_MODIFIED>' . NEW_LINE;
                     
    $sql = "select 
             manufacturers_id, " . 
             TABLE_MANUFACTURERS_INFO . ".languages_id, 
             manufacturers_url, 
             url_clicked, 
             date_last_click, " . 
             TABLE_LANGUAGES . ".code as lang_code, " . 
             TABLE_LANGUAGES . ".name as lang_name 
            from " . 
             TABLE_MANUFACTURERS_INFO . "," . 
             TABLE_LANGUAGES . " 
            where " . 
             TABLE_MANUFACTURERS_INFO . ".manufacturers_id=" . $cat['manufacturers_id'] . " and " . 
             TABLE_LANGUAGES . ".languages_id=" . TABLE_MANUFACTURERS_INFO . ".languages_id";

    $detail_query = olc_db_query($sql);

    while ($details = olc_db_fetch_array($detail_query))
    {
      $schema .= "<MANUFACTURERS_DESCRIPTION id='" . $details["languages_id"] ."' CODE='" . $details["lang_code"] . "' name='" . $details["lang_name"] . "'>\n";
      $schema .= "<URL>" . htmlspecialchars($details["manufacturers_url"]) . "</URL>" . NEW_LINE ;
      $schema .= "<URL_CLICK>" . $details["url_clicked"] . "</URL_CLICK>" . NEW_LINE ;
      $schema .= "<DATE_LAST_CLICK>" . $details["date_last_click"] . "</DATE_LAST_CLICK>" . NEW_LINE ;
      $schema .= "</MANUFACTURERS_DESCRIPTION>\n";
    }
    $schema .= '</MANUFACTURERS_DATA>' . NEW_LINE;
    echo $schema;
  }
  $schema = '</MANUFACTURERS>' . NEW_LINE;
  echo $schema;
}

//--------------------------------------------------------------

function SendOrders ()
{
  global $_GET, $order_total_class;
  
  $order_from = olc_db_prepare_input($_GET['order_from']);
  $order_to = olc_db_prepare_input($_GET['order_to']);
  $order_status = olc_db_prepare_input($_GET['order_status']);
        
  if (defined('SET_TIME_LIMIT')) { @set_time_limit(0);}

  $schema = '<?xml version="1.0" encoding="' . CHARSET . '"?>' . NEW_LINE .
            '<ORDER>' . NEW_LINE;
  echo $schema;
        
  $sql ="select * from " . TABLE_ORDERS . " where orders_id >= '" . olc_db_input($order_from) . "'";
  if (!isset($order_status) && !isset($order_from)) 
  {
    $order_status = 1;
    $sql .= "and orders_status = " . $order_status;
  }
  if ($order_status!='') 
  {
    $sql .= " and orders_status = " . $order_status;
  }
  $orders_query = olc_db_query($sql);
        
  while ($orders = olc_db_fetch_array($orders_query))
  {
    // Geburtsdatum laden
    $cust_sql = "select * from " . TABLE_CUSTOMERS . " where customers_id=" . $orders['customers_id'];
    $cust_query = olc_db_query ($cust_sql);
    if (($cust_query) && ($cust_data = olc_db_fetch_array($cust_query)))
    {
      $cust_dob = $cust_data['customers_dob'];
      $cust_gender = $cust_data['customers_gender'];
    } 
      else 
    {
      $cust_dob = '';
      $cust_gender = '';
    }
    if ($orders['billing_company']=='') $orders['billing_company']=$orders['delivery_company'];
    if ($orders['billing_name']=='')  $orders['billing_name']=$orders['delivery_name'];
    if ($orders['billing_street_address']=='') $orders['billing_street_address']=$orders['delivery_street_address'];
    if ($orders['billing_postcode']=='')  $orders['billing_postcode']=$orders['delivery_postcode'];
    if ($orders['billing_city']=='')  $orders['billing_city']=$orders['delivery_city'];
    if ($orders['billing_suburb']=='') $orders['billing_suburb']=$orders['delivery_suburb'];
    if ($orders['billing_state']=='')  $orders['billing_state']=$orders['delivery_state'];
    if ($orders['billing_country']=='')  $orders['billing_country']=$orders['delivery_country'];

    $schema  = '<ORDER_INFO>' . NEW_LINE .
               '<ORDER_HEADER>' . NEW_LINE .
               '<ORDER_ID>' . $orders['orders_id'] . '</ORDER_ID>' . NEW_LINE .
               '<CUSTOMER_ID>' . $orders['customers_id'] . '</CUSTOMER_ID>' . NEW_LINE .
               '<CUSTOMER_CID>' . $orders['customers_cid'] . '</CUSTOMER_CID>' . NEW_LINE .
               '<CUSTOMER_GROUP>' . $orders['customers_status'] . '</CUSTOMER_GROUP>' . NEW_LINE .
               '<ORDER_DATE>' . $orders['date_purchased'] . '</ORDER_DATE>' . NEW_LINE .
               '<ORDER_STATUS>' . $orders['orders_status'] . '</ORDER_STATUS>' . NEW_LINE .
               '<ORDER_IP>' . $orders['customers_ip'] . '</ORDER_IP>' . NEW_LINE .
               '<ORDER_CURRENCY>' . htmlspecialchars($orders['currency']) . '</ORDER_CURRENCY>' . NEW_LINE .
               '<ORDER_CURRENCY_VALUE>' . $orders['currency_value'] . '</ORDER_CURRENCY_VALUE>' . NEW_LINE .
               '</ORDER_HEADER>' . NEW_LINE .
               '<BILLING_ADDRESS>' . NEW_LINE .
               '<VAT_ID>' . htmlspecialchars($orders['customers_vat_id']) . '</VAT_ID>' . NEW_LINE . //JP07112005 (Existiert erst ab OLC 3.x)
               '<COMPANY>' . htmlspecialchars($orders['billing_company']) . '</COMPANY>' . NEW_LINE .
               '<NAME>' . htmlspecialchars($orders['billing_name']) . '</NAME>' . NEW_LINE .
               '<FIRSTNAME>' . htmlspecialchars($orders['billing_firstname']) . '</FIRSTNAME>' . NEW_LINE .
               '<LASTNAME>' . htmlspecialchars($orders['billing_lastname']) . '</LASTNAME>' . NEW_LINE .
               '<STREET>' . htmlspecialchars($orders['billing_street_address']) . '</STREET>' . NEW_LINE .
               '<pOSTCODE>' . htmlspecialchars($orders['billing_postcode']) . '</pOSTCODE>' . NEW_LINE .
               '<CITY>' . htmlspecialchars($orders['billing_city']) . '</CITY>' . NEW_LINE .
               '<SUBURB>' . htmlspecialchars($orders['billing_suburb']) . '</SUBURB>' . NEW_LINE .
               '<STATE>' . htmlspecialchars($orders['billing_state']) . '</STATE>' . NEW_LINE .
               '<COUNTRY>' . htmlspecialchars($orders['billing_country_iso_code_2']) . '</COUNTRY>' . NEW_LINE .
               '<TELEPHONE>' . htmlspecialchars($orders['customers_telephone']) . '</TELEPHONE>' . NEW_LINE . // JAN
               '<EMAIL>' . htmlspecialchars($orders['customers_email_address']) . '</EMAIL>' . NEW_LINE . // JAN
               '<BIRTHDAY>' . htmlspecialchars($cust_dob) . '</BIRTHDAY>' . NEW_LINE .
               '<GENDER>' . htmlspecialchars($cust_gender) . '</GENDER>' . NEW_LINE .
               '</BILLING_ADDRESS>' . NEW_LINE .
               '<DELIVERY_ADDRESS>' . NEW_LINE .
               '<COMPANY>' . htmlspecialchars($orders['delivery_company']) . '</COMPANY>' . NEW_LINE .
               '<NAME>' . htmlspecialchars($orders['delivery_name']) . '</NAME>' . NEW_LINE .
               '<FIRSTNAME>' . htmlspecialchars($orders['delivery_firstname']) . '</FIRSTNAME>' . NEW_LINE . 
               '<LASTNAME>' . htmlspecialchars($orders['delivery_lastname']) . '</LASTNAME>' . NEW_LINE .                    
               '<STREET>' . htmlspecialchars($orders['delivery_street_address']) . '</STREET>' . NEW_LINE .
               '<pOSTCODE>' . htmlspecialchars($orders['delivery_postcode']) . '</pOSTCODE>' . NEW_LINE .
               '<CITY>' . htmlspecialchars($orders['delivery_city']) . '</CITY>' . NEW_LINE .
               '<SUBURB>' . htmlspecialchars($orders['delivery_suburb']) . '</SUBURB>' . NEW_LINE .
               '<STATE>' . htmlspecialchars($orders['delivery_state']) . '</STATE>' . NEW_LINE .
               '<COUNTRY>' . htmlspecialchars($orders['delivery_country_iso_code_2']) . '</COUNTRY>' . NEW_LINE .
               '</DELIVERY_ADDRESS>' . NEW_LINE .
               '<pAYMENT>' . NEW_LINE .
               '<pAYMENT_METHOD>' . htmlspecialchars($orders['payment_method']) . '</pAYMENT_METHOD>'  . NEW_LINE .
               '<pAYMENT_CLASS>' . htmlspecialchars($orders['payment_class']) . '</pAYMENT_CLASS>'  . NEW_LINE;
    
    switch ($orders['payment_class']) 
    {
      case 'banktransfer':
             // Bankverbindung laden, wenn aktiv
             $bank_name = '';
             $bank_blz  = '';
             $bank_kto  = '';
             $bank_inh  = '';
             $bank_stat = -1;
  	          
  	          $bank_sql = "select * from " . TABLE_BANKTRANSFER . " where orders_id = " . $orders['orders_id'];
             $bank_query = olc_db_query($bank_sql);
	          if (($bank_query) && ($bankdata = olc_db_fetch_array($bank_query))) 
	          {
	            $bank_name = $bankdata['banktransfer_bankname'];
	            $bank_blz  = $bankdata['banktransfer_blz'];
	            $bank_kto  = $bankdata['banktransfer_number'];
	            $bank_inh  = $bankdata['banktransfer_owner'];
	            $bank_stat = $bankdata['banktransfer_status'];
	          }
             $schema .= '<pAYMENT_BANKTRANS_BNAME>' . htmlspecialchars($bank_name) . '</pAYMENT_BANKTRANS_BNAME>' . NEW_LINE .
                        '<pAYMENT_BANKTRANS_BLZ>' . htmlspecialchars($bank_blz) . '</pAYMENT_BANKTRANS_BLZ>' . NEW_LINE .
                        '<pAYMENT_BANKTRANS_NUMBER>' . htmlspecialchars($bank_kto) . '</pAYMENT_BANKTRANS_NUMBER>' . NEW_LINE .
                        '<pAYMENT_BANKTRANS_OWNER>' . htmlspecialchars($bank_inh) . '</pAYMENT_BANKTRANS_OWNER>' . NEW_LINE .
                        '<pAYMENT_BANKTRANS_STATUS>' . htmlspecialchars($bank_stat) . '</pAYMENT_BANKTRANS_STATUS>' . NEW_LINE;
             break;
    }
    $schema .= '</pAYMENT>' . NEW_LINE . 
               '<SHIPPING>' . NEW_LINE . 
               '<SHIPPING_METHOD>' . htmlspecialchars($orders['shipping_method']) . '</SHIPPING_METHOD>'  . NEW_LINE .
               '<SHIPPING_CLASS>' . htmlspecialchars($orders['shipping_class']) . '</SHIPPING_CLASS>'  . NEW_LINE .
               '</SHIPPING>' . NEW_LINE .                      
               '<ORDER_PRODUCTS>' . NEW_LINE;
                     
    $sql = "select 
             orders_products_id,
             allow_tax, 
             products_id, 
             products_model, 
             products_name, 
             final_price, 
             products_tax, 
             products_quantity 
            from " . 
             TABLE_ORDERS_PRODUCTS . " 
            where 
             orders_id = '" . $orders['orders_id'] . "'";
                     
    $products_query = olc_db_query($sql);
    while ($products = olc_db_fetch_array($products_query))
    {
      if ($products['allow_tax']==1) $products['final_price']=$products['final_price']/(1+$products['products_tax']*0.01);
      $schema .= '<pRODUCT>' . NEW_LINE .
                 '<pRODUCTS_ID>' . $products['products_id'] . '</pRODUCTS_ID>' . NEW_LINE .
                 '<pRODUCTS_QUANTITY>' . $products['products_quantity'] . '</pRODUCTS_QUANTITY>' . NEW_LINE .
                 '<pRODUCTS_MODEL>' . htmlspecialchars($products['products_model']) . '</pRODUCTS_MODEL>' . NEW_LINE .
                 '<pRODUCTS_NAME>' . htmlspecialchars($products['products_name']) . '</pRODUCTS_NAME>' . NEW_LINE .
                 '<pRODUCTS_PRICE>' . $products['final_price']/$products['products_quantity'] . '</pRODUCTS_PRICE>' . NEW_LINE .
                 '<pRODUCTS_TAX>' . $products['products_tax'] . '</pRODUCTS_TAX>' . NEW_LINE.
                 '<pRODUCTS_TAX_FLAG>' . $products['allow_tax'] . '</pRODUCTS_TAX_FLAG>' . NEW_LINE;
            
      $attributes_query = olc_db_query("select products_options, products_options_values, options_values_price, price_prefix from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" .$orders['orders_id'] . "' and orders_products_id = '" . $products['orders_products_id'] . "'");
      if (olc_db_num_rows($attributes_query))
      {
        while ($attributes = olc_db_fetch_array($attributes_query))
        {
          require_once(DIR_FS_INC . 'olc_get_attributes_model.inc.php');
          $attributes_model =olc_get_attributes_model($products['products_id'],$attributes['products_options_values']);
          $schema .= '<option>' . NEW_LINE .
                     '<pRODUCTS_OPTIONS>' .  htmlspecialchars($attributes['products_options']) . '</pRODUCTS_OPTIONS>' . NEW_LINE .
                     '<pRODUCTS_OPTIONS_VALUES>' .  htmlspecialchars($attributes['products_options_values']) . '</pRODUCTS_OPTIONS_VALUES>' . NEW_LINE .
                     '<pRODUCTS_OPTIONS_MODEL>'.$attributes_model.'</pRODUCTS_OPTIONS_MODEL>'. NEW_LINE.
                     '<pRODUCTS_OPTIONS_PRICE>' .  $attributes['price_prefix'] . ' ' . $attributes['options_values_price'] . '</pRODUCTS_OPTIONS_PRICE>' . NEW_LINE .
                     '</OPTION>' . NEW_LINE;
        }
      }            
      $schema .=  '</pRODUCT>' . NEW_LINE;
    }
    $schema .= '</ORDER_PRODUCTS>' . NEW_LINE;                     
    $schema .= '<ORDER_TOTAL>' . NEW_LINE;
          
    $totals_query = olc_db_query("select title, value, class, sort_order from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $orders['orders_id'] . "' order by sort_order");
    while ($totals = olc_db_fetch_array($totals_query))
    {
      $total_prefix = "";
      $total_tax  = "";
      $total_prefix = $order_total_class[$totals['class']]['prefix'];
      $total_tax = $order_total_class[$totals['class']]['tax'];
      $schema .= '<TOTAL>' . NEW_LINE .
                 '<TOTAL_TITLE>' . htmlspecialchars($totals['title']) . '</TOTAL_TITLE>' . NEW_LINE .
                 '<TOTAL_VALUE>' . htmlspecialchars($totals['value']) . '</TOTAL_VALUE>' . NEW_LINE .
                 '<TOTAL_CLASS>' . htmlspecialchars($totals['class']) . '</TOTAL_CLASS>' . NEW_LINE .
                 '<TOTAL_SORT_ORDER>' . htmlspecialchars($totals['sort_order']) . '</TOTAL_SORT_ORDER>' . NEW_LINE .
                 '<TOTAL_PREFIX>' . htmlspecialchars($total_prefix) . '</TOTAL_PREFIX>' . NEW_LINE .
                 '<TOTAL_TAX>' . htmlspecialchars($total_tax) . '</TOTAL_TAX>' . NEW_LINE . 
                 '</TOTAL>' . NEW_LINE;
    }
    $schema .= '</ORDER_TOTAL>' . NEW_LINE;
          
    $sql = "select 
             comments 
            from " . 
             TABLE_ORDERS_STATUS_HISTORY . " 
            where 
             orders_id = '" . $orders['orders_id'] . "' and 
             orders_status_id = '" . $orders['orders_status'] . "' ";
         
    $comments_query = olc_db_query($sql);
    if ($comments =  olc_db_fetch_array($comments_query)) 
    {
      $schema .=  '<ORDER_COMMENTS>' . htmlspecialchars($comments['comments']) . '</ORDER_COMMENTS>' . NEW_LINE;
    }
    $schema .= '</ORDER_INFO>' . "\n\n";
    echo $schema;
  }
  $schema = '</ORDER>' . "\n\n";
  echo $schema;
}

//--------------------------------------------------------------

function SendProducts ()
{
  global $_GET, $LangID;
  
  if (defined('SET_TIME_LIMIT')) { @set_time_limit(0);}

  $schema = '<?xml version="1.0" encoding="' . CHARSET . '"?>' . NEW_LINE .
            '<pRODUCTS>' . NEW_LINE;
  echo $schema;
                  
  $sql = "select products_id,products_fsk18, products_quantity, products_model, products_image, products_price, " .
         "products_date_added, products_last_modified, products_date_available, products_weight, " .
         "products_status, products_tax_class_id, manufacturers_id, products_ordered from " . TABLE_PRODUCTS;
               
  $from = olc_db_prepare_input($_GET['products_from']);
  $anz  = olc_db_prepare_input($_GET['products_count']);
  if (isset($from))
  {
    if (!isset($anz)) $anz=1000;
    $sql .= " limit " . $from . "," . $anz;
  }

  $orders_query = olc_db_query($sql);
  while ($products = olc_db_fetch_array($orders_query))
  {
    $schema  = '<pRODUCT_INFO>' . NEW_LINE .
               '<pRODUCT_DATA>' . NEW_LINE .
               '<pRODUCT_ID>'.$products['products_id'].'</pRODUCT_ID>' . NEW_LINE .
               '<pRODUCT_DEEPLINK>'. HTTP_SERVER.DIR_WS_CATALOG.$olc_filename['product_info'].'?products_id='.$products['products_id'].'</pRODUCT_DEEPLINK>' . NEW_LINE .
               '<pRODUCT_QUANTITY>' . $products['products_quantity'] . '</pRODUCT_QUANTITY>' . NEW_LINE .
               '<pRODUCT_MODEL>' . htmlspecialchars($products['products_model']) . '</pRODUCT_MODEL>' . NEW_LINE .
               '<pRODUCT_FSK18>' . htmlspecialchars($products['products_fsk18']) . '</pRODUCT_FSK18>' . NEW_LINE .
               '<pRODUCT_IMAGE>' . htmlspecialchars($products['products_image']) . '</pRODUCT_IMAGE>' . NEW_LINE;

    if ($products['products_image']!='') 
    {
      $schema .= '<pRODUCT_IMAGE_POPUP>'.HTTP_SERVER.DIR_WS_CATALOG.DIR_WS_POPUP_IMAGES.$products['products_image'].'</pRODUCT_IMAGE_POPUP>'. NEW_LINE .
                 '<pRODUCT_IMAGE_SMALL>'.HTTP_SERVER.DIR_WS_CATALOG.DIR_WS_INFO_IMAGES.$products['products_image'].'</pRODUCT_IMAGE_SMALL>'. NEW_LINE .
                 '<pRODUCT_IMAGE_THUMBNAIL>'.HTTP_SERVER.DIR_WS_CATALOG.DIR_WS_THUMBNAIL_IMAGES.$products['products_image'].'</pRODUCT_IMAGE_THUMBNAIL>'. NEW_LINE .
                 '<pRODUCT_IMAGE_ORIGINAL>'.HTTP_SERVER.DIR_WS_CATALOG.DIR_WS_ORIGINAL_IMAGES.$products['products_image'].'</pRODUCT_IMAGE_ORIGINAL>'. NEW_LINE;
    }

    $schema .= '<pRODUCT_PRICE>' . $products['products_price'] . '</pRODUCT_PRICE>' . NEW_LINE;

    /* Wird von CAO derzeit nicht verwendet !!! */
    
    
    require_once(DIR_FS_INC .'olc_get_customers_statuses.inc.php');
    
    $customers_status=olc_get_customers_statuses();
    for ($i=1,$n=sizeof($customers_status);$i<$n; $i++) 
    {
      if ($customers_status[$i]['id']!=0) 
      {
        $schema .= "<pRODUCT_GROUP_PRICES id='".$customers_status[$i]['id']."' name='".$customers_status[$i]['text']. "'>". NEW_LINE;
        $group_price_query=olc_db_query("SELECT * FROM " . TABLE_PERSONAL_OFFERS_BY_CUSTOMERS_STATUS . " ".$customers_status[$i]['id'].
                                        " WHERE products_id='" . $products_id . "'");
        while ($group_price_data=olc_db_fetch_array($group_price_query)) 
        {
          //if ($group_price_data['personal_offer']!='0') 
          //{
          $schema .='<pRICE_ID>'.$group_price_data['price_id'].'</pRICE_ID>';
          $schema .='<pRODUCT_ID>'.$group_price_data['products_id'].'</pRODUCT_ID>';
          $schema .='<QTY>'.$group_price_data['quantity'].'</QTY>';
          $schema .='<pRICE>'.$group_price_data['personal_offer'].'</pRICE>';
          //}
        }
        $schema .= "</pRODUCT_GROUP_PRICES>\n";
      }
    }
    // products Options

    $products_attributes='';
    $products_options_data=array();
    $products_options_array =array();
    $products_attributes_query = olc_db_query("select count(*) as total
                                               from " . TABLE_PRODUCTS_OPTIONS . "
                                               popt, " . TABLE_PRODUCTS_ATTRIBUTES . "
                                               patrib where
                                               patrib.products_id='" . $products['products_id'] . "'
                                               and patrib.options_id = popt.products_options_id
                                               and popt.language_id = '" . $LangID . "'");

    $products_attributes = olc_db_fetch_array($products_attributes_query);

    if ($products_attributes['total'] > 0) 
    {
      $products_options_name_query = olc_db_query("select distinct
                                                   popt.products_options_id,
                                                   popt.products_options_name
                                                   from " . TABLE_PRODUCTS_OPTIONS . "
                                                   popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib
                                                   where patrib.products_id='" . $products['products_id'] . "'
                                                   and patrib.options_id = popt.products_options_id
                                                   and popt.language_id = '" . $LangID . "' order by popt.products_options_name");
      $row = 0;
      $col = 0;
      $products_options_data=array();
      while ($products_options_name = olc_db_fetch_array($products_options_name_query)) 
      {
        $selected = 0;
        $products_options_array = array();
        $products_options_data[$row]=array(
                       'NAME'=>$products_options_name['products_options_name'],
                       'id' => $products_options_name['products_options_id'],
                       'DATA' =>'');
        $products_options_query = olc_db_query("select
                                                 pov.products_options_values_id,
                                                 pov.products_options_values_name,
                                                 pa.attributes_model,
                                                 pa.options_values_price,
                                                 pa.options_values_weight,
                                                 pa.price_prefix,
                                                 pa.weight_prefix,
                                                 pa.attributes_stock,
                                                 pa.attributes_model
                                                from " . TABLE_PRODUCTS_ATTRIBUTES . "
                                                 pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . "
                                                 pov 
                                                where
                                                 pa.products_id = '" . $products['products_id'] . "'
                                                 and pa.options_id = '" . $products_options_name['products_options_id'] . "' and
                                                 pa.options_values_id = pov.products_options_values_id and
                                                 pov.language_id = '" . $LangID . "' 
                                                order by pov.products_options_values_name");
        $col = 0;
        while ($products_options = olc_db_fetch_array($products_options_query)) 
        {
          $products_options_array[] = array('id' => $products_options['products_options_values_id'], 'text' => $products_options['products_options_values_name']);
          if ($products_options['options_values_price'] != '0') 
          {
            $products_options_array[sizeof($products_options_array)-1]['text'] .=  ' '.$products_options['price_prefix'].' '.$products_options['options_values_price'].' '.$_SESSION['currency'] ;
          }
          $price='';
          $products_options_data[$row]['DATA'][$col]=array(
                                    'id' => $products_options['products_options_values_id'],
                                    'TEXT' =>$products_options['products_options_values_name'],
                                    'MODEL' =>$products_options['attributes_model'],
                                    'WEIGHT' =>$products_options['options_values_weight'],
                                    'PRICE' =>$products_options['options_values_price'],
                                    'WEIGHT_PREFIX' =>$products_options['weight_prefix'],
                                    'PREFIX' =>$products_options['price_prefix']);
          $col++;
        }
        $row++;
      }
    }
    if (sizeof($products_options_data)!=0) 
    {
      for ($i=0,$n=sizeof($products_options_data);$i<$n;$i++) 
      {
        $schema .= "<pRODUCT_ATTRIBUTES NAME='".$products_options_data[$i]['NAME']."'>";
        for ($ii=0,$nn=sizeof($products_options_data[$i]['DATA']);$ii<$nn;$ii++) 
        {
          $schema .= '<option>';
          $schema .= '<id>'.$products_options_data[$i]['DATA'][$ii]['id'].'</id>';
          $schema .= '<MODEL>'.$products_options_data[$i]['DATA'][$ii]['MODEL'].'</MODEL>';
          $schema .= '<TEXT>'.$products_options_data[$i]['DATA'][$ii]['TEXT'].'</TEXT>';
          $schema .= '<WEIGHT>'.$products_options_data[$i]['DATA'][$ii]['WEIGHT'].'</WEIGHT>';
          $schema .= '<pRICE>'.$products_options_data[$i]['DATA'][$ii]['PRICE'].'</pRICE>';
          $schema .= '<WEIGHT_PREFIX>'.$products_options_data[$i]['DATA'][$ii]['WEIGHT_PREFIX'].'</WEIGHT_PREFIX>';
          $schema .= '<pREFIX>'.$products_options_data[$i]['DATA'][$ii]['PREFIX'].'</pREFIX>';
          $schema .= '</OPTION>';
        }
        $schema .= '</pRODUCT_ATTRIBUTES>';
      }
    }
    /* End Wird zur Zeit nicht verwendet */
    
    require_once(DIR_FS_INC .'olc_get_tax_rate.inc.php');
    
    if (SWITCH_MWST==TRUE_STRING_S) 
    {
      // switch IDs
      if ($products['products_tax_class_id']==1) 
      { 
        $products['products_tax_class_id']=2; 
      }
        else
      {
        if ($products['products_tax_class_id']==2) 
        { 
          $products['products_tax_class_id']=1; 
        }
      } 
    }
    
    $schema .= '<pRODUCT_WEIGHT>' . $products['products_weight'] . '</pRODUCT_WEIGHT>' . NEW_LINE .
               '<pRODUCT_STATUS>' . $products['products_status'] . '</pRODUCT_STATUS>' . NEW_LINE .
               '<pRODUCT_TAX_CLASS_ID>' . $products['products_tax_class_id'] . '</pRODUCT_TAX_CLASS_ID>' . NEW_LINE  .
               '<pRODUCT_TAX_RATE>' . olc_get_tax_rate($products['products_tax_class_id']) . '</pRODUCT_TAX_RATE>' . NEW_LINE  .
               '<MANUFACTURERS_ID>' . $products['manufacturers_id'] . '</MANUFACTURERS_ID>' . NEW_LINE .
               '<pRODUCT_DATE_ADDED>' . $products['products_date_added'] . '</pRODUCT_DATE_ADDED>' . NEW_LINE .
               '<pRODUCT_LAST_MODIFIED>' . $products['products_last_modified'] . '</pRODUCT_LAST_MODIFIED>' . NEW_LINE .
               '<pRODUCT_DATE_AVAILABLE>' . $products['products_date_available'] . '</pRODUCT_DATE_AVAILABLE>' . NEW_LINE .
               '<pRODUCTS_ORDERED>' . $products['products_ordered'] . '</pRODUCTS_ORDERED>' . NEW_LINE ;
          
    /* Wird von CAO derzeit nicht verwendet !!! */
    
    $categories_query=olc_db_query("SELECT
                                     categories_id
                                    FROM ".TABLE_PRODUCTS_TO_CATEGORIES."
                                     where products_id='".$products['products_id']."'");
    $categories=array();
    while ($categories_data=olc_db_fetch_array($categories_query)) 
    {
      $categories[]=$categories_data['categories_id'];
    }
    $categories=implode(',',$categories);

    $schema .= '<pRODUCTS_CATEGORIES>' . $categories . '</pRODUCTS_CATEGORIES>' . NEW_LINE ;
    
    /* Ende Wird zur Zeit nicht verwendet */

    $detail_query = olc_db_query("select
                                   products_id,
                                   language_id,
                                   products_name, " . TABLE_PRODUCTS_DESCRIPTION .
         								  ".products_description,
                                   products_short_description,
                                   products_meta_title,
                                   products_meta_description,
                                   products_meta_keywords,
                                   products_url,
                                   name as language_name, code as language_code " .
                                   "from " . TABLE_PRODUCTS_DESCRIPTION . ", " . TABLE_LANGUAGES . " " .
                                   "where " . TABLE_PRODUCTS_DESCRIPTION . ".language_id=" . TABLE_LANGUAGES . ".languages_id " .
                                   "and " . TABLE_PRODUCTS_DESCRIPTION . ".products_id=" . $products['products_id']);
    
    while ($details = olc_db_fetch_array($detail_query))
    {
      $schema .= "<pRODUCT_DESCRIPTION id='" . $details["language_id"] ."' CODE='" . $details["language_code"] . "' name='" . $details["language_name"] . "'>\n";

      if ($details["products_name"] !='Array')
      {
        $schema .= "<NAME>" . htmlspecialchars($details["products_name"]) . "</NAME>" . NEW_LINE ;
      }
      $schema .=  "<URL>" . htmlspecialchars($details["products_url"]) . "</URL>" . NEW_LINE ;

      $prod_details = $details["products_description"];
      if ($prod_details != 'Array')
      {
        $schema .=  "<DESCRIPTION>" . htmlspecialchars($details["products_description"]) . "</DESCRIPTION>" . NEW_LINE;
        $schema .=  "<SHORT_DESCRIPTION>" . htmlspecialchars($details["products_short_description"]) . "</SHORT_DESCRIPTION>" . NEW_LINE;
        $schema .=  "<META_TITLE>" . htmlspecialchars($details["products_meta_title"]) . "</META_TITLE>" . NEW_LINE;
        $schema .=  "<META_DESCRIPTION>" . htmlspecialchars($details["products_meta_description"]) . "</META_DESCRIPTION>" . NEW_LINE;
        $schema .=  "<META_KEYWORDS>" . htmlspecialchars($details["products_meta_keywords"]) . "</META_KEYWORDS>" . NEW_LINE;
      }
      $schema .= "</pRODUCT_DESCRIPTION>\n";
    }
          
	 // NEU JP 26.08.2005 Aktionspreise exportieren
	 $special_query = "SELECT * from " . TABLE_SPECIALS . " " .
	                  "where products_id=" . $products['products_id'] . " limit 0,1";
					                            
	 $special_result = olc_db_query($special_query);
		             
	 while ($specials = olc_db_fetch_array($special_result)) 
	 {
	   $schema .= '<SPECIAL>' . NEW_LINE .
		           '<SPECIAL_PRICE>' . $specials['specials_new_products_price'] . '</SPECIAL_PRICE>' . NEW_LINE .
		           '<SPECIAL_DATE_ADDED>' . $specials['specials_date_added'] . '</SPECIAL_DATE_ADDED>' . NEW_LINE .
		           '<SPECIAL_LAST_MODIFIED>' . $specials['specials_last_modified'] . '</SPECIAL_LAST_MODIFIED>' . NEW_LINE .
		           '<SPECIAL_DATE_EXPIRES>' . $specials['expires_date'] . '</SPECIAL_DATE_EXPIRES>' . NEW_LINE .
		           '<SPECIAL_STATUS>' . $specials['status'] . '</SPECIAL_STATUS>' . NEW_LINE .
		           '<SPECIAL_DATE_STATUS_CHANGE>' . $specials['date_status_change'] . '</SPECIAL_DATE_STATUS_CHANGE>' . NEW_LINE .
		           '</SPECIAL>' . NEW_LINE;          
    }
    // Ende Aktionspreise
          
    $schema .= '</pRODUCT_DATA>' . NEW_LINE .
               '</pRODUCT_INFO>' . NEW_LINE;
    echo $schema;
  }
  $schema = '</pRODUCTS>' . "\n\n";
  echo $schema;
}

//--------------------------------------------------------------

function SendCustomers ()
{
  global $_GET;
  
  if (defined('SET_TIME_LIMIT')) { @set_time_limit(0);}

  $schema = '<?xml version="1.0" encoding="' . CHARSET . '"?>' . NEW_LINE .
            '<CUSTOMERS>' . NEW_LINE;
  echo $schema;

  $from = olc_db_prepare_input($_GET['customers_from']);
  $anz  = olc_db_prepare_input($_GET['customers_count']);

  $address_query = "select
                    c.customers_gender, 
                    c.customers_id,
                    c.customers_cid, 
                    c.customers_dob, 
                    c.customers_email_address, 
                    c.customers_telephone, 
                    c.customers_fax,
                    ci.customers_info_date_account_created,
                    a.entry_firstname, 
                    a.entry_lastname, 
                    a.entry_company, 
                    a.entry_street_address, 
                    a.entry_city,
                    a.entry_postcode, 
                    a.entry_suburb,
                    a.entry_state,
                    co.countries_iso_code_2
                   from 
                    " . TABLE_CUSTOMERS . " c, 
                    " . TABLE_CUSTOMERS_INFO . " ci, 
                    " . TABLE_ADDRESS_BOOK . " a , 
                    " . TABLE_COUNTRIES . " co
                   where
                    c.customers_id = ci.customers_info_id AND
                    c.customers_id = a.customers_id AND
                    c.customers_default_address_id = a.address_book_id AND
                    a.entry_country_id  = co.countries_id";
  
  if (isset($from)) 
  {
    if (!isset($anz)) $anz = 1000;
    $address_query.= " limit " . $from . "," . $anz;
  }
  $address_result = olc_db_query($address_query);

  while ($address = olc_db_fetch_array($address_result))  
  {
    $schema = '<CUSTOMERS_DATA>' . NEW_LINE .
              '<CUSTOMERS_ID>' . htmlspecialchars($address['customers_id']) . '</CUSTOMERS_ID>' . NEW_LINE .
              '<CUSTOMERS_CID>' . htmlspecialchars($address['customers_cid']) . '</CUSTOMERS_CID>' . NEW_LINE .
              '<GENDER>' . htmlspecialchars($address['customers_gender']) . '</GENDER>' . NEW_LINE .
              '<COMPANY>' . htmlspecialchars($address['entry_company']) . '</COMPANY>' . NEW_LINE .
              '<FIRSTNAME>' . htmlspecialchars($address['entry_firstname']) . '</FIRSTNAME>' . NEW_LINE .
              '<LASTNAME>' . htmlspecialchars($address['entry_lastname']) . '</LASTNAME>' . NEW_LINE .
              '<STREET>' . htmlspecialchars($address['entry_street_address']) . '</STREET>' . NEW_LINE .
              '<pOSTCODE>' . htmlspecialchars($address['entry_postcode']) . '</pOSTCODE>' . NEW_LINE .
              '<CITY>' . htmlspecialchars($address['entry_city']) . '</CITY>' . NEW_LINE .
              '<SUBURB>' . htmlspecialchars($address['entry_suburb']) . '</SUBURB>' . NEW_LINE .
              '<STATE>' . htmlspecialchars($address['entry_state']) . '</STATE>' . NEW_LINE .
              '<COUNTRY>' . htmlspecialchars($address['countries_iso_code_2']) . '</COUNTRY>' . NEW_LINE .
              '<TELEPHONE>' . htmlspecialchars($address['customers_telephone']) . '</TELEPHONE>' . NEW_LINE . // JAN
              '<FAX>' . htmlspecialchars($address['customers_fax']) . '</FAX>' . NEW_LINE . // JAN
              '<EMAIL>' . htmlspecialchars($address['customers_email_address']) . '</EMAIL>' . NEW_LINE . // JAN
              '<BIRTHDAY>' . htmlspecialchars($address['customers_dob']) . '</BIRTHDAY>' . NEW_LINE .
              '<DATE_ACCOUNT_CREATED>' . htmlspecialchars($address['customers_info_date_account_created']) . '</DATE_ACCOUNT_CREATED>' . NEW_LINE .
              '</CUSTOMERS_DATA>' . NEW_LINE;
    echo $schema;
  }
  $schema = '</CUSTOMERS>' . "\n\n";
  echo $schema;
}

//--------------------------------------------------------------

function SendCustomersNewsletter ()
{
  global $_GET;
  
  if (defined('SET_TIME_LIMIT')) { @set_time_limit(0);}

  $schema = '<?xml version="1.0" encoding="' . CHARSET . '"?>' . NEW_LINE .
            '<CUSTOMERS>' . NEW_LINE.
			
  $from = olc_db_prepare_input($_GET['customers_from']);
  $anz  = olc_db_prepare_input($_GET['customers_count']);
		
  $address_query = "select *
                    from " . TABLE_CUSTOMERS. " 
                    where customers_newsletter = 1";
                    
  if (isset($from)) 
  {
    if (!isset($anz)) $anz = 1000;
    $address_query.= " limit " . $from . "," . $anz;
  }
  $address_result = olc_db_query($address_query);
  while ($address = olc_db_fetch_array($address_result))
  {
    $schema .= '<CUSTOMERS_DATA>' . NEW_LINE;
    $schema .= '<CUSTOMERS_ID>' . $address['customers_id'] . '</CUSTOMERS_ID>' . NEW_LINE;
    $schema .= '<CUSTOMERS_CID>' . $address['customers_cid'] . '</CUSTOMERS_CID>' . NEW_LINE;
    $schema .= '<CUSTOMERS_GENDER>' . $address['customers_gender'] . '</CUSTOMERS_GENDER>' . NEW_LINE;
    $schema .= '<CUSTOMERS_FIRSTNAME>' . $address['customers_firstname'] . '</CUSTOMERS_FIRSTNAME>' . NEW_LINE;
    $schema .= '<CUSTOMERS_LASTNAME>' . $address['customers_lastname'] . '</CUSTOMERS_LASTNAME>' . NEW_LINE;
    $schema .= '<CUSTOMERS_EMAIL_ADDRESS>' . $address['customers_email_address'] . '</CUSTOMERS_EMAIL_ADDRESS>' . NEW_LINE;
    $schema .= '</CUSTOMERS_DATA>' . NEW_LINE;		
  }	
  $schema .= '</CUSTOMERS>' . "\n\n";
  echo $schema;
}

//--------------------------------------------------------------

function SendShopConfig ()
{
  $schema = '<?xml version="1.0" encoding="' . CHARSET . '"?>' . NEW_LINE .
            '<CONFIG>' . NEW_LINE .
            '<CONFIG_DATA>' . NEW_LINE ;
  echo $schema;
  
  $config_sql = "select * from " . TABLE_CONFIGURATION . " ";
  $config_res = olc_db_query($config_sql);

  while ($config = olc_db_fetch_array($config_res)) 
  {
    $schema = '<ENTRY id="' . $config['configuration_id'] . '">' .  NEW_LINE .
	           '<pARAM>' . htmlspecialchars($config['configuration_key']) . '</pARAM>' . NEW_LINE .
	           '<VALUE>' . htmlspecialchars($config['configuration_value']) . '</VALUE>' . NEW_LINE .
	           '<TITLE>' . htmlspecialchars($config['configuration_title']) . '</TITLE>' . NEW_LINE .
	           '<DESCRIPTION>' . htmlspecialchars($config['configuration_description']) . '</DESCRIPTION>' . NEW_LINE .
	           '<GROUP_ID>' . htmlspecialchars($config['config_group_id']) . '</GROUP_ID>' . NEW_LINE .
	           '<SORT_ORDER>' . htmlspecialchars($config['sort_order']) . '</SORT_ORDER>' . NEW_LINE .
	           '<USE_FUNCTION>' . htmlspecialchars($config['use_function']) . '</USE_FUNCTION>' . NEW_LINE .
	           '<SET_FUNCTION>' . htmlspecialchars($config['set_function']) . '</SET_FUNCTION>' . NEW_LINE .
	           '</ENTRY>' . NEW_LINE;
    echo $schema;
  }	  
  $schema = '</CONFIG_DATA>' . NEW_LINE;
  echo $schema;
	
	
  $schema = '<TAX_CLASS>' . NEW_LINE;
  echo $schema;
	
  $tax_class_sql = "select * from ". TABLE_TAX_CLASS . " ";
  $tax_class_res = olc_db_query($tax_class_sql);
	
  while ($tax_class = olc_db_fetch_array($tax_class_res)) 
  {
    $schema = '<CLASS id="' . $tax_class['tax_class_id'] . '">' . NEW_LINE .
	           '<TITLE>' .         htmlspecialchars($tax_class['tax_class_title']) .       '</TITLE>' . NEW_LINE .
	           '<DESCRIPTION>' .   htmlspecialchars($tax_class['tax_class_description']) . '</DESCRIPTION>' . NEW_LINE .
	           '<LAST_MODIFIED>' . htmlspecialchars($tax_class['last_modified']) .         '</LAST_MODIFIED>' . NEW_LINE .
	           '<DATE_ADDED>' .    htmlspecialchars($tax_class['date_added']) .            '</DATE_ADDED>' . NEW_LINE .
              '</CLASS>'. NEW_LINE;
    echo $schema;
  }
	
  $schema = '</TAX_CLASS>' . NEW_LINE;
  echo $schema;
  $schema = '<TAX_RATES>' . NEW_LINE;
  echo $schema;

  $tax_rates_sql = "select * from " . TABLE_TAX_RATES . " ";
  $tax_rates_res = olc_db_query($tax_rates_sql);
	
  while ($tax_rates = olc_db_fetch_array($tax_rates_res)) 
  {
    $schema = '<RATES id=">' . $tax_rates['tax_rates_id'] . '">' . NEW_LINE .
              '<ZONE_ID>' .       htmlspecialchars($tax_rates['tax_zone_id']) .     '</ZONE_ID>' . NEW_LINE .
              '<CLASS_ID>' .      htmlspecialchars($tax_rates['tax_class_id']) .    '</CLASS_ID>' . NEW_LINE .
              '<pRIORITY>' .      htmlspecialchars($tax_rates['tax_priority']) .    '</pRIORITY>' . NEW_LINE .
              '<RATE>' .          htmlspecialchars($tax_rates['tax_rate']) .        '</RATE>' . NEW_LINE .
              '<DESCRIPTION>' .   htmlspecialchars($tax_rates['tax_description']) . '</DESCRIPTION>' . NEW_LINE .
              '<LAST_MODIFIED>' . htmlspecialchars($tax_rates['last_modified']) .   '</LAST_MODIFIED>' . NEW_LINE .
              '<DATE_ADDED>' .    htmlspecialchars($tax_rates['date_added']) .      '</DATE_ADDED>' . NEW_LINE .
              '</RATES>' . NEW_LINE;
    echo $schema;
  }
  $schema = '</TAX_RATES>' . NEW_LINE;
  echo $schema;
  $schema = '</CONFIG>' . NEW_LINE;		  
  echo $schema;
}

//--------------------------------------------------------------
 
function SendXMLHeader ()
{
  header ("Last-Modified: ". gmdate ("D, d M Y H:i:s"). " GMT");  // immer geändert
  header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header ("Pragma: no-cache"); // HTTP/1.0
  header ("Content-type: text/xml");
}
//--------------------------------------------------------------
 

function SendHTMLHeader ()
{
  header ("Last-Modified: ". gmdate ("D, d M Y H:i:s"). " GMT");  // immer geändert
  header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header ("Pragma: no-cache"); // HTTP/1.0
  header ("Content-type: text/html");
}

//--------------------------------------------------------------

function ShowHTMLMenu ()
{
  global $version_nr, $version_datum, $user, $password, $PHP_SELF;
  
  SendHTMLHeader;

  $Url = $PHP_SELF . "?user=" . $user . "&password=" . $password;
  

?>
<html><head></head><body>
<h3>CAO-Faktura - OL-Commerce Shopanbindung</h3>
<h4>Version <? echo $version_nr; ?> Stand : <? echo $version_datum; ?></h4>
<br/>
<br/><b>m&ouml;gliche Funktionen :</b><br/><br/>
<a href="<? echo $Url; ?>&action=version">Ausgabe XML Scriptversion</a><br/>
<br/>
<a href="<? echo $Url; ?>&action=manufacturers_export">Ausgabe XML Manufacturers</a><br/>
<a href="<? echo $Url; ?>&action=categories_export">Ausgabe XML Categories</a><br/>
<a href="<? echo $Url; ?>&action=products_export">Ausgabe XML Products</a><br/>
<a href="<? echo $Url; ?>&action=customers_export">Ausgabe XML Customers</a><br/>
<a href="<? echo $Url; ?>&action=customers_newsletter_export">Ausgabe XML Customers-Newsletter</a><br/>
<br/>
<a href="<? echo $Url; ?>&action=orders_export">Ausgabe XML Orders</a><br/>
<br/>
<a href="<? echo $Url; ?>&action=config_export">Ausgabe XML Shop-Config</a><br/>
<br/>
<a href="<? echo $Url; ?>&action=update_tables">MySQL-Tabellen aktualisieren</a><br/>
</body>
</html>
<?
}   

//--------------------------------------------------------------   
   
function UpdateTables ()
{
  global $version_nr, $version_datum;
  
  SendHTMLHeader;

  echo '<html><head></head><body>';
  echo '<h3>Tabellen-Update / Erweiterung für CAO-Faktura</h3>';
  echo '<h4>Version ' . $version_nr . ' Stand : ' . $version_datum .'</h4>';
      
  $sql[1]  = 'ALTER TABLE ' . TABLE_PRODUCTS . ' ADD products_ean VARCHAR(128) AFTER products_id';
  $sql[2]  = 'ALTER TABLE ' . TABLE_ORDERS . ' ADD payment_class VARCHAR(32) NOT NULL';
  $sql[3]  = 'ALTER TABLE ' . TABLE_ORDERS . ' ADD shipping_method VARCHAR(32) NOT NULL';
  $sql[4]  = 'ALTER TABLE ' . TABLE_ORDERS . ' ADD shipping_class VARCHAR(32) NOT NULL';
  $sql[5]  = 'ALTER TABLE ' . TABLE_ORDERS . ' ADD billing_country_iso_code_2 CHAR(2) NOT NULL AFTER billing_country';
  $sql[6]  = 'ALTER TABLE ' . TABLE_ORDERS . ' ADD delivery_country_iso_code_2 CHAR(2) NOT NULL AFTER delivery_country';
  $sql[7]  = 'ALTER TABLE ' . TABLE_ORDERS . ' ADD billing_firstname VARCHAR(32) NOT NULL AFTER billing_name';
  $sql[8]  = 'ALTER TABLE ' . TABLE_ORDERS . ' ADD billing_lastname VARCHAR(32) NOT NULL AFTER billing_firstname';
  $sql[9]  = 'ALTER TABLE ' . TABLE_ORDERS . ' ADD delivery_firstname VARCHAR(32) NOT NULL AFTER delivery_name';
  $sql[10] = 'ALTER TABLE ' . TABLE_ORDERS . ' ADD delivery_lastname VARCHAR(32) NOT NULL AFTER delivery_firstname';
  $sql[11] = 'ALTER TABLE ' . TABLE_ORDERS . ' CHANGE payment_method payment_method VARCHAR(255) NOT NULL';
  $sql[12] = 'ALTER TABLE ' . TABLE_ORDERS . ' CHANGE shipping_method shipping_method VARCHAR(255) NOT NULL';
  $sql[13] = 'CREATE TABLE ' . TABLE_PREFIX. 'cao_log ( id int(11) NOT NULL auto_increment, date datetime NOT NULL default "0000-00-00 00:00:00",'.
             'user varchar(64) NOT NULL default "", pw varchar(64) NOT NULL default "", method varchar(64) NOT NULL default "",'.
             'action varchar(64) NOT NULL default "", post_data mediumtext, get_data mediumtext, PRIMARY KEY  (id))';
 
  $link = 'db_link';
  
  global $$link, $logger;

  for ($i=1;$i<=13;$i++)
  {
    echo '<b>SQL:</b> ' . $sql[$i] . HTML_BR;;
	   
    if (mysql_query($sql[$i], $$link))
    {
      echo '<b>Ergebnis : OK</b>';
    }
	   else
    {
      $error = mysql_error();
      $pos=strpos($error,'Duplicate column name');
	       
      if ($pos===False)
      {
        $pos=strpos($error,'already exists');
        if ($pos===False)
        {
          echo '<b>Ergebnis : </b><font color="red"><b>' . $error . '</b></font>';
		  }
		    else
		  {
		    echo '<b>Ergebnis : OK, Tabelle existierte bereits !</b>';
		  }
	   }
	     else
	   {
	     echo '<b>Ergebnis : OK, Spalte existierte bereits !</b>';
	   }	   
	 }
    echo '<br/><br/>';
  }
  echo '</body></html>';
}

//--------------------------------------------------------------

function olc_try_upload ($file = '', $destination = '', 
                         $permissions = '777', $extensions = '')
{
  $file_object = new upload($file, $destination, $permissions, $extensions);
  if ($file_object->filename != '') return $file_object; else return false;
}

//--------------------------------------------------------------

require_once(DIR_FS_INC .'olc_not_null.inc.php');

function clear_string($value) 
{
        $string=str_replace("'",'',$value);
        $string=str_replace(RPAREN,'',$string);
        $string=str_replace('(','',$string);
        $array=explode(',',$string);
        return $array;
} 

//--------------------------------------------------------------

function olc_RandomString($length) 
{
        $chars = array( 'a', 'A', 'b', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'h', 'H', 'i', 'I', 'j', 'J',  'k', 'K', 'l', 'L', 'm', 'M', 'n','N', 'o', 'O', 'p', 'P', 'q', 'Q', 'r', 'R', 's', 'S', 't', 'T',  'u', 'U', 'v','V', 'w', 'W', 'x', 'X', 'y', 'Y', 'z', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');

        $max_chars = count($chars) - 1;
        srand( (double) microtime()*1000000);

        $rand_str = '';
        for($i=0;$i<$length;$i++)
        {
          $rand_str = ( $i == 0 ) ? $chars[rand(0, $max_chars)] : $rand_str . $chars[rand(0, $max_chars)];
        }

  return $rand_str;
}

//--------------------------------------------------------------

function olc_create_password($pass) 
{
  return md5($pass);
}

//--------------------------------------------------------------

function olc_remove_product($product_id) 
{
	     	global $LangID, $customers_status_array;  //R Brym
		    $product_image_query = olc_db_query("select products_image from " . TABLE_PRODUCTS . " where products_id = '" . olc_db_input($product_id) . "'");
		    $product_image = olc_db_fetch_array($product_image_query);
		
		    $duplicate_image_query = olc_db_query("select count(*) as total from " . TABLE_PRODUCTS . " where products_image = '" . olc_db_input($product_image['products_image']) . "'");
		    $duplicate_image = olc_db_fetch_array($duplicate_image_query);
		
		    if ($duplicate_image['total'] < 2) {
		      if (file_exists(DIR_FS_CATALOG_POPUP_IMAGES . $product_image['products_image'])) {
		        @unlink(DIR_FS_CATALOG_POPUP_IMAGES . $product_image['products_image']);
		      }
		      // START CHANGES
		      $image_subdir = BIG_IMAGE_SUBDIR;
		      if (substr($image_subdir, -1) != '/') $image_subdir .= '/';
		      if (file_exists(DIR_FS_CATALOG_IMAGES . $image_subdir . $product_image['products_image'])) {
		        @unlink(DIR_FS_CATALOG_IMAGES . $image_subdir . $product_image['products_image']);
		      }
		      // END CHANGES
		    }

		    olc_db_query(DELETE_FROM . TABLE_SPECIALS . " where products_id = '" . olc_db_input($product_id) . "'");
		    olc_db_query(DELETE_FROM . TABLE_PRODUCTS . " where products_id = '" . olc_db_input($product_id) . "'");
		    olc_db_query(DELETE_FROM . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . olc_db_input($product_id) . "'");
		    olc_db_query(DELETE_FROM . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . olc_db_input($product_id) . "'");
		    olc_db_query(DELETE_FROM . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . olc_db_input($product_id) . "'");
		    olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_BASKET . " where products_id = '" . olc_db_input($product_id) . "'");
		    olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where products_id = '" . olc_db_input($product_id) . "'");
		
		
		    // get statuses
		    $customers_statuses_array = array(array());
		
		    $customers_statuses_query = olc_db_query("select * from " . TABLE_CUSTOMERS_STATUS . " where language_id = '".$LangID."' order by customers_status_id");

          while ($customers_statuses = olc_db_fetch_array($customers_statuses_query)) {
              $customers_statuses_array[] = array('id' => $customers_statuses['customers_status_id'],
                                                 'text' => $customers_statuses['customers_status_name']);

          } 

          for ($i=0,$n=sizeof($customers_status_array);$i<$n;$i++) {
              olc_db_query("delete from personal_offers_by_customers_status_" . $i . " where products_id = '" . olc_db_input($product_id) . "'");
          }

          $product_reviews_query = olc_db_query("select reviews_id from " . TABLE_REVIEWS . " where products_id = '" . olc_db_input($product_id) . "'");
          while ($product_reviews = olc_db_fetch_array($product_reviews_query)) {
            olc_db_query(DELETE_FROM . TABLE_REVIEWS_DESCRIPTION . " where reviews_id = '" . $product_reviews['reviews_id'] . "'");
          }
          olc_db_query(DELETE_FROM . TABLE_REVIEWS . " where products_id = '" . olc_db_input($product_id) . "'");
}

//--------------------------------------------------------------

function ManufacturersImageUpload ()
{
  global $_GET, $_POST;
  
  if ($manufacturers_image = &olc_try_upload('manufacturers_image',DIR_FS_CATALOG.DIR_WS_IMAGES,'777', '', true)) 
  {
    $code = 0;
    $message = 'OK';
  } else {
    $code = -1;
    $message = 'UPLOAD FAILED';
  }
  print_xml_status ($code, $_POST['action'], $message, '', 'FILE_NAME', $manufacturers_image->filename);
}

//--------------------------------------------------------------

function CategoriesImageUpload ()
{
  global $_GET, $_POST;
  if ( $categories_image = &olc_try_upload('categories_image',DIR_FS_CATALOG.DIR_WS_IMAGES.'categories/','777', '', true)) 
  {
    $code = 0;
    $message = 'OK';
  } else {
    $code = -1;
    $message = 'UPLOAD FAILED';
  }        
  print_xml_status ($code, $_POST['action'], $message, '', 'FILE_NAME', $categories_image->filename);
}

//--------------------------------------------------------------

function ProductsImageUpload ()
{
  global $_GET, $_POST;
  if ($products_image = &olc_try_upload('products_image',DIR_FS_CATALOG.DIR_WS_ORIGINAL_IMAGES,'777', '', true)) 
  {
    $products_image_name = $products_image->filename;
    // rewrite values to use resample classes
    define('DIR_FS_CATALOG_ORIGINAL_IMAGES',DIR_FS_CATALOG.DIR_WS_ORIGINAL_IMAGES);
    define('DIR_FS_CATALOG_INFO_IMAGES',DIR_FS_CATALOG.DIR_WS_INFO_IMAGES);
    define('DIR_FS_CATALOG_POPUP_IMAGES',DIR_FS_CATALOG.DIR_WS_POPUP_IMAGES);
    define('DIR_FS_CATALOG_THUMBNAIL_IMAGES',DIR_FS_CATALOG.DIR_WS_THUMBNAIL_IMAGES);
    define('DIR_FS_CATALOG_IMAGES',DIR_FS_CATALOG.DIR_WS_IMAGES);
    
// generate resampled images if picture on the fly is OFF

$not_pictures_on_the_fly=PRODUCT_IMAGE_ON_THE_FLY<>TRUE_STRING_S;

if ($not_pictures_on_the_fly)
{	
    require(DIR_FS_DOCUMENT_ROOT.'admin/includes/product_thumbnail_images.php');
    require(DIR_FS_DOCUMENT_ROOT.'admin/includes/product_info_images.php');
    require(DIR_FS_DOCUMENT_ROOT.'admin/includes/product_popup_images.php');
}

    $code = 0;
    $message = 'OK';
  } else {
    $code = -1;
    $message = 'UPLOAD FAILED';
  }        
  print_xml_status ($code, $_POST['action'], $message, '', 'FILE_NAME', $products_image->filename);
}

//--------------------------------------------------------------

function ManufacturersUpdate ()
{
  global $_POST;
  
  $manufacturers_id = olc_db_prepare_input($_POST['mID']);

  if (isset($manufacturers_id))
  {
    // Hersteller laden
    $count_query = olc_db_query("select 
                                  manufacturers_id,
	                               manufacturers_name,
	                               manufacturers_image,
	                               date_added,
	                               last_modified from " . TABLE_MANUFACTURERS . "
	                               where manufacturers_id='" . $manufacturers_id . "'");
	
	 if ($manufacturer = olc_db_fetch_array($count_query))
	 {
      $exists = 1;
      // aktuelle Herstellerdaten laden
      $manufacturers_name  = $manufacturer['manufacturers_name'];
		$manufacturers_image = $manufacturer['manufacturers_image'];
		$date_added          = $manufacturer['date_added'];
		$last_modified       = $manufacturer['last_modified'];
    } 
    else $exists = 0; 
	
    // Variablen nur ueberschreiben wenn als Parameter vorhanden !!!
    if (isset($_POST['manufacturers_name'])) $manufacturers_name = olc_db_prepare_input($_POST['manufacturers_name']);
    if (isset($_POST['manufacturers_image'])) $manufacturers_image = olc_db_prepare_input($_POST['manufacturers_image']);
		        
    $sql_data_array = array('manufacturers_id' => $manufacturers_id,
	                         'manufacturers_name' => $manufacturers_name,
	                         'manufacturers_image' => $manufacturers_image);
	
    if ($exists==0) // Neuanlage (id wird von CAO virgegeben !!!)
    {
      $mode='APPEND';
      $insert_sql_data = array('date_added' => 'now()');
      $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

      olc_db_perform(TABLE_MANUFACTURERS, $sql_data_array);
      $products_id = mysql_insert_id();
    } 
    elseif ($exists==1) //Update
    {
      $mode='UPDATE';
      $update_sql_data = array('last_modified' => 'now()');
      $sql_data_array = array_merge($sql_data_array, $update_sql_data);

      olc_db_perform(TABLE_MANUFACTURERS, $sql_data_array, 'update', 'manufacturers_id = \'' . olc_db_input($manufacturers_id) . '\'');
    }
    $languages_query = olc_db_query("select languages_id, name, code, image, directory from " . TABLE_LANGUAGES . " order by sort_order");
    while ($languages = olc_db_fetch_array($languages_query)) 
    {
      $languages_array[] = array('id' => $languages['languages_id'],
	                              'name' => $languages['name'],
	                              'code' => $languages['code'],
	                              'image' => $languages['image'],
	                              'directory' => $languages['directory']);
    }
    $languages = $languages_array;
    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) 
    {
      $language_id = $languages[$i]['id'];
	
      // Bestehende Daten laden
      $desc_query = olc_db_query("select manufacturers_id,languages_id,manufacturers_url,url_clicked,date_last_click from " .
		                           TABLE_MANUFACTURERS_INFO . " where manufacturers_id='" . $manufacturers_id . "' and languages_id='" . $language_id . "'");
      if ($desc = olc_db_fetch_array($desc_query))
      {
        $manufacturers_url = $desc['manufacturers_url'];
        $url_clicked       = $desc['url_clicked'];
		  $date_last_click   = $desc['date_last_click'];
		}
		          
		// uebergebene Daten einsetzen
		if (isset($_POST['manufacturers_url'][$language_id])) $manufacturers_url=olc_db_prepare_input($_POST['manufacturers_url'][$language_id]);
		if (isset($_POST['url_clicked'][$language_id]))       $url_clicked=olc_db_prepare_input($_POST['url_clicked'][$language_id]);
		if (isset($_POST['date_last_click'][$language_id]))   $date_last_click=olc_db_prepare_input($_POST['date_last_click'][$language_id]);
			          
		$sql_data_array = array('manufacturers_url' => $manufacturers_url);
		          
		if ($exists==0) // Insert
		{
		  $insert_sql_data = array('manufacturers_id' => $products_id,
		                           'languages_id' => $language_id);
		  $sql_data_array = /*olc_*/array_merge($sql_data_array, $insert_sql_data);
		  olc_db_perform(TABLE_MANUFACTURERS_INFO, $sql_data_array);
		}
		elseif ($exists==1) // Update
		{
		  olc_db_perform(TABLE_MANUFACTURERS_INFO, $sql_data_array, 'update', 'manufacturers_id = \'' . olc_db_input($manufacturers_id) . '\' and languages_id = \'' . $language_id . '\'');
		}
    }
    print_xml_status (0, $_POST['action'], 'OK', $mode ,'MANUFACTURERS_ID', $mID);
  }
    else
  {
    print_xml_status (99, $_POST['action'], 'PARAMETER ERROR', '', '', '');
  }
}

//--------------------------------------------------------------

function ManufacturersErase ()
{
  global $_POST;
  
  $ManID  = olc_db_prepare_input($_POST['mID']);
			  
  if (isset($ManID))
  {
    // Hersteller loeschen
    olc_db_query(DELETE_FROM . TABLE_MANUFACTURERS . " where manufacturers_id = '" . (int)$ManID . "'");
    olc_db_query(DELETE_FROM . TABLE_MANUFACTURERS_INFO . " where manufacturers_id = '" . (int)$ManID . "'");
    // Herstellerverweis in den Artikeln loeschen
    olc_db_query(UPDATE . TABLE_PRODUCTS . " set manufacturers_id = '' where manufacturers_id = '" . (int)$ManID . "'");

    print_xml_status (0, $_POST['action'], 'OK', '', '', '');			  
  }
    else
  {
    print_xml_status (99, $_POST['action'], 'PARAMETER ERROR', '', '', '');
  }      
}

//--------------------------------------------------------------

function ProductsUpdate ()
{
  global $_POST, $LangID;
  
  $languages_query = olc_db_query("select languages_id, name, code, image, directory from " . TABLE_LANGUAGES . " order by sort_order");
  while ($languages = olc_db_fetch_array($languages_query)) 
  {
    $languages_array[] = array('id' => $languages['languages_id'],
                               'name' => $languages['name'],
                               'code' => $languages['code'],
                               'image' => $languages['image'],
                               'directory' => $languages['directory']);
  }
  $products_id = olc_db_prepare_input($_POST['pID']);

  // product laden
  $count_query = olc_db_query("select products_quantity,
	                            products_model,
	                            products_image,
	                            products_price,
	                            products_date_available,
	                            products_weight,
	                            products_status,
	                            products_ean,
	                            products_fsk18,
	                            products_shippingtime,
	                            products_tax_class_id,
	                            manufacturers_id from " . TABLE_PRODUCTS . "
	                            where products_id='" . $products_id . "'");
	
  if ($product = olc_db_fetch_array($count_query))
  {
    $exists = 1;
    // aktuelle Produktdaten laden
    $products_quantity = $product['products_quantity'];
    $products_model = $product['products_model'];
    $products_image = $product['products_image'];
    $products_price = $product['products_price'];
	 $products_date_available = $product['products_date_available'];
	 $products_weight = $product['products_weight'];
	 $products_status = $product['products_status'];
	 $products_ean = $product['products_ean'];
	 $products_fsk18 = $product['products_fsk18'];
	 $products_shippingtime = $product['products_shippingtime'];
	 $products_tax_class_id = $product['products_tax_class_id'];
	 $manufacturers_id = $product['manufacturers_id'];
  }
  else $exists = 0;
	
  // Variablen nur ueberschreiben wenn als Parameter vorhanden !!!
  if (isset($_POST['products_quantity'])) $products_quantity = olc_db_prepare_input($_POST['products_quantity']);
  if (isset($_POST['products_model'])) $products_model = olc_db_prepare_input($_POST['products_model']);
  if (isset($_POST['products_image'])) $products_image = olc_db_prepare_input($_POST['products_image']);
  if (isset($_POST['products_price'])) $products_price = olc_db_prepare_input($_POST['products_price']);
  if (isset($_POST['products_date_available'])) $products_date_available = olc_db_prepare_input($_POST['products_date_available']);
  if (isset($_POST['products_weight'])) $products_weight = olc_db_prepare_input($_POST['products_weight']);
  if (isset($_POST['products_status'])) $products_status = olc_db_prepare_input($_POST['products_status']);
  if (isset($_POST['products_ean'])) $products_ean = olc_db_prepare_input($_POST['products_ean']);
  if (isset($_POST['products_fsk18'])) $products_fsk18 = olc_db_prepare_input($_POST['products_fsk18']);
  if (isset($_POST['products_shippingtime'])) $products_shippingtime = olc_db_prepare_input($_POST['products_shippingtime']);
  if (isset($_POST['products_me'])) $products_vpe = olc_db_prepare_input($_POST['products_me']);
  if (isset($_POST['products_tax_class_id'])) $products_tax_class_id = olc_db_prepare_input($_POST['products_tax_class_id']);
			
  if (file_exists('cao_produpd_1.php')) { include('cao_produpd_1.php'); }
	
  // Comment: SWITCH_MWST nun an der richtigen Var. ; TKI 2005-08-24
  if (SWITCH_MWST==true) 
  {
    // switch IDs
    if ($products_tax_class_id==1) 
    { 
      $products_tax_class_id=2; 
    }
      else
    {
      if ($products_tax_class_id==2) 
      { 
        $products_tax_class_id=1; 
      }
    } 
  }
  
  if (isset($_POST['manufacturers_id'])) $manufacturers_id = olc_db_prepare_input($_POST['manufacturers_id']);

  $products_date_available = (date('Y-m-d') < $products_date_available) ? $products_date_available : 'null';
	
  $sql_data_array = array('products_id' => $products_id,
	                       'products_quantity' => $products_quantity,
	                       'products_model' => $products_model,
	                       'products_image' => ($products_image == 'none') ? '' : $products_image,
	                       'products_price' => $products_price,
	                       'products_date_available' => $products_date_available,
	                       'products_weight' => $products_weight,
	                       'products_status' => $products_status,
	                       'products_ean' => $products_ean,
	                       'products_fsk18' => $products_fsk18,
	                       'products_shippingtime' => $products_shippingtime,
	                       'products_tax_class_id' => $products_tax_class_id,
	                       'manufacturers_id' => $manufacturers_id);
										
  if ($exists==0) // Neuanlage (id wird an CAO zurueckgegeben !!!)
  {
    // set groupaccees
    
    $permission_sql = 'show columns from ' . TABLE_PRODUCTS . ' like "group_permission_%"';
    $permission_query = olc_db_query ($permission_sql);
    
    if (olc_db_num_rows($permission_query))
    {
      // ist OLC 3.0.4
      $permission_array = array ();
      while ($permissions = olc_db_fetch_array($permission_query))
      {
        $permission_array = array_merge($permission_array, array ($permissions['Field'] => '1'));
      }
      
      $insert_sql_data = array('products_date_added' => 'now()',
	                            'products_shippingtime'=>1);
	                            
      $insert_sql_data = array_merge($insert_sql_data, $permission_array);  
    }
      else
    {
      // OLC bis 3.0.3
      $customers_statuses_array = array(array());
      $customers_statuses_query = olc_db_query("select customers_status_id,
	                                             customers_status_name
	                                             from " . TABLE_CUSTOMERS_STATUS . "
	                                             where language_id = '".$LangID."' order by
	                                             customers_status_id");
      $i=1;        // this is changed from 0 to 1 in cs v1.2
      while ($customers_statuses = olc_db_fetch_array($customers_statuses_query))
      {
        $i=$customers_statuses['customers_status_id'];
        $customers_statuses_array[$i] = array('id' => $customers_statuses['customers_status_id'],
	                                           'text' => $customers_statuses['customers_status_name']);
      }
    
	   $group_ids='c_all_group,';
      for ($i=0;$n=sizeof($customers_statuses_array),$i<$n;$i++)
      {
        $group_ids .='c_'.$customers_statuses_array[$i]['id'].'_group,';
      }
	  	
      $insert_sql_data = array('products_date_added' => 'now()',
	                            'products_shippingtime'=>1,
	                            'group_ids'=>$group_ids);
	 }
	
    $mode='APPEND';

    $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
	
    // insert data
    olc_db_perform(TABLE_PRODUCTS, $sql_data_array);
	
    $products_id = mysql_insert_id();
	
  }
  elseif ($exists==1) //Update
  {
    $mode='UPDATE';
    $update_sql_data = array('products_last_modified' => 'now()');
    $sql_data_array = array_merge($sql_data_array, $update_sql_data);
	
    // update data
    olc_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', 'products_id = \'' . olc_db_input($products_id) . '\'');
  }

  $languages = $languages_array;
  for ($i = 0, $n = sizeof($languages); $i < $n; $i++)
  {
    $language_id = $languages[$i]['id'];
	
    // Bestehende Daten laden
    $desc_query = olc_db_query("select
	                             products_id,
	                             products_name,
	                             products_description,
	                             products_short_description,
	                             products_meta_title,
	                             products_meta_description,
	                             products_meta_keywords,
	                             products_url,
	                             products_viewed,
	                             language_id
	                             from " .
	                             TABLE_PRODUCTS_DESCRIPTION . "
	                             where products_id='" . $products_id . "'
	                             and language_id='" . $language_id . "'");
	
    if ($desc = olc_db_fetch_array($desc_query))
    {
      $products_name = $desc['products_name'];
      $products_description = $desc['products_description'];
      $products_short_description = $desc['products_short_description'];
      $products_meta_title = $desc['products_meta_title'];
      $products_meta_description = $desc['products_meta_description'];
      $products_meta_keywords = $desc['products_meta_keywords'];
      $products_url = $desc['products_url'];
    }

    // uebergebene Daten einsetzen
    if (isset($_POST['products_name'][$LangID]))              $products_name              = olc_db_prepare_input($_POST['products_name'][$LangID]);
    if (isset($_POST['products_description'][$LangID]))       $products_description       = olc_db_prepare_input($_POST['products_description'][$LangID]);
    if (isset($_POST['products_short_description'][$LangID])) $products_short_description = olc_db_prepare_input($_POST['products_short_description'][$LangID]);
    if (isset($_POST['products_meta_title'][$LangID]))        $products_meta_title        = olc_db_prepare_input($_POST['products_meta_title'][$LangID]);
    if (isset($_POST['products_meta_description'][$LangID]))  $products_meta_description  = olc_db_prepare_input($_POST['products_meta_description'][$LangID]);
    if (isset($_POST['products_meta_keywords'][$LangID]))     $products_meta_keywords     = olc_db_prepare_input($_POST['products_meta_keywords'][$LangID]);
    if (isset($_POST['products_url'][$LangID]))               $products_url               = olc_db_prepare_input($_POST['products_url'][$LangID]);
    
    //NEU 20051004 JP
    if (isset($_POST['products_shop_long_description'][$LangID]))  $products_description       = olc_db_prepare_input($_POST['products_shop_long_description'][$LangID]);
    if (isset($_POST['products_shop_short_description'][$LangID])) $products_short_description = olc_db_prepare_input($_POST['products_shop_short_description'][$LangID]);

    $sql_data_array = array('products_name' => $products_name,
                            'products_description' => $products_description,
                            'products_short_description' => $products_short_description,
                            'products_meta_title' => $products_meta_title,
                            'products_meta_description' => $products_meta_description,
                            'products_meta_keywords' => $products_meta_keywords,
                            'products_url' => $products_url);

    if ($exists==0) // Insert
    {
      $insert_sql_data = array('products_id' => $products_id,
                               'language_id' => $language_id);
	                                     
      $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
      olc_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array);
    }
    elseif (($exists==1)and($language_id==$LangID)) // Update
    {
      // Nur die Daten in der akt. Sprache aendern !
      olc_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array, 'update', 'products_id = \'' . olc_db_input($products_id) . '\' and language_id = \'' . $language_id . '\'');
    }
  }
  if (file_exists('cao_produpd_2.php')) { include('cao_produpd_2.php'); }

  print_xml_status (0, $_POST['action'], 'OK', $mode, 'PRODUCTS_ID', $products_id);
}

//--------------------------------------------------------------
 
function ProductsErase ()
{
  global $_POST;

  $ProdID  = olc_db_prepare_input($_POST['prodid']);
  if (isset($ProdID))
  {
    // ProductsToCategieries loeschen bei denen die products_id = ... ist
    $res1 = olc_db_query(DELETE_FROM . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id='" . $ProdID . "'");
	           
    // Product loeschen
    olc_remove_product($ProdID);
    $code = 0;
    $message = 'OK';
  }
    else
  {
    $code = 99;
    $message = 'FAILED';			   
  }
  print_xml_status (0, $_POST['action'], 'OK', '', 'SQL_RES1', $res1);
}

//--------------------------------------------------------------
 
function ProductsSpecialPriceUpdate ()
{
  global $_POST;
  
  $ProdID  = olc_db_prepare_input($_POST['prodid']);
		  
  $Price  = olc_db_prepare_input($_POST['price']);
  $Status = olc_db_prepare_input($_POST['status']);
  $Expire = olc_db_prepare_input($_POST['expired']);
		  
  if (isset($ProdID))
  {
    /*
    1. Ermitteln ob Produkt bereits einen Spezialpreis hat
    2. wenn JA -> Update / NEIN -> INSERT		    
    */
    $sp_sql = "select specials_id from " . TABLE_SPECIALS . " " .
              "where products_id='" . (int)$ProdID . "'";
    $sp_query = olc_db_query($sql);
		                 
    if ($sp = olc_db_fetch_array($sp_query))
    {
      // es existiert bereits ein Datensatz -> Update
      $SpecialID = $sp['specials_id'];
           
      olc_db_query(
              UPDATE . TABLE_SPECIALS . 
              " set specials_new_products_price = '" . $Price . "'," .
              " specials_last_modified = now()," . 
              " expires_date = '" . $Expire .
              "' where specials_id = '" . (int)$SpecialID. "'");
            
      print_xml_status (0, $_POST['action'], 'OK', 'UPDATE', '', '');
    }
      else
    {
      // Neuanlage
      olc_db_query(
              INSERT_INTO . TABLE_SPECIALS .
              " (products_id, specials_new_products_price, specials_date_added, expires_date, status) " .
              " values ('" . (int)$ProdID . "', '" . $Price . "', now(), '" . $Expire . "', '1')");
            
      print_xml_status (0, $_POST['action'], 'OK', 'APPEND', '', '');
    }
  }
    else
  {
    print_xml_status (99, $_POST['action'], 'PARAMETER ERROR', '', '', '');
  }
}

//--------------------------------------------------------------
 
function ProductsSpecialPriceErase ()
{
  global $_POST; 

  $ProdID  = olc_db_prepare_input($_POST['prodid']);
  if (isset($ProdID))
  {
    olc_db_query(DELETE_FROM . TABLE_SPECIALS . " where products_id = '" . (int)$ProdID . "'");
    print_xml_status (0, $_POST['action'], 'OK', '', '', '');
  }
    else
  {
    print_xml_status (99, $_POST['action'], 'PARAMETER ERROR', '', '', '');
  }
}

//--------------------------------------------------------------

function CategoriesUpdate ()
{
  global $_POST, $LangID;

  $CatID    = olc_db_prepare_input($_POST['catid']);
  $ParentID = olc_db_prepare_input($_POST['parentid']);
  
  if (isset($ParentID) && isset($CatID))
  {
    // product laden
    $SQL = "select categories_id, parent_id, date_added, sort_order, categories_image " .
           "from " . TABLE_CATEGORIES . " where categories_id='" . $CatID . "'";


    $count_query = olc_db_query($SQL);
    if ($categorie = olc_db_fetch_array($count_query))
    {
      $exists = 1;
    
      $ParentID = $categorie['parent_id'];
      $Sort     = $categorie['sort_order'];
      $Image    = $categorie['categories_image'];   
    } 
    else $exists = 0; 
        
    // Variablen nur ueberschreiben wenn als Parameter vorhanden !!!
    if (isset($_POST['parentid'])) $ParentID = olc_db_prepare_input($_POST['parentid']);
    if (isset($_POST['sort']))     $Sort     = olc_db_prepare_input($_POST['sort']);
    if (isset($_POST['image']))    $Image    = olc_db_prepare_input($_POST['image']);
  
  
    $sql_data_array = array('categories_id'    => $CatID,
                            'parent_id'        => $ParentID,
                            'sort_order'       => $Sort,
                            'categories_image' => $Image,
                            'last_modified'    => 'now()');
  
    if ($exists==0) // Neuanlage 
    {
      $mode='APPEND';
      
      // set groupaccees
      $permission_sql = 'show columns from ' . TABLE_CATEGORIES . ' like "group_permission_%"';
      $permission_query = olc_db_query ($permission_sql);
      
      if (olc_db_num_rows($permission_query))
      {
        // ist OLC 3.0.4
        $permission_array = array ();
        while ($permissions = olc_db_fetch_array($permission_query))
        {
          $permission_array = array_merge($permission_array, array ($permissions['Field'] => '1'));
        }
      
        $insert_sql_data = array('date_added' => 'now()');
	                            
        $insert_sql_data = array_merge($insert_sql_data, $permission_array);  
      }
        else
      {
        // OLC bis 3.0.3
        $customers_statuses_array = array(array());
        $customers_statuses_query = olc_db_query("select customers_status_id,
	                                               customers_status_name
	                                               from " . TABLE_CUSTOMERS_STATUS . "
	                                               where language_id = '".$LangID."' order by
	                                               customers_status_id");
        $i=1;        // this is changed from 0 to 1 in cs v1.2
        while ($customers_statuses = olc_db_fetch_array($customers_statuses_query)) 
        {
          $i=$customers_statuses['customers_status_id'];
          $customers_statuses_array[$i] = array('id' => $customers_statuses['customers_status_id'],
                                                'text' => $customers_statuses['customers_status_name']);
        }

        $group_ids='c_all_group,';
        for ($i=0;$n=sizeof($customers_statuses_array),$i<$n;$i++) 
        {
          $group_ids .='c_'.$customers_statuses_array[$i]['id'].'_group,';
        }
	     $insert_sql_data = array('date_added' => 'now()',
                                 'group_ids'  => $group_ids);
      }
                                          
      $sql_data_array = /*olc_*/array_merge($sql_data_array, $insert_sql_data);

      olc_db_perform(TABLE_CATEGORIES, $sql_data_array);
    } 
    elseif ($exists==1) //Update
    {
      $mode='UPDATE';

      olc_db_perform(TABLE_CATEGORIES, $sql_data_array, 'update', 'categories_id = \'' . olc_db_input($CatID) . '\'');
    }
        
    //$languages = olc_get_languages();
    
    $languages_query = olc_db_query("select languages_id, name, code, image, directory from " . TABLE_LANGUAGES . " order by sort_order");
    while ($languages = olc_db_fetch_array($languages_query)) 
    {
      $languages_array[] = array('id' => $languages['languages_id'],
                                 'name' => $languages['name'],
                                 'code' => $languages['code'],
                                 'image' => $languages['image'],
                                 'directory' => $languages['directory']);
    }
    
    $languages = $languages_array;
    
    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) 
    {
      $language_id = $languages[$i]['id'];
      
      // Bestehende Daten laden
      $SQL = "select categories_id,language_id,categories_name,categories_description,categories_heading_title,".
             "categories_meta_title,categories_meta_description,categories_meta_keywords";
	
      $desc_query = olc_db_query($SQL . " from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id='" . $CatID . "' and language_id='" . $language_id . "'");
      if ($desc = olc_db_fetch_array($desc_query))
      {
        $categories_name             = $desc['categories_name'];
        $categories_description      = $desc['$categories_description'];
        $categories_heading_title    = $desc['categories_heading_title'];
        $categories_meta_title       = $desc['categories_meta_title'];
        $categories_meta_description = $desc['categories_meta_description'];
        $categories_meta_keywords    = $desc['categories_meta_keywords'];
      }
        
      // uebergebene Daten einsetzen
      if (isset($_POST['name']))                        $categories_name             = olc_db_prepare_input(UrlDecode($_POST['name']));
      if (isset($_POST['descr']))                       $categories_description = olc_db_prepare_input(UrlDecode($_POST['descr']));
      if (isset($_POST['categories_heading_title']))    $categories_heading_title    = olc_db_prepare_input(UrlDecode($_POST['categories_heading_title']));  
      if (isset($_POST['categories_meta_title']))       $categories_meta_title       = olc_db_prepare_input(UrlDecode($_POST['categories_meta_title']));	  
	   if (isset($_POST['categories_meta_description'])) $categories_meta_description = olc_db_prepare_input(UrlDecode($_POST['categories_meta_description']));
	   if (isset($_POST['categories_meta_keywords']))    $categories_meta_keywords    = olc_db_prepare_input(UrlDecode($_POST['categories_meta_keywords']));    
	   
	   $sql_data_array = array('categories_name'             => $categories_name,
                              'categories_description'      => $categories_description,
	                           'categories_heading_title'    => $categories_heading_title,
	                           'categories_meta_title'       => $categories_meta_title,
	                           'categories_meta_description' => $categories_meta_description,
	                           'categories_meta_keywords'    => $categories_meta_keywords);

		if ($exists==0) // Insert
      {
        $insert_sql_data = array('categories_id' => $CatID,
                                 'language_id' => $language_id);
                                 
        $sql_data_array = /*olc_*/array_merge($sql_data_array, $insert_sql_data);
        olc_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_array);
      } 
      elseif (($exists==1)and($language_id==$LangID)) // Update
      {
        // Nur 1 Sprache aktualisieren
        olc_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_array, 'update', 'categories_id = \'' . olc_db_input($CatID) . '\' and language_id = \'' . $language_id . '\'');
      }
    }
    print_xml_status (0, $_POST['action'], 'OK', $mode, '', '');
  }
    else
  {
    print_xml_status (99, $_POST['action'], 'PARAMETER ERROR', '', '', '');
  }
}

//--------------------------------------------------------------

function CategoriesErase ()
{
  global $_POST;
  
  $CatID  = olc_db_prepare_input($_POST['catid']);

  if (isset($CatID))
  {
    // Categorie loeschen
    $res1 = olc_db_query(DELETE_FROM . TABLE_CATEGORIES . " where categories_id='" . $CatID . "'");
    // ProductsToCategieries loeschen bei denen die Categorie = ... ist
    $res2 = olc_db_query(DELETE_FROM . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id='" . $CatID . "'");
    // CategieriesDescription loeschenm bei denen die Categorie = ... ist
    $res3 = olc_db_query(DELETE_FROM . TABLE_CATEGORIES_DESCRIPTION . " where categories_id='" . $CatID . "'");

    print_xml_status (0, $_POST['action'], 'OK', '', 'SQL_RES1', $res1);
  }
    else
  {
    print_xml_status (99, $_POST['action'], 'PARAMETER ERROR', '', '', '');
  }
}

//--------------------------------------------------------------

function Prod2CatUpdate ()
{
  global $_POST;
  
  $ProdID = olc_db_prepare_input($_POST['prodid']);
  $CatID  = olc_db_prepare_input($_POST['catid']);
		  
  if (isset($ProdID) && isset($CatID))
  {
    $res = olc_db_query("replace into " . TABLE_PRODUCTS_TO_CATEGORIES . " (products_id, categories_id) Values ('" . $ProdID ."', '" . $CatID . "')");
    print_xml_status (0, $_POST['action'], 'OK', '', 'SQL_RES', $res);
  }
    else
  {
    print_xml_status (99, $_POST['action'], 'PARAMETER ERROR', '', '', '');
  }
}

//--------------------------------------------------------------

function Prod2CatErase ()
{
  global $_POST;
  
  $ProdID = olc_db_prepare_input($_POST['prodid']);
  $CatID  = olc_db_prepare_input($_POST['catid']);

  if (isset($ProdID) && isset($CatID))
  {
    $res = olc_db_query(DELETE_FROM . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id='" . $ProdID ."' and categories_id='" . $CatID . "'");
    print_xml_status (0, $_POST['action'], 'OK', '', 'SQL_RES', $res);
  }
    else
  {
    print_xml_status (99, $_POST['action'], 'PARAMETER ERROR', '', '', '');
  }
}

//--------------------------------------------------------------

function OrderUpdate ()
{
  global $_POST, $LangID;
  
  $schema = '<?xml version="1.0" encoding="' . CHARSET . '"?>' . NEW_LINE . NEW_LINE;
	        
  if ((isset($_POST['order_id'])) && (isset($_POST['status'])))
  {
    // Per Post übergebene Variablen
    $oID = $_POST['order_id'];
    $status = $_POST['status'];
    $comments = olc_db_prepare_input($_POST['comments']);
	
    //Status überprüfen
    $check_status_query = olc_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . olc_db_input($oID) . "'");
    if ($check_status = olc_db_fetch_array($check_status_query))
    {
      if ($check_status['orders_status'] != $status || $comments != '')
      {
        olc_db_query(UPDATE . TABLE_ORDERS . " set orders_status = '" . olc_db_input($status) . "', last_modified = now() where orders_id = '" . olc_db_input($oID) . "'");
        $customer_notified = '0';
        if ($_POST['notify'] == 'on')
        {
          // Falls eine Sprach id zur Order existiert die Emailbestätigung in dieser Sprache ausführen
          if (isset($check_status['orders_language_id']) && $check_status['orders_language_id'] > 0 ) 
          {
            $orders_status_query = olc_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . $check_status['orders_language_id'] . "'");
            if (olc_db_num_rows($orders_status_query) == 0) 
            {
              $orders_status_query = olc_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . $languages_id . "'");
            }
          } 
            else 
          {
            $orders_status_query = olc_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . $languages_id . "'");
          }
          $orders_statuses = array();
          $orders_status_array = array();
          while ($orders_status = olc_db_fetch_array($orders_status_query)) 
          {
            $orders_statuses[] = array('id' => $orders_status['orders_status_id'],
                                       'text' => $orders_status['orders_status_name']);
            $orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
          }
          // status query
          $orders_status_query = olc_db_query("select orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . $LangID . "' and orders_status_id='".$status."'");
          $o_status=olc_db_fetch_array($orders_status_query);
          $o_status=$o_status['orders_status_name'];
	
          //ok lets generate the html/txt mail from Template
          if ($_POST['notify_comments'] == 'on')
          {
            $notify_comments = sprintf(EMAIL_TEXT_COMMENTS_UPDATE, $comments) . "\n\n";
          } 
            else 
          {
            $comments='';
          }
	
          // require functionblock for mails
          require_once(DIR_WS_CLASSES.'class.phpmailer.php');
          require_once(DIR_FS_INC . 'olc_php_mail.inc.php');
          require_once(DIR_FS_INC . 'olc_add_tax.inc.php');
          require_once(DIR_FS_INC . 'olc_not_null.inc.php');
          require_once(DIR_FS_INC . 'changedataout.inc.php');
          require_once(DIR_FS_INC . 'olc_href_link.inc.php');
          require_once(DIR_FS_INC . 'olc_date_long.inc.php');
          require_once(DIR_FS_INC . 'olc_check_agent.inc.php');
          $smarty = new Smarty;
	
          $smarty->assign('language', $check_status['language']);
          $smarty->caching = false;
          $smarty->template_dir=DIR_FS_CATALOG.'templates';
          $smarty->compile_dir=DIR_FS_CATALOG.'cache/templates_c';
          $smarty->config_dir=DIR_FS_CATALOG.'lang';
          $smarty->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
          $smarty->assign('logo_path',HTTP_SERVER  . DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/images/');
          $smarty->assign('NAME',$check_status['customers_name']);
          $smarty->assign('ORDER_NR',$oID);
          $smarty->assign('ORDER_LINK',olc_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, 'SSL'));
          $smarty->assign('ORDER_DATE',olc_date_long($check_status['date_purchased']));
          $smarty->assign('NOTIFY_COMMENTS',$comments);
          $smarty->assign('ORDER_STATUS',$o_status);
	
          $html_mail=$smarty->fetch(CURRENT_TEMPLATE . '/admin/mail/'.$check_status['language'].'/change_order_mail.html');
          $txt_mail=$smarty->fetch(CURRENT_TEMPLATE . '/admin/mail/'.$check_status['language'].'/change_order_mail.txt');
	
          // send mail with html/txt template
          olc_php_mail(EMAIL_BILLING_ADDRESS,
                       EMAIL_BILLING_NAME ,
                       $check_status['customers_email_address'],
                       $check_status['customers_name'],
                       '',
                       EMAIL_BILLING_REPLY_ADDRESS,
                       EMAIL_BILLING_REPLY_ADDRESS_NAME,
                       '',
                       '',
                       EMAIL_BILLING_SUBJECT,
                       $html_mail ,
                       $txt_mail);
	
          $customer_notified = '1';
        }
        olc_db_query(INSERT_INTO . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values ('" . olc_db_input($oID) . "', '" . olc_db_input($status) . "', now(), '" . $customer_notified . "', '" . olc_db_input($comments)  . "')");
        $schema .= '<STATUS>' . NEW_LINE .
                   '<STATUS_DATA>' . NEW_LINE .
                   '<ORDER_ID>' . $oID . '</ORDER_ID>' . NEW_LINE .
                   '<ORDER_STATUS>' . $status . '</ORDER_STATUS>' . NEW_LINE .
                   '<ACTION>' . $_POST['action'] . '</ACTION>' . NEW_LINE .
                   '<CODE>' . '0' . '</CODE>' . NEW_LINE .
                   '<MESSAGE>' . 'OK' . '</MESSAGE>' . NEW_LINE . 
                   '</STATUS_DATA>' . NEW_LINE .
                   '</STATUS>' . NEW_LINE;
      } 
      else if ($check_status['orders_status'] == $status) 
      {
        // Status ist bereits gesetzt
        $schema .= '<STATUS>' . NEW_LINE .
                   '<STATUS_DATA>' . NEW_LINE .
                   '<ORDER_ID>' . $oID . '</ORDER_ID>' . NEW_LINE .
                   '<ORDER_STATUS>' . $status . '</ORDER_STATUS>' . NEW_LINE .
                   '<ACTION>' . $_POST['action'] . '</ACTION>' . NEW_LINE .
                   '<CODE>' . '1' . '</CODE>' . NEW_LINE .
                   '<MESSAGE>' . 'NO STATUS CHANGE' . '</MESSAGE>' . NEW_LINE . 
                   '</STATUS_DATA>' . NEW_LINE .
                   '</STATUS>' . NEW_LINE;
      }
    } 
      else           
    {
      // Fehler Order existiert nicht
      $schema .= '<STATUS>' . NEW_LINE .
                 '<STATUS_DATA>' . NEW_LINE .
                 '<ORDER_ID>' . $oID . '</ORDER_ID>' . NEW_LINE .
                 '<ACTION>' . $_POST['action'] . '</ACTION>' . NEW_LINE .
                 '<CODE>' . '2' . '</CODE>' . NEW_LINE .
                 '<MESSAGE>' . 'ORDER_ID NOT FOUND OR SET' . '</MESSAGE>' . NEW_LINE . 
                 '</STATUS_DATA>' . NEW_LINE .
                 '</STATUS>' . NEW_LINE;
    }
  } 
    else 
  {
    $schema = '<?xml version="1.0" encoding="' . CHARSET . '"?>' . NEW_LINE .
              '<STATUS>' . NEW_LINE .
              '<STATUS_DATA>' . NEW_LINE .
              '<ACTION>' . $_POST['action'] . '</ACTION>' . NEW_LINE .
              '<CODE>' . '99' . '</CODE>' . NEW_LINE .
              '<MESSAGE>' . 'PARAMETER ERROR' . '</MESSAGE>' . NEW_LINE . 
              '</STATUS_DATA>' . NEW_LINE .
              '</STATUS>' . "\n\n";
  }
  echo $schema; 
}

//--------------------------------------------------------------

function CustomersUpdate ()
{
  global $_POST, $Lang_folder;
  
  $customers_id = -1;
  // include PW function
  require_once(DIR_FS_INC . 'olc_encrypt_password.inc.php');
	
  if (isset($_POST['cID'])) $customers_id = olc_db_prepare_input($_POST['cID']);
	
  // security check, if user = admin, dont allow to perform changes
  if ($customers_id!=-1) 
  {
    $sec_query=olc_db_query("SELECT customers_status FROM ".TABLE_CUSTOMERS." where customers_id='".$customers_id."'");
    $sec_data=olc_db_fetch_array($sec_query);
    if ($sec_data['customers_status']==0) 
    {
      print_xml_status (120, $_POST['action'], 'CAN NOT CHANGE ADMIN USER!', '', '', '');
      return;
    }
  }
  $sql_customers_data_array = array();
  if (isset($_POST['customers_cid'])) $sql_customers_data_array['customers_cid'] = $_POST['customers_cid'];
  if (isset($_POST['customers_firstname'])) $sql_customers_data_array['customers_firstname'] = $_POST['customers_firstname'];
  if (isset($_POST['customers_lastname'])) $sql_customers_data_array['customers_lastname'] = $_POST['customers_lastname'];
  if (isset($_POST['customers_dob'])) $sql_customers_data_array['customers_dob'] = $_POST['customers_dob'];
  if (isset($_POST['customers_email'])) $sql_customers_data_array['customers_email_address'] = $_POST['customers_email'];
  if (isset($_POST['customers_tele'])) $sql_customers_data_array['customers_telephone'] = $_POST['customers_tele'];
  if (isset($_POST['customers_fax'])) $sql_customers_data_array['customers_fax'] = $_POST['customers_fax'];
  if (isset($_POST['customers_gender'])) $sql_customers_data_array['customers_gender'] = $_POST['customers_gender'];
  if (isset($_POST['customers_password'])) 
  {
    $sql_customers_data_array['customers_password'] = olc_encrypt_password($_POST['customers_password']);
  }
  $sql_address_data_array =array();
  if (isset($_POST['customers_firstname'])) $sql_address_data_array['entry_firstname'] = $_POST['customers_firstname'];
  if (isset($_POST['customers_lastname'])) $sql_address_data_array['entry_lastname'] = $_POST['customers_lastname'];
  if (isset($_POST['customers_company'])) $sql_address_data_array['entry_company'] = $_POST['customers_company'];
  if (isset($_POST['customers_street'])) $sql_address_data_array['entry_street_address'] = $_POST['customers_street'];
  if (isset($_POST['customers_city'])) $sql_address_data_array['entry_city'] = $_POST['customers_city'];
  if (isset($_POST['customers_postcode'])) $sql_address_data_array['entry_postcode'] = $_POST['customers_postcode'];
  if (isset($_POST['customers_gender'])) $sql_address_data_array['entry_gender'] = $_POST['customers_gender'];
  if (isset($_POST['customers_country_id'])) $country_code = $_POST['customers_country_id'];
  
  $country_query = "SELECT countries_id FROM ".TABLE_COUNTRIES." WHERE countries_iso_code_2 = '".$country_code ."' LIMIT 1";
  $country_result = olc_db_query($country_query);
  $row = olc_db_fetch_array($country_result);
  $sql_address_data_array['entry_country_id'] = $row['countries_id'];
	
  $count_query = olc_db_query("SELECT count(*) as count FROM " . TABLE_CUSTOMERS . " WHERE customers_id='" . (int)$customers_id . "' LIMIT 1");
  $check = olc_db_fetch_array($count_query);

  if ($check['count'] > 0) 
  {
    $mode = 'UPDATE';
    $address_book_result = olc_db_query("SELECT customers_default_address_id FROM ".TABLE_CUSTOMERS." WHERE customers_id = '". (int)$customers_id ."' LIMIT 1");
    $customer = olc_db_fetch_array($address_book_result);
    olc_db_perform(TABLE_CUSTOMERS, $sql_customers_data_array, 'update', "customers_id = '" . olc_db_input($customers_id) . "' LIMIT 1");
    olc_db_perform(TABLE_ADDRESS_BOOK, $sql_address_data_array, 'update', "customers_id = '" . olc_db_input($customers_id) . "' AND address_book_id = '".$customer['customers_default_address_id']."' LIMIT 1");
    olc_db_query(UPDATE . TABLE_CUSTOMERS_INFO . " set customers_info_date_account_last_modified = now() where customers_info_id = '" . (int)$customers_id . "'  LIMIT 1");
  }  
    else 
  {
    $mode= 'APPEND';
    if (strlen($_POST['customers_password'])==0)
    {
      // generate PW if empty
      $pw=olc_RandomString(8);
      $sql_customers_data_array['customers_password']=olc_create_password($pw);
    }				
    olc_db_perform(TABLE_CUSTOMERS, $sql_customers_data_array);
    $customers_id = olc_db_insert_id();
    $sql_address_data_array['customers_id'] = $customers_id;
    olc_db_perform(TABLE_ADDRESS_BOOK, $sql_address_data_array);
    $address_id = olc_db_insert_id();
    olc_db_query(UPDATE . TABLE_CUSTOMERS . " set customers_default_address_id = '" . (int)$address_id . "' where customers_id = '" . (int)$customers_id . "'");
    olc_db_query(UPDATE . TABLE_CUSTOMERS . " set customers_status = '" . STANDARD_GROUP . "' where customers_id = '" . (int)$customers_id . "'");
    olc_db_query(INSERT_INTO . TABLE_CUSTOMERS_INFO . " (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('" . (int)$customers_id . "', '0', now())");
  }

  if (SEND_ACCOUNT_MAIL==true && $mode=='APPEND' && $sql_customers_data_array['customers_email_address']!='') 
  {
    // generate mail for customer if customer=new
    require_once(DIR_WS_CLASSES.'class.phpmailer.php');
    require_once(DIR_FS_INC . 'olc_php_mail.inc.php');
    require_once(DIR_FS_INC . 'olc_add_tax.inc.php');
    require_once(DIR_FS_INC . 'olc_not_null.inc.php');
    require_once(DIR_FS_INC . 'changedataout.inc.php');
    require_once(DIR_FS_INC . 'olc_href_link.inc.php');
    require_once(DIR_FS_INC . 'olc_date_long.inc.php');
    require_once(DIR_FS_INC . 'olc_check_agent.inc.php');

    $smarty = new Smarty;
	
    //$smarty->assign('language', $check_status['language']);
    $smarty->assign('language', $Lang_folder);
    
    $smarty->caching = false;
    $smarty->template_dir=DIR_FS_CATALOG.'templates';
    $smarty->compile_dir=DIR_FS_CATALOG.'cache/templates_c';
    $smarty->config_dir=DIR_FS_CATALOG.'lang';
    $smarty->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
    $smarty->assign('logo_path',HTTP_SERVER  . DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/images/');
    $smarty->assign('NAME',$sql_customers_data_array['customers_lastname'] . ' ' . $sql_customers_data_array['customers_firstname']);
    $smarty->assign('EMAIL',$sql_customers_data_array['customers_email_address']);
    $smarty->assign('PASSWORD',$pw);
    //$smarty->assign('language', $Lang_folder);
    $smarty->assign('content', $module_content);
    $smarty->caching = false;
	
    $html_mail=$smarty->fetch(CURRENT_TEMPLATE . '/admin/mail/'.$Lang_folder.'/create_account_mail.html');
    $txt_mail=$smarty->fetch(CURRENT_TEMPLATE . '/admin/mail/'.$Lang_folder.'/create_account_mail.txt');
	
    // send mail with html/txt template
    olc_php_mail(
      EMAIL_SUPPORT_ADDRESS,
      EMAIL_SUPPORT_NAME ,
      $sql_customers_data_array['customers_email_address'],
      $sql_customers_data_array['customers_lastname'] . ' ' . $sql_customers_data_array['customers_firstname'],
      '',
      EMAIL_SUPPORT_REPLY_ADDRESS,
      EMAIL_SUPPORT_REPLY_ADDRESS_NAME,
      '',
      '',
      EMAIL_SUPPORT_SUBJECT,
      $html_mail ,
      $txt_mail);
  }
  print_xml_status (0, $_POST['action'], 'OK', $mode, 'CUSTOMERS_ID', $customers_id);
}

//--------------------------------------------------------------

function CustomersErase ()
{
  global $_POST;
  
  $cID  = olc_db_prepare_input($_POST['cID']);

  $sec_query=olc_db_query("SELECT customers_status FROM ".TABLE_CUSTOMERS." where customers_id='".$cID."'");
  $sec_data=olc_db_fetch_array($sec_query);
  if ($sec_data['customers_status']==0) 
  {
    print_xml_status (120, $_POST['action'], 'CAN NOT CHANGE ADMIN USER!', '', '', '');
    return;
  }
  if (isset($cID)) 
  {
    olc_db_query(UPDATE . TABLE_REVIEWS . " set customers_id = null where customers_id = '" .  $cID . "'");
    olc_db_query(DELETE_FROM . TABLE_ADDRESS_BOOK . " where customers_id = '" . $cID . "'");
    olc_db_query(DELETE_FROM . TABLE_CUSTOMERS . " where customers_id = '" .$cID . "'");
    olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . $cID. "'");
    olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_BASKET . " where customers_id = '" . $cID . "'");
    olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where customers_id = '" . $cID . "'");
    olc_db_query(DELETE_FROM . TABLE_WHOS_ONLINE . " where customer_id = '" . $cID . "'");
	
    print_xml_status (0, $_POST['action'], 'OK', '', 'SQL_RES1', $res1);
  } 
    else 
  {
    print_xml_status (99, $_POST['action'], 'PARAMETER ERROR', '', '', '');
  }
}

//--------------------------------------------------------------
//                     Ende Funktionen 
//-------------------------------------------------------------- 




  $table_has_products_image_medium = true;
  $table_has_products_image_large = false;
  
  $images_query = olc_db_query(' SHOW COLUMNS FROM '.TABLE_PRODUCTS);
  while($column = olc_db_fetch_array($images_query)) {
        if ($column['Field'] == 'products_image_medium') {
          $table_has_products_image_medium = true;
        }
        if ($column['Field'] == 'products_image_large') {
          $table_has_products_image_large = true;
        }
  }
  if ($table_has_products_image_medium && $table_has_products_image_large) {
      define('DREI_PRODUKTBILDER', true);
  } else {
      define('DREI_PRODUKTBILDER', false);
  }


  if (LOGGER==true) 
  {
		// log data into db.
	
		$pdata ='';
		while (list($key, $value) = each($_POST))
		{
	   	if (is_array($value))
	   	{
	   	  while (list($key1, $value1) = each($value))
	        {
	   	    $pdata .= addslashes($key)."[" . addslashes($key1)."] => ".addslashes($value1)."\\r\\n";    	
	   	  }
	   	} 
	   	  else
	   	{
	   	  $pdata .= addslashes($key)." => ".addslashes($value)."\\r\\n";
	   	}
		} 
	
		$gdata ='';
		while (list($key, $value) = each($_GET))
		{
	   	$gdata .= addslashes($key)." => ".addslashes($value)."\\r\\n";
		} 

olc_db_query("INSERT INTO " . TABLE_PREFIX ."cao_log
	              (date,user,pw,method,action,post_data,get_data) VALUES
	              (NOW(),'".$user."','".$password."','".$REQUEST_METHOD."','".$_POST['action']."','".$pdata."','".$gdata."')");
	}	
	
	
//-------------------------------------------------------------------------------------------------------
//
//-------------------------------------------------------------------------------------------------------

  require_once(DIR_FS_INC . 'olc_not_null.inc.php');
  require_once(DIR_FS_INC . 'olc_redirect.inc.php');
  require_once(DIR_FS_INC . 'olc_rand.inc.php');
  
  //----------------------------------------------------------------------------
  class upload {
    var $file, $filename, $destination, $permissions, $extensions, $tmp_filename;

    function upload($file = '', $destination = '', $permissions = '777', $extensions = '') {

      $this->set_file($file);
      $this->set_destination($destination);
      $this->set_permissions($permissions);
      $this->set_extensions($extensions);

      if (olc_not_null($this->file) && olc_not_null($this->destination)) {
        if ( ($this->parse() == true) && ($this->save() == true) ) {
          return true;
        } else {
          return false;
        }
      }
    }
  //----------------------------------------------------------------------------		
    function parse() {
      global $messageStack;
      if (isset($_FILES[$this->file])) {
        $file = array('name' => $_FILES[$this->file]['name'],
                      'type' => $_FILES[$this->file]['type'],
                      'size' => $_FILES[$this->file]['size'],
                      'tmp_name' => $_FILES[$this->file]['tmp_name']);
      } elseif (isset($_FILES[$this->file])) {

        $file = array('name' => $_FILES[$this->file]['name'],
                      'type' => $_FILES[$this->file]['type'],
                      'size' => $_FILES[$this->file]['size'],
                      'tmp_name' => $_FILES[$this->file]['tmp_name']);
      } else {
        $file = array('name' => $GLOBALS[$this->file . '_name'],
                      'type' => $GLOBALS[$this->file . '_type'],
                      'size' => $GLOBALS[$this->file . '_size'],
                      'tmp_name' => $GLOBALS[$this->file]);
      }

      if ( olc_not_null($file['tmp_name']) && ($file['tmp_name'] != 'none') && is_uploaded_file($file['tmp_name']) ) {
        if (sizeof($this->extensions) > 0) {
          if (!in_array(strtolower(substr($file['name'], strrpos($file['name'], '.')+1)), $this->extensions)) {
            //$messageStack->add_session(ERROR_FILETYPE_NOT_ALLOWED, 'error');

            return false;
          }
        }

        $this->set_file($file);
        $this->set_filename($file['name']);
        $this->set_tmp_filename($file['tmp_name']);

        return $this->check_destination();
      } else {

             //if ($file['tmp_name']=='none') $messageStack->add_session(WARNING_NO_FILE_UPLOADED, 'warning');
        return false;
      }
    }
  //----------------------------------------------------------------------------
    function save() {
      global $messageStack;

      if (substr($this->destination, -1) != '/') $this->destination .= '/';

      // GDlib check
      if (!function_exists(imagecreatefromgif)) {

        // check if uploaded file = gif
        if ($this->destination==DIR_FS_CATALOG_ORIGINAL_IMAGES) {
            // check if merge image is defined .gif
            if (strstr(PRODUCT_IMAGE_THUMBNAIL_MERGE,'.gif') ||
                strstr(PRODUCT_IMAGE_INFO_MERGE,'.gif') ||
                strstr(PRODUCT_IMAGE_POPUP_MERGE,'.gif')) {

                //$messageStack->add_session(ERROR_GIF_MERGE, 'error');
                return false;

            }
            // check if uploaded image = .gif
            if (strstr($this->filename,'.gif')) {
             //$messageStack->add_session(ERROR_GIF_UPLOAD, 'error');
             return false;
            }

        }

      }

      if (move_uploaded_file($this->file['tmp_name'], $this->destination . $this->filename)) {
        chmod($this->destination . $this->filename, $this->permissions);

        //$messageStack->add_session(SUCCESS_FILE_SAVED_SUCCESSFULLY, 'success');

        return true;
      } else {
        //$messageStack->add_session(ERROR_FILE_NOT_SAVED, 'error');

        return false;
      }
    }
  //----------------------------------------------------------------------------
    function set_file($file) {
      $this->file = $file;
    }
  //----------------------------------------------------------------------------
    function set_destination($destination) {
      $this->destination = $destination;
    }
  //----------------------------------------------------------------------------
    function set_permissions($permissions) {
      $this->permissions = octdec($permissions);
    }
  //----------------------------------------------------------------------------
    function set_filename($filename) {
      $this->filename = $filename;
    }
  //----------------------------------------------------------------------------
    function set_tmp_filename($filename) {
      $this->tmp_filename = $filename;
    }
  //----------------------------------------------------------------------------
    function set_extensions($extensions) {
      if (olc_not_null($extensions)) {
        if (is_array($extensions)) {
          $this->extensions = $extensions;
        } else {
          $this->extensions = array($extensions);
        }
      } else {
        $this->extensions = array();
      }
    }
  //----------------------------------------------------------------------------
    function check_destination() {
      global $messageStack;

      if (!is_writeable($this->destination)) {
        if (is_dir($this->destination)) {
          //$messageStack->add_session(sprintf(ERROR_DESTINATION_NOT_WRITEABLE, $this->destination), 'error');
        } else {
          //$messageStack->add_session(sprintf(ERROR_DESTINATION_DOES_NOT_EXIST, $this->destination), 'error');
        }

        return false;
      } else {
        return true;
      }
    }
  }
?>