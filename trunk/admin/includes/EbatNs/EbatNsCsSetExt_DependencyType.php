<?php
// autogenerated file 03.02.2006 11:21
// $Id: EbatNsCsSetExt_DependencyType.php,v 1.1.1.1 2006/12/22 14:37:32 gswkaiser Exp $
// $Log: EbatNsCsSetExt_DependencyType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:32  gswkaiser
// no message
//
// Revision 1.1  2006/02/03 10:52:01  michael
// initial checkin
//
//
require_once 'EbatNsCsSetExt_ValType.php';
require_once 'EbatNs_ComplexType.php';

class EbatNsCsSetExt_DependencyType extends EbatNs_ComplexType
{
	// start props
	// @var EbatNsCsSetExt_ValType $Value
	var $Value;
	// end props

/**
 *

 * @return EbatNsCsSetExt_ValType
 * @param  $index 
 */
	function getValue($index = null)
	{
		if ($index) {
		return $this->Value[$index];
	} else {
		return $this->Value;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setValue($value, $index = null)
	{
		if ($index) {
	$this->Value[$index] = $value;
	} else {
	$this->Value = $value;
	}

	}
/**
 *

 * @return 
 */
	function EbatNsCsSetExt_DependencyType()
	{
		$this->EbatNs_ComplexType('EbatNsCsSetExt_DependencyType', 'http://www.w3.org/2001/XMLSchema');
		$this->_elements = array_merge($this->_elements,
			array(
				'Value' =>
				array(
					'required' => true,
					'type' => 'EbatNsCsSetExt_ValType',
					'nsURI' => 'http://www.intradesys.com/Schemas/ebay/AttributeData_Extension.xsd',
					'array' => true,
					'cardinality' => '1..*'
				)
			));
	$this->_attributes = array_merge($this->_attributes,
		array(
			'count' =>
			array(
				'name' => 'count',
				'type' => 'int',
				'use' => 'required'
			),
			'parentValueId' =>
			array(
				'name' => 'parentValueId',
				'type' => 'int',
				'use' => 'required'
			),
			'childAttrId' =>
			array(
				'name' => 'childAttrId',
				'type' => 'int',
				'use' => 'required'
			),
			'type' =>
			array(
				'name' => 'type',
				'type' => 'int',
				'use' => 'required'
			)
		));

	}
}
?>
