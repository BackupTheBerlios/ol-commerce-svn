<?php
/* -----------------------------------------------------------------------------------------
   $Id: image_processing.php,v 1.1.1.1 2006/12/22 13:39:09 gswkaiser Exp $

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

define('MODULE_IMAGE_PROCESS_TEXT_DESCRIPTION', 'OL-Commerce Imageprocessing - Stapelverarbeitung für Bildbearbeitung');
define('MODULE_IMAGE_PROCESS_TEXT_TITLE', 'OL-Imageprocessing');
define('MODULE_IMAGE_PROCESS_STATUS_DESC','Modulstatus');
define('MODULE_IMAGE_PROCESS_STATUS_TITLE','Status');
define('IMAGE_EXPORT','Drücken Sie Ok um die Stapelverarbeitung zu starten, dieser Vorgang kann einige Zeit dauern, auf keinen Fall unterbrechen!.');
define('IMAGE_EXPORT_TYPE','<hr noshade="noshade"/><b>Stapelverarbeitung:</b>');

  class image_processing {
    var $code, $title, $description, $enabled;


    function image_processing() {
      global $order;

      $this->code = 'image_processing';
      $this->title = MODULE_IMAGE_PROCESS_TEXT_TITLE;
      $this->description = MODULE_IMAGE_PROCESS_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_IMAGE_PROCESS_SORT_ORDER;
      $this->enabled = ((MODULE_IMAGE_PROCESS_STATUS == TRUE_STRING_S) ? true : false);

    }


    function process($file) {
         // include needed functions
require_once('includes/classes/image_manipulator.php');
        @olc_set_time_limit(0);

        // action
        // get images in original_images folder
        $files=array();

        if ($dir= opendir(DIR_FS_CATALOG_ORIGINAL_IMAGES)){
            while  (($file = readdir($dir)) !==false) {
                     if (is_file(DIR_FS_CATALOG_ORIGINAL_IMAGES.$file) and ($file !="index.html")){
                         $files[]=array(
                                        'id' => $file,
                                        'text' =>$file);
                     }
             }
        closedir($dir);
        }
        for ($i=0;$n=sizeof($files),$i<$n;$i++) {

          $products_image_name = $files[$i]['text'];

  		 require(DIR_WS_INCLUDES . 'product_thumbnail_images.php');
           require(DIR_WS_INCLUDES . 'product_info_images.php');
           require(DIR_WS_INCLUDES . 'product_popup_images.php');

         }

    }

    function display() {


    return array('text' =>
                            IMAGE_EXPORT_TYPE.HTML_BR.
                            IMAGE_EXPORT.HTML_BR.
                            HTML_BR . olc_image_submit('button_review_approve.gif', IMAGE_UPDATE) .

                            HTML_A_START . olc_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=image_processing') . '">' .
                            olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);


    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_IMAGE_PROCESS_STATUS'");
        $this->_check = olc_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_IMAGE_PROCESS_STATUS', 'true',  '6', '1', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())");
}

    function remove() {
      olc_db_query(DELETE_FROM . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_IMAGE_PROCESS_STATUS');
    }

  }
?>