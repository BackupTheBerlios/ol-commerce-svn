<?php
// autogenerated file 17.11.2006 13:29
// $Id: ItemSortTypeCodeType.php,v 1.1.1.1 2006/12/22 14:38:13 gswkaiser Exp $
// $Log: ItemSortTypeCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:13  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class ItemSortTypeCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $ItemID
	var $ItemID = 'ItemID';
	// @var string $Price
	var $Price = 'Price';
	// @var string $StartPrice
	var $StartPrice = 'StartPrice';
	// @var string $Title
	var $Title = 'Title';
	// @var string $BidCount
	var $BidCount = 'BidCount';
	// @var string $Quantity
	var $Quantity = 'Quantity';
	// @var string $StartTime
	var $StartTime = 'StartTime';
	// @var string $EndTime
	var $EndTime = 'EndTime';
	// @var string $SellerUserID
	var $SellerUserID = 'SellerUserID';
	// @var string $TimeLeft
	var $TimeLeft = 'TimeLeft';
	// @var string $ListingDuration
	var $ListingDuration = 'ListingDuration';
	// @var string $ListingType
	var $ListingType = 'ListingType';
	// @var string $CurrentPrice
	var $CurrentPrice = 'CurrentPrice';
	// @var string $ReservePrice
	var $ReservePrice = 'ReservePrice';
	// @var string $MaxBid
	var $MaxBid = 'MaxBid';
	// @var string $BidderCount
	var $BidderCount = 'BidderCount';
	// @var string $HighBidderUserID
	var $HighBidderUserID = 'HighBidderUserID';
	// @var string $BuyerUserID
	var $BuyerUserID = 'BuyerUserID';
	// @var string $BuyerPostalCode
	var $BuyerPostalCode = 'BuyerPostalCode';
	// @var string $BuyerEmail
	var $BuyerEmail = 'BuyerEmail';
	// @var string $SellerEmail
	var $SellerEmail = 'SellerEmail';
	// @var string $TotalPrice
	var $TotalPrice = 'TotalPrice';
	// @var string $WatchCount
	var $WatchCount = 'WatchCount';
	// @var string $BestOfferCount
	var $BestOfferCount = 'BestOfferCount';
	// @var string $QuestionCount
	var $QuestionCount = 'QuestionCount';
	// @var string $ShippingServiceCost
	var $ShippingServiceCost = 'ShippingServiceCost';
	// @var string $FeedbackReceived
	var $FeedbackReceived = 'FeedbackReceived';
	// @var string $FeedbackLeft
	var $FeedbackLeft = 'FeedbackLeft';
	// @var string $UserID
	var $UserID = 'UserID';
	// @var string $QuantitySold
	var $QuantitySold = 'QuantitySold';
	// @var string $BestOffer
	var $BestOffer = 'BestOffer';
	// @var string $QuantityAvailable
	var $QuantityAvailable = 'QuantityAvailable';
	// @var string $QuantityPurchased
	var $QuantityPurchased = 'QuantityPurchased';
	// @var string $WonPlatform
	var $WonPlatform = 'WonPlatform';
	// @var string $SoldPlatform
	var $SoldPlatform = 'SoldPlatform';
	// @var string $ListingDurationDescending
	var $ListingDurationDescending = 'ListingDurationDescending';
	// @var string $ListingTypeDescending
	var $ListingTypeDescending = 'ListingTypeDescending';
	// @var string $CurrentPriceDescending
	var $CurrentPriceDescending = 'CurrentPriceDescending';
	// @var string $ReservePriceDescending
	var $ReservePriceDescending = 'ReservePriceDescending';
	// @var string $MaxBidDescending
	var $MaxBidDescending = 'MaxBidDescending';
	// @var string $BidderCountDescending
	var $BidderCountDescending = 'BidderCountDescending';
	// @var string $HighBidderUserIDDescending
	var $HighBidderUserIDDescending = 'HighBidderUserIDDescending';
	// @var string $BuyerUserIDDescending
	var $BuyerUserIDDescending = 'BuyerUserIDDescending';
	// @var string $BuyerPostalCodeDescending
	var $BuyerPostalCodeDescending = 'BuyerPostalCodeDescending';
	// @var string $BuyerEmailDescending
	var $BuyerEmailDescending = 'BuyerEmailDescending';
	// @var string $SellerEmailDescending
	var $SellerEmailDescending = 'SellerEmailDescending';
	// @var string $TotalPriceDescending
	var $TotalPriceDescending = 'TotalPriceDescending';
	// @var string $WatchCountDescending
	var $WatchCountDescending = 'WatchCountDescending';
	// @var string $QuestionCountDescending
	var $QuestionCountDescending = 'QuestionCountDescending';
	// @var string $ShippingServiceCostDescending
	var $ShippingServiceCostDescending = 'ShippingServiceCostDescending';
	// @var string $FeedbackReceivedDescending
	var $FeedbackReceivedDescending = 'FeedbackReceivedDescending';
	// @var string $FeedbackLeftDescending
	var $FeedbackLeftDescending = 'FeedbackLeftDescending';
	// @var string $UserIDDescending
	var $UserIDDescending = 'UserIDDescending';
	// @var string $QuantitySoldDescending
	var $QuantitySoldDescending = 'QuantitySoldDescending';
	// @var string $BestOfferCountDescending
	var $BestOfferCountDescending = 'BestOfferCountDescending';
	// @var string $QuantityAvailableDescending
	var $QuantityAvailableDescending = 'QuantityAvailableDescending';
	// @var string $QuantityPurchasedDescending
	var $QuantityPurchasedDescending = 'QuantityPurchasedDescending';
	// @var string $BestOfferDescending
	var $BestOfferDescending = 'BestOfferDescending';
	// @var string $ItemIDDescending
	var $ItemIDDescending = 'ItemIDDescending';
	// @var string $PriceDescending
	var $PriceDescending = 'PriceDescending';
	// @var string $StartPriceDescending
	var $StartPriceDescending = 'StartPriceDescending';
	// @var string $TitleDescending
	var $TitleDescending = 'TitleDescending';
	// @var string $BidCountDescending
	var $BidCountDescending = 'BidCountDescending';
	// @var string $QuantityDescending
	var $QuantityDescending = 'QuantityDescending';
	// @var string $StartTimeDescending
	var $StartTimeDescending = 'StartTimeDescending';
	// @var string $EndTimeDescending
	var $EndTimeDescending = 'EndTimeDescending';
	// @var string $SellerUserIDDescending
	var $SellerUserIDDescending = 'SellerUserIDDescending';
	// @var string $TimeLeftDescending
	var $TimeLeftDescending = 'TimeLeftDescending';
	// @var string $WonPlatformDescending
	var $WonPlatformDescending = 'WonPlatformDescending';
	// @var string $SoldPlatformDescending
	var $SoldPlatformDescending = 'SoldPlatformDescending';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function ItemSortTypeCodeType()
	{
		$this->EbatNs_FacetType('ItemSortTypeCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_ItemSortTypeCodeType = new ItemSortTypeCodeType();

?>
