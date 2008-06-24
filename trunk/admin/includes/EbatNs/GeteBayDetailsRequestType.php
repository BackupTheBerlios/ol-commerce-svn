<?php
// autogenerated file 17.11.2006 13:29
// $Id: GeteBayDetailsRequestType.php,v 1.1.1.1 2006/12/22 14:37:56 gswkaiser Exp $
// $Log: GeteBayDetailsRequestType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:56  gswkaiser
// no message
//
//
require_once 'DetailNameCodeType.php';
require_once 'AbstractRequestType.php';

class GeteBayDetailsRequestType extends AbstractRequestType
{
	// start props
	// @var DetailNameCodeType $DetailName
	var $DetailName;
	// end props

/**
 *

 * @return DetailNameCodeType
 * @param  $index 
 */
	function getDetailName($index = null)
	{
		if ($index) {
		return $this->DetailName[$index];
	} else {
		return $this->DetailName;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setDetailName($value, $index = null)
	{
		if ($index) {
	$this->DetailName[$index] = $value;
	} else {
	$this->DetailName = $value;
	}

	}
/**
 *

 * @return 
 */
	function GeteBayDetailsRequestType()
	{
		$this->AbstractRequestType('GeteBayDetailsRequestType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'DetailName' =>
				array(
					'required' => false,
					'type' => 'DetailNameCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				)
			));

	}
}
?>