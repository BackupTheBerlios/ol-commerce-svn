<?php
// autogenerated file 17.11.2006 13:29
// $Id: ExpressHistogramDepartmentType.php,v 1.1.1.1 2006/12/22 14:37:45 gswkaiser Exp $
// $Log: ExpressHistogramDepartmentType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:45  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'ExpressHistogramAisleType.php';
require_once 'ExpressHistogramDomainDetailsType.php';

class ExpressHistogramDepartmentType extends EbatNs_ComplexType
{
	// start props
	// @var ExpressHistogramDomainDetailsType $DomainDetails
	var $DomainDetails;
	// @var ExpressHistogramAisleType $Aisle
	var $Aisle;
	// end props

/**
 *

 * @return ExpressHistogramDomainDetailsType
 */
	function getDomainDetails()
	{
		return $this->DomainDetails;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setDomainDetails($value)
	{
		$this->DomainDetails = $value;
	}
/**
 *

 * @return ExpressHistogramAisleType
 * @param  $index 
 */
	function getAisle($index = null)
	{
		if ($index) {
		return $this->Aisle[$index];
	} else {
		return $this->Aisle;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setAisle($value, $index = null)
	{
		if ($index) {
	$this->Aisle[$index] = $value;
	} else {
	$this->Aisle = $value;
	}

	}
/**
 *

 * @return 
 */
	function ExpressHistogramDepartmentType()
	{
		$this->EbatNs_ComplexType('ExpressHistogramDepartmentType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'DomainDetails' =>
				array(
					'required' => false,
					'type' => 'ExpressHistogramDomainDetailsType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Aisle' =>
				array(
					'required' => false,
					'type' => 'ExpressHistogramAisleType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				)
			));

	}
}
?>
