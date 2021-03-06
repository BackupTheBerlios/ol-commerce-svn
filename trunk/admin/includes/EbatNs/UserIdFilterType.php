<?php
// autogenerated file 17.11.2006 13:30
// $Id: UserIdFilterType.php,v 1.1.1.1 2006/12/22 14:38:54 gswkaiser Exp $
// $Log: UserIdFilterType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:54  gswkaiser
// no message
//
//
require_once 'UserIDType.php';
require_once 'EbatNs_ComplexType.php';

class UserIdFilterType extends EbatNs_ComplexType
{
	// start props
	// @var UserIDType $ExcludeSellers
	var $ExcludeSellers;
	// @var UserIDType $IncludeSellers
	var $IncludeSellers;
	// end props

/**
 *

 * @return UserIDType
 * @param  $index 
 */
	function getExcludeSellers($index = null)
	{
		if ($index) {
		return $this->ExcludeSellers[$index];
	} else {
		return $this->ExcludeSellers;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setExcludeSellers($value, $index = null)
	{
		if ($index) {
	$this->ExcludeSellers[$index] = $value;
	} else {
	$this->ExcludeSellers = $value;
	}

	}
/**
 *

 * @return UserIDType
 * @param  $index 
 */
	function getIncludeSellers($index = null)
	{
		if ($index) {
		return $this->IncludeSellers[$index];
	} else {
		return $this->IncludeSellers;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setIncludeSellers($value, $index = null)
	{
		if ($index) {
	$this->IncludeSellers[$index] = $value;
	} else {
	$this->IncludeSellers = $value;
	}

	}
/**
 *

 * @return 
 */
	function UserIdFilterType()
	{
		$this->EbatNs_ComplexType('UserIdFilterType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'ExcludeSellers' =>
				array(
					'required' => false,
					'type' => 'UserIDType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..100'
				),
				'IncludeSellers' =>
				array(
					'required' => false,
					'type' => 'UserIDType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..100'
				)
			));

	}
}
?>
