<?php
/* -----------------------------------------------------------------------------------------
$Id: infobox.php,v 1.1 2004/02/07 23:02:54 fanta2k Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com
(c) 2003	    nextcommerce (infobox.php,v 1.7 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contributions:
Loginbox V1.0        	Aubrey Kilian <aubrey@mycon.co.za>
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
olc_smarty_init($box_smarty,$cacheid);
$img=$_SESSION['customers_status']['customers_status_image'];
if ($img!=EMPTY_STRING)
{
	$infoboxcontent = '<center>' . olc_image('admin/images/icons/'.$img) . '</center>';
}
$infoboxcontent .= BOX_LOGINBOX_STATUS . HTML_B_START . $_SESSION['customers_status']['customers_status_name'] . '</b><br/>';
if (CUSTOMER_SHOW_PRICE)
{
	if (NO_TAX_RAISED)
	{
		$price_disclaimer=BOX_LOGINBOX_NO_TAX_TEXT;
	}
	else
	{
		if (CUSTOMER_SHOW_PRICE_TAX)
		{
			$price_disclaimer=BOX_LOGINBOX_INCL;
		}
		else
		{
			$price_disclaimer=BOX_LOGINBOX_EXCL;
		}
	}
	$infoboxcontent .= $price_disclaimer.HTML_BR;
	if (CUSTOMER_OT_DISCOUNT != '0.00')
	{
		$infoboxcontent.=BOX_LOGINBOX_DISCOUNT . BLANK .	CUSTOMER_DISCOUNT . ' %<br/>';
		if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1)
		{
			$infoboxcontent .=
				BOX_LOGINBOX_DISCOUNT_TEXT . BLANK  . CUSTOMER_OT_DISCOUNT . ' % ' . BOX_LOGINBOX_DISCOUNT_OT . HTML_BR;
		}
	}
} else  {
	$infoboxcontent .= NOT_ALLOWED_TO_SEE_PRICES_TEXT;
}
if (CUSTOMER_ID)
{
	$button_your_account='button_your_account.gif';
	if (file_exists(CURRENT_TEMPLATE_BUTTONS. $button_your_account))
	{
		$infoboxcontent .= BOX_LOGINBOX_ACCOUNT;
		$infoboxcontent .= '<br/><center>
	    	<a href="' . olc_href_link(FILENAME_ACCOUNT, EMPTY_STRING) . '">' .
					olc_image_button($button_your_account, "Ihr Konto bearbeiten",  EMPTY_STRING,  EMPTY_STRING).'</a>&nbsp;
	    	<a href="' . olc_href_link(FILENAME_LOGOFF, EMPTY_STRING) . '">' .
					olc_image_button('button_logout.gif', "Einkauf beenden",  EMPTY_STRING,  EMPTY_STRING).'</a></center>';
	}
}
$box_smarty->assign('BOX_CONTENT', $infoboxcontent);
$box_infobox= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_infobox'.HTML_EXT,$cacheid);
$smarty->assign('box_INFOBOX',$box_infobox);
?>