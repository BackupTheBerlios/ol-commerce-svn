<?php
// autogenerated file 17.11.2006 13:29
// $Id: RangeCodeType.php,v 1.1.1.1 2006/12/22 14:38:32 gswkaiser Exp $
// $Log: RangeCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:32  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class RangeCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $High
	var $High = 'High';
	// @var string $Low
	var $Low = 'Low';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function RangeCodeType()
	{
		$this->EbatNs_FacetType('RangeCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_RangeCodeType = new RangeCodeType();

?>
