<?php
// autogenerated file 17.11.2006 13:29
// $Id: ShippingServiceDetailsType.php,v 1.1.1.1 2006/12/22 14:38:46 gswkaiser Exp $
// $Log: ShippingServiceDetailsType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:46  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'ShippingServiceCodeType.php';

class ShippingServiceDetailsType extends EbatNs_ComplexType
{
	// start props
	// @var string $Description
	var $Description;
	// @var boolean $ExpeditedService
	var $ExpeditedService;
	// @var boolean $InternationalService
	var $InternationalService;
	// @var token $ShippingService
	var $ShippingService;
	// @var int $ShippingServiceID
	var $ShippingServiceID;
	// @var int $ShippingTimeMax
	var $ShippingTimeMax;
	// @var int $ShippingTimeMin
	var $ShippingTimeMin;
	// @var ShippingServiceCodeType $ShippingServiceCode
	var $ShippingServiceCode;
	// end props

/**
 *

 * @return string
 */
	function getDescription()
	{
		return $this->Description;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setDescription($value)
	{
		$this->Description = $value;
	}
/**
 *

 * @return boolean
 */
	function getExpeditedService()
	{
		return $this->ExpeditedService;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setExpeditedService($value)
	{
		$this->ExpeditedService = $value;
	}
/**
 *

 * @return boolean
 */
	function getInternationalService()
	{
		return $this->InternationalService;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setInternationalService($value)
	{
		$this->InternationalService = $value;
	}
/**
 *

 * @return token
 */
	function getShippingService()
	{
		return $this->ShippingService;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setShippingService($value)
	{
		$this->ShippingService = $value;
	}
/**
 *

 * @return int
 */
	function getShippingServiceID()
	{
		return $this->ShippingServiceID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setShippingServiceID($value)
	{
		$this->ShippingServiceID = $value;
	}
/**
 *

 * @return int
 */
	function getShippingTimeMax()
	{
		return $this->ShippingTimeMax;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setShippingTimeMax($value)
	{
		$this->ShippingTimeMax = $value;
	}
/**
 *

 * @return int
 */
	function getShippingTimeMin()
	{
		return $this->ShippingTimeMin;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setShippingTimeMin($value)
	{
		$this->ShippingTimeMin = $value;
	}
/**
 *

 * @return ShippingServiceCodeType
 */
	function getShippingServiceCode()
	{
		return $this->ShippingServiceCode;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setShippingServiceCode($value)
	{
		$this->ShippingServiceCode = $value;
	}
/**
 *

 * @return 
 */
	function ShippingServiceDetailsType()
	{
		$this->EbatNs_ComplexType('ShippingServiceDetailsType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'Description' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ExpeditedService' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'InternationalService' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ShippingService' =>
				array(
					'required' => false,
					'type' => 'token',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ShippingServiceID' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ShippingTimeMax' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ShippingTimeMin' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ShippingServiceCode' =>
				array(
					'required' => false,
					'type' => 'ShippingServiceCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
