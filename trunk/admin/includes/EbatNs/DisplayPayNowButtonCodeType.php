<?php
// autogenerated file 17.11.2006 13:29
// $Id: DisplayPayNowButtonCodeType.php,v 1.1.1.1 2006/12/22 14:37:28 gswkaiser Exp $
// $Log: DisplayPayNowButtonCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:28  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class DisplayPayNowButtonCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $ShowPayNowButtonForAllPaymentMethods
	var $ShowPayNowButtonForAllPaymentMethods = 'ShowPayNowButtonForAllPaymentMethods';
	// @var string $ShowPayNowButtonForPayPalOnly
	var $ShowPayNowButtonForPayPalOnly = 'ShowPayNowButtonForPayPalOnly';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function DisplayPayNowButtonCodeType()
	{
		$this->EbatNs_FacetType('DisplayPayNowButtonCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_DisplayPayNowButtonCodeType = new DisplayPayNowButtonCodeType();

?>