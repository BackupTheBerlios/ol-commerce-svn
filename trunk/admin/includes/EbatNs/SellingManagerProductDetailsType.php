<?php
// autogenerated file 17.11.2006 13:29
// $Id: SellingManagerProductDetailsType.php,v 1.1.1.1 2006/12/22 14:38:38 gswkaiser Exp $
// $Log: SellingManagerProductDetailsType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:38  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';

class SellingManagerProductDetailsType extends EbatNs_ComplexType
{
	// start props
	// @var string $ProductName
	var $ProductName;
	// @var int $PartNumber
	var $PartNumber;
	// @var string $ProductPartNumber
	var $ProductPartNumber;
	// end props

/**
 *

 * @return string
 */
	function getProductName()
	{
		return $this->ProductName;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setProductName($value)
	{
		$this->ProductName = $value;
	}
/**
 *

 * @return int
 */
	function getPartNumber()
	{
		return $this->PartNumber;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setPartNumber($value)
	{
		$this->PartNumber = $value;
	}
/**
 *

 * @return string
 */
	function getProductPartNumber()
	{
		return $this->ProductPartNumber;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setProductPartNumber($value)
	{
		$this->ProductPartNumber = $value;
	}
/**
 *

 * @return 
 */
	function SellingManagerProductDetailsType()
	{
		$this->EbatNs_ComplexType('SellingManagerProductDetailsType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'ProductName' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'PartNumber' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ProductPartNumber' =>
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
