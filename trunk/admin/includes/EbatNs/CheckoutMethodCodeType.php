<?php
// autogenerated file 17.11.2006 13:29
// $Id: CheckoutMethodCodeType.php,v 1.1.1.1 2006/12/22 14:37:24 gswkaiser Exp $
// $Log: CheckoutMethodCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:24  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class CheckoutMethodCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $Other
	var $Other = 'Other';
	// @var string $ThirdPartyCheckout
	var $ThirdPartyCheckout = 'ThirdPartyCheckout';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function CheckoutMethodCodeType()
	{
		$this->EbatNs_FacetType('CheckoutMethodCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_CheckoutMethodCodeType = new CheckoutMethodCodeType();

?>