<?php
/* -----------------------------------------------------------------------------------------
$Id: order_steps.php,v 1.1.1.1 2004/02/17 16:20:07 fanta2k Exp $

OL-Commerce Version 2.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(information.php,v 1.6 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (content.php,v 1.2 2003/08/21); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

olc_smarty_init($box_smarty,$cacheid);
require_once(DIR_FS_INC.'olc_get_smarty_config_variable.inc.php');
$normal='normal';
$classes=array(EMPTY_STRING,$normal,$normal,$normal,$normal);
$classes[$order_step]='high';
$step_text_finished=EMPTY_STRING;
if ($order_step<4)
{
	$links=array(EMPTY_STRING,FILENAME_CHECKOUT_SHIPPING,FILENAME_CHECKOUT_PAYMENT);
	$titles=array(EMPTY_STRING,ORDER_STEP_1_TITLE,ORDER_STEP_2_TITLE);
}
switch ($order_step)
{
	case 1:
		$step_text='ship';
		break;
	case 2:
		$step_text='payment';
		break;
	case 3:
		$step_text='order';
		break;
	case 4:
		$step_text='success';
		$step_text_finished=UNDERSCORE.'finished';
		break;
}
$class_order_step_text='class_';
$class_order_link_start_text='LINK_START_';
$class_order_link_end_text='LINK_END_';
for ($i=1;$i<=4;$i++)
{
	if ($i<3)
	{
		if ($i<$order_step)
		{
			$box_smarty->assign($class_order_link_start_text.$i,
				HTML_A_START.olc_href_link($links[$i]).'" title="'.$titles[$i].'" style="cursor:hand">');
			$box_smarty->assign($class_order_link_end_text.$i,HTML_A_END);
		}
	}
	$box_smarty->assign($class_order_step_text.$i,$classes[$i]);
}
$order_steps_text='order_steps';
$box_template=BOX.$order_steps_text;
$is_graphic_mode=is_file(CURRENT_TEMPLATE_IMG.$order_steps_text.'_1_normal.gif');
if ($is_graphic_mode)
{
	$box_template.=UNDERSCORE."graphic";
}
$step_text=olc_get_smarty_config_variable($box_smarty,$order_steps_text,$step_text.'_text');
$you_are_here_text='you_are_here_text'.$step_text_finished;
$you_are_here_text=olc_get_smarty_config_variable($box_smarty,$order_steps_text,$you_are_here_text);
if ($order_step==4)
{
	$step_text=$you_are_here_text;
}
else
{
	$step_text=sprintf($you_are_here_text,(4-$order_step),$order_step.DOT.BLANK.$step_text);
}
$box_smarty->assign('step_text',$step_text);

$box_content= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.$box_template.HTML_EXT,$cacheid);
$smarty->assign('ORDER_STEPS',$box_content);
?>
