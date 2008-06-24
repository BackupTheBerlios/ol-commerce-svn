<?php
/*
$Id: attributemanagerplaceholder.inc.php,v 1.1.1.1 2006/12/22 13:37:21 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Released under the GNU General Public License

Web Development
http://www.kangaroopartners.com
*/

require_once('attributemanager/includes/attributemanagerconfig.inc.php');
require_once('attributemanager/classes/stopdirectaccess.class.php');
stopdirectaccess::authorise(AM_SESSION_VALID_INCLUDE);
?>
<div id="attributemanager"></div>