<?php
// autogenerated file 17.11.2006 13:29
// $Id: CharacteristicSetIDsType.php,v 1.1.1.1.2.1 2007/04/08 07:16:38 gswkaiser Exp $
// $Log: CharacteristicSetIDsType.php,v $
// Revision 1.1.1.1.2.1  2007/04/08 07:16:38  gswkaiser
// olcommerce_2_0_0
//
// Update
//
// Revision 1.1.1.1  2006/12/22 14:37:23  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';

class CharacteristicSetIDsType extends EbatNs_ComplexType
{
	// start props
	// @var string $id
	var $id;
	// end props

/**
 *

 * @return string
 * @param  $index 
 */
	function getID($index = null)
	{
		if ($index) {
		return $this->id[$index];
	} else {
		return $this->id;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setID($value, $index = null)
	{
		if ($index) {
	$this->id[$index] = $value;
	} else {
	$this->id = $value;
	}

	}
/**
 *

 * @return 
 */
	function CharacteristicSetIDsType()
	{
		$this->EbatNs_ComplexType('CharacteristicSetIDsType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'id' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => true,
					'cardinality' => '0..*'
				)
			));

	}
}
?>
