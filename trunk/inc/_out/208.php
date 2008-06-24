<?PHP
//---PayPal WPP Modification START ---//
function olc_paypal_wpp_enabled()
{
	//W. Kaiser
	/*
	$paypal_wpp_check = olc_db_query("SELECT configuration_id FROM " . TABLE_CONFIGURATION .
	" WHERE configuration_key = 'MODULE_PAYMENT_PAYPAL_DP_STATUS' AND configuration_value = TRUE_STRING_S");
	if (olc_db_num_rows($paypal_wpp_check)) {
		return true;
	} else {
		return false;
	}
	*/
	if (USE_PAYPAL_WPP)
	{
		return (ENABLE_SSL || IS_LOCAL_HOST) && MODULE_PAYMENT_PAYPAL_DP_STATUS==TRUE_STRING_S;
	}
	//W. Kaiser
}
//---PayPal WPP Modification END ---//
?>