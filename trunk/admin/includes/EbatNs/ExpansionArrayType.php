<?php
// autogenerated file 17.11.2006 13:29
// $Id: ExpansionArrayType.php,v 1.1.1.1 2006/12/22 14:37:44 gswkaiser Exp $
// $Log: ExpansionArrayType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:44  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'SearchResultItemType.php';

class ExpansionArrayType extends EbatNs_ComplexType
{
	// start props
	// @var SearchResultItemType $ExpansionItem
	var $ExpansionItem;
	// @var int $TotalAvailable
	var $TotalAvailable;
	// end props

/**
 *

 * @return SearchResultItemType
 * @param  $index 
 */
	function getExpansionItem($index = null)
	{
		if ($index) {
		return $this->ExpansionItem[$index];
	} else {
		return $this->ExpansionItem;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setExpansionItem($value, $index = null)
	{
		if ($index) {
	$this->ExpansionItem[$index] = $value;
	} else {
	$this->ExpansionItem = $value;
	}

	}
/**
 *

 * @return int
 */
	function getTotalAvailable()
	{
		return $this->TotalAvailable;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setTotalAvailable($value)
	{
		$this->TotalAvailable = $value;
	}
/**
 *

 * @return 
 */
	function ExpansionArrayType()
	{
		$this->EbatNs_ComplexType('ExpansionArrayType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'ExpansionItem' =>
				array(
					'required' => false,
					'type' => 'SearchResultItemType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				),
				'TotalAvailable' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
