<?php
// autogenerated file 17.11.2006 13:29
// $Id: WarningLevelCodeType.php,v 1.1.1.1 2006/12/22 14:38:58 gswkaiser Exp $
// $Log: WarningLevelCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:58  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class WarningLevelCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $Low
	var $Low = 'Low';
	// @var string $High
	var $High = 'High';
	// end props

/**
 *

 * @return 
 */
	function WarningLevelCodeType()
	{
		$this->EbatNs_FacetType('WarningLevelCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_WarningLevelCodeType = new WarningLevelCodeType();

?>