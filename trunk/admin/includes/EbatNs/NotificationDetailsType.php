<?php
// autogenerated file 17.11.2006 13:29
// $Id: NotificationDetailsType.php,v 1.1.1.1 2006/12/22 14:38:23 gswkaiser Exp $
// $Log: NotificationDetailsType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:23  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'NotificationEventTypeCodeType.php';
require_once 'NotificationEventStateCodeType.php';

class NotificationDetailsType extends EbatNs_ComplexType
{
	// start props
	// @var anyURI $DeliveryURL
	var $DeliveryURL;
	// @var string $ReferenceID
	var $ReferenceID;
	// @var dateTime $ExpirationTime
	var $ExpirationTime;
	// @var NotificationEventTypeCodeType $Type
	var $Type;
	// @var int $Retries
	var $Retries;
	// @var NotificationEventStateCodeType $DeliveryStatus
	var $DeliveryStatus;
	// @var dateTime $NextRetryTime
	var $NextRetryTime;
	// @var dateTime $DeliveryTime
	var $DeliveryTime;
	// @var string $ErrorMessage
	var $ErrorMessage;
	// end props

/**
 *

 * @return anyURI
 */
	function getDeliveryURL()
	{
		return $this->DeliveryURL;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setDeliveryURL($value)
	{
		$this->DeliveryURL = $value;
	}
/**
 *

 * @return string
 */
	function getReferenceID()
	{
		return $this->ReferenceID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setReferenceID($value)
	{
		$this->ReferenceID = $value;
	}
/**
 *

 * @return dateTime
 */
	function getExpirationTime()
	{
		return $this->ExpirationTime;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setExpirationTime($value)
	{
		$this->ExpirationTime = $value;
	}
/**
 *

 * @return NotificationEventTypeCodeType
 */
	function getType()
	{
		return $this->Type;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setType($value)
	{
		$this->Type = $value;
	}
/**
 *

 * @return int
 */
	function getRetries()
	{
		return $this->Retries;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setRetries($value)
	{
		$this->Retries = $value;
	}
/**
 *

 * @return NotificationEventStateCodeType
 */
	function getDeliveryStatus()
	{
		return $this->DeliveryStatus;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setDeliveryStatus($value)
	{
		$this->DeliveryStatus = $value;
	}
/**
 *

 * @return dateTime
 */
	function getNextRetryTime()
	{
		return $this->NextRetryTime;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setNextRetryTime($value)
	{
		$this->NextRetryTime = $value;
	}
/**
 *

 * @return dateTime
 */
	function getDeliveryTime()
	{
		return $this->DeliveryTime;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setDeliveryTime($value)
	{
		$this->DeliveryTime = $value;
	}
/**
 *

 * @return string
 */
	function getErrorMessage()
	{
		return $this->ErrorMessage;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setErrorMessage($value)
	{
		$this->ErrorMessage = $value;
	}
/**
 *

 * @return 
 */
	function NotificationDetailsType()
	{
		$this->EbatNs_ComplexType('NotificationDetailsType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'DeliveryURL' =>
				array(
					'required' => false,
					'type' => 'anyURI',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ReferenceID' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ExpirationTime' =>
				array(
					'required' => false,
					'type' => 'dateTime',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Type' =>
				array(
					'required' => false,
					'type' => 'NotificationEventTypeCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Retries' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'DeliveryStatus' =>
				array(
					'required' => false,
					'type' => 'NotificationEventStateCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'NextRetryTime' =>
				array(
					'required' => false,
					'type' => 'dateTime',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'DeliveryTime' =>
				array(
					'required' => false,
					'type' => 'dateTime',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ErrorMessage' =>
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
