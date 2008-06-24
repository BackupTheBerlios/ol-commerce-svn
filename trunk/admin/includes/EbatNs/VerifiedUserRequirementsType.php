<?php
// autogenerated file 17.11.2006 13:30
// $Id: VerifiedUserRequirementsType.php,v 1.1.1.1 2006/12/22 14:38:56 gswkaiser Exp $
// $Log: VerifiedUserRequirementsType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:56  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';

class VerifiedUserRequirementsType extends EbatNs_ComplexType
{
	// start props
	// @var boolean $VerifiedUser
	var $VerifiedUser;
	// @var int $MinimumFeedbackScore
	var $MinimumFeedbackScore;
	// end props

/**
 *

 * @return boolean
 */
	function getVerifiedUser()
	{
		return $this->VerifiedUser;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setVerifiedUser($value)
	{
		$this->VerifiedUser = $value;
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
	function VerifiedUserRequirementsType()
	{
		$this->EbatNs_ComplexType('VerifiedUserRequirementsType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'VerifiedUser' =>
				array(
					'required' => false,
					'type' => 'boolean',
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