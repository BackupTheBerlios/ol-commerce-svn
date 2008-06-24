<?php
// autogenerated file 17.11.2006 13:30
// $Id: UnitCodeType.php,v 1.1.1.1 2006/12/22 14:38:54 gswkaiser Exp $
// $Log: UnitCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:54  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class UnitCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $kg
	var $kg = 'kg';
	// @var string $lbs
	var $lbs = 'lbs';
	// @var string $oz
	var $oz = 'oz';
	// @var string $cm
	var $cm = 'cm';
	// @var string $inches
	var $inches = 'inches';
	// @var string $ft
	var $ft = 'ft';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function UnitCodeType()
	{
		$this->EbatNs_FacetType('UnitCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_UnitCodeType = new UnitCodeType();

?>