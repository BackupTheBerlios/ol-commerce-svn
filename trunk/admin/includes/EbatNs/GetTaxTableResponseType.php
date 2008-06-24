<?php
// autogenerated file 17.11.2006 13:29
// $Id: GetTaxTableResponseType.php,v 1.1.1.1 2006/12/22 14:38:09 gswkaiser Exp $
// $Log: GetTaxTableResponseType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:09  gswkaiser
// no message
//
//
require_once 'AbstractResponseType.php';
require_once 'TaxTableType.php';

class GetTaxTableResponseType extends AbstractResponseType
{
	// start props
	// @var dateTime $LastUpdateTime
	var $LastUpdateTime;
	// @var TaxTableType $TaxTable
	var $TaxTable;
	// end props

/**
 *

 * @return dateTime
 */
	function getLastUpdateTime()
	{
		return $this->LastUpdateTime;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setLastUpdateTime($value)
	{
		$this->LastUpdateTime = $value;
	}
/**
 *

 * @return TaxTableType
 */
	function getTaxTable()
	{
		return $this->TaxTable;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setTaxTable($value)
	{
		$this->TaxTable = $value;
	}
/**
 *

 * @return 
 */
	function GetTaxTableResponseType()
	{
		$this->AbstractResponseType('GetTaxTableResponseType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'LastUpdateTime' =>
				array(
					'required' => false,
					'type' => 'dateTime',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'TaxTable' =>
				array(
					'required' => false,
					'type' => 'TaxTableType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
