<?php
// autogenerated file 17.11.2006 13:29
// $Id: SetReturnURLRequestType.php,v 1.1.1.1 2006/12/22 14:38:40 gswkaiser Exp $
// $Log: SetReturnURLRequestType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:40  gswkaiser
// no message
//
//
require_once 'ModifyActionCodeType.php';
require_once 'AuthenticationEntryType.php';
require_once 'AbstractRequestType.php';

class SetReturnURLRequestType extends AbstractRequestType
{
	// start props
	// @var AuthenticationEntryType $AuthenticationEntry
	var $AuthenticationEntry;
	// @var string $ApplicationDisplayName
	var $ApplicationDisplayName;
	// @var ModifyActionCodeType $Action
	var $Action;
	// end props

/**
 *

 * @return AuthenticationEntryType
 */
	function getAuthenticationEntry()
	{
		return $this->AuthenticationEntry;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setAuthenticationEntry($value)
	{
		$this->AuthenticationEntry = $value;
	}
/**
 *

 * @return string
 */
	function getApplicationDisplayName()
	{
		return $this->ApplicationDisplayName;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setApplicationDisplayName($value)
	{
		$this->ApplicationDisplayName = $value;
	}
/**
 *

 * @return ModifyActionCodeType
 */
	function getAction()
	{
		return $this->Action;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setAction($value)
	{
		$this->Action = $value;
	}
/**
 *

 * @return 
 */
	function SetReturnURLRequestType()
	{
		$this->AbstractRequestType('SetReturnURLRequestType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'AuthenticationEntry' =>
				array(
					'required' => false,
					'type' => 'AuthenticationEntryType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ApplicationDisplayName' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Action' =>
				array(
					'required' => false,
					'type' => 'ModifyActionCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
