<?php

/**
* ----------------------------------------------------------------------------
* Package: Tag-Cloud / xt:Commerce 3.0.4
* Copyright (c) 2007 by seo-one - Suchmaschinenoptimierung-Hamburg.de <info@seo-one.de>
* Hamburg, Germany
* ----------------------------------------------------------------------------
* Released under the GNU General Public License
* ----------------------------------------------------------------------------
* Original Author of file: Oliver Oestrup <oestrup@seo-one.de>
* ----------------------------------------------------------------------------
* Purpose: Display as box
* ----------------------------------------------------------------------------
**/

define('MODULE_TAG_CLOUD_MIN_SIZE', 10); // Größe in Pixel, in der ein Tag bei der geringsten Gewichtung dargestellt wird
define('MODULE_TAG_CLOUD_MAX_SIZE', 20); // Größe in Pixel, in der ein Tag bei der höchsten Gewichtung dargestellt wird
define('MODULE_TAG_CLOUD_MIN_WEIGHT', 100); // Fettung von 100 bis 900, in der ein Tag bei der geringsten Gewichtung dargestellt wird
define('MODULE_TAG_CLOUD_MAX_WEIGHT', 900); // Fettung von 100 bis 900, in der ein Tag bei der höchsten Gewichtung dargestellt wird
define('MODULE_TAG_CLOUD_MIN_COLOR', '999999'); // Farbe in Hex-Werten von 000000 bis FFFFFF, in der ein Tag bei der geringsten Gewichtung dargestellt wird
define('MODULE_TAG_CLOUD_MAX_COLOR', 'BA9715'); // Farbe in Hex-Werten von 000000 bis FFFFFF, in der ein Tag bei der höchsten Gewichtung dargestellt wird
define('MODULE_TAG_CLOUD_SHOW_SEARCH_INPUT', false); // Angabe true/false, ob das Suchfeld angezeigt werden soll

olc_smarty_init($box_smarty,$cacheid);

$search = false;
$tagList = array();

if(MODULE_TAG_CLOUD_SHOW_SEARCH_INPUT) {
	$search = array(
		'FORM_ACTION' => olc_draw_form('quick_find', olc_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get').olc_hide_session_id(),
		'INPUT_SEARCH' => olc_draw_input_field('keywords', '', 'size="20" maxlength="30"'),
		'BUTTON_SUBMIT' => olc_image_submit('button_quick_find.gif', IMAGE_BUTTON_SEARCH),
		'FORM_END' => '</form>',
		'LINK_ADVANCED' => olc_href_link(FILENAME_ADVANCED_SEARCH)
	);
}

$minSearches = (int)MODULE_TAG_CLOUD_MIN_SEARCHES;
if($minSearches < 1) {
	$minSearches = 1;
}

$maxDisplay = (int)MODULE_TAG_CLOUD_MAX_DISPLAY;
if($maxDisplay < 0) {
	$maxDisplay = 0;
}

$logFactor = (float)MODULE_TAG_CLOUD_LOG;
if($logFactor < 0) {
	$logFactor = 0;
}

$styleSizeMin = (int)MODULE_TAG_CLOUD_MIN_SIZE;
if($styleSizeMin < 1) {
	$styleSizeMin = 1;
}

$styleSizeMax = (int)MODULE_TAG_CLOUD_MAX_SIZE;
if($styleSizeMax < 1) {
	$styleSizeMax = 1;
}

$styleWeightMin = (int)MODULE_TAG_CLOUD_MIN_WEIGHT / 100;
if($styleWeightMin < 1) {
	$styleWeightMin = 1;
}
elseif($styleWeightMin > 9) {
	$styleWeightMin = 9;
}

$styleWeightMax = (int)MODULE_TAG_CLOUD_MAX_WEIGHT / 100;
if($styleWeightMax < 1) {
	$styleWeightMax = 1;
}
elseif($styleWeightMax > 9) {
	$styleWeightMax = 9;
}

$styleColorMin = array(
	base_convert(substr(MODULE_TAG_CLOUD_MIN_COLOR, 0, 2), 16, 10),
	base_convert(substr(MODULE_TAG_CLOUD_MIN_COLOR, 2, 2), 16, 10),
	base_convert(substr(MODULE_TAG_CLOUD_MIN_COLOR, 4, 2), 16, 10)
);

$styleColorMax = array(
	base_convert(substr(MODULE_TAG_CLOUD_MAX_COLOR, 0, 2), 16, 10),
	base_convert(substr(MODULE_TAG_CLOUD_MAX_COLOR, 2, 2), 16, 10),
	base_convert(substr(MODULE_TAG_CLOUD_MAX_COLOR, 4, 2), 16, 10)
);

$cloudLang = (int)$_SESSION['languages_id'];

$sortKeys = array();
$list = array();
$weightMin = null;
$weightMax = null;

$listQuery = olc_db_query(
	"SELECT tag, searches + offset AS weight ".
	"FROM module_tag_cloud ".
	"WHERE ".
		"language_id = ".$cloudLang." AND ".
		"searches >= ".$minSearches." AND ".
		"not_found = 0 ".
	"ORDER BY weight DESC, inserted DESC ".
	"LIMIT ".$maxDisplay
);

while($tag = olc_db_fetch_array($listQuery)) {
	$sortKeys[] = $tag["tag"];
	$list[] = array(
		"tag" => $tag["tag"],
		"weight" => $tag["weight"]
	);
	if(!isset($weightMin) || $weightMin > $tag["weight"]) {
		$weightMin = $tag["weight"];
	}
	if(!isset($weightMax) || $weightMax < $tag["weight"]) {
		$weightMax = $tag["weight"];
	}
}

array_multisort($sortKeys, $list);

foreach($list as $tag) {
	if($weightMax == $weightMin) {
		$tagWeight = 0.5;
	}
	else {
		$tagWeight = ($tag["weight"] - $weightMin) / ($weightMax - $weightMin);
	}
	
	if($logFactor) {
		$tagWeight = log($logFactor * $tagWeight + 1) / log($logFactor + 1);
	}
	
	$styleSize = round($tagWeight * ($styleSizeMax - $styleSizeMin) + $styleSizeMin);
	$styleWeight = round($tagWeight * ($styleWeightMax - $styleWeightMin) + $styleWeightMin) * 100;
	
	$styleColor = sprintf(
		"%02X%02X%02X",
		$tagWeight * ($styleColorMax[0] - $styleColorMin[0]) + $styleColorMin[0],
		$tagWeight * ($styleColorMax[1] - $styleColorMin[1]) + $styleColorMin[1],
		$tagWeight * ($styleColorMax[2] - $styleColorMin[2]) + $styleColorMin[2]
	);
	
	$tagList[] = array(
		"tag" => $tag["tag"],
		"link" => olc_href_link(FILENAME_ADVANCED_SEARCH_RESULT, 'searchTagCloud=1&keywords='.urlencode($tag["tag"]), 'NONSSL', false),
		"style" => array(
			"size" => $styleSize."px",
			"weight" => $styleWeight,
			"color" => "#".$styleColor
		)
	);
}


if ($search || count($tagList)) 
{
	$box_smarty->assign('search', $search);
	$box_smarty->assign('tagList', $tagList);
	$box_smarty->assign('link', "http://www.suchmaschinenoptimierung-hamburg.de/xtc-modules/".$_SESSION['language']."/tag-cloud.html");
	$box_smarty->assign('language', $_SESSION['language']);
	$box_tag_cloud = $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_tag_cloud'.HTML_EXT);
	$smarty->assign('box_TAG_CLOUD', $box_tag_cloud);
}
?>