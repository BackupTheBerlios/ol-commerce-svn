<?php
/* -----------------------------------------------------------------------------------------
$Id: newsletter.php,v 1.0

OLC-NEWSLETTER_RECIPIENTS RC1 - Contribution for OL-Commerce http://www.ol-commerce.com, http://www.seifenparadies.de
by Matthias Hinsche http://www.gamesempire.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce www.oscommerce.com
(c) 2003	    nextcommerce www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

olc_smarty_init($box_smarty,$cacheid);
require_once(DIR_FS_INC.'olc_draw_form.inc.php');
require_once(DIR_FS_INC.'olc_draw_input_field.inc.php');
require_once(DIR_FS_INC.'olc_image_button.inc.php');

$box_smarty->assign('FORM_ACTION', olc_draw_form('sign_in', olc_href_link(FILENAME_NEWSLETTER, '', SSL)));
$box_smarty->assign('FIELD_EMAIL', olc_draw_input_field('email',BOX_LOGINBOX_EMAIL));
$box_smarty->assign('BUTTON', olc_image_submit('button_send.gif', IMAGE_BUTTON_LOGIN));
$box_newsletter= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_newsletter'.HTML_EXT,$cacheid);
$smarty->assign('box_NEWSLETTER',$box_newsletter);
?>