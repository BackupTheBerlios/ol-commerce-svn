<?php
// autogenerated file 17.11.2006 13:29
// $Id: GetCharitiesRequestType.php,v 1.1.1.1 2006/12/22 14:37:55 gswkaiser Exp $
// $Log: GetCharitiesRequestType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:55  gswkaiser
// no message
//
//
require_once 'StringMatchCodeType.php';
require_once 'AbstractRequestType.php';

class GetCharitiesRequestType extends AbstractRequestType
{
	// start props
	// @var string $CharityID
	var $CharityID;
	// @var string $CharityName
	var $CharityName;
	// @var string $Query
	var $Query;
	// @var int $CharityRegion
	var $CharityRegion;
	// @var int $CharityDomain
	var $CharityDomain;
	// @var boolean $IncludeDescription
	var $IncludeDescription;
	// @var StringMatchCodeType $MatchType
	var $MatchType;
	// end props

/**
 *

 * @return string
 */
	function getCharityID()
	{
		return $this->CharityID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCharityID($value)
	{
		$this->CharityID = $value;
	}
/**
 *

 * @return string
 */
	function getCharityName()
	{
		return $this->CharityName;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCharityName($value)
	{
		$this->CharityName = $value;
	}
/**
 *

 * @return string
 */
	function getQuery()
	{
		return $this->Query;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setQuery($value)
	{
		$this->Query = $value;
	}
/**
 *

 * @return int
 */
	function getCharityRegion()
	{
		return $this->CharityRegion;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCharityRegion($value)
	{
		$this->CharityRegion = $value;
	}
/**
 *

 * @return int
 */
	function getCharityDomain()
	{
		return $this->CharityDomain;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCharityDomain($value)
	{
		$this->CharityDomain = $value;
	}
/**
 *

 * @return boolean
 */
	function getIncludeDescription()
	{
		return $this->IncludeDescription;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setIncludeDescription($value)
	{
		$this->IncludeDescription = $value;
	}
/**
 *

 * @return StringMatchCodeType
 */
	function getMatchType()
	{
		return $this->MatchType;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setMatchType($value)
	{
		$this->MatchType = $value;
	}
/**
 *

 * @return 
 */
	function GetCharitiesRequestType()
	{
		$this->AbstractRequestType('GetCharitiesRequestType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'CharityID' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'CharityName' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Query' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'CharityRegion' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'CharityDomain' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'IncludeDescription' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'MatchType' =>
				array(
					'required' => false,
					'type' => 'StringMatchCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
