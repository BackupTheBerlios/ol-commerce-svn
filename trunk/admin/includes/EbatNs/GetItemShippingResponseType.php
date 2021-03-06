<?php
// autogenerated file 17.11.2006 13:29
// $Id: GetItemShippingResponseType.php,v 1.1.1.1 2006/12/22 14:37:57 gswkaiser Exp $
// $Log: GetItemShippingResponseType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:57  gswkaiser
// no message
//
//
require_once 'ShippingDetailsType.php';
require_once 'AbstractResponseType.php';

class GetItemShippingResponseType extends AbstractResponseType
{
	// start props
	// @var ShippingDetailsType $ShippingDetails
	var $ShippingDetails;
	// end props

/**
 *

 * @return ShippingDetailsType
 */
	function getShippingDetails()
	{
		return $this->ShippingDetails;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setShippingDetails($value)
	{
		$this->ShippingDetails = $value;
	}
/**
 *

 * @return 
 */
	function GetItemShippingResponseType()
	{
		$this->AbstractResponseType('GetItemShippingResponseType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'ShippingDetails' =>
				array(
					'required' => false,
					'type' => 'ShippingDetailsType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
