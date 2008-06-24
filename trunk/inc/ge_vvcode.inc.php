<?php
/* -----------------------------------------------------------------------------------------
$Id: ge_vvcode.inc.php,v 1.0

OLC-NEWSLETTER_RECIPIENTS RC1 - Contribution for XT-Commerce http://www.xt-commerce.com
by Matthias Hinsche http://www.gamesempire.de

Copyright (c) 2003 XT-Commerce
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce www.oscommerce.com
(c) 2003	    nextcommerce www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Third Party contribution:

Visual Verify Code (VVC) security
http://www.oscommerce.com/community/contributions,1560/page,26
file: visual_verify_code.php,v 1.0 26SEP03
Written for use with:
osCommerce, Open Source E-Commerce Solutions http://www.oscommerce.com
Part of Contribution Named:
Visual Verify Code (VVC) by William L. Peer, Jr. (wpeer@forgepower.com) for www.onlyvotives.com

Modified for use in XT-Commerce by GamesEmpire.de Matthias Hinsche

(c) 2003 xt-commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function vvcode_render_code($code)
{
	if (!empty($code))
	{
		$imwidth=120;
		$imheight=30;
		$im = @ImageCreate ($imwidth, $imheight); //or die ("Kann keinen neuen GD-Bild-Stream erzeugen - verify_code_img_gen.php");
		if ($im)
		{
			$background_color = ImageColorAllocate ($im, 255, 255, 255);
			$text_color_black = ImageColorAllocate ($im, 0, 0, 0);
			$text_color_red = ImageColorAllocate ($im, 255, 0, 0);
			$text_color_blue = ImageColorAllocate ($im, 0, 0, 255);
			//$text_color_green = ImageColorAllocate ($im, 0, 255, 0);
			imagecolortransparent($im,$background_color);
			$text_color=array($text_color_black,$text_color_red,$text_color_blue,$text_color_green);
			$border_color = $background_color;  ///ImageColorAllocate ($im, 154, 154, 154);
			//strip any spaces that may have crept in
			//end-user wouldn't know to type the space! :)
			$code = str_replace(BLANK, "", $code);
			$x=0;
			$stringlength = strlen($code);
			for ($i = 0; $i< $stringlength; $i++) {
				$x = $x + (rand (8, 15));
				$y = rand (2, 10);
				$font = rand (3,5);
				$single_char = substr($code, $i, 1);
				imagechar($im, $font, $x, $y, $single_char, $text_color[rand(0,2)]);
			}
			imagerectangle ($im, 2, 2, $imwidth-2, $imheight-2, $border_color);
			Header("Content-type: image/Jpeg");
			ImageJpeg($im);
			ImageDestroy;
			return true;
		}
	}
}
?>