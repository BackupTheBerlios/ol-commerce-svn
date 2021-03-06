<?php
// autogenerated file 17.11.2006 13:29
// $Id: GetRecommendationsResponseContainerType.php,v 1.1.1.1 2006/12/22 14:38:04 gswkaiser Exp $
// $Log: GetRecommendationsResponseContainerType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:04  gswkaiser
// no message
//
//
require_once 'SIFFTASRecommendationsType.php';
require_once 'EbatNs_ComplexType.php';
require_once 'AttributeRecommendationsType.php';
require_once 'ProductRecommendationsType.php';
require_once 'ListingAnalyzerRecommendationsType.php';
require_once 'PricingRecommendationsType.php';

class GetRecommendationsResponseContainerType extends EbatNs_ComplexType
{
	// start props
	// @var ListingAnalyzerRecommendationsType $ListingAnalyzerRecommendations
	var $ListingAnalyzerRecommendations;
	// @var SIFFTASRecommendationsType $SIFFTASRecommendations
	var $SIFFTASRecommendations;
	// @var PricingRecommendationsType $PricingRecommendations
	var $PricingRecommendations;
	// @var AttributeRecommendationsType $AttributeRecommendations
	var $AttributeRecommendations;
	// @var ProductRecommendationsType $ProductRecommendations
	var $ProductRecommendations;
	// @var string $CorrelationID
	var $CorrelationID;
	// end props

/**
 *

 * @return ListingAnalyzerRecommendationsType
 */
	function getListingAnalyzerRecommendations()
	{
		return $this->ListingAnalyzerRecommendations;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setListingAnalyzerRecommendations($value)
	{
		$this->ListingAnalyzerRecommendations = $value;
	}
/**
 *

 * @return SIFFTASRecommendationsType
 */
	function getSIFFTASRecommendations()
	{
		return $this->SIFFTASRecommendations;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setSIFFTASRecommendations($value)
	{
		$this->SIFFTASRecommendations = $value;
	}
/**
 *

 * @return PricingRecommendationsType
 */
	function getPricingRecommendations()
	{
		return $this->PricingRecommendations;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setPricingRecommendations($value)
	{
		$this->PricingRecommendations = $value;
	}
/**
 *

 * @return AttributeRecommendationsType
 */
	function getAttributeRecommendations()
	{
		return $this->AttributeRecommendations;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setAttributeRecommendations($value)
	{
		$this->AttributeRecommendations = $value;
	}
/**
 *

 * @return ProductRecommendationsType
 */
	function getProductRecommendations()
	{
		return $this->ProductRecommendations;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setProductRecommendations($value)
	{
		$this->ProductRecommendations = $value;
	}
/**
 *

 * @return string
 */
	function getCorrelationID()
	{
		return $this->CorrelationID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCorrelationID($value)
	{
		$this->CorrelationID = $value;
	}
/**
 *

 * @return 
 */
	function GetRecommendationsResponseContainerType()
	{
		$this->EbatNs_ComplexType('GetRecommendationsResponseContainerType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'ListingAnalyzerRecommendations' =>
				array(
					'required' => false,
					'type' => 'ListingAnalyzerRecommendationsType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'SIFFTASRecommendations' =>
				array(
					'required' => false,
					'type' => 'SIFFTASRecommendationsType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'PricingRecommendations' =>
				array(
					'required' => false,
					'type' => 'PricingRecommendationsType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'AttributeRecommendations' =>
				array(
					'required' => false,
					'type' => 'AttributeRecommendationsType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ProductRecommendations' =>
				array(
					'required' => false,
					'type' => 'ProductRecommendationsType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'CorrelationID' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
