<?php
// autogenerated file 17.11.2006 13:30
// $Id: TaxJurisdictionType.php,v 1.1.1.1 2006/12/22 14:38:52 gswkaiser Exp $
// $Log: TaxJurisdictionType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:52  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';

class TaxJurisdictionType extends EbatNs_ComplexType
{
	// start props
	// @var string $JurisdictionID
	var $JurisdictionID;
	// @var float $SalesTaxPercent
	var $SalesTaxPercent;
	// @var boolean $ShippingIncludedInTax
	var $ShippingIncludedInTax;
	// @var string $JurisdictionName
	var $JurisdictionName;
	// end props

/**
 *

 * @return string
 */
	function getJurisdictionID()
	{
		return $this->JurisdictionID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setJurisdictionID($value)
	{
		$this->JurisdictionID = $value;
	}
/**
 *

 * @return float
 */
	function getSalesTaxPercent()
	{
		return $this->SalesTaxPercent;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setSalesTaxPercent($value)
	{
		$this->SalesTaxPercent = $value;
	}
/**
 *

 * @return boolean
 */
	function getShippingIncludedInTax()
	{
		return $this->ShippingIncludedInTax;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setShippingIncludedInTax($value)
	{
		$this->ShippingIncludedInTax = $value;
	}
/**
 *

 * @return string
 */
	function getJurisdictionName()
	{
		return $this->JurisdictionName;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setJurisdictionName($value)
	{
		$this->JurisdictionName = $value;
	}
/**
 *

 * @return 
 */
	function TaxJurisdictionType()
	{
		$this->EbatNs_ComplexType('TaxJurisdictionType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'JurisdictionID' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'SalesTaxPercent' =>
				array(
					'required' => false,
					'type' => 'float',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ShippingIncludedInTax' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'JurisdictionName' =>
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
