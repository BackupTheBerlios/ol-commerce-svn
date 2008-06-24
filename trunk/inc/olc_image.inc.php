<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_image.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:36 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com
(c) 2003	    nextcommerce (olc_image.inc.php,v 1.5 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Modified 09/21/2006 by W. Kaiser for "pictures on the fly"-support

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
// include needed functions
require_once(DIR_FS_INC.'olc_parse_input_field_data.inc.php');
require_once(DIR_FS_INC.'olc_not_null.inc.php');

// The HTML image wrapper function
function olc_image($src, $alt = '', $width = '', $height = '', $parameters = '')
{
	global $server,$force_scale;

	if (!$src)
	{
		$src=get_default_image();
	}
	$not_image_required=IMAGE_REQUIRED == FALSE_STRING_S;
	if ($not_image_required)
	{
		if (!$src || ($src == DIR_WS_IMAGES))
		{
			return false;
		}
	}
	$rep=array(QUOTE => '&quot;');
	$src=olc_parse_input_field_data($src, $rep);
	/*
	if (IS_MULTI_SHOP)
	{
	$src=olc_set_multi_shop_dir_info($src);
	}
	*/
	//Don't calculate if the image is a button
	//or set to a "%" width and/or height
	//or if a 'pixel' image is being passed (hope you dont have pixels for sale!)
	if ($force_scale)
	{
		$do_calculate=true;
	}
	elseif (strstr($src,'/buttons/') == false)
	{
		if (strstr($src,'/manufacturers/') == false)
		{
			if (strstr($width,PERCENT) == false )
			{
				if (strstr($height,PERCENT) == false)
				{
					$do_calculate=strstr($src, 'pixel') == false;
				}
			}
		}
	}
	if ($do_calculate)
	{
		if (strpos($src,HASH.DOT)===false)
		{
			if (DO_IMAGE_ON_THE_FLY)
			{
				if (!file_exists($src))
				{
					$dir=DIR_WS_THUMBNAIL_IMAGES;
					if (strpos($src,$dir)!==false)
					{
						$img_type='thumbnail';
					}
					else
					{
						$dir=DIR_WS_INFO_IMAGES;
						if (strpos($src,$dir)!==false)
						{
							$img_type='info';
						}
						else
						{
							$dir=DIR_WS_POPUP_IMAGES;
							if (strpos($src,$dir)!==false)
							{
								$img_type='popup';
							}
							else
							{
								if (strpos($src,DIR_WS_ORIGINAL_IMAGES)!==false)
								{
									$src=get_default_image();
								}
								else
								{
									$img_type=EMPTY_STRING;
								}
							}
						}
					}
					if ($img_type)
					{
						if ($force_scale)
						{
							$srcn=$src;
						}
						else
						{
							$srcn=str_replace($img_type,'original',$src);
						}
						$products_image_name=basename($srcn);
						$src_path=ADMIN_PATH_PREFIX.$srcn;
						if (file_exists($src_path))
						{
							$processsor=DIR_WS_INCLUDES.'product_'.$img_type.'_images.php';
							if (NOT_IS_ADMIN_FUNCTION)
							{
								$prefix='admin/';
								$processsor=$prefix.$processsor;
							}
							//$src_manipulation_text='image_manipulation';
							if (!class_exists('image_manipulation'))
							{
								$dir_fs_catalog='DIR_FS_CATALOG_';
								define($dir_fs_catalog.'IMAGES', ADMIN_PATH_PREFIX.DIR_WS_IMAGES);
								define($dir_fs_catalog.'ORIGINAL_IMAGES', ADMIN_PATH_PREFIX.DIR_WS_ORIGINAL_IMAGES);
								define($dir_fs_catalog.'THUMBNAIL_IMAGES', ADMIN_PATH_PREFIX.DIR_WS_THUMBNAIL_IMAGES);
								define($dir_fs_catalog.'INFO_IMAGES', ADMIN_PATH_PREFIX.DIR_WS_INFO_IMAGES);
								define($dir_fs_catalog.'POPUP_IMAGES',ADMIN_PATH_PREFIX.DIR_WS_POPUP_IMAGES);
								include_once($prefix.DIR_WS_CLASSES.'image_manipulator.php');
							}
							include($processsor);
						}
						else
						{
							return EMPTY_STRING;
						}
					}
				}
			}
			if (CONFIG_CALCULATE_IMAGE_SIZE)
			{
				// Do we calculate the image size?
				$do_calculate=(!$width || !$height || $force_scale);
				if ($do_calculate)
				{
					$src_size = @getimagesize($src);
					if (!$src_size)
					{
						$src_size = @getimagesize(get_default_image());
					}
					if ($src_size)
					{
						$src_width=$src_size[0];
						$src_height=$src_size[1];
						// Set the width and height to the proper ratio
						if (!($width || $height))
						{
							$width = $src_width;
							$height = $src_height;
							$ratio=$width/$height;
						}
						else if (!$width)
						{
							$ratio = $height/$src_height;
							$width = intval($src_width * $ratio);
						}
						else		//if (!$height)
						{
							$ratio = $width / $src_width;
							$height = intval($src_height * $ratio);
						}
						// Scale the image if not the original size
						if ($src_width != $width || $src_height != $height || $force_scale)
						{
							$rx = $src_width / $width;
							$ry = $src_height / $height;
							if ($rx < $ry)
							{
								$width = intval($height / $ratio);
							}
							else
							{
								$height = intval($width * $ratio);
							}
						}
					}
					elseif ($not_image_required)
					{
						return false;
					}
				}
			}
		}
	}
	// Add remaining image parameters if they exist
	$src = '<img src="' . $src . '" style="border:0px"';
	if (olc_not_null($alt))
	{
		$alt=olc_parse_input_field_data($alt, $rep);
		$src .= ' title="' . $alt . QUOTE;
	}
	$src .= ' alt="'.$alt.QUOTE;
	if ($width)
	{
		$src .= ' width="' . $width . QUOTE;
	}
	if ($height)
	{
		$src .= ' height="' . $height . QUOTE;
	}
	if ($parameters)
	{
		$src .= BLANK . $parameters;
	}
	else
	{
		$src .= ' align="middle"';
	}
	$src .= '/>';
	return $src;
}

function get_default_image()
{
	$src=NO_IMAGE_NAME;
	if (file_exists($src))
	{
		global $force_scale;

		$force_scale=true;
	}
	else
	{
		$src=EMPTY_STRING;
	}
	return $src;
}

if (NOT_IS_ADMIN_FUNCTION)
{
	if (!function_exists('clear_string'))
	{
		function clear_string($value) {

			$string=str_replace(APOS, EMPTY_STRING,$value);
			$string=str_replace(RPAREN, EMPTY_STRING,$string);
			$string=str_replace('(', EMPTY_STRING,$string);
			$array=explode(COMMA,$string);
			return $array;
		}
	}
}
?>
