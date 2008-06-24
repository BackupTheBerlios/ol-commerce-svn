<?php
// autogenerated file 17.11.2006 13:29
// $Id: ValidateChallengeInputRequestType.php,v 1.1.1.1 2006/12/22 14:38:56 gswkaiser Exp $
// $Log: ValidateChallengeInputRequestType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:56  gswkaiser
// no message
//
//
require_once 'AbstractRequestType.php';

class ValidateChallengeInputRequestType extends AbstractRequestType
{
	// start props
	// @var string $ChallengeToken
	var $ChallengeToken;
	// @var string $UserInput
	var $UserInput;
	// @var boolean $KeepTokenValid
	var $KeepTokenValid;
	// end props

/**
 *

 * @return string
 */
	function getChallengeToken()
	{
		return $this->ChallengeToken;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setChallengeToken($value)
	{
		$this->ChallengeToken = $value;
	}
/**
 *

 * @return string
 */
	function getUserInput()
	{
		return $this->UserInput;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setUserInput($value)
	{
		$this->UserInput = $value;
	}
/**
 *

 * @return boolean
 */
	function getKeepTokenValid()
	{
		return $this->KeepTokenValid;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setKeepTokenValid($value)
	{
		$this->KeepTokenValid = $value;
	}
/**
 *

 * @return 
 */
	function ValidateChallengeInputRequestType()
	{
		$this->AbstractRequestType('ValidateChallengeInputRequestType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'ChallengeToken' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'UserInput' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'KeepTokenValid' =>
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