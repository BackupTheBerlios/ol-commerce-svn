<?php
// autogenerated file 17.11.2006 13:29
// $Id: FlatRateInsuranceRangeCodeType.php,v 1.1.1.1 2006/12/22 14:37:50 gswkaiser Exp $
// $Log: FlatRateInsuranceRangeCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:50  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class FlatRateInsuranceRangeCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $FlatRateInsuranceRange1
	var $FlatRateInsuranceRange1 = 'FlatRateInsuranceRange1';
	// @var string $FlatRateInsuranceRange2
	var $FlatRateInsuranceRange2 = 'FlatRateInsuranceRange2';
	// @var string $FlatRateInsuranceRange3
	var $FlatRateInsuranceRange3 = 'FlatRateInsuranceRange3';
	// @var string $FlatRateInsuranceRange4
	var $FlatRateInsuranceRange4 = 'FlatRateInsuranceRange4';
	// @var string $FlatRateInsuranceRange5
	var $FlatRateInsuranceRange5 = 'FlatRateInsuranceRange5';
	// @var string $FlatRateInsuranceRange6
	var $FlatRateInsuranceRange6 = 'FlatRateInsuranceRange6';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function FlatRateInsuranceRangeCodeType()
	{
		$this->EbatNs_FacetType('FlatRateInsuranceRangeCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_FlatRateInsuranceRangeCodeType = new FlatRateInsuranceRangeCodeType();

?>
