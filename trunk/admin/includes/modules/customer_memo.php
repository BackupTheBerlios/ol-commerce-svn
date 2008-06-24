<?php
/* --------------------------------------------------------------
$Id: customer_memo.php,v 1.1.1.1.2.1 2007/04/08 07:16:45 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

(c) programmed by Zanier Mario for neXTCommerce
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------
based on:
(c) 2003	    nextcommerce (customer_memo.php,v 1.6 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

--------------------------------------------------------------*/


?>
    <td valign="top" class="main"><?php echo ENTRY_MEMO; ?></td>
    <td class="main"><?php
    $memo_query = olc_db_query("SELECT
                                  *
                              FROM
                                  " . TABLE_CUSTOMERS_MEMO . "
                              WHERE
                                  customers_id = '" . $_GET['cID'] . "'
                              ORDER BY
                                  memo_date DESC");
    while ($memo_values = olc_db_fetch_array($memo_query)) {
    	$poster_query = olc_db_query("SELECT customers_firstname, customers_lastname FROM " . TABLE_CUSTOMERS . " WHERE customers_id = '" . $memo_values['poster_id'] . APOS);
    	$poster_values = olc_db_fetch_array($poster_query);
?><table width="100%">
      <tr>
        <td class="main"><b><?php echo TEXT_DATE; ?></b>:<i><?php echo $memo_values['memo_date']; ?></i><b><?php echo TEXT_TITLE; ?></b>:<?php echo $memo_values['memo_title']; ?><b>  <?php echo TEXT_POSTER; ?></b>:<?php echo $poster_values['customers_lastname']; ?> <?php echo $poster_values['customers_firstname']; ?></td>
      </tr>
      <tr>
        <td width="142" class="main" style="border: 1px solid; border-color: #cccccc;"><?php echo $memo_values['memo_text']; ?></td>
      </tr>
      <tr>
        <td><a href="<?php echo olc_href_link(FILENAME_CUSTOMERS, 'cID=' . $_GET['cID'] . '&action=edit&special=remove_memo&mID=' . $memo_values['memo_id']); ?>" onclick="javascript:return confirm('<?php echo DELETE_ENTRY; ?>')"><?php echo olc_image_button('button_delete.gif', IMAGE_DELETE); ?></a></td>
      </tr>
    </table>
<?php
    }
?>
    <table width="100%">
      <tr>
        <td class="main"><b><?php echo TEXT_TITLE ?></b>:<?php echo olc_draw_input_field('memo_title'); ?><br/><?php echo olc_draw_textarea_field('memo_text', 'soft', '80', '5'); ?><br/><?php echo olc_image_submit('button_insert.gif', IMAGE_INSERT); ?></td>
      </tr>
    </table></td>