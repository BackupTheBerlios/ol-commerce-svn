<?php
/* -----------------------------------------------------------------------------------------
   $Id: graduated_prices.php,v 1.1.1.1.2.1 2007/04/08 07:17:59 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com
   (c) 2003	    nextcommerce (graduated_prices.php,v 1.11 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
olc_smarty_init($module_smarty,$cacheid);
$module_content=array();
  // include needed functions
  require_once(DIR_FS_INC.'olc_format_price_graduated.inc.php');

  $staffel_query = olc_db_query("SELECT
                                     quantity,
                                     personal_offer
                                     FROM
                                     ".TABLE_PERSONAL_OFFERS_BY_CUSTOMERS_STATUS . CUSTOMER_STATUS_ID . "
                                     WHERE
                                     products_id = '" . (int)$_GET['products_id'] . "'
                                     ORDER BY quantity ASC");
  $staffel_data = array();
  $staffel=array();
  $i='';
  while ($staffel_values = olc_db_fetch_array($staffel_query)) {
  $staffel[]=array('stk'=>$staffel_values['quantity'],
                    'price'=>$staffel_values['personal_offer']);
  }

  for ($i=0,$n=sizeof($staffel); $i<$n; $i++) {
  if ($staffel[$i]['stk'] == 1) {
        $quantity= $staffel[$i]['stk'];
        if ($staffel[$i+1]['stk']!='') $quantity= $staffel[$i]['stk'].'-'.($staffel[$i+1]['stk']-1);
      } else {
         $quantity= ' > '.$staffel[$i]['stk'];
         if ($staffel[$i+1]['stk']!='') $quantity= $staffel[$i]['stk'].'-'.($staffel[$i+1]['stk']-1);
      }
  $staffel_data[$i] = array(
    'QUANTITY' => $quantity,
    'PRICE' => olc_format_price_graduated($staffel[$i]['price'], $price_special=1, $calculate_currencies=true, 
    	$tax_class=$product_info['products_tax_class_id']));
  }
if (sizeof($staffel_data)>1) {
  $module_smarty->assign('language', SESSION_LANGUAGE);
  $module_smarty->assign(MODULE_CONTENT,$staffel_data);
  $module= $module_smarty->fetch(CURRENT_TEMPLATE_MODULE . 'graduated_price'.HTML_EXT,$cacheid);
  $info_smarty->assign('MODULE_graduated_price',$module);
 };
?>