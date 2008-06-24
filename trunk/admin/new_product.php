<?php
/* --------------------------------------------------------------
$Id: new_product.php,v 1.1.1.2.2.1 2007/04/08 07:16:30 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(categories.php,v 1.140 2003/03/24); www.oscommerce.com
(c) 2003  nextcommerce (categories.php,v 1.37 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------
Third Party contribution:
Enable_Disable_Categories 1.3               Autor: Mikel Williams | mikel@ladykatcostumes.com
New Attribute Manager v4b                   Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
Category Descriptions (Version: 1.5 MS2)    Original Author:   Brian Lowe <blowe@wpcusrgrp.org> | Editor: Lord Illicious <shaolin-venoms@illicious.net>
Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

Released under the GNU General Public License
--------------------------------------------------------------*/

$pID=$_GET['pID'];
$is_post=false;
if ($_POST)
{
	$is_post=true;
	$pInfo = new objectInfo($_POST);
	$products_name = $_POST['products_name'];
	$products_description = $_POST['products_description'];
	$products_short_description = $_POST['products_short_description'];
	$products_meta_title = $_POST['products_meta_title'];
	$products_meta_description = $_POST['products_meta_description'];
	$products_meta_keywords = $_POST['products_meta_keywords'];
	$products_url = $_POST['products_url'];
}
elseif ($pID)
{
	$product_query=olc_standard_products_query().SQL_AND.'p.products_id='.$pID;
	$product_query = olc_db_query($product_query);
	//W. Kaiser - Baseprice
	$product = olc_db_fetch_array($product_query);
	$pInfo = new objectInfo($product);
	$products_name = stripslashes($pInfo->products_name);
	$products_name=str_replace('\\',EMPTY_STRING,$products_name);
}
else
{
	$pInfo = new objectInfo(array());
}
$manufacturers_array = array(array('id' => EMPTY_STRING, 'text' => TEXT_NONE));
$manufacturers_query = olc_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
while ($manufacturers = olc_db_fetch_array($manufacturers_query)) {
	$manufacturers_array[] = array('id' => $manufacturers['manufacturers_id'],
	'text' => $manufacturers['manufacturers_name']);
}
$vpe_array=array(array('id' => EMPTY_STRING, 'text' => TEXT_NONE));
$vpe_query = olc_db_query("select products_vpe_id, products_vpe_name from " . TABLE_PRODUCTS_VPE .
" WHERE language_id='".SESSION_LANGUAGE_ID."' order by products_vpe_name");
while ($vpe = olc_db_fetch_array($vpe_query)) {
	$vpe_array[] = array('id' => $vpe['products_vpe_id'], 'text' => $vpe['products_vpe_name']);
}
$have_vpe=sizeof($vpe_array)>0;
$tax_class_array = array(array('id' => '0', 'text' => TEXT_NONE));
$tax_class_query = olc_db_query("select tax_class_id, tax_class_title from " . TABLE_TAX_CLASS . " order by tax_class_title");
while ($tax_class = olc_db_fetch_array($tax_class_query)) {
	$tax_class_array[] = array('id' => $tax_class['tax_class_id'],
	'text' => $tax_class['tax_class_title']);
}
$shipping_statuses = array();
$shipping_statuses=olc_get_shipping_status();
$languages = olc_get_languages();

switch ($pInfo->products_status)
{
	case '0': $status = false; $out_status = true; break;
	case '1':
	default: $status = true; $out_status = false;
}
if (NOT_USE_AJAX_ADMIN)
{
	$spiffyCal='includes/javascript/spiffyCal/spiffyCal_v2_1.';
	$main_content='
	<link rel="stylesheet" type="text/css" href="'.$spiffyCal.'css">
	<script language="JavaScript" type="text/javascript" src="'.$spiffyCal.'js"></script>
';
}
else
{
	$main_content=EMPTY_STRING;
}
echo $main_content.='
<script language="javascript" type="text/javascript" src="includes/admin_global_scripts.js.php"></script>
<!-- body //-->
<tr><td>
';
$form_action = ($pID) ? 'update_product' : 'insert_product';
$fsk18_array=array(array('id'=>'0','text'=>NO),array('id'=>'1','text'=>YES));
$form_name='new_product';
echo olc_draw_form($form_name, FILENAME_CATEGORIES,'cPath=' . $_GET['cPath'] . '&pID=' . $pID . '&action='.$form_action, 'post','enctype="multipart/form-data"');
if ($pID)
{
	$text=TEXT_EXISTING_PRODUCT;
} else {
	$text=TEXT_NEW_PRODUCT;
}
if ($products_name)
{
	$products_name=QUOTE.$products_name.QUOTE;
}
//define('AJAX_TITLE',sprintf($text, $products_name, olc_output_generated_category_path($current_category_id)));
define('AJAX_TITLE',sprintf($text, $products_name));
echo '
		<span class="pageHeading">
'.AJAX_TITLE;
?>
	</span><br/><br/>
	<table width="100%"  border="0">
	  <tr>
	    <td class="main" width="50%" valign="top">
		    <?php
		    $products_status='products_status';
		    echo TEXT_PRODUCTS_STATUS.HTML_NBSP .
		    olc_draw_radio_field($products_status, ONE_STRING, $status) . HTML_NBSP . TEXT_PRODUCT_AVAILABLE . HTML_NBSP .
		    olc_draw_radio_field($products_status,  ZERO_STRING, $out_status) . HTML_NBSP . TEXT_PRODUCT_NOT_AVAILABLE; ?><br/>
	      <table width="100%" border="0">
	        <tr>
	          <td class="main" width="127">
	          <?php
	          $spiffy_date_field_caption=TEXT_PRODUCTS_DATE_AVAILABLE;
	          $spiffy_date=$pInfo->products_date_available;
	          $spiffy_control_name="dateAvailable";
	          $spiffy_form_name=$form_name;
	          $spiffy_date_field_name='products_date_available';
	          include(DIR_FS_INC.'olc_create_spiffy_control.inc.php');
	          /*
	          if (true or IS_AJAX_PROCESSING)
	          {
	          	if (true or IS_IE)
	          	{
	          		if ($realproduct_processing)
	          		{
	          			if (USE_AJAX_ATTRIBUTES_MANAGER)
	          			{
	          				require_once(AJAX_ATTRIBUTES_MANAGER_LEADIN.'header.inc.php');
	          				echo $script;
	          			}
	          		}
	          	}
	          }
	          */
						?>
	          </td>
	        </tr>
	      </table>
	      <br/>
	    </td>
	    <td  width="50%" align="right">
		    <table class="formArea" width="100%" border="0">
		    	<tr>
		        <td class="main"><?php echo TEXT_PRODUCTS_SORT; ?></td>
		        <td class="main"><?php echo olc_draw_input_field('products_sort', $pInfo->products_sort); ?></td>
		      </tr>
		      <tr>
		        <td class="main"><?php echo TEXT_PRODUCTS_MODEL; ?></td>
		        <td class="main"><?php echo  olc_draw_input_field('products_model', $pInfo->products_model); ?></td>
		      </tr>
		      <tr>
		        <td class="main"><?php echo TEXT_PRODUCTS_MANUFACTURER; ?></td>
		        <td class="main">
		        	<?php
		        	echo olc_draw_pull_down_menu('manufacturers_id', $manufacturers_array,$pInfo->manufacturers_id);
		        	?>
		        </td>
		      </tr>
	      <?PHP
	      if ($have_vpe)
	      {
	      	$products_vpe=$pInfo->products_vpe;
	      	$products_vpe=$products_vpe==EMPTY_STRING?DEFAULT_PRODUCTS_VPE_ID:$products_vpe;
	      	$products_vpe_pulldown=olc_draw_pull_down_menu('products_vpe', $vpe_array, $products_vpe);

	      	$products_min_order_vpe=$pInfo->products_min_order_vpe;
	      	$products_min_order_vpe=$products_min_order_vpe==EMPTY_STRING?$products_vpe:$products_min_order_vpe;
	      	$products_min_order_vpe_pulldown=
	      	olc_draw_pull_down_menu('products_min_order_vpe', $vpe_array, $products_min_order_vpe);
	      	$have_vpe= '
		      <tr>
		        <td class="main">'. TEXT_PRODUCTS_VPE_VISIBLE.HTML_NBSP.
	      	olc_draw_selection_field('products_vpe_status', 'checkbox', '1',
	      	$pInfo->products_vpe_status==1 ? true : false).'
		        </td>
		        <td class="main">'.TEXT_PRODUCTS_VPE_VALUE.HTML_NBSP.
	      	olc_draw_input_field('products_vpe_value',
	      	$pInfo->products_vpe_value,'size="10"').HTML_NBSP.
	      	TEXT_PRODUCTS_VPE.HTML_NBSP.$products_vpe_pulldown.'
		        </td>
		      </tr>
		      <!-- W. Kaiser - Baseprice-->
		      <tr>
		        <td class="main">'.TEXT_PRODUCTS_BASEPRICE_SHOW.HTML_NBSP.
	      	olc_draw_selection_field('products_baseprice_show', 'checkbox', '1',
	      	$pInfo->products_baseprice_show==1 ? true : false).'
		        </td>
		        <td class="main">'.
	      	TEXT_PRODUCTS_BASEPRICE_VALUE.HTML_NBSP.olc_draw_input_field('products_baseprice_value',
	      	$pInfo->products_baseprice_value,'size="10"').'
		        </td>
		      </tr>
		      <!-- W. Kaiser - Baseprice-->
		      <!-- W. Kaiser - Minimum order-->
		      <tr>
		        <td class="main">'.TEXT_PRODUCTS_MINORDER_QTY.HTML_NBSP.'</td>
		        <td class="main">'.olc_draw_input_field('products_min_order_quantity',
	      	$pInfo->products_min_order_quantity,'size="5"').HTML_NBSP.
	      	TEXT_PRODUCTS_MINORDER_VPE.HTML_NBSP.$products_min_order_vpe_pulldown .'
		        </td>
		      </tr>
		      <!-- W. Kaiser - Minimum order-->
		      <!-- W. Kaiser - UVP-->
		      <tr>
		        <td class="main">'.TEXT_PRODUCTS_UVP.HTML_NBSP.'</td>
		        <td class="main">'.olc_draw_input_field('products_uvp',$pInfo->products_uvp,'size="20"').'
		        </td>
		      </tr>
		      <!-- W. Kaiser -  UVP-->
';
	      	echo $have_vpe;
				}?>
	      <tr>
	        <td class="main"><?php echo TEXT_FSK18; ?></td>
	        <td class="main">
	        	<?php echo olc_draw_pull_down_menu('fsk18', $fsk18_array, $pInfo->products_fsk18); ?>
	        </td>
	      </tr>
	      <tr>
				<?php if (ACTIVATE_SHIPPING_STATUS==TRUE_STRING_S) { ?>
	        <td class="main"><?php echo BOX_SHIPPING_STATUS.':'; ?></td>
	        <td class="main">
		        	<?php
		        	echo olc_draw_pull_down_menu('shipping_status', $shipping_statuses, $pInfo->products_shippingtime);
	  	      	?>
	        	</td>
	      </tr>
				<?php } ?>
	      <tr>
	        <?php
	        $basedir=DIR_FS_CATALOG.FULL_CURRENT_TEMPLATE.'module/product_';
	        $directory=$basedir.'info/';
  			$files=olc_get_templates($directory);
	        $default_array=array();
	        // set default value in dropdown!
	        if ($content['content_file']==EMPTY_STRING) {
	        	$t=TEXT_SELECT;
	        } else {
	        	$t=TEXT_NO_FILE;
	        }
        	$default_array[]=array('id' => 'default','text' => $t);
        	$default_value=$pInfo->product_template;
        	$files=array_merge($default_array,$files);
	        echo '
	        	<td class="main">'.TEXT_CHOOSE_INFO_TEMPLATE.':</td>';
	        echo '
	        	<td class="main">
	        		'.olc_draw_pull_down_menu('info_template',$files,$default_value);
	?>
	        </td>
	      </tr>
	      <tr>
	          <?php
	          $directory=$basedir.'options/';
		  			$files=olc_get_templates($directory);
	          // set default value in dropdown!
	          $default_array=array();
	          if ($content['content_file']==EMPTY_STRING) {
	          	$default_array[]=array('id' => 'default','text' => TEXT_SELECT);
	          	$default_value=$pInfo->options_template;
	          	$files=array_merge($default_array,$files);
	          } else {
	          	$default_array[]=array('id' => 'default','text' => TEXT_NO_FILE);
	          	$default_value=$pInfo->options_template;
	          	$files=array_merge($default_array,$files);
	          }
	          echo '
	          	<td class="main">'.TEXT_CHOOSE_OPTIONS_TEMPLATE.':'.'</td>';
	          echo '
	          	<td class="main">
	          		'.olc_draw_pull_down_menu('options_template',$files,$default_value);
	?>
		        </td>
		      </tr>
		    </table>
		  </td>
	  </tr>
	</table>
	<br /><br />
	<?php
	  $products_id=$pInfo->products_id;
	  for ($i = 0, $n = sizeof($languages); $i < $n; $i++)
	  {
	  	$lang_id=$languages[$i]['id'];
	  ?>
	 <table width="100%" border="0">
	  <tr>
	    <td valign="middle" class="menuBoxHeading">
	    <?php
	    $lang_image=olc_image(ADMIN_PATH_PREFIX.'lang/' . $languages[$i]['directory'] .SLASH. $languages[$i]['image'],
	    	$languages[$i]['name'],EMPTY_STRING,EMPTY_STRING,'align=middle').HTML_NBSP;

			$products_name=(($is_post && $products_name[$lang_id]) ? stripslashes($products_name[$lang_id]) :
	    olc_get_products_name($products_id, $lang_id));
	    $products_name=str_replace('\\',EMPTY_STRING,$products_name);
	    echo $lang_image.TEXT_PRODUCTS_NAME; ?>&nbsp;<?php echo olc_draw_input_field('products_name[' . $lang_id . ']',
	    $products_name,'size=60'); ?></td>
	  </tr>
	  <tr>
	    <td class="main"><?php echo TEXT_PRODUCTS_URL . '&nbsp;<small>' . TEXT_PRODUCTS_URL_WITHOUT_HTTP . '</small>'; ?>
	    <?php echo olc_draw_input_field('products_url[' . $lang_id . ']', (($is_post && $products_url[$lang_id]) ?
	    stripslashes($products_url[$lang_id]) : olc_get_products_url($products_id, $lang_id)),'size=60'); ?></td>
	  </tr>
	</table>
	<table width="100%" border="0">
	  <tr>
	    <td class="pageHeading" colspan="2"><b><?php echo TEXT_PRODUCTS_DESCRIPTION; ?></b><br/>
<?php
	       $use_spaw=USE_SPAW==TRUE_STRING_S;
	       $s='products_description_'.$lang_id;
	       $content=(($is_post && $products_description[$lang_id]) ? stripslashes($products_description[$lang_id]) :
	       olc_get_products_description($products_id, $lang_id));
		     $content=str_replace('\\',EMPTY_STRING,$content);
	       if ($use_spaw)
	       {
	       	$sw = new SPAW_Wysiwyg(
	       	$control_name=$s , 					// control's name
	       	$value= $content,           // initial value
	       	$lang=EMPTY_STRING,          // language
	       	$mode = 'full',             // toolbar mode
	       	$theme='default',           // theme (skin)
	       	$width='100%',              // width
	       	$height='400px',            // height
	       	$css_stylesheet=SPAW_STYLESHEET,         // css stylesheet file for content
	       	$dropdown_data=EMPTY_STRING           // data for dropdowns (style, font, etc.)
	       	);
	       	$sw->show();
	       }
	       else
	       {
	       	echo olc_draw_textarea_field($s, 'soft', '150', '15', $content);
	       }
?>
	    </td>
	  </tr>
	  <tr>
	    <td class="main" width="60%" rowspan="2" valign="top">
	    	<b><?php echo TEXT_PRODUCTS_SHORT_DESCRIPTION; ?></b><br/>
	      <?php
	      $s='products_short_description_'.$lang_id;
	      $content=(($is_post && $products_short_description[$lang_id]) ?
	      stripslashes($products_short_description[$lang_id]) :
	      olc_get_products_short_description($products_id, $lang_id));
 	      $content=str_replace('\\',EMPTY_STRING,$content);
	      if ($use_spaw)
	      {
	      	$sw = new SPAW_Wysiwyg(
	      	$control_name=$s , // control's name
	      	$value= $content,                  // initial value
	      	$lang=EMPTY_STRING,                   // language
	      	$mode = EMPTY_STRING,                 // toolbar mode
	      	$theme='default',           // theme (skin)
	      	$width='100%',              // width
	      	$height='150px',            // height
	      	$css_stylesheet=SPAW_STYLESHEET,         // css stylesheet file for content
	      	$dropdown_data=EMPTY_STRING           // data for dropdowns (style, font, etc.)
	      	);
	      	$sw->show();
	      } else {
	      	echo olc_draw_textarea_field($s, 'soft', '60', '8', $content);
	      }
	      ?>
	    </td>
	    <td class="main" align=top>
		    <?php
	      $meta_title=$products_meta_title[$lang_id];
				$meta_title=(($is_post && $meta_title) ? stripslashes($meta_title) :
	      olc_get_products_meta_title($products_id, $lang_id));
	      $meta_title=str_replace('\\',EMPTY_STRING,$meta_title);

	      $meta_description=$products_meta_description[$lang_id];
				$meta_description=(($is_post && $meta_description) ? stripslashes($meta_description) :
	      olc_get_products_meta_description($products_id, $lang_id));
	      $meta_description=str_replace('\\',EMPTY_STRING,$meta_description);

	      $meta_keywords=$products_meta_keywords[$lang_id];
				$meta_keywords=(($is_post && $meta_keywords) ? stripslashes($meta_keywords) :
	      olc_get_products_meta_keywords($products_id, $lang_id));
	      $meta_keywords=str_replace('\\',EMPTY_STRING,$meta_keywords);

		    echo HTML_B_START.TEXT_META_TITLE.HTML_B_END.HTML_BR;
	      echo olc_draw_textarea_field('products_meta_title['.$lang_id.']','soft','60','4',$meta_title).HTML_BR;
	      echo HTML_B_START.TEXT_META_DESCRIPTION.HTML_B_END.HTML_BR;
	      echo olc_draw_textarea_field('products_meta_description['.$lang_id.']','soft','60','4',$meta_description).HTML_BR;
	      echo HTML_B_START.TEXT_META_KEYWORDS.HTML_B_END.HTML_BR;
	      echo olc_draw_textarea_field('products_meta_keywords['.$lang_id.']','soft','60','4',$meta_keywords);
	      ?>
	    </td>
	  </tr>
	</table>
<?php
	  if (DO_PROMOTION)
	  {
	    include(DIR_WS_MODULES. 'products_promotion.php');
	  }
 }
?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td class="pageHeading"><?php echo HEADING_PRODUCT_OPTIONS; ?></td>
		</tr>
		<tr>
			<td>
				<table width="100%" border="0" class="formArea">
	        <tr>
	          <td class="main"><?php echo TEXT_PRODUCTS_QUANTITY; ?><br/>
	          <?php echo olc_draw_input_field('products_quantity', $pInfo->products_quantity); ?></td>
	        </tr>
	        <tr>
	          <td class="main"><?php echo TEXT_PRODUCTS_WEIGHT; ?><br/>
	          <?php echo olc_draw_input_field('products_weight', $pInfo->products_weight); ?>
	          <?php echo TEXT_PRODUCTS_WEIGHT_INFO; ?></td>
	        </tr>
	          <td class="main"><?php echo TEXT_PRODUCTS_IMAGE; ?><br/>
	          <?php echo olc_draw_file_field('products_image') . HTML_BR . HTML_NBSP .
	          $pInfo->products_image . olc_draw_hidden_field('products_previous_image', $pInfo->products_image); ?>
	          </td>
	        </tr>
	        <?php
	        if (DO_GROUP_CHECK)
	        {
	        	$customers_statuses_array = olc_get_customers_statuses();
	        	$customers_statuses_array=array_merge(array(array('id'=>'all','text'=>TXT_ALL)),
	        	$customers_statuses_array);
	?>
					<tr>
						<td valign="top">
							<table width="100%"  border="0">
							  <tr>
									<td colspan="2"><hr/></td>
							  </tr>
							  <tr>
									<td valign="top" width="15%" class="main">
										<b><?php echo ENTRY_CUSTOMERS_STATUS; ?></b>
									</td>
									<td class="main">
							<?php
							$is_new=$form_action == 'insert_product';
							$not_is_new=!$is_new;
							$check_it=$is_new;
							for ($i=0;$n=sizeof($customers_statuses_array),$i<$n;$i++)
							{
								if ($not_is_new)
								{
									$check_it=strstr($pInfo->group_ids,'c_'.$customers_statuses_array[$i]['id'].'_group');
								}
								if ($check_it)
								{
									$checked=' checked';
								} else {
									$checked=EMPTY_STRING;
								}
								$checked.=' onclick="javascript:check_group_checkboxes(this,'.$i.')"';
								echo '<input type="checkbox" name="groups[]" value="'.
								$customers_statuses_array[$i]['id'].'"'.$checked.'> '.
								$customers_statuses_array[$i]['text'].HTML_BR;
							}
							?>
									</td>
								</tr>
							</table>
						</td>
	        </tr>
	<?php
	        }
	?>
				</table>
			</td>
		</tr>
		<tr>
			<td>
	      <?php include(DIR_WS_MODULES.'group_prices.php'); ?>
			</td>
		</tr>
	  <tr>
	    <td class="main" align="right">
	      <?php
	      if ($have_vpe)
	      {
	      	$have_vpe=TRUE_STRING_S;
	      }
	      else
	      {
	      	$have_vpe=FALSE_STRING_S;
	      }
	      //	      IMAGE_SAVE,'style="cursor:hand" onclick="javascript:return confirm(\''.SAVE_ENTRY.'\')"') .
	      echo olc_draw_hidden_field('products_date_added',
	      (($pInfo->products_date_added) ? $pInfo->products_date_added : date('Y-m-d'))) .
	      olc_image_submit('button_save.gif',
	      IMAGE_SAVE,'style="cursor:hand" onclick="javascript:return check_product_form('.$have_vpe.')"') .
	      '&nbsp;&nbsp;<a href="' . olc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pID) . '">' .
	      olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END; ?>
	     </td>
	  </tr>
	</table>
</form>