<?php
// autogenerated file 17.11.2006 13:29
// $Id: StoreSubscriptionLevelCodeType.php,v 1.1.1.1 2006/12/22 14:38:50 gswkaiser Exp $
// $Log: StoreSubscriptionLevelCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:50  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class StoreSubscriptionLevelCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $Close
	var $Close = 'Close';
	// @var string $Basic
	var $Basic = 'Basic';
	// @var string $Featured
	var $Featured = 'Featured';
	// @var string $Anchor
	var $Anchor = 'Anchor';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function StoreSubscriptionLevelCodeType()
	{
		$this->EbatNs_FacetType('StoreSubscriptionLevelCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_StoreSubscriptionLevelCodeType = new StoreSubscriptionLevelCodeType();

?>
