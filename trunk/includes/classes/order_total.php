<?php
/* -----------------------------------------------------------------------------------------
$Id: order_total.php,v 1.1.1.1.2.1 2007/04/08 07:17:48 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(order_total.php,v 1.4 2003/02/11); www.oscommerce.com
(c) 2003	    nextcommerce (order_total.php,v 1.6 2003/08/13); www.nextcommerce.org
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

(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

class order_total {
	var $modules;

	// GV Code Start
	// ICW ORDER TOTAL CREDIT CLASS/GV SYSTEM - START ADDITION
	//
	// This function is called in checkout payment after display of payment methods. It actually calls
	// two credit class functions.
	//
	// use_credit_amount() is normally a checkbox used to decide whether the credit amount should be applied to reduce
	// the order total. Whether this is a Gift Voucher, or discount coupon or reward points etc.
	//
	// The second function called is credit_selection(). This in the credit classes already made is usually a redeem box.
	// for entering a Gift Voucher number. Note credit classes can decide whether this part is displayed depending on
	// E.g. a setting in the admin section.
	//
	function credit_selection()
	{
		$selection_string = EMPTY_STRING;
		$close_string = EMPTY_STRING;
		$credit_class_string = EMPTY_STRING;
		if (MODULE_ORDER_TOTAL_INSTALLED) {
			$header_string = '
			<tr>
			   <td>
			   	<table border="0" width="100%" cellspacing="0" cellpadding="2">
			      <tr>
			        <td class="main"><b>' . TABLE_HEADING_CREDIT . '</b></td>
			      </tr>
			    </table>
			   </td>
			</tr>
			<tr>
				<td>
			  	<table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
			    	<tr class="infoBoxContents">
			    		<td>
			    			<table border="0" width="100%" cellspacing="0" cellpadding="2">
			       			<tr>
			       				<td width="10">' .  olc_draw_separator('pixel_trans.gif', '10', '1') .'</td>
			        			<td colspan="2">
			        				<table border="0" width="100%" cellspacing="0" cellpadding="2">
';
			$close_string   = '
			                </table>
			              </td>
										<td width="10">' .  olc_draw_separator('pixel_trans.gif', '10', '1') . '</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
				<tr>
					<td width="100%">' .  olc_draw_separator('pixel_trans.gif', '100%', '10') . '
					</td>
				</tr>';
			reset($this->modules);
			$output_string = EMPTY_STRING;
			while (list(, $value) = each($this->modules)) {
				$class = substr($value, 0, strrpos($value, '.'));
				if ($GLOBALS[$class]->enabled && $GLOBALS[$class]->credit_class)
				{
					$use_credit_string = $GLOBALS[$class]->use_credit_amount();
					if ($selection_string==EMPTY_STRING) $selection_string = $GLOBALS[$class]->credit_selection();
					if (($use_credit_string !=EMPTY_STRING ) || ($selection_string != EMPTY_STRING) )
					{
						$output_string .=  '
				<tr colspan="4">
					<td colspan="4" width="100%">' .  olc_draw_separator('pixel_trans.gif', '100%', '10') . '</td>
				</tr>
				<tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" >
					<td width="10">' .  olc_draw_separator('pixel_trans.gif', '10', '1') .'</td>
					<td class="main"><b>' . $GLOBALS[$class]->header .'</b></td>'.$use_credit_string.'
					<td width="10">' . olc_draw_separator('pixel_trans.gif', '10', '1') . '</td>
				</tr>
';
					$output_string .= $selection_string;
					}

				}
			}
			if ($output_string != EMPTY_STRING)
			{
				$output_string = $header_string . $output_string .$close_string;
			}
		}
		return $output_string;
	}


	//            if ($selection_string !=EMPTY_STRING) {
	//              $output_string .= '</td>' . NEW_LINE;
	//              $output_string .= $selection_string;
	//            }




	// update_credit_account is called in checkout process on a per product basis. It's purpose
	// is to decide whether each product in the cart should add something to a credit account.
	// e.g. for the Gift Voucher it checks whether the product is a Gift voucher and then adds the amount
	// to the Gift Voucher account.
	// Another use would be to check if the product would give reward points and add these to the points/reward account.
	//
	function update_credit_account($i) {
		if (MODULE_ORDER_TOTAL_INSTALLED) {
			reset($this->modules);
			while (list(, $value) = each($this->modules)) {
				$class = substr($value, 0, strrpos($value, '.'));
				if ( ($GLOBALS[$class]->enabled && $GLOBALS[$class]->credit_class) ) {
					$GLOBALS[$class]->update_credit_account($i);
				}
			}
		}
	}
	// This function is called in checkout confirmation.
	// It's main use is for credit classes that use the credit_selection() method. This is usually for
	// entering redeem codes(Gift Vouchers/Discount Coupons). This function is used to validate these codes.
	// If they are valid then the necessary actions are taken, if not valid we are returned to checkout payment
	// with an error
	//
	function collect_posts() {

		if (MODULE_ORDER_TOTAL_INSTALLED) {
			reset($this->modules);
			while (list(, $value) = each($this->modules)) {
				$class = substr($value, 0, strrpos($value, '.'));
				if ( ($GLOBALS[$class]->enabled && $GLOBALS[$class]->credit_class) ) {
					$post_var = 'c' . $GLOBALS[$class]->code;
					if ($_POST[$post_var]) {
						$_SESSION[$post_var] = $_POST[$post_var];
					}
					$GLOBALS[$class]->collect_posts();
				}
			}
		}
	}
	// pre_confirmation_check is called on checkout confirmation. It's function is to decide whether the
	// credits available are greater than the order total. If they are then a variable (credit_covers) is set to
	// true. This is used to bypass the payment method. In other words if the Gift Voucher is more than the order
	// total, we don't want to go to paypal etc.
	//
	function pre_confirmation_check() {
		global $order;
		if (MODULE_ORDER_TOTAL_INSTALLED) {
			$total_deductions  = 0;
			reset($this->modules);
			$order_total = $order->info['total'];
			while (list(, $value) = each($this->modules)) {
				$class = substr($value, 0, strrpos($value, '.'));
				$order_total = $this->get_order_total_main($class,$order_total);
				if ( ($GLOBALS[$class]->enabled && $GLOBALS[$class]->credit_class) ) {
					$total_deductions = $total_deductions + $GLOBALS[$class]->pre_confirmation_check($order_total);
					$order_total = $order_total - $GLOBALS[$class]->pre_confirmation_check($order_total);
				}
			}
			if ($order->info['total'] - $total_deductions <= 0 ) {
				$_SESSION['credit_covers'] = true;
			}
			else{   // belts and suspenders to get rid of credit_covers variable if it gets set once and they put something else in the cart
				unset($_SESSION['credit_covers']);
			}
		}
	}
	// this function is called in checkout process. it tests whether a decision was made at checkout payment to use
	// the credit amount be applied aginst the order. If so some action is taken. E.g. for a Gift voucher the account
	// is reduced the order total amount.
	//
	function apply_credit() {
		if (MODULE_ORDER_TOTAL_INSTALLED) {
			reset($this->modules);
			while (list(, $value) = each($this->modules)) {
				$class = substr($value, 0, strrpos($value, '.'));
				if ( ($GLOBALS[$class]->enabled && $GLOBALS[$class]->credit_class) ) {
					$GLOBALS[$class]->apply_credit();
				}
			}
		}
	}
	// Called in checkout process to clear session variables created by each credit class module.
	//
	function clear_posts() {

		if (MODULE_ORDER_TOTAL_INSTALLED) {
			reset($this->modules);
			while (list(, $value) = each($this->modules)) {
				$class = substr($value, 0, strrpos($value, '.'));
				if ( ($GLOBALS[$class]->enabled && $GLOBALS[$class]->credit_class) ) {
					$post_var = 'c' . $GLOBALS[$class]->code;
					unset($_SESSION[$post_var]);
				}
			}
		}
	}
	// Called at various times. This function calulates the total value of the order that the
	// credit will be appled aginst. This varies depending on whether the credit class applies
	// to shipping & tax
	//
	function get_order_total_main($class, $order_total) {
		global $credit, $order;
		//      if ($GLOBALS[$class]->include_tax == FALSE_STRING_S) $order_total=$order_total-$order->info['tax'];
		//      if ($GLOBALS[$class]->include_shipping == FALSE_STRING_S) $order_total=$order_total-$order->info['shipping_cost'];
		return $order_total;
	}
	// ICW ORDER TOTAL CREDIT CLASS/GV SYSTEM - END ADDITION
	// GV Code End

	// class constructor
	function order_total() {

		if (defined('MODULE_ORDER_TOTAL_INSTALLED') && olc_not_null(MODULE_ORDER_TOTAL_INSTALLED)) {
			$this->modules = explode(';', MODULE_ORDER_TOTAL_INSTALLED);

			reset($this->modules);
			while (list(, $value) = each($this->modules)) {
				include_once(DIR_WS_LANGUAGES . SESSION_LANGUAGE . '/modules/order_total/' . $value);
				include_once(DIR_WS_MODULES . 'order_total/' . $value);
				$class = substr($value, 0, strrpos($value, '.'));
				$GLOBALS[$class] = new $class;
			}
		}
	}

	function process() {
		$order_total_array = array();
		if (is_array($this->modules))
		{
			reset($this->modules);
			while (list(, $value) = each($this->modules))
			{
				$class = substr($value, 0, strrpos($value, DOT));
				if ($GLOBALS[$class]->enabled)
				{
					$GLOBALS[$class]->process();
					$ot_class_output=$GLOBALS[$class]->output;
					for ($i=0, $n=sizeof($ot_class_output); $i<$n; $i++)
					{
						$current_ot_class_output=$ot_class_output[$i];
						$current_ot_class_output_title=$current_ot_class_output['title'];
						if ($current_ot_class_output_title)
						{
							$current_ot_class_output_text=$current_ot_class_output['text'];
							if ($current_ot_class_output_text)
							{
								$order_total_array[] = array(
								'code' => $GLOBALS[$class]->code,
								'title' => $current_ot_class_output_title,
								'text' => $current_ot_class_output_text,
								'value' => $current_ot_class_output['value'],
								'sort_order' => $GLOBALS[$class]->sort_order);
							}
						}
					}
				}
			}
		}
		return $order_total_array;
	}

	function output() {
		$output_string = EMPTY_STRING;
		if (is_array($this->modules))
		{
			$bold_classes="ot_subtotal.ot_total";
			reset($this->modules);
			while (list(, $value) = each($this->modules)) {
				$class = substr($value, 0, strrpos($value, DOT));
				$class=$GLOBALS[$class];
				if ($class->enabled)
				{
					$size=sizeof($class->output);
					$bold_it=strpos($bold_classes,$class)!==false;
					for ($i=0; $i<$size; $i++)
					{
						$title= $class->output[$i]['title'];
						$text=$class->output[$i]['text'];
						if ($bold_it)
						{
							$title=HTML_B_START.$title.HTML_B_END;
							$text=HTML_B_START.$text.HTML_B_END;
						}
						$output_string .=
'              <tr>
                <td align="right" class="main">' . $title . '</td>
                <td align="right" class="main">' . $text . '</td>
              </tr>';
					}
				}
			}
		}
		return $output_string;
	}
}
?>