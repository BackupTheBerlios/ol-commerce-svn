<?php
// autogenerated file 17.11.2006 13:29
// $Id: GetStoreCustomPageRequestType.php,v 1.1.1.1 2006/12/22 14:38:08 gswkaiser Exp $
// $Log: GetStoreCustomPageRequestType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:08  gswkaiser
// no message
//
//
require_once 'AbstractRequestType.php';

class GetStoreCustomPageRequestType extends AbstractRequestType
{
	// start props
	// @var string $PageID
	var $PageID;
	// end props

/**
 *

 * @return string
 */
	function getPageID()
	{
		return $this->PageID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setPageID($value)
	{
		$this->PageID = $value;
	}
/**
 *

 * @return 
 */
	function GetStoreCustomPageRequestType()
	{
		$this->AbstractRequestType('GetStoreCustomPageRequestType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'PageID' =>
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
