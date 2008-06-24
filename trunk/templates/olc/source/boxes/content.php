<?php
/* -----------------------------------------------------------------------------------------
$Id: content.php,v 1.2 2004/02/17 16:20:07 fanta2k Exp $

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

olc_smarty_init($box_smarty,$cacheid);
$content_query=olc_db_query("
SELECT
content_id,
categories_id,
parent_id,
content_title,
content_group
FROM ".
TABLE_CONTENT_MANAGER."
WHERE
languages_id=".SESSION_LANGUAGE_ID." and
file_flag=1 and
content_status=1
order by sort_order,content_id");

$sep_line='
	<tr>
		<td colspan="2" valign="middle" style="font-size:1px">
			#
		</td>
	</tr>
';
$file=CURRENT_TEMPLATE_IMG.'img_underline.gif';
if (is_file(DIR_FS_CATALOG.$file))
{
	$underline=str_replace(HASH,olc_image($file),$sep_line);
}
else
{
	$underline=EMPTY_STRING;
}
$file=CURRENT_TEMPLATE_IMG.'bullet_c.gif';
if (is_file(DIR_FS_CATALOG.$file))
{
	$bullet=olc_image($file,EMPTY_STRING,EMPTY_STRING,EMPTY_STRING,'align="top"');
}
else
{
	$bullet=EMPTY_STRING;
}
$line0='
	<tr>
		<td valign="top">
'.$bullet.'
		</td>
		<td class="infoBoxContents" valign="top">
			#
		</td>
	</tr>
';
$start=HTML_A_START;
$term= HTML_A_END.$underline;
if (OL_COMMERCE)
{
	$s=olc_get_smarty_config_variable($box_smarty,'sitemap','heading_sitemap');
	$s = $start . olc_href_link(FILENAME_SITEMAP).'">'.$s . $term;
	$content_string=str_replace(HASH,$s,$line0);
	if (SHOW_PDF_CATALOG)
	{
		$s=olc_href_link(FILENAME_PDF_EXPORT,'u=true',NONSSL,false,false,false);
		$s=str_replace(strtolower(HTTPS),strtolower(HTTP),$s);
		$s = $start . $s.'" target="_blank">'.BOX_PDF_EXPORT . $term;
		$content_string.=str_replace(HASH,$s,$line0);
	}
	if (SHOW_GALLERY)
	{
		$s = $start . olc_href_link(FILENAME_GALLERY).'">'.TEXT_GALLERY . $term;
		$content_string.=str_replace(HASH,$s,$line0);
	}
	$content_string .= str_replace(HASH,HTML_HR,$sep_line);
}
else
{
	$content_string=EMPTY_STRING;
}

//W. Kaiser - AJAX
while ($content_data=olc_db_fetch_array($content_query))
{
	$s = $start . olc_href_link(FILENAME_CONTENT,'coID='.$content_data['content_group']) . '">' .
	$content_data['content_title'] . $term;
	$content_string.=str_replace(HASH,$s,$line0);
}
$content_string='
<table width="100%" border="0" cellpadding="0" cellspacing="0">
'.$content_string.'
</table>
';

$box_smarty->assign('BOX_CONTENT', $content_string);
$box_content= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_content'.HTML_EXT,$cacheid);
$smarty->assign('box_CONTENT',$box_content);
?>