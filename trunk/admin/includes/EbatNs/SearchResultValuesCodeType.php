<?php
// autogenerated file 17.11.2006 13:29
// $Id: SearchResultValuesCodeType.php,v 1.1.1.1 2006/12/22 14:38:36 gswkaiser Exp $
// $Log: SearchResultValuesCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:36  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class SearchResultValuesCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $Escrow
	var $Escrow = 'Escrow';
	// @var string $New
	var $New = 'New';
	// @var string $CharityListing
	var $CharityListing = 'CharityListing';
	// @var string $Picture
	var $Picture = 'Picture';
	// @var string $Gift
	var $Gift = 'Gift';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function SearchResultValuesCodeType()
	{
		$this->EbatNs_FacetType('SearchResultValuesCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_SearchResultValuesCodeType = new SearchResultValuesCodeType();

?>
