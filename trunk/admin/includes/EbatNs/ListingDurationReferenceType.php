<?php
// autogenerated file 17.11.2006 13:29
// $Id: ListingDurationReferenceType.php,v 1.1.1.1 2006/12/22 14:38:17 gswkaiser Exp $
// $Log: ListingDurationReferenceType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:17  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';

class ListingDurationReferenceType extends EbatNs_ComplexType
{
	// start props
	// end props

/**
 *

 * @return 
 */
	function ListingDurationReferenceType()
	{
		$this->EbatNs_ComplexType('ListingDurationReferenceType', 'urn:ebay:apis:eBLBaseComponents');
	$this->_attributes = array_merge($this->_attributes,
		array(
			'type' =>
			array(
				'name' => 'type',
				'type' => 'ListingTypeCodeType',
				'use' => 'required'
			)
		));

	}
}
?>