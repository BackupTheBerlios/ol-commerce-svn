<?php
/* ------------------------------------------------
olc_cool_menu.inc.php

coolMenu for osCommerce
author:	Andreas Kothe
url:		http://www.oddbyte.de

modified 2006 for OL-Commerce v2/AJAX by Dipl.-Ing.(TH) Winfried Kaiser - www.seifenparadies.de

Released under the GNU General Public License
------------------------------------------------
*/

define('SUB_CATEGORIES',4);				//Max. # of subcategories

ob_start();
if (NOT_IS_ADMIN_FUNCTION)
{
	require_once(DIR_FS_INC.'olc_get_categories.inc.php');
	require_once(DIR_FS_INC.'olc_count_products_in_category.inc.php');
	$menu_entries = olc_get_categories(EMPTY_STRING);
}
require_once(DIR_FS_INC.'olc_image.inc.php');

$html_blank=array(HTML_NBSP,strtoupper(HTML_NBSP));
$html_break=array(HTML_BR,strtoupper(HTML_BR),"<p>","<P>");
$html_two_blanks=HTML_NBSP.HTML_NBSP;

/*
W. Kaiser - Note:

As this is originally an osCommerce-contribution, it is doing code-output "on the fly" (the dumb way!).

As we can not use this in the context of OL-Commerce/AJAX, we have to prevent that.

So we start PHPs' output-buffering, and let the module do the output.

At the end, we assign the output-buffer to a variable (which will be assigned to Smarty), and clear the output-buffering.
*/

$menu_image=BULLET;
$menu_start="	oCMenu.makeMenu('";
$top_text="top". UNDERSCORE;
$sub_text="sub". UNDERSCORE;
$sep="','";
$two_sep=$sep.$sep;
$sep_top_text=$sep.$top_text;
$sep_sub_text=$sep.$sub_text;
?>
<!-- coolMenu //-->
<!--
Copyright 2002 www.dhtmlcentral.com
modified for PHP and osCommerce by Andreas Kothe - www.oddbyte.de
modified for OL-Commerce v2/AJAX by Dipl.-Ing.(TH) Winfried Kaiser - www.seifenparadies.de
-->
<table>
  <tr>
    <td>
    	<div id="cool_menu">
<script type="text/javascript" language="javascript">

function cool_menu_init()
{
	oCMenu=new makeCM("oCMenu") //Making the menu object. Argument: menuname
	//Menu properties

	oCMenu.pxBetween=0
	oCMenu.fromLeft=<?php echo $initial_left_position.NEW_LINE;?>
	oCMenu.fromTop=<?php echo $initial_top_position.NEW_LINE;?>
	oCMenu.onresize="cool_menu_position();"
	oCMenu.rows=0
	oCMenu.menuPlacement="left"
	oCMenu.offlineRoot=""
	oCMenu.onlineRoot=""
	oCMenu.resizeCheck=1
	oCMenu.wait=500
	oCMenu.fillImg="<?php echo $image_path;?>tile.gif"
	oCMenu.zIndex=0
	//Background bar properties
	oCMenu.useBar=1
	oCMenu.barWidth="menu"
	oCMenu.barHeight="menu"
	oCMenu.barClass="clBar"
	oCMenu.barX="menu"
	oCMenu.barY="menu"
	oCMenu.barBorderX=0
	oCMenu.barBorderY=0
	oCMenu.barBorderClass=""
	oCMenu.level[0]=new cm_makeLevel()
	oCMenu.level[0].width=<?php echo $cell_width.NEW_LINE;?>
	oCMenu.level[0].height=<?php echo $cell_height.NEW_LINE;?>
	oCMenu.level[0].regClass="clLevel0"
	oCMenu.level[0].overClass="clLevel0over"
	oCMenu.level[0].borderX=1
	oCMenu.level[0].borderY=1
	oCMenu.level[0].borderClass="clLevel0border"
	//oCMenu.level[0].borderClass="clLevelAllborder"
	oCMenu.level[0].offsetX=0
	oCMenu.level[0].offsetY=0
	oCMenu.level[0].rows=0
	oCMenu.level[0].arrow="<?php echo $image_path;?>arrow.gif"
	oCMenu.level[0].arrowWidth=11
	oCMenu.level[0].arrowHeight=11
	oCMenu.level[0].align="right"
	//oCMenu.level[0].filter="progid:DXImageTransform.Microsoft.Fade(duration=0.8)"
	oCMenu.level[0].filter=""
	<?php
	for ($i=1; $i<SUB_CATEGORIES; $i++)
	{
		$menu_level='
	oCMenu.level[' . $i . ']';
		echo
		$menu_level.'=new cm_makeLevel()'.
		//$menu_level.'.width='.$cell_width.
		//$menu_level.'.height='.$cell_height.
		$menu_level.'.regClass="clLevel1"'.
		$menu_level.'.overClass="clLevel1over"'.
		$menu_level.'.borderX=1'.
		$menu_level.'.borderY=1'.
		$menu_level.'.align="right"'.
		$menu_level.'.offsetX=0'.
		$menu_level.'.offsetY=0'.
		$menu_level.'.borderClass="clLevel1border"'.
		$menu_level.'.align="right"'.
		$menu_level.'.filter=""';
	} // end for

	// ---
	function blank_length($text)
	{
		global $html_two_blanks;

		$count = 0;
		while (substr($text, 0,12) == $html_two_blanks)
		{
			$text = substr($text, 12);
			$count++;
		}
		return $count;
	}

	function print_menu_line($menu_entries, $depth_size,$depth_parentid, $depth,&$top_level_items)
	{
		global $html_blank,$html_break,$html_two_blanks,$menu_image;
		global $menu_start,$top_text,$sub_text,$sep,$two_sep,$sep_top_text;

		$size=0;
		for($i=0; $depth_size[$i]!=0; $i++)
		{
			$size++;
		}
		$size1=$size-1;
		$depth_size_0=$depth_size[0];
		$menu=$menu_start;
		if ($depth == 0)
		{
			$menu.=$top_text .$depth_size_0 .$two_sep;
			$top_level_items++;
		}
		else if ($depth == 1)
		{
			$menu.=$sub_text .$depth_size_0 .UNDERSCORE. $depth_size[1] .	$sep_top_text. $depth_size_0 . $sep;
		}
		else	 // $depth < 1
		{
			$menu.=$sub_text;
			for ($i=0; $i<$size; $i++)
			{
				$menu.=($depth_size[$i] != 0) ? UNDERSCORE.$depth_size[$i] : UNDERSCORE;
			}
			$menu.=$sep_sub_text;
			for ($i=0; $i<$size1; $i++)
			{
				$menu.=($depth_size[$i] != 0) ? UNDERSCORE.$depth_size[$i] : UNDERSCORE;
			}
			$menu.=$sep;
		}
		$menu.=$menu_image.$menu_entries['text'];			//Add leading menu image
		if (IS_ADMIN_FUNCTION)
		{
			$link=olc_href_link($menu_entries['link']);
		}
		else
		{
			if (SHOW_COUNTS == TRUE_STRING_S)
			{
				$products_in_category = olc_count_products_in_category($menu_entries['id']);
				if ($products_in_category > 0)
				{
					$menu.=HTML_NBSP."(" . $products_in_category . RPAREN;
				}
			}
			$cPathNew = "cPath=";
			for ($i=0; $i<$size-1; $i++)
			{
				$cPathNew .= ($depth_size[$i] != 0) ? $depth_parentid[$i].UNDERSCORE:EMPTY_STRING;
			}
			$cPathNew .= $menu_entries['id'];
			$link=olc_href_link(FILENAME_DEFAULT,$cPathNew);
			if (USE_AJAX)
			{
				//We need to make AJAX-links here, as "cool-menu" defines an "onclick"-handler for the menu-entries.
				//so these clicks will not "bubble" up to the common "onclick"-handler!
				$link=AJAX_REQUEST_FUNC_START.$link.AJAX_REQUEST_FUNC_END;
			}
		}
		$menu.='\',"' . $link. '"';
		$c=str_replace($html_blank,BLANK,$menu_entries['title']);
		$c=str_replace($html_break,NEW_LINE,$c);
		$c=html_entity_decode($c);
		$c=str_replace(QUOTE,APOS,$c);
		$c=strip_tags($c);
		$menu.=",\"" . $c . "\"".RPAREN.SEMI_COLON.NEW_LINE;
		echo $menu;
	}

	$depth=0;
	$blank_length=0;
	$depth_size=array();
	$depth_parentid=array();
	$top_level_items=0;
	$depth_text='depth';
	$text_text='text';
	$id_text='id';

	echo NEW_LINE;
	for($i=0; $i<count($menu_entries); $i++)
	{
		$blank_length = blank_length($menu_entries[$i][$text_text]);
		if($blank_length == $depth)
		{
			$menu_entries[$i][$depth_text] = $depth;
			$depth_size[$depth]++;
		}
		else if ($blank_length > $depth)
		{
			$depth++;
			$menu_entries[$i][$depth_text] = $depth;
			$depth_size[$depth]++;
		}
		else //if ($blank_length < $depth)
		{
			for ($j=$depth; $j>$blank_length; $j--)
			{
				$depth_size[$j] = 0;
				$depth--;
			}
			$menu_entries[$i][$depth_text] = $depth;
			$depth_size[$depth]++;
		}
		$depth_parentid[$menu_entries[$i][$depth_text]] = $menu_entries[$i][$id_text];
		// remove blanks
		$menu_entries[$i][$text_text] = substr($menu_entries[$i][$text_text], 12*$blank_length);
		print_menu_line($menu_entries[$i], $depth_size,$depth_parentid, $depth,	$top_level_items);
	}
	?>
	// create menu
//debug_stop();
	oCMenu.construct()
}

function cool_menu_position(check_position)
{
	cm_pos = findPos()
	var cm_left=cm_pos[0]+<?php echo $menu_left_adjust.NEW_LINE;?>
	var cm_top=cm_pos[1]+<?php echo $menu_top_adjust.NEW_LINE;?>
	var message="";
	if (check_position)
	{
		if (location.href.indexOf("localhost")!=-1)
		{
			message0="'Cool-Menu'-Hinweis für Browser '"+browser+"'\n\n"+
			"Der Wert von '$initial_#_position' in Datei '<?php echo ADMIN_PATH_PREFIX.TEMPLATE_PATH;?>"+current_template+
			"/source/boxes/categories_coolmenu.php' sollte '@' sein";
			if (oCMenu.fromLeft!=cm_left)
			{
				message=message0.replace(/#/,"left");
				message=message.replace(/@/,cm_left);
			}
			if (oCMenu.fromTop!=cm_top)
			{
				if (message.length>0)
				{
					message+="\n\n"
				}
				message=message0.replace(/#/,"top");
				message=message.replace(/@/,cm_top);
			}
		}
	}
	oCMenu.fromLeft=cm_left
	oCMenu.fromTop=cm_top
	oCMenu.construct(true)
	if (message.length>0)
	{
		alert(message)
	}
}
cool_menu_init();
</script>
    		<img src="images/pixel_trans.gif"
					height="<?php echo $cell_height*$top_level_items+$additional_menu_div_height;?>">
    	</div>
    </td>
  </tr>
</table>
<!-- coolMenu_eof //-->
<?php
$box_categories=ob_get_contents();
ob_end_clean();
?>
