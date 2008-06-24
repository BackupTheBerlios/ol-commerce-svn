<?php
// autogenerated file 17.11.2006 13:29
// $Id: GetMyMessagesRequestType.php,v 1.1.1.1 2006/12/22 14:38:00 gswkaiser Exp $
// $Log: GetMyMessagesRequestType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:00  gswkaiser
// no message
//
//
require_once 'MyMessagesAlertIDArrayType.php';
require_once 'MyMessagesMessageIDArrayType.php';
require_once 'AbstractRequestType.php';

class GetMyMessagesRequestType extends AbstractRequestType
{
	// start props
	// @var MyMessagesAlertIDArrayType $AlertIDs
	var $AlertIDs;
	// @var MyMessagesMessageIDArrayType $MessageIDs
	var $MessageIDs;
	// @var long $FolderID
	var $FolderID;
	// end props

/**
 *

 * @return MyMessagesAlertIDArrayType
 */
	function getAlertIDs()
	{
		return $this->AlertIDs;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setAlertIDs($value)
	{
		$this->AlertIDs = $value;
	}
/**
 *

 * @return MyMessagesMessageIDArrayType
 */
	function getMessageIDs()
	{
		return $this->MessageIDs;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setMessageIDs($value)
	{
		$this->MessageIDs = $value;
	}
/**
 *

 * @return long
 */
	function getFolderID()
	{
		return $this->FolderID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setFolderID($value)
	{
		$this->FolderID = $value;
	}
/**
 *

 * @return 
 */
	function GetMyMessagesRequestType()
	{
		$this->AbstractRequestType('GetMyMessagesRequestType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'AlertIDs' =>
				array(
					'required' => false,
					'type' => 'MyMessagesAlertIDArrayType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'MessageIDs' =>
				array(
					'required' => false,
					'type' => 'MyMessagesMessageIDArrayType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'FolderID' =>
				array(
					'required' => false,
					'type' => 'long',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>