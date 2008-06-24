<?php
// autogenerated file 17.11.2006 13:29
// $Id: ShipmentType.php,v 1.1.1.1 2006/12/22 14:38:42 gswkaiser Exp $
// $Log: ShipmentType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:42  gswkaiser
// no message
//
//
require_once 'ShippingCarrierCodeType.php';
require_once 'ShippingPackageCodeType.php';
require_once 'EbatNs_ComplexType.php';
require_once 'ShipmentStatusCodeType.php';
require_once 'ShipmentDeliveryStatusCodeType.php';
require_once 'ShippingFeatureCodeType.php';
require_once 'AmountType.php';
require_once 'MeasureType.php';
require_once 'ItemTransactionIDType.php';
require_once 'AddressType.php';

class ShipmentType extends EbatNs_ComplexType
{
	// start props
	// @var dateTime $EstimatedDeliveryDate
	var $EstimatedDeliveryDate;
	// @var AmountType $InsuredValue
	var $InsuredValue;
	// @var MeasureType $PackageDepth
	var $PackageDepth;
	// @var MeasureType $PackageLength
	var $PackageLength;
	// @var MeasureType $PackageWidth
	var $PackageWidth;
	// @var string $PayPalShipmentID
	var $PayPalShipmentID;
	// @var long $ShipmentID
	var $ShipmentID;
	// @var AmountType $PostageTotal
	var $PostageTotal;
	// @var dateTime $PrintedTime
	var $PrintedTime;
	// @var AddressType $ShipFromAddress
	var $ShipFromAddress;
	// @var AddressType $ShippingAddress
	var $ShippingAddress;
	// @var ShippingCarrierCodeType $ShippingCarrierUsed
	var $ShippingCarrierUsed;
	// @var ShippingFeatureCodeType $ShippingFeature
	var $ShippingFeature;
	// @var ShippingPackageCodeType $ShippingPackage
	var $ShippingPackage;
	// @var token $ShippingServiceUsed
	var $ShippingServiceUsed;
	// @var string $ShipmentTrackingNumber
	var $ShipmentTrackingNumber;
	// @var MeasureType $WeightMajor
	var $WeightMajor;
	// @var MeasureType $WeightMinor
	var $WeightMinor;
	// @var ItemTransactionIDType $ItemTransactionID
	var $ItemTransactionID;
	// @var dateTime $DeliveryDate
	var $DeliveryDate;
	// @var ShipmentDeliveryStatusCodeType $DeliveryStatus
	var $DeliveryStatus;
	// @var dateTime $RefundGrantedTime
	var $RefundGrantedTime;
	// @var dateTime $RefundRequestedTime
	var $RefundRequestedTime;
	// @var ShipmentStatusCodeType $Status
	var $Status;
	// end props

/**
 *

 * @return dateTime
 */
	function getEstimatedDeliveryDate()
	{
		return $this->EstimatedDeliveryDate;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setEstimatedDeliveryDate($value)
	{
		$this->EstimatedDeliveryDate = $value;
	}
/**
 *

 * @return AmountType
 */
	function getInsuredValue()
	{
		return $this->InsuredValue;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setInsuredValue($value)
	{
		$this->InsuredValue = $value;
	}
/**
 *

 * @return MeasureType
 */
	function getPackageDepth()
	{
		return $this->PackageDepth;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setPackageDepth($value)
	{
		$this->PackageDepth = $value;
	}
/**
 *

 * @return MeasureType
 */
	function getPackageLength()
	{
		return $this->PackageLength;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setPackageLength($value)
	{
		$this->PackageLength = $value;
	}
/**
 *

 * @return MeasureType
 */
	function getPackageWidth()
	{
		return $this->PackageWidth;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setPackageWidth($value)
	{
		$this->PackageWidth = $value;
	}
/**
 *

 * @return string
 */
	function getPayPalShipmentID()
	{
		return $this->PayPalShipmentID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setPayPalShipmentID($value)
	{
		$this->PayPalShipmentID = $value;
	}
/**
 *

 * @return long
 */
	function getShipmentID()
	{
		return $this->ShipmentID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setShipmentID($value)
	{
		$this->ShipmentID = $value;
	}
/**
 *

 * @return AmountType
 */
	function getPostageTotal()
	{
		return $this->PostageTotal;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setPostageTotal($value)
	{
		$this->PostageTotal = $value;
	}
/**
 *

 * @return dateTime
 */
	function getPrintedTime()
	{
		return $this->PrintedTime;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setPrintedTime($value)
	{
		$this->PrintedTime = $value;
	}
/**
 *

 * @return AddressType
 */
	function getShipFromAddress()
	{
		return $this->ShipFromAddress;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setShipFromAddress($value)
	{
		$this->ShipFromAddress = $value;
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

 * @return ShippingCarrierCodeType
 */
	function getShippingCarrierUsed()
	{
		return $this->ShippingCarrierUsed;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setShippingCarrierUsed($value)
	{
		$this->ShippingCarrierUsed = $value;
	}
/**
 *

 * @return ShippingFeatureCodeType
 * @param  $index 
 */
	function getShippingFeature($index = null)
	{
		if ($index) {
		return $this->ShippingFeature[$index];
	} else {
		return $this->ShippingFeature;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setShippingFeature($value, $index = null)
	{
		if ($index) {
	$this->ShippingFeature[$index] = $value;
	} else {
	$this->ShippingFeature = $value;
	}

	}
/**
 *

 * @return ShippingPackageCodeType
 */
	function getShippingPackage()
	{
		return $this->ShippingPackage;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setShippingPackage($value)
	{
		$this->ShippingPackage = $value;
	}
/**
 *

 * @return token
 */
	function getShippingServiceUsed()
	{
		return $this->ShippingServiceUsed;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setShippingServiceUsed($value)
	{
		$this->ShippingServiceUsed = $value;
	}
/**
 *

 * @return string
 */
	function getShipmentTrackingNumber()
	{
		return $this->ShipmentTrackingNumber;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setShipmentTrackingNumber($value)
	{
		$this->ShipmentTrackingNumber = $value;
	}
/**
 *

 * @return MeasureType
 */
	function getWeightMajor()
	{
		return $this->WeightMajor;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setWeightMajor($value)
	{
		$this->WeightMajor = $value;
	}
/**
 *

 * @return MeasureType
 */
	function getWeightMinor()
	{
		return $this->WeightMinor;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setWeightMinor($value)
	{
		$this->WeightMinor = $value;
	}
/**
 *

 * @return ItemTransactionIDType
 * @param  $index 
 */
	function getItemTransactionID($index = null)
	{
		if ($index) {
		return $this->ItemTransactionID[$index];
	} else {
		return $this->ItemTransactionID;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setItemTransactionID($value, $index = null)
	{
		if ($index) {
	$this->ItemTransactionID[$index] = $value;
	} else {
	$this->ItemTransactionID = $value;
	}

	}
/**
 *

 * @return dateTime
 */
	function getDeliveryDate()
	{
		return $this->DeliveryDate;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setDeliveryDate($value)
	{
		$this->DeliveryDate = $value;
	}
/**
 *

 * @return ShipmentDeliveryStatusCodeType
 */
	function getDeliveryStatus()
	{
		return $this->DeliveryStatus;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setDeliveryStatus($value)
	{
		$this->DeliveryStatus = $value;
	}
/**
 *

 * @return dateTime
 */
	function getRefundGrantedTime()
	{
		return $this->RefundGrantedTime;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setRefundGrantedTime($value)
	{
		$this->RefundGrantedTime = $value;
	}
/**
 *

 * @return dateTime
 */
	function getRefundRequestedTime()
	{
		return $this->RefundRequestedTime;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setRefundRequestedTime($value)
	{
		$this->RefundRequestedTime = $value;
	}
/**
 *

 * @return ShipmentStatusCodeType
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
	function ShipmentType()
	{
		$this->EbatNs_ComplexType('ShipmentType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'EstimatedDeliveryDate' =>
				array(
					'required' => false,
					'type' => 'dateTime',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'InsuredValue' =>
				array(
					'required' => false,
					'type' => 'AmountType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'PackageDepth' =>
				array(
					'required' => false,
					'type' => 'MeasureType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'PackageLength' =>
				array(
					'required' => false,
					'type' => 'MeasureType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'PackageWidth' =>
				array(
					'required' => false,
					'type' => 'MeasureType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'PayPalShipmentID' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ShipmentID' =>
				array(
					'required' => false,
					'type' => 'long',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'PostageTotal' =>
				array(
					'required' => false,
					'type' => 'AmountType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'PrintedTime' =>
				array(
					'required' => false,
					'type' => 'dateTime',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ShipFromAddress' =>
				array(
					'required' => false,
					'type' => 'AddressType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
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
				'ShippingCarrierUsed' =>
				array(
					'required' => false,
					'type' => 'ShippingCarrierCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ShippingFeature' =>
				array(
					'required' => false,
					'type' => 'ShippingFeatureCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				),
				'ShippingPackage' =>
				array(
					'required' => false,
					'type' => 'ShippingPackageCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ShippingServiceUsed' =>
				array(
					'required' => false,
					'type' => 'token',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ShipmentTrackingNumber' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'WeightMajor' =>
				array(
					'required' => false,
					'type' => 'MeasureType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'WeightMinor' =>
				array(
					'required' => false,
					'type' => 'MeasureType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ItemTransactionID' =>
				array(
					'required' => false,
					'type' => 'ItemTransactionIDType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				),
				'DeliveryDate' =>
				array(
					'required' => false,
					'type' => 'dateTime',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'DeliveryStatus' =>
				array(
					'required' => false,
					'type' => 'ShipmentDeliveryStatusCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'RefundGrantedTime' =>
				array(
					'required' => false,
					'type' => 'dateTime',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'RefundRequestedTime' =>
				array(
					'required' => false,
					'type' => 'dateTime',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Status' =>
				array(
					'required' => false,
					'type' => 'ShipmentStatusCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>