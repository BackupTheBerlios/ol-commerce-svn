<?php
/*
osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2005 osCommerce

Released under the GNU General Public License

@Author: Raphael Vullriede (osc@rvdesign.de)

Port to OL-Commerce

@Author: Winfried Kaiser (w.kaiser@fortune.de)
*/

define('USE_AJAX_ATTRIBUTES_MANAGER',true);
// if the customer is not logged on, redirect them to the login page
require('includes/application_top.php');

if (!isset($_SESSION['customer_id'])) {
	olc_redirect(olc_href_link(FILENAME_LOGIN, EMPTY_STRING, NONSSL));
}

require(DIR_WS_INCLUDES . "header.php");
require(DIR_WS_INCLUDES . "html_head.php");

define('IS_AJAX_PROCESSING',false);
define('USE_AJAX',false);

// XML-Specification: https://www.google.com/webmasters/sitemaps/docs/de/protocol.html

define('CHANGEFREQ_CATEGORIES', 'weekly');  // Valid values are "always", "hourly", "daily", "weekly", "monthly", "yearly" and "never".
define('CHANGEFREQ_PRODUCTS', 'daily'); // Valid values are "always", "hourly", "daily", "weekly", "monthly", "yearly" and "never".

define('PRIORITY_CATEGORIES', '1.0');
define('PRIORITY_PRODUCTS', '0.5');

define('MAX_ENTRYS', 50000);
define('MAX_SIZE', 10000000);
define('GOOGLE_URL', 'http://www.google.com/webmasters/sitemaps/ping?sitemap=');

define('SITEMAPINDEX_HEADER',
'<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.google.com/schemas/sitemap/0.84"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84
	http://www.google.com/schemas/sitemap/0.84/siteindex.xsd">
');
define('SITEMAPINDEX_ENTRY',
"<sitemap>
	<loc>%s</loc>
	<lastmod>%s</lastmod>
</sitemap>
");
define('SITEMAPINDEX_FOOTER', '</sitemapindex>');

define('SITEMAP_HEADER',
'<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84
	http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">
');
define('SITEMAP_ENTRY',
"<url>
		<loc>%s</loc>
		<priority>%s</priority>
		<lastmod>%s</lastmod>
		<changefreq>%s</changefreq>
	</url>
");
define('SITEMAP_FOOTER', '</urlset>');

define('SITEMAP_CATALOG', HTTP_SERVER.DIR_WS_CATALOG);

$usegzip        = false;
$autogenerate   = false;
$output_to_file = false;
$notify_google  = false;
$notify_url     = EMPTY_STRING;

// request over http or command line?
if (!isset($_SERVER['SERVER_PROTOCOL']))
{
	if (count($_SERVER['argv'] > 1))
	{
		// option p ist only possible of min 1 more option isset
		if ( (strlen($_SERVER['argv'][1]) >= 2) && strpos($_SERVER['argv'][1], 'p') !== true) {
			$notify_google = true;
			$_SERVER['argv'][1] = str_replace('p', EMPTY_STRING, $_SERVER['argv'][1]);
		}
		switch($_SERVER['argv'][1]) {

			// dump to file
			case '-f':
			$output_to_file = true;
			$filename = $_SERVER['argv'][2];
			break;

			// dump to compressed file
			case '-zf':
			$usegzip        = true;
			$output_to_file = true;
			$filename = $_SERVER['argv'][2];
			break;

			// autogenerate sitemaps. useful for sites with more the 500000 Urls
			case '-a':
			$autogenerate = true;
			break;

			// autogenerate sitemaps and use gzip
			case '-za':
			$autogenerate   = true;
			$usegzip        = true;
			break;
		}
	}
} else {

	if (count($_GET) > 0) {
		// dump to file
		if (isset($_GET['f'])) {
			$output_to_file = true;
			$filename = $_GET['f'];
		}
		// use gzip
		$usegzip = $_GET['gzip'];
		// autogenerate sitemaps
		$autogenerate = $_GET['auto'];
		// notify google
		$notify_google = $_GET['ping'];
	}
}

// use gz... functions for compressed files
if ($usegzip) {
	$function_open  = 'gzopen';
	$function_close = 'gzclose';
	$function_write = 'gzwrite';
	$file_extension = '.xml.gz';
} else {
	$function_open  = 'fopen';
	$function_close = 'fclose';
	$function_write = 'fwrite';
	$file_extension = '.xml';
}

$c = 0;
$i = 1;

$sitemap_filename0='sitemap';
$sitemap_filename = $sitemap_filename0.$i.$file_extension;
$notify_url = SITEMAP_CATALOG.$sitemap_filename;
$sitemap_filename='../'.$sitemap_filename;
if ($autogenerate) {
	$filename = $sitemap_filename;
}
$autogenerate = $autogenerate || $output_to_file;
if ($autogenerate) {
	$fp = $function_open($filename, 'w');
	$main_content = "Sitemap-Datei '<b>" . realpath($filename) . "</b>' erstellt.";
}

output(SITEMAP_HEADER);
$strlen = strlen(SITEMAP_HEADER);

$cat_result = olc_db_query("
    SELECT
      c.categories_id,
      c.parent_id,
      cd.language_id,
      UNIX_TIMESTAMP(c.date_added) as date_added,
      UNIX_TIMESTAMP(c.last_modified) as last_modified,
      l.code
    FROM
      ".TABLE_CATEGORIES." c,
      ".TABLE_CATEGORIES_DESCRIPTION." cd,
      ".TABLE_LANGUAGES." l
    WHERE
    	c.categories_status='1' AND
      c.categories_id = cd.categories_id AND
      cd.language_id = l.languages_id
    ORDER by
      cd.categories_id
  ");

$cat_array = array();
if (olc_db_num_rows($cat_result) > 0) {
	while($cat_data = olc_db_fetch_array($cat_result)) {
		$cat_array[$cat_data['categories_id']][$cat_data['code']] = $cat_data;
	}
}
reset($cat_array);
$index_php='index.php';
$product_info_php='product_info.php';

foreach($cat_array as $lang_array) {
	foreach($lang_array as $cat_id => $cat_data) {
		//$lang_param = ($cat_data['code'] != DEFAULT_LANGUAGE) ? '&language='.$cat_data['code'] : EMPTY_STRING;
		$lang_param = '&language='.$cat_data['code'];
		$date = ($cat_data['last_modified'] != NULL) ? $cat_data['last_modified'] : $cat_data['date_added'];
		$string = sprintf(
			SITEMAP_ENTRY, htmlspecialchars(utf8_encode(olc_href_link_catalog($index_php,
			rv_get_path($cat_data['categories_id'], $cat_data['code']).$lang_param, NONSSL, false,
			USE_SEO,false))) ,PRIORITY_CATEGORIES, iso8601_date($date), CHANGEFREQ_CATEGORIES);
		$c_cat_total++;
		output_entry();
	}
}

$product_result = olc_db_query("
    SELECT
      p.products_id,
      pd.language_id,
      UNIX_TIMESTAMP(p.products_date_added) as products_date_added,
      UNIX_TIMESTAMP(p.products_last_modified) as products_last_modified,
      l.code
    FROM
      ".TABLE_PRODUCTS." p,
      ".TABLE_PRODUCTS_DESCRIPTION." pd,
      ".TABLE_LANGUAGES." l
    WHERE
      p.products_status='1' AND
      p.products_id = pd.products_id AND
      pd.language_id = l.languages_id
    ORDER BY
      p.products_id
  ");

if (olc_db_num_rows($product_result) > 0) {
	while($product_data = olc_db_fetch_array($product_result)) {
		//$lang_param = ($product_data['code'] != DEFAULT_LANGUAGE) ? '&language='.$product_data['code'] : EMPTY_STRING;
		$lang_param = '&language='.$product_data['code'];
		$date = ($product_data['products_last_modified'] != NULL) ?
			$product_data['products_last_modified'] : $product_data['products_date_added'];
		$string = sprintf(SITEMAP_ENTRY, htmlspecialchars(utf8_encode(olc_href_link_catalog($product_info_php,
			'products_id='.$product_data['products_id'].$lang_param, NONSSL, false, SEARCH_ENGINE_FRIENDLY_URLS,false))) ,
			PRIORITY_PRODUCTS, iso8601_date($date), CHANGEFREQ_PRODUCTS);
		$c_prod_total++;
		output_entry();
	}
}
output(SITEMAP_FOOTER);
if ($autogenerate) {
	$function_close($fp);
}
$main_content .= "<br/><br/>" . $c_cat_total . " <b>Kategorien</b> und " . $c_prod_total . " <b>Produkte</b> exportiert.";
// generates sitemap-index file
if ($autogenerate && $i > 1) {
	$sitemap_index_file = 'sitemap_index'.$file_extension;
	$main_content = $main_content . "<br/><br/>Sitemap-Index-Datei '<b>" . realpath($sitemap_index_file) . "</b>' erstellt.";
	$notify_url = SITEMAP_CATALOG.$sitemap_index_file;
	$fp = $function_open('sitemap_index'.$file_extension, 'w');
	$function_write($fp, SITEMAPINDEX_HEADER);
	for($ii=1; $ii<=$i; $ii++) {
		$function_write($fp, sprintf(SITEMAPINDEX_ENTRY, SITEMAP_CATALOG.$sitemap_filename0.$ii.$file_extension, iso8601_date(time())));
	}
	$function_write($fp, SITEMAPINDEX_FOOTER);
	$function_close($fp);
}

if ($notify_google)
{
	fopen(GOOGLE_URL.urlencode($notify_url), 'r');
	$google_response = file_get_contents(GOOGLE_URL . urlencode($notify_url));
	//Delete wrong Javascript in Google return page!!!!!
	$google_response=str_replace('document.domain="google.com";',EMPTY_STRING,$google_response);
	$main_content .= "<br/><br/>Google-Aufruf mit<br/><b>" . GOOGLE_URL . HTML_BR . $notify_url . "</b><br/><br/>" .
		'<b><font color="red">Google Antwort:</font></b><br/>' .	$google_response;
}

$smarty->assign('CONTENT_BODY',$main_content);
	$smarty->assign('BUTTON_CONTINUE',HTML_A_START . olc_href_link(FILENAME_START) . '">' .
	olc_template_image_button('button_continue.gif', 'Weiter') . HTML_A_END);
$main_content = $smarty->fetch(CURRENT_TEMPLATE_MODULE . 'google_sitemap'.HTML_EXT,SMARTY_CACHE_ID);

echo '
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
 ';
		require(DIR_WS_INCLUDES . "column_left.php");
echo '
		<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td>
        	<table width="100%" border="0">
          	<tr>
            	<td>
'.
$main_content.
'

			        </td>
			      </tr>
			    </table>
		    </td>
';
require(DIR_WS_INCLUDES . 'application_bottom.php');

if (!function_exists('olc_template_image_button')) {
	function olc_template_image_button($image, $alt = '', $params = '') {
		$button='../'.CURRENT_TEMPLATE_BUTTONS . $image;
		return olc_image($button, $alt, EMPTY_STRING, EMPTY_STRING, $params);
	}
}

// < PHP5
if (!function_exists('file_put_contents')) {
	function file_put_contents($filename, $content) {

		$fp = fopen($filename, 'w');
		fwrite($fp, $content);
		fclose($fp);
	}
}

// < PHP5
function iso8601_date($timestamp) {
	if (PHP_VERSION < 5) {
		$tzd = date('O',$timestamp);
		$tzd = substr(chunk_split($tzd, 3, ':'),0,6);
		return date('Y-m-d\TH:i:s', $timestamp) . $tzd;
	} else {
		return date('c', $timestamp);
	}
}

// generates cPath with helper array
function rv_get_path($cat_id, $code) {
	global $cat_array;

	$my_cat_array = array($cat_id);
	while($cat_array[$cat_id][$code]['parent_id'] != 0) {
		$my_cat_array[] = $cat_array[$cat_id][$code]['parent_id'];
		$cat_id = $cat_array[$cat_id][$code]['parent_id'];
	}
	return 'cPath='.implode('_', array_reverse($my_cat_array));
}

function output($string) {
	global $function_write, $fp, $autogenerate;

	if ($autogenerate) {
		$function_write($fp, $string);
	} else {
		echo $string;
	}
}

function output_entry()
{
	global $string, $strlen, $c, $autogenerate, $fp, $function_open, $function_close, $main_content, $strlen,$file_extension;

	output($string);
	$strlen += strlen($string);
	$c++;
	if ($autogenerate) {
		// 500000 entrys or filesize > 10,485,760 - some space for the last entry
		if ( $c == MAX_ENTRYS || $strlen >= MAX_SIZE) {
			output(SITEMAP_FOOTER);
			$function_close($fp);
			$c = 0;
			$i++;
			$filename = $sitemap_filename0.$i.$file_extension;
			$fp = $function_open($filename, 'w');
			$main_content .= "<br/>Sitemap-Datei '<b>" . realpath($filename) . "</b>' erstellt.";
			output(SITEMAP_HEADER);
			$strlen = strlen(SITEMAP_HEADER);
		}
	}
}

function olc_href_link_catalog($page = '', $parameters = '', $connection = NONSSL, $add_session_id = true,
	$search_engine_safe = true, $create_ajax_link = true)
{
	global $request_type, $session_started, $http_domain, $https_domain;

	if (olc_not_null($page))
	{
		$link = HTTP_SERVER.DIR_WS_CATALOG;
		if (olc_not_null($parameters))
		{
			$link .= $page . '?' . $parameters;
			//$separator = AMP;
		}
		else
		{
			$link .= $page;
			//$separator = '?';
		}

		while ((substr($link, -1) == AMP) || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);
		// Add the session id when moving from different HTTP and HTTPS servers, or when SID is defined
		if ($search_engine_safe)
		{
			return olc_seo_url($link);
		}
	}
	else
	{
		$die_error_text = '</td></tr></table></td></tr></table><br/><br/><font color="#ff0000">".
			"<b>Fehler!</b></font><br/><br/><b>Der Link ist nicht definiert!<br/><br/>';
		die($die_error_text);
	}
}
?>