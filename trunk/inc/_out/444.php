<?PHP
/* -----------------------------------------------------------------------------------------
$Id: olc_t_and_c_accepted.inc.php,v 1.1.1.1 2006/12/22 13:41:44 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com
(c) 2003	    nextcommerce (xsell_products.php,v 1.5 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contribution:
olc_t_and_c_accepted				Autor: Winfried Kaiser, w.kaiser@fortune.de

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
*/

// if conditions are not accepted, redirect the customer to the confirmation page
$error_message=EMPTY_STRING;
$conditions_text='conditions';
$fernag_text='fernag';
$conditions_accepted=$_POST[$conditions_text] == true;
if (!$conditions_accepted)
{
	$conditions_accepted=$_GET[$conditions_text] == true;
}
if (!$conditions_accepted)
{
	$error_message=ERROR_CONDITIONS_NOT_ACCEPTED;
}
$_SESSION[$conditions_text]=$conditions_accepted;
//	W. Kaiser
$fernag_accepted=$_POST[$fernag_text] == true;
if (!$fernag_accepted)
{
	$fernag_accepted=$_GET[$fernag_text] == true;
}
$_SESSION[$fernag_text]=$fernag_accepted;
if (!$fernag_accepted)
{
	if (strlen($error_message)>0)
	{
		$error_message.="\n\n";
	}
	$error_message.=ERROR_FERNAG_NOT_ACCEPTED;
}
$customers_order_reference_text='customers_order_reference';
$comments_text='comments';
$reference=$_POST[$customers_order_reference_text];
if (!$reference)
{
	$reference = $_GET[$customers_order_reference_text];
}
$_SESSION[$customers_order_reference_text] = $reference;
$comments=$_POST[$comments_text];
if (!$comments)
{
	$comments = $_GET[$customers_order_reference_text];
}
$_SESSION[$comments_text] = $comments;
//	W. Kaiser
if (strlen($error_message)>0)
{
	if (IS_AJAX_PROCESSING)
	{
		ajax_error($error_message);
	}
	else
	{
		olc_redirect(olc_href_link(FILENAME_CHECKOUT_CONFIRMATION,
		'error_message=' .nl2br($error_message)).
		AMP.$conditions_text.EQUAL.$_SESSION[$conditions_text].
		AMP.$fernag_text.EQUAL.$_SESSION[$fernag_text].
		AMP.$comments_text.EQUAL.$_SESSION[$comments_text].
		AMP.$customers_order_reference_text.EQUAL.$_SESSION[$customers_order_reference_text]
		);
	}
}
?>
