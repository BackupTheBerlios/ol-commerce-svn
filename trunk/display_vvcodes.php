<?php
/* -----------------------------------------------------------------------------------------
$Id: display_vvcodes.php 831 2005-03-13 10:16:09Z mz $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:

Copyright (c) 2004 XT-Commerce

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

require ('includes/application_top.php');
require_once (DIR_FS_INC.'olc_render_vvcode.inc.php');
require_once (DIR_FS_INC.'olc_random_charcode.inc.php');

$visual_verify_code = olc_random_charcode(6);
$_SESSION['vvcode'] = $visual_verify_code;
$vvimg = vvcode_render_code($visual_verify_code);
?>