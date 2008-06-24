<?php
// autogenerated file 03.02.2006 11:21
// $Id: EbatNsCsSetExt_AttributeSetType.php,v 1.1.1.1 2006/12/22 14:37:30 gswkaiser Exp $
// $Log: EbatNsCsSetExt_AttributeSetType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:30  gswkaiser
// no message
//
// Revision 1.1  2006/02/03 10:52:01  michael
// initial checkin
//
//
require_once 'EbatNsCsSetExt_AttributeType.php';
require_once 'EbatNs_ComplexType.php';

class EbatNsCsSetExt_AttributeSetType extends EbatNs_ComplexType
{
	// start props
	// @var EbatNsCsSetExt_AttributeType $Attribute
	var $Attribute;
	// @var string $DomainName
	var $DomainName;
	// end props

/**
 *

 * @return EbatNsCsSetExt_AttributeType
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

 * @return 
 */
	function EbatNsCsSetExt_AttributeSetType()
	{
		$this->EbatNs_ComplexType('EbatNsCsSetExt_AttributeSetType', 'http://www.w3.org/2001/XMLSchema');
		$this->_elements = array_merge($this->_elements,
			array(
				'Attribute' =>
				array(
					'required' => false,
					'type' => 'EbatNsCsSetExt_AttributeType',
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
				)
			));
	$this->_attributes = array_merge($this->_attributes,
		array(
			'attributeSetID' =>
			array(
				'name' => 'attributeSetID',
				'type' => 'int',
				'use' => 'required'
			),
			'attributeSetVersion' =>
			array(
				'name' => 'attributeSetVersion',
				'type' => 'string',
				'use' => 'required'
			),
			'id' =>
			array(
				'name' => 'id',
				'type' => 'int',
				'use' => 'required'
			)
		));

	}
}
?>