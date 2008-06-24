<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_vpe_and_baseprice_info.inc.php 2006/03/09
OL-Commerce Version 1.2
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2006 Dipl.-Ing. (TH) W. Kaiser, w.kaiser@fortune.de
-----------------------------------------------------------------------------------------
based on:
XT-Commerce - community made shopping
http://www.xt-commerce.com

Copyright (c) 2003 XT-Commerce
Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//W. Kaiser - Baseprice

function olc_get_vpe_and_baseprice_info(&$this_object,$product_info,$products_price,$is_auction=false)
{
	$products_vpe_status=$product_info['products_vpe_status'];
	$products_min_order_quantity=max(1,$product_info['products_min_order_quantity']);
	$show_min_order_qty=$products_min_order_quantity>1;
	//Get price
	//Make sure we consider special prices!!!!
	$products_price=str_replace(HTML_NBSP,BLANK,$products_price);
	$s=explode(SESSION_CURRENCY,strip_tags($products_price));
	//Use normal price
	if (sizeof($s)>1 && $s[1]<>EMPTY_STRING)
	{
		//Use special price
		$s=explode(BLANK,trim($s[1]));
		$products_price0=$s[sizeof($s)-1];
	}
	else
	{
		$products_price0=$s[0];
	}
	//Eliminate currency
	$pos=strrpos($products_price0,BLANK);
	if ($pos)
	{
		$products_price0=substr($products_price0,0,$pos);
	}
	//Make sure price uses then correct decimal separator ('.')
	for ($i=strlen($products_price0)-1;$i>=0;$i--)
	{
		$s=substr($products_price0,$i,1);
		if (!is_numeric($s))
		{
			if ($s==COMMA)
			{
				$products_price0=str_replace($s,DOT,$products_price0);
			}
			break;
		}
	}
	olc_assign_vpe_and_baseprice_element($this_object,'PRODUCTS_REAL_PRICE',$products_price0);
	if ($products_vpe_status || $show_min_order_qty)
	{
		$products_baseprice_value=$product_info['products_baseprice_value'];
		$show_products_baseprice=$products_baseprice_value!=0.0;
		if ($show_min_order_qty)
		{
			if ($is_auction)
			{
				$products_price=$products_price0;
			}
			else
			{
				$products_price=$products_price0*$products_min_order_quantity;
			}
			$vpe_name0=split(COMMA,olc_get_vpe_name($product_info['products_min_order_vpe']));
			$products_min_order_quantity0=$products_min_order_quantity.BLANK.$vpe_name0[0];
			$products_min_order_quantity_text=$products_min_order_quantity0.
			LPAREN.ltrim(olc_format_price($products_price,true,true,true),BLANK.HTML_NBSP).RPAREN;
			$products_min_order_quantity_text=sprintf(TEXT_PRODUCTS_MIN_ORDER,$products_min_order_quantity_text);
			olc_assign_vpe_and_baseprice_element($this_object,'PRODUCTS_MIN_ORDER_QTY',$products_min_order_quantity_text);
		}
		if ($products_vpe_status)
		{
			$products_vpe_value=$product_info['products_vpe_value'];
			if ($products_vpe_value!=0.0)
			{
				//VPE == VPE-Einheit,VPE-Name, GRUNDPREIS-Anzeige-Name. (z.B. "cm,Länge,1m")
				//Wenn VPE-Name vorhanden, dann wird er der VPE-Einheit vorangestellt (z.B. "Länge: 1cm")
				$vpe_name0=split(COMMA,olc_get_vpe_name($product_info['products_vpe']));
				$vpe_type_name=$vpe_name0[1];
				$vpe_name="%s ".$vpe_name0[0];
				if ($vpe_type_name)
				{
					$vpe_name=$vpe_type_name.COLON_BLANK.$vpe_name;
				}
				if ($is_auction)
				{
					$vpe_name=$products_min_order_quantity0.COMMA.HTML_NBSP.$vpe_name;
					if ($show_min_order_qty)
					{
						$products_vpe_value=$products_vpe_value*$products_min_order_quantity;
					}
				}
				$vpe_name=sprintf($vpe_name,olc_format_price($products_vpe_value,false,false,false,false));
				olc_assign_vpe_and_baseprice_element($this_object,'PRODUCTS_VPE',$vpe_name);
				if ($show_products_baseprice)
				{
					$baseprice_show=$product_info['products_baseprice_show']==1;
					//Wenn der Basisipreis  i m m e r  angezeigt werden soll
					//(also auch wenn die entsprechende Produktoption nicht gesetzt ist)
					//dann die Kommentarmarken zu Beginn und Ende des nächsten Abschnitts löschen!
					//(Voraussetzung dafür ist allerdings, dass die VPE und das Vergleichs-Maß
					//des Basisipreises definiert sind!

					/*
					if (!$baseprice_show)
					{
					$baseprice_show=$products_baseprice_value<>$products_vpe_value;
					}
					*/
					if ($baseprice_show)
					{
						$products_price=$products_price0*($products_baseprice_value/$products_vpe_value);
						$products_price=olc_format_price($products_price,true,true,true);
						$products_baseprice_value=olc_format_price($products_baseprice_value,false,false,false);
						$baseprice_display_name=$vpe_name0[2];
						if ($baseprice_display_name)
						{
							$vpe_name=$baseprice_display_name;
						}
						else
						{
							$vpe_name=$products_baseprice_value.HTML_NBSP.$vpe_name0[0];
						}
						$products_baseprice_value=sprintf(TEXT_PRODUCTS_BASEPRICE,$vpe_name,$products_price);
						olc_assign_vpe_and_baseprice_element($this_object,'PRODUCTS_BASEPRICE',$products_baseprice_value);
					}
				}
			}
		}
	}
	$products_uvp=$product_info['products_uvp'];
	if ((float)$products_uvp>0)
	{
		if ($products_uvp>=$products_price0)
		{
			$products_uvp=ltrim(olc_format_price($products_uvp,true,true,true));
			if (CURRENT_SCRIPT==FILENAME_PDF_EXPORT)
			{
				$s=TEMPLATE_UVP_PRICE_SHORT;
			}
			else
			{
				$s=TEMPLATE_UVP_PRICE;
			}
			$products_uvp=sprintf($s,$products_uvp);
		}
		else
		{
			$products_uvp=EMPTY_STRING;
		}
		olc_assign_vpe_and_baseprice_element($this_object,'PRODUCTS_UVP',$products_uvp);
	}
}

function olc_price_adjust($price,$faktor)
{
	$price=$price*$faktor;
	return olc_format_price($price,true,true,true);
}

function olc_assign_vpe_and_baseprice_element(&$this_object,$element_name,$element_value)
{
	if (is_array($this_object))
	{
		//Assign value to Smarty data-array
		$this_object[$element_name]=$element_value;
	}
	else
	{
		//Assign value to Smarty object
		$this_object->assign($element_name,$element_value);
	}
}
//W. Kaiser - Baseprice
?>
