<?php
/* -----------------------------------------------------------------------------------------
$Id: payment.php,v 1.1.1.1.2.1 2007/04/08 07:17:48 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(payment.php,v 1.36 2003/02/11); www.oscommerce.com
(c) 2003	    nextcommerce (payment.php,v 1.11 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contribution:

Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
http://www.oscommerce.com/community/contributions,282
Copyright (c) Strider | Strider@oscworks.com
Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
Copyright (c) Andre ambidex@gmx.net
Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org


Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// include needed functions
require_once(DIR_FS_INC.'olc_count_payment_modules.inc.php');
require_once(DIR_FS_INC.'olc_in_array.inc.php');

class payment {
	var $modules, $selected_module;

	// class constructor
	function payment($module = EMPTY_STRING) {
		global $PHP_SELF;

		if (defined('MODULE_PAYMENT_INSTALLED') && olc_not_null(MODULE_PAYMENT_INSTALLED)) {
			$this->modules = explode(';', MODULE_PAYMENT_INSTALLED);

			$include_modules = array();

			if ( (olc_not_null($module)) && (in_array($module . DOT .
			substr($PHP_SELF, (strrpos($PHP_SELF, DOT)+1)), $this->modules)) ) {
				$this->selected_module = $module;

				$include_modules[] = array('class' => $module, 'file' => $module . PHP);
			} else {
				reset($this->modules);
				while (list(, $value) = each($this->modules)) {
					$class = substr($value, 0, strrpos($value, DOT));
					$include_modules[] = array('class' => $class, 'file' => $value);
				}
			}
			// load unallowed modules into array
			$unallowed_modules = explode(COMMA, $_SESSION['customers_status']['customers_status_payment_unallowed']);

			$lang_dir=DIR_WS_LANGUAGES . SESSION_LANGUAGE . '/modules/payment/';
			$modules_payment_dir=DIR_WS_MODULES . 'payment/';
			for ($i = 0, $n = sizeof($include_modules); $i < $n; $i++) {
				$file=$include_modules[$i]['file'];
				if ($file==FILENAME_PAYPAL_WPP)
				{
					if (USE_PAYPAL_WPP)
					{
						continue;
					}
				}
				elseif ($file==FILENAME_PAYPAL_IPN)
				{
					if (!USE_PAYPAL_IPN)
					{
						continue;
					}
				}
				$class=$include_modules[$i]['class'];
				if (!olc_in_array($class, $unallowed_modules))
				{
					// check if zone is allowed to see module
					$upper_class= strtoupper($class);
					$constant_modules_payment='MODULE_PAYMENT_' . $upper_class . '_ALLOWED';
					if (defined($constant_modules_payment))
					{
						$constant_modules_payment=constant($constant_modules_payment);
					}
					else
					{
						$constant_modules_payment=EMPTY_STRING;
					}
					if ($constant_modules_payment != EMPTY_STRING)
					{
						$unallowed_zones = explode(COMMA, $constant_modules_payment);
					} else {
						$unallowed_zones = array();
					}
					if (in_array($_SESSION['delivery_zone'], $unallowed_zones) == true || count($unallowed_zones) == 0) {
						if ($file)
						{
							if ($file!='no_payment')
							{
								$include_file=$modules_payment_dir . $file;
								if (file_exists($include_file))
								{
									include_once($lang_dir . $file);
									include_once($include_file);
									$GLOBALS[$class] = new $class;
								}
							}
						}
					}
				}
			}
			// if there is only one payment method, select it as default because in
			// checkout_confirmation.php the $payment variable is being assigned the
			// $HTTP_POST_VARS['payment'] value which will be empty (no radio button selection possible)
			if ( (olc_count_payment_modules() == 1) && (!is_object($_SESSION['payment'])) ) {
				$_SESSION['payment'] = $include_modules[0]['class'];
			}

			if (olc_not_null($module))
			{
				if (in_array($module, $this->modules))
				{
					if (isset($GLOBALS[$module]->form_action_url))
					{
						$this->form_action_url = $GLOBALS[$module]->form_action_url;
					}
				}
			}
		}
	}

	// class methods
	/* The following method is needed in the checkout_confirmation.php page
	due to a chicken and egg problem with the payment class and order class.
	The payment modules needs the order destination data for the dynamic status
	feature, and the order class needs the payment module title.
	The following method is a work-around to implementing the method in all
	payment modules available which would break the modules in the contributions
	section. This should be looked into again post 2.2.
	*/
	function update_status() 
	{
		if (is_array($this->modules)) {
			if (is_object($GLOBALS[$this->selected_module])) {
				if (function_exists('method_exists')) {
					if (method_exists($GLOBALS[$this->selected_module], 'update_status')) {
						$GLOBALS[$this->selected_module]->update_status();
					}
				} else { // PHP3 compatibility
					@call_user_method('update_status', $GLOBALS[$this->selected_module]);
				}
			}
		}
	}

	//W. Kaiser - AJAX
	function javascript_validation()
	{
		$js = EMPTY_STRING;
//Payment.php';
		if (is_array($this->modules))
		{
			$js .= '
function check_form_payment(form_name)
{
	var error = 0;
	var error_message = "' . JS_ERROR . '";
	var payment_value = null;
  var document_checkout_payment_payment=document.checkout_payment.payment;
  var payment_length=document_checkout_payment_payment.length;
	if (document_checkout_payment_payment.value)
  {
    payment_value = document_checkout_payment_payment.value;
  }
  if (payment_length)
  {
    for (var i=0; i<payment_length; i++)
    {
      if (document_checkout_payment_payment[i].checked)
      {
        payment_value = document_checkout_payment_payment[i].value;
        break;
      }
    }
  }
';
			reset($this->modules);
			while (list(, $value) = each($this->modules))
			{
				$class = substr($value, 0, strrpos($value, DOT));
				if ($GLOBALS[$class]->enabled)
				{
					$js .= $GLOBALS[$class]->javascript_validation();
				}
			}
			$js .= '
	if (payment_value == null)
	{
		error_message = error_message + "' . JS_ERROR_NO_PAYMENT_MODULE_SELECTED . '";
		error = 1;
	}
	// GV Code Start/End
	if (error == 1 && submitter != 1)
	{
		alert(error_message);
		return false;
	}
	else
	{';
			if (USE_AJAX)
			{
				$js .= '
		make_AJAX_Request_POST(form_name,"'.FILENAME_CHECKOUT_CONFIRMATION.'");
		return false;';
			}
			else
			{
				$js .= '
		return true;';
			}
			$js .=  '
	}
}
//Payment.php';
			if (NOT_USE_AJAX)
			{
				$js = '
<script language="javascript" type="text/javascript"><!--
'.$js.'
//--></script>' . NEW_LINE;
			}
		}
		return $js;
	}
	//W. Kaiser - AJAX

	function selection() {
		$selection_array = array();

		if (is_array($this->modules)) {
			reset($this->modules);
			while (list(, $value) = each($this->modules)) {
				$class = substr($value, 0, strrpos($value, DOT));
				if ($GLOBALS[$class]->enabled) {
					$selection = $GLOBALS[$class]->selection();
					if (is_array($selection)) $selection_array[] = $selection;
				}
			}
		}

		return $selection_array;
	}

	//GV Code Start
	//ICW CREDIT CLASS Gift Voucher System
	// check credit covers was setup to test whether credit covers is set in other parts of the code
	function check_credit_covers() {
		global $credit_covers;

		return $credit_covers;
	}
	// GV Code End

	function pre_confirmation_check() {
		global $credit_covers, $payment_modules; // GV Code ICW CREDIT CLASS Gift Voucher System
		if (is_array($this->modules)) {
			if (is_object($GLOBALS[$this->selected_module]) && ($GLOBALS[$this->selected_module]->enabled) ) {

				if ($credit_covers) { // GV Code ICW CREDIT CLASS Gift Voucher System
					$GLOBALS[$this->selected_module]->enabled = false; // GV Code ICW CREDIT CLASS Gift Voucher System
					$GLOBALS[$this->selected_module] = NULL; // GV Code ICW CREDIT CLASS Gift Voucher System
					$payment_modules = EMPTY_STRING; // GV Code ICW CREDIT CLASS Gift Voucher System
				} else { // GV Code ICW CREDIT CLASS Gift Voucher System
					$GLOBALS[$this->selected_module]->pre_confirmation_check();
				}
			}
		}
	}

	function confirmation() {
		if (is_array($this->modules)) {
			if (is_object($GLOBALS[$this->selected_module]) && ($GLOBALS[$this->selected_module]->enabled) ) {
				return $GLOBALS[$this->selected_module]->confirmation();
			}
		}
	}

	function process_button() {
		if (is_array($this->modules)) {
			if (is_object($GLOBALS[$this->selected_module]) && ($GLOBALS[$this->selected_module]->enabled) ) {
				return $GLOBALS[$this->selected_module]->process_button();
			}
		}
	}

	function before_process() {
		if (is_array($this->modules)) {
			if (is_object($GLOBALS[$this->selected_module]) && ($GLOBALS[$this->selected_module]->enabled) ) {
				return $GLOBALS[$this->selected_module]->before_process();
			}
		}
	}

	function after_process() {
		if (is_array($this->modules)) {
			if (is_object($GLOBALS[$this->selected_module]) && ($GLOBALS[$this->selected_module]->enabled) ) {
				return $GLOBALS[$this->selected_module]->after_process();
			}
		}
	}

	function get_error() {
		if (is_array($this->modules)) {
			if (is_object($GLOBALS[$this->selected_module]) && ($GLOBALS[$this->selected_module]->enabled) ) {
				return $GLOBALS[$this->selected_module]->get_error();
			}
		}
	}

	//---PayPal WPP Modification START ---//
	function ec_step1() {
		if (is_array($this->modules)) {
			if (is_object($GLOBALS[$this->selected_module]) && ($GLOBALS[$this->selected_module]->enabled) ) {
				return $GLOBALS[$this->selected_module]->ec_step1();
			}
		}
	}

	function ec_step2() {
		if (is_array($this->modules)) {
			if (is_object($GLOBALS[$this->selected_module]) && ($GLOBALS[$this->selected_module]->enabled) ) {
				return $GLOBALS[$this->selected_module]->ec_step2();
			}
		}
	}
	//---PayPal WPP Modification END---//
}
?>