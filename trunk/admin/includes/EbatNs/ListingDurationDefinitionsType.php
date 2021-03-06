<?php
// autogenerated file 17.11.2006 13:29
// $Id: ListingDurationDefinitionsType.php,v 1.1.1.1 2006/12/22 14:38:17 gswkaiser Exp $
// $Log: ListingDurationDefinitionsType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:17  gswkaiser
// no message
//
//
require_once 'ListingDurationDefinitionType.php';
require_once 'EbatNs_ComplexType.php';

class ListingDurationDefinitionsType extends EbatNs_ComplexType
{
	// start props
	// @var ListingDurationDefinitionType $ListingDuration
	var $ListingDuration;
	// end props

/**
 *

 * @return ListingDurationDefinitionType
 * @param  $index 
 */
	function getListingDuration($index = null)
	{
		if ($index) {
		return $this->ListingDuration[$index];
	} else {
		return $this->ListingDuration;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setListingDuration($value, $index = null)
	{
		if ($index) {
	$this->ListingDuration[$index] = $value;
	} else {
	$this->ListingDuration = $value;
	}

	}
/**
 *

 * @return 
 */
	function ListingDurationDefinitionsType()
	{
		$this->EbatNs_ComplexType('ListingDurationDefinitionsType', 'http://www.w3.org/2001/XMLSchema');
		$this->_elements = array_merge($this->_elements,
			array(
				'ListingDuration' =>
				array(
					'required' => false,
					'type' => 'ListingDurationDefinitionType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				)
			));
	$this->_attributes = array_merge($this->_attributes,
		array(
			'Version' =>
			array(
				'name' => 'Version',
				'type' => 'int',
				'use' => 'required'
			)
		));

	}
}
?>
