<?php
// autogenerated file 17.11.2006 13:29
// $Id: GetHighBiddersRequestType.php,v 1.1.1.1 2006/12/22 14:37:57 gswkaiser Exp $
// $Log: GetHighBiddersRequestType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:57  gswkaiser
// no message
//
//
require_once 'AbstractRequestType.php';
require_once 'ItemIDType.php';

class GetHighBiddersRequestType extends AbstractRequestType
{
	// start props
	// @var ItemIDType $ItemID
	var $ItemID;
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

 * @return 
 */
	function GetHighBiddersRequestType()
	{
		$this->AbstractRequestType('GetHighBiddersRequestType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'ItemID' =>
				array(
					'required' => false,
					'type' => 'ItemIDType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
