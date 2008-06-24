<?php
/* -----------------------------------------------------------------------------------------
$Id: validproducts.php,v 1.1.1.1.2.1 2007/04/08 07:16:33 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project (earlier name of osCommerce)
(c) 2002-2003 osCommerce (validproducts.php,v 0.01 2002/08/17); www.oscommerce.com
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contribution:

Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
http://www.oscommerce.com/community/contributions,282
Copyright (c) Strider | Strider@oscworks.com
Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
Copyright (c) Andre ambidex@gmx.net
Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/


require('includes/application_top.php');

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<title>Valid Categories/Products List</title>
<style type="text/css">
<!--
h4 {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; text-align: center}
p {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: xx-small}
th {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: xx-small}
td {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: xx-small}
-->
</style>
<head>
<body>
<table width="100% border="0" cellspacing="0" cellpadding="0">
<tr>
<table width="550" border="1" cellspacing="1" bordercolor="gray">
<tr>
<td colspan="3">
<h4><?php echo TEXT_VALID_PRODUCTS_LIST; ?></h4>
</td>
</tr>
<?
$_GET['max_rows'] = 100; // Hier max.Artikel einstellen

echo "<tr><th>". TEXT_VALID_PRODUCTS_ID . "</th><th>" . TEXT_VALID_PRODUCTS_NAME . "</th><th>" . TEXT_VALID_PRODUCTS_MODEL . "</th></tr><tr>";
$products_query_raw = "select p.products_id, p.products_model, p.products_status, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = pd.products_id and pd.language_id = '" . SESSION_LANGUAGE_ID . "' ORDER BY pd.products_name";
$products_split = new splitPageResults($_GET['page'], $_GET['max_rows'], $products_query_raw, $products_query_numrows, 'p.products_id');
$result = olc_db_query($products_query_raw);

if ($row = olc_db_fetch_array($result)) {
	do {
		echo "<td>&nbsp;".$row["products_id"]."</td>\n";
		if ($row["products_status"] == '1') {
			echo '<td nowrap="nowrap">' .HTML_NBSP. olc_image(DIR_WS_IMAGES . "icon_status_green.gif", IMAGE_ICON_STATUS_GREEN, 10, 10) . HTML_NBSP . $row["products_name"] .HTML_NBSP. "</td>\n";
		} else {
			echo '<td nowrap="nowrap">'.HTML_NBSP . olc_image(DIR_WS_IMAGES . "icon_status_red.gif", IMAGE_ICON_STATUS_RED, 10, 10) . HTML_NBSP . $row["products_name"] . HTML_NBSP."</td>\n";
		}
		echo "<td>&nbsp;".$row["products_model"]."</td>\n";
		echo "</tr>\n";
	}
	while($row = olc_db_fetch_array($result));
}
echo "</table>\n";
?>
<br/>
      <table width="550" border="0" cellspacing="1" cellpadding="0">
       <tr>
        <td><?php echo $products_split->display_count($products_query_numrows, $_GET['max_rows'], $_GET['page'], TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></td>
        <td align="right"><?php echo $products_split->display_links($products_query_numrows, $_GET['max_rows'], MAX_DISPLAY_PAGE_LINKS, $_GET['page'], olc_get_all_get_params(array('page'))); ?></td>
       </tr>
      </table>
<br/>
<table width="550" border="0" cellspacing="1">
<tr>
<td align=middle><input type="button" value="Close Window" onclick="javascript:window.close()"></td>
</tr></table>
</tr></table>
</body>
</html>