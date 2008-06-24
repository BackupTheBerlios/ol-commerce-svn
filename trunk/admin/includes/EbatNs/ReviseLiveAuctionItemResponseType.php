<?php
// autogenerated file 17.11.2006 13:29
// $Id: ReviseLiveAuctionItemResponseType.php,v 1.1.1.1 2006/12/22 14:38:35 gswkaiser Exp $
// $Log: ReviseLiveAuctionItemResponseType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:35  gswkaiser
// no message
//
//
require_once 'FeesType.php';
require_once 'AbstractResponseType.php';
require_once 'ItemIDType.php';

class ReviseLiveAuctionItemResponseType extends AbstractResponseType
{
	// start props
	// @var ItemIDType $ItemID
	var $ItemID;
	// @var FeesType $Fees
	var $Fees;
	// @var string $CategoryID
	var $CategoryID;
	// @var string $Category2ID
	var $Category2ID;
	// end props

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

 * @return FeesType
 */
	function getFees()
	{
		return $this->Fees;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setFees($value)
	{
		$this->Fees = $value;
	}
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

 * @return string
 */
	function getCategory2ID()
	{
		return $this->Category2ID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCategory2ID($value)
	{
		$this->Category2ID = $value;
	}
/**
 *

 * @return 
 */
	function ReviseLiveAuctionItemResponseType()
	{
		$this->AbstractResponseType('ReviseLiveAuctionItemResponseType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'ItemID' =>
				array(
					'required' => false,
					'type' => 'ItemIDType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Fees' =>
				array(
					'required' => false,
					'type' => 'FeesType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'CategoryID' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Category2ID' =>
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
