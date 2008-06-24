<?php
/* -----------------------------------------------------------------------------------------
$Id: add_a_quickie.php,v 1.2 2004/02/17 16:20:07 fanta2k Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(add_a_quickie.php,v 1.10 2001/12/19); www.oscommerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contribution:
Add A Quickie v1.0 Autor  Harald Ponce de Leon

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

olc_smarty_init($box_smarty,$cacheid);
$box_content=olc_draw_form('quick_add', olc_href_link('index'.PHP),'get');
$box_smarty->assign('FORM_ACTION',$box_content);
$box_smarty->assign('INPUT_FIELD',olc_draw_hidden_field('action', 'buy_now') .
	olc_draw_input_field('BUYproducts_model',EMPTY_STRING,'size=10'));
$box_smarty->assign('SUBMIT_BUTTON',olc_image_submit('button_buy_now.gif', BOX_HEADING_ADD_PRODUCT_ID));
$box_add_a_quickie= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_add_a_quickie'.HTML_EXT,$cacheid);
$smarty->assign('box_ADD_A_QUICKIE',$box_add_a_quickie);
?>