<?php
// autogenerated file 17.11.2006 13:29
// $Id: StoreItemListSortOrderCodeType.php,v 1.1.1.1 2006/12/22 14:38:50 gswkaiser Exp $
// $Log: StoreItemListSortOrderCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:50  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class StoreItemListSortOrderCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $EndingFirst
	var $EndingFirst = 'EndingFirst';
	// @var string $NewlyListed
	var $NewlyListed = 'NewlyListed';
	// @var string $LowestPriced
	var $LowestPriced = 'LowestPriced';
	// @var string $HighestPriced
	var $HighestPriced = 'HighestPriced';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function StoreItemListSortOrderCodeType()
	{
		$this->EbatNs_FacetType('StoreItemListSortOrderCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_StoreItemListSortOrderCodeType = new StoreItemListSortOrderCodeType();

?>
