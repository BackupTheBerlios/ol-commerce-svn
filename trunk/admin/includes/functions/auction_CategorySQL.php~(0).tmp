<?php
function getCategoryPath($catid)
{
	$sqlstring = SELECT_ALL .TABLE_EBAY_CATEGORIES.SQL_WHERE;
	if ($catid)
	{
		$sqlstring.=" id=".$catid;
	}
	else
	{
		$sqlstring.=" parentid=0";
	}

	$recordset = olc_db_query($sqlstring);
	$catstring = EMPTY_STRING;
	do {
		$parentid = $row_name['parentid'];
		$name = htmlentities($row_name['name']);
	}
	while ($row_name = olc_db_fetch_array($recordset));
	if($parentid!=0)
	{
		$catstring .= getCategoryPath($parentid);
	}
	$catstring .= HTML_A_START.CURRENT_SCRIPT.'?catid='.$catid.'&x='.$_GET['x'].'" style="cursor:hand">'.
	$name.HTML_A_END.HTML_NBSP.'> ';
	return $catstring;
}

function revertCategoryPath($path)
{
	if ($path)
	{
		$path=str_replace(HTML_NBSP,BLANK,$path);
		$path=strip_tags(html_entity_decode($path));
		$path_x=explode(' > ',$path);
		$path_x=array_reverse($path_x);
		$path=implode($path_x,' < ');
		return LPAREN.$path.RPAREN;
	}
}

function getSubCategories($parentid){
	$recordset = olc_db_query(SELECT_ALL .TABLE_EBAY_CATEGORIES." where parentid='".$parentid."' order by name ASC");
	return $recordset;
}

function getRootCategories(){
	$sqlquery = SELECT_ALL .TABLE_EBAY_CATEGORIES." where parentid = 0 order by name ASC";
	$recordset = olc_db_query($sqlquery);
	return $recordset;
}

function insertVersion($onlineversion, $updatetime){
	$sqlstring = SQL_UPDATE.TABLE_EBAY_CONFIG.
	" SET `category_version` = '".$onlineversion."', `category_update_time` = '".$updatetime."' where id=1";
	$recordset = olc_db_query($sqlstring);
}

function browseCat4insert($catList){
	olc_db_query("TRUNCATE TABLE ".TABLE_EBAY_CATEGORIES);
	$comma="', ";
	$i=0;
	foreach ($catList as $cat) {
		$sqlstring = INSERT_INTO .TABLE_EBAY_CATEGORIES." (name, id, parentid, leaf, virtual, expired) VALUES ";
		$sqlstring .= "( ";
		$sqlstring .= APOS.addslashes(utf8_decode($cat->getCategoryName())).$comma;
		$sqlstring .= APOS.$cat->getCategoryId().$comma;
		$sqlstring .= APOS.$cat->getCategoryParentId().$comma;
		$sqlstring .= APOS.$cat->getLeafCategory().$comma;
		$sqlstring .= APOS.$cat->getIsVirtual().$comma;
		$sqlstring .= APOS.$cat->getIsExpired()	.APOS;
		$sqlstring .= " )";
		insertCategory($sqlstring);
	}
}

function insertCategory($sqlstring){
	olc_db_query($sqlstring);
}

function getCatVersion(){
	$sqlstring = SELECT ."category_version from ".TABLE_EBAY_CONFIG." where id=1";
	$recordset = olc_db_query($sqlstring);
	do {
		$version = $row_name['category_version'];
	}
	while ($row_name = olc_db_fetch_array($recordset));
	return $version;
}

function getCatUpdateTime(){
	$sqlstring = SELECT." category_update_time from  ".TABLE_EBAY_CONFIG." where id=1";
	$recordset = olc_db_query($sqlstring);
	do {
		$updatetime = $row_name['category_update_time'];
	}
	while ($row_name = olc_db_fetch_array($recordset));
	return $updatetime;
}

/*function createCatTables(){
	createCategoryTable();
	//createCategoryVersion();
}*/

function createCatTables(){
	$sqlstring =
	"CREATE TABLE IF NOT EXISTS " .TABLE_EBAY_CATEGORIES."  (
		name varchar(100) NOT NULL default '',
		id int(11) NOT NULL default '0',
		parentid int(11) NOT NULL default '0',
		leaf set('0','1') NOT NULL default '',
		virtual set('0','1') NOT NULL default '',
		expired set('0','1') NOT NULL default '',
		PRIMARY KEY  (id)
	);";
	olc_db_query($sqlstring);
}

/*function createCategoryVersion(){
	$sqlstring =
	"CREATE TABLE IF NOT EXISTS " . TABLE_EBAY_CONFIG."  (
		category_version varchar(5) NOT NULL default '',
		updateGTMTime timestamp NULL default CURRENT_TIMESTAMP
	)";
	olc_db_query($sqlstring);
}*/
?>