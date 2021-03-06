<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_show_banner.php,v 1.1.1.1.2.1 2007/04/08 07:16:07 gswkaiser Exp $

   OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

   modified by http://www.ol-commerce.de, http://www.seifenparadies.de


   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_show_banner.php, v 1.15 2003/08/18);
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

// CHECKIT
// -> optimize code -> double parts

// require of application_top not possible
// cause then whois online registers it also as visitor
//

define('TABLE_AFFILIATE_BANNERS_HISTORY', 'affiliate_banners_history');
define('TABLE_AFFILIATE_BANNERS', 'affiliate_banners');
define('TABLE_PRODUCTS', 'products');

require('includes/configure.php');
if (SHOW_AFFILIATE)
{
	require('includes/affiliate_configure.php');
}

// include used functions
require_once(DIR_FS_INC.'olc_db_connect.inc.php');
require_once(DIR_FS_INC.'olc_db_close.inc.php');
require_once(DIR_FS_INC.'olc_db_query.inc.php');
require_once(DIR_FS_INC.'olc_db_fetch_array.inc.php');

// make a connection to the database... now
olc_db_connect() or die('Unable to connect to database server!');

function affiliate_show_banner($pic) {
	//Read Pic and send it to browser
    $fp = fopen($pic, "rb");
    if (!$fp) exit();
    // Get Image type
    $img_type = substr($pic, strrpos($pic, ".") + 1);
    // Get Imagename
    $pos = strrpos($pic, "/");
    if ($pos) {
    	$img_name = substr($pic, strrpos($pic, "/" ) + 1);
    }
	else {
		$img_name=$pic;
    }
    header ("Content-type: image/$img_type");
    header ("Content-Disposition: inline; filename=$img_name");
    fpassthru($fp);
    // The file is closed when fpassthru() is done reading it (leaving handle useless).
    // fclose ($fp);
    exit();
}

function affiliate_debug($banner,$sql) {
?>
    <table border=1 cellpadding=2 cellspacing=2>
      <tr><td colspan=2>Check the pathes! (includes/configure.php)</td></tr>
      <tr><td>absolute path to picture:</td><td><?php echo DIR_FS_CATALOG. DIR_WS_IMAGES . $banner; ?></td></tr>
      <tr><td>build with:</td><td>DIR_FS_CATALOG . DIR_WS_IMAGES . $banner</td></tr>
      <tr><td>DIR_FS_DOCUMENT_ROOT</td><td><?php echo DIR_FS_DOCUMENT_ROOT; ?></td></tr>
      <tr><td>DIR_FS_CATALOG</td><td><?php echo DIR_FS_CATALOG ; ?></td></tr>
      <tr><td>DIR_WS_IMAGES</td><td><?php echo DIR_WS_IMAGES; ?></td></tr>
      <tr><td>$banner</td><td><?php echo $banner; ?></td></tr>
      <tr><td>SQL-Query used:</td><td><?php echo $sql; ?></td></tr>
      <tr><th>Try to find error:</td><td>&nbsp;</th></tr>
      <tr><td>SQL-Query:</td><td><?php if ($banner) echo "Got Result"; else echo "No result"; ?></td></tr>
      <tr><td>Locating Pic</td><td>
<?php
    $pic = DIR_FS_CATALOG . DIR_WS_IMAGES . $banner;
    echo $pic . HTML_BR;
    if (!is_file($pic)) {
      echo "failed<br/>";
    } else {
      echo "success<br/>";
    }
?>
      </td></tr>
    </table>
<?php
    exit();
}

$banner = '';
$products_id = '';
$banner_id ='';
$prod_banner_id = '';
// Register needed Post / Get Variables
$affiliate_id = $_GET['ref'];
if (!$affiliate_id ) $affiliate_id = $_POST['ref'];
$banner_id = $_GET['affiliate_banner_id'];
if (isset($_GET['affiliate_banner_id'])) $banner_id = $_GET['affiliate_banner_id'];
if (!$banner_id) $banner_id = $_POST['affiliate_banner_id'];
$prod_banner_id = $_GET['affiliate_pbanner_id'];
if (!$prod_banner_id ) $prod_banner_id = $_POST['affiliate_pbanner_id'];

if (!empty($banner_id)) {
	$is_banner = TRUE_STRING_S;
    $sql = "select affiliate_banners_image, affiliate_products_id from " . TABLE_AFFILIATE_BANNERS . " where affiliate_banners_id = " . $banner_id  . " and affiliate_status = 1";
    $banner_values = olc_db_query($sql);
    if ($banner_array = olc_db_fetch_array($banner_values)) {
    	$banner = $banner_array['affiliate_banners_image'];
    	$products_id = $banner_array['affiliate_products_id'];
    }
}

if (!empty($prod_banner_id)) {
	$is_banner = FALSE_STRING_S;
    $banner_id = 1; // Banner id for these Banners is one
    $sql = "select products_image from " . TABLE_PRODUCTS . " where products_id = '" . $prod_banner_id  . "' and products_status = 1";
    $banner_values = olc_db_query($sql);
    if ($banner_array = olc_db_fetch_array($banner_values)) {
    	$banner = $banner_array['products_image'];
    	$products_id = $prod_banner_id;
    }
}

// DebugModus
if (AFFILIATE_SHOW_BANNERS_DEBUG == TRUE_STRING_S) affiliate_debug($banner,$sql);

if ($banner) {
	if($is_banner == TRUE_STRING_S) {
		$pic = DIR_FS_CATALOG . DIR_WS_IMAGES . $banner;
	}
	else {
		$pic = DIR_FS_CATALOG . DIR_WS_THUMBNAIL_IMAGES . $banner;
	}

    // Show Banner only if it exists:
    if (is_file($pic)) {
    	$today = date('Y-m-d');
    	// Update stats:
    	if ($affiliate_id) {
    		$banner_stats_query = olc_db_query("select * from " . TABLE_AFFILIATE_BANNERS_HISTORY . " where affiliate_banners_id = '" . $banner_id  . "' and affiliate_banners_products_id = '" . $products_id ."' and affiliate_banners_affiliate_id = '" . $affiliate_id. "' and affiliate_banners_history_date = '" . $today . APOS);
    		// Banner has been shown today
    		if ($banner_stats_array = olc_db_fetch_array($banner_stats_query)) {
    			olc_db_query(SQL_UPDATE . TABLE_AFFILIATE_BANNERS_HISTORY . " set affiliate_banners_shown = affiliate_banners_shown + 1 where affiliate_banners_id = '" . $banner_id  . "' and affiliate_banners_affiliate_id = '" . $affiliate_id. "' and affiliate_banners_products_id = '" . $products_id ."' and affiliate_banners_history_date = '" . $today . APOS);
    		}
			else { // First view of Banner today
          		olc_db_query(INSERT_INTO . TABLE_AFFILIATE_BANNERS_HISTORY . " (affiliate_banners_id, affiliate_banners_products_id, affiliate_banners_affiliate_id, affiliate_banners_shown, affiliate_banners_history_date) VALUES ('" . $banner_id  . "', '" .  $products_id ."', '" . $affiliate_id. "', '1', '" . $today . "')");
          	}
        }
        // Show Banner
        affiliate_show_banner($pic);
    }
}

// Show default Banner if none is found
if (is_file(AFFILIATE_SHOW_BANNERS_DEFAULT_PIC)) {
	affiliate_show_banner(AFFILIATE_SHOW_BANNERS_DEFAULT_PIC);
}
else {
    echo HTML_BR; // Output something to prevent endless loading
}
exit();
?>
