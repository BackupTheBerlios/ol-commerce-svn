<?php
// autogenerated file 17.11.2006 13:29
// $Id: FlatRateInsuranceRangeCostType.php,v 1.1.1.1 2006/12/22 14:37:50 gswkaiser Exp $
// $Log: FlatRateInsuranceRangeCostType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:50  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'AmountType.php';
require_once 'FlatRateInsuranceRangeCodeType.php';

class FlatRateInsuranceRangeCostType extends EbatNs_ComplexType
{
	// start props
	// @var FlatRateInsuranceRangeCodeType $FlatRateInsuranceRange
	var $FlatRateInsuranceRange;
	// @var AmountType $InsuranceCost
	var $InsuranceCost;
	// end props

/**
 *

 * @return FlatRateInsuranceRangeCodeType
 */
	function getFlatRateInsuranceRange()
	{
		return $this->FlatRateInsuranceRange;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setFlatRateInsuranceRange($value)
	{
		$this->FlatRateInsuranceRange = $value;
	}
/**
 *

 * @return AmountType
 */
	function getInsuranceCost()
	{
		return $this->InsuranceCost;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setInsuranceCost($value)
	{
		$this->InsuranceCost = $value;
	}
/**
 *

 * @return 
 */
	function FlatRateInsuranceRangeCostType()
	{
		$this->EbatNs_ComplexType('FlatRateInsuranceRangeCostType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'FlatRateInsuranceRange' =>
				array(
					'required' => false,
					'type' => 'FlatRateInsuranceRangeCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'InsuranceCost' =>
				array(
					'required' => false,
					'type' => 'AmountType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
