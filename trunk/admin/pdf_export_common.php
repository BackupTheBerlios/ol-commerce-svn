<?php
/* --------------------------------------------------------------
$Id: pdf_export_common.php,v 1.1.1.1.2.1 2007/04/08 07:16:31 gswkaiser Exp $

OL - COMMERCE
http://www.ol-commerce.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(column_left.php,v 1.15 2002/01/11); www.oscommerce.com
(c) 2003	    nextcommerce (column_left.php,v 1.25 2003/08/19); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com
(c) 2005 ol-commerce; Manfred Tomanik www.ol-commerce.de

Released under the GNU General Public License
--------------------------------------------------------------*/

define('NO_STORE',false);			//Collect all data-sets and output then!
//define('NO_STORE',true);			//Directly process each data-set! Future extension!
define('STORE',!NO_STORE);

define('LEFT','L');
define('RIGHT','R');
define('CENTER','C');
define('BOLD','B');
define('ITALIC','I');
define('BOLD_ITALIC',BOLD.ITALIC);
define('NORMAL',EMPTY_STRING);
define('TEXT_DASH',chr(150));

require_once(DIR_FS_INC.'olc_format_price.inc.php');
require_once(DIR_FS_INC.'olc_get_vpe_and_baseprice_info.inc.php');
if (NOT_IS_ADMIN_FUNCTION)
{
	require_once(DIR_FS_INC.'olc_get_shipping_status_name.inc.php');
}
$class_path=$class_path."includes/classes/";
define('FPDF_FONTPATH',$class_path.'fpdf/font/');
require($class_path . 'fpdf/fpdf.php');
$s=DIR_WS_LANGUAGES . SESSION_LANGUAGE . SLASH;
$file=$s. 'admin' .SLASH . CURRENT_SCRIPT;
include($file);
$file=$s. CURRENT_SCRIPT;
include($file);

class PDF extends FPDF
{
	var $columns;
	var $column_width;
	var $column_width1;
	var $descr_lines_height=4;
	var $font='Arial';
	var $impressum;
	var $impressum_lines;
	var $impressum_left;
	var $max_impressum_line_length;
	var $footer;
	var $cells_height=5;
	var $footer_top;
	var $footer_left;
	var $footer_disclaimer_top;
	var $footer_disclaimer_left;
	var $entry_height;						//Height of catalog entry
	var $show_price;
	var $new_page;
	var $last_header;
	var $data_sets;
	var $two_lines;

	var $group_check_group;

	var $fsk18_check_condition;
	var $tax_inc;

	var $language_dir_start;
	var $image_dir;
	var $max_image_height;

	var $shipping_status_name;
	var $language_parameter;

	var $min_qty_color;
	var $body_color_text;
	var $dash_array;

	var $have_uvp;
	var $footer_uvp_left;
	var $footer_uvp_top;

	var $item_name=0;
	var $item_image=1;
	var $item_id=3;
	var $item_price=4;
	var $item_cat_name=5;
	var $item_model=6;
	var $item_sd_1=7;
	var $item_sd_2=8;
	var $item_shippingtime=9;
	var $item_pict_disc=10;
	var $item_min_qty=11;
	var $item_uvp=12;

	function olcCheckSpecial($pID) {
		$product_query=SELECT."specials_new_products_price from " . TABLE_SPECIALS .
		" where products_id='" . $pID . "' and status and TO_DAYS(expires_date)>=TO_DAYS(NOW())";
		return $product['specials_new_products_price'];
	}

	//Load data
	function LoadData($column_width)
	{
		$this->dash_array=array(HTML_MDASH,HTML_NDASH);
		if (DO_GROUP_CHECK)
		{
			$group_check=" c.".$this->group_check_group . SQL_AND;
		}
		if (!$this->fsk18_check_condition)
		{
			$fsk_lock=' p.products_fsk18!=1 '.SQL_AND;
		}
		$query ="language_id='". $this->_pdf_lang .APOS;
		$query =SELECT."
					p.products_id,
					p.products_model,
					p.products_image,
					p.products_fsk18,
					p.products_shippingtime,
					p.products_price,
          p.products_uvp,
          p.products_vpe,
          p.products_vpe_status,
          p.products_vpe_value,
          p.products_baseprice_show,
          p.products_baseprice_value,
					p.products_min_order_quantity,
					p.products_min_order_vpe,
          p.products_uvp,
					pd.products_name,
					pd.products_short_description,
					cd.categories_name
					FROM " .
		TABLE_CATEGORIES . " c, ".
		TABLE_CATEGORIES_DESCRIPTION . " cd, ".
		TABLE_PRODUCTS_TO_CATEGORIES . " ptc, ".
		TABLE_PRODUCTS . " p, ".
		TABLE_PRODUCTS_DESCRIPTION . " pd
					WHERE
					c.categories_status=1 ".SQL_AND.
		$group_check.
		$fsk_lock."
					p.products_status=1 AND
					(cd.categories_id=c.categories_id AND cd.".$query.") AND
					(pd.products_id=p.products_id AND pd.".$query.") AND
					ptc.categories_id=c.categories_id AND
					p.products_id=ptc.products_id AND
					p.products_price > 0 AND
					pd.products_name <> ''
					ORDER BY cd.categories_name, pd.products_name";
		$product_query=olc_db_query($query);
		$this->data=EMPTY_STRING;
		if (olc_db_num_rows($product_query ))
		{
			$show_shipping=ACTIVATE_SHIPPING_STATUS==TRUE_STRING_S;
			if ($show_shipping)
			{
				if (!$this->shipping_status_name)
				{
					$this->shipping_status_name=array();
					$this->shipping_status_name[]=EMPTY_STRING;
					$shipping_status_query=olc_db_query(SELECT."shipping_status_name" .SQL_FROM . TABLE_SHIPPING_STATUS .
					" where language_id='" .  $this->_pdf_lang . APOS);
					while ($shipping_status=olc_db_fetch_array($shipping_status_query))
					{
						$this->shipping_status_name[]=$shipping_status['shipping_status_name'];
					}
				}
			}
			$this->two_lines=$this->descr_lines_height+$this->descr_lines_height;
			$this->spalte=$this->columns;
			$this->last_header=EMPTY_STRING;
			$this->new_page=true;
			$this->new_height=0;
			if (NO_STORE)
			{
				$this->data_sets=1;
			}
			$lparen=LPAREN;
			$rparen=RPAREN;
			$blank_apos=" '";
			$xx=0;
			while($product=olc_db_fetch_array($product_query))
			{
				//W. Kaiser - AJAX
				$data[$xx][$this->item_name]=prepare_string_item($product['products_name'],2,$column_width);
				$data[$xx][$this->item_image]=$product['products_image'];
				$products_id=$product[products_id];
				$data[$xx][$this->item_id]=$products_id;
				$olPrice=$this->olcCheckSpecial($products_id);
				if(!$olPrice)
				{
					$olPrice=$product['products_price'];
				}
				$this_array=array();
				olc_get_vpe_and_baseprice_info($this_array,$product,$olPrice);
				$vpe=$this_array['PRODUCTS_BASEPRICE'];
				if ($vpe)
				{
					$vpe=BLANK.prepare_string_item($vpe,1,1000);
				}
				$data[$xx][$this->item_price]=TEXT_PRICE.olc_format_price ($olPrice,true,true,true,true).$vpe;

				$vpe=$this_array['PRODUCTS_UVP'];
				if ($vpe)
				{
					$data[$xx][$this->item_uvp]=strip_tags($vpe);
					$this->have_uvp=true;
				}
				$data[$xx][$this->item_cat_name]=TEXT_PRODUCT_GROUP.$blank_apos.trim($product['categories_name']).APOS;
				$vpe=$this_array['PRODUCTS_VPE'];
				if ($vpe)
				{
					$vpe=$lparen.$vpe.$rparen;
				}
				$data[$xx][$this->item_model]=TEXT_MODEL_NUMBER.$product['products_model'].$vpe;
				$products_short_description=str_replace(HTML_NBSP,BLANK,$product['products_short_description']);
				$data[$xx][$this->item_sd_1]=prepare_string_item($products_short_description,1,$column_width);
				$data[$xx][$this->item_sd_2]=prepare_string_item($products_short_description,2,$column_width);
				if ($show_shipping)
				{
					$data[$xx][$this->item_shippingtime]=TEXT_SHIPPING_TIME.$this->shipping_status_name[$product['products_shippingtime']];
				}
				$data[$xx][$this->item_pict_disc]=TEXT_PICTURE_DISCLAIMER;
				$min_qty=$this_array['PRODUCTS_MIN_ORDER_QTY'];
				if ($min_qty)
				{
					$data[$xx][$this->item_min_qty]=$min_qty;
				}
				//W. Kaiser - AJAX
				if (STORE)
				{
					$xx++;
				}
				else
				{
					$this->data=$data;
					$this->format();
				}
			}
			if (STORE)
			{
				$this->data=$data;
			}
		}
	}

	function Footer()
	{
		$this->format_footer(7);
		if (!$this->footer)
		{
			//Footer
			if (NO_TAX_RAISED)
			{
				$price_disclaimer=PRICE_DISCLAIMER_NO_TAX_NO_LINK;
			}
			else
			{
				if ($this->tax_inc)
				{
					$price_disclaimer=PRICE_DISCLAIMER_INCL_GENERAL_NO_LINK;
				}
				else
				{
					$price_disclaimer=PRICE_DISCLAIMER_EXCL_NO_LINK;
				}
			}
			$price_disclaimer=str_replace($this->dash_array,TEXT_DASH,$price_disclaimer);
			$this->footer=str_replace(HASH,date('d.m.Y h:i'),TEXT_CATALOGUE_CREATION_DATE).
			strip_tags($price_disclaimer);
			$this->footer_disclaimer_left=ceil($this->w-$this->GetStringWidth(GENERAL_DISCLAIMER))/2;
			$this->footer_top=$this->h-$this->tMargin;
			$cells_height=$this->FontSize;
			$this->footer_left=ceil($this->w-$this->GetStringWidth($this->footer))/2;
			$this->footer_disclaimer_top=$this->footer_top+$cells_height;
			if ($this->have_uvp)
			{
				$this->footer_uvp_left=ceil($this->w-$this->GetStringWidth(TEMPLATE_UVP_PRICE_SHORT_DISCLAIMER))/2;
				$this->footer_uvp_top=$this->footer_disclaimer_top;

				$this->footer_top-=$cells_height;
				$this->footer_disclaimer_top-=$cells_height;
			}
		}
		//Footer notes
		$this->Text($this->footer_left,$this->footer_top,$this->footer);
		$link=olc_href_link(FILENAME_CONTENT,'coID=1'.$this->language_parameter,NONSSL,false,true,false);
		$link=str_replace(strtolower(HTTPS),strtolower(HTTP),$link);
		$this->Link($this->footer_left,$this->footer_top-.5*($this->FontSize),
		$this->GetStringWidth($this->footer),$this->FontSize,$link);
		$page_text=str_replace(HASH,$this->PageNo(),TEXT_PAGE);
		if ($this->page%2==1)
		{
			$page_text_left=ceil($this->w-$this->rMargin-$this->GetStringWidth($page_text));
		}
		else
		{
			$page_text_left=$this->lMargin;
		}
		$this->Text($page_text_left,$this->footer_top,$page_text);		//Footer
		//General disclaimer
		$this->Text($this->footer_disclaimer_left,$this->footer_disclaimer_top,GENERAL_DISCLAIMER);		//Footer
		if ($this->have_uvp)
		{
			$this->Text($this->footer_uvp_left,$this->footer_uvp_top,TEMPLATE_UVP_PRICE_SHORT_DISCLAIMER);		//UVP Disclaimer
		}
	}

	function create_header($ii)
	{
		$this->new_height=$this->default_height;
		$this->spalte=0;
		unset($this->img_height);
		unset($this->new_height_tmp);
		//Print Impressum
		if (!$this->page)
		{
			$this->impressum=array();
			$store=explode(NEW_LINE,STORE_NAME_ADDRESS);
			$lines=sizeof($store)-1;
			for ($i=0;$i<=$lines;$i++)
			{
				$s=trim($store[$i]);
				if ($i==$lines)
				{
					$this->impressum[]=EMPTY_STRING;
					$l_s=strtolower($s);
					if (strpos($l_s,strtolower(TEXT_FON))===false)
					{
						if (strpos($l_s,'tel')===false)
						{
							$s=TEXT_FON.'.: '.$s;
						}
					}
				}
				$this->store_impressum_string($s);
			}
			$this->store_impressum_string('eMail: '.STORE_OWNER_EMAIL_ADDRESS);
			$s=HTTP_SERVER;
			if (strpos($s,'localhost')>0)
			{
				$store=explode('@',STORE_OWNER_EMAIL_ADDRESS);
				$s="http://www.".$store[1];
			}
			$this->store_impressum_string('Web: '.$s);

			$this->impressum_lines=sizeof($this->impressum);
			$this->impressum_left=ceil($this->w-$this->rMargin-$this->max_impressum_line_length);
			$this->max_image_height=$this->impressum_lines*$this->FontSize*$this->k;
			if (SHOW_SHOP_CLICK)
			{
				$this->max_image_height=$this->max_image_height/2;
			}
		}
		$this->AddPage();
		if (PDF_SHOW_WATERMARK){
			//Put watermark
			$this->Watermark();
		}
		$this->SetFont($this->font,EMPTY_STRING,10);
		$this->format_title();
		$top=$this->tMargin;
		$left=$this->wc[0];
		$link=olc_href_link('index.php',$this->language_parameter,NONSSL,false,true,false,true);
		$link=str_replace(strtolower(HTTPS),strtolower(HTTP),$link);
		$image=FULL_CURRENT_TEMPLATE."images/logo.jpg";
		if (file_exists($image))
		{
			$top=$this->tMargin;
			$img=@getimagesize($image);
			$w=$img[0];
			$h=$img[1];
			if($h>$this->max_image_height)
			{
				$w=$w*($this->max_image_height/$h);
				$h=$this->max_image_height;
			}
			$h=$h/$this->k;
			$this->Image($image,$this->lMargin,$top,$w/$this->k,$h,EMPTY_STRING,$link);
		}
		if (SHOW_SHOP_CLICK)
		{
			$this->SetFont($this->font,NORMAL,8);
			$this->SetY($top+$h+$this->descr_lines_height);
			$this->MultiCell(80,$this->descr_lines_height,TEXT_SHOP_CLICK);
		}
		$this->SetFont($this->font,BOLD_ITALIC,14);
		$y=$this->new_height-$this->descr_lines_height*3;
		$text=$this->data[$ii][$this->item_cat_name];
		$x=$this->lMargin;		//($this->w-$this->GetStringWidth($text));
		$this->Text($x,$y-$this->descr_lines_height,$text);		//Product group
		$this->SetY($y);
		$this->DrawSeparatorLine();
		$this->SetFont($this->font,EMPTY_STRING,9);
		$left=$this->impressum_left;
		for ($i=0;$i<$this->impressum_lines;$i++)
		{
			$this->Text($left,$top,$this->impressum[$i]);
			$top+=$this->descr_lines_height;
		}
	}

	function store_impressum_string($s)
	{
		$this->impressum[]=$s;
		$this->max_impressum_line_length=max($this->max_impressum_line_length,$this->GetStringWidth($s));
	}

	function format_text($size=10)
	{
		$body_color_text=explode(COMMA,PDF_BODY_COLOR_TEXT);
		$this->SetTextColor($body_color_text[0], $body_color_text[1], $body_color_text[2]);
		$this->SetFont($this->font,EMPTY_STRING,$size);
		$this->descr_lines_height=$this->FontSize*1.1;
	}

	function format_title($size=12)
	{
		$header_text_color=explode(COMMA,PDF_HEADER_COLOR_TEXT);
		$this->SetTextColor($header_text_color[0], $header_text_color[1], $header_text_color[2]);
		$this->descr_lines_height=$this->FontSize*1.1;
	}

	function format_footer($size=12)
	{
		$footer_color_cell=explode(COMMA,PDF_FOOTER_CELL_BG_COLOR);
		$this->SetFillColor($footer_color_cell[0], $footer_color_cell[1], $footer_color_cell[2]);
		$footer_color_text=explode(COMMA,PDF_FOOTER_CELL_TEXT_COLOR);
		$this->SetTextColor($footer_color_text[0], $footer_color_text[1], $footer_color_text[2]);
		$this->SetFont($this->font,EMPTY_STRING,$size);
		$this->descr_lines_height=$this->FontSize*1.1;
	}

	function Watermark()
	{
		//Calc font-size to fit text in page
		$w=$this->w-$this->lMargin-$this->rMargin;
		$font_size=100;
		$ang=45;                                                                 //rotation angle
		$sin=deg2rad($ang);
		$cos=cos($sin);
		$sin=sin($sin);
		while (true)
		{
			$this->SetFont($this->font,BOLD,$font_size);
			$wmw=$this->GetStringWidth(STORE_NAME);
			$wwm=($wmw*$cos);
			if ($wwm<=$w)
			{
				break;
			}
			else
			{
				//Reduce font size
				$font_size-=5;
			}
		}
		$hwm=($wmw*$sin);
		$watermark_color=explode(COMMA,PDF_PAGE_WATERMARK_COLOR);
		$this->SetTextColor($watermark_color[0], $watermark_color[1], $watermark_color[2]);
		$this->RotatedText($this->lMargin/2+($this->w-$wwm)/2,($this->h+$hwm)/2,STORE_NAME,$ang);
	}

	function RotatedText($x,$y,$txt,$angle)
	{
		//Text rotated around its origin
		$this->Rotate($angle,$x,$y);
		$this->Text($x,$y,$txt);
		$this->Rotate(0);
	}

	function format()
	{
		$show_shipping=ACTIVATE_SHIPPING_STATUS==TRUE_STRING_S;
		if (STORE)
		{
			$this->data_sets=count($this->data);
		}
		$cell_width=$pdf->column_width*.9;
		for($data_set=0;$data_set<$this->data_sets;$data_set++)
		{
			## INIT
			#### spalte nach columns wieder null
			if($this->spalte>=$this->columns)
			{
				$this->spalte=0;
				#### höher als max height -> neue seite
				if (($this->new_height_tmp + $this->entry_height)> $this->h)
				{
					$this->new_height=0;
					$this->new_page=true;
				}
				else
				{
					$this->new_height=$this->new_height_tmp+$this->two_lines;
				}
				unset($this->img_height);
				unset($this->new_height_tmp);
			}
			#### create categorie header
			$current_data=$this->data[$data_set];
			$this_header=$current_data[$this->item_cat_name];
			if($this->new_page OR ($this_header!=$this->last_header))
			{
				$this->last_header=$this_header;
				$this->create_header($data_set);
				$this->new_page=false;
			}
			$this->format_text(11);
			if($this->debug) { echo "<h2>".$current_data[$this->item_name]."  new_height_tmp $this->new_height_tmp</h2>"; }
			### name einfügen
			$header_text_color=explode(COMMA,PDF_HEADER_COLOR_TEXT);
			$this->SetTextColor($header_text_color[0], $header_text_color[1], $header_text_color[2]);
			$line=0;
			$col=$this->wc[$this->spalte];
			$this->SetFont($this->font,BOLD,$this->FontSizePt);
			$__link=strtr($this->product_link,array("#" => $current_data[$this->item_price]));
			$this->SetY($this->new_height-$this->p_height[$line]);
			$this->SetX($col-1);
			$this->Cell($cell_width,$this->p_height[$line],$current_data[$this->item_name],0,0,EMPTY_STRING,0,$__link);
			$this->SetFont($this->font,EMPTY_STRING,$this->FontSizePt);
			$this->format_text(9);
			### Kurz-Beschreibung Zeile 1 einfügen
			$line++;
			$this->Text($col,($this->new_height-$this->p_height[$line]),$current_data[$this->item_sd_1]);
			### Kurz-Beschreibung Zeile 2 einfügen
			$line++;
			$this->Text($col,($this->new_height-$this->p_height[$line]),$current_data[$this->item_sd_2]);
			### Artikel-Nummer einfügen
			$line++;
			$this->Text($col,($this->new_height-$this->p_height[$line]),$current_data[$this->item_model]);
			if ($this->show_price)
			{
				### Preis einfügen
				$line++;
				$this->SetFont($this->font,BOLD,$this->FontSizePt);
				$this->Text($col,($this->new_height-$this->p_height[$line]),$current_data[$this->item_price]);
				$this->SetFont($this->font,EMPTY_STRING,$this->FontSizePt);
			}
			### Bild einfügen
			$image=$current_data[$this->item_image];
			$left=$col;
			$top=($this->new_height-$this->p_height[$line])+$this->descr_lines_height/2;
			if($image)
			{
				$image=$this->image_dir.$image;
				if (!file_exists($image))
				{
					if (DO_IMAGE_ON_THE_FLY)
					{
						//W. Kaiser - "picture-on-the-fly"-modification
						olc_image($image);
					}
				}
				if (file_exists($image))
				{
					$img=@getimagesize($image);
					$w=$img[0];
					$h=$img[1];
					if($this->img_height < $h)
					{
						$this->new_height_tmp=($h*0.3)+23+$this->new_height;
						$this->img_height=$h;
					}
					$line++;
					$this->Image($image,$left,$top,0,0,EMPTY_STRING,$__link);
					$image_width=$this->info['w']/$this->k;
					$left+=$image_width+2;
				}
			}
			$this->SetFont($this->font,EMPTY_STRING,8);
			$y=$top;
			if ($show_shipping)
			{
				### UVP einfügen
				$price_uvp=$current_data[$this->item_uvp];
				if ($price_uvp)
				{
					$y+=$this->descr_lines_height;
					$this->Text($left,$y,$price_uvp);
					$this->LineString($left,$y,$price_uvp,-$this->FontSize/2);
					$line++;
				}
				### Lieferzeit einfügen
				$y+=$this->descr_lines_height;
				$this->Text($left,$y,$current_data[$this->item_shippingtime]);
				if ($image)
				{
					### Bild-Disclaimer einfügen
					$y+=$this->descr_lines_height;
					$this->Text($left,$y,$current_data[$this->item_pict_disc]);
				}
				$min_qty=$current_data[$this->item_min_qty];
				if ($min_qty)
				{
					### Mindestabnahme einfügen
					$min_qty=str_replace(HTML_BR,TILDE,$min_qty);
					if (!isset($this->min_qty_color))
					{
						$this->min_qty_color=EMPTY_STRING;
						$s1="color:";
						$poss=strpos($min_qty,$s1);					//Any color in style?
						if ($poss!==false)
						{
							$poss+=strlen($s1);
							$pose=strpos($min_qty,QUOTE,$poss);
							if ($pose!==false)
							{
								$this->min_qty_color=trim(substr($min_qty,$poss,$pose-$poss));
								if ($this->min_qty_color)
								{
									$this->body_color_text=explode(COMMA,PDF_BODY_COLOR_TEXT);
									$this->body_color_text=$this->body_color_text[0];
								}
							}
						}
					}
					$min_qty=trim(strip_tags($min_qty));
					$min_qty=explode(TILDE,$min_qty);
					if ($this->min_qty_color)
					{
						$this->SetTextColor($this->min_qty_color);
					}
					$y+=$this->descr_lines_height;
					$y+=$this->descr_lines_height;
					$this->Text($left,$y,$min_qty[0]);
					$y+=$this->descr_lines_height;
					$this->Text($left,$y,$min_qty[1]);
					if ($this->min_qty_color)
					{
						$this->SetTextColor($this->body_color_text);
					}
				}
				$this->spalte++;
			}
		}
	}

	function DrawSeparatorLine()
	{
		$x=$this->GetX();
		$y=$this->GetY();
		$this->SetLineWidth(0.5);
		$product_name_color_table=explode(COMMA,PDF_PRODUCT_NAME_COLOR_TABLE);
		$this->SetDrawColor($product_name_color_table[0], $product_name_color_table[1], $product_name_color_table[2]);
		$this->Line($this->lMargin*2,$y,$this->w-$this->lMargin*2,$y);
		$this->Ln($this->cells_height);
	}

	function LineString($x,$y,$txt,$cellheight)
	{
		//calculate the width of the string
		$stringwidth=$this->GetStringWidth($txt);
		$ypos=($y+($cellheight/2));
		$this->Line($x,$ypos,($x+$stringwidth),$ypos);
	}
}

function prepare_string_item(&$string_item,$line,$column_width)
{
	$string_item=strip_tags($string_item);
	$string_item=trim($string_item);
	$string_item=str_replace(HTML_NBSP,BLANK,$string_item);
	$string_item=str_replace(HTML_BR,BLANK,$string_item);
	$string_item=str_replace(array(HTML_B_START,HTML_B_END), array(HTML_B_START,HTML_B_END), $string_item);
	if (strlen($string_item)>$column_width)
	{
		$l_string_item=substr($string_item,0,$column_width);
		if ($line==1)
		{
			$sep_chars=" -.,;:)";
			for ($i=strlen($l_string_item)-1;$i>0;$i--)
			{
				$c=substr($l_string_item,$i,1);
				if (!(strpos($sep_chars,$c)===false))
				{
					$pos=$i;
					if ($c!=BLANK)
					{
						$pos++;
					}
					$string_item=ltrim(substr($string_item,$pos));
					$l_string_item=rtrim(substr($l_string_item,0,$pos));
					break;
				}
			}
		}
		else
		{
			$l_string_item=$l_string_item."...";
		}
	}
	else
	{
		$l_string_item=$string_item;
		$string_item=EMPTY_STRING;
	}
	return $l_string_item;
}
global $use_catalog_link,$is_print_version,$is_pdf;

$use_catalog_link=true;
$is_print_version=true;
$is_pdf=true;

$pdf_lang_query_sql=SELECT_ALL . TABLE_LANGUAGES;

$customers_status_start=1;
$customers_status_end=$customers_status_start;
if (IS_ADMIN_FUNCTION)
{
	if (!ISSET_CUSTOMER_ID)
	{
		olc_redirect(olc_href_link(FILENAME_LOGIN,$this->language_parameter,NONSSL,false,true,false,false));
	}
	$customers_statuses_array=olc_get_customers_statuses();
	$customers_status_count=count($customers_statuses_array);
	if ($_POST['process'])
	{
		$message="PDF-Datei(en) wurde(n) gespeichert in ...";
		$language_dir_start="../";
		$image_dir=$language_dir_start.str_replace(DIR_WS_CATALOG,EMPTY_STRING,DIR_WS_CATALOG_THUMBNAIL_IMAGES);
		$customers_status_id=$_POST['group_status'];
		$do_all=$customers_status_id==0;
		if ($do_all)
		{
			$customers_status_ids=$customers_status_count;
			$customers_status_end=$customers_status_ids-1;
		}
		else
		{
			for ($customers_status_start=1;$customers_status_start<=$customers_status_count;$customers_status_start++)
			{
				if ($customers_status_id==$customers_statuses_array[$customers_status_start]['id'])
				{
					break;
				}
			}
			$customers_status_end=$customers_status_start;
		}
	}
	else
	{
		if (($customers_status_count-1)>1)
		{
			$customers_statuses_array[0]['text']=TEXT_CATALOGUE_ALL_VARIATIONS;
			$main_content .= olc_draw_form('parameter', CURRENT_SCRIPT,BLANK).HTML_BR.HTML_BR;
			$main_content .= olc_draw_hidden_field('process',TRUE_STRING_S);
			$main_content .= TEXT_INFO_HEADING_STATUS_CUSTOMER . BLANK .
			olc_draw_pull_down_menu('group_status', $customers_statuses_array,DEFAULT_CUSTOMERS_STATUS_ID_ADMIN).HTML_BR.HTML_BR;
			$main_content .= '
	<p>'.
			olc_image_submit('button_confirm.gif', IMAGE_BUTTON_CONTINUE,'onclick="javascript:show_message()"').'
	</p>
</form>
<script>
var message_visible=true,style_display,style_display_show="inline",style_display_hide="none";
var message_element_style;

function show_message()
{
	message_element_style=document.getElementById("message").style;
	message_element_style.display=style_display_show;
	setInterval("toggle_visibility()", 1000);
}

function toggle_visibility()
{
	if (message_visible)
	{
		style_display=style_display_hide;
	}
	else
	{
		style_display=style_display_show;
	}
	message_element_style.display=style_display;
	message_visible=!message_visible;
}
</script>
<p id="message" style="display:none;">
	<font color="#FF0000"><b>'.TEXT_CATALOGUE_BEING_GENERATED.'</b></font>
</p>
 ';
			$page_header_icon_image=HEADING_MODULES_ICON;
			$page_header_title=HEADING_TITLE;
			$page_header_subtitle='OLC Module';
			$show_column_right=true;
			require(PROGRAM_FRAME);
			olc_exit();
		}
	}
}
else
{
	$image_dir=DIR_WS_THUMBNAIL_IMAGES;
	$customers_status_id=CUSTOMER_STATUS_ID;
	$show_price=CUSTOMER_SHOW_PRICE;
	$tax_inc=CUSTOMER_SHOW_PRICE_TAX;
	$fsk18_check_condition=CUSTOMER_IS_FSK18;
	$group_check_group=SQL_GROUP_CONDITION;
	$pdf_lang_query_sql.=SQL_WHERE."languages_id='".SESSION_LANGUAGE_ID.APOS;
}
for ($customers_status=$customers_status_start;$customers_status<=$customers_status_end;$customers_status++)
{
	$pdf_lang_query=olc_db_query($pdf_lang_query_sql);
	while($pdf_lang=olc_db_fetch_array($pdf_lang_query))
	{
		$_pdf_lang=$pdf_lang['languages_id'];
		if (IS_ADMIN_FUNCTION)
		{
			if ($do_all)
			{
				$customers_status_id=$customers_statuses_array[$customers_status]['id'];
			}
			if ($customers_status_id<>CUSTOMER_STATUS_ID)
			{
				$customers_status_query=olc_db_query(
				SELECT."
	      customers_status_show_price,
	      customers_status_show_price_tax,
	      customers_fsk18,
	      customers_fsk18_display
			  FROM " .
				TABLE_CUSTOMERS_STATUS . "
	  		WHERE
	      customers_status_id='" . $customers_status_id ."'
	      AND language_id='" . $_pdf_lang . APOS);
				$customers_status_value=olc_db_fetch_array($customers_status_query);
				$show_price=$customers_status_value['customers_status_show_price'];
				$fsk18_check_condition=$customers_status_value['customers_fsk18_display'];
				$tax_inc=$customers_status_value['show_price_tax'];
				$group_check_group=str_replace(CUSTOMER_STATUS_ID,$customers_status_id,SQL_GROUP_CONDITION);
			}
			$domain=set_filename($customers_statuses_array[$customers_status_id]['text'],
			$tax_inc,$fsk18_check_condition);
		}
		$pdf=new PDF();

		//Seiten-Parameter setzen Beginn
		$pdf->columns=2;										//Anzahl Spalten auf der Seite
		$pdf->SetMargins(15,10,10);					//Ränder links ,rechts, oben
		$descr_lines=4;											//Anzahl der Zeilen Beschreibungstext pro Produkt
		//Seiten-Parameter setzen Ende
		if ($show_price)
		{
			$descr_lines++;
		}
		$pdf->show_price=$show_price;
		//Seiten-Parameter setzen Ende

		$pdf->column_width=($pdf->w-($pdf->lMargin+$pdf->rMargin))/$pdf->columns;
		$pdf->column_width1=($pdf->column_width-3)/1.75;
		$pdf->AliasNbPages();
		$pdf->font='Arial';
		$pdf->_pdf_lang=$_pdf_lang;
		$pdf->language_parameter='&language='.$_SESSION['language_code'];
		//$pdf->debug=1;
		$pdf->group_check_group=$group_check_group;
		$pdf->fsk18_check_condition=$fsk18_check_condition;
		$pdf->tax_inc=$tax_inc;
		$pdf->lang_directory=$language_dir_start."lang/".$pdf_lang[directory].SLASH;
		$pdf->image_dir=$image_dir;
		$pdf->language_dir_start=$language_dir_start;
		$pdf->wc=array();
		$col_start=$pdf->lMargin;
		for ($col=0;$col<$pdf->columns;$col++)
		{
			$pdf->wc[]=$col_start;
			$col_start+=$pdf->column_width;
		}
		$pdf->p_height=array();
		$col_start=-$pdf->descr_lines_height;
		$pdf->format_text();
		//entry_height is the total heigth of a catalog entry;
		$pdf->entry_height=0;
		for ($col=0;$col<=$descr_lines+5;$col++)
		{
			$pdf->p_height[]=$col_start;
			$col_start-=$pdf->descr_lines_height;
			$pdf->entry_height+=$pdf->descr_lines_height;
		}
		$pdf->entry_height+=$pdf->descr_lines_height+$pdf->descr_lines_height;
		$pdf->entry_height+=PRODUCT_IMAGE_THUMBNAIL_HEIGHT/$pdf->k;
		$pdf->default_height=60;;
		$pdf->max_height=228;
		$pdf_lang_code=$pdf_lang['code'];
		$product_link =
		olc_href_link('product_info.php',"products_id=#&language=".$pdf_lang_code,NONSSL,false,true,false,true);
		$product_link=str_replace(strtolower(HTTPS),strtolower(HTTP),$product_link);
		$pdf->product_link=$product_link;
		$pdf->LoadData($pdf->column_width1);
		if (sizeof($pdf->data)>1)
		{
			if (STORE)
			{
				$pdf->format();
			}
			if (IS_ADMIN_FUNCTION)
			{
				$file=$domain.UNDERSCORE.$file.".pdf";  //Store file
				$file="lang/".$pdf_lang[directory].SLASH.$file;  //Store file
				$message.=HTML_BR.$file;
				$file=$language_dir_start.$file;
			}
			else
			{
				switch ($pdf_lang_code)
				{
					case "en": $file="Catalogue";break;
					default: $file="Katalog";break;
				}
				$file=STORE_NAME. " -- ".$file.".pdf";
				$dest="I";				//Send to Browser
			}
			$pdf->Output($file,$dest);
		}
		if (NOT_IS_ADMIN_FUNCTION)
		{
			olc_exit();
		}
	}
}
$use_catalog_link=false;
$is_print_version=false;
$main_content=TEXT_CATALOGUE_SUCCESS;
if (IS_ADMIN_FUNCTION)
{
	$message=$main_content.HTML_BR.$message.HTML_BR.HTML_BR;
	$messageStack->add($message,'success');
	$main_content=$messageStack->output('*');
	if (USE_AJAX)
	{
		$smarty->assign(MAIN_CONTENT,$main_content);
		$smarty->display(INDEX_HTML);
	}
	else
	{
		$_SESSION['session_messageStack']=$main_content;
		olc_redirect(olc_href_link(FILENAME_DEFAULT,EMPTY_STRING,NONSSL,false,true,false,true));
	}
}
else
{
	if (USE_AJAX)
	{
		$smarty->assign(MAIN_CONTENT,$main_content);
		$smarty->display(INDEX_HTML);
	}
	else
	{
		olc_exit();
	}
}

function set_filename($group_check_group,$tax_inc,$fsk18_check)
{
	$dash="-";
	if ($group_check_group)
	{
		$file=$dash.$group_check_group;
	}
	if ($tax_inc)
	{
		$s="inkl";
	}
	else
	{
		$s="exkl";
	}
	$file.=$dash.$s."_mwst";
	if ($fsk18_check)
	{
		$s="mit";
	}
	else
	{
		$s="ohne";
	}
	$file.=$dash.$s."_fsk18";
	return  "Katalog".strtolower($file);
}
?>