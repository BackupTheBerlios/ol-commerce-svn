<?php
// autogenerated file 17.11.2006 13:29
// $Id: MerchDisplayCodeType.php,v 1.1.1.1 2006/12/22 14:38:20 gswkaiser Exp $
// $Log: MerchDisplayCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:20  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class MerchDisplayCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $DefaultTheme
	var $DefaultTheme = 'DefaultTheme';
	// @var string $StoreTheme
	var $StoreTheme = 'StoreTheme';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function MerchDisplayCodeType()
	{
		$this->EbatNs_FacetType('MerchDisplayCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_MerchDisplayCodeType = new MerchDisplayCodeType();

?>
