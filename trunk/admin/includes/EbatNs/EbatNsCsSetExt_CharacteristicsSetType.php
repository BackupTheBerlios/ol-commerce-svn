<?php
// autogenerated file 03.02.2006 11:21
// $Id: EbatNsCsSetExt_CharacteristicsSetType.php,v 1.1.1.1 2006/12/22 14:37:31 gswkaiser Exp $
// $Log: EbatNsCsSetExt_CharacteristicsSetType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:31  gswkaiser
// no message
//
// Revision 1.1  2006/02/03 10:52:01  michael
// initial checkin
//
//
require_once 'EbatNsCsSetExt_CharacteristicsListType.php';
require_once 'EbatNs_ComplexType.php';
require_once 'EbatNsCsSetExt_CharacteristicType.php';
require_once 'EbatNsCsSetExt_PresentationInstructionType.php';

class EbatNsCsSetExt_CharacteristicsSetType extends EbatNs_ComplexType
{
	// start props
	// @var string $Name
	var $Name;
	// @var int $AttributeSetID
	var $AttributeSetID;
	// @var string $AttributeSetVersion
	var $AttributeSetVersion;
	// @var EbatNsCsSetExt_CharacteristicType $Characteristics
	var $Characteristics;
	// @var string $DomainName
	var $DomainName;
	// @var EbatNsCsSetExt_CharacteristicsListType $CharacteristicsList
	var $CharacteristicsList;
	// @var EbatNsCsSetExt_PresentationInstructionType $PresentationInstruction
	var $PresentationInstruction;
	// end props

/**
 *

 * @return string
 */
	function getName()
	{
		return $this->Name;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setName($value)
	{
		$this->Name = $value;
	}
/**
 *

 * @return int
 */
	function getAttributeSetID()
	{
		return $this->AttributeSetID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setAttributeSetID($value)
	{
		$this->AttributeSetID = $value;
	}
/**
 *

 * @return string
 */
	function getAttributeSetVersion()
	{
		return $this->AttributeSetVersion;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setAttributeSetVersion($value)
	{
		$this->AttributeSetVersion = $value;
	}
/**
 *

 * @return EbatNsCsSetExt_CharacteristicType
 * @param  $index 
 */
	function getCharacteristics($index = null)
	{
		if ($index) {
		return $this->Characteristics[$index];
	} else {
		return $this->Characteristics;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setCharacteristics($value, $index = null)
	{
		if ($index) {
	$this->Characteristics[$index] = $value;
	} else {
	$this->Characteristics = $value;
	}

	}
/**
 *

 * @return string
 */
	function getDomainName()
	{
		return $this->DomainName;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setDomainName($value)
	{
		$this->DomainName = $value;
	}
/**
 *

 * @return EbatNsCsSetExt_CharacteristicsListType
 */
	function getCharacteristicsList()
	{
		return $this->CharacteristicsList;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCharacteristicsList($value)
	{
		$this->CharacteristicsList = $value;
	}
/**
 *

 * @return EbatNsCsSetExt_PresentationInstructionType
 */
	function getPresentationInstruction()
	{
		return $this->PresentationInstruction;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setPresentationInstruction($value)
	{
		$this->PresentationInstruction = $value;
	}
/**
 *

 * @return 
 */
	function EbatNsCsSetExt_CharacteristicsSetType()
	{
		$this->EbatNs_ComplexType('EbatNsCsSetExt_CharacteristicsSetType', 'http://www.w3.org/2001/XMLSchema');
		$this->_elements = array_merge($this->_elements,
			array(
				'Name' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'AttributeSetID' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'AttributeSetVersion' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Characteristics' =>
				array(
					'required' => false,
					'type' => 'EbatNsCsSetExt_CharacteristicType',
					'nsURI' => 'http://www.intradesys.com/Schemas/ebay/AttributeData_Extension.xsd',
					'array' => true,
					'cardinality' => '0..*'
				),
				'DomainName' =>
				array(
					'required' => true,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '1..1'
				),
				'CharacteristicsList' =>
				array(
					'required' => true,
					'type' => 'EbatNsCsSetExt_CharacteristicsListType',
					'nsURI' => 'http://www.intradesys.com/Schemas/ebay/AttributeData_Extension.xsd',
					'array' => false,
					'cardinality' => '1..1'
				),
				'PresentationInstruction' =>
				array(
					'required' => false,
					'type' => 'EbatNsCsSetExt_PresentationInstructionType',
					'nsURI' => 'http://www.intradesys.com/Schemas/ebay/AttributeData_Extension.xsd',
					'array' => false,
					'cardinality' => '0..1'
				)
			));
	$this->_attributes = array_merge($this->_attributes,
		array(
			'id' =>
			array(
				'name' => 'id',
				'type' => 'int',
				'use' => 'required'
			),
			'order' =>
			array(
				'name' => 'order',
				'type' => 'int',
				'use' => 'required'
			),
			'type' =>
			array(
				'name' => 'type',
				'type' => 'string',
				'use' => 'required'
			)
		));

	}
}
?>
