<?php
/*
$Id: pdf_datasheet_functions.php,v 1.1.1.1.2.1 2007/04/08 07:18:42 gswkaiser Exp $
osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com
Copyright (c) 2003 osCommerce
Released under the GNU General Public License

Modified by Jochen Kirchhoff, jochen888@web.de
Anmerkung:
-Anpassung für 3 Images Contribution optional im Quelltext

Adapted for OL-Commerce by W. Kaiser, w.kaiser@fortune.de
*/

define('LEFT','L');
define('RIGHT','R');
define('CENTER','C');
define('BOLD','B');
define('ITALIC','I');
define('PDF','.pdf');
define('TEXT_DASH',chr(150));

$class_path="includes/classes/";
if (NOT_IS_ADMIN_FUNCTION)
{
	$class_path="admin/".$class_path;
}
define('FPDF_FONTPATH',$class_path.'fpdf/font/');
require($class_path . 'fpdf/fpdf.php');

require('pdf/pdf_datasheet_config.php');

include(DIR_WS_LANGUAGES . SESSION_LANGUAGE . SLASH. CURRENT_SCRIPT);

$products_id=$_GET['products_id'];
// global name of the later document
$docfilename = EMPTY_STRING;

class PDF extends FPDF
{
	//Starting Y position
	var $y0;
	var $font='Arial';
	var $columns;
	var $total_width;
	var $column_width;
	var $column_width1;
	var $total_height;
	var $impressum;
	var $impressum_lines;
	var $impressum_left;
	var $max_impressum_line_length;
	var $footer;
	var $footer_top;
	var $footer_left;
	var $footer_disclaimer;
	var $footer_disclaimer_left;
	var $y_after_name;
	var $cells_height=5;
	var $y_after_image;
	var $y_after_description;
	var $language_parameter;
	var $max_image_height;
	var $dash_array;

	function Header()
	{
		global $products_id,$products_link;

		$this->SetFont($this->font,EMPTY_STRING,10);
		if (!$this->impressum)
		{
			$this->dash_array=array(HTML_MDASH,HTML_NDASH);
			$this->impressum=array();
			$store=explode(NEW_LINE,STORE_NAME_ADDRESS);
			$lines=sizeof($store)-1;
			for ($i=0;$i<=$lines;$i++)
			{
				$s=trim($store[$i]);
				if ($i==$lines)
				{
					$this->impressum[]=EMPTY_STRING;
					if (strpos($s,TEXT_FON)===false)
					{
						$s=TEXT_FON.'.: '.$s;
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

			$this->impressum[]=EMPTY_STRING;
			$this->impressum[]=EMPTY_STRING;

			$this->impressum_lines=sizeof($this->impressum);
			$this->max_image_height=($this->impressum_lines-2)*$this->FontSize*$this->k;
			$this->impressum_left=ceil($this->w-$this->rMargin-$this->max_impressum_line_length);
		}
		if (PDF_SHOW_BACKGROUND){
			//Show background
			$this->Background();
		}
		if (PDF_SHOW_WATERMARK){
			//Put watermark
			$this->Watermark();
		}

		$header_text_color=explode(COMMA,PDF_HEADER_COLOR_TEXT);
		$this->SetTextColor($header_text_color[0],$header_text_color[1],$header_text_color[2]);
		if (PDF_SHOW_LOGO)
		{
			// Store Logo
			// BOF Mod for correct imagesize & type
			// Get the data of this picture
			$image=FULL_CURRENT_TEMPLATE."images/logo.jpg";
			$img =getimagesize($image);
			$w=$img[0];
			$h=$img[1];
			if($h>$this->max_image_height)
			{
				$w=$w*($this->max_image_height/$h);
				$h=$this->max_image_height;
			}
			//Get the type of this picture
			switch ($img[2])
			{
				case 1:
					//picturetype is 'gif'
					$imagetype ='GIF';
					break;
				case 2:
					//picturetype is 'jpg'
					$imagetype ='JPG';
					break;
				case 3:
					//picturetype is 'png'
					$imagetype ='PNG';
					break;
			}
			$link=olc_href_link('index.php',$this->language_parameter,NONSSL,false,true,false,true);
			$image=FULL_CURRENT_TEMPLATE."images/logo.jpg";
			$this->Image($image,$this->lMargin,$this->tMargin,$w/$this->k,$h/$this->k,EMPTY_STRING,$link);
			// EOF Mod for correct imagesize & type
		}
		else
		{
			//Store Name
			$this->SetFont($this->font,BOLD,18);
			$this->SetLineWidth(0);
			$w=$this->GetStringWidth(STORE_NAME)+6;
			$this->Cell($w,8,STORE_NAME,0,0,LEFT);
		}
		$this->SetFont($this->font,EMPTY_STRING,10);
		$this->Cell($imagewidth_3,$this->cells_height,EMPTY_STRING,0,0);
		$left=$this->impressum_left;
		$this->SetY($this->tMargin);
		for ($i=0;$i<$this->impressum_lines;$i++)
		{
			$this->SetX($left);
			$this->MultiCell($left-$this->rMargin,4,$this->impressum[$i],0,LEFT);
			$top+=$this->descr_lines_height;
		}
		//PDF-Info
		$this->SetAuthor(STORE_NAME);
		$products_name = $this->ProductsData($products_id, SESSION_LANGUAGE_ID,'products_name');
		$this->SetTitle($products_name );
		$this->SetSubject(PDF_TITLE);
		//Keep Y position
		$this->y0=$this->GetY();
		$product_name_color_text=explode(COMMA,PDF_PRODUCT_NAME_COLOR_TEXT);
		$this->Ln(0);
		$path = $this->GetPath($products_id, SESSION_LANGUAGE_ID,$cat_link);
		$cat_link=olc_href_link('index.php','cPath='.$cat_link.$this->language_parameter,NONSSL,false,true,false,true);
		$this->SetFont($this->font,ITALIC,10);
		$header_color_table=explode(COMMA,PDF_HEADER_COLOR_TABLE);
		$this->SetFillColor($header_color_table[0],$header_color_table[1],$header_color_table[2]);
		$this->SetTextColor($product_name_color_text[0],$product_name_color_text[1],$product_name_color_text[2]);
		$this->Cell(0,$this->cells_height,$path .' > '. $products_name,0,0,LEFT,1,$cat_link);
		$this->Ln(10);

		// Display product name
		$this->SetFont($this->font,BOLD,16);
		$product_name_color_table=explode(COMMA,PDF_PRODUCT_NAME_COLOR_TABLE);
		$this->SetFillColor($product_name_color_table[0],$product_name_color_table[1],$product_name_color_table[2]);
		$this->SetTextColor($product_name_color_text[0],$product_name_color_text[1],$product_name_color_text[2]);
		$products_link=olc_href_link(FILENAME_PRODUCT_INFO,'products_id='.$products_id.$this->language_parameter,
			NONSSL,false,true,false,true);
		$this->MultiCell(0,8,$products_name,0,LEFT,1,$products_link);
		$this->Ln($this->cells_height);
		$this->y_after_name=$this->GetY();
		if (PDF_SHOW_SHORT_DESCRIPTION)
		{
			global $products_data;
			$this->SetFont($this->font,BOLD,11);
			$body_color_text=explode(COMMA,PDF_BODY_COLOR_TEXT);
			$this->SetTextColor($body_color_text[0],$body_color_text[1],$body_color_text[2]);
			$w=$this->w*.6;
			$this->Cell($w,$this->cells_height,EMPTY_STRING,0,0);
			$products_short_description = strip_tags($products_data['PRODUCTS_SHORT_DESCRIPTION']);
			$this->SetX($this->lMargin);
			$products_short_description=str_replace(NEW_LINE,BLANK,$products_short_description);
			$this->MultiCell($w,$this->cells_height,$products_short_description,0,LEFT);
			$this->Ln($this->cells_height);
		}
	}

	function RotatedText($x,$y,$txt,$angle)
	{
		//Text rotated around its origin
		$this->Rotate($angle,$x,$y);
		$this->Text($x,$y,$txt);
		$this->Rotate(0);
	}

	function Footer()
	{
		$this->SetFont($this->font,EMPTY_STRING,9);
		//Footer notes
		if (!$this->footer)
		{
			//Footer
			global $products_data;
			if (NO_TAX_RAISED)
			{
				$price_disclaimer=PRICE_DISCLAIMER_NO_TAX_NO_LINK;
			}
			else
			{
				if (CUSTOMER_SHOW_PRICE_TAX)
				{
					global $products_data;
					$price_disclaimer=sprintf(PRICE_DISCLAIMER_INCL_NO_LINK,$products_data['PRODUCTS_TAX_VALUE']);
				}
				else
				{
					$price_disclaimer=PRICE_DISCLAIMER_EXCL_NO_LINK;
				}
			}
			$price_disclaimer=str_replace($this->dash_array,TEXT_DASH,$price_disclaimer);
			$price_disclaimer=strip_tags($price_disclaimer);
			$this->footer=
			str_replace(HASH,date('d.m.Y H:m'),TEXT_DATASHEET_CREATION_DATE).strip_tags($price_disclaimer);
			$this->footer_left=ceil($this->w-$this->GetStringWidth($this->footer))/2;
			$this->footer_disclaimer=$products_data['GENERAL_DISCLAIMER'];
			$this->footer_top=$this->h-$this->tMargin;
			if ($this->footer_disclaimer)
			{
				$this->footer_disclaimer_left=ceil($this->w-$this->GetStringWidth($this->footer_disclaimer))/2;
			}
			else
			{
				$this->footer_top+=$this->cells_height;
			}
		}
		$footer_color_cell=explode(COMMA,PDF_FOOTER_CELL_BG_COLOR);
		$this->SetFillColor($footer_color_cell[0],$footer_color_cell[1],$footer_color_cell[2]);
		$footer_color_text=explode(COMMA,PDF_FOOTER_CELL_TEXT_COLOR);
		$this->SetTextColor($footer_color_text[0],$footer_color_text[1],$footer_color_text[2]);
		$this->Text($this->footer_left,$this->footer_top,$this->footer);		//Footer
		$link=olc_href_link(FILENAME_CONTENT,'coID=1'.$this->language_parameter,NONSSL,false,true,false);
		$this->Link($this->footer_left,$this->footer_top-.5*($this->FontSize),
			$this->GetStringWidth($this->footer),$this->FontSize,$link);
		if ($this->footer_disclaimer)
		{
			$this->Text($this->footer_disclaimer_left,$this->footer_top+$this->cells_height,$this->footer_disclaimer);		//Disclaimer
		}
	}

	function CheckPageBreak($h)
	{
		//Creates a new page if needed
		if ($this->GetY()+$h>$this->PageBreakTrigger){
			$this->AddPage($this->CurOrientation);
		}
	}

	function NbLines($w,$txt)
	{
		//Calculate number of lines for a "w" width Multicell
		$cw=&$this->CurrentFont['cw'];
		if ($w==0)
		$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",EMPTY_STRING,$txt);
		$nb=strlen($s);
		if ($nb>0 and $s[$nb-1]==NEW_LINE)
		$nb--;
		$sep=-1;
		$i=0;
		$j=0;		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if ($c==NEW_LINE)
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if ($c==' ')
			$sep=$i;
			$l+=$cw[$c];
			if ($l>$wmax)
			{
				if ($sep==-1)
				{
					if ($i==$j)
					$i++;
				}
				else
				$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
			$i++;
		}
		return $nl;
	}

	function LineString($x,$y,$txt,$cellheight)
	{
		//calculate the width of the string
		$stringwidth=$this->GetStringWidth($txt);
		$ypos=($y+($cellheight/2));
		$this->Line($x,$ypos,($x+$stringwidth),$ypos);
	}

	function ShowImage(&$width,&$height,$path,$loc='',$x_pos=1,$products_link='')
	{
		$width=min($width,PDF_MAX_IMAGE_WIDTH);
		$height = (IMAGE_KEEP_PROPORTIONS != 0 ? $height : min($height,PDF_MAX_IMAGE_HEIGHT));
		$this->SetLineWidth(1);
		$this->Cell($width,$height,EMPTY_STRING,0,0);
		$this->SetLineWidth(0.2);
		if (file_exists($path))
		{
			$pos=strrpos($path,DOT);
			$type=substr(strtolower($path),$pos+1);
			$legal_types=".jpg.jpeg.png.gif";
			$legal_image=strpos($legal_types,$type)!==false;
			$try_on_the_fly=false;
		}
		else
		{
			$legal_image=false;
			$try_on_the_fly=DO_IMAGE_ON_THE_FLY;
		}
		if (!$legal_image)
		{
			//W. Kaiser - "picture-on-the-fly"-modification
			if ($try_on_the_fly)
			{
				olc_image($path);
				$legal_image=file_exists($path);
			}
		}
		if ($legal_image)
		{
			if (!$loc)
			{
				$x_pos=$this->GetX()-$width;
			}
			$this->Image($path,$x_pos, $this->GetY(), $width, $height,EMPTY_STRING,$products_link);
		}else{
			$this->x = $this->lMargin;
			$y=$this->GetY();
			$product_name_color_table=explode(COMMA,PDF_PRODUCT_NAME_COLOR_TABLE);
			$this->SetFillColor($product_name_color_table[0],$product_name_color_table[1],$product_name_color_table[2]);
			if ($_SESSION['language_code']=='de')
			{
				$text='Kein Bild';
			}
			else
			{
				$text='No image';
			}
			$this->Cell($width,$height,$text,1,0,C);
		}
	}

	function CalculatedSpace($y1,$y2,$imageheight)
	{
		//Si les commentaires sont - importants que l'image au niveau de l'espace d'affichage
		if (($h2=$y2-$y1) < $imageheight)
		{
			$this->Ln(($imageheight-$h2)+3);
		}
		else
		{
			$this->Ln(3);
		}
	}

	function DrawCells($data_array)
	{
		$totallines=0;
		$imagewidth=$data_array[0];
		$s=$this->w-$imagewidth;
		for($i=2;$i<(sizeof($data_array)-1);$i++)
		{
			$totallines+=$this->NbLines($s,$data_array[$i]);
		}
		//5 = cells height
		$h=$this->cells_height*$totallines;
		//if products description takes the whole page height goes to new page
		if ($h<pDF_TEXT_HEIGHT)
		{
			$this->CheckPageBreak($h);
		}
		$body_color_text=explode(COMMA,PDF_BODY_COLOR_TEXT);
		$this->SetTextColor($body_color_text[0],$body_color_text[1],$body_color_text[2]);
		$this->SetFont($this->font,EMPTY_STRING,9);
		if (PDF_SHOW_PRICE)
		{
			if (CUSTOMER_SHOW_PRICE)
			{
				$this->SetFont($this->font,BOLD,14);
				$price=$data_array['PRODUCTS_PRICE_DISPLAY'];
				if ($price)
				{
					$y=$this->y_after_name;
					if (PDF_SHOW_SPECIALS_PRICE)
					{
						$s=explode(HTML_BR,$price);
						$show_special_price=sizeof($s)>1;
						if ($show_special_price) //If special price
						{
							$price=str_replace($br_array,HTML_BR,$price);
							$s=explode(HTML_BR,$price);
							$price=strip_tags($s[0]);
							$special_price=strip_tags($s[1]);
						}
					}
					$base_price=$data_array['PRODUCTS_BASEPRICE'];
					$base_price=strip_tags(str_replace(HTML_NBSP,BLANK,$base_price));
					$sw=$this->GetStringWidth($price);
					$x=$this->w-$this->rMargin-$sw;
					$price_uvp=$data_array['PRODUCTS_UVP'];
					if ($price_uvp)
					{
						$this->SetTextColor('red');
					}
					$this->Text($x,$y+$this->cells_height,$price);
					$this->SetDrawColor($body_color_text[0],$body_color_text[1],$body_color_text[2]);
					if ($price_uvp)
					{
						$this->SetTextColor($body_color_text[0],$body_color_text[1],$body_color_text[2]);
						$y+=$this->FontSize;
						$y+=$this->FontSize;
						$this->SetFont($this->font,BOLD,8);
						$price_uvp=strip_tags($price_uvp);
						$sw=$this->GetStringWidth($price_uvp);
						$x=$this->w-$this->rMargin-$sw;
						$this->Text($x,$y,$price_uvp);
						$this->LineString($x,$y,$price_uvp,-$this->FontSize/2);
					}
					if ($show_special_price)
					{
						$this->LineString($x,$y,$price,$this->cells_height+1);
						$special_price_color_field=explode(COMMA,PDF_SPECIAL_PRICE_COLOR_FIELD);
						$this->SetFillColor($special_price_color_field[0],$special_price_color_field[1],$special_price_color_field[2]);
						$special_price_color_text=explode(COMMA,PDF_SPECIAL_PRICE_COLOR_TEXT);
						$this->SetTextColor($special_price_color_text[0],$special_price_color_text[1],$special_price_color_text[2]);
						$this->SetFont($this->font,BOLD,14);
						$y+=$this->cells_height;
						$y+=$this->cells_height;
						$sw=$this->GetStringWidth($special_price);
						$x=$this->w-$this->rMargin-$sw;
						$this->Text($x,$y,$special_price);
						if ($base_price)
						{
							$this->SetFont($this->font,EMPTY_STRING,8);
							$sw=$this->GetStringWidth($base_price);
							$x=$this->w-$this->rMargin-$sw;
							$this->Text($x,$this->GetY(),str_replace(HTML_NBSP,BLANK,$base_price));
						}
						if (PDF_SHOW_SPECIALS_PRICE_EXPIRES)
						{
							$s=$data_array['PRODUCTS_SPECIALPRICE'];
							if ($s)
							{
								$s=strip_tags($s);
								$y+=$this->cells_height;
								$y+=$this->cells_height;
								$this->SetFont($this->font,BOLD,8);
								$sw=$this->GetStringWidth($s);
								$x=$this->w-$this->rMargin-$sw;
								$this->Text($x,$y,$s);
							}
						}
						$bg_color=explode(COMMA,PDF_PAGE_BG_COLOR);
						$this->SetFillColor($bg_color[0],$bg_color[1],$bg_color[2]);
						$this->SetTextColor($body_color_text[0],$body_color_text[1],$body_color_text[2]);
					}
					else
					{
						if ($base_price)
						{
							$base_price=str_replace(HTML_NBSP,BLANK,$base_price);
							$this->SetFont($this->font,EMPTY_STRING,8);
							$sw=$this->GetStringWidth($base_price);
							$x=$this->w-$this->rMargin-$sw;
							$this->Text($x,$this->GetY(),str_replace(HTML_NBSP,BLANK,$base_price));
						}
					}
				}
			}
		}
		$this->SetFillColor($special_price_color_field[0],$special_price_color_field[1],$special_price_color_field[2]);
		$this->SetTextColor($body_color_text[0],$body_color_text[1],$body_color_text[2]);
		$this->SetFont($this->font,EMPTY_STRING,9);
		$max_y=$this->GetY();
		if (PDF_SHOW_SHIPPING_TIME)
		{
			$s=$data_array['SHIPPING_NAME'];
			if ($s)
			{
				$this->Cell(0,$this->cells_height,EMPTY_STRING,0,0);
				$this->SetX($this->lMargin);
				$this->MultiCell(0,$this->cells_height,$data_array['SHIPPING_DESC'].$s,0,LEFT);
				$max_y=max($max_y,$this->GetY());
			}
		}
		$this->SetY($max_y+$this->cells_height);
		if (PDF_SHOW_IMAGES)
		{
			$image=$data_array['PRODUCTS_IMAGE'];
			$pos=strpos($image,DIR_WS_IMAGES);
			if ($pos>0)
			{
				$image=substr($image,$pos);
			}
			$show_image=true;
			if (strlen($image))
			{
				//If custom image
				$heightwidth=getimagesize($image);
				$heightwidth_0=$heightwidth[0]*$this->pdf_to_mm_faktor;
				$heightwidth_1=$heightwidth[1]*$this->pdf_to_mm_faktor;
				$imageheight=$data_array[1];
				$len_imagewidth=strlen($imagewidth);
				$len_imageheight=strlen($imageheight);
				if (PDF_IMAGE_KEEP_PROPORTIONS != 0 )
				{
					$imagewidth=$heightwidth_0;
					// 		Bild in Orginalgröße abbilden, maximale Größe ignorieren
					$factor = $heightwidth_0/$heightwidth_1;
					$imageheight=$imagewidth/$factor;
				}
				//If only Small Image Width is defined
				else if ($len_imagewidth>1 && $len_imageheight)
				{
					$imageheight=$heightwidth_1;
				}
				//If only Small Image Height is defined
				else if ($len_imagewidth && $len_imageheight>1)
				{
					$imagewidth=$heightwidth_0;
				}
				else
				{
					$imagewidth=$heightwidth_0;
					$imageheight=$heightwidth_1;
				}
				global $products_link;
				$this->ShowImage($imagewidth,$imageheight,$image,true,$this->lMargin,$products_link);
			}
			else
			{
				$imagewidth=$imageheight=0;
			}
		}
		$y1=$this->GetY();
		$x_m_imagewidth=$this->w-$this->rMargin-$imagewidth+3;
		$imagewidth_3=$imagewidth+3;
		$this->SetY($y1+$this->info['h']/$this->k+$this->cells_height);		//Ad image height
		$this->Cell(0,$this->cells_height,EMPTY_STRING,0,0);
		$this->SetX($this->lMargin);
		$this->MultiCell(0,$this->cells_height,PICTURE_DISCLAIMER,0,LEFT);
		if (PDF_SHOW_MODEL)
		{
			$s=$data_array['PRODUCTS_MODEL'];
			if ($s)
			{
				$this->Cell(0,$this->cells_height,EMPTY_STRING,0,0);
				$this->SetX($this->lMargin);
				$this->MultiCell(0,$this->cells_height,TEXT_PRODUCTS_MODEL .$s,0,LEFT);
			}
		}
		if (PDF_SHOW_VPE)
		{
			$s=$data_array['PRODUCTS_VPE'];
			if ($s)
			{
				$this->Cell(0,$this->cells_height,EMPTY_STRING,0,0);
				$this->SetX($this->lMargin);
				$this->MultiCell(0,$this->cells_height,$s,0,LEFT);
			}
		}
		$s=$data_array['PRODUCTS_MIN_ORDER_QTY'];
		if ($s)
		{
			$s=str_replace(HTML_BR,TILDE,$s);
			$color=EMPTY_STRING;
			$s1="color:";
			$poss=strpos($s,$s1);					//Any color in style?
			if ($poss!==false)
			{
				$poss+=strlen($s1);
				$pose=strpos($s,QUOTE,$poss);
				if ($pose!==false)
				{
					$color=trim(substr($s,$poss,$pose-$poss));
				}
			}
			$s=trim(strip_tags($s));
			if ($color)
			{
				$this->SetTextColor($color);
			}
			$this->Cell(0,$this->cells_height,EMPTY_STRING,0,0);
			$this->SetX($this->lMargin);
			$this->MultiCell(0,$this->cells_height,$s,0,LEFT);
			if ($color)
			{
				$this->SetTextColor($body_color_text[0],$body_color_text[1],$body_color_text[2]);
			}
		}
		if (PDF_SHOW_MANUFACTURER)
		{
			$s=$data_array['PRODUCTS_MANUFACTURER'];
			if ($s)
			{
				$this->Cell(0,$this->cells_height,EMPTY_STRING,0,0);
				$this->SetX($this->lMargin);
				$this->MultiCell(0,$this->cells_height,TEXT_PRODUCTS_MANUFACTURER .$s,0,LEFT);
			}
		}
		$this->y_after_image=$this->GetY();
		global $empty_line,$p_array,$b_array,$br_array,$html_br_len,$html_b_len;

		$empty_line='<p></p>';
		$p_array=array('<P>','<p>','</P>','</p>');
		$b_array=array('<B>',HTML_B_START,'</B>',HTML_B_END,'<STRONG>','<strong>','</STRONG>','</strong>');
		$br_array=array('<BR>','<br>',HTML_BR,'<br />');
		$html_br_len=strlen(HTML_BR);
		$html_b_len=strlen(HTML_B_START);
		if (PDF_SHOW_DESCRIPTION)
		{
			$this->SetY($y1);
			$desc= explode("~~",$data_array['PRODUCTS_DESCRIPTION']);
			$this->SetFont($this->font,EMPTY_STRING,9);
			$this->Cell($imagewidth_3,$this->cells_height,EMPTY_STRING,0,0);
			$left=$this->GetX();
			foreach ($desc as $desc_row)
			{
				$this->output_text($left,0,$desc_row);
			}
			$this->y_after_description=$this->GetY();
		}
		$x2=$this->GetX();
		$y2=$this->GetY();
		$this->SetFont($this->font,EMPTY_STRING,9);

		//if products description does not take the whole page height
		//	 if ($h<$this->h)
		//	 {
		$this->CalculatedSpace($y1,$y2,$imageheight);
		// 	 }
	}

	function GetPath($products_id, $languages_id,&$cat_link)
	{
		$cat_id_sql = olc_db_query("select pc.categories_id, cd.categories_name from " .
		TABLE_PRODUCTS_TO_CATEGORIES . " pc,  " . TABLE_CATEGORIES_DESCRIPTION . " cd
			where
      pc.products_id = '" . $products_id . "' and
      cd.categories_id = pc.categories_id and
			cd.language_id = '" . $languages_id . "' LIMIT 1") ;
		if (olc_db_num_rows($cat_id_sql) > 0)
		{
			$cPath = EMPTY_STRING;
			$cat_link = EMPTY_STRING;
			$cat_id_data = olc_db_fetch_array($cat_id_sql);
			$categories = array();
			olc_get_parent_categories($categories, $cat_id_data['categories_id']);
			$parent_id_sql0 = SELECT."categories_name,categories_id from " . TABLE_CATEGORIES_DESCRIPTION .
			" where categories_id = '#' and language_id = '" . $languages_id . APOS;
			$size = sizeof($categories)-1;
			for ($i=$size; $i >= 0; $i--)
			{
				$parent_id_sql = olc_db_query(str_replace(HASH,$categories[$i],$parent_id_sql0));
				$parent_id_data = olc_db_fetch_array($parent_id_sql);
				if ($cPath != EMPTY_STRING)
				{
					$cPath .= ' > ';
					$cat_link .="_";
				}
				$cPath .= $parent_id_data['categories_name'];
				$cat_link .= $categories[$i];
			}
			if ($cPath != EMPTY_STRING)
			{
				$cPath .= ' > ';
				$cat_link .="_";
			}
			$cPath .= $cat_id_data['categories_name'];
			$cat_link .=$cat_id_data['categories_id'];
		}
		return $cPath;
	}

	function ProductsData($products_id, $languages_id,$field){
		$products_name_query = olc_db_query("select ".$field." from " . TABLE_PRODUCTS_DESCRIPTION . " where
                               products_id = '" . $products_id . "' and
                               language_id = '" . $languages_id . APOS);
		$products_name = olc_db_fetch_array($products_name_query);
		return $products_name[$field];
	}

	function ProductsDataSheet($languages_id, $products_id){
		global $currencies;
		global $docfilename;

		//Convertion pixels -> mm
		$this->pdf_to_mm_faktor=1/$this->k;

		$imagewidth=PRODUCT_IMAGE_INFO_WIDTH*$this->pdf_to_mm_faktor;
		$imageheight=PRODUCT_IMAGE_INFO_HEIGHT*$this->pdf_to_mm_faktor;

		//W. Kaiser -- AJAX
		//Use 'product_info.php' also for printing!!
		$isprint_version=true;
		$is_pdf=true;
		include(DIR_WS_MODULES.'product_info.php');
		//W. Kaiser -- AJAX

		global $products_data;
		//Get Data fram Smarty
		$products_data=array();
		$products_data[]=$imagewidth;
		$products_data[]=$imageheight;
		while (list($key, $value) = each($info_smarty->_tpl_vars))
		{
			$products_data[$key]=$value;
		}
		require_once(DIR_FS_INC.'olc_get_smarty_config_variable.inc.php');
		$products_data['SHIPPING_DESC']=olc_get_smarty_config_variable($info_smarty,'product_info','text_shippingtime');

		$this->AddPage();
		$this->DrawCells($products_data);
		$this->SetY(max($this->y_after_description,$this->y_after_image)+$this->cells_height);
		if (PDF_SHOW_OPTIONS)
		{
			$products_options_name_sql = "
				select distinct
				popt.products_options_id,
				popt.products_options_name
				from " .
			TABLE_PRODUCTS_OPTIONS . " popt, " .
			TABLE_PRODUCTS_ATTRIBUTES . " patrib
				where
				patrib.products_id='" . $products_id . "' and
				patrib.options_id = popt.products_options_id and
				popt.language_id = '" . SESSION_LANGUAGE_ID . APOS;
			$products_options_name = olc_db_query($products_options_name_sql);
			if (olc_db_num_rows($products_options_name))
			{
				$this->DrawSeparatorLine();
				//pov.products_options_values_thumbnail,
				$products_options_sql0 = "
				select
				pov.products_options_values_id,
				pov.products_options_values_name,
				pa.options_values_price,
				pa.price_prefix from " .
				TABLE_PRODUCTS_ATTRIBUTES . " pa, " .
				TABLE_PRODUCTS_OPTIONS_VALUES . " pov where
				pa.products_id = '" . $products_id . "'
				and pa.options_id = '#'
				and pa.options_values_id = pov.products_options_values_id
				and pov.language_id = '" . SESSION_LANGUAGE_ID . "'
				order by pov.products_options_values_name";

				$this->SetFont($this->font, BOLD, 10);
				$special_price_color_text=explode(COMMA,PDF_SPECIAL_PRICE_COLOR_TEXT);
				$this->SetTextColor($special_price_color_text[0],$special_price_color_text[1],$special_price_color_text[2]);
				$this->MultiCell(0, 8, TEXT_PRODUCTS_OPTIONS . $print_catalog_array['name'],0, LEFT, 0);
				$this->SetFont($this->font, EMPTY_STRING, 8);
				$options_color_text=explode(COMMA,PDF_OPTIONS_COLOR);
				$this->SetTextColor($options_color_text[0],$options_color_text[1],$options_color_text[2]);
				$options_color_text=explode(COMMA,PDF_OPTIONS_BG_COLOR);
				$this->SetFillColor($options_color_text[0],$options_color_text[1],$options_color_text[2]);
				if (PDF_OPTIONS_AS_IMAGES_ENABLED == TRUE_STRING_S)
				{
					//OAI query
					if (PDF_SHOW_OPTIONS_VERTICAL != 0)
					// Option values are displayed horizontaly
					{
						while ($products_options_name_values = olc_db_fetch_array($products_options_name)) {
							$this->Ln(6);
							$this->SetFont($this->font, BOLD, 11);
							$this->Cell(190, $this->cells_height, $products_options_name_values['products_options_name'],0, 0, LEFT);
							$this->Ln();
							$products_options_sql=
								str_replace(HASH,$products_options_name_values['products_options_id'],$products_options_sql0);
							$products_options = olc_db_query($products_options_sql);
							$count_options_values = olc_db_num_rows($products_options);
							$count_options = 0;
							$largest_y = $this->GetY();
							//OAI query
							$products_options_query = olc_db_query($products_options_query_sql);
							while ($products_options_values = olc_db_fetch_array($products_options_query))
							{
								$products_options_values_name=$products_options_values['products_options_values_name'];
								$w = $this->GetStringWidth($products_options_values_name) + 2;
								$this->SetFont($this->font, EMPTY_STRING, 10);
								$this->SetTextColor($body_color_text[0],$body_color_text[1],$body_color_text[2]);
								$option_string = $products_options_values_name;
								$current_x = $this->GetX();
								if (PDF_SHOW_OPTIONS_PRICE)
								{
									$options_values_price=$products_options_values['options_values_price'];
									if ($options_values_price != ' 0.0000')
									{
										$option_string.=LPAREN . $products_options_values['price_prefix'] .
										olc_format_price($options_values_price,true,true,true). RPAREN;
									}
								}
								$count_options++;
								$add_to =  ($count_options_values != $count_options ? ',' : '.');
								$this->Write($this->cells_height, $option_string . $add_to);
								$largest_y = $this->GetY();
								$next_x = $this->GetX();
								if ($products_options_name_values['products_options_images_enabled'] == TRUE_STRING_S)
								{
									$path_to_image = DIR_IMAGE . 'options/' .
									$products_options_values['products_options_values_thumbnail'];
									$img_size = GetImageSize($path_to_image);
									$img_h = ($img_size[1] * $this->pdf_to_mm_faktor);
									$img_w = $img_size[0] * $this->pdf_to_mm_faktor;
									if ($next_x < ($current_x + $img_w)) {
										$next_x = $current_x + $img_w;
									}
									$current_y = $this->GetY();
									$image_y = ($this->GetY()) + $this->cells_height;
									$largest_y = $image_y + $img_h;
									$this->SetY($image_y);
									$this->SetX($current_x);
									$this->ShowImage($img_w, $img_h, $path_to_image); //, false, 0);
									$this->SetY($current_y);
									$this->SetX($next_x);
								}
								$this->Cell(3, 6, EMPTY_STRING, 0, 0, CENTER);
								$this->SetTextColor('Black');
							}
							$this->SetY($largest_y);
						}
					}
					else
					{
						// Option values are displayed vertically
						while ($products_options_name_values = olc_db_fetch_array($products_options_name))
						{
							$this->Ln(6);
							$this->SetFont($this->font, BOLD, 11);
							$this->Cell(190, $this->cells_height, $products_options_name_values['products_options_name'],0, 0, LEFT);
							$this->Ln();

							$products_options_sql=str_replace(HASH,$products_options_name_values['products_options_id'],$products_options_sql0);
							$products_options = olc_db_query($products_options_sql);
							$count_options_values = olc_db_num_rows($products_options);
							//OAI query
							$products_options_query = olc_db_query($products_options_query_sql);
							// Loop on all option values
							while ($products_options_values = olc_db_fetch_array($products_options_query))
							{
								$this->SetFont($this->font, EMPTY_STRING, 9);
								$this->SetTextColor($body_color_text[0],$body_color_text[1],$body_color_text[2]);
								$option_string = $products_options_values['products_options_values_name'];
								if (PDF_SHOW_OPTIONS_PRICE)
								{
									$options_values_price=$products_options_values['options_values_price'];
									if ($options_values_price != ' 0.0000')
									{
										$option_string.=LPAREN . $products_options_values['price_prefix'] .
										olc_format_price($options_values_price,true,true,true). RPAREN;
									}
								}
								$count_options++;
								$add_to =  ($count_options_values != $count_options ? ',' : '.');
								$this->Write($this->cells_height, $option_string . $add_to);
								if ($products_options_name_values['products_options_images_enabled'] == TRUE_STRING_S)
								{
									$path_to_image = DIR_IMAGE . 'options/' . $products_options_values['products_options_values_thumbnail'];
									$img_size = GetImageSize($path_to_image);
									$img_h = ($img_size[1] * $this->pdf_to_mm_faktor);
									$img_w = $img_size[0] * $this->pdf_to_mm_faktor;
									$this->SetX(50);
									$this->ShowImage($img_w, $img_h, $path_to_image); //, false, 0);
									$this->SetX(0);
								}
								$this->Ln();
							} // end loop on options values
						} // end loop on options

					}
				}
				else
				{
					$this->Ln(-$this->cells_height);
					while ($products_options_name_values = olc_db_fetch_array($products_options_name)) {
						$this->Ln($this->cells_height);
						$this->SetFont($this->font,BOLD,11);
						$this->Cell($this->w,$this->cells_height,$products_options_name_values['products_options_name'],0,0,LEFT);
						$this->Ln();
						$products_options_sql=str_replace(HASH,$products_options_name_values['products_options_id'],$products_options_sql0);
						$products_options = olc_db_query($products_options_sql);
						$option_string=EMPTY_STRING;
						$count_options_values = olc_db_num_rows($products_options);
						$count_options = 0;
						while ($products_options_values = olc_db_fetch_array($products_options))
						{
							$option_string.= $products_options_values['products_options_values_name'];	//. $option_value;
							if (PDF_SHOW_OPTIONS_PRICE)
							{
								$options_values_price=$products_options_values['options_values_price'];
								if ($options_values_price != ' 0.0000')
								{
									$option_string.=LPAREN . $products_options_values['price_prefix'] .
									olc_format_price($options_values_price,true,true,true). RPAREN;
								}
							}
							$count_options++;
							$option_string .= ($count_options_values != $count_options ? COMMA_BLANK : DOT);
						}
						$this->SetFont($this->font,EMPTY_STRING,8);
						$w=$this->w-$this->lMargin-$this->rMargin;
						$this->SetX($this->lMargin);
						$this->MultiCell($w,$this->cells_height,$option_string,0,LEFT,1);
					}
				}
			}
		}
		$s=$products_data['PRODUCTS_SOLD_OUT'];
		if ($s)
		{
			$this->Ln($this->cells_height*2);
			$y=$this->GetY();
			$this->SetTextColor('red');
			$this->SetFont($this->font,BOLD,$this->FontSizePt);
			$s=strip_tags($s);
			$this->Text($this->lMargin,$y,$s);
			$s1=$products_data['PRODUCTS_DATE_AVAILABLE'];
			if ($s1)
			{
				$this->SetTextColor('Darkgreen');
				$this->Text($this->lMargin+$this->GetStringWidth($s),$y,BLANK.strip_tags($s1));
			}
			$this->Ln($this->cells_height);
		}
		if (PDF_SHOW_DATE_ADDED_AVAILABLE)
		{
			//Date available
			$s=$products_data['PRODUCTS_DATE_ADDED'];
			if ($s)
			{
				$x=$this->GetX();
				$y=$this->GetY();
				$this->SetFont($this->font,ITALIC,9);
				$this->Ln($this->cells_height);
				$new_color_table=explode(COMMA,PDF_HEADER_COLOR_TABLE);
				$this->SetFillColor($new_color_table[0],$new_color_table[1],$new_color_table[2]);
				$product_name_color_text=explode(COMMA,PDF_PRODUCT_NAME_COLOR_TEXT);
				$this->SetTextColor($product_name_color_text[0],$product_name_color_text[1],$product_name_color_text[2]);
				$this->MultiCell(0,$this->cells_height, sprintf(TEXT_DATE_ADDED,olc_date_short($s)),0,LEFT,1);
			}
		}
	}

	function Background()
	{
		$bg_color=explode(COMMA,PDF_PAGE_BG_COLOR);
		$this->SetFillColor($bg_color[0],$bg_color[1],$bg_color[2]);
		$this->Rect($this->lMargin,0,$this->w-$this->rMargin,$this->h,'F');
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
		$this->SetTextColor($watermark_color[0],$watermark_color[1],$watermark_color[2]);
		$this->RotatedText($this->lMargin/2+($this->w-$wwm)/2,($this->h+$hwm)/2,STORE_NAME,$ang);
	}

	function store_impressum_string($s)
	{
		$this->impressum[]=$s;
		$this->max_impressum_line_length=max($this->max_impressum_line_length,$this->GetStringWidth($s));
	}

	function output_text($left,$width,$desc_row)
	{
		global $empty_line,$p_array,$b_array,$br_array,$html_br_len,$html_b_len;

		$desc_row=str_replace(NEW_LINE,EMPTY_STRING,$desc_row);
		$desc_row=str_replace($empty_line,EMPTY_STRING,$desc_row);
		$desc_row=str_replace(HTML_NBSP,BLANK,$desc_row);
		$desc_row=str_replace(' :',':',$desc_row);
		if ($desc_row)
		{
			$desc_row= str_replace(array("<li>","<LI>"),'• ',$desc_row);
			$y=$y1;
			$found= eregi('images/(.*\.gif|.*\.jpg)',$desc_row,$img);
			if ($found)
			{
				$img[1]=str_replace('.gif','.jpg',$img[1]);
				$path_to_image = DIR_IMAGE . $img[1];
				if (file_exists($path_to_image)){
					$desc_row='IMG ' . $path_to_image;
					$img_size= GetImageSize($path_to_image);
					$img[7]=($img_size[1]*$this->pdf_to_mm_faktor);
					$img[6]=$img_size[0]*$this->pdf_to_mm_faktor;
					$this->ShowImage($img[6],$img[7],$path_to_image,$loc=1,$left);
					$this->SetY($img[7]+$y+$this->cells_height);
				}else{
					$this->ln(2);
				}
			}else{
				//Find HTML_BR, "<p>", HTML_B_START
				$l_desc_row=strtolower($desc_row);
				$line_parts=explode(HTML_BR,$desc_row);		//get #of text parts separated by <br/>
				$broken_line_parts=sizeof($line_parts)-1;
				for ($line=0;$line<=$broken_line_parts;$line++)
				{
					$line_part=$line_parts[$line];
					$line_part_len=strlen($line_parts[$line]);
					$line_part=str_replace($b_array,HTML_B_START,$line_part);
					$line_part_len=strlen($line_part);
					$l_line_part=strtolower($line_part);
					$add_line=!(strpos($l_line_part,"<p>")===false);
					if ($add_line)
					{
						//Eliminate "<p>"-tags
						$line_part=str_replace($p_array,EMPTY_STRING,$line_part);
						$l_line_part=strtolower($line_part);
						$line_part_len=strlen($line_part);
					}
					//Check for bolding
					$line_bold=explode(HTML_B_START,$line_part);
					$bold_parts=sizeof($line_bold)-1;
					$do_dolding=$bold_parts>1;
					for ($bold_part=0;$bold_part<=$bold_parts;$bold_part++)
					{
						$text2=trim($line_bold[$bold_part]);
						if ($text2)
						{
							$reset_bolding=false;
							if ($do_dolding)
							{
								if ($bold_part>0)
								{
									//Set font bold
									$this->SetFont($this->font,BOLD,$this->FontSizePt);
									$reset_bolding=true;
								}
							}
							$text2= strip_tags($text2);
							$this->SetX($left);
							$this->MultiCell($width,4,$text2,0,LEFT);
							if ($reset_bolding)
							{
								//Set font normal
								$this->SetFont($this->font,EMPTY_STRING,$this->FontSizePt);
							}
							if ($add_line)
							{
								//Add empty line
								$this->SetY($this->GetY()+$this->cells_height);
							}
						}
					}
				}
			}
		}
	}

	function DrawSeparatorLine()
	{
		$x=$this->GetX();
		$y=$this->GetY();
		$this->SetLineWidth(0.5);
		$product_name_color_table=explode(COMMA,PDF_PRODUCT_NAME_COLOR_TABLE);
		$this->SetDrawColor($product_name_color_table[0],$product_name_color_table[1],$product_name_color_table[2]);
		$this->Line($this->lMargin*2,$y,$this->w-$this->lMargin*2,$y);
		$this->Ln($this->cells_height);
	}
}

function WriteDocument($pdf,$docfilename){
	// Variable $docfilename kommt aus function ProductsDataSheet(), dann aus function GenerateFilename()

	//Save PDF to file
	$pdf->Output(PDF_DOC_PATH . $docfilename);
}

function GenerateFilename($docfilename)
{
	// Variable $docfilename kommt aus function ProductsDataSheet

	$find = array('/ä/','/ö/','/ü/','/ß/','/Ä/','/Ö/','/Ü/','/ /','/<br\/>/','/[:;\'\"\/]/');
	$replace = array('ae','oe','ue','ss','Ae','Oe','Ue',UNDERSCORE,UNDERSCORE,'');
	return preg_replace ($find , $replace, strtolower($docfilename) . UNDERSCORE . SESSION_LANGUAGE_ID . PDF);
}

function prepare_string_item(&$string_item,$line,$column_width)
{
	$string_item=strip_tags($string_item);
	$string_item=trim($string_item);
	$string_item=str_replace(HTML_NBSP,BLANK,$string_item);
	$string_item=str_replace(HTML_BR,BLANK,$string_item);
	$string_item = str_replace(HTML_B_START, HTML_B_START, $string_item);
	$string_item = str_replace(HTML_B_END, HTML_B_END, $string_item);
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
					$string_item=ltrim(substr($string_item,$i+1));
					$l_string_item=rtrim(substr($l_string_item,0,$i));
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

function StartDownload($filename){

	$filename = realpath($filename); //server specific
	$file_extension = strtolower(substr(strrchr($filename,"."),1));

	if (! file_exists( $filename ) )
	{
		die("NO FILE HERE");
	}

	switch( $file_extension )
	{
		case "pdf": $ctype="application/pdf"; break;
		case "exe": $ctype="application/octet-stream"; break;
		case "zip": $ctype="application/zip"; break;
		case "doc": $ctype="application/msword"; break;
		case "xls": $ctype="application/vnd.ms-excel"; break;
		case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
		case "gif": $ctype="image/gif"; break;
		case "png": $ctype="image/png"; break;
		case "jpe": case "jpeg":
		case "jpg": $ctype="image/jpg"; break;
		default: $ctype="application/force-download";
	}
	header("Pragma: public"); // required
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false); // required for certain browsers
	header("Content-Type: $ctype");
	//header("Content-Disposition: attachment; filename=".basename($filename).";" );
	header("Content-Disposition: inline; filename=".basename($filename).";" );
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".@filesize($filename));
	@readfile("$filename") or die("File not found.");
	exit();
}

//W. Kaiser
global $use_catalog_link,$is_print_version;
$use_catalog_link=true;
$is_print_version=true;

$pdf=new PDF();
$pdf->language_parameter='&language='.$_SESSION['language_code'];
$checkfilename=$pdf->ProductsData($products_id, SESSION_LANGUAGE_ID,'products_name');
$docfilename=GenerateFilename($checkfilename);
//If the File has been generated before, break up here and immediatly start the download or the redirect
if (false and file_exists(PDF_DOC_PATH . $docfilename) )
{
	if (PDF_FILE_REDIRECT){
		header('Location: ' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . PDF_DOC_PATH . $docfilename );
		exit();
	} else {
		StartDownload(PDF_DOC_PATH . $docfilename);
	}
}

//	$pdf->AddFont('Verdana','verdana.php');
//	$pdf->AddFont('Verdana', BOLD, 'verdanab.php');
//	$pdf->AddFont('Verdana', ITALIC, 'verdanai.php');
$pdf->Open();
$pdf->SetMargins(15,10,10);					//Ränder links ,rechts, oben
$pdf->SetAutoPageBreak = false;			//otherwise the pagebreak will not be calculated correctly, but automaticly (sometimes wrong) set.
$pdf->SetDisplayMode("real");
$pdf->AliasNbPages();
$pdf->ProductsDataSheet(SESSION_LANGUAGE_ID, $products_id);

if (PDF_SAVE_DOCUMENT)
{
	//Delete any PDF-file older then five minutes from now
	$dir = DIR_FS_CATALOG."cache/cache".SLASH;
	$dh = opendir($dir);
	if ($dh)
	{
		$delete_date=time()-300;			//Time  minus 5 minutes
		while (false !== ($filename = readdir($dh)))
		{
			if (strpos($filename,PDF)!==false)
			{
				$filename=$dir.$filename;
				if (filemtime($filename)<=$delete_date)
				{
					unlink($filename);
				}
			}
		}
		closedir($dh);
	}
	//Write Document to defined PDF_DOC_PATH
	WriteDocument($pdf,$docfilename);
	//start the download or the redirect
	$docfilename=PDF_DOC_PATH . $docfilename;
	if (PDF_FILE_REDIRECT)
	{
		header('Location: ' . $docfilename);
		exit();
	} else {
		StartDownload($docfilename);
	}
} else {
	if (PDF_FILE_REDIRECT)
	{
		$dest="D";
	}else{
		$dest="I";
	}
	$pdf->Output($docfilename,$dest);
}
$use_catalog_link=false;
$is_print_version=false;
exit;
?>
