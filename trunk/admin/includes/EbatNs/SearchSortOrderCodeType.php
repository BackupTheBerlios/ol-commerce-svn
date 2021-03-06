<?php
// autogenerated file 17.11.2006 13:29
// $Id: SearchSortOrderCodeType.php,v 1.1.1.1 2006/12/22 14:38:36 gswkaiser Exp $
// $Log: SearchSortOrderCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:36  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class SearchSortOrderCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $SortByEndDate
	var $SortByEndDate = 'SortByEndDate';
	// @var string $SortByStartDate
	var $SortByStartDate = 'SortByStartDate';
	// @var string $SortByCurrentBid
	var $SortByCurrentBid = 'SortByCurrentBid';
	// @var string $SortByListingDate
	var $SortByListingDate = 'SortByListingDate';
	// @var string $SortByCurrentBidAsc
	var $SortByCurrentBidAsc = 'SortByCurrentBidAsc';
	// @var string $SortByCurrentBidDesc
	var $SortByCurrentBidDesc = 'SortByCurrentBidDesc';
	// @var string $SortByPayPalAsc
	var $SortByPayPalAsc = 'SortByPayPalAsc';
	// @var string $SortByPayPalDesc
	var $SortByPayPalDesc = 'SortByPayPalDesc';
	// @var string $SortByEscrowAsc
	var $SortByEscrowAsc = 'SortByEscrowAsc';
	// @var string $SortByEscrowDesc
	var $SortByEscrowDesc = 'SortByEscrowDesc';
	// @var string $SortByCountryAsc
	var $SortByCountryAsc = 'SortByCountryAsc';
	// @var string $SortByCountryDesc
	var $SortByCountryDesc = 'SortByCountryDesc';
	// @var string $SortByDistanceAsc
	var $SortByDistanceAsc = 'SortByDistanceAsc';
	// @var string $SortByBidCountAsc
	var $SortByBidCountAsc = 'SortByBidCountAsc';
	// @var string $SortByBidCountDesc
	var $SortByBidCountDesc = 'SortByBidCountDesc';
	// @var string $BestMatchSort
	var $BestMatchSort = 'BestMatchSort';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function SearchSortOrderCodeType()
	{
		$this->EbatNs_FacetType('SearchSortOrderCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_SearchSortOrderCodeType = new SearchSortOrderCodeType();

?>
