<?php
// autogenerated file 17.11.2006 13:29
// $Id: AddMemberMessagesAAQToBidderResponseType.php,v 1.1.1.1 2006/12/22 14:37:14 gswkaiser Exp $
// $Log: AddMemberMessagesAAQToBidderResponseType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:14  gswkaiser
// no message
//
//
require_once 'AddMemberMessagesAAQToBidderResponseContainerType.php';
require_once 'AbstractResponseType.php';

class AddMemberMessagesAAQToBidderResponseType extends AbstractResponseType
{
	// start props
	// @var AddMemberMessagesAAQToBidderResponseContainerType $AddMemberMessagesAAQToBidderResponseContainer
	var $AddMemberMessagesAAQToBidderResponseContainer;
	// end props

/**
 *

 * @return AddMemberMessagesAAQToBidderResponseContainerType
 * @param  $index 
 */
	function getAddMemberMessagesAAQToBidderResponseContainer($index = null)
	{
		if ($index) {
		return $this->AddMemberMessagesAAQToBidderResponseContainer[$index];
	} else {
		return $this->AddMemberMessagesAAQToBidderResponseContainer;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setAddMemberMessagesAAQToBidderResponseContainer($value, $index = null)
	{
		if ($index) {
	$this->AddMemberMessagesAAQToBidderResponseContainer[$index] = $value;
	} else {
	$this->AddMemberMessagesAAQToBidderResponseContainer = $value;
	}

	}
/**
 *

 * @return 
 */
	function AddMemberMessagesAAQToBidderResponseType()
	{
		$this->AbstractResponseType('AddMemberMessagesAAQToBidderResponseType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'AddMemberMessagesAAQToBidderResponseContainer' =>
				array(
					'required' => false,
					'type' => 'AddMemberMessagesAAQToBidderResponseContainerType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				)
			));

	}
}
?>