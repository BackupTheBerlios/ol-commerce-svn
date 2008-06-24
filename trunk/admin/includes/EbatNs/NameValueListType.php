<?php
// autogenerated file 17.11.2006 13:29
// $Id: NameValueListType.php,v 1.1.1.1 2006/12/22 14:38:23 gswkaiser Exp $
// $Log: NameValueListType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:23  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';

class NameValueListType extends EbatNs_ComplexType
{
	// start props
	// @var string $Name
	var $Name;
	// @var string $Value
	var $Value;
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
 * @param  $index 
 */
	function getValue($index = null)
	{
		if ($index) {
		return $this->Value[$index];
	} else {
		return $this->Value;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setValue($value, $index = null)
	{
		if ($index) {
	$this->Value[$index] = $value;
	} else {
	$this->Value = $value;
	}

	}
/**
 *

 * @return 
 */
	function NameValueListType()
	{
		$this->EbatNs_ComplexType('NameValueListType', 'urn:ebay:apis:eBLBaseComponents');
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
				'Value' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => true,
					'cardinality' => '0..*'
				)
			));

	}
}
?>
