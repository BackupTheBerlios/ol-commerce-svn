<?php
// autogenerated file 17.11.2006 13:29
// $Id: SKUType.php,v 1.1.1.1 2006/12/22 14:38:48 gswkaiser Exp $
// $Log: SKUType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:48  gswkaiser
// no message
//
//
require_once 'EbatNs_SimpleType.php';

class SKUType extends EbatNs_SimpleType
{
	// start props
	// end props

/**
 *

 * @return 
 */
	function SKUType()
	{
		$this->EbatNs_SimpleType('SKUType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_SKUType = new SKUType();

?>
