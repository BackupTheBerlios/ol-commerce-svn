<?php
/* -----------------------------------------------------------------------------------------
$Id: livehelp.php,v 1.0 2006/10/10$

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(information.php,v 1.6 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (content.php,v 1.2 2003/08/21); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//Check is somebody is online
$department=2;	//intval($UNTRUSTED['department']);
$query = "SELECT *
          FROM livehelp_users,livehelp_operator_departments
          WHERE
          livehelp_users.user_id=livehelp_operator_departments.user_id AND
          livehelp_users.isonline='Y' AND
          livehelp_users.isoperator='Y' AND
          livehelp_operator_departments.department=".$department;
$online=olc_db_query($query);
$livehelp_show=olc_db_num_rows($online)>0;
$livehelp_show_text='livehelp_show';
$ping_mode=isset($_GET['p']);
if ($livehelp_show<>$_SESSION[$livehelp_show_text])
{
	$_SESSION[$livehelp_show_text]=$livehelp_show;
	if ($livehelp_show)
	{
		$dir='livehelp/';
		$box_content= '
<!-- Powered by: Crafty Syntax Live Help        http://www.craftysyntax.com/ -->
<a href="'.$dir.'livehelp.php?relative=Y&amp;department='.$department.'&amp;pingtimes=15" target="_blank" ><img src="'.DIR_WS_IMAGES.'livehelp.gif" border="0" title="'.LIVE_HELP_TITLE.'"></a>
';
		/*
		$box_content= '
		<!-- Powered by: Crafty Syntax Live Help        http://www.craftysyntax.com/ -->
		<a href="'.$dir.'livehelp.php?relative=Y&amp;department='.$department.'&amp;pingtimes=15" target="_blank" ><img src="'.$dir.'image.php?department='.$department.'&amp;what=getstate" border=0 ></a>
		<!--
		<a name=byRef href=http://www.craftysyntax.com  target="_blank"  ><img name=myIcon src="'.$dir.'image.php?what=getcredit&amp;department=2" border="0" ></a>
		-->
		*/

		$footer_content='<p>{'.olc_get_smarty_config_variable($smarty,'lievhelp','footer_content').'}</p>';

		$box_content.= '
<!-- copyright 2003 - 2006 by Eric Gerdes -->
'.$footer_content;
		$smarty->assign('BOX_CONTENT',$box_content);
		$box_content= $smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_livehelp'.HTML_EXT,$cacheid);
	}
	else
	{
		$box_content=HTML_NBSP;
	}
	if ($ping_mode)
	{
		echo $box_content;
	}
	else
	{
		$smarty->assign('box_LIVEHELP',$box_content);
	}
}
elseif (IS_AJAX_PROCESSING)
{
	if ($ping_mode)
	{
		echo AJAX_NODATA;			//Finalize AJAX request
	}
}
?>