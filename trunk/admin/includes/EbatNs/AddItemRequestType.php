<?php
// autogenerated file 17.11.2006 13:29
// $Id: AddItemRequestType.php,v 1.1.1.1 2006/12/22 14:37:13 gswkaiser Exp $
// $Log: AddItemRequestType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:13  gswkaiser
// no message
//
//
require_once 'ExternalProductIDType.php';
require_once 'ItemType.php';
require_once 'AbstractRequestType.php';

class AddItemRequestType extends AbstractRequestType
{
	// start props
	// @var ItemType $Item
	var $Item;
	// @var ExternalProductIDType $ExternalProductID
	var $ExternalProductID;
	// end props

/**
 *

 * @return ItemType
 */
	function getItem()
	{
		return $this->Item;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setItem($value)
	{
		$this->Item = $value;
	}
/**
 *

 * @return ExternalProductIDType
 */
	function getExternalProductID()
	{
		return $this->ExternalProductID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setExternalProductID($value)
	{
		$this->ExternalProductID = $value;
	}
/**
 *

 * @return 
 */
	function AddItemRequestType()
	{
		$this->AbstractRequestType('AddItemRequestType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'Item' =>
				array(
					'required' => false,
					'type' => 'ItemType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ExternalProductID' =>
				array(
					'required' => false,
					'type' => 'ExternalProductIDType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
