<?php
// autogenerated file 17.11.2006 13:29
// $Id: PaymentDetailsType.php,v 1.1.1.1 2006/12/22 14:38:26 gswkaiser Exp $
// $Log: PaymentDetailsType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:26  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';

class PaymentDetailsType extends EbatNs_ComplexType
{
	// start props
	// @var int $HoursToDeposit
	var $HoursToDeposit;
	// @var int $DaysToFullPayment
	var $DaysToFullPayment;
	// end props

/**
 *

 * @return int
 */
	function getHoursToDeposit()
	{
		return $this->HoursToDeposit;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setHoursToDeposit($value)
	{
		$this->HoursToDeposit = $value;
	}
/**
 *

 * @return int
 */
	function getDaysToFullPayment()
	{
		return $this->DaysToFullPayment;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setDaysToFullPayment($value)
	{
		$this->DaysToFullPayment = $value;
	}
/**
 *

 * @return 
 */
	function PaymentDetailsType()
	{
		$this->EbatNs_ComplexType('PaymentDetailsType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'HoursToDeposit' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'DaysToFullPayment' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
