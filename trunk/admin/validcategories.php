<?php
   /* -----------------------------------------------------------------------------------------
   $Id: validcategories.php,v 1.1.1.1.2.1 2007/04/08 07:16:33 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project (earlier name of osCommerce)
   (c) 2002-2003 osCommerce (validcategories.php,v 0.01 2002/08/17); www.oscommerce.com
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
<html>
<head>
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
<table width="550" border="1" cellspacing="1" bordercolor="gray">
<tr>
<td colspan="4">
<h4><?php echo TEXT_VALID_CATEGORIES_LIST; ?></h4>
</td>
</tr>
<?
    echo "<tr><th>" . TEXT_VALID_CATEGORIES_ID . "</th><th>" . TEXT_VALID_CATEGORIES_NAME . "</th></tr><tr>";
    $result = olc_db_query("SELECT * FROM " . TABLE_CATEGORIES . ", " . TABLE_CATEGORIES_DESCRIPTION . 
    " WHERE categories.categories_id = categories_description.categories_id and categories_description.language_id = '" . 
    SESSION_LANGUAGE_ID . "' ORDER BY categories.categories_id");
    if ($row = olc_db_fetch_array($result)) {
        do {
            echo "<td>".$row["categories_id"]."</td>\n";
            echo "<td>".$row["categories_name"]."</td>\n";
            echo "</tr>\n";
        }
        while($row = olc_db_fetch_array($result));
    }
    echo "</table>\n";
?>
<br/>
<table width="550" border="0" cellspacing="1">
<tr>
<td align=middle><input type="button" value="Close Window" onclick="javascript:window.close()"></td>
</tr></table>
</body>
</html>