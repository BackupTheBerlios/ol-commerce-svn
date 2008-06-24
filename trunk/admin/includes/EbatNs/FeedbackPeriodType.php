<?php
// autogenerated file 17.11.2006 13:29
// $Id: FeedbackPeriodType.php,v 1.1.1.1 2006/12/22 14:37:49 gswkaiser Exp $
// $Log: FeedbackPeriodType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:49  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';

class FeedbackPeriodType extends EbatNs_ComplexType
{
	// start props
	// @var int $PeriodInDays
	var $PeriodInDays;
	// @var int $Count
	var $Count;
	// end props

/**
 *

 * @return int
 */
	function getPeriodInDays()
	{
		return $this->PeriodInDays;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setPeriodInDays($value)
	{
		$this->PeriodInDays = $value;
	}
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

 * @return 
 */
	function FeedbackPeriodType()
	{
		$this->EbatNs_ComplexType('FeedbackPeriodType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'PeriodInDays' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Count' =>
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
