<?php
// autogenerated file 17.11.2006 13:29
// $Id: OrderType.php,v 1.1.1.1 2006/12/22 14:38:26 gswkaiser Exp $
// $Log: OrderType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:26  gswkaiser
// no message
//
//
require_once 'AddressType.php';
require_once 'CheckoutStatusType.php';
require_once 'TradingRoleCodeType.php';
require_once 'OrderStatusCodeType.php';
require_once 'EbatNs_ComplexType.php';
require_once 'BuyerPaymentMethodCodeType.php';
require_once 'ShippingServiceOptionsType.php';
require_once 'OrderIDType.php';
require_once 'AmountType.php';
require_once 'TransactionArrayType.php';
require_once 'ExternalTransactionType.php';
require_once 'ShippingDetailsType.php';
require_once 'UserIDType.php';

class OrderType extends EbatNs_ComplexType
{
	// start props
	// @var OrderIDType $OrderID
	var $OrderID;
	// @var OrderStatusCodeType $OrderStatus
	var $OrderStatus;
	// @var AmountType $AdjustmentAmount
	var $AdjustmentAmount;
	// @var AmountType $AmountPaid
	var $AmountPaid;
	// @var AmountType $AmountSaved
	var $AmountSaved;
	// @var CheckoutStatusType $CheckoutStatus
	var $CheckoutStatus;
	// @var ShippingDetailsType $ShippingDetails
	var $ShippingDetails;
	// @var TradingRoleCodeType $CreatingUserRole
	var $CreatingUserRole;
	// @var dateTime $CreatedTime
	var $CreatedTime;
	// @var string $FinanceOfferID
	var $FinanceOfferID;
	// @var BuyerPaymentMethodCodeType $PaymentMethods
	var $PaymentMethods;
	// @var string $SellerEmail
	var $SellerEmail;
	// @var AddressType $ShippingAddress
	var $ShippingAddress;
	// @var ShippingServiceOptionsType $ShippingServiceSelected
	var $ShippingServiceSelected;
	// @var AmountType $Subtotal
	var $Subtotal;
	// @var AmountType $Total
	var $Total;
	// @var ExternalTransactionType $ExternalTransaction
	var $ExternalTransaction;
	// @var boolean $DigitalDelivery
	var $DigitalDelivery;
	// @var TransactionArrayType $TransactionArray
	var $TransactionArray;
	// @var UserIDType $BuyerUserID
	var $BuyerUserID;
	// end props

/**
 *

 * @return OrderIDType
 */
	function getOrderID()
	{
		return $this->OrderID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setOrderID($value)
	{
		$this->OrderID = $value;
	}
/**
 *

 * @return OrderStatusCodeType
 */
	function getOrderStatus()
	{
		return $this->OrderStatus;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setOrderStatus($value)
	{
		$this->OrderStatus = $value;
	}
/**
 *

 * @return AmountType
 */
	function getAdjustmentAmount()
	{
		return $this->AdjustmentAmount;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setAdjustmentAmount($value)
	{
		$this->AdjustmentAmount = $value;
	}
/**
 *

 * @return AmountType
 */
	function getAmountPaid()
	{
		return $this->AmountPaid;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setAmountPaid($value)
	{
		$this->AmountPaid = $value;
	}
/**
 *

 * @return AmountType
 */
	function getAmountSaved()
	{
		return $this->AmountSaved;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setAmountSaved($value)
	{
		$this->AmountSaved = $value;
	}
/**
 *

 * @return CheckoutStatusType
 */
	function getCheckoutStatus()
	{
		return $this->CheckoutStatus;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCheckoutStatus($value)
	{
		$this->CheckoutStatus = $value;
	}
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

 * @return TradingRoleCodeType
 */
	function getCreatingUserRole()
	{
		return $this->CreatingUserRole;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCreatingUserRole($value)
	{
		$this->CreatingUserRole = $value;
	}
/**
 *

 * @return dateTime
 */
	function getCreatedTime()
	{
		return $this->CreatedTime;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCreatedTime($value)
	{
		$this->CreatedTime = $value;
	}
/**
 *

 * @return string
 */
	function getFinanceOfferID()
	{
		return $this->FinanceOfferID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setFinanceOfferID($value)
	{
		$this->FinanceOfferID = $value;
	}
/**
 *

 * @return BuyerPaymentMethodCodeType
 * @param  $index 
 */
	function getPaymentMethods($index = null)
	{
		if ($index) {
		return $this->PaymentMethods[$index];
	} else {
		return $this->PaymentMethods;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setPaymentMethods($value, $index = null)
	{
		if ($index) {
	$this->PaymentMethods[$index] = $value;
	} else {
	$this->PaymentMethods = $value;
	}

	}
/**
 *

 * @return string
 */
	function getSellerEmail()
	{
		return $this->SellerEmail;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setSellerEmail($value)
	{
		$this->SellerEmail = $value;
	}
/**
 *

 * @return AddressType
 */
	function getShippingAddress()
	{
		return $this->ShippingAddress;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setShippingAddress($value)
	{
		$this->ShippingAddress = $value;
	}
/**
 *

 * @return ShippingServiceOptionsType
 */
	function getShippingServiceSelected()
	{
		return $this->ShippingServiceSelected;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setShippingServiceSelected($value)
	{
		$this->ShippingServiceSelected = $value;
	}
/**
 *

 * @return AmountType
 */
	function getSubtotal()
	{
		return $this->Subtotal;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setSubtotal($value)
	{
		$this->Subtotal = $value;
	}
/**
 *

 * @return AmountType
 */
	function getTotal()
	{
		return $this->Total;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setTotal($value)
	{
		$this->Total = $value;
	}
/**
 *

 * @return ExternalTransactionType
 * @param  $index 
 */
	function getExternalTransaction($index = null)
	{
		if ($index) {
		return $this->ExternalTransaction[$index];
	} else {
		return $this->ExternalTransaction;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setExternalTransaction($value, $index = null)
	{
		if ($index) {
	$this->ExternalTransaction[$index] = $value;
	} else {
	$this->ExternalTransaction = $value;
	}

	}
/**
 *

 * @return boolean
 */
	function getDigitalDelivery()
	{
		return $this->DigitalDelivery;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setDigitalDelivery($value)
	{
		$this->DigitalDelivery = $value;
	}
/**
 *

 * @return TransactionArrayType
 */
	function getTransactionArray()
	{
		return $this->TransactionArray;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setTransactionArray($value)
	{
		$this->TransactionArray = $value;
	}
/**
 *

 * @return UserIDType
 */
	function getBuyerUserID()
	{
		return $this->BuyerUserID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setBuyerUserID($value)
	{
		$this->BuyerUserID = $value;
	}
/**
 *

 * @return 
 */
	function OrderType()
	{
		$this->EbatNs_ComplexType('OrderType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'OrderID' =>
				array(
					'required' => false,
					'type' => 'OrderIDType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'OrderStatus' =>
				array(
					'required' => false,
					'type' => 'OrderStatusCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'AdjustmentAmount' =>
				array(
					'required' => false,
					'type' => 'AmountType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'AmountPaid' =>
				array(
					'required' => false,
					'type' => 'AmountType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'AmountSaved' =>
				array(
					'required' => false,
					'type' => 'AmountType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'CheckoutStatus' =>
				array(
					'required' => false,
					'type' => 'CheckoutStatusType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ShippingDetails' =>
				array(
					'required' => false,
					'type' => 'ShippingDetailsType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'CreatingUserRole' =>
				array(
					'required' => false,
					'type' => 'TradingRoleCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'CreatedTime' =>
				array(
					'required' => false,
					'type' => 'dateTime',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'FinanceOfferID' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'PaymentMethods' =>
				array(
					'required' => false,
					'type' => 'BuyerPaymentMethodCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				),
				'SellerEmail' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ShippingAddress' =>
				array(
					'required' => false,
					'type' => 'AddressType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ShippingServiceSelected' =>
				array(
					'required' => false,
					'type' => 'ShippingServiceOptionsType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Subtotal' =>
				array(
					'required' => false,
					'type' => 'AmountType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Total' =>
				array(
					'required' => false,
					'type' => 'AmountType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ExternalTransaction' =>
				array(
					'required' => false,
					'type' => 'ExternalTransactionType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				),
				'DigitalDelivery' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'TransactionArray' =>
				array(
					'required' => false,
					'type' => 'TransactionArrayType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'BuyerUserID' =>
				array(
					'required' => false,
					'type' => 'UserIDType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
