<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_get_free_shipping_amount.inc.php,v 1.0 2005/04/19 Winfried Kaiser

   OL-Commerce Version 1.0
   http://www.ol-commerce.com

   Copyright (c) 2004 OL-Commerce 
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com
   (c) 2003	    nextcommerce (olc_draw_selection_field.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// Determine order-amount for free shipping national/international

function olc_get_free_shipping_amount()
{
	//	W. Kaiser - Free shipping national/international
	global $order;

	if (!$order)
	{
		$order=new order;
	}
	if (MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING == TRUE_STRING_S)
	{
		$IsNational=$order->delivery['country_id'] == STORE_COUNTRY;
		switch (MODULE_ORDER_TOTAL_SHIPPING_DESTINATION)
		{
			case 'national':
			if ($IsNational)
			{
				$pass = true; break;
			}
			case 'international':
			if (!$IsNational)
			{
				$pass = true; break;
			}
			case 'both':
			$pass = true; break;
			default:
			$pass = false; break;
		}

		if ($pass)
		{

			//MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER
			$Pos=strpos(MODULE_SHIPPING_FREECOUNT_AMOUNT, ',');
			if ($Pos)
			{
				if ($IsNational)		//National order??
				{
					$FreeAmount = substr(MODULE_SHIPPING_FREECOUNT_AMOUNT, 0, $Pos);
				}
				else
				{
					$FreeAmount = substr(MODULE_SHIPPING_FREECOUNT_AMOUNT, $Pos + 1);
				}
			}
			else
			{
				$FreeAmount = MODULE_SHIPPING_FREECOUNT_AMOUNT;
			}
		}
	}
	else
	{
		$FreeAmount = 0;
	}
	define(FREE_AMOUNT,$FreeAmount);
	return $pass;
}
?>