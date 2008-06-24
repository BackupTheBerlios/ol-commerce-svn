<?php
/* --------------------------------------------------------------
$Id: security_check.php,v 1.1.1.1.2.1 2007/04/08 07:16:46 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2003	    nextcommerce (security_check.php,v 1.2 2003/08/23); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

// config files
$config='config.inc.php';
$file_names = array(
'includes/configure.php',
'includes/configure.org.php',
'admin/includes/configure.php',
'admin/includes/configure.org.php',
'chCounter/includes/'.$config,
'elmar/'.$config);
$file= 'livehelp/config.php';
if (file_exists(DIR_FS_CATALOG . $file))
{
	$file_names[]=$file;
}
$files = sizeof($file_names);
$show_error_message=true;
for ($file = 0; $file < $files ; $file++)
{
	$file_name = DIR_FS_CATALOG . $file_names[$file];
	if (is_writeable($file_name))
	{
		if ($show_error_message)
		{
			$show_error_message=false;
			$error_flag=true;
		}
		$file_warning .= str_replace(DIR_FS_CATALOG,EMPTY_STRING,$file_name) . HTML_BR;
	}
}

$folder_flag==false;
$images='images/';
$media='media/';
$product_images=$images.'product_'.$images;
$file_names = array(
'cache/rss/','cache/adodb_cache/','cache/blz/', '/cache/cache/', 'download/', 'export/', 'import/', $images, $images.'categories/',
$images.'banner/',$images.'product_options',$images.'products_promotions',$images.'slideshow',
$product_images.'info_'.$images,$media, $media.'content/', $media.'products/',
$product_images.'original_'.$images,$product_images.'popup_'.$images,$product_images.'thumbnail_'.$images,
$product_images.'imagecache/','cache/pdfdocs/','cache/sessions/','cache/templates_c/');
$files = sizeof($file_names);
$show_error_message=true;
for ($file = 0; $file < $files ; $file++)
{
	$file_name = DIR_FS_CATALOG . $file_names[$file];
	if (!is_writeable($file_name)) {
		if ($show_error_message)
		{
			$show_error_message=false;
			$error_flag=true;
		}
		$folder_flag==false;
		$folder_warning .= str_replace(DIR_FS_CATALOG,EMPTY_STRING,$file_name) . HTML_BR;
	}
}

$dir=ADMIN_PATH_PREFIX.'olc_installer'.SLASH;
if (is_dir($dir))
{
	$error_flag=true;
	$install_warning=true;
}

if ($error_flag)
{
 ?>
<table class="security_check" border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		  <table width="100%" border="0" cellspacing="5" cellpadding="5">
		    <tr>
		      <td width="1"><?php echo olc_image(DIR_WS_ICONS.'big_warning.gif'); ?></td>
		      <td class="main">
			        <?php
			        if ($install_warning)
			        {
			        	include_once($dir.'language'.SLASH.SESSION_LANGUAGE.PHP);
			        	echo "<p>".TEXT_RENAME_DIR."</p>";
			        }
			        if ($file_warning)
			        {
			        	echo "<p>".TEXT_FILE_WARNING."</p>";
			        	echo HTML_B_START.$file_warning.'</b><br/>';
			        }
			        if ($folder_warning)
			        {
			        	echo "<p>".TEXT_FOLDER_WARNING."</p>";
			        	echo HTML_B_START.$folder_warning.HTML_B_END;
			        }
			        $payment_query=olc_db_query(SELECT_ALL.TABLE_CONFIGURATION.
			        " WHERE configuration_key = 'MODULE_PAYMENT_INSTALLED'");
			        while ($payment_data=olc_db_fetch_array($payment_query)) {
			        	$installed_payment=$payment_data['configuration_value'];
			        }
			        if ($installed_payment==EMPTY_STRING)
			        {
			        	echo "<p>".TEXT_PAYMENT_ERROR."</p>";
			        }
			        $shipping_query=olc_db_query("SELECT *  FROM ".TABLE_CONFIGURATION.
			        " WHERE configuration_key = 'MODULE_SHIPPING_INSTALLED'");
			        while ($shipping_data=olc_db_fetch_array($shipping_query))
			        {
			        	$installed_shipping=$shipping_data['configuration_value'];
			        }
			        if ($installed_shipping==EMPTY_STRING)
			        {
			        	echo "<p>".TEXT_SHIPPING_ERROR."</p>";
			        }
			?>
		      </td>
		    </tr>
		  </table>
		</td>
	</tr>
</table>
<?php
}
?>
