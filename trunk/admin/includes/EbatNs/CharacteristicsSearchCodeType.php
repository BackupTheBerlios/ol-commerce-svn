<?php
// autogenerated file 17.11.2006 13:29
// $Id: CharacteristicsSearchCodeType.php,v 1.1.1.1 2006/12/22 14:37:23 gswkaiser Exp $
// $Log: CharacteristicsSearchCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:23  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class CharacteristicsSearchCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $Single
	var $Single = 'Single';
	// @var string $Multi
	var $Multi = 'Multi';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function CharacteristicsSearchCodeType()
	{
		$this->EbatNs_FacetType('CharacteristicsSearchCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_CharacteristicsSearchCodeType = new CharacteristicsSearchCodeType();

?>
