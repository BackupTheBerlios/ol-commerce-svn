<?php
// autogenerated file 17.11.2006 13:29
// $Id: AckCodeType.php,v 1.1.1.1 2006/12/22 14:37:12 gswkaiser Exp $
// $Log: AckCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:12  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class AckCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $Success
	var $Success = 'Success';
	// @var string $Failure
	var $Failure = 'Failure';
	// @var string $Warning
	var $Warning = 'Warning';
	// @var string $PartialFailure
	var $PartialFailure = 'PartialFailure';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function AckCodeType()
	{
		$this->EbatNs_FacetType('AckCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_AckCodeType = new AckCodeType();

?>