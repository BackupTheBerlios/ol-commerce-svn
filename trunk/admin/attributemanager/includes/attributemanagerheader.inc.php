<?php
/*
$Id: attributemanagerheader.inc.php,v 1.1.1.1 2006/12/22 13:37:21 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Released under the GNU General Public License

Web Development
http://www.kangaroopartners.com

Adopted for OL-Commerce by: Dipl.-Ing.(TH) W. Kaiser, w.kaiser@fortune.de. 2/23/2006
*/

//W. Kaiser - AJAX
$productsId='productsId="'.$_GET['pID'].'"';
$pageAction='pageAction="'.$action.'"';
$sessionId='sessionId="'.olc_session_name().'='.olc_session_id().'"';
if (IS_AJAX_PROCESSING)
{
	$ajax_script_id++;
	define('AJAX_SCRIPT_'.$ajax_script_id,
	$productsId.'
	'.$pageAction.'
	'.$sessionId.'
	 goOnLoad()
	 ');
}
else
{
	$script.='
<!-- osc@kangaroopartners.com - AJAX Attribute Manager start-->
<script language="JavaScript" type="text/JavaScript" src="attributemanager/javascript/attributemanager.js"></script>
<link rel="stylesheet" type="text/css" href="attributemanager/css/attributemanager.css" />
<script language="JavaScript" type="text/javascript">
var '.$productsId.'
var '.$pageAction.'
var '.$sessionId.'

function goOnLoad()
{
//debug_stop();
	attributeManagerInit();
	SetFocus();
}
</script>
<!-- osc@kangaroopartners.com - AJAX Attribute Manager end-->
';
}
//W. Kaiser - AJAX
?>