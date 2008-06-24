<?php
// autogenerated file 17.11.2006 13:29
// $Id: AddressRecordTypeCodeType.php,v 1.1.1.1 2006/12/22 14:37:14 gswkaiser Exp $
// $Log: AddressRecordTypeCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:14  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class AddressRecordTypeCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $Residential
	var $Residential = 'Residential';
	// @var string $Business
	var $Business = 'Business';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function AddressRecordTypeCodeType()
	{
		$this->EbatNs_FacetType('AddressRecordTypeCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_AddressRecordTypeCodeType = new AddressRecordTypeCodeType();

?>
