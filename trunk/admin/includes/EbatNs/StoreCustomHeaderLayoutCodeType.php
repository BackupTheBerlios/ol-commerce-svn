<?php
// autogenerated file 17.11.2006 13:29
// $Id: StoreCustomHeaderLayoutCodeType.php,v 1.1.1.1 2006/12/22 14:38:49 gswkaiser Exp $
// $Log: StoreCustomHeaderLayoutCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:49  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class StoreCustomHeaderLayoutCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $NoHeader
	var $NoHeader = 'NoHeader';
	// @var string $CustomHeaderShown
	var $CustomHeaderShown = 'CustomHeaderShown';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function StoreCustomHeaderLayoutCodeType()
	{
		$this->EbatNs_FacetType('StoreCustomHeaderLayoutCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_StoreCustomHeaderLayoutCodeType = new StoreCustomHeaderLayoutCodeType();

?>