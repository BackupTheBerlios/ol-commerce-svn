<?php
/*
$Id: pdf_invoice,v 1.4 2005/04/07

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

function define_field($col_title,$min_width,$content_var_name,$align=RIGHT,$is_price_field=false,$check_field_size=false)
{
	global $x_text,$x_width,$x_content,$x_align,$holds_price,$check_size,$invoice_items;

	$x_text[$invoice_items]=$col_title;
	$x_width[$invoice_items]=$min_width;
	$x_content[$invoice_items]=$content_var_name;
	$x_align[$invoice_items]=$align;
	$holds_price[$invoice_items]=$is_price_field;
	$check_size[$invoice_items]=$check_field_size;
	$invoice_items++;
}

define('LEFT','L');
define('RIGHT','R');
define('CENTER','C');
define('BOLD','B');
define('ITALIC','I');
define('BOLD_ITALIC',BOLD.ITALIC);
define('UNDERLINE','U');
define('BOLD_UNDERLINE',BOLD.UNDERLINE);
define('NORMAL',EMPTY_STRING);
define('TWO_BLANK',BLANK.BLANK);
define('COLON_BLANK',':'.BLANK);
define('TILDE','~');
define('ELLIPSES','...');
define('PDF','.pdf');

define('PDF_INVOICE_MARK_COLOR_BG_STANDARD','White');
define('PDF_INVOICE_MARK_COLOR_STANDARD','Black');

if ($IsAdminFunction)
{
	$pdf_download=true;
}
else
{
	$print_order=isset($_GET['print_order']);
	$print_packingslip=isset($_GET['print_packingslip']);

	$pdf_download=CURRENT_SCRIPT<>FILENAME_CHECKOUT_PROCESS;
	//If checkout_process, Pdf needs to be stored in a file!
}
$print_invoice=!($print_packing_slip || $print_order);
$lang_dir=ADMIN_PATH_PREFIX .'lang'.SLASH.SESSION_LANGUAGE.SLASH;
require($lang_dir.FILENAME_ORDERS_INVOICE_PDF);

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
$store_country=olc_get_country_name(STORE_COUNTRY);
$billing_country=$order->billing['country'];

$not_print_packing_slip=!$print_packing_slip;

define('NOT_NO_TAX_RAISED',!NO_TAX_RAISED);
define('ADD_TAX',CUSTOMER_SHOW_PRICE_TAX && NOT_NO_TAX_RAISED);
define('IS_NATIONAL_ORDER',$billing_country==$store_country);
$customers_order_reference=$order->info['customers_order_reference'];
$customers_order_reference=str_replace(APOS,EMPTY_STRING,$customers_order_reference);
$have_customers_order_reference=$customers_order_reference<>EMPTY_STRING;

//Build products elements table
$x_width=array();															//$x_width[] will be calculated based on the text's width
//but you can override it with a  bigger(!) value, if desired
$x_text=array();															//Column text
$x_content=array();														//Holds the name of the information content field
$x_align=array();															//Alignment indicator for field
$holds_price=array();													//Column holds price
$do_check_size=array();												//Column must be size-checked

// ***** Available data fields *****
$position_data_name='position';
$qty_data_name='qty';
$discount_data_name='discount';
$model_data_name='model';
$name_data_name='name';
$tax_data_name='tax';
$price_data_name='price';
$final_price_data_name='final_price';
// ***** Available data fields *****

//Check if any products discounts included
$have_products_discount=false;
for ($i = 0, $n = sizeof($order->products)-1; $i <= $n; $i++)
{
	$current_product=$order->products[$i];
	if ($current_product[$tax_data_name])
	{
		$have_products_tax=true;
	}
	if ($current_product[$discount_data_name])
	{
		$have_products_discount=true;
	}
}
//Build products elements table
require_once(DIR_FS_INC.'olc_date_short.inc.php');

$document_order=0;
$document_invoice=1;
$document_packingslip=2;

$customer_name=$order->customer['name'];
$print_billing_address=$customer_name<>$order->billing['name'];
$print_delivery_address=$customer_name<>$order->delivery['name'];
if ($print_packing_slip)
{
	$document_number_data_field='delivery_packingslip_number';
	$document_number_date_field='delivery_packingslip_date';
	$document_data=$order->delivery;
	$key='STORE_PACKINGSLIP_NUMBER';
	$text=PRINT_INVOICE_PACKINGSLIP_NR;
	$date_text=PRINT_INVOICE_PACKINGSLIP_DATE;

	$document=$document_packingslip;
	$doc_type=PRINT_INVOICE_PACKINGSLIP_HEADING;
}
else
{
	$payment_method=$order->info['payment_method'];
	require($lang_dir.'modules/payment'.SLASH.$payment_method.PHP);

	$price_single_header=PRINT_INVOICE_SINGLE_PRICE;
	$price_header=PRINT_INVOICE_PRICE;
	if (NO_TAX_RAISED)
	{
		$tax_disclaimer=BOX_LOGINBOX_NO_TAX_TEXT;
	}
	elseif (CUSTOMER_SHOW_PRICE_TAX)
	{
		$tax_disclaimer=PRICES_DISCLAIMER_INCL;
	}
	else
	{
		$tax_disclaimer=PRICES_DISCLAIMER_EXCL;
		if (!IS_NATIONAL_ORDER)
		{
			$tax_disclaimer.=LPAREN.TAX_DISCLAIMER_EU.RPAREN;
		}
	}
	$tax_disclaimer=strip_tags($tax_disclaimer);
	$orders_discount=$order->info['orders_discount'];
	$have_orders_discount=(float)$orders_discount<>0;

	define('TAX_DISCLAIMER',$tax_disclaimer);

	define('PRICE_SINGLE_HEADER',str_replace(HASH,SESSION_CURRENCY,$price_single_header));
	define('PRICE_HEADER',str_replace(HASH,SESSION_CURRENCY,$price_header));
	$use_line_break=strpos(PRICE_SINGLE_HEADER,TILDE)!==false;
	if (!$use_line_break)
	{
		$use_line_break=strpos(PRICE_HEADER,NEW_LINE)!==false;
	}
	if ($print_invoice)
	{
		$document_number_data_field='billing_invoice_number';
		$document_number_date_field='billing_invoice_date';
		$document_data=$order->billing;
		$key='STORE_INVOICE_NUMBER';
		$text=PRINT_INVOICE_INVOICE_NR;
		$date_text=PRINT_INVOICE_INVOICE_DATE;

		$document=$document_invoice;
		$doc_type=PRINT_INVOICE_INVOICE_HEADING;
	}
	else //if ($print_order)
	{
		$invoice_items_per_page+=2;
		$document_number_data_field='order_id';
		$document_number_date_field='date_purchased';
		$document_data=$order->info;
		$key=EMPTY_STRING;
		$text=PRINT_INVOICE_ORDER_NR;
		$date_text=PRINT_INVOICE_ORDER_DATE;

		$document=$document_order;
		$doc_type=PRINT_INVOICE_ORDER_HEADING;

		$date_format=BLANK.'H:i:s';
	}
}
$document_number=$document_data[$document_number_data_field];
if ($document_number)
{
	$document_date=date('d.m.Y'.$date_format, strtotime($document_data[$document_number_date_field]));
}
else
{
	if ($IsAdminFunction)
	{
		if ($key)
		{
			$document_number=constant($key)+1;
			olc_db_query("
			update ".TABLE_CONFIGURATION." set configuration_value='".$document_number."'
			where configuration_key='".$key.APOS);

			$s="
			update ".TABLE_ORDERS."
			set ".$document_number_data_field."='".$document_number."', ".
			$document_number_date_field."='".time()."'
		  where orders_id='" . $oID.APOS;
			olc_db_query($s);
		}
	}
	else
	{
		$doc_type=str_replace(HASH,$doc_type,PRINT_INVOICE_NO_DOCUMENT);
		if (IS_AJAX_PROCESSING)
		{
			include_once(DIR_FS_INC.'ajax_error.inc.php');
			ajax_error($doc_type);
		}
		else
		{
			$messageStack->add_session('pdf_invoice',$doc_type, 'error');
			olc_redirect(olc_href_link(CURRENT_SCRIPT,olc_get_all_get_params()));
		}
	}
}

$invoice_items=0;
//Include configuration
include('pdf_invoice_config.php');
$invoice_items--;

$info=array();
define('DATE',date('d.m.Y'));
$info[]=$text.$document_number;
$info[]=$date_text.$document_date;
$info_lines=2;
if (!$print_order)
{
	$info[]=PRINT_INVOICE_ORDER_NR.$order->info['order_id'];
	$info[]=PRINT_INVOICE_ORDER_DATE.date('d.m.Y', $order->info[date_purchased]);
	$info_lines+=2;
}
$info[]=PRINT_INVOICE_CUSTOMER_NR.$order->customer['csID'];
$info_lines+=1;
if ($not_print_packing_slip)
{
	$info[]=PRINT_INVOICE_PAYMENT_METHOD.constant('MODULE_PAYMENT_'.strtoupper($payment_method).'_TEXT_TITLE');
	$info_lines+=1;
}
if ($have_customers_order_reference)
{
	$info[]=PRINT_INVOICE_CUST_REF.$customers_order_reference;
	$info_lines+=1;
}

$format_id_text='format_id';
$dot_blank_text=DOT.BLANK;
$is_print_version=true;

require_once(DIR_FS_INC.'olc_format_price.inc.php');

$path='admin/includes/classes/fpdf/';
define('FPDF_FONTPATH',$path.'font/');
require($path.'fpdf.php');

class PDF extends FPDF
{
	var $print_order=false;
	var $font='Arial';
	var $invoice_font_size=10;

	var $document;
	var $document_order=0;
	var $document_invoice=1;
	var $document_packingslip=2;
	var $doc_type;

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
		global $oID,$order,$address_left,$address_top,$sender,$format_id_text,$have_customers_order_reference;
		global $Y_Fields_Name_position,$Y_Table_Position,$invoice_start_top,$info,$invoice_items_per_page;
		global $print_billing_address,$print_delivery_address,$invoice_items_per_page0,$invoice_items_per_page_next;
		global $use_line_break;

		$this->SetFont($this->font,NORMAL,8);
		if (!$this->impressum)
		{
			$this->impressum=array();
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
							$s=TEXT_FON.DOT.COLON_BLANK.$s;
						}
					}
				}
				$this->store_impressum_string($s);
			}
			$this->store_impressum_string('eMail'.COLON_BLANK.STORE_OWNER_EMAIL_ADDRESS);
			$s=HTTP_SERVER;
			if (strpos($s,'localhost')>0)
			{
				$store=explode('@',STORE_OWNER_EMAIL_ADDRESS);
				$s="http://www.".$store[1];
			}
			$this->store_impressum_string('Web'.COLON_BLANK.$s);

			$this->impressum_lines=sizeof($this->impressum);
			$this->impressum_left=ceil($this->w-$this->rMargin-$this->max_impressum_line_length);
		}
		$this->$page++;
		$is_firstpage=$this->page==1;
		$top=$this->lMargin;		//4
		$left=$this->impressum_left;
		$link=olc_href_link('index.php',$this->language_parameter,NONSSL,false,true,false,true);
		$image=CURRENT_TEMPLATE_IMG.'invoice_logo.jpg';
		if (file_exists($image))
		{
			$top=$this->tMargin;
			$this->Image($image,$this->lMargin,$top,EMPTY_STRING,EMPTY_STRING,EMPTY_STRING,$link);
		}
		for ($i=0;$i<$this->impressum_lines;$i++)
		{
			$this->Text($left,$top,$this->impressum[$i]);
			$top+=$this->lines_height;
		}
		$w=($this->w-$this->lMargin-$this->lMargin)/2;
		if ($is_firstpage)
		{
			//Sender info
			$this->SetFont($this->font,BOLD_UNDERLINE,6);
			$this->SetY($address_top);
			$this->SetX($address_left);
			$this->Cell($w, 0, $sender,0,LEFT);
			switch($this->document)
			{
				case $this->document_order:
					//Customer address
					$address=$order->customer;
					break;

				case $this->document_invoice:
					//Delivery address
					$address=$order->billing;
					break;

				case $this->document_packingslip:
					//Delivery address
					$address=$order->delivery;
					break;
			}
			$this->SetFont($this->font,NORMAL,10);
			$this->SetY($address_top+$this->lines_height);
			$this->SetX($address_left);
			$this->MultiCell($w,$this->lines_height, olc_address_format($address[$format_id_text],$address, EMPTY_STRING,
			EMPTY_STRING,TILDE),0,LEFT);
		}
		//Draw invoice type text text
		$this->SetFont($this->font,BOLD,16);
		$this->SetY($invoice_start_top-3);
		$x=$this->lMargin;
		$this->SetX($x-$this->cMargin);
		$this->MultiCell($w,$this->lines_height, $this->doc_type,0,LEFT);
		$this->SetFont($this->font,NORMAL,10);
		//Draw Order Number, Customer Number Date & Payment method
		$top=$invoice_start_top-$this->lines_height*4;
		$info_items=sizeof($info)-1;
		if ($have_customers_order_reference)
		{
			$cori=$info_items;
		}
		else
		{
			$cori=-1;
		}
		for ($i=0;$i<=$info_items;$i++)
		{
			$set_bold=$i==0 || $i==$cori;
			if ($set_bold)
			{
				$this->SetFont($this->font,BOLD,10);
			}
			$max_info_len=max($max_info_len,$this->GetStringWidth($info[$i]));
			if ($set_bold)
			{
				$this->SetFont($this->font,NORMAL,10);
			}
		}
		$top=$invoice_start_top-$this->lines_height*4;
		$left=$this->w-$this->rMargin-$this->GetStringWidth(DATE);
		$this->Text($left,$top,DATE);
		$left=$this->w-$this->rMargin-$max_info_len;
		$top=$invoice_start_top;
		for ($i=0;$i<=$info_items;$i++)
		{
			$set_bold=$i==0 || $i==$cori;
			if ($set_bold)
			{
				$this->SetFont($this->font,BOLD,10);
			}
			$this->Text($left,$top,$info[$i]);
			$top+=$this->lines_height;
			if ($set_bold)
			{
				$this->SetFont($this->font,NORMAL,10);
			}
		}
		//Invoice fields Name position
		$Y_Fields_Name_position = $top;	//	+$this->lines_height;	//$invoice_start_top;
		if ($is_firstpage)
		{
			$standard_address_lines=7;
			if ($print_billing_address || $print_delivery_address)
			{
				$print_it=array();
				$print_header=array();
				$print_address=array();
				switch($this->document)
				{
					case $this->document_order:
						if ($print_billing_address)
						{
							$print_it[0]=true;;
							$print_header[0]=PRINT_INVOICE_BILL_TO;
							$print_address[0]=$order->billing;
						}
						if ($print_delivery_address)
						{
							$print_it[1]=true;
							$print_header[1]=PRINT_INVOICE_SHIP_TO;
							$print_address[1]=$order->delivery;
						}
						break;

					case $this->document_invoice:
						if ($print_billing_address)
						{
							$print_it[0]=true;;
							$print_header[0]=PRINT_INVOICE_SHIP_TO;
							$print_address[0]=$order->delivery;
						}
						if ($print_delivery_address)
						{
							$print_it[1]=true;
							$print_header[1]=PRINT_INVOICE_SOLD_TO;
							$print_address[1]=$order->customer;
						}
						break;

					case $this->document_packingslip:
						if ($print_billing_address)
						{
							$print_it[0]=true;;
							$print_header[0]=PRINT_INVOICE_BILL_TO;
							$print_address[0]=$order->billing;
						}
						if ($print_delivery_address)
						{
							$print_it[1]=true;
							$print_header[1]=PRINT_INVOICE_SOLD_TO;
							$print_address[1]=$order->customer;
						}
						break;
				}
				$x=$this->lMargin;
				$Y_Fields_Name_position+=$this->lines_height;
				for ($i=0;$i<2;$i++)
				{
					$y=$Y_Fields_Name_position;
					if ($print_it[$i])
					{
						$address=
						olc_address_format($print_address[$i][$format_id_text],$print_address[$i], EMPTY_STRING,EMPTY_STRING, TILDE);
						$current_print_header=$print_header[$i];
						$address_line=explode(TILDE,$address);
						$lines=sizeof($address_line)-1;
						$max_address_lines=max($max_address_lines,$lines);
						if ($i)
						{
							if ($printed)
							{
								if ($right_justify_3rd_address)
								{
									$this->SetFont($this->font,NORMAL,10);
									$address_line=explode(TILDE,$address);
									$lines=sizeof($address_line)-1;
									$max_address_lines=max($max_address_lines,$lines);
									for ($j=0;$j<=$lines;$j++)
									{
										$s=$address_line[$j];
										$l_w=max($l_w,$this->GetStringWidth($s));
									}
								}
								$this->SetFont($this->font,BOLD,10);
								$l_w=max($l_w,$this->GetStringWidth($current_print_header));
								$x=$this->w-$this->rMargin-$l_w;
							}
							$this->SetY($y);
							$this->SetX($x);
							$this->SetFont($this->font,BOLD,10);
							$this->Cell($w,0,$current_print_header);
							$this->SetFont($this->font,NORMAL,10);
							$y+=$this->lines_height/2;
							$this->SetY($y);
							$this->SetX($x);
							$this->MultiCell($w,$this->lines_height,$address,0,LEFT);
							$max_y=max($max_y,$this->GetY());
							$x+=$w;
							$printed=true;
						}
					}
				}
				$print_billing_address=false;
				$print_delivery_address=false;
				$Y_Fields_Name_position=$max_y+$this->lines_height*2;
			}
			else
			{
				$max_address_lines=0;
			}
			$invoice_items_per_page+=$standard_address_lines-$max_address_lines;
			//Next page can hold more items, as the delivery/billing/order-addresses will not be repeated!
			$invoice_items_per_page_next=$invoice_items_per_page0+$standard_address_lines;
			$invoice_items_per_page0=$invoice_items_per_page;
		}
		else
		{
			$Y_Fields_Name_position+=$this->lines_height;
		}
		$Y_Table_Position = $Y_Fields_Name_position+$this->lines_height;
		output_invoice_header();
		if ($use_line_break)
		{
			$Y_Table_Position+=$this->lines_height;
		}
		//Table position, under Fields Name
	}

	function Footer()
	{
		$this->SetFont($this->font,NORMAL,8);
		if (!$this->footer)
		{
			//Footer
			global $order;

			$sep=TWO_BLANK.chr(149).TWO_BLANK;
			if (IS_NATIONAL_ORDER)
			{
				if (PRINT_INVOICE_BANK_BLZ)
				{
					$bank_account=PRINT_INVOICE_BANK_BLZ.STORE_BANK_BLZ.COMMA_BLANK.PRINT_INVOICE_BANK_ACCOUNT.STORE_BANK_ACCOUNT;
				}
			}
			else
			{
				if (PRINT_INVOICE_BANK_BIC)
				{
					$bank_account=PRINT_INVOICE_BANK_BIC.STORE_BANK_BIC.COMMA_BLANK.PRINT_INVOICE_BANK_IBAN.STORE_BANK_IBAN;
				}
			}
			if ($bank_account)
			{
				$footer=PRINT_INVOICE_BANK.STORE_BANK_NAME.COMMA_BLANK.$bank_account;
			}
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
				$footer.=$sep.$tax_id;
			}
			$footer_top=$this->h-$this->tMargin;	//+$this->lines_height;
			if ($footer)
			{
				$this->footer_1=$footer;
				$this->footer_1_top=$footer_top;
				$this->footer_1_left=ceil($this->w-$this->GetStringWidth($this->footer_1))/2;
				$line_add=$this->lines_height;
			}
			if (STORE_REGISTER)
			{
				$register=PRINT_INVOICE_REGISTER.STORE_REGISTER;
				if (STORE_REGISTER_NR)
				{
					$register.=STORE_REGISTER_NR;
				}
				if (STORE_MANAGER)
				{
					$register.=$sep.PRINT_INVOICE_MANAGER.STORE_MANAGER;
				}
				$this->footer_2=$register;
				$this->footer_2_top=$footer_top+$line_add;
				$this->footer_2_left=ceil($this->w-$this->GetStringWidth($register))/2;
			}
		}
		if ($this->footer_1_top || $this->footer_2_top)
		{
			//Footer notes
			$y=$footer_top-$this->lines_height;
			$this->SetLineWidth(.2);
			$indent=10;
			$this->Line($this->lMargin+$indent,$y,$this->w-$this->rMargin-$indent,$y);

			if ($this->footer_1_top)
			{
				$this->Text($this->footer_1_left,$this->footer_1_top,$this->footer_1);
			}
			if ($this->footer_2_top)
			{
				$this->Text($this->footer_2_left,$this->footer_2_top,$this->footer_2);
			}
		}
		if ($this->page>1)
		{
			$page_text=str_replace(HASH,$this->page,PRINT_INVOICE_PAGE);
			$this->Text($page_text_left,$footer_top,$page_text);		//Footer page #
		}
	}

	function store_impressum_string($s)
	{
		$this->impressum[]=$s;
		$this->max_impressum_line_length=max($this->max_impressum_line_length,$this->GetStringWidth($s));
	}

	function Total($total_text,$total_sum)
	{
		global $invoice_items,$x_pos,$x_width;

		$this->SetFillColor(PDF_INVOICE_MARK_COLOR_BG);
		$this->SetTextColor(PDF_INVOICE_MARK_COLOR);
		$this->SetFont($pdf->font,BOLD,$this->invoice_font_size);
		$y=$this->GetY();
		$invoice_items_1=$invoice_items-1;
		$this->SetX($x_pos[$invoice_items_1]);
		$this->Cell($x_width[$invoice_items_1],$this->lines_height,$total_text,0,0,RIGHT,0);
		$this->SetY($y);
		$this->SetX($x_pos[$invoice_items]);
		$this->Cell($x_width[$invoice_items],$this->lines_height,olc_format_price($total_sum,1,1,0),1,0,RIGHT,1);
		$this->SetFont($this->font,NORMAL,10);
		$this->SetTextColor(PDF_INVOICE_MARK_COLOR_STANDARD);
		$this->SetFillColor(PDF_INVOICE_MARK_COLOR_BG_STANDARD);
	}
}

function Make_Header_Cell(&$x,$w,$txt=EMPTY_STRING,$is_price=false)
{
	global $pdf,$Y_Fields_Name_position,$x_pos,$x_width,$x_text,$field,$use_line_break,$set_parameters,$holds_price;

	$w=$x_width[$field];
	if ($set_parameters)
	{
		$x_pos[]=$x;
		$text=$txt;
		$text_parts=split(TILDE,$text);
		$text_parts_count=sizeof($text_parts);
		if ($text_parts_count>1)
		{
			$text_len=0;
			for ($j=0;$j<$text_parts_count;$j++)
			{
				$text_1=$text_parts[$j];
				if ($pdf->GetStringWidth($text_1)>$text_len)
				{
					$txt=$text_1;
				}
			}
		}
		$w_t=ceil($pdf->GetStringWidth(BLANK.$txt.BLANK));
		if ($w_t>$w)
		{
			$w=$w_t;
			$x_width[$field]=$w;
		}
	}
	else
	{
		if ($use_line_break)
		{
			if (strpos($txt,TILDE)===false)
			{
				//We use line break in header, and current text has no line break-> add line break at end!
				$txt.=TILDE;
			}
		}
		$pdf->SetY($Y_Fields_Name_position);
		$pdf->SetX($x_pos[$field]);
		$pdf->MultiCell($w,$pdf->lines_height,$txt,1,CENTER,1);
	}
	$x+=$w;
	$field++;
}

function Make_Cell($txt=EMPTY_STRING,$align,$is_price=false,$check_field_width=false,$add_lines,$fill=false)
{
	global $pdf,$field,$Y_Table_Position,$x_pos,$x_width,$tax;

	$w=$x_width[$field];
	if ($check_field_width)
	{
		$txt=fit_string($txt,$w);
	}
	else if ($is_price)
	{
		if (ADD_TAX)
		{
			$txt=olc_add_tax($txt, $tax);
		}
		$txt=olc_format_price($txt,1,1,0);
	}
	$pdf->SetY($Y_Table_Position);
	$pdf->SetX($x_pos[$field]);
	if ($add_lines)
	{
		//Multicell with more than one line (most likely attributes)
		//Attach line breaks, in order to prevent centering of cell text
		$txt=str_pad($txt,strlen($txt)+$add_lines,TILDE,STR_PAD_RIGHT);
	}
	$pdf->MultiCell($w,$pdf->lines_height,$txt,1,$align,$fill);
	$field++;
}

function fit_string($txt,$w)
{
	global $pdf;
	if ($pdf->GetStringWidth($txt) > $w)
	{
		for ($len=strlen($txt)-4;$len>0;$len--)
		{
			//$txt=BLANK.substr($txt,0,$len).ELLIPSES.BLANK;
			$txt=substr($txt,0,$len).ELLIPSES;
			if ($pdf->GetStringWidth($txt) <= $w)
			{
				break;
			}
		}
	}
	return $txt;
}

function new_page()
{
	global $pdf,$item_count,$invoice_items_per_page_next,$invoice_items_per_page0,$invoice_items_per_page;
	global $total_price,$footer_lines,$not_print_packing_slip,$have_carry,$carry;

	$break_1_done=$invoice_items_per_page<>$invoice_items_per_page0;
	if ($break_1_done)
	{
		if ($not_print_packing_slip)
		{
			//We had on overflow, so print overflow line
			$carry=array_sum($total_price);
			$pdf->Total(PRINT_INVOICE_CARRY,$carry);
			$have_carry=true;
		}
		$pdf->AddPage();
		$item_count = 1;
		$invoice_items_per_page=$invoice_items_per_page_next;
		$invoice_items_per_page0=$invoice_items_per_page_next;
	}
	else
	{
		//We need to overflow, so we can put more items on current page, as we only need to print on line (carry-over)!
		$invoice_items_per_page=$invoice_items_per_page+($footer_lines-1);
	}
}

function output_invoice_header()
{
	global $pdf,$x_pos,$x_width,$x_text,$Y_Fields_Name_position,$invoice_font_markup,$invoice_font_size;
	global $set_parameters,$products_field_width,$field;

	//Create each Field Name
	$pdf->SetFont($pdf->font,$invoice_font_markup,$invoice_font_size);
	//Color filling each Field Name box
	$pdf->SetFillColor(PDF_INVOICE_MARK_COLOR_BG);
	$pdf->SetTextColor(PDF_INVOICE_MARK_COLOR);
	$x=$pdf->lMargin;
	$field=0;
	for ($i=0;$i<sizeof($x_width);$i++)
	{
		Make_Header_Cell($x,$x_width[$field],$x_text[$field]);
	}
	$pdf->SetTextColor(PDF_INVOICE_MARK_COLOR_STANDARD);
	$pdf->SetFillColor(PDF_INVOICE_MARK_COLOR_BG_STANDARD);
}

//Instanciation of inherited class
$pdf=new PDF();
// Set the Page Margins
$pdf->SetMargins(15,10,10);					//Ränder links ,rechts, oben
//	$pdf->AddFont('Verdana','verdana.php');
//	$pdf->AddFont('Verdana', BOLD, 'verdanab.php');
//	$pdf->AddFont('Verdana', ITALIC, 'verdanai.php');
$pdf->font='Arial';
$pdf->invoice_font_size=$invoice_font_size;
$pdf->language_parameter='&language='.$_SESSION['language_code'];
$pdf->Open();
$pdf->SetDisplayMode("real");
$pdf->AliasNbPages();

$set_parameters=true;
$pdf->SetFont($pdf->font,$invoice_font_markup,$invoice_font_size);
$x=$pdf->lMargin;
$field=0;
//Sum widths of all fields apart form products name field
for ($i=0;$i<sizeof($x_text);$i++)
{
	Make_Header_Cell($x,$x_width[$field],$x_text[$field]);
	if ($i<>$products_field_item)
	{
		$total+=$x_width[$i];
	}
}
$set_parameters=false;
//Allocate rest of width to products name field
$products_field_width=$pdf->w-$pdf->lMargin-$pdf->rMargin-$total;
$x_width[$products_field_item]=$products_field_width;
$x=$x_pos[$products_field_item];
//Recalculate field start positions
for ($i=$products_field_item;$i<sizeof($x_text);$i++)
{
	$x_pos[$i]=$x;
	$x+=$x_width[$i];
}
$footer_lines=1;		//Total line
$shipping_cost=$order->info['shipping_cost'];
$have_shipping_cost=(int)$shipping_cost>0;
if ($have_shipping_cost)
{
	$footer_lines+=1;		//Shipment-cost line
}
if ($have_orders_discount)
{
	$footer_lines+=1;		//Order-discount line
}
if ($credit_available)
{
	$footer_lines+=1;		//Creadi line
}
if ($footer_lines>1)
{
	$footer_lines+=1;		//If more then one line, we have total and subtotal(s)
}
//Get # of different tax-classes
if (NOT_NO_TAX_RAISED)
{
	$tax_classes=0;
	$last_tax_class=0;
	for ($i = 0, $n = sizeof($order->products)-1; $i <= $n; $i++)
	{
		if ($order->products[$i][$tax_data_name]<>$last_tax_class)
		{
			$tax_classes++;
		}
	}
	$tax_lines=$tax_classes*2;
	if (!ADD_TAX)
	{
		if (!IS_NATIONAL_ORDER)
		{
			$tax_lines=$tax_classes;
		}
	}
	$footer_lines+=$tax_lines-1;	//-1, because we already have accounted for one "sum" line!
}
$standard_footer_lines=8;
//(Total 7%, Total 16%, Tax-Total 7%, Tax-Total 16%, shipment cost, discount, credit,grand-total)
if ($footer_lines<>$standard_footer_lines)
{
	//We need to adjust max items per page
	$invoice_items_per_page+=$standard_footer_lines-$footer_lines;
}
if (!$have_customers_order_reference)
{
	$invoice_items_per_page++;
}
if (!$have_orders_discount)
{
	$invoice_items_per_page++;
}
$not_credit_available=empty($order->billing['billing_name']);
if ($not_credit_available)
{
	//No billing info --> credit was available
	$invoice_items_per_page++;
}
else
{
	$credit_available=true;
}
$invoice_items_per_page0=$invoice_items_per_page;

//Build sender line for invoice
$new_line="\r\n";
$pos=strpos(STORE_NAME_ADDRESS,$new_line);
if ($pos===false)
{
	$new_line=NEW_LINE;
	$pos=strpos(STORE_NAME_ADDRESS,$new_line);
}
if ($pos)
{
	$sender=str_replace($new_line,COMMA_BLANK,STORE_NAME_ADDRESS);
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
$pdf->document=$document;
$pdf->doc_type=$doc_type;
// Add the first page
$pdf->SetTextColor(PDF_INVOICE_MARK_COLOR_STANDARD);
$pdf->AddPage();
//Show the products information line by line
$total_price=array();
$total_tax=array();
$invoice_items_1=$invoice_items-1;
for ($i = 0, $n = sizeof($order->products)-1; $i <= $n; $i++)
{
	if ($have_carry)
	{
		$pdf->SetFillColor(PDF_INVOICE_MARK_COLOR_BG);
		$pdf->SetTextColor(PDF_INVOICE_MARK_COLOR);
		$field=0;
		$content=EMPTY_STRING;
		$is_price=false;
		for ($item=0;$item<=$invoice_items;$item++)
		{
			$is_carry_field=$item>=$invoice_items_1;
			if ($is_carry_field)
			{
				switch ($item)
				{
					case $invoice_items-1:
						$content=PRINT_INVOICE_CARRY;
						$is_price=false;
						break;
					case $invoice_items:
						$content=$carry;
						$is_price=true;
						break;
				}
				$pdf->SetFont($pdf->font,BOLD,$pdf->invoice_font_size);
			}
			Make_Cell($content,RIGHT,$is_price,false,0,$is_carry_field);
			if ($is_carry_field)
			{
				$pdf->SetFont($pdf->font,NORMAL,$pdf->invoice_font_size);
			}
		}
		$pdf->SetFillColor(PDF_INVOICE_MARK_COLOR_BG_STANDARD);
		$pdf->SetTextColor(PDF_INVOICE_MARK_COLOR_STANDARD);
		$Y_Table_Position+=$pdf->lines_height;
		$invoice_items_per_page0--;
		$invoice_items_per_page=$invoice_items_per_page0;
	}
	$current_product=$order->products[$i];
	$qty=$current_product[$qty_data_name];
	$model=$current_product[$model_data_name];
	$name=$current_product[$name_data_name];
	if ($not_print_packing_slip)
	{
		$tax=$current_product[$tax_data_name];
		$discount=$current_product[$discount_data_name];
		if ($discount_decimal_places)
		{
			$discount=olc_precision($discount,$discount_decimal_places);
			if ($discount_decimal_places)
			{
				$discount=number_format($discount,$discount_decimal_places,CURRENCY_DECIMAL_POINT,CURRENCY_THOUSANDS_POINT);
			}
		}
		$price=$current_product[$price_data_name];
		$final_price=$current_product[$final_price_data_name];
		$total_price[$tax]+=$final_price;
	}

	if (NOT_NO_TAX_RAISED)
	{
		$total_tax[$tax].=$final_price*$tax/100;

		$tax=olc_precision($tax,$tax_decimal_places);
		if ($tax_decimal_places)
		{
			$tax=number_format($tax,$tax_decimal_places,CURRENCY_DECIMAL_POINT,CURRENCY_THOUSANDS_POINT);
		}
	}
	$pdf->SetFont($pdf->font,NORMAL,$pdf->invoice_font_size);
	$pdf->SetY($Y_Table_Position);
	$current_product_attributes=$current_product['attributes'];
	$attributes=sizeof($current_product_attributes);
	if ($attributes)
	{
		//Break if article + attributes are too long
		if ((($item_count+$attributes) %  $invoice_items_per_page)==0)
		{
			new_page();
		}
	}
	$field=0;
	$position=$i+1;
	for ($item=0;$item<=$invoice_items;$item++)
	{
		$is_product_field=$item==$products_field_item;
		if ($is_product_field)
		{
			$pdf->SetFont($pdf->font,BOLD,$pdf->invoice_font_size);
		}
		Make_Cell($$x_content[$field],$x_align[$field],$holds_price[$field],$check_size[$field],$attributes);
		if ($is_product_field)
		{
			$pdf->SetFont($pdf->font,NORMAL,$pdf->invoice_font_size);
		}
	}
	$Y_Table_Position+=$pdf->lines_height;
	if ($attributes)
	{
		//Print attributes
		$pdf->SetFont($pdf->font,ITALIC,9);
		$x=$x_pos[$products_field_item]+2;
		$w=$products_field_width-2;
		$y=$Y_Table_Position+$pdf->lines_height*.6;
		for ($a=0,$m=$attributes-1; $a <= $m;$a++)
		{
			$current_attribute=$current_product_attributes[$a];
			$txt='- '.$current_attribute['option'].COLON_BLANK.$current_attribute['value'];
			$txt=fit_string($txt,$w);
			$pdf->Text($x,$y,$txt);
			$y+=$pdf->lines_height;
		}
		$pdf->SetFont($pdf->font,NORMAL,$pdf->invoice_font_size);
		//$pdf->SetY($Y_Table_Position+$attributes*$pdf->lines_height);
		$Y_Table_Position+=$pdf->lines_height*$attributes;
	}
	$item_count++;
	//Check for products overflow (i.e.: more then one page required
	$break_page=($item_count % $invoice_items_per_page) == 0;
	if ($break_page)
	{
		if ($i<>$n)
		{
			//Overflow if more products to come!
			new_page();
		}
	}
}
if ($not_print_packing_slip)
{
	$total_items=sizeof($total_price);
	$total_price_classes=array_keys($total_price);
	$add_tax_id=$total_items>1;
	if ($add_tax_id)
	{
		asort($total_price);
	}
	if ($add_tax_id)
	{
		asort($total_tax[$i]);

		$max_tax_id_len=0;
		for ($i = 0; $i < $total_items; $i++)
		{
			$tax=olc_precision($total_price_classes[$i],$tax_decimal_places);
			if ($tax_decimal_places)
			{
				$tax=number_format($tax,$tax_decimal_places,CURRENCY_DECIMAL_POINT,CURRENCY_THOUSANDS_POINT);
			}
			$max_tax_id_len=max($max_tax_id_len,strlen($tax));
			$total_tax[$i]=$tax;
		}
	}
	else
	{
		$i=(int)$total_price_classes[0];
		$add_tax_id=$i<>0;
		$max_tax_id_len=strlen($i);
	}
	$max_text_len=0;
	$tax=EMPTY_STRING;
	$price_name=EMPTY_STRING;
	$price_value=EMPTY_STRING;
	$tax_name=EMPTY_STRING;
	$tax_value=EMPTY_STRING;
	$pdf->SetFont($pdf->font,BOLD,$pdf->invoice_font_size);
	for ($i = 0; $i < $total_items; $i++)
	{
		$key=$total_price_classes[$i];
		if ($add_tax_id)
		{
			$tax=$total_tax[$i];
			$tax_id_len=strlen($tax);
			if ($tax_id_len<$max_tax_id_len)
			{
				//Add leading blanks
				$tax=str_pad(EMPTY_STRING,$max_tax_id_len-$tax_id_len,BLANK).$tax;
			}
			$tax.='('.$tax.' %)'.COLON_BLANK;
			$s=PRINT_INVOICE_SUM.$tax;
			$max_text_len=max($max_text_len,ceil($pdf->GetStringWidth($s)));
			if ($tax_name)
			{
				$tax_name.=TILDE;
				$tax_value.=TILDE;
			}
			$tax_name.=$s;
			$tax_value.=olc_format_price($total_tax[$key],1,1,0);
		}
		$s=PRINT_INVOICE_SUM.$tax;
		$max_text_len=max($max_text_len,ceil($pdf->GetStringWidth($s)));
		$pdf->SetFont($pdf->font,NORMAL,$pdf->invoice_font_size);
		if ($price_name)
		{
			$price_name.=TILDE;
			$price_value.=TILDE;
		}
		$price_name.=$s;
		$values[]=$price;
		$price_value.=olc_format_price($total_price[$key],1,1,0);
	}
	$pdf->SetFont($pdf->font,NORMAL,$pdf->invoice_font_size);
	$shipping_text=$order->info['shipping_method'].BLANK;
	$pos=strpos($shipping_text,LPAREN);
	if ($pos)
	{
		$shipping_text=rtrim(substr($shipping_text,0,$pos+1));//	.TILDE.ltrim(substr($shipping_text,$pos+1));
	}
	$max_text_len=max($max_text_len,ceil($pdf->GetStringWidth($shipping_text)));
	$x_price=$x_pos[$invoice_items];
	$w=$x_width[$invoice_items];

	$texts=array();
	$values=array();
	$height=array();

	$texts[]=$price_name;
	$values[]=$price_value;
	if ($add_tax_id)
	{
		$total_items+=$total_items;
	}
	$height[]=$pdf->lines_height*$total_items;
	$shipping_cost_index=-1;
	if ($add_tax_id || $have_shipping_cost || $have_orders_discount || $credit_available)
	{
		if ($add_tax_id)
		{
			$texts[]=$tax_name;
			$values[]=$tax_value;
			$height[]=$pdf->lines_height;
		}
		$total_price=array_sum($total_price)+array_sum($total_tax);
		if ($have_shipping_cost)
		{
			$shipping_cost_index=sizeof($texts);
			$texts[]=$shipping_text;
			$values[]=olc_format_price($shipping_cost,1,1,0);
			$height[]=$pdf->lines_height;
			$total_price+=$shipping_cost;
		}
		if ($have_orders_discount)
		{
			$texts[]=PRINT_INVOICE_TOTAL_DISCOUNT;
			$values[]=olc_format_price($orders_discount,1,1,0);;
			$height[]=$pdf->lines_height;
			$total_price-=$orders_discount;
			$max_text_len=max($max_text_len,ceil($pdf->GetStringWidth(PRINT_INVOICE_TOTAL_DISCOUNT)));
		}
		if ($credit_available)
		{
			$credit=$total_price;
			$total_price=0;
		}
		else
		{
			$total=$order->info['total_value'];
			$credit=$total-$total_price;
			if ($credit>0)
			{
				$credit_available=true;
				$total_price-=$credit;
			}
		}
		if ($credit_available)
		{
			$max_text_len=max($max_text_len,ceil($pdf->GetStringWidth(PRINT_INVOICE_TOTAL_CREDIT)));
			$texts[]=PRINT_INVOICE_TOTAL_CREDIT;
			$values[]=olc_format_price($credit,1,1,0);
			$height[]=$pdf->lines_height;
		}
		$max_text_len=max($max_text_len,ceil($pdf->GetStringWidth(PRINT_INVOICE_TOTAL)));
		$texts[]=PRINT_INVOICE_TOTAL;
		//$values[]=olc_format_price($order->info['total_value'],1,1,0);
		$values[]=olc_format_price($total_price,1,1,0);
		$height[]=$pdf->lines_height;
	}
	$max_text_len+=$pdf->cMargin*2;
	$x_text=$x_price-$max_text_len;
	$y=$pdf->GetY();
	//Print invoice-table footer texts
	$total_price_classes=sizeof($total_price_classes);
	for ($i=0,$n=sizeof($texts)-1;$i<=$n;$i++)
	{
		$h=$height[$i];
		$pdf->SetY($Y_Table_Position);
		$pdf->SetX($x_text);
		$fill=$i<$total_price_classes || $i==$n;
		if ($fill)
		{
			$pdf->SetFillColor(PDF_INVOICE_MARK_COLOR_BG);
			$pdf->SetFont($pdf->font,BOLD,$pdf->invoice_font_size);
		}
		$pdf->MultiCell($max_text_len,$h,$texts[$i],0,RIGHT,0);
		$pdf->SetY($Y_Table_Position);
		$pdf->SetX($x_price);
		$pdf->MultiCell($w,$h,$values[$i],1,RIGHT,$fill);
		if ($fill)
		{
			$pdf->SetFont($pdf->font,NORMAL,$pdf->invoice_font_size);
			$pdf->SetFillColor(PDF_INVOICE_MARK_COLOR_BG_STANDARD);
		}
		$Y_Table_Position+=$pdf->lines_height;
	}
	if ($not_print_packing_slip)
	{
		/*
		$payment_message=EMPTY_STRING;
		if ($payment_method=='moneyorder')
		{
		if ($total_price>0)
		{
		$payment_message=TILDE.PRINT_INVOICE_MONEY_ORDER;
		}
		}
		*/
		$w=$x_text*.8-$pdf->lMargin;
		$pdf->SetY($y+$pdf->lines_height);
		$pdf->SetX($pdf->lMargin);
		$pdf->SetFont($pdf->font,NORMAL,8);
		$pdf->MultiCell($w,$h,$tax_disclaimer.TILDE.TILDE.PRINT_INVOICE_THANX_TEXT.$payment_message,0,LEFT);
	}
}
$pdf->Footer();
// PDF is created now output the file
//PDF file name
$pdf_invoice=str_replace(SLASH,UNDERSCORE,strtolower($doc_type)).UNDERSCORE.$document_number.PDF;
if ($pdf_download)
{
	$dest="I";																						//Send to Browser
}
else
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
	$pdf_invoice=$dir.$pdf_invoice;  //Store in file
}
$pdf->Output($pdf_invoice,$dest);
$is_print_version=false;
$is_pdf=false;
if ($pdf_download)
{
	olc_exit();
}
?>