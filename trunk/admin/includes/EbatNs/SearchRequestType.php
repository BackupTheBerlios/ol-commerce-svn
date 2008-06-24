<?php
// autogenerated file 17.11.2006 13:29
// $Id: SearchRequestType.php,v 1.1.1.1 2006/12/22 14:38:36 gswkaiser Exp $
// $Log: SearchRequestType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:36  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'SearchAttributesType.php';

class SearchRequestType extends EbatNs_ComplexType
{
	// start props
	// @var int $AttributeSetID
	var $AttributeSetID;
	// @var int $ProductFinderID
	var $ProductFinderID;
	// @var SearchAttributesType $SearchAttributes
	var $SearchAttributes;
	// end props

/**
 *

 * @return int
 */
	function getAttributeSetID()
	{
		return $this->AttributeSetID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setAttributeSetID($value)
	{
		$this->AttributeSetID = $value;
	}
/**
 *

 * @return int
 */
	function getProductFinderID()
	{
		return $this->ProductFinderID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setProductFinderID($value)
	{
		$this->ProductFinderID = $value;
	}
/**
 *

 * @return SearchAttributesType
 * @param  $index 
 */
	function getSearchAttributes($index = null)
	{
		if ($index) {
		return $this->SearchAttributes[$index];
	} else {
		return $this->SearchAttributes;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setSearchAttributes($value, $index = null)
	{
		if ($index) {
	$this->SearchAttributes[$index] = $value;
	} else {
	$this->SearchAttributes = $value;
	}

	}
/**
 *

 * @return 
 */
	function SearchRequestType()
	{
		$this->EbatNs_ComplexType('SearchRequestType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'AttributeSetID' =>
				array(
					'required' => true,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '1..1'
				),
				'ProductFinderID' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'SearchAttributes' =>
				array(
					'required' => false,
					'type' => 'SearchAttributesType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				)
			));

	}
}
?>
