<?php
// autogenerated file 17.11.2006 13:29
// $Id: StoreCustomListingHeaderDisplayCodeType.php,v 1.1.1.1 2006/12/22 14:38:49 gswkaiser Exp $
// $Log: StoreCustomListingHeaderDisplayCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:49  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class StoreCustomListingHeaderDisplayCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $None
	var $None = 'None';
	// @var string $Full
	var $Full = 'Full';
	// @var string $FullAndLeftNavigationBar
	var $FullAndLeftNavigationBar = 'FullAndLeftNavigationBar';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function StoreCustomListingHeaderDisplayCodeType()
	{
		$this->EbatNs_FacetType('StoreCustomListingHeaderDisplayCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_StoreCustomListingHeaderDisplayCodeType = new StoreCustomListingHeaderDisplayCodeType();

?>
