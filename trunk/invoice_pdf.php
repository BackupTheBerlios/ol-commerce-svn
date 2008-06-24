<?php
/*
$Id: create_pdf,v 1.4 2005/04/07

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2003 osCommerce

Released under the GNU General Public License

Written by Neil Westlake (nwestlake@gmail.com) for www.Digiprintuk.com

Version History:
1.1
Initial release
1.2
Corrected problem displaying PDF when from a HTTPS URL.
1.3
Modified item display to allow page continuation when more than 20 products are on one invoice.
1.4
Corrected problem with page continuation, now invoices will allow for an unlimited amount of products on one invoice

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
*/

$print_invoice=!$print_packing_slip;
require(DIR_WS_LANGUAGES . SESSION_LANGUAGE .SLASH . FILENAME_ORDERS_INVOICE_PDF);

$delivery_country=$order->delivery['country'];
if (NO_TAX_RAISED)
{
	$price_single_header=PRINT_INVOICE_PRICE;
	$price_header=PRINT_INVOICE_SINGLE_PRICE;
	$tax_disclaimer=BOX_LOGINBOX_NO_TAX_TEXT;
}
elseif (CUSTOMER_SHOW_PRICE_TAX)
{
	$price_single_header=PRINT_INVOICE_SINGLE_PRICE;
	$price_header=PRINT_INVOICE_PRICE;
	$tax_disclaimer=PRICES_DISCLAIMER_INCL;
}
else
{
	$price_single_header=PRINT_INVOICE_SINGLE_PRICE;
	$price_header=PRINT_INVOICE_PRICE;

	$tax_disclaimer=PRICES_DISCLAIMER_EXCL;
	if (!$delivery_country)
	{
		$tax_disclaimer.=LPAREN.TAX_DISCLAIMER_EU.RPAREN;
	}
}

//***** Configuration *****
$items_per_page = 20;													//Products items per page

$address_top=48;
$address_left=24.1;

$invoice_start_top=110;
$invoice_start_left=$address_left;

$qty_text='qty';
$model_text='model';
$name_text='name';
$tax_text='tax';
$price_text='price';
$final_price_text='final_price';

//Build products elements table
$x_width=array();			//$x_width[] will be calculated based on the text's width
//but you can override it with a  bigger(!) value, if desired
$x_text=array();			//Column text
$x_content=array();		//Holds the name of the information content field
$holds_price=array();	//Column holds price
$check_size=array();	//Column must be size-checked

$x_text[]=PRINT_INVOICE_POSITION;							//Field 1 = Position
$x_width[]=9;
$x_content[]=EMPTY_STRING;
$check_size[]=false;

$x_text[]=PRINT_INVOICE_QUANTITY;							//Field 2 = Quantity
$x_width[]=9;
$x_content[]=$qty_text;
$check_size[]=false;

$x_text[]=PRINT_INVOICE_PRODUCTS_MODEL;				//Field 3 = Model
$x_width[]=27;
$x_content[]=$model_text;
$check_size[]=false;

$products_field_item=sizeof($x_width);
$x_text[]=PRINT_INVOICE_PRODUCTS;							//Field 4 = Description (will be allocated later!)
$x_width[]=0;
$x_content[]=$name_text;
$check_size[]=true;

if (NO_TAX_RAISED)
{
	$tax_field_width=0;
}
else
{
	$x_text[]=PRINT_INVOICE_TAX;								//Field 5 = Tax;
	$tax_field_width=15;
	$x_width[]=$tax_field_width;
	$x_content[]=$tax_text;
	$check_size[]=false;
}
if ($print_invoice)
{
	define('PRICE_SINGLE_HEADER',str_replace(HASH,SESSION_CURRENCY,$price_single_header));
	define('PRICE_HEADER',str_replace(HASH,SESSION_CURRENCY,$price_header));
	$use_line_break=strpos(PRICE_SINGLE_HEADER,NEW_LINE)!==false;
	if (!$use_line_break)
	{
		$use_line_break=strpos(PRICE_HEADER,NEW_LINE)!==false;
	}

	$x_text[]=PRICE_SINGLE_HEADER;							//Field 5/6 = Single price
	$x_width[]=20;
	$x_content[]=$price_text;
	$check_size[]=false;

	$x_text[]=PRICE_HEADER;											//Field 6/7 = Total price
	$x_width[]=20;
	$x_content[]=$final_price_text;
	$check_size[]=false;
}
$invoice_items=sizeof($x_text);
//Build products elements table
//***** Configuration *****

define('TAX_DISCLAIMER',$tax_disclaimer);
define('NOT_NO_TAX_RAISED',!NO_TAX_RAISED);

$x_pos=array();
$set_parameters=true;
$format_id_text='format_id';
$dot_blank_text=DOT.BLANK;
$products_tax_precision=0;			//No decimal places for tax
$is_print_version=true;
$ellipses='...';

require_once(DIR_FS_INC.'olc_format_price.inc.php');
require_once(DIR_FS_INC.'olc_date_short.inc.php');
$path='admin/includes/classes/fpdf/';
define('FPDF_FONTPATH',$path.'font/');
require($path.'fpdf.php');

define('LEFT','L');
define('RIGHT',RIGHT);
define('CENTER',CENTER);
define('BOLD','B');
define('ITALIC','I');
define('BOLD_ITALIC',BOLD.ITALIC);
define('UNDERLINE','U');
define('BOLD_UNDERLINE',BOLD.UNDERLINE);
define('NO_FORMAT',EMPTY_STRING);
define('TWO_BLANK',BLANK.BLANK);

if (class_exists('order'))
{
	$oID=$order->info['order_id'];
}
else
{
	include_once(DIR_WS_CLASSES . 'order.php');
	$oID=$_GET['oID'];
	$orders_query = olc_db_query("select orders_id from " . TABLE_ORDERS . " where orders_id = '" . $oID . APOS);
	$order = new order($oID);
}
/*
if (!class_exists('currencies'))
{
require_once(DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();
}
*/

class PDF extends FPDF
{
	var $doc_type;
	var $print_invoice=true;
	var $print_order=false;
	var $font='Arial';

	var $page;
	var $lines_height=4.23;
	var $language_parameter;
	var $impressum;
	var $impressum_lines;
	var $impressum_left;
	var $max_impressum_line_length;
	var $footer_1;
	var $footer_2;
	var $footer_1_top;
	var $footer_1_left;
	var $footer_2_top;
	var $footer_2_left;

	var $zero_cent=',--';
	var $zero_cent_replace=',  ';

	function Header()
	{
		global $oID,$order,$address_left,$address_top,$sender,$format_id_text,$invoice_start_left;
		global $Y_Fields_Name_position,$Y_Table_Position;

		if (!$this->page)
		{
			$this->impressum=array();
			//$image_width=$this->info['w']/$this->k;
			//$image_height=$this->info['h']/$this->k;
			$store=nl2br(STORE_NAME_ADDRESS);
			$store=explode(HTML_BR,$store);
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
		}
		$this->$page++;
		$this->SetFont($this->font,NO_FORMAT,8);
		$top=$this->lMargin;		//4
		$left=$this->wc[0];
		$link=olc_href_link('index.php',$this->language_parameter,NONSSL,false,true,false,true);
		$image=CURRENT_TEMPLATE_IMG.'invoice_logo.jpg';
		$top=$this->tMargin;
		$this->Image($image,$this->lMargin,$top,EMPTY_STRING,EMPTY_STRING,EMPTY_STRING,$link);
		for ($i=0;$i<$this->impressum_lines;$i++)
		{
			$this->Text($left,$top,$this->impressum[$i]);
			$top+=$this->lines_height;
		}
		if ($this->page==1)
		{
			//Sender info
			$this->SetFont($this->font,BOLD_UNDERLINE,8);
			$this->SetX($address_left);
			$this->SetY($address_top);
			$this->MultiCell(85, $this->lines_height, $sender,0,LEFT);
			if ($this->print_invoice)
			{
				//Billing address
				$format_id=$order->billing[$format_id_text];
				$address=$order->billing;
			}
			else
			{
				//Billing address
				$format_id=$order->delivery[$format_id_text];
				$address=$order->delivery;
			}
			$this->SetFont($this->font,NO_FORMAT,10);
			$this->SetX($address_left);
			$this->SetY($address_top);
			$this->MultiCell(85, 45, olc_address_format($format_id,$address, EMPTY_STRING,	EMPTY_STRING, NEW_LINE),0,LEFT);
		}
		//Draw invoice type text text
		$this->SetFont($this->font,BOLD_UNDERLINE,16);
		$this->SetX($address_left);
		$this->SetY($invoice_start_left);
		$this->MultiCell(85, $this->lines_height, $this->doc_type,0,LEFT);

		$this->SetFont($this->font,NO_FORMAT,10);
		if ($this->page>1)
		{
			$page_text=str_replace(HASH,$this->PageNo(),PRINT_INVOICE_PAGE);
			$this->Text($left,$address_left,$this->GetY()+$this->lines_height);
		}
		//Draw Order Number, Customer Number Date & Payment method
		$info=array();
		$info[]=PRINT_INVOICE_ORDERNR.olc_db_input($oID);
		$info[]=PRINT_INVOICE_CUSTOMERNR. $order->customers['customers_cid'];
		$info[]=PRINT_INVOICE_DATE.olc_date_short($order->info['date_purchased']);
		$info[]=PRINT_INVOICE_PAYMENT_METHOD.$order->info['payment_method'];
		for ($i=0;$i<sizeof($info);$i++)
		{
			$max_info_len=max($max_info_len,$this->GetStringWidth($info[$i]));
		}
		$left=$this->w-$this->lMargin-$max_info_len;
		$top=$invoice_start_top;
		for ($i=0;$i<sizeof($info);$i++)
		{
			$this->Text($left,$top,$info[$i]);
			$top+=$this->lines_height;
		}
		//Invoice fields Name position
		$Y_Fields_Name_position = $top;
		//Table position, under Fields Name
		$Y_Table_Position = $Y_Fields_Name_position+$this->lines_height;
		output_invoice_header($Y_Fields_Name_position);
	}

	function Footer()
	{
		$this->SetFont($this->font,NO_FORMAT,8);
		if (!$this->footer)
		{
			//Footer
			global $order;
			if ($delivery_country==STORE_COUNTRY)
			{
				$bank_account=PRINT_INVOICE_BLZ.STORE_BLZ.COMMA_BLANK.PRINT_INVOICE_ACCOUNT.STORE_ACCOUNT;
			}
			else
			{
				$bank_account=PRINT_INVOICE_BIC.STORE_BIC.COMMA_BLANK.PRINT_INVOICE_IBAN.STORE_IBAN;
			}
			$footer=PRINT_INVOICE_BANK.STORE_BANK.COMMA_BLANK.$bank_account.DOT;
			if (STORE_USTID || STORE_TAXNR)
			{
				if (STORE_USTID)
				{
					$tax_id=PRINT_INVOICE_USTID.STORE_USTID;
				}
				else
				{
					$tax_id=PRINT_INVOICE_TAXNR.STORE_TAXNR;
				}
			}
			$this->footer_2=$footer.BLANK.$tax_id;
			$footer_top=$this->h-$this->tMargin;
			if (STORE_REGISTER)
			{
				$register=PRINT_INVOICE_REGISTER.STORE_REGISTER;
				if (STORE_REGISTER_NR)
				{
					$register.=STORE_REGISTER_NR;
				}
				if (STORE_MANAGER)
				{
					$register.=' -- '.PRINT_INVOICE_MANAGER.STORE_MANAGER;
				}
				$this->footer_1=$register;
				$this->footer_1_top=$footer_top;
				$footer_top-=$this->FontSize;
				$this->footer_1_left=ceil($this->w-$this->GetStringWidth($this->$register))/2;
			}
			$this->footer_2_top=$footer_top;
			$this->footer_2_left=ceil($this->w-$this->GetStringWidth($this->footer_1))/2;
		}
		//Footer notes
		$this->Text($this->footer_2_left,$this->footer_2_top,$this->footer_2);
		if ($this->footer_1)
		{
			$this->Text($this->footer_1_left,$this->footer_1_top,$this->footer_1);
		}
		/*
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
		*/
		/*
		//Position at 1.5 cm from bottom
		$this->SetY(-17);
		//Arial italic 8
		$this->SetFont($this->font,NO_FORMAT,10);
		$this->SetTextColor('Black');
		$this->Cell(0,10, PRINT_INVOICE_THANX_TEXT, 0,0,CENTER);
		//$this->SetY(-15);
		//$this->Cell(0,10, PRINT_INVOICE_URL, 0,0,CENTER);
		//Page number
		//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,CENTER);
		*/
	}

	function store_impressum_string($s)
	{
		$this->impressum[]=$s;
		$this->max_impressum_line_length=max($this->max_impressum_line_length,$this->GetStringWidth($s));
	}

	function print_line_with_price($left,$top,$text)
	{
		$pos=strpos($text,$this->zero_cent);
		if ($pos!==false)
		{
			$zero_cent_replace_len=strlen($this->zero_cent_replace);
			$text=str_replace($this->zero_cent,$this->zero_cent_replace,$text);
			$this->Text($left,$top,$text);		//Price
			$font_size=$this->FontSize;
			$dash_height=$font_size*.1;
			if (strpos($this->FontStyle,BOLD)!==false)		//Bold font?
			{
				$dash_height.=$dash_height;
			}
			$dash_len=$this->GetStringWidth(substr($this->zero_cent_replace,1));
			$dash_top=$top-($font_size/2-$dash_height*2);
			$this->SetLineWidth($dash_height*.75);
			$body_color_text=explode(COMMA,PDF_BODY_COLOR_TEXT);
			$this->SetDrawColor($body_color_text[0], $body_color_text[1], $body_color_text[2]);
			while (true)
			{
				$pos=strpos($text,$this->zero_cent_replace,$pos);
				if ($pos!==false)
				{
					$text_left=substr($text,0,$pos+1);
					$dash_left=$left+$this->GetStringWidth($text_left);
					$this->Line($dash_left,$dash_top,$dash_left+$dash_len,$dash_top);
					$pos+=$zero_cent_replace_len;
				}
				else
				{
					break;
				}
			}
		}
		else
		{
			$this->Text($left,$top,$text);		//Price
		}
	}
}

function Make_Header_Cell(&$x,$w,$txt='',$is_price=false)
{
	global $pdf,$Y_Table_Position,$x_pos,$x_width,$use_line_break,$set_parameters,$holds_price;
	if ($set_parameters)
	{
		$x_pos[]=$x;
		$holds_price[]=$is_price;
	}
	$pdf->SetX($x);
	$pdf->SetY($Y_Table_Position);
	$x+=$w;
	$h=$pdf->lines_height;
	if ($use_line_break)
	{
		$h+=$pdf->lines_height;
	}
	$pdf->Cell($w,$h,$txt,1,0,CENTER,1);
}

function Make_Cell($txt='',$align,$is_price=false,$check_width=false)
{
	global $pdf,$field,$Y_Table_Position,$x_pos,$x_width;

	$w=$x_width[$field];
	if ($check_width)
	{
		if ($pdf->GetStringWidth($txt) > $w)
		{
			for ($len=strlen($txt)-4;$len>0;$len--)
			{
				$products_name=BLANK.substr($products_name,0,$len).$ellipses.BLANK;
				if ($pdf->GetStringWidth($txt) <= $w)
				{
					break;
				}
			}
		}
	}
	$pdf->SetX($x_pos[$field]);
	$pdf->SetY($Y_Table_Position);
	$txt=BLANK.$txt.BLANK;
	$pdf->MultiCell($w,$pdf->lines_height ,$txt,1,0,$align,1);
	$Y_Table_Position+= $pdf->lines_height;
	$field++;
}

function new_page()
{
	global $pdf,$item_count;

	$pdf->Footer();
	$pdf->Header();
	$item_count = 1;
}

function output_invoice_header($Y_Fields_Name_position)
{
	global $pdf,$x_pos,$x_width,$x_text,$Y_Fields_Name_position;

	//Create each Field Name
	//Color filling each Field Name box
	$pdf->SetFillColor(PDF_INVOICE_MARK_COLOR_BG);
	$pdf->SetTextColor(PDF_INVOICE_MARK_COLOR);
	//Bold Font for Field Name
	$pdf->SetFont($pdf->font,BOLD,10);
	$pdf->SetY($Y_Fields_Name_position);
	$x=$pdf->lMargin;
	$field=0;
	for ($i=0;$i<sizeof($x_width);$i++)
	{
		Make_Header_Cell($x,$x_width[$field],$x_text[$field]);
		$field++;
	}
	$pdf->Ln();
	$pdf->SetTextColor('Black');
}

//Instanciation of inherited class
$pdf=new PDF();
// Set the Page Margins
$pdf->SetMargins(15,10,10);					//Ränder links ,rechts, oben
//Calc size of each field based on its title, then total width ex. products description field,
//and asssign max. possible value to products description field
$pdf->font='Arial';
$pdf->SetFont($pdf->font,BOLD,10);
$total=0;
for ($i=0;$i<sizeof($x_text);$i++)
{
	$text=$x_text[$i];
	$text_parts=split(NEW_LINE,$text);
	$text_parts_count=sizeof($text_parts);
	if ($text_parts_count>1)
	{
		$text_len=0;
		for ($j=0;$j<$text_parts_count;$j++)
		{
			$text_1=$text_parts[$j];
			if ($pdf->GetStringWidth($text_1)>$text_len)
			{
				$text=$text_1;
			}
		}
	}
	$text=BLANK.$text.BLANK;
	$w=ceil($pdf->GetStringWidth($text));
	if ($w>$x_width[$i])
	{
		$x_width[$i]=$w;
	}
	if ($i<>$products_field_item)
	{
		$total+=$x_width[$i];
	}
}
$products_field_width=$pdf->w-$pdf->lMargin-$pdf->rMargin-$total-$tax_field_width;
$x_width[$products_field_item]=$products_field_width;
if ($print_invoice)
{
	$print_packing_slip=$order->billing['country']<>$order->delivery['country'];
}
else
{
	$print_packing_slip=false;
}
if ($is_admin_function)
{
	if ($print_invoice)
	{
		$doc_type=PRINT_INVOICE_INVOICE_HEADING;
		if ($print_packing_slip)
		{
			$doc_type=PRINT_INVOICE_PACKINGSLIP_HEADING.SLASH.NEW_LINE.$pdf->doc_type;
		}
	}
	else
	{
		$doc_type=PRINT_INVOICE_PACKINGSLIP_HEADING;
	}
}
else
{
	$doc_type=PRINT_ORDER_HEADING;
	$pdf->print_order=true;
}
$pdf->print_invoice=$print_invoice;
$pdf->doc_type=$doc_type;
//	$pdf->AddFont('Verdana','verdana.php');
//	$pdf->AddFont('Verdana', BOLD, 'verdanab.php');
//	$pdf->AddFont('Verdana', ITALIC, 'verdanai.php');
$pdf->language_parameter='&language='.$_SESSION['language_code'];
$pdf->Open();
$pdf->SetDisplayMode("real");
$pdf->AliasNbPages();
$new_line="\r\n";
$pos=strpos(STORE_NAME_ADDRESS,$new_line);
if ($pos===false)
{
	$new_line=NEW_LINE;
	if (strpos(STORE_NAME_ADDRESS,$new_line)===false)
	{
		$sender=str_replace(NEW_LINE,COMMA_BLANK,STORE_NAME_ADDRESS);
	}
}
else
{
	$sender=str_replace("\r\n",COMMA_BLANK,STORE_NAME_ADDRESS);
}
if (strpos($sender,COMMA_BLANK)!==false)
{
	$sender_parts=split(COMMA_BLANK,$sender);
	$sender_parts_count=sizeof($sender_parts)-1;
	$fon=$sender_parts[$sender_parts_count];		//Assume last address entry is fon!
	if ($fon)
	{
		$fon=str_replace(array(SLASH,BLANK,'-'),EMPTY_STRING,$fon);		//Remove illegal chars
		if (is_numeric($fon))
		//Remove fon-number from sender address
		{
			$sender=EMPTY_STRING;
			for ($i=0;$i<$sender_parts_count;$i++)
			{
				if ($sender)
				{
					$sender.=COMMA_BLANK;
				}
				$sender.=$sender_parts[$i];
			}
		}
	}
}
$set_parameters=true;
while (true)
{
	// Add the first page
	$pdf->SetTextColor('Black');
	$pdf->AddPage();
	$set_parameters=false;
	//Show the products information line by line
	$total_price=array();
	for ($i = 0, $n = sizeof($order->products)-1; $i <= $n; $i++)
	{
		$current_product=$order->products[$i];

		$qty=$current_product[$qty_text];
		$model=$current_product[$model_text];
		$name=BLANK.$current_product[$name_text].BLANK;
		$name_len=strlen($name);
		$tax=$current_product[$tax_text];
		$price=$current_product[$price_text];
		$final_price=$current_product[$final_price_text];

		$total_price[$tax].=$final_price;
		if (NOT_NO_TAX_RAISED)
		{
			if (CUSTOMER_SHOW_PRICE_TAX)
			{
				$price=olc_add_tax($price, $tax);
				$final_price=olc_add_tax($final_price, $tax);
			}
			$tax=olc_precision($tax,$tax_precision);
			$tax=number_format($tax,$tax_precision,CURRENCY_DECIMAL_POINT,CURRENCY_THOUSANDS_POINT);
		}

		$pdf->SetFont($pdf->font,NO_FORMAT,10);
		$pdf->SetY($Y_Table_Position);
		$current_product_attributes=$current_product['attributes'];
		$attributes=sizeof($current_product_attributes);
		if ($attributes)
		{
			if ((($item_count+$attributes) %  $items_per_page)==0)
			{
				new_page();
			}
		}
		$field=0;
		Make_Cell(($i+1).DOT,RIGHT,false);
		if (true)
		{
			Make_Cell($qty,RIGHT,false);
			Make_Cell($model,RIGHT,false);
			Make_Cell($name,LEFT,false,true);
			if ($attributes)
			{
				$pdf->SetFont($pdf->font,ITALIC,10);
				for ($a=0,$m=$attributes-1; $a <= $m;$a++)
				{
					$current_attribute=$current_product_attributes[$a];
					Make_Cell(TWO_BLANK.$current_attribute['option'].': '.$current_attribute['value'],LEFT,true);
				}
				$pdf->SetFont($pdf->font,NO_FORMAT,10);
			}
			if (NOT_NO_TAX_RAISED)
			{
				Make_Cell($tax,RIGHT);
			}
			Make_Cell(olc_format_price ($price,1,1,0),RIGHT,true);
			Make_Cell(olc_format_price($final_price,1,1,0),RIGHT,true);
		}
		else
		{
			for ($item=1;$item<$invoice_items;$item++)
			{
				Make_Cell($$x_content[$field],LEFT,$holds_price[$field],$check_size[$field]);
				if ($item==$field_item)
				{
					if ($attributes)
					{
						$pdf->SetFont($pdf->font,ITALIC,10);
						for ($a=0,$n=$attributes-1; $a <= $n;$a++)
						{
							$Y_Table_Position+= $pdf->lines_height;
							$current_attribute=$current_product_attributes[$a];
							Make_Cell(TWO_BLANK.$current_attribute['option'].': '.$current_attribute['value'],LEFT,false,true);
						}
						$pdf->SetFont($pdf->font,NO_FORMAT,10);
					}
				}
			}
		}
		$item_count++;
		//Check for products overflow (i.e.: more then one page required
		if (($item_count % $items_per_page) == 0)
		{
			if ($i<>$n)
			{
				//Overflow if more products to come!
				new_page();
			}
		}
	}
	for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++)
	{
		$pdf->SetY($Y_Table_Position + $pdf->lines_height);
		$pdf->SetX(102);
		$order_totals_text = $order->totals[$i]['text'];
		$temp = substr ($order_totals_text,0 ,3);
		//if ($i == 3) $pdf->Text(10,10,$temp);
		if ($temp == HTML_B_START)
		{
			$pdf->SetFont($pdf->font,BOLD,10);
			$temp2 = substr($order_totals_text, 3);
			$order_totals_text = substr($temp2, 0, strlen($temp2)-4);
		}
		$pdf->MultiCell(94,$order->totals[$i]['title'] . BLANK . $order_totals_text,0,RIGHT);
		$Y_Table_Position += $pdf->lines_height;
	}
	// Draw the shipping address for label
	//Draw the invoice delivery address text
	/*
	$pdf->SetFont($pdf->font,BOLD,11);
	$pdf->SetTextColor('Black');
	//$pdf->Text(117,61,PRINT_INVOICE_SHIP_TO);
	//$pdf->SetX(0);
	$pdf->SetY(240);
	$pdf->Cell($table_width_20);
	$pdf->MultiCell(50, 4, strtoupper(olc_address_format($order->delivery[$format_id_text], $order->delivery,9,
	EMPTY_STRING, EMPTY_STRING, NEW_LINE)),0,LEFT);
	*/
	// PDF's created now output the file
	//PDF file name
	$pdf_invoice=str_replace(SLASH,UNDERSCORE,strtolower($pdf->doc_type)).UNDERSCORE.$order->info['order_id'].'.pdf';
	if ($is_admin_function)
	{
		$dest="I";				//Send to Browser
		if ($print_packing_slip)
		{
			$pdf->doc_type=PRINT_PACKINGSLIP_HEADING;
			$pdf->print_invoice=false;
			include('admin'.SLAH.FILENAME_ORDERS_PACKINGSLIP_PDF);
		}
		else
		{
			break;
		}
	}
	else
	{
		$pdf_invoice=DIR_FS_CATALOG."cache/cache".SLASH.$pdf_invoice;  //File path
		break;
	}
}
$pdf->Output($pdf_invoice,$dest);
$is_print_version=false;
?>