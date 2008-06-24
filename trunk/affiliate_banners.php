<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_banners.php,v 1.1.1.1.2.1 2007/04/08 07:16:04 gswkaiser Exp $

   OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

   modified by http://www.ol-commerce.de, http://www.seifenparadies.de


   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_banners.php, v 1.13 2003/02/27);
   http://oscaffiliate.sourceforge.net/

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce
   Copyright (c) 2003 netz-designer
   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

   Copyright (c) 2002 - 2003 osCommerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------*/

require('includes/application_top.php');


// include needed functions
require_once(DIR_FS_INC.'olc_draw_textarea_field.inc.php');
require_once(DIR_FS_INC.'olc_image.inc.php');



if (!isset($_SESSION['affiliate_id'])) {
    olc_redirect(olc_href_link(FILENAME_AFFILIATE, '', SSL));
}

$breadcrumb->add(NAVBAR_TITLE, olc_href_link(FILENAME_AFFILIATE, '', SSL));
$breadcrumb->add(NAVBAR_TITLE_BANNERS, olc_href_link(FILENAME_AFFILIATE_BANNERS));

$affiliate_banners_values = olc_db_query("select * from " . TABLE_AFFILIATE_BANNERS . " order by affiliate_banners_title");

require(DIR_WS_INCLUDES . 'header.php');
$affiliate_banners_title_text='affiliate_banners_title';
$affiliate_banners_title=$affiliate_banners[$affiliate_banners_title_text];
$smarty->assign($affiliate_banners_title_text, $affiliate_banners_title);
$smarty->assign('FORM_ACTION', olc_draw_form('individual_banner', olc_href_link(FILENAME_AFFILIATE_BANNERS)));
$smarty->assign('INPUT_BANNER_ID', olc_draw_input_field('individual_banner_id', '', 'size="5"'));
$smarty->assign('BUTTON_SUBMIT', olc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));

$title=$affiliate_pbanners['products_name'];
$params='ref=' . $_SESSION['affiliate_id'];
$link_end='" target=\"_blank\">';
$image=DIR_WS_IMAGES . $affiliate_pbanners['affiliate_banners_image'];
if (olc_not_null($_POST['individual_banner_id']) || olc_not_null($_GET['individual_banner_id'])) {
    if (olc_not_null($_POST['individual_banner_id'])) $individual_banner_id = $_POST['individual_banner_id'];
    if ($_GET['individual_banner_id']) $individual_banner_id = $_GET['individual_banner_id'];
    $affiliate_pbanners_values = olc_db_query("select p.products_image, pd.products_name from " . TABLE_PRODUCTS . " p, " .
    TABLE_PRODUCTS_DESCRIPTION . " pd
    where p.products_id = '" . $individual_banner_id . "'
    and pd.products_id = '" . $individual_banner_id . "'
    and p.products_status = '1'
    and pd.language_id = '" . SESSION_LANGUAGE_ID . APOS);
    if ($affiliate_pbanners = olc_db_fetch_array($affiliate_pbanners_values)) {
        $link = HTML_A_START . olc_href_link(ADMIN_PATH_PREFIX. FILENAME_PRODUCT_INFO, $params .
        '&products_id=' . $individual_banner_id . '&affiliate_banner_id=1') .$link_end;
        switch (AFFILIATE_KIND_OF_BANNERS)
        {
          case 1:
            break;
          case 2: // Link to Products
        		$image=FILENAME_AFFILIATE_SHOW_BANNER .QUESTION . $params . '&affiliate_pbanner_id=' . $individual_banner_id;
            break;
        }
        $link .= olc_image($image,$title).HTML_A_END;
    }
    $smarty->assign('link1', $link);
    $smarty->assign('TEXTAREA_AFFILIATE_BANNER1', olc_draw_textarea_field('affiliate_banner', 'soft', '60', '6', $link));
}
$banner_table_content = '';
if (olc_db_num_rows($affiliate_banners_values)) {
    while ($affiliate_banners = olc_db_fetch_array($affiliate_banners_values)) {
        $prod_id = $affiliate_banners['affiliate_products_id'];
        $affiliate_products_query = olc_db_query("select products_name from " . TABLE_PRODUCTS_DESCRIPTION .
        " where products_id = '" . $prod_id . "' and language_id = '" . SESSION_LANGUAGE_ID . APOS);
        $affiliate_products = olc_db_fetch_array($affiliate_products_query);
        $ban_id = $affiliate_banners['affiliate_banners_id'];
        $affiliate_banner_id='&affiliate_banner_id=' . $ban_id;
        $link0 = HTML_A_START.olc_href_link('../' . FILENAME_PRODUCT_INFO, $params.$affiliate_banner_id.HASH).$link_end;
        $products_id='&products_id='.$prod_id ;
        $affiliate_banners_image ='../' . DIR_WS_IMAGES . $affiliate_banners['affiliate_banners_image'] ;
        $link=str_replace(HASH, EMPTY_STRING,$link0);
        $link_products_id = str_replace(HASH, $products_id,$link0);
        switch (AFFILIATE_KIND_OF_BANNERS) {
            case 1: // Link to Products
                if ($prod_id > 0) {
                    $link = $link_products_id;
                }
                else { // generic_link
                    $title=$affiliate_banners_title;
                }
	              $image=$affiliate_banners_image;
                break;
            case 2: // Link to Products
                if ($prod_id > 0) {
	                $link = $link_products_id;
                }
                else { // generic_link
                  $title=$affiliate_banners_title;
                }
								$image=FILENAME_AFFILIATE_SHOW_BANNER . '?' . $param . $affiliate_banner_id;
                break;
        }
        $link .= olc_image($image,$title).HTML_A_END;

        $banner_table_content .= '<tr>';
        $banner_table_content .= '<td><table width="100%" border="0" cellspacing="0" cellpadding="2">';
        $banner_table_content .= '<tr><td class="infoBoxHeading" align="center">' . TEXT_AFFILIATE_NAME . BLANK .
        $affiliate_banners_title . '</td></tr>';
        $banner_table_content .= '<tr><td class="smallText" align="center"><br/>' . $link . '</td></tr>';
        $banner_table_content .= '<tr><td class="smallText" align="center">' . TEXT_AFFILIATE_INFO . '</td></tr>';
        $banner_table_content .= '<tr><td class="smallText" align="center">' . olc_draw_textarea_field('affiliate_banner', 'soft', '60', '6', $link) . '</td></tr>';
        $banner_table_content .= '</table></td></tr>';
    }
    $smarty->assign('banner_table_content', $banner_table_content);
}
$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'affiliate_banners'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
require(BOXES);
$smarty->display(INDEX_HTML);?>
