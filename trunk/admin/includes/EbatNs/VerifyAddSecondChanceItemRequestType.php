<?php
// autogenerated file 17.11.2006 13:29
// $Id: VerifyAddSecondChanceItemRequestType.php,v 1.1.1.1 2006/12/22 14:38:57 gswkaiser Exp $
// $Log: VerifyAddSecondChanceItemRequestType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:57  gswkaiser
// no message
//
//
require_once 'UserIDType.php';
require_once 'SiteCodeType.php';
require_once 'SecondChanceOfferDurationCodeType.php';
require_once 'AmountType.php';
require_once 'AbstractRequestType.php';
require_once 'ItemIDType.php';

class VerifyAddSecondChanceItemRequestType extends AbstractRequestType
{
	// start props
	// @var UserIDType $RecipientBidderUserID
	var $RecipientBidderUserID;
	// @var AmountType $BuyItNowPrice
	var $BuyItNowPrice;
	// @var boolean $CopyEmailToSeller
	var $CopyEmailToSeller;
	// @var SecondChanceOfferDurationCodeType $Duration
	var $Duration;
	// @var ItemIDType $ItemID
	var $ItemID;
	// @var SiteCodeType $Site
	var $Site;
	// @var string $SellerMessage
	var $SellerMessage;
	// end props

/**
 *

 * @return UserIDType
 */
	function getRecipientBidderUserID()
	{
		return $this->RecipientBidderUserID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setRecipientBidderUserID($value)
	{
		$this->RecipientBidderUserID = $value;
	}
/**
 *

 * @return AmountType
 */
	function getBuyItNowPrice()
	{
		return $this->BuyItNowPrice;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setBuyItNowPrice($value)
	{
		$this->BuyItNowPrice = $value;
	}
/**
 *

 * @return boolean
 */
	function getCopyEmailToSeller()
	{
		return $this->CopyEmailToSeller;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCopyEmailToSeller($value)
	{
		$this->CopyEmailToSeller = $value;
	}
/**
 *

 * @return SecondChanceOfferDurationCodeType
 */
	function getDuration()
	{
		return $this->Duration;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setDuration($value)
	{
		$this->Duration = $value;
	}
/**
 *

 * @return ItemIDType
 */
	function getItemID()
	{
		return $this->ItemID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setItemID($value)
	{
		$this->ItemID = $value;
	}
/**
 *

 * @return SiteCodeType
 */
	function getSite()
	{
		return $this->Site;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setSite($value)
	{
		$this->Site = $value;
	}
/**
 *

 * @return string
 */
	function getSellerMessage()
	{
		return $this->SellerMessage;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setSellerMessage($value)
	{
		$this->SellerMessage = $value;
	}
/**
 *

 * @return 
 */
	function VerifyAddSecondChanceItemRequestType()
	{
		$this->AbstractRequestType('VerifyAddSecondChanceItemRequestType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'RecipientBidderUserID' =>
				array(
					'required' => false,
					'type' => 'UserIDType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'BuyItNowPrice' =>
				array(
					'required' => false,
					'type' => 'AmountType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'CopyEmailToSeller' =>
				array(
					'required' => true,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '1..1'
				),
				'Duration' =>
				array(
					'required' => false,
					'type' => 'SecondChanceOfferDurationCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ItemID' =>
				array(
					'required' => false,
					'type' => 'ItemIDType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Site' =>
				array(
					'required' => false,
					'type' => 'SiteCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'SellerMessage' =>
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
