<?PHP
//Standard products items per page
$invoice_items_per_page = 20;

//Nr. of decimal places for tax value(s)
$tax_decimal_places = 0;

// ***** Positioning *****
$address_top=48;				// In mm
$address_left=24.1;			// In mm
$invoice_start_top=100;	// In mm
// ***** Positioning *****

// ***** Fonts and markups *****
$invoice_font_size=10;
$invoice_font_markup=BOLD;
// ***** Fonts and markups *****

//If "$right_justify_2nd_address" is set, the 2nd aaditional(!) will be right justified,
//otherwise its left will be positioned in then page middle.
//(Only applicable, if we have all different order, shipping and billing addresses.)
$right_justify_3rd_address=false;

// ***** Document field definitions *****

//Invoice Position
define_field($col_title=PRINT_INVOICE_POSITION,$min_width=0,$content_var_data_name=$position_data_name,$align=RIGHT,
	$is_price_field=false,$do_check_size=false);

//Products quantity
define_field($col_title=PRINT_INVOICE_QUANTITY,$min_width=0,$content_var_data_name=$qty_data_name,$align=RIGHT,
	$is_price_field=false,$do_check_size=false);

//Products model
define_field($col_title=PRINT_INVOICE_PRODUCTS_MODEL,$min_width=0,$content_var_data_name=$model_data_name,$align=RIGHT,
	$is_price_field=false,$do_check_size=false);
$products_field_item=$invoice_items;

//Products description
define_field($col_title=PRINT_INVOICE_PRODUCTS,$min_width=0,$content_var_data_name=$name_data_name,$align=LEFT,
	$is_price_field=false,$do_check_size=true);

if ($not_print_packing_slip)
{
	/*
	//If you want to show products discounts, remove block comment
	if ($have_products_discount)
	{
		//Products discount
		//include only, if discounts are available at all! (Checked befor call in "pdf_invoice.php")
		define_field($col_title=PRINT_INVOICE_DISCOUNT,$min_width=0,$content_var_data_name=$discount_data_name,$align=RIGHT,
			$is_price_field=false,$do_check_size=true);
		$show_discount=true;
		//Specify # of decimal places for products discount
		$discount_decimal_places=0;
	}
	*/
	if (ADD_TAX)
	{
		if ($have_products_tax)
		{
			//Products tax;
			define_field($col_title=PRINT_INVOICE_TAX,$min_width=0,$content_var_data_name=$discount_data_name,$align=RIGHT,
				$is_price_field=false,$do_check_size=false);
		}
	}
	//Products single price
	define_field($col_title=PRICE_SINGLE_HEADER,$min_width=0,$content_var_data_name=$price_data_name,$align=RIGHT,
		$is_price_field=true,$do_check_size=false);

	//Products total price
	define_field($col_title=PRICE_HEADER,$min_width=22,$content_var_data_name=$final_price_data_name,
		$align=RIGHT,$is_price_field=true,$do_check_size=false);
}
// ***** Field definitions *****
?>