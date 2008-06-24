<?php
// autogenerated file 17.11.2006 13:29
// $Id: GetOrdersResponseType.php,v 1.1.1.1 2006/12/22 14:38:01 gswkaiser Exp $
// $Log: GetOrdersResponseType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:01  gswkaiser
// no message
//
//
require_once 'OrderArrayType.php';
require_once 'AbstractResponseType.php';
require_once 'PaginationResultType.php';

class GetOrdersResponseType extends AbstractResponseType
{
	// start props
	// @var PaginationResultType $PaginationResult
	var $PaginationResult;
	// @var boolean $HasMoreOrders
	var $HasMoreOrders;
	// @var OrderArrayType $OrderArray
	var $OrderArray;
	// @var int $OrdersPerPage
	var $OrdersPerPage;
	// @var int $PageNumber
	var $PageNumber;
	// @var int $ReturnedOrderCountActual
	var $ReturnedOrderCountActual;
	// end props

/**
 *

 * @return PaginationResultType
 */
	function getPaginationResult()
	{
		return $this->PaginationResult;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setPaginationResult($value)
	{
		$this->PaginationResult = $value;
	}
/**
 *

 * @return boolean
 */
	function getHasMoreOrders()
	{
		return $this->HasMoreOrders;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setHasMoreOrders($value)
	{
		$this->HasMoreOrders = $value;
	}
/**
 *

 * @return OrderArrayType
 */
	function getOrderArray()
	{
		return $this->OrderArray;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setOrderArray($value)
	{
		$this->OrderArray = $value;
	}
/**
 *

 * @return int
 */
	function getOrdersPerPage()
	{
		return $this->OrdersPerPage;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setOrdersPerPage($value)
	{
		$this->OrdersPerPage = $value;
	}
/**
 *

 * @return int
 */
	function getPageNumber()
	{
		return $this->PageNumber;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setPageNumber($value)
	{
		$this->PageNumber = $value;
	}
/**
 *

 * @return int
 */
	function getReturnedOrderCountActual()
	{
		return $this->ReturnedOrderCountActual;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setReturnedOrderCountActual($value)
	{
		$this->ReturnedOrderCountActual = $value;
	}
/**
 *

 * @return 
 */
	function GetOrdersResponseType()
	{
		$this->AbstractResponseType('GetOrdersResponseType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'PaginationResult' =>
				array(
					'required' => false,
					'type' => 'PaginationResultType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'HasMoreOrders' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'OrderArray' =>
				array(
					'required' => false,
					'type' => 'OrderArrayType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'OrdersPerPage' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'PageNumber' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ReturnedOrderCountActual' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>