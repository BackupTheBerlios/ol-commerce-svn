<?php
// autogenerated file 17.11.2006 13:29
// $Id: AddToWatchListRequestType.php,v 1.1.1.1 2006/12/22 14:37:16 gswkaiser Exp $
// $Log: AddToWatchListRequestType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:16  gswkaiser
// no message
//
//
require_once 'AbstractRequestType.php';
require_once 'ItemIDType.php';

class AddToWatchListRequestType extends AbstractRequestType
{
	// start props
	// @var ItemIDType $ItemID
	var $ItemID;
	// end props

/**
 *

 * @return ItemIDType
 * @param  $index 
 */
	function getItemID($index = null)
	{
		if ($index) {
		return $this->ItemID[$index];
	} else {
		return $this->ItemID;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setItemID($value, $index = null)
	{
		if ($index) {
	$this->ItemID[$index] = $value;
	} else {
	$this->ItemID = $value;
	}

	}
/**
 *

 * @return 
 */
	function AddToWatchListRequestType()
	{
		$this->AbstractRequestType('AddToWatchListRequestType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'ItemID' =>
				array(
					'required' => false,
					'type' => 'ItemIDType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				)
			));

	}
}
?>
