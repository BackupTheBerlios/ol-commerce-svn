<?php
/*
*  product_promotion.php
*  created by Southbridge, Sergej Stroh
*  date 2005.08.03
*	www.southbridge.de
* ----------------------------------------------- */
?>

<table width="100%" cellpadding="3" cellspacing="0" border="0" class="pp_tab">
  <tr>
    <td class="pp_header"><?php echo PP_HEADER_TITLE;?></td>
    <td class="pp_header" width="45%">
<table cellpadding="0" cellspacing="0" border="0" align="left">
  <tr>
    <td class="pp_main" width="22"><?php echo olc_draw_selection_field('products_promotion_status', 'checkbox', '1', $pInfo->products_promotion_status==1 ? true : false);?></td>
    <td class="pp_main"><?php echo PP_CONFIG_GLOBAL_ON;?> &nbsp;</td>
  </tr>
</table>
    </td>
  </tr>
  <tr>
    <td valign="top" colspan="2">

<table width="100%" cellpadding="0" cellspacing="1" border="0">
  <tr>
    <td class="pp_main" width="22"><?php echo olc_draw_selection_field('products_promotion_product_title', 'checkbox', '1',$pInfo->products_promotion_product_title==1 ? true : false);?></td>
    <td class="pp_main"><?php echo PP_CONFIG_PRODUCT_TITLE_ON;?></td>
  </tr>
  <tr>
    <td class="pp_main" width="22" style="border-bottom: 1px solid #cccccc;"><?php echo olc_draw_selection_field('products_promotion_product_desc', 'checkbox', '1',$pInfo->products_promotion_product_desc==1 ? true : false);?></td>
    <td class="pp_main" style="border-bottom: 1px solid #cccccc;"><?php echo PP_CONFIG_PRODUCT_DESCRIPTION_ON;?></td>
  </tr>
</table>

<?php
// ---------------------------------------------------------------------------- // INFOS HOLEN
$languages = olc_get_languages();
$lang_anz = sizeof($languages);

for($i = 0; $i < $lang_anz; $i ++){
	$promotion_query = olc_db_query("SELECT
        products_promotion_title,
        products_promotion_image,
        products_promotion_desc
      FROM " . TABLE_PRODUCTS_DESCRIPTION . "
      WHERE products_id = '" . (int)$_GET['pID'] . "'
      AND language_id = '" . $languages[$i]['id'] . "'");

	$promotion = olc_db_fetch_array($promotion_query);
	//echo '<pre>'; print_r($promotion); echo '</pre>';
	$title .= olc_image(DIR_WS_ADMIN.'images/icons/'. $languages[$i]['code'] .'_icon.gif', 'Language') . '<input type="text" name="products_promotion_title[' . $languages[$i]['id'] . ']" size="75" value="'. $promotion['products_promotion_title'] .'"><br />';
	// grafik vorhanden
	if($promotion['products_promotion_image'] != '')
	{
		$image .= olc_image(DIR_WS_CATALOG_IMAGES.'products_promotion/'. $promotion['products_promotion_image'], 'Image'). "\n" . olc_draw_hidden_field('products_promotion_image'. $i, $promotion['products_promotion_image']). '<br>';
		$image .= olc_draw_selection_field('del_products_promotion_image'. $i, 'checkbox', 'products_promotion_image'. $i) .' '. PP_TEXT_DELETE .'<br /><br />';
	}
	$image .= olc_image(DIR_WS_ADMIN.'images/icons/'. $languages[$i]['code'] .'_icon.gif', 'Language') . olc_draw_file_field('products_promotion_image'. $i). '&nbsp;<br />';
	$description .= olc_image(DIR_WS_ADMIN.'images/icons/'. $languages[$i]['code'] .'_icon.gif', 'Language') . '<textarea id="products_promotion_desc[' . $languages[$i]['id'] . ']" name="products_promotion_desc[' . $languages[$i]['id'] . ']" cols="100" rows="15" style="width:99%;">' . $promotion['products_promotion_desc'] . '</textarea><br />';
}
// ---------------------------------------------------------------------------- // INFOS HOLEN eof
?>
<table cellpadding="2" cellspacing="1" border="0" style="padding-top: 5px;">
  <tr>
    <td class="pp_title"><?php echo PP_TEXT_TITLE;?></td>
  </tr>
  <tr>
    <td class="pp_main"><?php echo $title;?></td>
  </tr>
</table>

<table cellpadding="2" cellspacing="1" border="0" style="padding-top: 5px;">
  <tr>
    <td class="pp_title"><?php echo PP_TEXT_IMAGE;?></td>
  </tr>
  <tr>
    <td class="pp_main"><?php echo $image;?></td>
  </tr>
</table>

<table cellpadding="2" cellspacing="1" border="0" style="padding-top: 5px;">
  <tr>
    <td class="pp_title"><?php echo PP_TEXT_DESCRIPTION;?></td>
  </tr>
  <tr>
    <td class="pp_main"><?php echo $description;?></td>
  </tr>
</table>

    </td>
  </tr>
</table>