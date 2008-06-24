<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_count_cart.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:11 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/


// counts total ammount of a product id in cart.

function olc_count_cart()
{
	$qty_text='qty';
	$id_text='id';
	$cart=$_SESSION['cart'];
	$id_list=$cart->get_product_id_list();
	$id_list= explode(COMMA_BLANK,$id_list);
	$actual_content=array();
	for ($i=0,$n=sizeof($id_list); $i<$n; $i++)
	{
		$current_id_list=$id_list[$i];
		$actual_content[]=array(
		$id_text=>$current_id_list,
		$qty_text=>$cart->get_quantity($current_id_list));
	}
	// merge product IDs
	$actual_content_text='actual_content';
	$content=array();
	for ($i=0,$n=sizeof($actual_content);$i<$n; $i++)
	{
		$actual_content_id=$actual_content[$i][$id_text];
		$pos=strpos($actual_content_id,'{');
		if ($pos!==false)
		{
			$act_id=substr($actual_content_id,0,$pos);
		}
		else
		{
			$act_id=$actual_content_id;
		}
		$_SESSION[$actual_content_text][$act_id]=
		array($qty_text=>$_SESSION[$actual_content_text][$act_id][$qty_text]+$actual_content[$i][$qty_text]);
	}
}
?>