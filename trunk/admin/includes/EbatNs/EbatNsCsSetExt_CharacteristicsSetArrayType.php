<?php
// autogenerated file 03.02.2006 11:21
// $Id: EbatNsCsSetExt_CharacteristicsSetArrayType.php,v 1.1.1.1 2006/12/22 14:37:31 gswkaiser Exp $
// $Log: EbatNsCsSetExt_CharacteristicsSetArrayType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:31  gswkaiser
// no message
//
// Revision 1.1  2006/02/03 10:52:01  michael
// initial checkin
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'EbatNsCsSetExt_CharacteristicsSetType.php';

class EbatNsCsSetExt_CharacteristicsSetArrayType extends EbatNs_ComplexType
{
	// start props
	// @var EbatNsCsSetExt_CharacteristicsSetType $CharacteristicsSet
	var $CharacteristicsSet;
	// end props

/**
 *

 * @return EbatNsCsSetExt_CharacteristicsSetType
 * @param  $index 
 */
	function getCharacteristicsSet($index = null)
	{
		if ($index) {
		return $this->CharacteristicsSet[$index];
	} else {
		return $this->CharacteristicsSet;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setCharacteristicsSet($value, $index = null)
	{
		if ($index) {
	$this->CharacteristicsSet[$index] = $value;
	} else {
	$this->CharacteristicsSet = $value;
	}

	}
/**
 *

 * @return 
 */
	function EbatNsCsSetExt_CharacteristicsSetArrayType()
	{
		$this->EbatNs_ComplexType('EbatNsCsSetExt_CharacteristicsSetArrayType', 'http://www.intradesys.com/Schemas/ebay/AttributeData_Extension.xsd');
		$this->_elements = array_merge($this->_elements,
			array(
				'CharacteristicsSet' =>
				array(
					'required' => false,
					'type' => 'EbatNsCsSetExt_CharacteristicsSetType',
					'nsURI' => 'http://www.intradesys.com/Schemas/ebay/AttributeData_Extension.xsd',
					'array' => true,
					'cardinality' => '0..*'
				)
			));

	}
}
?>
