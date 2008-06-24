<?php
// autogenerated file 17.11.2006 13:29
// $Id: SMSSubscriptionType.php,v 1.1.1.1 2006/12/22 14:38:48 gswkaiser Exp $
// $Log: SMSSubscriptionType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:48  gswkaiser
// no message
//
//
require_once 'SMSSubscriptionUserStatusCodeType.php';
require_once 'EbatNs_ComplexType.php';
require_once 'WirelessCarrierIDCodeType.php';
require_once 'SMSSubscriptionErrorCodeCodeType.php';
require_once 'ItemIDType.php';

class SMSSubscriptionType extends EbatNs_ComplexType
{
	// start props
	// @var string $SMSPhone
	var $SMSPhone;
	// @var SMSSubscriptionUserStatusCodeType $UserStatus
	var $UserStatus;
	// @var WirelessCarrierIDCodeType $CarrierID
	var $CarrierID;
	// @var SMSSubscriptionErrorCodeCodeType $ErrorCode
	var $ErrorCode;
	// @var ItemIDType $ItemToUnsubscribe
	var $ItemToUnsubscribe;
	// end props

/**
 *

 * @return string
 */
	function getSMSPhone()
	{
		return $this->SMSPhone;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setSMSPhone($value)
	{
		$this->SMSPhone = $value;
	}
/**
 *

 * @return SMSSubscriptionUserStatusCodeType
 */
	function getUserStatus()
	{
		return $this->UserStatus;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setUserStatus($value)
	{
		$this->UserStatus = $value;
	}
/**
 *

 * @return WirelessCarrierIDCodeType
 */
	function getCarrierID()
	{
		return $this->CarrierID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCarrierID($value)
	{
		$this->CarrierID = $value;
	}
/**
 *

 * @return SMSSubscriptionErrorCodeCodeType
 */
	function getErrorCode()
	{
		return $this->ErrorCode;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setErrorCode($value)
	{
		$this->ErrorCode = $value;
	}
/**
 *

 * @return ItemIDType
 */
	function getItemToUnsubscribe()
	{
		return $this->ItemToUnsubscribe;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setItemToUnsubscribe($value)
	{
		$this->ItemToUnsubscribe = $value;
	}
/**
 *

 * @return 
 */
	function SMSSubscriptionType()
	{
		$this->EbatNs_ComplexType('SMSSubscriptionType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'SMSPhone' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'UserStatus' =>
				array(
					'required' => false,
					'type' => 'SMSSubscriptionUserStatusCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'CarrierID' =>
				array(
					'required' => false,
					'type' => 'WirelessCarrierIDCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ErrorCode' =>
				array(
					'required' => false,
					'type' => 'SMSSubscriptionErrorCodeCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ItemToUnsubscribe' =>
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
