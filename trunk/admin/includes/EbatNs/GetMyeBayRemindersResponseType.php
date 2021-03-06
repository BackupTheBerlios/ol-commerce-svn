<?php
// autogenerated file 17.11.2006 13:29
// $Id: GetMyeBayRemindersResponseType.php,v 1.1.1.1 2006/12/22 14:37:59 gswkaiser Exp $
// $Log: GetMyeBayRemindersResponseType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:59  gswkaiser
// no message
//
//
require_once 'RemindersType.php';
require_once 'AbstractResponseType.php';

class GetMyeBayRemindersResponseType extends AbstractResponseType
{
	// start props
	// @var RemindersType $BuyingReminders
	var $BuyingReminders;
	// @var RemindersType $SellingReminders
	var $SellingReminders;
	// end props

/**
 *

 * @return RemindersType
 */
	function getBuyingReminders()
	{
		return $this->BuyingReminders;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setBuyingReminders($value)
	{
		$this->BuyingReminders = $value;
	}
/**
 *

 * @return RemindersType
 */
	function getSellingReminders()
	{
		return $this->SellingReminders;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setSellingReminders($value)
	{
		$this->SellingReminders = $value;
	}
/**
 *

 * @return 
 */
	function GetMyeBayRemindersResponseType()
	{
		$this->AbstractResponseType('GetMyeBayRemindersResponseType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'BuyingReminders' =>
				array(
					'required' => false,
					'type' => 'RemindersType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'SellingReminders' =>
				array(
					'required' => false,
					'type' => 'RemindersType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
