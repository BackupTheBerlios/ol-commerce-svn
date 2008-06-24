<?php
// autogenerated file 17.11.2006 13:29
// $Id: GetDescriptionTemplatesRequestType.php,v 1.1.1.1 2006/12/22 14:37:55 gswkaiser Exp $
// $Log: GetDescriptionTemplatesRequestType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:55  gswkaiser
// no message
//
//
require_once 'AbstractRequestType.php';

class GetDescriptionTemplatesRequestType extends AbstractRequestType
{
	// start props
	// @var string $CategoryID
	var $CategoryID;
	// @var dateTime $LastModifiedTime
	var $LastModifiedTime;
	// @var boolean $MotorVehicles
	var $MotorVehicles;
	// end props

/**
 *

 * @return string
 */
	function getCategoryID()
	{
		return $this->CategoryID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCategoryID($value)
	{
		$this->CategoryID = $value;
	}
/**
 *

 * @return dateTime
 */
	function getLastModifiedTime()
	{
		return $this->LastModifiedTime;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setLastModifiedTime($value)
	{
		$this->LastModifiedTime = $value;
	}
/**
 *

 * @return boolean
 */
	function getMotorVehicles()
	{
		return $this->MotorVehicles;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setMotorVehicles($value)
	{
		$this->MotorVehicles = $value;
	}
/**
 *

 * @return 
 */
	function GetDescriptionTemplatesRequestType()
	{
		$this->AbstractRequestType('GetDescriptionTemplatesRequestType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'CategoryID' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'LastModifiedTime' =>
				array(
					'required' => false,
					'type' => 'dateTime',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'MotorVehicles' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>