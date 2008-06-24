<?php
/* -----------------------------------------------------------------------------------------
$Id: product_thumb.php,v 1.1.1.1.2.1 2007/04/08 07:16:19 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_round.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// This is "On the Fly Thumbnailer with Caching Option" by Pallieter Koopmans.
// Based on Marcello Colaruotolo (1.5.1) which builds upon Nathan Welch (1.5)
// and Roberto Ghizzi. With improvements by @Quest WebDesign, http://atQuest.nl/
//
// Scales product images dynamically, resulting in smaller file sizes, and keeps
// proper image ratio.
//
// Used in conjunction with modified tep_image in html_output.php (see: readme.txt).
//
// CONFIGURATION SETTINGS
//
// Use Resampling? Set the value below to true to generate resampled thumbnails
// resulting in smoother-looking images. Not supported in GD ver. < 2.01
$use_resampling = true;
//
// Create True Color Thumbnails? Better quality overall but set to false if you
// have GD version < 2.01 or if creating transparent thumbnails.
$use_truecolor = true;
//
// Output GIFs as JPEGS? Set this option to true if you have GD version > 1.6
// and want to output GIF thumbnails as JPGs instead of GIFs or PNGs. Note that your
// GIF transparencies will not be retained in the thumbnail if you output them
// as JPGs. If you have GD Library < 1.6 with GIF create support, GIFs will
// be output as GIFs. Set the "matte" color below if setting this option to true.
$gif_as_jpeg = false;
//
// Cache Images? Set to true if you want to create cached images for each thumbnail.
// This will add to disk space but will save your processor from having to create
// the thumbnail for every visitor.
//$tn_cache = true;
$tn_cache = isset($_GET['c']);		// Take caching info as a parameter in order to allow setting a shop parameter.
//
// Define RGB Color Value for background matte color if outputting GIFs as JPEGs
// Example: white is r=255, b=255, g=255; black is r=0, b=0, g=0; red is r=255, b=0, g=0;
$r = 255; // Red color value (0-255)
$g = 255; // Green color value (0-255)
$b = 255; // Blue color value (0-255)
//
// Allow the creation of thumbnail images that are larger than the original images:
$allow_larger = false; // The default is false.
// If allow_larger is set to false, you can opt to output the original image:
// Better leave it true if you want pixel_trans_* to work as expected
$show_original = true; // The default is true.
//
// END CONFIGURATION SETTINGS

// Note: In order to manually debug this script, you might want to comment
// the three header() lines -- otherwise no output is shown.

// Get the size of the image:
define('DOT','.');

$img=$_GET['img'];
$img=str_replace(array('~1','~2'),array('&','.'),$img);
$img_base=$img;
$product_images='images/product_images/';
$img=$product_images.'original_images/'.$img_base;
$image_target_height=$_GET['h'];
$image_target_width=$_GET['w'];
$image_origin=$_GET['t'];
$use_extended_version=isset($_GET['e']);		//Use slower (extended) version
$pos=strrpos($img_base,DOT);
$base_img=substr($img_base,0,$pos);
//If original image is to be displayed, use original image, unless extended manipulation is required.
$is_original=$image_origin=='ORIGINAL';
if ($use_extended_version)
{
	$img_type='jpg';
	$image_type = 2;

}
else
{
	$img_type=substr($img_base,$pos+1);
	switch ($img_type)
	{
		case "jpg" or "jpeg":
			$quality=$_GET['q'];
			break;
		case "gif":
			if (!$gif_as_jpeg)
			{
				$image_type = 1;
				$img_type='gif';
			}
			break;
		case "png":
			$image_type = 3;
			$img_type='png';
			break;
		default:
			//Wrong type
			create_error_image();
	}
}
// Create appropriate image header:
header('Content-type: image/'.$img_type);
// If you are required to set the full path for file_exists(), set this:
// $cache_file = '/your/path/to/catalog/'.$cache_file;
$use_cached_image=false;
if ($tn_cache || $is_original)
{
	if ($is_original)
	{
		$cache_file=$img;
		$tn_cache=false;
	}
	else
	{
		$cache_file=$base_img.'_'.$image_target_width.'_x_'.$image_target_height.DOT.$img_type;
		$cache_file = $product_images."imagecache/".$cache_file;
	}
	if (file_exists($cache_file))
	{
		if (filemtime($cache_file) > filemtime($img))
		{
			$use_cached_image=true;
		}
	}
}
if ($use_cached_image)
{
	header("Content-Length: ".filesize($cache_file));
	$src=fopen($cache_file,"r");
	fpassthru($src);
	fclose($src);
}
else
{
	$image = @getimagesize($img);
	if ($image && $image_target_width && $image_target_height)
	{
		$image_width=$image[0];
		$image_height=$image[1];
		if (!$allow_larger)
		{
			$is_error=$image_target_width > $image_width;
			if (!$is_error)
			{
				$is_error=$image_target_height > $image_height;
			}
		}
		else
		{
			$is_error=true;
		}
	}
	// Check the input variables and decide what to do:
	if ($is_error)
	{
		if (!$image || !$show_original)
		{
			//Show an error image:
			create_error_image();
		}
	}
	elseif ($use_extended_version)
	{
		include('includes/configure.php');		// Get configuration
		include(DIR_FS_INC.'olc_db_connect.inc.php');
		// make a connection to the database... now
		olc_db_connect() or die('product_thumb -- Kann keine Verbindung zur Datenbank erhalten!');

		include(DIR_FS_INC.'olc_db_query.inc.php');
		include(DIR_FS_INC.'olc_db_fetch_array.inc.php');
		include(DIR_FS_INC.'olc_db_close.inc.php');

		$const='PRODUCT_IMAGE_'.$image_origin.'_';
		$configuration_query=olc_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from ' .
		TABLE_PREFIX .'configuration' . " WHERE configuration_key LIKE '".$const."%'");
		while ($configuration = olc_db_fetch_array($configuration_query))
		{
			define($configuration['cfgKey'], $configuration['cfgValue']);
		}
		$bevel=$const.'BEVEL';
		$drop_shadow=$const.'DROP_SHADDOW';
		$ellipse=$const.'ELLIPSE';
		$frame=$const.'FRAME';
		$greyscale=$const.'GREYSCALE';
		$height=$const.'HEIGHT';
		$merge=$const.'MERGE';
		$motion_blur=$const.'MOTION_BLUR';
		$round_edges=$const.'ROUND_EDGES';
		$width=$const.'WIDTH';

		define('BEVEL',constant($bevel));
		define('DROP_SHADDOW',constant($drop_shadow));
		define('ELLIPSE',constant($ellipse));
		define('FRAME',constant($frame));
		define('GREYSCALE',constant($greyscale));
		define('HEIGHT',constant($height));
		define('MERGE',constant($merge));
		define('MOTION_BLUR',constant($motion_blur));
		define('ROUND_EDGES',constant($round_edges));
		define('WIDTH',constant($width));

		// include needed functions
		require_once('admin/'.DIR_WS_CLASSES.'image_manipulator.php');
		if (!$tn_cache)
		{
			$cache_file='';
		}
		$a = new image_manipulation($img,WIDTH,HEIGHT,$cache_file,$quality,'');
		$array=clear_string(BEVEL);
		if (BEVEL)
		{
			$a->bevel($array[0],$array[1],$array[2]);
		}
		$array=clear_string(GREYSCALE);
		if (GREYSCALE)
		{
			$a->greyscale($array[0],$array[1],$array[2]);
		}
		$array=clear_string(ELLIPSE);
		if (ELLIPSE)
		{
			$a->ellipse($array[0]);
		}
		$array=clear_string(ROUND_EDGES);
		if (ROUND_EDGES)
		{
			$a->round_edges($array[0],$array[1],$array[2]);
		}

		$string=str_replace(APOS,'',MERGE);
		$string=str_replace(RPAREN,'',$string);
		$string=str_replace('(',DIR_WS_CATALOG_IMAGES,$string);
		$array=explode(',',$string);
		if (MERGE)
		{
			$a->merge($array[0],$array[1],$array[2],$array[3],$array[4]);
		}

		$array=clear_string(FRAME);
		if (FRAME)
		{
			$a->frame($array[0],$array[1],$array[2],$array[3]);
		}

		$array=clear_string(DROP_SHADOW);
		if (DROP_SHADOW)
		{
			$a->drop_shadow($array[0],$array[1],$array[2]);
		}

		$array=clear_string(MOTION_BLUR);
		if (MOTION_BLUR)
		{
			$a->motion_blur($array[0],$array[1]);
		}
		$a->create();
	}
	else
	{
		$create_jpeg=$image_type == 2 || ($image_type == 1 && $gif_as_jpeg);
		if (!$create_jpeg)
		{
			$create_gif=$image_type == 1 && function_exists('imagegif');
			if (!$create_gif)
			{
				$create_png=$image_type == 3 || $image_type == 1;
			}
		}
		// Create a new, empty image based on settings:
		if ($use_truecolor && ($image_type == 2 || $image_type == 3))
		{
			$tmp_img = imagecreatetruecolor($image_target_width,$image_target_height);
		}
		else
		{
			$tmp_img = imagecreate($image_target_width,$image_target_height);
		}
		$th_bg_color = imagecolorallocate($tmp_img, $r, $g, $b);
		imagefill($tmp_img, 0, 0, $th_bg_color);
		imagecolortransparent($tmp_img, $th_bg_color);
		// Create the image to be scaled:
		if ($create_jpeg)
		{
			$src = imagecreatefromjpeg($img);
			$funtion='imagejpeg';
		}
		elseif ($create_gif)
		{
			$src = imagecreatefromgif($img);
			$funtion='imagegif';
		}
		elseif ($create_png)
		{
			$src = imagecreatefrompng($img);
			$funtion='imagepng';
		}
		// Scale the image based on settings:
		if (function_exists('imagecopyresampled') && $use_resampling)
		{
			imagecopyresampled($tmp_img, $src, 0, 0, 0, 0, $image_target_width, $image_target_height, $image_width, $image_height);
		}
		else
		{
			imagecopyresized($tmp_img, $src, 0, 0, 0, 0, $image_target_width, $image_target_height, $image_width, $image_height);
		}
		// Output the image:
		if ($create_jpeg)
		{
			imagejpeg($tmp_img, '', $quality);
			if ($tn_cache) imagejpeg($tmp_img,$cache_file, $quality);
		}
		elseif ($create_gif)
		{
			imagegif($tmp_img);
			if ($tn_cache) imagegif($tmp_img,$cache_file);
		}
		elseif ($create_png)
		{
			imagepng($tmp_img);
			if ($tn_cache) imagepng($tmp_img,$cache_file);
		}
		// Clear the image from memory:
		imagedestroy($src);
		imagedestroy($tmp_img);
	}
}

function create_error_image()
{
	global $image_target_width, $image_target_height;

	header('Content-type: image/jpeg');
	$src = imagecreate($image_target_width, $image_target_height); // Create a blank image.
	$bgc = imagecolorallocate($src, 255, 255, 255);
	$tc  = imagecolorallocate($src, 0, 0, 0);
	imagefilledrectangle($src, 0, 0, $image_target_width, $image_target_height, $bgc);
	imagestring($src, 1, 5, 5, 'Fehler', $tc);
	imagejpeg($src, '', 100);
	exit();
}
?>