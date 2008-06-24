<?php
// autogenerated file 17.11.2006 13:29
// $Id: MyeBaySecondChanceOfferListType.php,v 1.1.1.1 2006/12/22 14:38:21 gswkaiser Exp $
// $Log: MyeBaySecondChanceOfferListType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:21  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'ItemType.php';

class MyeBaySecondChanceOfferListType extends EbatNs_ComplexType
{
	// start props
	// @var int $TotalAvailable
	var $TotalAvailable;
	// @var ItemType $SecondChanceOffer
	var $SecondChanceOffer;
	// end props

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

 * @return ItemType
 * @param  $index 
 */
	function getSecondChanceOffer($index = null)
	{
		if ($index) {
		return $this->SecondChanceOffer[$index];
	} else {
		return $this->SecondChanceOffer;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setSecondChanceOffer($value, $index = null)
	{
		if ($index) {
	$this->SecondChanceOffer[$index] = $value;
	} else {
	$this->SecondChanceOffer = $value;
	}

	}
/**
 *

 * @return 
 */
	function MyeBaySecondChanceOfferListType()
	{
		$this->EbatNs_ComplexType('MyeBaySecondChanceOfferListType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'TotalAvailable' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'SecondChanceOffer' =>
				array(
					'required' => false,
					'type' => 'ItemType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				)
			));

	}
}
?>
