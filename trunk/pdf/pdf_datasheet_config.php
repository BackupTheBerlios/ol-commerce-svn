<?php
/*
$Id: pdf_datasheet_config.php,v 1.1.1.1 2006/12/22 13:49:06 gswkaiser Exp $
osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com
Copyright (c) 2003 osCommerce
Released under the GNU General Public License
Modified by Jochen Kirchhoff, jochen888@web.de

Adapted for OL-Commerce by W. Kaiser, w.kaiser@fortune.de

Most of the config date has been moved to the Admin Config area!

*/

// Height for products descriptions, needed for pagebreak calcultations
define('PDF_TEXT_HEIGHT', 240);

//redirect to the file or download it (1->redirect,0-<download)
//	define('FILE_REDIRECT', 0);
//indicate the name of the DB field containing the alternate image (es.: $products_bimage)
define('PDF_ALT_IMAGE', 'products_image');   //If an image other than the small std. image is used

// BOF Mod for 3 Images Contrib
if(PDF_ALT_IMAGE == 'products_image') {
	define('DIR_IMAGE', DIR_WS_IMAGES);
}
elseif(PDF_ALT_IMAGE == 'products_image_medium'){
	define('DIR_IMAGE', DIR_WS_IMAGES . 'medium/');
}
elseif(PDF_ALT_IMAGE == 'products_image_large'){
	define('DIR_IMAGE', DIR_WS_IMAGES . 'large/');
}
// EOF Mod for 3 Images Contrib

?>