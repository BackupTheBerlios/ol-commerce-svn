<?php
// autogenerated file 17.11.2006 13:29
// $Id: GetMyeBayBuyingRequestType.php,v 1.1.1.1 2006/12/22 14:37:59 gswkaiser Exp $
// $Log: GetMyeBayBuyingRequestType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:59  gswkaiser
// no message
//
//
require_once 'ItemListCustomizationType.php';
require_once 'MyeBaySelectionType.php';
require_once 'AbstractRequestType.php';

class GetMyeBayBuyingRequestType extends AbstractRequestType
{
	// start props
	// @var ItemListCustomizationType $WatchList
	var $WatchList;
	// @var ItemListCustomizationType $BidList
	var $BidList;
	// @var ItemListCustomizationType $BestOfferList
	var $BestOfferList;
	// @var ItemListCustomizationType $WonList
	var $WonList;
	// @var ItemListCustomizationType $LostList
	var $LostList;
	// @var MyeBaySelectionType $FavoriteSearches
	var $FavoriteSearches;
	// @var MyeBaySelectionType $FavoriteSellers
	var $FavoriteSellers;
	// @var MyeBaySelectionType $SecondChanceOffer
	var $SecondChanceOffer;
	// end props

/**
 *

 * @return ItemListCustomizationType
 */
	function getWatchList()
	{
		return $this->WatchList;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setWatchList($value)
	{
		$this->WatchList = $value;
	}
/**
 *

 * @return ItemListCustomizationType
 */
	function getBidList()
	{
		return $this->BidList;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setBidList($value)
	{
		$this->BidList = $value;
	}
/**
 *

 * @return ItemListCustomizationType
 */
	function getBestOfferList()
	{
		return $this->BestOfferList;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setBestOfferList($value)
	{
		$this->BestOfferList = $value;
	}
/**
 *

 * @return ItemListCustomizationType
 */
	function getWonList()
	{
		return $this->WonList;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setWonList($value)
	{
		$this->WonList = $value;
	}
/**
 *

 * @return ItemListCustomizationType
 */
	function getLostList()
	{
		return $this->LostList;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setLostList($value)
	{
		$this->LostList = $value;
	}
/**
 *

 * @return MyeBaySelectionType
 */
	function getFavoriteSearches()
	{
		return $this->FavoriteSearches;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setFavoriteSearches($value)
	{
		$this->FavoriteSearches = $value;
	}
/**
 *

 * @return MyeBaySelectionType
 */
	function getFavoriteSellers()
	{
		return $this->FavoriteSellers;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setFavoriteSellers($value)
	{
		$this->FavoriteSellers = $value;
	}
/**
 *

 * @return MyeBaySelectionType
 */
	function getSecondChanceOffer()
	{
		return $this->SecondChanceOffer;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setSecondChanceOffer($value)
	{
		$this->SecondChanceOffer = $value;
	}
/**
 *

 * @return 
 */
	function GetMyeBayBuyingRequestType()
	{
		$this->AbstractRequestType('GetMyeBayBuyingRequestType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'WatchList' =>
				array(
					'required' => false,
					'type' => 'ItemListCustomizationType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'BidList' =>
				array(
					'required' => false,
					'type' => 'ItemListCustomizationType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'BestOfferList' =>
				array(
					'required' => false,
					'type' => 'ItemListCustomizationType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'WonList' =>
				array(
					'required' => false,
					'type' => 'ItemListCustomizationType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'LostList' =>
				array(
					'required' => false,
					'type' => 'ItemListCustomizationType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'FavoriteSearches' =>
				array(
					'required' => false,
					'type' => 'MyeBaySelectionType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'FavoriteSellers' =>
				array(
					'required' => false,
					'type' => 'MyeBaySelectionType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'SecondChanceOffer' =>
				array(
					'required' => false,
					'type' => 'MyeBaySelectionType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
