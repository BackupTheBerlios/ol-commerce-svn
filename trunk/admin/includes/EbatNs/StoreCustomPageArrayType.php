<?php
// autogenerated file 17.11.2006 13:29
// $Id: StoreCustomPageArrayType.php,v 1.1.1.1 2006/12/22 14:38:49 gswkaiser Exp $
// $Log: StoreCustomPageArrayType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:49  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'StoreCustomPageType.php';

class StoreCustomPageArrayType extends EbatNs_ComplexType
{
	// start props
	// @var StoreCustomPageType $CustomPage
	var $CustomPage;
	// end props

/**
 *

 * @return StoreCustomPageType
 * @param  $index 
 */
	function getCustomPage($index = null)
	{
		if ($index) {
		return $this->CustomPage[$index];
	} else {
		return $this->CustomPage;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setCustomPage($value, $index = null)
	{
		if ($index) {
	$this->CustomPage[$index] = $value;
	} else {
	$this->CustomPage = $value;
	}

	}
/**
 *

 * @return 
 */
	function StoreCustomPageArrayType()
	{
		$this->EbatNs_ComplexType('StoreCustomPageArrayType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'CustomPage' =>
				array(
					'required' => false,
					'type' => 'StoreCustomPageType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				)
			));

	}
}
?>
