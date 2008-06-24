<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_display_banner.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:20 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(banner.php,v 1.10 2003/02/11); www.oscommerce.com
(c) 2003	    nextcommerce (olc_display_banner.inc.php,v 1.3 2003/08/1); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// Display a banner from the specified group or banner id ($identifier)
function olc_display_banner($action, $identifier) {
	if ($action == 'dynamic') {
		$banners_query = olc_db_query(SELECT_COUNT." as count from " . TABLE_BANNERS . " where status = '1' and banners_group = '" . $identifier . APOS);
		$banners = olc_db_fetch_array($banners_query);
		if ($banners['count'] > 0) {
			$banner = olc_random_select("select banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_group = '" . $identifier . APOS);
		} else {
			return '<b>OLC ERROR! (olc_display_banner(' . $action . ', ' . $identifier . ') -> No banners with group \'' . $identifier . '\' found!</b>';
		}
	} elseif ($action == 'static') {
		if (is_array($identifier)) {
			$banner = $identifier;
		} else {
			$banner_query = olc_db_query("select banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_id = '" . $identifier . APOS);
			if (olc_db_num_rows($banner_query)) {
				$banner = olc_db_fetch_array($banner_query);
			} else {
				return '<b>OLC ERROR! (olc_display_banner(' . $action . ', ' . $identifier . ') -> Banner with id \'' . $identifier . '\' not found, or status inactive</b>';
			}
		}
	} else {
		return '<b>OLC ERROR! (olc_display_banner(' . $action . ', ' . $identifier . ') -> Unknown $action parameter value - it must be either \'dynamic\' or \'static\''.HTML_B_END;
	}

	if (olc_not_null($banner['banners_html_text'])) {
		$banner_string = $banner['banners_html_text'];
	} else {
		$banner_string = HTML_A_START . olc_href_link(FILENAME_REDIRECT, 'action=banner&goto=' . $banner['banners_id']) . '" target="_blank">' . olc_image(DIR_WS_IMAGES.'banner/' . $banner['banners_image'], $banner['banners_title']) . HTML_A_END;
	}

	olc_update_banner_display_count($banner['banners_id']);

	return $banner_string;
}
 ?>