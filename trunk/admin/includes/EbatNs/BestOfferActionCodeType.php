<?php
// autogenerated file 17.11.2006 13:29
// $Id: BestOfferActionCodeType.php,v 1.1.1.1 2006/12/22 14:37:18 gswkaiser Exp $
// $Log: BestOfferActionCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:18  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class BestOfferActionCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $Accept
	var $Accept = 'Accept';
	// @var string $Decline
	var $Decline = 'Decline';
	// @var string $Counter
	var $Counter = 'Counter';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function BestOfferActionCodeType()
	{
		$this->EbatNs_FacetType('BestOfferActionCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_BestOfferActionCodeType = new BestOfferActionCodeType();

?>
