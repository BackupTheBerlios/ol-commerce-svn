<?php
// autogenerated file 17.11.2006 13:29
// $Id: GetItemResponseType.php,v 1.1.1.1 2006/12/22 14:37:57 gswkaiser Exp $
// $Log: GetItemResponseType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:57  gswkaiser
// no message
//
//
require_once 'AbstractResponseType.php';
require_once 'ItemType.php';

class GetItemResponseType extends AbstractResponseType
{
	// start props
	// @var ItemType $Item
	var $Item;
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

 * @return 
 */
	function GetItemResponseType()
	{
		$this->AbstractResponseType('GetItemResponseType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'Item' =>
				array(
					'required' => false,
					'type' => 'ItemType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
