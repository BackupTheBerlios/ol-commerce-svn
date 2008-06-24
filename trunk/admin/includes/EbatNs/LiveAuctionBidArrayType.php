<?php
// autogenerated file 17.11.2006 13:29
// $Id: LiveAuctionBidArrayType.php,v 1.1.1.1 2006/12/22 14:38:18 gswkaiser Exp $
// $Log: LiveAuctionBidArrayType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:18  gswkaiser
// no message
//
//
require_once 'LiveAuctionBidType.php';
require_once 'EbatNs_ComplexType.php';

class LiveAuctionBidArrayType extends EbatNs_ComplexType
{
	// start props
	// @var LiveAuctionBidType $LiveAuctionBid
	var $LiveAuctionBid;
	// end props

/**
 *

 * @return LiveAuctionBidType
 * @param  $index 
 */
	function getLiveAuctionBid($index = null)
	{
		if ($index) {
		return $this->LiveAuctionBid[$index];
	} else {
		return $this->LiveAuctionBid;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setLiveAuctionBid($value, $index = null)
	{
		if ($index) {
	$this->LiveAuctionBid[$index] = $value;
	} else {
	$this->LiveAuctionBid = $value;
	}

	}
/**
 *

 * @return 
 */
	function LiveAuctionBidArrayType()
	{
		$this->EbatNs_ComplexType('LiveAuctionBidArrayType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'LiveAuctionBid' =>
				array(
					'required' => false,
					'type' => 'LiveAuctionBidType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				)
			));

	}
}
?>
