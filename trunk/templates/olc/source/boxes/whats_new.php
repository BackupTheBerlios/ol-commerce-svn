<?php
/* -----------------------------------------------------------------------------------------
$Id: whats_new.php,v 1.3 2004/03/16 14:59:01 fanta2k Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(whats_new.php,v 1.31 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (whats_new.php,v 1.12 2003/08/21); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contributions:
Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

define('SHOW_MARQUEE_WHATSNEW',true);

$show_marquee=SHOW_MARQUEE_WHATSNEW;// && IS_IE;

$Entries=MAX_DISPLAY_NEW_PRODUCTS;
if ($show_marquee)
{
	$Entries+=$Entries+$Entries;
	$upcoming_sql="
		or to_days(p.products_date_available) > to_days(now())
";
}
else
{
	$upcoming_sql=EMPTY_STRING;
}
if (OL_COMMERCE)
{
	$products_listing_sql="
	select distinct
	p.products_id,
	p.products_image,
	p.products_date_available,
	p.products_date_added,
	p.products_tax_class_id,
	p.products_price
	from " .
	TABLE_PRODUCTS . " p, " .
	TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " .
	TABLE_CATEGORIES . " c
	where
	p.products_status=1
	and p.products_id = p2c.products_id
	and p.products_id !=".(int)$_GET['products_id']."
	and p.products_image IS NOT NULL
	and
	(
		((p.products_date_available IS NULL AND to_days(p.products_date_added)>=(to_days(now())-90)) OR
			(
				p.products_date_available IS NOT NULL AND
				to_days(p.products_date_available)<=to_days(now()) AND
				to_days(p.products_date_available)>=(to_days(now())-90)
			)
		)
		".$upcoming_sql."
	)
	and c.categories_status=1
	and c.categories_id = p2c.categories_id
	#group_fsk18#
	order by p.products_date_added desc
	limit " . $Entries;
	$products_listing_template='box_whatsnew';
	$products_listing_type='neue Produkte';
	$smarty_listing_filename=FILENAME_PRODUCTS_NEW;
	$smarty_box_name="box_WHATSNEW";
	$heading_text="heading_whatsnew";
	include(DIR_FS_INC.'olc_prepare_specials_whatsnew_boxes.inc.php');
}
else
{
	include('templates/xtc4/source/boxes/whats_new.php');
}
?>