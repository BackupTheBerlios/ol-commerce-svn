<?php
// autogenerated file 17.11.2006 13:29
// $Id: MyMessagesResponseDetailsType.php,v 1.1.1.1 2006/12/22 14:38:23 gswkaiser Exp $
// $Log: MyMessagesResponseDetailsType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:23  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';

class MyMessagesResponseDetailsType extends EbatNs_ComplexType
{
	// start props
	// @var boolean $ResponseEnabled
	var $ResponseEnabled;
	// @var anyURI $ResponseURL
	var $ResponseURL;
	// @var dateTime $UserResponseDate
	var $UserResponseDate;
	// end props

/**
 *

 * @return boolean
 */
	function getResponseEnabled()
	{
		return $this->ResponseEnabled;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setResponseEnabled($value)
	{
		$this->ResponseEnabled = $value;
	}
/**
 *

 * @return anyURI
 */
	function getResponseURL()
	{
		return $this->ResponseURL;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setResponseURL($value)
	{
		$this->ResponseURL = $value;
	}
/**
 *

 * @return dateTime
 */
	function getUserResponseDate()
	{
		return $this->UserResponseDate;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setUserResponseDate($value)
	{
		$this->UserResponseDate = $value;
	}
/**
 *

 * @return 
 */
	function MyMessagesResponseDetailsType()
	{
		$this->EbatNs_ComplexType('MyMessagesResponseDetailsType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'ResponseEnabled' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ResponseURL' =>
				array(
					'required' => false,
					'type' => 'anyURI',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'UserResponseDate' =>
				array(
					'required' => false,
					'type' => 'dateTime',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>