<?php
// autogenerated file 17.11.2006 13:29
// $Id: ExpressSellerRequirementsType.php,v 1.1.1.1 2006/12/22 14:37:46 gswkaiser Exp $
// $Log: ExpressSellerRequirementsType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:46  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'FeedbackRequirementsType.php';

class ExpressSellerRequirementsType extends EbatNs_ComplexType
{
	// start props
	// @var boolean $ExpressSellingPreference
	var $ExpressSellingPreference;
	// @var boolean $ExpressApproved
	var $ExpressApproved;
	// @var boolean $GoodStanding
	var $GoodStanding;
	// @var FeedbackRequirementsType $FeedbackScore
	var $FeedbackScore;
	// @var FeedbackRequirementsType $PositiveFeedbackPercent
	var $PositiveFeedbackPercent;
	// @var FeedbackRequirementsType $FeedbackAsSellerScore
	var $FeedbackAsSellerScore;
	// @var FeedbackRequirementsType $PositiveFeedbackAsSellerPercent
	var $PositiveFeedbackAsSellerPercent;
	// @var boolean $BusinessSeller
	var $BusinessSeller;
	// @var boolean $EligiblePayPalAccount
	var $EligiblePayPalAccount;
	// @var boolean $PayPalAccountAcceptsUnconfirmedAddress
	var $PayPalAccountAcceptsUnconfirmedAddress;
	// @var boolean $CombinedPaymentsAccepted
	var $CombinedPaymentsAccepted;
	// @var boolean $FeedbackPublic
	var $FeedbackPublic;
	// end props

/**
 *

 * @return boolean
 */
	function getExpressSellingPreference()
	{
		return $this->ExpressSellingPreference;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setExpressSellingPreference($value)
	{
		$this->ExpressSellingPreference = $value;
	}
/**
 *

 * @return boolean
 */
	function getExpressApproved()
	{
		return $this->ExpressApproved;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setExpressApproved($value)
	{
		$this->ExpressApproved = $value;
	}
/**
 *

 * @return boolean
 */
	function getGoodStanding()
	{
		return $this->GoodStanding;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setGoodStanding($value)
	{
		$this->GoodStanding = $value;
	}
/**
 *

 * @return FeedbackRequirementsType
 */
	function getFeedbackScore()
	{
		return $this->FeedbackScore;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setFeedbackScore($value)
	{
		$this->FeedbackScore = $value;
	}
/**
 *

 * @return FeedbackRequirementsType
 */
	function getPositiveFeedbackPercent()
	{
		return $this->PositiveFeedbackPercent;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setPositiveFeedbackPercent($value)
	{
		$this->PositiveFeedbackPercent = $value;
	}
/**
 *

 * @return FeedbackRequirementsType
 */
	function getFeedbackAsSellerScore()
	{
		return $this->FeedbackAsSellerScore;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setFeedbackAsSellerScore($value)
	{
		$this->FeedbackAsSellerScore = $value;
	}
/**
 *

 * @return FeedbackRequirementsType
 */
	function getPositiveFeedbackAsSellerPercent()
	{
		return $this->PositiveFeedbackAsSellerPercent;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setPositiveFeedbackAsSellerPercent($value)
	{
		$this->PositiveFeedbackAsSellerPercent = $value;
	}
/**
 *

 * @return boolean
 */
	function getBusinessSeller()
	{
		return $this->BusinessSeller;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setBusinessSeller($value)
	{
		$this->BusinessSeller = $value;
	}
/**
 *

 * @return boolean
 */
	function getEligiblePayPalAccount()
	{
		return $this->EligiblePayPalAccount;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setEligiblePayPalAccount($value)
	{
		$this->EligiblePayPalAccount = $value;
	}
/**
 *

 * @return boolean
 */
	function getPayPalAccountAcceptsUnconfirmedAddress()
	{
		return $this->PayPalAccountAcceptsUnconfirmedAddress;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setPayPalAccountAcceptsUnconfirmedAddress($value)
	{
		$this->PayPalAccountAcceptsUnconfirmedAddress = $value;
	}
/**
 *

 * @return boolean
 */
	function getCombinedPaymentsAccepted()
	{
		return $this->CombinedPaymentsAccepted;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCombinedPaymentsAccepted($value)
	{
		$this->CombinedPaymentsAccepted = $value;
	}
/**
 *

 * @return boolean
 */
	function getFeedbackPublic()
	{
		return $this->FeedbackPublic;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setFeedbackPublic($value)
	{
		$this->FeedbackPublic = $value;
	}
/**
 *

 * @return 
 */
	function ExpressSellerRequirementsType()
	{
		$this->EbatNs_ComplexType('ExpressSellerRequirementsType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'ExpressSellingPreference' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ExpressApproved' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'GoodStanding' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'FeedbackScore' =>
				array(
					'required' => false,
					'type' => 'FeedbackRequirementsType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'PositiveFeedbackPercent' =>
				array(
					'required' => false,
					'type' => 'FeedbackRequirementsType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'FeedbackAsSellerScore' =>
				array(
					'required' => false,
					'type' => 'FeedbackRequirementsType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'PositiveFeedbackAsSellerPercent' =>
				array(
					'required' => false,
					'type' => 'FeedbackRequirementsType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'BusinessSeller' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'EligiblePayPalAccount' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'PayPalAccountAcceptsUnconfirmedAddress' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'CombinedPaymentsAccepted' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'FeedbackPublic' =>
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