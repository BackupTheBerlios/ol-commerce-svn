<?php
// autogenerated file 17.11.2006 13:29
// $Id: BidActionCodeType.php,v 1.1.1.1 2006/12/22 14:37:19 gswkaiser Exp $
// $Log: BidActionCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:19  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class BidActionCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $Unknown
	var $Unknown = 'Unknown';
	// @var string $Bid
	var $Bid = 'Bid';
	// @var string $NotUsed
	var $NotUsed = 'NotUsed';
	// @var string $Retraction
	var $Retraction = 'Retraction';
	// @var string $AutoRetraction
	var $AutoRetraction = 'AutoRetraction';
	// @var string $Cancelled
	var $Cancelled = 'Cancelled';
	// @var string $AutoCancel
	var $AutoCancel = 'AutoCancel';
	// @var string $Absentee
	var $Absentee = 'Absentee';
	// @var string $BuyItNow
	var $BuyItNow = 'BuyItNow';
	// @var string $Purchase
	var $Purchase = 'Purchase';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function BidActionCodeType()
	{
		$this->EbatNs_FacetType('BidActionCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_BidActionCodeType = new BidActionCodeType();

?>
