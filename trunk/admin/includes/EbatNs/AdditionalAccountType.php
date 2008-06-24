<?php
// autogenerated file 17.11.2006 13:29
// $Id: AdditionalAccountType.php,v 1.1.1.1 2006/12/22 14:37:13 gswkaiser Exp $
// $Log: AdditionalAccountType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:13  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'AmountType.php';
require_once 'CurrencyCodeType.php';

class AdditionalAccountType extends EbatNs_ComplexType
{
	// start props
	// @var AmountType $Balance
	var $Balance;
	// @var CurrencyCodeType $Currency
	var $Currency;
	// @var string $AccountCode
	var $AccountCode;
	// end props

/**
 *

 * @return AmountType
 */
	function getBalance()
	{
		return $this->Balance;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setBalance($value)
	{
		$this->Balance = $value;
	}
/**
 *

 * @return CurrencyCodeType
 */
	function getCurrency()
	{
		return $this->Currency;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCurrency($value)
	{
		$this->Currency = $value;
	}
/**
 *

 * @return string
 */
	function getAccountCode()
	{
		return $this->AccountCode;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setAccountCode($value)
	{
		$this->AccountCode = $value;
	}
/**
 *

 * @return 
 */
	function AdditionalAccountType()
	{
		$this->EbatNs_ComplexType('AdditionalAccountType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'Balance' =>
				array(
					'required' => false,
					'type' => 'AmountType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Currency' =>
				array(
					'required' => false,
					'type' => 'CurrencyCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'AccountCode' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
