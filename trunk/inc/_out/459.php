<?PHP
/* -----------------------------------------------------------------------------------------
$Id: olc_ajax_prepare_special_html_chars.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:09 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(banner.php,v 1.10 2003/02/11); www.oscommerce.com
(c) 2003	    nextcommerce (olc_activate_banners.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com
(c) 2006	Winfried Kaiser, w.kaiser@fortune.de

Released under the GNU General Public License
---------------------------------------------------------------------------------------

Replace special HTML-chars ("<,>,&nbsp;") to other codes,
to prevent them from being converted by "htmlentities".
Otherwise, our HTML-code would be broken!

W. Kaiser - AJAX

*/

function olc_ajax_prepare_special_html_chars($html_text)
{
	$chars_to_ignore=array("<",">",HTML_NBSP,HTML_NDASH,HTML_MDASH,AMP);	//Extend if needed!
	$char_pos=128;
	for ($i=0;$i<sizeof($chars_to_ignore);$i++)
	{
		$chars_to_replace_ignores_with[]=chr($char_pos);
		$char_pos++;
	}
	$html_text = str_replace($chars_to_ignore,$chars_to_replace_ignores_with,$html_text);
	//Convert non-standard chars to their HTML-equivalent,
	//as the browser won't do that for us in AJAX-mode!!
	$html_text = htmlentities($html_text,ENT_NOQUOTES);
	//Restore special HTML-chars
	return str_replace($chars_to_replace_ignores_with,$chars_to_ignore,$html_text);
}
?>
