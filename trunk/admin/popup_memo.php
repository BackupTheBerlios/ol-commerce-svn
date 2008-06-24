<?php
/* --------------------------------------------------------------
   $Id: popup_memo.php,v 1.1.1.1.2.1 2007/04/08 07:16:31 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercecoding standards www.oscommerce.com
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   --------------------------------------------------------------*/

   require('includes/application_top.php');
   include(DIR_FS_LANGUAGES . SESSION_LANGUAGE . '/admin/customers.php');

if ($_GET['action']) {
switch ($_GET['action']) {

        case 'save':

        $memo_title = olc_db_prepare_input($_POST['memo_title']);
        $memo_text = olc_db_prepare_input($_POST['memo_text']);

        if ($memo_text != '' && $memo_title != '' ) {
          $sql_data_array = array(
            'customers_id' => $_POST['id'],
            'memo_date' => date("Y-m-d"),
            'memo_title' =>$memo_title,
            'memo_text' => nl2br($memo_text),
            'poster_id' => $_SESSION['customer_id']);

          olc_db_perform(TABLE_CUSTOMERS_MEMO, $sql_data_array);
          }
        break;

        case 'remove':
        olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_MEMO . " WHERE memo_id = '" . $_GET['mID'] . APOS);
        break;

}
}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo $page_title; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">

</head>
<body>
<div class="pageHeading">
	<?php 
		define('AJAX_TITLE',TITLE_MEMO);
		echo AJAX_TITLE;
	?>
</div></p>
    <table width="100%">
      <tr>
		  <?php
			echo olc_draw_form('customers_memo', 'popup_memo.php', "action=save&id=".(int)$_GET['id'], 'post');
		   //<form name="customers_memo" method="POST" action="popup_memo.php?action=save&id=<?php echo (int)$_GET['id'];?>">
			?>
        <td class="main" style="border-top: 1px solid; border-color: #cccccc;"><b><?php echo TEXT_TITLE ?></b>:<?php echo olc_draw_input_field('memo_title').olc_draw_hidden_field('id',(int)$_GET['id']); ?><br/><?php echo olc_draw_textarea_field('memo_text', 'soft', '73', '5'); ?><br/><?php echo olc_image_submit('button_insert.gif', IMAGE_INSERT); ?></td>
      </tr>
    </table></form>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">

  <tr>
    <td>



    <td class="main"><?php
  $memo_query = olc_db_query("SELECT
                                  *
                              FROM
                                  " . TABLE_CUSTOMERS_MEMO . "
                              WHERE
                                  customers_id = '" . (int)$_GET['id'] . "'
                              ORDER BY
                                  memo_id DESC");
  while ($memo_values = olc_db_fetch_array($memo_query)) {
    $poster_query = olc_db_query("SELECT customers_firstname, customers_lastname FROM " . TABLE_CUSTOMERS . " WHERE customers_id = '" . $memo_values['poster_id'] . APOS);
    $poster_values = olc_db_fetch_array($poster_query);
?><table width="100%">
      <tr>
        <td class="main"><hr noshade="noshade"/><b><?php echo TEXT_DATE; ?></b>:<i><?php echo $memo_values['memo_date']; ?><br/></i><b><?php echo TEXT_TITLE; ?></b>:<?php echo $memo_values['memo_title']; ?><br/><b>  <?php echo TEXT_POSTER; ?></b>:<?php echo $poster_values['customers_lastname']; ?> <?php echo $poster_values['customers_firstname']; ?></td>
      </tr>
      <tr>
        <td width="142" class="main" style="border: 1px solid; border-color: #cccccc;"><?php echo $memo_values['memo_text']; ?></td>
      </tr>
      <tr>
        <td><a href="<?php echo olc_href_link('popup_memo.php', 'id=' . $_GET['id'] . '&action=remove&mID=' . $memo_values['memo_id']); ?>" onclick="javascript:return confirm('<?php echo DELETE_ENTRY; ?>')"><?php echo olc_image_button('button_delete.gif', IMAGE_DELETE); ?></a></td>
      </tr>
    </table>
<?php
  }
?>
  </td>
    </td>
  </tr>
</table>

</body>
</html>