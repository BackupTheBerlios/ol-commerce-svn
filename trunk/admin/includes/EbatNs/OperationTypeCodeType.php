<?php
// autogenerated file 17.11.2006 13:29
// $Id: OperationTypeCodeType.php,v 1.1.1.1 2006/12/22 14:38:25 gswkaiser Exp $
// $Log: OperationTypeCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:25  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class OperationTypeCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $ItemRules
	var $ItemRules = 'ItemRules';
	// @var string $ReplaceAllDefaultRules
	var $ReplaceAllDefaultRules = 'ReplaceAllDefaultRules';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function OperationTypeCodeType()
	{
		$this->EbatNs_FacetType('OperationTypeCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_OperationTypeCodeType = new OperationTypeCodeType();

?>