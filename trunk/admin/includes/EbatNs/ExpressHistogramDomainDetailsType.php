<?php
// autogenerated file 17.11.2006 13:29
// $Id: ExpressHistogramDomainDetailsType.php,v 1.1.1.1 2006/12/22 14:37:45 gswkaiser Exp $
// $Log: ExpressHistogramDomainDetailsType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:45  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';

class ExpressHistogramDomainDetailsType extends EbatNs_ComplexType
{
	// start props
	// @var string $Name
	var $Name;
	// @var string $BreadCrumb
	var $BreadCrumb;
	// @var int $ItemCount
	var $ItemCount;
	// @var int $ProductCount
	var $ProductCount;
	// @var anyURI $ImageURL
	var $ImageURL;
	// end props

/**
 *

 * @return string
 */
	function getName()
	{
		return $this->Name;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setName($value)
	{
		$this->Name = $value;
	}
/**
 *

 * @return string
 */
	function getBreadCrumb()
	{
		return $this->BreadCrumb;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setBreadCrumb($value)
	{
		$this->BreadCrumb = $value;
	}
/**
 *

 * @return int
 */
	function getItemCount()
	{
		return $this->ItemCount;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setItemCount($value)
	{
		$this->ItemCount = $value;
	}
/**
 *

 * @return int
 */
	function getProductCount()
	{
		return $this->ProductCount;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setProductCount($value)
	{
		$this->ProductCount = $value;
	}
/**
 *

 * @return anyURI
 */
	function getImageURL()
	{
		return $this->ImageURL;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setImageURL($value)
	{
		$this->ImageURL = $value;
	}
/**
 *

 * @return 
 */
	function ExpressHistogramDomainDetailsType()
	{
		$this->EbatNs_ComplexType('ExpressHistogramDomainDetailsType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'Name' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'BreadCrumb' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ItemCount' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ProductCount' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ImageURL' =>
				array(
					'required' => false,
					'type' => 'anyURI',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
