<?php
// autogenerated file 17.11.2006 13:29
// $Id: AttributeArrayType.php,v 1.1.1.1 2006/12/22 14:37:17 gswkaiser Exp $
// $Log: AttributeArrayType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:17  gswkaiser
// no message
//
//
require_once 'AttributeType.php';
require_once 'EbatNs_ComplexType.php';

class AttributeArrayType extends EbatNs_ComplexType
{
	// start props
	// @var AttributeType $Attribute
	var $Attribute;
	// end props

/**
 *

 * @return AttributeType
 * @param  $index 
 */
	function getAttribute($index = null)
	{
		if ($index) {
		return $this->Attribute[$index];
	} else {
		return $this->Attribute;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setAttribute($value, $index = null)
	{
		if ($index) {
	$this->Attribute[$index] = $value;
	} else {
	$this->Attribute = $value;
	}

	}
/**
 *

 * @return 
 */
	function AttributeArrayType()
	{
		$this->EbatNs_ComplexType('AttributeArrayType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'Attribute' =>
				array(
					'required' => false,
					'type' => 'AttributeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				)
			));

	}
}
?>
