<?php
// autogenerated file 17.11.2006 13:29
// $Id: ModifyActionCodeType.php,v 1.1.1.1 2006/12/22 14:38:20 gswkaiser Exp $
// $Log: ModifyActionCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:20  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class ModifyActionCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $Add
	var $Add = 'Add';
	// @var string $Delete
	var $Delete = 'Delete';
	// @var string $Update
	var $Update = 'Update';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function ModifyActionCodeType()
	{
		$this->EbatNs_FacetType('ModifyActionCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_ModifyActionCodeType = new ModifyActionCodeType();

?>
