<?php
/* --------------------------------------------------------------
$Id: pdf_export.php,v 1.1.1.1.2.1 2007/04/08 07:16:18 gswkaiser Exp $

OL - COMMERCE
http://www.ol-commerce.de


--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(column_left.php,v 1.15 2002/01/11); www.oscommerce.com
(c) 2003	    nextcommerce (column_left.php,v 1.25 2003/08/19); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com
(c) 2005 ol-commerce; Manfred Tomanik www.ol-commerce.de

Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application_top.php');
if (VISITOR_PDF_CATALOGUE==TRUE_STRING_S)
{
	$class_path=DIR_FS_CATALOG."admin/";
	require($class_path.'pdf_export_common.php');
}
else
{

}
?>