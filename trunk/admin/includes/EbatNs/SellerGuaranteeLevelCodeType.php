<?php
// autogenerated file 17.11.2006 13:29
// $Id: SellerGuaranteeLevelCodeType.php,v 1.1.1.1 2006/12/22 14:38:37 gswkaiser Exp $
// $Log: SellerGuaranteeLevelCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:37  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class SellerGuaranteeLevelCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $NotEligible
	var $NotEligible = 'NotEligible';
	// @var string $Regular
	var $Regular = 'Regular';
	// @var string $Premium
	var $Premium = 'Premium';
	// @var string $Ultra
	var $Ultra = 'Ultra';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function SellerGuaranteeLevelCodeType()
	{
		$this->EbatNs_FacetType('SellerGuaranteeLevelCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_SellerGuaranteeLevelCodeType = new SellerGuaranteeLevelCodeType();

?>
