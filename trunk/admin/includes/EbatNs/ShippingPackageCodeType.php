<?php
// autogenerated file 17.11.2006 13:29
// $Id: ShippingPackageCodeType.php,v 1.1.1.1 2006/12/22 14:38:43 gswkaiser Exp $
// $Log: ShippingPackageCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:43  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class ShippingPackageCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $None
	var $None = 'None';
	// @var string $Letter
	var $Letter = 'Letter';
	// @var string $LargeEnvelope
	var $LargeEnvelope = 'LargeEnvelope';
	// @var string $USPSLargePack
	var $USPSLargePack = 'USPSLargePack';
	// @var string $VeryLargePack
	var $VeryLargePack = 'VeryLargePack';
	// @var string $ExtraLargePack
	var $ExtraLargePack = 'ExtraLargePack';
	// @var string $UPSLetter
	var $UPSLetter = 'UPSLetter';
	// @var string $USPSFlatRateEnvelope
	var $USPSFlatRateEnvelope = 'USPSFlatRateEnvelope';
	// @var string $PackageThickEnvelope
	var $PackageThickEnvelope = 'PackageThickEnvelope';
	// @var string $Roll
	var $Roll = 'Roll';
	// @var string $Europallet
	var $Europallet = 'Europallet';
	// @var string $OneWayPallet
	var $OneWayPallet = 'OneWayPallet';
	// @var string $BulkyGoods
	var $BulkyGoods = 'BulkyGoods';
	// @var string $Furniture
	var $Furniture = 'Furniture';
	// @var string $Cars
	var $Cars = 'Cars';
	// @var string $Motorbikes
	var $Motorbikes = 'Motorbikes';
	// @var string $Caravan
	var $Caravan = 'Caravan';
	// @var string $IndustryVehicles
	var $IndustryVehicles = 'IndustryVehicles';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function ShippingPackageCodeType()
	{
		$this->EbatNs_FacetType('ShippingPackageCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_ShippingPackageCodeType = new ShippingPackageCodeType();

?>
