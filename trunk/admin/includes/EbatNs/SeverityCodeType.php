<?php
// autogenerated file 17.11.2006 13:29
// $Id: SeverityCodeType.php,v 1.1.1.1 2006/12/22 14:38:41 gswkaiser Exp $
// $Log: SeverityCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:41  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class SeverityCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $Warning
	var $Warning = 'Warning';
	// @var string $Error
	var $Error = 'Error';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function SeverityCodeType()
	{
		$this->EbatNs_FacetType('SeverityCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_SeverityCodeType = new SeverityCodeType();

?>