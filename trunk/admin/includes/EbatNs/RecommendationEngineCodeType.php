<?php
// autogenerated file 17.11.2006 13:29
// $Id: RecommendationEngineCodeType.php,v 1.1.1.1 2006/12/22 14:38:32 gswkaiser Exp $
// $Log: RecommendationEngineCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:32  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class RecommendationEngineCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $ListingAnalyzer
	var $ListingAnalyzer = 'ListingAnalyzer';
	// @var string $SIFFTAS
	var $SIFFTAS = 'SIFFTAS';
	// @var string $ProductPricing
	var $ProductPricing = 'ProductPricing';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// @var string $SuggestedAttributes
	var $SuggestedAttributes = 'SuggestedAttributes';
	// end props

/**
 *

 * @return 
 */
	function RecommendationEngineCodeType()
	{
		$this->EbatNs_FacetType('RecommendationEngineCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_RecommendationEngineCodeType = new RecommendationEngineCodeType();

?>