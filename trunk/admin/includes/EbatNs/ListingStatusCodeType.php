<?php
// autogenerated file 17.11.2006 13:29
// $Id: ListingStatusCodeType.php,v 1.1.1.1 2006/12/22 14:38:17 gswkaiser Exp $
// $Log: ListingStatusCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:17  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class ListingStatusCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $Active
	var $Active = 'Active';
	// @var string $Ended
	var $Ended = 'Ended';
	// @var string $Completed
	var $Completed = 'Completed';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// @var string $Custom
	var $Custom = 'Custom';
	// end props

/**
 *

 * @return 
 */
	function ListingStatusCodeType()
	{
		$this->EbatNs_FacetType('ListingStatusCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_ListingStatusCodeType = new ListingStatusCodeType();

?>
