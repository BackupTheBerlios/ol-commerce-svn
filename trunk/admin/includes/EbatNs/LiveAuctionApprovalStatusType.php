<?php
// autogenerated file 17.11.2006 13:29
// $Id: LiveAuctionApprovalStatusType.php,v 1.1.1.1 2006/12/22 14:38:18 gswkaiser Exp $
// $Log: LiveAuctionApprovalStatusType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:18  gswkaiser
// no message
//
//
require_once 'UserIDType.php';
require_once 'EbatNs_ComplexType.php';

class LiveAuctionApprovalStatusType extends EbatNs_ComplexType
{
	// start props
	// @var UserIDType $UserID
	var $UserID;
	// @var string $Status
	var $Status;
	// end props

/**
 *

 * @return UserIDType
 */
	function getUserID()
	{
		return $this->UserID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setUserID($value)
	{
		$this->UserID = $value;
	}
/**
 *

 * @return string
 */
	function getStatus()
	{
		return $this->Status;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setStatus($value)
	{
		$this->Status = $value;
	}
/**
 *

 * @return 
 */
	function LiveAuctionApprovalStatusType()
	{
		$this->EbatNs_ComplexType('LiveAuctionApprovalStatusType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'UserID' =>
				array(
					'required' => false,
					'type' => 'UserIDType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Status' =>
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
