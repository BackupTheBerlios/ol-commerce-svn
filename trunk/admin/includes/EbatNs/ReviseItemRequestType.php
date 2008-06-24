<?php
// autogenerated file 17.11.2006 13:29
// $Id: ReviseItemRequestType.php,v 1.1.1.1 2006/12/22 14:38:34 gswkaiser Exp $
// $Log: ReviseItemRequestType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:34  gswkaiser
// no message
//
//
require_once 'ItemType.php';
require_once 'ModifiedFieldType.php';
require_once 'AbstractRequestType.php';

class ReviseItemRequestType extends AbstractRequestType
{
	// start props
	// @var ItemType $Item
	var $Item;
	// @var ModifiedFieldType $ModifiedFields
	var $ModifiedFields;
	// @var string $DeletedField
	var $DeletedField;
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

 * @return ModifiedFieldType
 * @param  $index 
 */
	function getModifiedFields($index = null)
	{
		if ($index) {
		return $this->ModifiedFields[$index];
	} else {
		return $this->ModifiedFields;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setModifiedFields($value, $index = null)
	{
		if ($index) {
	$this->ModifiedFields[$index] = $value;
	} else {
	$this->ModifiedFields = $value;
	}

	}
/**
 *

 * @return string
 * @param  $index 
 */
	function getDeletedField($index = null)
	{
		if ($index) {
		return $this->DeletedField[$index];
	} else {
		return $this->DeletedField;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setDeletedField($value, $index = null)
	{
		if ($index) {
	$this->DeletedField[$index] = $value;
	} else {
	$this->DeletedField = $value;
	}

	}
/**
 *

 * @return 
 */
	function ReviseItemRequestType()
	{
		$this->AbstractRequestType('ReviseItemRequestType', 'urn:ebay:apis:eBLBaseComponents');
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
				'ModifiedFields' =>
				array(
					'required' => false,
					'type' => 'ModifiedFieldType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				),
				'DeletedField' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => true,
					'cardinality' => '0..*'
				)
			));

	}
}
?>
