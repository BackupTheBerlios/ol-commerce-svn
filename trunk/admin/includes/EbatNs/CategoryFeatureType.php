<?php
// autogenerated file 17.11.2006 13:29
// $Id: CategoryFeatureType.php,v 1.1.1.1 2006/12/22 14:37:22 gswkaiser Exp $
// $Log: CategoryFeatureType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:22  gswkaiser
// no message
//
//
require_once 'DigitalDeliveryEnabledCodeType.php';
require_once 'AdFormatEnabledCodeType.php';
require_once 'EbatNs_ComplexType.php';
require_once 'ListingDurationReferenceType.php';

class CategoryFeatureType extends EbatNs_ComplexType
{
	// start props
	// @var string $CategoryID
	var $CategoryID;
	// @var ListingDurationReferenceType $ListingDuration
	var $ListingDuration;
	// @var boolean $ShippingTermsRequired
	var $ShippingTermsRequired;
	// @var boolean $BestOfferEnabled
	var $BestOfferEnabled;
	// @var boolean $DutchBINEnabled
	var $DutchBINEnabled;
	// @var boolean $UserConsentRequired
	var $UserConsentRequired;
	// @var boolean $HomePageFeaturedEnabled
	var $HomePageFeaturedEnabled;
	// @var boolean $ProPackEnabled
	var $ProPackEnabled;
	// @var boolean $BasicUpgradePackEnabled
	var $BasicUpgradePackEnabled;
	// @var boolean $ValuePackEnabled
	var $ValuePackEnabled;
	// @var boolean $ProPackPlusEnabled
	var $ProPackPlusEnabled;
	// @var AdFormatEnabledCodeType $AdFormatEnabled
	var $AdFormatEnabled;
	// @var DigitalDeliveryEnabledCodeType $DigitalDeliveryEnabled
	var $DigitalDeliveryEnabled;
	// @var boolean $BestOfferCounterEnabled
	var $BestOfferCounterEnabled;
	// @var boolean $BestOfferAutoDeclineEnabled
	var $BestOfferAutoDeclineEnabled;
	// @var boolean $LocalMarketSpecialitySubscription
	var $LocalMarketSpecialitySubscription;
	// @var boolean $LocalMarketRegularSubscription
	var $LocalMarketRegularSubscription;
	// @var boolean $LocalMarketPremiumSubscription
	var $LocalMarketPremiumSubscription;
	// @var boolean $LocalMarketNonSubscription
	var $LocalMarketNonSubscription;
	// @var boolean $ExpressEnabled
	var $ExpressEnabled;
	// @var boolean $ExpressPicturesRequired
	var $ExpressPicturesRequired;
	// @var boolean $ExpressConditionRequired
	var $ExpressConditionRequired;
	// @var double $MinimumReservePrice
	var $MinimumReservePrice;
	// @var boolean $SellerContactDetailsEnabled
	var $SellerContactDetailsEnabled;
	// @var boolean $TransactionConfirmationRequestEnabled
	var $TransactionConfirmationRequestEnabled;
	// @var boolean $StoreInventoryEnabled
	var $StoreInventoryEnabled;
	// @var boolean $SkypeMeTransactionalEnabled
	var $SkypeMeTransactionalEnabled;
	// @var boolean $SkypeMeNonTransactionalEnabled
	var $SkypeMeNonTransactionalEnabled;
	// end props

/**
 *

 * @return string
 */
	function getCategoryID()
	{
		return $this->CategoryID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCategoryID($value)
	{
		$this->CategoryID = $value;
	}
/**
 *

 * @return ListingDurationReferenceType
 * @param  $index 
 */
	function getListingDuration($index = null)
	{
		if ($index) {
		return $this->ListingDuration[$index];
	} else {
		return $this->ListingDuration;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setListingDuration($value, $index = null)
	{
		if ($index) {
	$this->ListingDuration[$index] = $value;
	} else {
	$this->ListingDuration = $value;
	}

	}
/**
 *

 * @return boolean
 */
	function getShippingTermsRequired()
	{
		return $this->ShippingTermsRequired;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setShippingTermsRequired($value)
	{
		$this->ShippingTermsRequired = $value;
	}
/**
 *

 * @return boolean
 */
	function getBestOfferEnabled()
	{
		return $this->BestOfferEnabled;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setBestOfferEnabled($value)
	{
		$this->BestOfferEnabled = $value;
	}
/**
 *

 * @return boolean
 */
	function getDutchBINEnabled()
	{
		return $this->DutchBINEnabled;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setDutchBINEnabled($value)
	{
		$this->DutchBINEnabled = $value;
	}
/**
 *

 * @return boolean
 */
	function getUserConsentRequired()
	{
		return $this->UserConsentRequired;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setUserConsentRequired($value)
	{
		$this->UserConsentRequired = $value;
	}
/**
 *

 * @return boolean
 */
	function getHomePageFeaturedEnabled()
	{
		return $this->HomePageFeaturedEnabled;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setHomePageFeaturedEnabled($value)
	{
		$this->HomePageFeaturedEnabled = $value;
	}
/**
 *

 * @return boolean
 */
	function getProPackEnabled()
	{
		return $this->ProPackEnabled;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setProPackEnabled($value)
	{
		$this->ProPackEnabled = $value;
	}
/**
 *

 * @return boolean
 */
	function getBasicUpgradePackEnabled()
	{
		return $this->BasicUpgradePackEnabled;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setBasicUpgradePackEnabled($value)
	{
		$this->BasicUpgradePackEnabled = $value;
	}
/**
 *

 * @return boolean
 */
	function getValuePackEnabled()
	{
		return $this->ValuePackEnabled;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setValuePackEnabled($value)
	{
		$this->ValuePackEnabled = $value;
	}
/**
 *

 * @return boolean
 */
	function getProPackPlusEnabled()
	{
		return $this->ProPackPlusEnabled;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setProPackPlusEnabled($value)
	{
		$this->ProPackPlusEnabled = $value;
	}
/**
 *

 * @return AdFormatEnabledCodeType
 */
	function getAdFormatEnabled()
	{
		return $this->AdFormatEnabled;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setAdFormatEnabled($value)
	{
		$this->AdFormatEnabled = $value;
	}
/**
 *

 * @return DigitalDeliveryEnabledCodeType
 */
	function getDigitalDeliveryEnabled()
	{
		return $this->DigitalDeliveryEnabled;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setDigitalDeliveryEnabled($value)
	{
		$this->DigitalDeliveryEnabled = $value;
	}
/**
 *

 * @return boolean
 */
	function getBestOfferCounterEnabled()
	{
		return $this->BestOfferCounterEnabled;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setBestOfferCounterEnabled($value)
	{
		$this->BestOfferCounterEnabled = $value;
	}
/**
 *

 * @return boolean
 */
	function getBestOfferAutoDeclineEnabled()
	{
		return $this->BestOfferAutoDeclineEnabled;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setBestOfferAutoDeclineEnabled($value)
	{
		$this->BestOfferAutoDeclineEnabled = $value;
	}
/**
 *

 * @return boolean
 */
	function getLocalMarketSpecialitySubscription()
	{
		return $this->LocalMarketSpecialitySubscription;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setLocalMarketSpecialitySubscription($value)
	{
		$this->LocalMarketSpecialitySubscription = $value;
	}
/**
 *

 * @return boolean
 */
	function getLocalMarketRegularSubscription()
	{
		return $this->LocalMarketRegularSubscription;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setLocalMarketRegularSubscription($value)
	{
		$this->LocalMarketRegularSubscription = $value;
	}
/**
 *

 * @return boolean
 */
	function getLocalMarketPremiumSubscription()
	{
		return $this->LocalMarketPremiumSubscription;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setLocalMarketPremiumSubscription($value)
	{
		$this->LocalMarketPremiumSubscription = $value;
	}
/**
 *

 * @return boolean
 */
	function getLocalMarketNonSubscription()
	{
		return $this->LocalMarketNonSubscription;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setLocalMarketNonSubscription($value)
	{
		$this->LocalMarketNonSubscription = $value;
	}
/**
 *

 * @return boolean
 */
	function getExpressEnabled()
	{
		return $this->ExpressEnabled;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setExpressEnabled($value)
	{
		$this->ExpressEnabled = $value;
	}
/**
 *

 * @return boolean
 */
	function getExpressPicturesRequired()
	{
		return $this->ExpressPicturesRequired;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setExpressPicturesRequired($value)
	{
		$this->ExpressPicturesRequired = $value;
	}
/**
 *

 * @return boolean
 */
	function getExpressConditionRequired()
	{
		return $this->ExpressConditionRequired;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setExpressConditionRequired($value)
	{
		$this->ExpressConditionRequired = $value;
	}
/**
 *

 * @return double
 */
	function getMinimumReservePrice()
	{
		return $this->MinimumReservePrice;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setMinimumReservePrice($value)
	{
		$this->MinimumReservePrice = $value;
	}
/**
 *

 * @return boolean
 */
	function getSellerContactDetailsEnabled()
	{
		return $this->SellerContactDetailsEnabled;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setSellerContactDetailsEnabled($value)
	{
		$this->SellerContactDetailsEnabled = $value;
	}
/**
 *

 * @return boolean
 */
	function getTransactionConfirmationRequestEnabled()
	{
		return $this->TransactionConfirmationRequestEnabled;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setTransactionConfirmationRequestEnabled($value)
	{
		$this->TransactionConfirmationRequestEnabled = $value;
	}
/**
 *

 * @return boolean
 */
	function getStoreInventoryEnabled()
	{
		return $this->StoreInventoryEnabled;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setStoreInventoryEnabled($value)
	{
		$this->StoreInventoryEnabled = $value;
	}
/**
 *

 * @return boolean
 */
	function getSkypeMeTransactionalEnabled()
	{
		return $this->SkypeMeTransactionalEnabled;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setSkypeMeTransactionalEnabled($value)
	{
		$this->SkypeMeTransactionalEnabled = $value;
	}
/**
 *

 * @return boolean
 */
	function getSkypeMeNonTransactionalEnabled()
	{
		return $this->SkypeMeNonTransactionalEnabled;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setSkypeMeNonTransactionalEnabled($value)
	{
		$this->SkypeMeNonTransactionalEnabled = $value;
	}
/**
 *

 * @return 
 */
	function CategoryFeatureType()
	{
		$this->EbatNs_ComplexType('CategoryFeatureType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'CategoryID' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ListingDuration' =>
				array(
					'required' => false,
					'type' => 'ListingDurationReferenceType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				),
				'ShippingTermsRequired' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'BestOfferEnabled' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'DutchBINEnabled' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'UserConsentRequired' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'HomePageFeaturedEnabled' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ProPackEnabled' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'BasicUpgradePackEnabled' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ValuePackEnabled' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ProPackPlusEnabled' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'AdFormatEnabled' =>
				array(
					'required' => false,
					'type' => 'AdFormatEnabledCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'DigitalDeliveryEnabled' =>
				array(
					'required' => false,
					'type' => 'DigitalDeliveryEnabledCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'BestOfferCounterEnabled' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'BestOfferAutoDeclineEnabled' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'LocalMarketSpecialitySubscription' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'LocalMarketRegularSubscription' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'LocalMarketPremiumSubscription' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'LocalMarketNonSubscription' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ExpressEnabled' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ExpressPicturesRequired' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ExpressConditionRequired' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'MinimumReservePrice' =>
				array(
					'required' => false,
					'type' => 'double',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'SellerContactDetailsEnabled' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'TransactionConfirmationRequestEnabled' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'StoreInventoryEnabled' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'SkypeMeTransactionalEnabled' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'SkypeMeNonTransactionalEnabled' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
