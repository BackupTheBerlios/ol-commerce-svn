<?php
/* ------------------------------------------------
coolMenu for osCommerce
author:	Andreas Kothe
url:		http://www.oddbyte.de
modified for olCommerce v2/AJAX by Dipl.-Ing.(TH) Winfried Kaiser - www.seifenparadies.de
Released under the GNU General Public License
------------------------------------------------
*/
// --- CONFIGURATION ---
$cell_height=15;									//Height of one menu entry
//Most likely you need to adjust these values for your template
//in order to achieve a proper layout and placement of the menu
$cell_width=195;									//Width of menu-block

$menu_top_adjust=0;								//Adjustment for calculated "top" position of menu-block
$menu_left_adjust=-7;							//Adjustment for calculated "left" position of menu-block

$initial_top_position=282;				//Approx. initial "top" position of  menu-block
$initial_left_position=16;				//Approx. initial "left" position of  menu-block

if (strpos(USER_AGENT,'msie')!==false)
{
	$initial_top_position=262;				//Approx. initial "top" position of  menu-block
	$initial_left_position=13;				//Approx. initial "left" position of  menu-block
}
elseif (strpos(USER_AGENT,'gecko')!==false)
{
	$initial_top_position=296;				//Approx. initial "top" position of  menu-block
	$initial_left_position=15;				//Approx. initial "left" position of  menu-block
	$parameters='align="top"';				//Alignment parameter for "bullet.gif"
}
elseif (strpos(USER_AGENT,'opera')!==false)
{
	//$menu_top_adjust_browser=29;
	$initial_top_position=251;				//Approx. initial "top" position of  menu-block
}
elseif (strpos(USER_AGENT,'safari')!==false)
{

}
include(DIR_FS_INC.'olc_cool_menu.inc.php');
?>
