<?php
// autogenerated file 17.11.2006 13:29
// $Id: DisputeMessageSourceCodeType.php,v 1.1.1.1 2006/12/22 14:37:28 gswkaiser Exp $
// $Log: DisputeMessageSourceCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:28  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class DisputeMessageSourceCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $Buyer
	var $Buyer = 'Buyer';
	// @var string $Seller
	var $Seller = 'Seller';
	// @var string $eBay
	var $eBay = 'eBay';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function DisputeMessageSourceCodeType()
	{
		$this->EbatNs_FacetType('DisputeMessageSourceCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_DisputeMessageSourceCodeType = new DisputeMessageSourceCodeType();

?>