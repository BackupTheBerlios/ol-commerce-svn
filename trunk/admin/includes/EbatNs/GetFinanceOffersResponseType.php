<?php
// autogenerated file 17.11.2006 13:29
// $Id: GetFinanceOffersResponseType.php,v 1.1.1.1 2006/12/22 14:37:56 gswkaiser Exp $
// $Log: GetFinanceOffersResponseType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:56  gswkaiser
// no message
//
//
require_once 'AbstractResponseType.php';
require_once 'FinanceOfferArrayType.php';

class GetFinanceOffersResponseType extends AbstractResponseType
{
	// start props
	// @var int $Count
	var $Count;
	// @var FinanceOfferArrayType $FinanceOfferArray
	var $FinanceOfferArray;
	// end props

/**
 *

 * @return int
 */
	function getCount()
	{
		return $this->Count;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCount($value)
	{
		$this->Count = $value;
	}
/**
 *

 * @return FinanceOfferArrayType
 */
	function getFinanceOfferArray()
	{
		return $this->FinanceOfferArray;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setFinanceOfferArray($value)
	{
		$this->FinanceOfferArray = $value;
	}
/**
 *

 * @return 
 */
	function GetFinanceOffersResponseType()
	{
		$this->AbstractResponseType('GetFinanceOffersResponseType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'Count' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'FinanceOfferArray' =>
				array(
					'required' => false,
					'type' => 'FinanceOfferArrayType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
