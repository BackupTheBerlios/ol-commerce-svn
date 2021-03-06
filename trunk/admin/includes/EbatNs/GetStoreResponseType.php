<?php
// autogenerated file 17.11.2006 13:29
// $Id: GetStoreResponseType.php,v 1.1.1.1 2006/12/22 14:38:09 gswkaiser Exp $
// $Log: GetStoreResponseType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:09  gswkaiser
// no message
//
//
require_once 'AbstractResponseType.php';
require_once 'StoreType.php';

class GetStoreResponseType extends AbstractResponseType
{
	// start props
	// @var StoreType $Store
	var $Store;
	// end props

/**
 *

 * @return StoreType
 */
	function getStore()
	{
		return $this->Store;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setStore($value)
	{
		$this->Store = $value;
	}
/**
 *

 * @return 
 */
	function GetStoreResponseType()
	{
		$this->AbstractResponseType('GetStoreResponseType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'Store' =>
				array(
					'required' => false,
					'type' => 'StoreType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
