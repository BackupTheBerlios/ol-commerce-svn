<?php
// autogenerated file 17.11.2006 13:29
// $Id: DispatchTimeMaxDetailsType.php,v 1.1.1.1 2006/12/22 14:37:28 gswkaiser Exp $
// $Log: DispatchTimeMaxDetailsType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:28  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';

class DispatchTimeMaxDetailsType extends EbatNs_ComplexType
{
	// start props
	// @var int $DispatchTimeMax
	var $DispatchTimeMax;
	// @var string $Description
	var $Description;
	// end props

/**
 *

 * @return int
 */
	function getDispatchTimeMax()
	{
		return $this->DispatchTimeMax;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setDispatchTimeMax($value)
	{
		$this->DispatchTimeMax = $value;
	}
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

 * @return 
 */
	function DispatchTimeMaxDetailsType()
	{
		$this->EbatNs_ComplexType('DispatchTimeMaxDetailsType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'DispatchTimeMax' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Description' =>
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
