<?php
// autogenerated file 17.11.2006 13:29
// $Id: PictureManagerActionCodeType.php,v 1.1.1.1 2006/12/22 14:38:27 gswkaiser Exp $
// $Log: PictureManagerActionCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:27  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class PictureManagerActionCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $Add
	var $Add = 'Add';
	// @var string $Delete
	var $Delete = 'Delete';
	// @var string $Rename
	var $Rename = 'Rename';
	// @var string $Move
	var $Move = 'Move';
	// @var string $Change
	var $Change = 'Change';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function PictureManagerActionCodeType()
	{
		$this->EbatNs_FacetType('PictureManagerActionCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_PictureManagerActionCodeType = new PictureManagerActionCodeType();

?>