<?php
// autogenerated file 17.11.2006 13:29
// $Id: ShippingCarrierCodeType.php,v 1.1.1.1 2006/12/22 14:38:42 gswkaiser Exp $
// $Log: ShippingCarrierCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:42  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class ShippingCarrierCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $UPS
	var $UPS = 'UPS';
	// @var string $USPS
	var $USPS = 'USPS';
	// @var string $DeutschePost
	var $DeutschePost = 'DeutschePost';
	// @var string $DHL
	var $DHL = 'DHL';
	// @var string $Hermes
	var $Hermes = 'Hermes';
	// @var string $iLoxx
	var $iLoxx = 'iLoxx';
	// @var string $Other
	var $Other = 'Other';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function ShippingCarrierCodeType()
	{
		$this->EbatNs_FacetType('ShippingCarrierCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_ShippingCarrierCodeType = new ShippingCarrierCodeType();

?>
