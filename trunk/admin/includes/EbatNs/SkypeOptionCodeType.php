<?php
// autogenerated file 17.11.2006 13:29
// $Id: SkypeOptionCodeType.php,v 1.1.1.1 2006/12/22 14:38:48 gswkaiser Exp $
// $Log: SkypeOptionCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:48  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class SkypeOptionCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $None
	var $None = 'None';
	// @var string $Voice
	var $Voice = 'Voice';
	// end props

/**
 *

 * @return 
 */
	function SkypeOptionCodeType()
	{
		$this->EbatNs_FacetType('SkypeOptionCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_SkypeOptionCodeType = new SkypeOptionCodeType();

?>
