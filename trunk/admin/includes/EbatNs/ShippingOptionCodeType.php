<?php
// autogenerated file 17.11.2006 13:29
// $Id: ShippingOptionCodeType.php,v 1.1.1.1 2006/12/22 14:38:43 gswkaiser Exp $
// $Log: ShippingOptionCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:43  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class ShippingOptionCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $SiteOnly
	var $SiteOnly = 'SiteOnly';
	// @var string $WorldWide
	var $WorldWide = 'WorldWide';
	// @var string $SitePlusRegions
	var $SitePlusRegions = 'SitePlusRegions';
	// @var string $WillNotShip
	var $WillNotShip = 'WillNotShip';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function ShippingOptionCodeType()
	{
		$this->EbatNs_FacetType('ShippingOptionCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_ShippingOptionCodeType = new ShippingOptionCodeType();

?>