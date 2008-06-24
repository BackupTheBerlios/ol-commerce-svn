<?php
// autogenerated file 17.11.2006 13:29
// $Id: AbstractResponseType.php,v 1.1.1.1 2006/12/22 14:37:10 gswkaiser Exp $
// $Log: AbstractResponseType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:10  gswkaiser
// no message
//
//
require_once 'DuplicateInvocationDetailsType.php';
require_once 'ErrorType.php';
require_once 'EbatNs_ComplexType.php';
require_once 'AckCodeType.php';

class AbstractResponseType extends EbatNs_ComplexType
{
	// start props
	// @var dateTime $Timestamp
	var $Timestamp;
	// @var AckCodeType $Ack
	var $Ack;
	// @var string $CorrelationID
	var $CorrelationID;
	// @var ErrorType $Errors
	var $Errors;
	// @var string $Message
	var $Message;
	// @var string $Version
	var $Version;
	// @var string $Build
	var $Build;
	// @var string $NotificationEventName
	var $NotificationEventName;
	// @var DuplicateInvocationDetailsType $DuplicateInvocationDetails
	var $DuplicateInvocationDetails;
	// @var string $RecipientUserID
	var $RecipientUserID;
	// @var string $EIASToken
	var $EIASToken;
	// @var string $NotificationSignature
	var $NotificationSignature;
	// @var string $HardExpirationWarning
	var $HardExpirationWarning;
	// end props

/**
 *

 * @return dateTime
 */
	function getTimestamp()
	{
		return $this->Timestamp;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setTimestamp($value)
	{
		$this->Timestamp = $value;
	}
/**
 *

 * @return AckCodeType
 */
	function getAck()
	{
		return $this->Ack;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setAck($value)
	{
		$this->Ack = $value;
	}
/**
 *

 * @return string
 */
	function getCorrelationID()
	{
		return $this->CorrelationID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCorrelationID($value)
	{
		$this->CorrelationID = $value;
	}
/**
 *

 * @return ErrorType
 * @param  $index 
 */
	function getErrors($index = null)
	{
		if ($index) {
		return $this->Errors[$index];
	} else {
		return $this->Errors;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setErrors($value, $index = null)
	{
		if ($index) {
	$this->Errors[$index] = $value;
	} else {
	$this->Errors = $value;
	}

	}
/**
 *

 * @return string
 */
	function getMessage()
	{
		return $this->Message;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setMessage($value)
	{
		$this->Message = $value;
	}
/**
 *

 * @return string
 */
	function getVersion()
	{
		return $this->Version;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setVersion($value)
	{
		$this->Version = $value;
	}
/**
 *

 * @return string
 */
	function getBuild()
	{
		return $this->Build;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setBuild($value)
	{
		$this->Build = $value;
	}
/**
 *

 * @return string
 */
	function getNotificationEventName()
	{
		return $this->NotificationEventName;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setNotificationEventName($value)
	{
		$this->NotificationEventName = $value;
	}
/**
 *

 * @return DuplicateInvocationDetailsType
 */
	function getDuplicateInvocationDetails()
	{
		return $this->DuplicateInvocationDetails;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setDuplicateInvocationDetails($value)
	{
		$this->DuplicateInvocationDetails = $value;
	}
/**
 *

 * @return string
 */
	function getRecipientUserID()
	{
		return $this->RecipientUserID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setRecipientUserID($value)
	{
		$this->RecipientUserID = $value;
	}
/**
 *

 * @return string
 */
	function getEIASToken()
	{
		return $this->EIASToken;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setEIASToken($value)
	{
		$this->EIASToken = $value;
	}
/**
 *

 * @return string
 */
	function getNotificationSignature()
	{
		return $this->NotificationSignature;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setNotificationSignature($value)
	{
		$this->NotificationSignature = $value;
	}
/**
 *

 * @return string
 */
	function getHardExpirationWarning()
	{
		return $this->HardExpirationWarning;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setHardExpirationWarning($value)
	{
		$this->HardExpirationWarning = $value;
	}
/**
 *

 * @return 
 */
	function AbstractResponseType()
	{
		$this->EbatNs_ComplexType('AbstractResponseType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'Timestamp' =>
				array(
					'required' => false,
					'type' => 'dateTime',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Ack' =>
				array(
					'required' => false,
					'type' => 'AckCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'CorrelationID' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Errors' =>
				array(
					'required' => false,
					'type' => 'ErrorType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				),
				'Message' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Version' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Build' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'NotificationEventName' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'DuplicateInvocationDetails' =>
				array(
					'required' => false,
					'type' => 'DuplicateInvocationDetailsType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'RecipientUserID' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'EIASToken' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'NotificationSignature' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'HardExpirationWarning' =>
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