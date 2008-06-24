<?php
/* --------------------------------------------------------------
$Id: auctions_getCategoriesSQL.php,v 1.1.1.1.2.1 2007/04/08 07:16:24 gswkaiser Exp $

v 0.1
http://www.lener.info/
This Part of auction.LISTER for ebay is Released under the GNU General Public License
For more informations contact andrea@lener.info

OL-Commerce Version 5.x/AJAX
http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce; www.oscommerce.com
(c) 2003	    nextcommerce; www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

$use_ajax=$_GET['ajax'];
if ($use_ajax)
{
	$x=$_GET['x'];
	$header_addon='
<script language="javascript"><!--
var submitted=false;

function set_cat_info(cat_id)
{
	window.opener.document.forms["auction_data"].elements["cat'.$x.'"].value = cat_id;
	window.close();
	return false;
}

function check_submit()
{
	if (submitted)
	{
		alert("'.AUCTIONS_TEXT_CATEGORIES_SUBMITTED.'");
		return false;
	}
	else
	{
		 submitted=true;
		 return true;
	}
}
//--></script>
';

	$is_periodic=true;
	$get_categories=true;
}
require('includes/application_top.php');
require_once $ebatns_dir.'EbatNs_ServiceProxy.php';
require_once $ebatns_dir.'GetCategoriesRequestType.php';
require_once $ebatns_dir.'GetCategoriesResponseType.php';
require_once $ebatns_dir.'CategoryType.php';
//include functions for save and browse category in db
require_once DIR_WS_FUNCTIONS.'auction_CategorySQL.php';

$main_content=
'<div id="main_content">
<h3>'.HTML_NBSP.AUCTIONS_TEXT_SUB_HEADER_CATEGORIES.'</h3>
';

//look if there is a category id in database
$catid=$_GET['catid'];
if (!isset($catid))
{
	$session=create_ebay_session();
	if ($session)
	{
		$cs = new EbatNs_ServiceProxy($session);
		$req = new GetCategoriesRequestType();
		//categories form ebay.de
		$req->CategorySiteID = 77;
		$req->LevelLimit = 1;
		$req->DetailLevel = 'ReturnHeaders';

		if (isset($_POST['updatecat']))
		{
			set_time_limit(0);
			//if button update is pressed
			//truncate old categories
			olc_db_query("TRUNCATE TABLE ".TABLE_EBAY_CATEGORIES);
			//return all categories
			$req->DetailLevel = 'ReturnAll';
			$req->LevelLimit = 1;
			$req->setCategoryParent(0);
			$res = $cs->GetCategories($req);
			$onlineversion = $res->getCategoryVersion();
			$updatetime = $res->getUpdateTime();
			//get root categories from api
			$catRootList = $res->getCategoryArray();

			//run through root list save them and get subcategories
			$comma="', ";
			$null="'0', ";
			$rparen=RPAREN;
			$detail_level = 'ReturnAll';
			$insert=INSERT_INTO .TABLE_EBAY_CATEGORIES." (name, id, parentid, leaf) VALUES (";
			for($j=0,$n=count($catRootList);$j<$n;$j++)
			{
				$mycattype = $catRootList[$j];
				$sqlstring = $insert;
				$sqlstring .= APOS.addslashes($mycattype->getCategoryName()).$comma;
				$sqlstring .= APOS.$mycattype->getCategoryID().$comma;
				$sqlstring .= $null;
				$sqlstring .= APOS.$mycattype->getLeafCategory().APOS.$rparen;
				olc_db_query($sqlstring);
				//subcategories
				$req1 = new GetCategoriesRequestType();
				$req1->DetailLevel = $detail_level ;
				$req1->LevelLimit = 255;
				$req1->setCategoryParent($mycattype->getCategoryID());
				$res1 = $cs->GetCategories($req1);
				//get subcategories from api and save them
				$catList = $res1->getCategoryArray();
				for($k=1,$m=count($catList);$k<$m;$k++){
					$mycattype1 = $catList[$k];
					$parentid = $mycattype1->getCategoryParentID();
					$sqlstring_sub = $insert;
					$sqlstring_sub .= APOS.addslashes($mycattype1->getCategoryName()).$comma;
					$sqlstring_sub .= APOS.$mycattype1->getCategoryID().$comma;
					$sqlstring_sub .= APOS.$parentid[0].$comma;
					$sqlstring_sub .= APOS.$mycattype1->getLeafCategory().APOS.$rparen;
					olc_db_query($sqlstring_sub);
				}
			}
			//update category version and update time in db
			insertVersion($onlineversion, date(AUCTIONS_DATE_FORMAT));
			$catid=0;
		}
		else
		{
			//check offlineversion of categories
			$updatetime = explode(BLANK,getCatUpdateTime());
			$localversion = getCatVersion();
			if ($localversion == BLANK)
			{
				$localversion = 0;
			}
			//if updatedate is not the same date then look for online category version
			if ($updatetime[0] < date("Y-m-d"))
			{
				$res = $cs->GetCategories($req);
				$onlineversion = $res->getCategoryVersion();
			}
			else
			{//else don't look - once a day is enough
				$onlineversion = $localversion;
			}
		}
	}
}
$a_start_cat=HTML_A_START.CURRENT_SCRIPT.'?catid=#&x='.$x.'" style="cursor:hand">';
if ($catid)
{
	$main_content.= HTML_B_START.AUCTIONS_TEXT_CATEGORIES_ROOT_PATH.HTML_B_END.HTML_HR.HTML_BR;
	$path = '<div width="275">'.getCategoryPath($catid).'</div>';
	$categories = getSubCategories($catid);
	$content= AUCTIONS_TEXT_CATEGORIES_SUB_CAT;
}
else
{
	//if onlineversion is equal to offlineversion
	if ($localversion == $onlineversion)
	{
		if ($localversion)
		{
			$main_content.= HTML_NBSP.sprintf(AUCTIONS_TEXT_CATEGORIES_VERSION_OK,$localversion);
			insertVersion($onlineversion, date(AUCTIONS_DATE_FORMAT));
		}
	}
	else
	{
		//download new category-tree
		$main_content.= HTML_NBSP.AUCTIONS_TEXT_CATEGORIES_DOWNLOAD.
		olc_draw_form("category",basename($PHP_SELF),'post',EMPTY_STRING,'onsubmit="check_submit()"').
		olc_draw_submit_button('updatecat',AUCTIONS_TEXT_CATEGORIES_CAT_UPDATE)."
		</form>
";
	}
	$path=EMPTY_STRING;
	$categories = getRootCategories();
	$content= HTML_NBSP.AUCTIONS_TEXT_CATEGORIES_ROOT_CAT;
}
if ($path)
{
	$main_content.=HTML_NBSP.
	str_replace(HASH,ZERO_STRING,$a_start_cat).AUCTIONS_TEXT_CATEGORIES_ROOT.HTML_A_END.' > '.$path.HTML_BR.HTML_BR;
}
$main_content.= HTML_HR.HTML_B_START.$content.HTML_B_END.HTML_BR.HTML_BR;
$main_content.=
olc_draw_form('form1',HASH).'
	<table border="0" cellpadding="0" cellspacing="2">';

$td_start= '<td class="dataTableContent"';
$td_start_left= $td_start.'>'.HTML_NBSP;
$td_start_right= $td_start.'align="right">';
$td_end= "</td>";
$row_start="<tr>".$td_start_left;
$row_end=$td_end."</tr>";
$name_text='name';
$id_text='id';
$leaf_text='leaf';
$lparen=LPAREN;
$rparen=RPAREN;
$submit=$td_end.$td_start_right.HASH.HTML_NBSP.$td_end.$td_start_left.HTML_NBSP.HTML_NBSP.
olc_draw_submit_button('choosencat',AUCTIONS_TEXT_SUBMIT_SELECT,'onclick="javascript:set_cat_info(\'#~\')" style="cursor:hand"');
$trailer=HTML_A_END.$td_end.$td_start_right.HASH.HTML_NBSP;
$tr_start_heading='<tr class="dataTableHeadingContent" align="center"><td>';
$main_content.=$tr_start_heading.AUCTIONS_TEXT_CATEGORIES_CATEGORY.$td_end.'<td>'.AUCTIONS_TEXT_CATEGORIES_ID.$td_end.$row_end;
while ($row_name = olc_db_fetch_array($categories))
{
	$name=$row_name[$name_text];
	if ($name)
	{
		$id=$row_name[$id_text];
		$name=str_replace(BLANK,HTML_NBSP,$name);
		if ($row_name[$leaf_text])
		{
			$content= $name.$submit;
			$desc=revertCategoryPath($path.$name);
		}
		else
		{
			$content= $a_start_cat.$name.$trailer;
			$desc=$name;
		}
		$content= str_replace(TILDE,addslashes($desc),$content);
		$main_content.= $row_start.str_replace(HASH,$id,$content).$row_end;
	}
}
$main_content.= "</table></form><div>";
echo $main_content;
?>
