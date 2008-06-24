<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Configuration file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.1.0, 2003-03-27
// ================================================

if (!defined('HTTP_SERVER'))
{
	//Include OL-Commerce config!!!!
	$s=$_SERVER['REQUEST_URI'];
	$pos=strpos($s,'/dialogs');
	if ($pos!==false)
	{
		$level='../';
	}
	else 
	{
		$level='';
	}
	include $level.'../../configure.php';
}
if ($_SERVER['HTTPS'] != null)
{
	$spaw_base_url = HTTPS_SERVER;
}
else
{
	$spaw_base_url = HTTP_SERVER;
}
$spaw_root='spaw/';
$spaw_dir = $spaw_base_url.DIR_WS_ADMIN.DIR_WS_CLASSES.$spaw_root;
$spaw_root = DIR_FS_ADMIN.DIR_WS_CLASSES.$spaw_root;
//echo "spaw_root -- ".$spaw_root.HTML_BR;

$spaw_default_toolbars = 'default';
$spaw_default_theme = 'default';
$spaw_default_lang = 'de';
$spaw_default_css_stylesheet = $spaw_dir.'wysiwyg.css';


/*
// base url for images
$spaw_base_url = '/';

if (isset($_SERVER))
  $_spawsrvvars = $_SERVER;
else
  $_spawsrvvars = $HTTP_SERVER_VARS;

// calculate root folder for spaw files
$spaw_root = realpath(dirname(__FILE__)."/..");
$spaw_root = str_replace("\\","/",$spaw_root);
if (!ereg('/$', $spaw_root))
  $spaw_root = $spaw_root."/";

// directory where spaw files are located
$spaw_dir = str_replace(str_replace("\\","/",$_spawsrvvars['DOCUMENT_ROOT']),'',$spaw_root);
if (!ereg('^/', $spaw_dir))
  $spaw_dir = "/".$spaw_dir;

$spaw_default_toolbars = 'default';
$spaw_default_theme = 'default';
$spaw_default_lang = 'de';
$spaw_default_css_stylesheet = $spaw_dir.'wysiwyg.css';
*/
// add javascript inline or via separate file
$spaw_inline_js = false;

// use active toolbar (reflecting current style) or static
$spaw_active_toolbar = true;

// default dropdown content
$spaw_dropdown_data['style']['default'] = 'Normal';

$spaw_dropdown_data['table_style']['default'] = 'Normal';

$spaw_dropdown_data['td_style']['default'] = 'Normal';

$spaw_dropdown_data['font']['Arial'] = 'Arial';
$spaw_dropdown_data['font']['Courier'] = 'Courier';
$spaw_dropdown_data['font']['Tahoma'] = 'Tahoma';
$spaw_dropdown_data['font']['Times New Roman'] = 'Times';
$spaw_dropdown_data['font']['Verdana'] = 'Verdana';

$spaw_dropdown_data['fontsize']['1'] = '1';
$spaw_dropdown_data['fontsize']['2'] = '2';
$spaw_dropdown_data['fontsize']['3'] = '3';
$spaw_dropdown_data['fontsize']['4'] = '4';
$spaw_dropdown_data['fontsize']['5'] = '5';
$spaw_dropdown_data['fontsize']['6'] = '6';

// in mozilla it works only with this settings, if you don't care
// about mozilla you can change <H1> to Heading 1 etc.
// this way it will be reflected in active toolbar
$spaw_dropdown_data['paragraph']['Normal'] = 'Normal';
$spaw_dropdown_data['paragraph']['<H1>'] = 'Heading 1';
$spaw_dropdown_data['paragraph']['<H2>'] = 'Heading 2';
$spaw_dropdown_data['paragraph']['<H3>'] = 'Heading 3';
$spaw_dropdown_data['paragraph']['<H4>'] = 'Heading 4';
$spaw_dropdown_data['paragraph']['<H5>'] = 'Heading 5';
$spaw_dropdown_data['paragraph']['<H6>'] = 'Heading 6';

// image library related config

// allowed extentions for uploaded image files
$spaw_valid_imgs = array('gif', 'jpg', 'jpeg', 'png');

// allow upload in image library
$spaw_upload_allowed = true;

// allow delete in image library
$spaw_img_delete_allowed = true;

// image library related config

// allowed extentions for uploaded image files
$spaw_valid_imgs = array('gif', 'jpg', 'jpeg', 'png');
// allow upload in image library
$spaw_upload_allowed = true;
// image libraries
$spaw_imglibs = array(
  array(
    'value'   => DIR_WS_CATALOG_IMAGES.'content/',
    'text'    => 'Images-Content',
  ),
  array(
    'value'   => DIR_WS_CATALOG_INFO_IMAGES,
    'text'    => 'Produkte - Produkt-Info',
  ),
    array(
    'value'   => DIR_WS_CATALOG_ORIGINAL_IMAGES,
    'text'    => 'Produkte - Original',
  ),
    array(
    'value'   => DIR_WS_CATALOG_POPUP_IMAGES,
    'text'    => 'Produkte - Popup',
  ),
      array(
    'value'   => DIR_WS_CATALOG_POPUP_IMAGES,
    'text'    => 'Produkte - Thumbnails',
  )
);

// file to include in img_library.php (useful for setting $spaw_imglibs dynamically
// $spaw_imglib_include = '';

// allowed hyperlink targets
$spaw_a_targets['_self'] = 'Self';
$spaw_a_targets['_blank'] = 'Blank';
$spaw_a_targets['_top'] = 'Top';
$spaw_a_targets['_parent'] = 'Parent';

// image popup script url
$spaw_img_popup_url = $spaw_dir.'img_popup.php';

// internal link script url
$spaw_internal_link_script = 'url to your internal link selection script';

// disables style related controls in dialogs when css class is selected
$spaw_disable_style_controls = true;

// disables stripping domain part from local urls
$spaw_disable_absolute_url_stripping = false;

// disables xhtml output (browser generated code)
$spaw_disable_xhtml = false;

?>
