<?php
// autogenerated file 17.11.2006 13:29
// $Id: StoreHeaderStyleCodeType.php,v 1.1.1.1 2006/12/22 14:38:50 gswkaiser Exp $
// $Log: StoreHeaderStyleCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:50  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class StoreHeaderStyleCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $Full
	var $Full = 'Full';
	// @var string $Minimized
	var $Minimized = 'Minimized';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function StoreHeaderStyleCodeType()
	{
		$this->EbatNs_FacetType('StoreHeaderStyleCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_StoreHeaderStyleCodeType = new StoreHeaderStyleCodeType();

?>