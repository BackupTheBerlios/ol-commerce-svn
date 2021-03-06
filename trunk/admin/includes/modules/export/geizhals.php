<?php
/* -----------------------------------------------------------------------------------------
   $Id: geizhals.php,v 1.1.1.1 2006/12/22 13:39:09 gswkaiser Exp $

   OL-Commerce Version 2.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(cod.php,v 1.28 2003/02/14); www.oscommerce.com
   (c) 2003	    nextcommerce (invoice.php,v 1.6 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


define('MODULE_GEIZHALS_TEXT_DESCRIPTION', 'Export - Geizhals (; getrennt)<br/><b>Format:</b><br/>Artikelnr;Hersteller;Bezeichnung;Preis; Verf�gbarkeit;deeplink;optionale Beschreibung');
define('MODULE_GEIZHALS_TEXT_TITLE', 'Geizhals - CSV');
define('MODULE_GEIZHALS_FILE_TITLE' , '<hr noshade="noshade"/>Dateiname');
define('MODULE_GEIZHALS_FILE_DESC' , 'Geben Sie einen Dateinamen ein, falls die Exportadatei am Server gespeichert werden soll.<br/>(Verzeichnis export/)');
define('MODULE_GEIZHALS_STATUS_DESC','Modulstatus');
define('MODULE_GEIZHALS_STATUS_TITLE','Status');
define('MODULE_GEIZHALS_CURRENCY_TITLE','W�hrung');
define('MODULE_GEIZHALS_CURRENCY_DESC','Welche W�hrung soll exportiert werden?');
define('EXPORT_YES','Nur Herunterladen');
define('EXPORT_NO','Am Server Speichern');
define('CURRENCY','<hr noshade="noshade"/><b>W�hrung:</b>');
define('CURRENCY_DESC','W�hrung in der Exportdatei');
define('EXPORT','Bitte den Sicherungsprozess AUF KEINEN FALL unterbrechen. Dieser kann einige Minuten in Anspruch nehmen.');
define('EXPORT_TYPE','<hr noshade="noshade"/><b>Speicherart:</b>');
define('EXPORT_STATUS_TYPE','<hr noshade="noshade"/><b>Kundengruppe:</b>');
define('EXPORT_STATUS','Bitte w�hlen Sie die Kundengruppe, die Basis f�r den Exportierten Preis bildet. (Falls Sie keine Kundengruppenpreise haben, w�hlen Sie <i>Gast</i>):</b>');

// include needed functions


  class geizhals {
    var $code, $title, $description, $enabled;


    function geizhals() {
      global $order;

      $this->code = 'geizhals';
      $this->title = MODULE_GEIZHALS_TEXT_TITLE;
      $this->description = MODULE_GEIZHALS_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_GEIZHALS_SORT_ORDER;
      $this->enabled = ((MODULE_GEIZHALS_STATUS == TRUE_STRING_S) ? true : false);

    }


    function process($file) {

        @olc_set_time_limit(0);
        $schema = 'Artikelnr;Hersteller;Bezeichnung;Preis;Verf�gbarkeit;deeplink;optionale Beschreibung' . NEW_LINE;
        $export_query =olc_db_query("SELECT
                             p.products_id,
                             pd.products_name,
                             pd.products_description,
                             p.products_model,
                             p.products_shippingtime,
                             p.products_image,
                             p.products_price,
                             p.products_status,
                             p.products_discount_allowed,
                             p.products_tax_class_id,
                             p.products_date_added,
                             m.manufacturers_name
														FROM
														" . TABLE_PRODUCTS . " p LEFT JOIN
														" . TABLE_MANUFACTURERS . " m
														ON p.manufacturers_id = m.manufacturers_id LEFT JOIN
														" . TABLE_PRODUCTS_DESCRIPTION . " pd
														ON p.products_id = pd.products_id AND
														pd.language_id = '".SESSION_LANGUAGE_ID."' LEFT JOIN
														" . TABLE_SPECIALS . " s
														ON p.products_id = s.products_id
														WHERE
														p.products_status = 1
														ORDER BY
														p.products_date_added DESC,
														pd.products_name");


        while ($products = olc_db_fetch_array($export_query)) {

            $products_price =  olc_get_products_price_export($products['products_id'],1,true,$_POST['status'],1,$_POST['currencies'],true);

            // remove trash
            $products_description = strip_tags($products['products_description']);
            $products_description = substr($products_description, 0, 197) . '..';
             $products_description = str_replace(";",", ",$products_description);
            $products_description = str_replace(APOS,", ",$products_description);
            $products_description = str_replace(NEW_LINE,BLANK,$products_description);
            $products_description = str_replace("\r",BLANK,$products_description);
            $products_description = str_replace("\t",BLANK,$products_description);
            $products_description = str_replace("\v",BLANK,$products_description);
            $products_description = str_replace("&quot,"," \"",$products_description);
            $products_description = str_replace("&qout,"," \"",$products_description);

            //create content
            $schema .=
                       $products['products_model'] . ';' .
                       $products['manufacturers_name'] .';'.
                       $products['products_name'] . ';' .
                       $products_price. ';' .
                       olc_get_shipping_status_name($products['products_shippingtime']). ';' .
                       HTTP_CATALOG_SERVER . DIR_WS_CATALOG . 'product_info.php?products_id=' . $products['products_id'] . ';' .
                       $products_description . NEW_LINE;


        }
        // create File
          $fp = fopen(DIR_FS_DOCUMENT_ROOT.'export/' . $file, "w+");
          fputs($fp, $schema);
          fclose($fp);


      switch ($_POST['export']) {
        case 'yes':
            // send File to Browser
            $extension = substr($file, -3);
            $fp = fopen(DIR_FS_DOCUMENT_ROOT.'export/' . $file,"rb");
            $buffer = fread($fp, filesize(DIR_FS_DOCUMENT_ROOT.'export/' . $file));
            fclose($fp);
            header('Content-type: application/x-octet-stream');
            header('Content-disposition: attachment; filename=' . $file);
            echo $buffer;
            exit;

        break;
        }

    }

    function display() {

    $customers_statuses_array = olc_get_customers_statuses();

    // build Currency Select
    $curr='';
    $currencies=olc_db_query("SELECT code FROM ".TABLE_CURRENCIES);
    while ($currencies_data=olc_db_fetch_array($currencies)) {
     $curr.=olc_draw_radio_field('currencies', $currencies_data['code'],true).$currencies_data['code'].HTML_BR;
    }

    return array('text' =>  EXPORT_STATUS_TYPE.HTML_BR.
                          	EXPORT_STATUS.HTML_BR.
                          	olc_draw_pull_down_menu('status',$customers_statuses_array, '1').HTML_BR.
                            CURRENCY.HTML_BR.
                            CURRENCY_DESC.HTML_BR.
                            $curr.
                            EXPORT_TYPE.HTML_BR.
                            EXPORT.HTML_BR.
                          	olc_draw_radio_field('export', 'no',false).EXPORT_NO.HTML_BR.
                            olc_draw_radio_field('export', 'yes',true).EXPORT_YES.HTML_BR.
                            HTML_BR . olc_image_submit('button_export.gif', IMAGE_UPDATE) .

                            HTML_A_START . olc_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=geizhals') . '">' .
                            olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);


    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_GEIZHALS_STATUS'");
        $this->_check = olc_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_GEIZHALS_FILE', 'geizhals.csv',  '6', '1', '', now())");
      olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_GEIZHALS_STATUS', 'true',  '6', '1', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())");
}

    function remove() {
      olc_db_query(DELETE_FROM . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_GEIZHALS_STATUS','MODULE_GEIZHALS_FILE');
    }

  }
?>