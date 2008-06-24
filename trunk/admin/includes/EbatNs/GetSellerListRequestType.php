<?php
// autogenerated file 17.11.2006 13:29
// $Id: GetSellerListRequestType.php,v 1.1.1.1 2006/12/22 14:38:07 gswkaiser Exp $
// $Log: GetSellerListRequestType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:07  gswkaiser
// no message
//
//
require_once 'UserIDType.php';
require_once 'PaginationType.php';
require_once 'GranularityLevelCodeType.php';
require_once 'SKUArrayType.php';
require_once 'AbstractRequestType.php';
require_once 'UserIDArrayType.php';

class GetSellerListRequestType extends AbstractRequestType
{
	// start props
	// @var UserIDType $UserID
	var $UserID;
	// @var UserIDArrayType $MotorsDealerUsers
	var $MotorsDealerUsers;
	// @var dateTime $EndTimeFrom
	var $EndTimeFrom;
	// @var dateTime $EndTimeTo
	var $EndTimeTo;
	// @var int $Sort
	var $Sort;
	// @var dateTime $StartTimeFrom
	var $StartTimeFrom;
	// @var dateTime $StartTimeTo
	var $StartTimeTo;
	// @var PaginationType $Pagination
	var $Pagination;
	// @var GranularityLevelCodeType $GranularityLevel
	var $GranularityLevel;
	// @var SKUArrayType $SKUArray
	var $SKUArray;
	// @var boolean $IncludeWatchCount
	var $IncludeWatchCount;
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

 * @return UserIDArrayType
 */
	function getMotorsDealerUsers()
	{
		return $this->MotorsDealerUsers;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setMotorsDealerUsers($value)
	{
		$this->MotorsDealerUsers = $value;
	}
/**
 *

 * @return dateTime
 */
	function getEndTimeFrom()
	{
		return $this->EndTimeFrom;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setEndTimeFrom($value)
	{
		$this->EndTimeFrom = $value;
	}
/**
 *

 * @return dateTime
 */
	function getEndTimeTo()
	{
		return $this->EndTimeTo;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setEndTimeTo($value)
	{
		$this->EndTimeTo = $value;
	}
/**
 *

 * @return int
 */
	function getSort()
	{
		return $this->Sort;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setSort($value)
	{
		$this->Sort = $value;
	}
/**
 *

 * @return dateTime
 */
	function getStartTimeFrom()
	{
		return $this->StartTimeFrom;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setStartTimeFrom($value)
	{
		$this->StartTimeFrom = $value;
	}
/**
 *

 * @return dateTime
 */
	function getStartTimeTo()
	{
		return $this->StartTimeTo;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setStartTimeTo($value)
	{
		$this->StartTimeTo = $value;
	}
/**
 *

 * @return PaginationType
 */
	function getPagination()
	{
		return $this->Pagination;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setPagination($value)
	{
		$this->Pagination = $value;
	}
/**
 *

 * @return GranularityLevelCodeType
 */
	function getGranularityLevel()
	{
		return $this->GranularityLevel;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setGranularityLevel($value)
	{
		$this->GranularityLevel = $value;
	}
/**
 *

 * @return SKUArrayType
 */
	function getSKUArray()
	{
		return $this->SKUArray;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setSKUArray($value)
	{
		$this->SKUArray = $value;
	}
/**
 *

 * @return boolean
 */
	function getIncludeWatchCount()
	{
		return $this->IncludeWatchCount;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setIncludeWatchCount($value)
	{
		$this->IncludeWatchCount = $value;
	}
/**
 *

 * @return 
 */
	function GetSellerListRequestType()
	{
		$this->AbstractRequestType('GetSellerListRequestType', 'urn:ebay:apis:eBLBaseComponents');
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
				'MotorsDealerUsers' =>
				array(
					'required' => false,
					'type' => 'UserIDArrayType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'EndTimeFrom' =>
				array(
					'required' => false,
					'type' => 'dateTime',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'EndTimeTo' =>
				array(
					'required' => false,
					'type' => 'dateTime',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Sort' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'StartTimeFrom' =>
				array(
					'required' => false,
					'type' => 'dateTime',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'StartTimeTo' =>
				array(
					'required' => false,
					'type' => 'dateTime',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Pagination' =>
				array(
					'required' => false,
					'type' => 'PaginationType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'GranularityLevel' =>
				array(
					'required' => false,
					'type' => 'GranularityLevelCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'SKUArray' =>
				array(
					'required' => false,
					'type' => 'SKUArrayType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'IncludeWatchCount' =>
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
