<?php
// autogenerated file 17.11.2006 13:29
// $Id: ErrorClassificationCodeType.php,v 1.1.1.1 2006/12/22 14:37:44 gswkaiser Exp $
// $Log: ErrorClassificationCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:44  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class ErrorClassificationCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $RequestError
	var $RequestError = 'RequestError';
	// @var string $SystemError
	var $SystemError = 'SystemError';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function ErrorClassificationCodeType()
	{
		$this->EbatNs_FacetType('ErrorClassificationCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_ErrorClassificationCodeType = new ErrorClassificationCodeType();

?>
