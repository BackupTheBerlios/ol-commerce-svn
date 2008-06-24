<?php
/* --------------------------------------------------------------
$Id: new_categorie.php,v 1.1.1.1.2.1 2007/04/08 07:16:30 gswkaiser Exp $

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
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

$cID=$_GET['cID'];
if ($_POST)
{
	$cInfo = new objectInfo($_POST);
	$categories_name = $_POST['categories_name'];
	$categories_heading_title = $_POST['categories_heading_title'];
	$categories_description = $_POST['categories_description'];
	$categories_meta_title = $_POST['categories_meta_title'];
	$categories_meta_description = $_POST['categories_meta_description'];
	$categories_meta_keywords = $_POST['categories_meta_keywords'];
	$categories_url = $_POST['categories_url'];
}
elseif ($cID)
{
	$category_query = olc_db_query("select c.categories_id,c.group_ids, cd.language_id, cd.categories_name, cd.categories_heading_title, cd.categories_description, cd.categories_meta_title, cd.categories_meta_description, cd.categories_meta_keywords, c.categories_image, c.sort_order, c.date_added, c.last_modified, c.categories_template, c.listing_template from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and c.categories_id = '" . $cID . APOS);
	$category = olc_db_fetch_array($category_query);
	$cInfo = new objectInfo($category);
}
else
{
	$cInfo = new objectInfo(array());
}
$dir00=DIR_FS_CATALOG.TEMPLATE_PATH.CURRENT_TEMPLATE_MODULE;
$languages = olc_get_languages();
$text_new_or_edit = ($_GET['action']=='new_category_ACD') ? TEXT_INFO_HEADING_NEW_CATEGORY : TEXT_INFO_HEADING_EDIT_CATEGORY;
$sep=HTML_HR;
?>
      <tr>
        <td>
	        <table border="0" width="100%" cellspacing="0" cellpadding="0">
	          <tr>
	            <td class="pageHeading">
								<?php
								echo '
	<script language="javascript" src="includes/admin_global_scripts.js.php"></script>
	';
								define('AJAX_TITLE',sprintf($text_new_or_edit,
								olc_output_generated_category_path($current_category_id)));
								echo AJAX_TITLE;
								?>
	            </td>
	          </tr>
	        </table>
	      </td>
      </tr>
      <tr>
        <td><?php echo $sep;?></td>
      </tr>

      <?php
      $form_action = ($cID) ? 'update_category' : 'insert_category';
      echo olc_draw_form('new_category', FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cID .
    '&action='.$form_action, 'post', 'enctype="multipart/form-data"'); ?>
      <tr>
        <td>
        	<table width="100%" border="0" cellspacing="0" cellpadding="2">
        		<tr>
        			<td colspan="2">
 								<table class="infobox_border" width="100%"  border="0">
									<tr>
				            <td class="main" width="200" valign="top"><?php echo TEXT_EDIT_CATEGORIES_IMAGE; ?></td>
				            <td class="main" valign="top"><?php echo olc_draw_file_field('categories_image') . HTML_BR .
				            HTML_NBSP .$cInfo->categories_image .
				            olc_draw_hidden_field('categories_previous_image',$cInfo->categories_image); ?>
				            </td>
				          </tr>
				          <tr>
				          	<td colspan="2"><?php echo $sep;?></td>
				          </tr>
                	<tr>
          <?php
          $dir0=$dir00 . 'product_listing/';
          $files=olc_get_templates($dir0);
          // set default value in dropdown!
          if ($files)
          {
          	$text=TEXT_SELECT;
          }
          else
          {
          	$text=TEXT_NO_FILE;
          }
          $default_array=array('id' => 'default','text' => $text);
          $default_value=$cInfo->listing_template;
          $files=array_merge($default_array,$files);
          echo '
          					<td class="main">'.TEXT_CHOOSE_INFO_TEMPLATE_LISTING.':</td>
          					<td>
          						<span class="main">'.olc_draw_pull_down_menu('listing_template',$files,$default_value).'</span>
						      	</td>
						      </tr>
                  <tr>
';
          $dir0=$dir00. 'categorie_listing/';
          $files=olc_get_templates($dir0);
          // set default value in dropdown!
          if ($files)
          {
          	$text=TEXT_SELECT;
          }
          else
          {
          	$text=TEXT_NO_FILE;
          }
          $default_array=array('id' => 'default','text' => $text);
          $default_value=$cInfo->categories_template;
          $files=array_merge($default_array,$files);
          echo '
          					<td class="main">'.TEXT_CHOOSE_INFO_TEMPLATE_CATEGORIE.':</td>
          					<td>
          						<span class="main">'.olc_draw_pull_down_menu('categorie_template',$files,$default_value).'</span>
          					</td>
      						</tr>
      						<tr>
';
          $order_array=EMPTY_STRING;
          $order_array=array(
          array('id' => 'p.products_price','text'=>TXT_PRICES),
          array('id' => 'pd.products_name','text'=>TXT_NAME),
          array('id' => 'p.products_ordered','text'=>TXT_ORDERED),
          array('id' => 'p.products_sort','text'=>TXT_SORT),
          array('id' => 'p.products_weight','text'=>TXT_WEIGHT),
          array('id' => 'p.products_quantity','text'=>TXT_QTY));
          $default_value='pd.products_name';
?>
            				<td class="main"><?php echo TEXT_EDIT_PRODUCT_SORT_ORDER; ?>:</td>
            				<td class="main"><?php echo olc_draw_pull_down_menu('products_sorting',$order_array,$default_value); ?></td>
          				</tr>
          				<tr>
<?php
$order_array=EMPTY_STRING;
$order_array=array(array('id' => 'ASC','text'=>'ASC (1 first)'),
array('id' => 'DESC','text'=>'DESC (1 last)'));
?>
				          	<td class="main"><?php echo TEXT_EDIT_PRODUCT_SORT_ORDER; ?>:</td>
				            <td class="main"><?php echo olc_draw_pull_down_menu('products_sorting2',$order_array,'ASC'); ?></td>
				          </tr>
				          <tr>
				            <td class="main"><?php echo TEXT_EDIT_SORT_ORDER; ?></td>
				            <td class="main"><?php echo olc_draw_input_field('sort_order', $cInfo->sort_order, 'size="2"'); ?></td>
				          </tr>
<?php

if (DO_GROUP_CHECK) {
	$customers_statuses_array = olc_get_customers_statuses();
	$customers_statuses_array=array_merge(array(array('id'=>'all','text'=>TXT_ALL)),$customers_statuses_array);
?>
						      <tr>
						        <td colspan="2"><?php echo $sep;?></td>
						      </tr>
									<tr>
										<td valign="top" class="main" ><?php echo ENTRY_CUSTOMERS_STATUS; ?></td>
										<td class="main">
<?php
$is_new=$form_action == 'insert_category';
$not_is_new=!$is_new;
$check_it=$is_new;
for ($i=0;$n=sizeof($customers_statuses_array),$i<$n;$i++) {
	if ($not_is_new)
	{
		$check_it=strstr($category['group_ids'],'c_'.$customers_statuses_array[$i]['id'].'_group');
	}
	if ($check_it)
	{
		$checked=' checked="checked"';
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
<?php
}
?>
								</table>
							</td>
						</tr>
<?php
$lang_dir0=ADMIN_PATH_PREFIX.'lang/';
$admin_images='/admin/images/';
$size80=' size="80"';
for ($i=0; $i<sizeof($languages); $i++)
{
	$lang=$languages[$i];
	$lang_id=$lang['id'];
	$lang_dir=$lang_dir0.$lang['directory'];
	$lang_image=olc_image($lang_dir.$admin_images.$lang['image']);
	$cat_name=$categories_name[$lang_id];
	$cat_description=$categories_description[$lang_id];
?>
	          <tr>
	            <td class="main"><?php if ($i == 0) echo TEXT_EDIT_CATEGORIES_NAME; ?></td>
	            <td class="main">
            <?php echo $lang_image . HTML_NBSP .
            olc_draw_input_field('categories_name[' . $lang_id . ']', (($cat_name) ?
            stripslashes($cat_name) : olc_get_categories_name($cInfo->categories_id, $lang_id)),$size80); ?>
	            </td>
	          </tr>
<?php } ?>

	          <tr>
	          	<td colspan="2"><?php echo $sep; ?></td>
	          </tr>

<?php
for ($i=0; $i<sizeof($languages); $i++)
{
	$lang=$languages[$i];
	$lang_id=$lang['id'];
	$lang_dir=$lang_dir0.$lang['directory'];
	$lang_image=olc_image($lang_dir.$admin_images.$lang['image']);
	$cat_name=$categories_name[$lang_id];
	$cat_description=$categories_description[$lang_id];
?>
	          <tr>
	            <td class="main"><?php if ($i == 0) echo TEXT_EDIT_CATEGORIES_HEADING_TITLE; ?></td>
	            <td class="main">
            <?php echo $lang_image . HTML_NBSP .
            olc_draw_input_field('categories_heading_title[' . $lang_id . ']', (($cat_name) ?
             stripslashes($cat_name) : olc_get_categories_heading_title($cInfo->categories_id, $lang_id)),$size80); ?>
	            </td>
	          </tr>
<?php } ?>

        		<tr><td colspan="2"><?php echo $sep; ?></td></tr>

<?php    for ($i=0; $i<sizeof($languages); $i++)
{
	$lang=$languages[$i];
	$lang_id=$lang['id'];
	$lang_dir=$lang_dir0.$lang['directory'];
	$lang_image=olc_image($lang_dir.$admin_images.$lang['image']);
	$cat_meta_title=$categories_meta_title[$lang_id];
	$cat_meta_description=$categories_meta_description[$lang_id];
	$cat_meta_keywords=$categories_meta_keywords[$lang_id];
?>
	          <tr>
	            <td class="main" valign="top"><?php  echo TEXT_EDIT_CATEGORIES_DESCRIPTION; ?></td>
	            <td align="left">
		            <table width="100%" border="0" cellspacing="0" cellpadding="0">
		              <tr>
		                <td class="main" valign="top" width="40">
		                <?php
		                	echo $lang_image; ?>&nbsp;
		                </td>
		                <td class="main" align="left" style="text-align:left">
						       <?php
						       $content=($cat_description) ? stripslashes($cat_description) :
						       olc_get_categories_description($cInfo->categories_id, $lang_id);

						       $s='categories_description_' .	$lang_id;
						       if (USE_SPAW==TRUE_STRING_S)
						       {
						       	$sw = new SPAW_Wysiwyg(
						       	$control_name=$s , 					// control's name
						       	$value= $content,           // initial value
						       	$lang=EMPTY_STRING,         // language
						       	$mode = 'full',             // toolbar mode
						       	$theme='default',           // theme (skin)
						       	$width='600px',              // width
						       	$height='400px',            // height
						       	$css_stylesheet=SPAW_STYLESHEET,         // css stylesheet file for content
						       	$dropdown_data=EMPTY_STRING           // data for dropdowns (style, font, etc.)
						       	);
						       	$sw->show();
						       }
						       else
						       {
						       	echo olc_draw_textarea_field($s,'soft', '70', '15', $content);
						       }
									?>
		                </td>
		              </tr>
		            </table>
		          </td>
  	        </tr>
	          <tr>
	            <td class="main" valign="top"><?php echo TEXT_META_TITLE; ?></td>
	            <td>
		            <table width="100%" border="0" cellspacing="0" cellpadding="0">
		              <tr>
		                <td class="main" valign="top" width="40">
		                <?php echo $lang_image; ?>&nbsp;
		                </td>
		                <td class="main"><?php echo olc_draw_textarea_field('categories_meta_title[' . $lang_id . ']',
		                'soft', '82', '3', (($cat_meta_title) ? stripslashes($cat_meta_title) :
		                olc_get_categories_meta_title($cInfo->categories_id, $lang_id))); ?>
		               </td>
		              </tr>
		            </table>
		          </td>
	          </tr>
	          <tr>
	            <td colspan="2"><?php echo $sep; ?></td>
	          </tr>
	           <tr>
	            <td class="main" valign="top"><?php  echo TEXT_META_DESCRIPTION; ?></td>
	            <td>
		            <table width="100%" border="0" cellspacing="0" cellpadding="0">
		              <tr>
		                <td class="main" valign="top" width="40">
		                <?php echo $lang_image; ?>&nbsp;
		                </td>
		                <td class="main"><?php echo olc_draw_textarea_field('categories_meta_description[' . $lang_id . ']',
		                'soft', '82', '3', (($cat_meta_description) ? stripslashes($cat_meta_description) :
		                	olc_get_categories_meta_description($cInfo->categories_id, $lang_id))); ?></td>
		              </tr>
		            </table>
		          </td>
	          </tr>
	          <tr>
	            <td colspan="2"><?php echo $sep; ?>
	            </td>
	          </tr>
	           <tr>
	            <td class="main" valign="top"><?php  echo TEXT_META_KEYWORDS; ?></td>
	            <td>
		            <table width="100%" border="0" cellspacing="0" cellpadding="0">
		              <tr>
		                <td class="main" valign="top" width="40">
		                <?php echo $lang_image; ?>&nbsp;
		                </td>
		                <td class="main"><?php echo olc_draw_textarea_field('categories_meta_keywords[' . $lang_id . ']',
		                'soft', '82', '3', (($cat_meta_keywords) ? stripslashes($cat_meta_keywords) :
		                olc_get_categories_meta_keywords($cInfo->categories_id, $lang_id))); ?></td>
		              </tr>
		            </table>
		          </td>
	          </tr>
<?php } ?>
		        <tr><td colspan="2"><?php echo $sep; ?></td></tr>
		      </table>
		    </td>
			  </tr>
				<tr>
				  <td class="main" align="right">
				    <?php
				    echo olc_draw_hidden_field('categories_date_added',
				    (($cInfo->date_added) ? $cInfo->date_added : date('Y-m-d'))) .
				    olc_draw_hidden_field('parent_id', $cInfo->parent_id) . olc_image_submit('button_save.gif',
				    IMAGE_SAVE,'style="cursor:hand" onclick="javascript:return confirm(\''.SAVE_ENTRY.'\')"') . '&nbsp;&nbsp;'.
				    HTML_A_START . olc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cID) . '">' .
				    olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END;
				     ?>
			   </td>
			</tr>
		</form>
