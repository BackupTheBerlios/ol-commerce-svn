<?php
// autogenerated file 17.11.2006 13:29
// $Id: StoreCustomCategoryArrayType.php,v 1.1.1.1 2006/12/22 14:38:48 gswkaiser Exp $
// $Log: StoreCustomCategoryArrayType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:48  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'StoreCustomCategoryType.php';

class StoreCustomCategoryArrayType extends EbatNs_ComplexType
{
	// start props
	// @var StoreCustomCategoryType $CustomCategory
	var $CustomCategory;
	// end props

/**
 *

 * @return StoreCustomCategoryType
 * @param  $index 
 */
	function getCustomCategory($index = null)
	{
		if ($index) {
		return $this->CustomCategory[$index];
	} else {
		return $this->CustomCategory;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setCustomCategory($value, $index = null)
	{
		if ($index) {
	$this->CustomCategory[$index] = $value;
	} else {
	$this->CustomCategory = $value;
	}

	}
/**
 *

 * @return 
 */
	function StoreCustomCategoryArrayType()
	{
		$this->EbatNs_ComplexType('StoreCustomCategoryArrayType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'CustomCategory' =>
				array(
					'required' => false,
					'type' => 'StoreCustomCategoryType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				)
			));

	}
}
?>