<?php
// autogenerated file 17.11.2006 13:29
// $Id: SearchTypeCodeType.php,v 1.1.1.1 2006/12/22 14:38:36 gswkaiser Exp $
// $Log: SearchTypeCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:36  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class SearchTypeCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $All
	var $All = 'All';
	// @var string $Gallery
	var $Gallery = 'Gallery';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function SearchTypeCodeType()
	{
		$this->EbatNs_FacetType('SearchTypeCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_SearchTypeCodeType = new SearchTypeCodeType();

?>
