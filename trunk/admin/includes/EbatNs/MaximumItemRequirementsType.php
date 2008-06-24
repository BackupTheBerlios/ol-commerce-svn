<?php
// autogenerated file 17.11.2006 13:29
// $Id: MaximumItemRequirementsType.php,v 1.1.1.1 2006/12/22 14:38:19 gswkaiser Exp $
// $Log: MaximumItemRequirementsType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:19  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';

class MaximumItemRequirementsType extends EbatNs_ComplexType
{
	// start props
	// @var int $MaximumItemCount
	var $MaximumItemCount;
	// @var int $MinimumFeedbackScore
	var $MinimumFeedbackScore;
	// end props

/**
 *

 * @return int
 */
	function getMaximumItemCount()
	{
		return $this->MaximumItemCount;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setMaximumItemCount($value)
	{
		$this->MaximumItemCount = $value;
	}
/**
 *

 * @return int
 */
	function getMinimumFeedbackScore()
	{
		return $this->MinimumFeedbackScore;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setMinimumFeedbackScore($value)
	{
		$this->MinimumFeedbackScore = $value;
	}
/**
 *

 * @return 
 */
	function MaximumItemRequirementsType()
	{
		$this->EbatNs_ComplexType('MaximumItemRequirementsType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'MaximumItemCount' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'MinimumFeedbackScore' =>
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
