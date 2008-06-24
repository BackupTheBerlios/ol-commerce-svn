<?php
/* -----------------------------------------------------------------------------------------
$Id: specials.php,v 1.3 2004/03/16 14:59:01 fanta2k Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(specials.php,v 1.30 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (specials.php,v 1.10 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

define('SHOW_MARQUEE_SPECIALS',true);

$show_marquee=SHOW_MARQUEE_SPECIALS;

$Entries=MAX_DISPLAY_NEW_PRODUCTS;
if (!$show_marquee)
{
	$Entries+=$Entries;
}
if (OL_COMMERCE)
{
	$products_listing_sql="
	select distinct
	p.products_id,
	pd.products_name,
	pd.products_short_description,
	p.products_price,
	p.products_tax_class_id,
	p.products_image,
	s.expires_date,
	s.specials_new_products_price
	from " .
	TABLE_PRODUCTS . " p, " .
	TABLE_PRODUCTS_DESCRIPTION . " pd, " .
	TABLE_SPECIALS . " s
	where
	p.products_status = 1
	and p.products_id = s.products_id
	and pd.products_id = s.products_id
	and pd.language_id = " .SESSION_LANGUAGE_ID. "
	and s.status = 1
	#group_fsk18#
	order by s.specials_date_added
	limit " . $Entries;
	$products_listing_template='box_specials';
	$products_listing_type='Sonderangebote';
	$smarty_listing_filename=FILENAME_SPECIALS;
	$smarty_box_name="box_SPECIALS";
	$heading_text="heading_specials";
	include(DIR_FS_INC . 'olc_prepare_specials_whatsnew_boxes.inc.php');
}
else
{
	include('templates/xtc4/source/boxes/specials.php');
}
?>