<?php
// autogenerated file 17.11.2006 13:29
// $Id: DateSpecifierCodeType.php,v 1.1.1.1 2006/12/22 14:37:27 gswkaiser Exp $
// $Log: DateSpecifierCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:27  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class DateSpecifierCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $M
	var $M = 'M';
	// @var string $D
	var $D = 'D';
	// @var string $Y
	var $Y = 'Y';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function DateSpecifierCodeType()
	{
		$this->EbatNs_FacetType('DateSpecifierCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_DateSpecifierCodeType = new DateSpecifierCodeType();

?>
